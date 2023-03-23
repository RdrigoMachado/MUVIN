<?php
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
unset($_SESSION["nome"]);
session_destroy();
header("Location: " . URL_PAGINAS . "index.php?logout");
die();