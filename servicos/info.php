<?php
require_once("listar.php");

if(!isset($_GET["id"])){
    return;
}
$id = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$informacoes = pegarInformacoes($id);
$imagens = pegarImagens($id );


foreach($informacoes as $informacao)
{
    echo "<p>" , $informacao ," </p>";
}

foreach($imagens as $imagem)
{
    echo '<img src="', $imagem , '" width="300px">';
}


?>