<?php
require_once("../Persistencia/BancoDeDados.php");
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/GerenciadorDeImagem.php");
require_once("Entidade.php");
require_once("Componente.php");
require_once("../paginas/config.php");

function adicionarImagemNaTabela($id_componente, $imagem_nome)
{
    $banco_de_dados = new BancoDeDados();
    $imagem = GerenciadorDeEstruturas::recuperarEstrutura("imagem");
    $imagem->setCampoEspecifico("componente_id", $id_componente);
    $imagem->setCampoEspecifico("nome", $imagem_nome);
    $imagem->setCampoEspecifico("principal", "");
    return $banco_de_dados->adicionar($imagem);
}


if(isset($_FILES['imagem']) && isset($_POST['id_componente']) && isset($_POST['id']) && isset($_POST['tabela'] ))
{
    $id             = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $tabela         =       filter_var($_POST['tabela'], FILTER_SANITIZE_STRING);
    $id_componente  = (int) filter_var($_POST['id_componente'], FILTER_SANITIZE_NUMBER_INT);
    $imagem         = $_FILES['imagem'];
    $mensagem = "";


    $id_adicionado = adicionarImagemNaTabela($id_componente, $imagem["name"]);
    if($id_adicionado == -1)
    {
        header("Location: " . URL . "visualizar_componente.php?tabela=" . $tabela . "&id=" . $id . "&erro=bd");
        die();
    }

    if(!GerenciadorDeImagem::adicionarImagem($id_componente, $imagem))
    {
        $banco_de_dados = new BancoDeDados();
        $banco_de_dados->deletar("imagem", $id_adicionado);
        header("Location: " . URL . "visualizar_componente.php?tabela=" . $tabela . "&id=" . $id . "&erro=persistencia");
        die();
    }

    header("Location: " . URL . "visualizar_componente.php?tabela=" . $tabela . "&id=" . $id);
    die();
}
else
{    
    header("Location: " . URL . "listar_tipos.php");
    die();
}