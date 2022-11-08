<?php
require_once("../Negocio/Componente.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("config.php");

$resultados = [];
$tabela = "";
$entidade;
$id = -1;
$referencias = [];

$tipo = null;
$componente = null;
$imagens = [];

function pegarValorComponenteId()
{   
    global  $tipo;

    $campo = $tipo->getCampoEspecifico("componente_id");
    return $campo->getValor();
}

function recuperaValores()
{
    global  $tipo, $componente, $tabela, $id, $imagens;
    
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

    $banco_de_dados = new BancoDeDados();

    $tipo = $banco_de_dados->visualizar($tabela, $id);
  
    $componente = $banco_de_dados->visualizar("componente", pegarValorComponenteId());
    if ($tipo == NULL  || $componente == NULL ) 
    {
        header("Location: " . URL . "listar_componentes.php?erro=nao-encontrado&tabela=" . $tabela);
        die();
    }
    $filtro = "componente_id = " . $componente->getCampoEspecifico("id")->getValor();
    $imagens = $banco_de_dados->listar("imagem", $filtro);
}


if (isset($_GET['tabela']) && isset($_GET['id']))
{
    recuperaValores();
}

?>
<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Visualizar " . ucwords($tabela) . " " . $id);?>
<body>
    <?php print(MENU_PRINCIPAL);?>
<div class="container p-3 my-3 bg-light text-dark rounded">

    <h4>
        Visualização de <?= $tipo->getNome()?>
    </h4>

    <h4> Geral </h4>

    <?php

        Componente::visualizarCampos($componente->getCampos()); 
        ?>
    
    <br>
    <h4> Especifico </h4>
    <?php
     Componente::visualizarCampos($tipo->getCampos()); 
    ?>
    <br>

    <h4> Imagens </h4>
    <?php
        foreach($imagens as $imagem)
        {
            $caminho = "../Persistencia/imagens/"
                        . $imagem->getCampoEspecifico("componente_id")->getValor() . "/"
                        . $imagem->getCampoEspecifico("nome")->getValor();
            echo "<img src='", $caminho ,"'>"  ; 
        } 
    ?>
    
    
    <br>

    
    <form method="POST" enctype="multipart/form-data" action="<?= URL_NEGOCIO ?>adicionar_imagem.php"> 
        <input hidden name="id_componente" value="<?=$componente->getCampoEspecifico('id')->getValor() ?>">
        <input hidden name="tabela" value="<?=$tipo->getNome() ?>">
        <input hidden name="id" value="<?=$tipo->getCampoEspecifico('id')->getValor() ?>">
        <input type="file" name="imagem" accept="image/*">    
        <button class="btn btn-primary" type="submit">Adicionar Imagem</button>
    </form>


    <br>
    <br>


    <a  class="btn btn-primary" href="<?= URL ?>editar_componente.php?tabela=<?= $tabela  ?>&id=<?= $id ?>" role="button">Editar</a>
    <a  class="btn btn-primary" href="<?= URL_NEGOCIO ?>deletar.php?tabela=<?= $tabela    ?>&id=<?= $id ?>" role="button">DELETAR</a>
    <a class="btn btn-primary"  href="<?= URL ?>listar_componentes.php?tabela=<?= $tabela ?>" role="button">Listar</a>





</div>

</body>
</html>