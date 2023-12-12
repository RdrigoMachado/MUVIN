<?php
require_once(realpath(__DIR__ . "/admin/Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/listar.php"));


if(!isset($_GET["id"])){
    return;
}
$id = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$imagens = pegarImagens($id );







echo '<div class="conteudo-overlay">';




echo '<div class="imagens">';

$aux = 0;
foreach($imagens as $imagem)
{
    if($aux == 0){
        echo '<img class="mySlides" src="', $imagem , '" style="height: 300px;  display: block; margin-left: auto;margin-right: auto;">';

    } else {
        echo '<img class="mySlides" src="', $imagem , '" style="height: 300px; display: none; margin-left: auto;margin-right: auto;">';

    }
    $aux++;
}

echo '<div class="center">';
echo    '<div class="section">';
echo        '<div class="buttonSlide" onclick="plusDivs(-1)"> ❮ </div>';

for($i = 0; $i < sizeof($imagens); $i++)
{
    echo '<div class="pag demo" onclick="currentDiv(' , $i + 1 , ')">' , $i + 1 , '</div>'; 

}
echo        '<div class="buttonSlide" onclick="plusDivs(1)"> ❯ </div>';
echo   '</div>';

echo   '</div>';

echo '</div>';

echo '<div class="descricao">';
mostrarInformacoes($id);
echo '</div>';

echo '</div>';

?>