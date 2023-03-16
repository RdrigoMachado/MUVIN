<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../Negocio/Entidade.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

function adicionar()
{
    $inputLimpo = Componente::limparInputUsuario($_POST);
    if($inputLimpo == [])
    {
        header("Location: " . URL_PAGINAS . "listar_componente.php?tabela=" . $inputLimpo["tabela"] . "&erro=adicionar");
    }

    $entidade = new Entidade();
    $entidade->setNome($inputLimpo["tabela"]);
    $entidade->adicionarNovosCampos($inputLimpo["campos"]);
    

    $bancoDeDados = new BancoDeDados();
    $id_adicionado = $bancoDeDados->adicionar($entidade);
    if ($id_adicionado)
    {
        header("Location: " . URL_PAGINAS . "visualizar.php?tabela=" . $inputLimpo["tabela"] . "&id=" . $id_adicionado);
    }
    else
    {
        header("Location: " . URL_PAGINAS . "listar.php?tabela=" . $inputLimpo["tabela"] . "&erro=adicionar");
    }
    die();
}

$metodo = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);
if($metodo == "POST")
{
    adicionar();
}


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
        <div class="container">
        <?php adicionarMenu();?>
        <section class="corpo">
        
            <form method="post" class="em-coluna">
                <h4>Adicionar <?= ucwords($estruturaTabela->getNome()) ?> </h4>

                <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
                <?php Componente::gerarCamposFormulario($estruturaTabela); ?>
                    <button class="form-botao form-botao-roxo" type="submit">Adicionar</button>
            </form>
        </section>
        </div>
    </body>
</html>
