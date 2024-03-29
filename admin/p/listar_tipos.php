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
    $tabelas = GerenciadorDeEstruturas::listarNomesTipos();
    foreach ($tabelas as $tabela)
    {
        print(' <li class="nav-item active">' . $tabela . '</li>' . PHP_EOL);
    }
}
?>

<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Lista Tipos");?>
    <body>
        <div class="container">
        <?php adicionarMenu();?>
<section class="corpo">
    <div class="em-coluna">
            <h4>Tipos</h4>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">

                        <?php criarListaLinksTabelas(); ?>
                    </ul>
                </div>
            </nav>
        </div>
</section>
        </div>
    </body>
</html>
