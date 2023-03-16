<?php
require_once(realpath(__DIR__ . "/listar.php"));


if(!isset($_GET["id"])){
    return;
}
$id = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

$informacoes = pegarInformacoes($id);
$imagens = pegarImagens($id );


echo '<div class="content" style="max-width: 900px; align-itens:center">';
$aux = 0;
foreach($imagens as $imagem)
{
    if($aux == 0){
        echo '<img class="mySlides" src="', $imagem , '" style="height: 200px;  display: block; margin-left: auto;margin-right: auto;">';

    } else {
        echo '<img class="mySlides" src="', $imagem , '" style="height: 200px; display: none; margin-left: auto;margin-right: auto;">';

    }
    $aux++;
}
echo '</div>';

echo '<div class="center">';
echo    '<div class="section">';
echo        '<div class="buttonSlide" onclick="plusDivs(-1)"> ❮ </div>';

for($i = 0; $i < sizeof($imagens); $i++)
{
    echo '<div class="pag demo" onclick="currentDiv(' , $i + 1 , ')">' , $i + 1 , '</div>'; 

}
echo        '<div class="buttonSlide" onclick="plusDivs(1)"> ❯ </div>';
echo   '</div><br/>';

echo   '</div><br/><div class="descricao">';

foreach($informacoes as $informacao)
{
    echo "<p>" , $informacao ," </p>";
}

echo '</div>'

?>