<?php
require_once(realpath(__DIR__ . "/admin/Persistencia/BancoDeDados.php"));

$id = $_GET["id"];
$banco_de_dados = new BancoDeDados();
$componente = $banco_de_dados->visualizaOverlay($id);
echo json_encode($componente, JSON_UNESCAPED_SLASHES);



