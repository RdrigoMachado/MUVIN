<?php
require_once("../Persistencia/BancoDeDados.php");
require_once("Entidade.php");
require_once("Componente.php");
require_once("../paginas/config.php");


function editar()
{
    $inputLimpo = Componente::limparInputUsuario($_POST);
    $id = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    if($inputLimpo == [])
    {
        header("Location: " . URL . "listar.php?tabela=" . $inputLimpo["tabela"] . "&erro=editar");
    }

    $entidade = new Entidade();
    $entidade->setNome($inputLimpo["tabela"]);
    $entidade->adicionarNovosCampos($inputLimpo["campos"]);


    $gerenciadorBD = new BancoDeDados();
    if($gerenciadorBD->editar($entidade))
    {
        header("Location: " . URL . "visualizar.php?tabela=" . $inputLimpo["tabela"] . '&id=' . $id);
    }
    else
    {
        header("Location: " . URL . "visualizar.php?tabela=" . $inputLimpo["tabela"] . '&id=' . $id);
    }
    die();
}

editar();
