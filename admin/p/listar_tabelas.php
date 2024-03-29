<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
  header("Location: " . URL_PAGINAS . "login.php?erro=login-necessario");
  die();
}

function criarListaLinksTabelas()
{
    $tabelas = GerenciadorDeEstruturas::listarNomesEstruturas();
    foreach ($tabelas as $tabela)
    {
        print(' <li class="nav-item active"> <a class="nav-link"  href="'. URL_PAGINAS . 'listar.php?tabela=' . $tabela. '"> ' . $tabela . '<span class="sr-only"></span></a></li>' . PHP_EOL);

    }
}
?>

<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Lista Tabelas");?>
    <body>
        <div class="container">
            <?php adicionarMenu();?>

            <section id="fomulario">
                <h4>Tabelas</h4>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">

                            <?php criarListaLinksTabelas(); ?>
                        </ul>
                    </div>
                </nav>
            </section>
        </div>
    </body>
</html>
