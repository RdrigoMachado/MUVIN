<?php
require_once(realpath(__DIR__ . "/../../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../../config.php"));

$lista_ignorar_componente = ["tipo_id", "ultima_atualizacao", "criacao"];
$lista_ignorar_especifico = ["componente_id"];


$estruturaTabela = [];

if (!isset($_GET['tabela']))
{
    echo "Página não existe";
    die();
}

$tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
$estruturaTabela = GerenciadorDeEstruturas::recuperarEstrutura($tabela);

if ($estruturaTabela == NULL) {
    die();
}

$estruturaComponente = GerenciadorDeEstruturas::recuperarEstrutura("componente");
?>


<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Adicionar Componente");?>
    <body>
        <?php adicionarMenu();?>

        <div class="container p-3 my-3 bg-light text-dark rounded">

            <form action="<?= URL_NEGOCIO ?>adicionar_componente.php" method="post">
                <h4>Adicionar <?= ucwords($estruturaTabela->getNome()) ?> </h4>

                <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
                <h5>Geral</h5>
                <?php Componente::gerarCamposFormulario($estruturaComponente, 'componente', $lista_ignorar_componente); ?>
                <br>
                <br>
                
                <h5>Especifico</h5>

                <?php Componente::gerarCamposFormulario($estruturaTabela, $tabela, $lista_ignorar_especifico); ?>
                <br>
                <div>
                    <button type="submit" class="btn btn-secondary btn-lg btn-block">Adicionar</button>
                </div>
            </form>
        </div>
    </body>
</html>
