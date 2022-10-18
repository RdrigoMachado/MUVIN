<?php
require_once("../Persistencia/BancoDeDados.php");
require_once("Entidade.php");
require_once("Componente.php");
require_once("../paginas/config.php");


function retornarId($tipos, $nome_procurado){
    foreach($tipos as $tipo){    
        $campo_nome = $tipo->getCampoEspecifico("nome");
        if($campo_nome->getValor() == $nome_procurado){
            $campo_id = $tipo->getCampoEspecifico("id");
            return $campo_id->getValor();
        }
    }
    return -1;
}

function adicionar()
{
    $tabela   = filter_var($_POST["tabela"], FILTER_SANITIZE_STRING);

    $inputEspecifico = Componente::limparInputEspecifico($_POST[$tabela], $tabela);
    $inputComponente = Componente::limparInputEspecifico($_POST['componente'], 'componente');
    if($inputEspecifico == [] || $inputComponente  == [] )
    {
        header("Location: " . URL . "listar_componentes.php?tabela=" . $inputLimpo["tabela"] . "&erro=adicionar");
    }

    $bancoDeDados = new BancoDeDados();
    $tipos = $bancoDeDados->listar("tipo");
    $id_tipo =  retornarId($tipos, $tabela);
    if($id_tipo == -1){
        header("Location: " . URL . "listar_componentes.php?tabela=" . $tabela . "&erro=tipo-nao-encontrado");
        die();
    }
    //adiciona componente e pega id
    
    $componente = new Entidade();
    $componente->setNome("componente");
    $componente->adicionarNovosCampos($inputComponente["campos"]);
    $componente->adicionarCampo("tipo_id", "chave_estrangeira", NULL, "tipo", $id_tipo);
    $componente->adicionarCampo("ultima_atualizacao", "date", NULL, NULL, date('Y-m-d'));
    $componente->adicionarCampo("criacao", "date", NULL, NULL, date('Y-m-d'));

    $id_adicionado = $bancoDeDados->adicionar($componente);
     
    if($id_adicionado == -1)
    {
        header("Location: " . URL . "listar_componentes.php?tabela=" . $tabela . "&erro=adicionar");
        die();
    }



    $entidade = new Entidade();
    $entidade->setNome($tabela);
    $entidade->adicionarNovosCampos($inputEspecifico["campos"]);
    $entidade->adicionarCampo("componente_id", "chave_estrangeira", NULL, "componente", $id_adicionado);

    $id_adicionado = $bancoDeDados->adicionar($entidade);
    
    if ($id_adicionado != -1)
    {
        header("Location: " . URL . "visualizar_componente.php?tabela=" .$tabela . "&id=" . $id_adicionado);
    }
    else
    {
        header("Location: " . URL . "listar_componentes.php?tabela=" . $tabela . "&erro=adicionar");
    }
    die();
}

adicionar();