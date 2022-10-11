<?php
require_once("../Persistencia/BancoDeDados.php");
require_once("Entidade.php");
require_once("Componente.php");
require_once("../paginas/config.php");


function excluir()
{
    if(!isset($_GET['id']) || !isset($_GET['tabela']))
    {
        header("Location: " . URL . "listar_tabelas.php");
        die();
    }
    
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id     = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $gerenciadorBD = new BancoDeDados();
    $gerenciadorBD->deletar($tabela, $id);
    
    header("Location: " . URL . "listar.php?tabela=" . $tabela);
    die();
}

excluir();
