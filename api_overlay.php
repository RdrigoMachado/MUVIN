<?php
/**
 * Caminho da imagem é definido em constante no Banco de Dados no inicio do arquivo
 * id passado via get
 * ex: localhost/muvin/api_overlay.php?id=49
 */
 require_once(realpath(__DIR__ . "/admin/Persistencia/BancoDeDados.php"));
$id = $_GET["id"];
$banco_de_dados = new BancoDeDados();
$componente = $banco_de_dados->visualizaOverlay($id);
echo json_encode($componente, JSON_UNESCAPED_SLASHES);



