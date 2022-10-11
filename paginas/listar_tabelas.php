<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("config.php");


function criarListaLinksTabelas()
{
    $tabelas = GerenciadorDeEstruturas::listarNomesEstruturas();
    foreach ($tabelas as $tabela)
    {
        print(' <li class="nav-item active"> <a class="nav-link"  href="'. URL . 'listar.php?tabela=' . $tabela. '"> ' . $tabela . '<span class="sr-only"></span></a></li>' . PHP_EOL);

    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Listar Tabelas</title>
</head>
<body>
<?php print(MENU_PRINCIPAL);?>

<div class="container p-3 my-3 bg-light text-dark rounded">

    <h4>Tabelas</h4>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <?php criarListaLinksTabelas(); ?>
            </ul>
        </div>
    </nav>
</div>

</body>
</html>
