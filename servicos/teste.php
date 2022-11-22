<?php
require_once("listar.php");

$componentes = listarComponentes();
foreach($componentes as $componente){
    print_r($componente);
    echo '<br>';
}