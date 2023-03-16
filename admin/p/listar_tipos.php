<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));


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
        <?php adicionarMenu();?>

        <div class="container p-3 my-3 bg-light text-dark rounded">

            <h4>Tipos</h4>
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
