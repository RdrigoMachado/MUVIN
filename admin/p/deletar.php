<?php
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../Negocio/Entidade.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

if(!isset($_GET['id']) || !isset($_GET['tabela']))
{
    header("Location: " . URL . "listar_tabelas.php");
    die();
}

$tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
$id     = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$gerenciadorBD = new BancoDeDados();
$gerenciadorBD->deletar($tabela, $id);

header("Location: " . URL_PAGINAS . "listar.php?tabela=" . $tabela);
die();

