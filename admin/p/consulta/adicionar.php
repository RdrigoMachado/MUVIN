<?php
require_once(realpath(__DIR__ . "/../../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../../config.php"));

if (!isset($_GET['tabela']))
{
    echo "Página não existe";
    die();
}

$tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
$estruturaTabela = GerenciadorDeEstruturas::recuperarEstrutura($tabela);

if ($estruturaTabela == NULL) {
    echo "Página não existe";
    die();
}
?>

<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Adicionar " . ucwords($tabela));?>
    <body>
        <?php adicionarMenu();?>

        <div class="container p-3 my-3 bg-light text-dark rounded">

            <form action="<?= URL_PAGINAS ?>adicionar.php" method="post">
                <h4>Adicionar <?= ucwords($estruturaTabela->getNome()) ?> </h4>

                <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
                <?php Componente::gerarCamposFormulario($estruturaTabela); ?>
                <br>
                <div>
                    <button type="submit" class="btn btn-secondary btn-lg btn-block">Adicionar</button>
                </div>
            </form>
        </div>
    </body>
</html>
