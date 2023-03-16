<?php
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Negocio/Entidade.php"));
require_once(realpath(__DIR__ . "/../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
  header("Location: " . URL . "index.php?erro=login-necessario");
  die();
}

function editar()
{
    $inputLimpo = Componente::limparInputUsuario($_POST);
    $id = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    if($inputLimpo == [])
    {
        header("Location: " . URL_PAGINAS . "listar.php?tabela=" . $inputLimpo["tabela"] . "&erro=editar");
    }

    $entidade = new Entidade();
    $entidade->setNome($inputLimpo["tabela"]);
    $entidade->adicionarNovosCampos($inputLimpo["campos"]);


    $gerenciadorBD = new BancoDeDados();
    if($gerenciadorBD->editar($entidade))
    {
        header("Location: " . URL_PAGINAS . "visualizar.php?tabela=" . $inputLimpo["tabela"] . '&id=' . $id);
    }
    else
    {
        header("Location: " . URL_PAGINAS . "visualizar.php?tabela=" . $inputLimpo["tabela"] . '&id=' . $id);
    }
    die();
}
$metodo = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);
if($metodo == "POST")
{
    editar();
}


$gerenciadorBD = new BancoDeDados();
$resultado = [];
$tabela = "";
$estruturaTabela = [];
$id = -1;
if (isset($_GET['tabela']) && isset($_GET['id'])) {

    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    $resultado = $gerenciadorBD->visualizar($tabela, $id);
    $estruturaTabela = GerenciadorDeEstruturas::recuperarEstrutura($tabela);
}
?>
<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Editar " . ucwords($tabela) . " " . $id);?>
    <body>
        <div class="container">
            <?php adicionarMenu();?>
            <section class="corpo">
                    <form method="post" class="em-coluna">
                        <h4>Editar <?= $tabela ?> <?= $id ?> </h4>
                        <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <?php Componente::gerarCamposFormulario($resultado); ?>

                        <div>
                            <button type="submit" class="form-botao form-botao-roxo">Editar</button>
                        </div>
                    </form>
            </section>
        </div>
    </body>
</html>
