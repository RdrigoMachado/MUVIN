<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

function criarListaLinksComponentes()
{
$componentes = GerenciadorDeEstruturas::listarNomesTipos();
   
    foreach ($componentes as $componente)
    {
        echo '
        <li> <a  href="' . URL_PAGINAS . 'listar_componentes.php?tabela=' . $componente . '"> ' . $componente . '</a></li>' . PHP_EOL;

    }
}

function criarListaLinksGenericos()
{
$genericos = GerenciadorDeEstruturas::listarNomesEstruturas();
   
    foreach ($genericos as $generico)
    {
        echo '
        <li> <a href="' . URL_PAGINAS . 'listar.php?tabela=' . $generico . '"> '. $generico . '</a></li>' . PHP_EOL;
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
                <div class="lista">
                    <?php 
                        echo '<h2>Componentes</h2>';
                        criarListaLinksComponentes();
                        echo '<h2>Tabelas genéricas</h2>';
                        criarListaLinksGenericos();
                    ?>
                </div>
            </section>
        </div>
    </body>
</html>
