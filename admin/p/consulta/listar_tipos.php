<?php
require_once(realpath(__DIR__ . "/../../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../../config.php"));

function criarListaLinksComponentes()
{
$componentes = GerenciadorDeEstruturas::listarNomesTipos();
   
    foreach ($componentes as $componente)
    {
        echo '
        <li class="nav-item active"> 
            <a class="nav-link"  href="' . URL_PAGINAS . 'consulta/listar_componentes.php?tabela=' .
            $componente . '"> ' . $componente . '<span class="sr-only"></span></a></li>' . PHP_EOL;

    }
}

function criarListaLinksGenericos()
{
$genericos = GerenciadorDeEstruturas::listarNomesEstruturas();
   
    foreach ($genericos as $generico)
    {
        echo '
        <li class="nav-item active"> 
            <a class="nav-link"  href="' . URL_PAGINAS . 'consulta/listar.php?tabela=' .
            $generico . '"> '. $generico . '<span class="sr-only"></span></a></li>' . PHP_EOL;
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

                        <?php 
                            
                            echo '<h2>Componentes</h2>';
                            criarListaLinksComponentes();
                            echo '<h2>Tabelas genéricas</h2>';
                            criarListaLinksGenericos();

                        ?>
                    </ul>
                </div>
            </nav>
        </div>
    </body>
</html>
