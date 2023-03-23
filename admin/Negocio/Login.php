<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));


$metodo = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);
if($metodo != "POST")
{
    header("Location: " . URL_PAGINAS . "login.php");
    die();
}
if(!isset($_POST['nome']) || !isset($_POST['senha']))
{
    header("Location: " . URL_PAGINAS . "login.php?erro=dados-faltando");
    die();
}
$nome  = filter_var($_POST['nome'],  FILTER_SANITIZE_STRING);
$senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING);

//$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);
$bancoDeDados = new BancoDeDados();

if($bancoDeDados->login($nome, $senha))
{
    session_start();
    $_SESSION["nome"] = $nome;
    
    header("Location: " . URL_PAGINAS . "index.php");
    die();
}
else
{
    header("Location: " . URL_PAGINAS . "login.php?erro");
    die();
}