<?php
require_once("../Negocio/Componente.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("config.php");

$resultados = [];
$tabela = "";
$entidade;
$tipo = null;
$id = -1;
$referencias = [];


$tipo = null;
$componente = null;

function pegarValorComponenteId()
{   
    global  $tipo;

    $campo = $tipo->getCampoEspecifico("componente_id");
    return $campo->getValor();
}

function recuperaValores()
{
    global  $tipo, $componente, $tabela, $id;
    
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
        
    <a  class="btn btn-primary" href="<?= URL ?>editar_componente.php?tabela=<?= $tabela  ?>&id=<?= $id ?>" role="button">Editar</a>
    <a  class="btn btn-primary" href="<?= URL_NEGOCIO ?>deletar.php?tabela=<?= $tabela    ?>&id=<?= $id ?>" role="button">DELETAR</a>
    <a class="btn btn-primary"  href="<?= URL ?>listar_componentes.php?tabela=<?= $tabela ?>" role="button">Listar</a>

</div>

</body>
</html>
