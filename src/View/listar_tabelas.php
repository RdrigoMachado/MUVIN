<?php
require_once("../Persistencia/Arquivos/PersistenciaDeEstruturas.php");
require_once("../config.php");


function criarListaLinksTabelas()
{
    $tabelas = PersistenciaDeEstruturas::listarNomesTabelasGenericas();
    foreach ($tabelas as $tabela)
    {
        print(' <li class="nav-item active"> <a class="nav-link"  href="'. URL . 'View/listar.php?tabela=' . $tabela . '"> ' . $tabela . '<span class="sr-only"></span></a></li>' . PHP_EOL);

    }
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

    <h3>Tabelas</h3>
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
