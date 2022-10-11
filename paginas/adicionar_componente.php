<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("../Negocio/Componente.php");

require_once("config.php");


$estruturaTabela = [];

if (isset($_GET['tabela']))
{
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    
    $estruturaTabela = GerenciadorDeEstruturas::recuperarEstrutura($tabela);
    $estruturaComponente = GerenciadorDeEstruturas::recuperarEstrutura("componente");
    if ($estruturaTabela == NULL) {
        die();
    }
} else {
    die();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php print(MENU_PRINCIPAL);?>

<div class="container p-3 my-3 bg-light text-dark rounded">

    <form action="<?= URL_NEGOCIO ?>adicionar_componente.php" method="post">
        <h4>Adicionar <?= ucwords($estruturaTabela->getNome()) ?> </h4>

        <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
        <h5>Geral</h5>
        <?php Componente::gerarCamposFormulario($estruturaComponente, 'componente'); ?>
        <br>
        <br>
        
        <h5>Especifico</h5>

        <?php Componente::gerarCamposFormulario($estruturaTabela, $tabela, $ignorar = 'componente_id'); ?>
        <br>
        <div>
            <button type="submit" class="btn btn-secondary btn-lg btn-block">Adicionar</button>
        </div>
    </form>
</div>
</body>
</html>
