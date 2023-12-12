<?php
require_once(realpath(__DIR__ . "/Entidade.php"));
require_once(realpath(__DIR__ . "/Componente.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../config.php"));

function adicionar()
{
    $inputLimpo = Componente::limparInputUsuario($_POST);
    if($inputLimpo == [])
    {
        header("Location: " . URL . "listar_componente.php?tabela=" . $inputLimpo["tabela"] . "&erro=adicionar");
    }

    $entidade = new Entidade();
    $entidade->setNome($inputLimpo["tabela"]);
    $entidade->adicionarNovosCampos($inputLimpo["campos"]);
    

    $bancoDeDados = new BancoDeDados();
    $id_adicionado = $bancoDeDados->adicionar($entidade);
    if ($id_adicionado)
    {
        header("Location: " . URL . "visualizar.php?tabela=" . $inputLimpo["tabela"] . "&id=" . $id_adicionado);
    }
    else
    {
        header("Location: " . URL . "listar.php?tabela=" . $inputLimpo["tabela"] . "&erro=adicionar");
    }
    die();
}

adicionar();