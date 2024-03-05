<?php
require_once(realpath(__DIR__ . "/admin/Persistencia/BancoDeDados.php"));

$banco_de_dados = new BancoDeDados();
$lista_componentes = $banco_de_dados->listarComponentesLinhaTempo();
echo json_encode($lista_componentes, JSON_UNESCAPED_SLASHES);