<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("../Negocio/Componente.php");

require_once("config.php");

$gerenciadorBD = new BancoDeDados();
$resultado = [];
$tabela = "";
$estruturaTabela = [];
$id = -1;
if (isset($_GET['tabela']) && isset($_GET['id'])) {

    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    $resultado = $gerenciadorBD->visualizar($tabela, $id);
    $estruturaTabela = GerenciadorDeEstruturas::recuperarEstrutura($tabela);
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
<?php print(MENU_PRINCIPAL); ?>

<div class="container p-3 my-3 bg-light text-dark rounded">

    <h4>Editar <?= $tabela ?> <?= $id ?> </h4>
    <form action="<?= URL ?>../Negocio/editar.php" method="post">
        <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <?php Componente::gerarCamposFormulario($resultado); ?>

        <br>
        <div>
            <button type="submit" class="btn btn-secondary btn-lg btn-block">Editar</button>
        </div>
    </form>
</div>

</body>
</html>
