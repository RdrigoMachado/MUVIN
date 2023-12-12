<?php
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeImagem.php"));
require_once(realpath(__DIR__ . "/Componente.php"));
require_once(realpath(__DIR__ . "/Entidade.php"));
require_once(realpath(__DIR__ . "/config.php"));



function adicionarImagemNaTabela($id_componente, $imagem_nome)
{
    $banco_de_dados = new BancoDeDados();
    $imagem = GerenciadorDeEstruturas::recuperarEstrutura("imagem");
    $imagem->setCampoEspecifico("componente_id", $id_componente);
    $imagem->setCampoEspecifico("nome", $imagem_nome);
    $imagem->setCampoEspecifico("principal", "");
    return $banco_de_dados->adicionar($imagem);
}

function adicionarImagem($imagem, $id_componente, $id, $tabela)
{
    $id_adicionado = adicionarImagemNaTabela($id_componente, $imagem["name"]);
    if($id_adicionado == -1)
    {
        header("Location: " . URL_PAGINAS . "visualizar_componente.php?tabela=" . $tabela . "&id=" . $id . "&erro=bd");
        die();
    }

    if(!GerenciadorDeImagem::adicionarImagem($id_componente, $imagem))
    {
        $banco_de_dados = new BancoDeDados();
        $banco_de_dados->deletar("imagem", $id_adicionado);
        header("Location: " . URL_PAGINAS . "visualizar_componente.php?tabela=" . $tabela . "&id=" . $id . "&erro=persistencia");
        die();
    }

}