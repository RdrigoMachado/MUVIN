<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../Negocio/Entidade.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
  header("Location: " . URL_PAGINAS . "login.php?erro=login-necessario");
  die();
}

$inputEspecifico = null;
$inputComponente = null;
$tabela;
$id;
$componente_id;

/**
 * Recupera valores filtrados do componente e do tipo
 * caso não consiga pegar os dados de um deles redireciona para listar_componentes
 */
function recuperaValoresPostados()
{
    global $inputComponente, $inputEspecifico, $tabela, $id, $componente_id;

    $tabela   = filter_var($_POST["tabela"], FILTER_SANITIZE_STRING);
    $id = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $componente_id = (int) filter_var($_POST['componente_id'], FILTER_SANITIZE_NUMBER_INT);

    $inputEspecifico = Componente::limparInputEspecifico($_POST[$tabela], $tabela);
    $inputComponente = Componente::limparInputEspecifico($_POST['componente'], 'componente');

    if($inputEspecifico == [] || $inputComponente  == [] )
    {
        header("Location: " . URL_PAGINAS . "listar_componentes.php?tabela=" . $inputLimpo["tabela"] . "&erro=editar");
        die();
    }

}

function criarEntidadeComDadosRecuperados($nome_tabela, $campos)
{
    $entidade = new Entidade();
    $entidade->setNome($nome_tabela);
    $entidade->adicionarNovosCampos($campos);
    return $entidade;
}

function editar()
{
    global  $inputComponente, $inputEspecifico, $tabela, $id, $componente_id;

    recuperaValoresPostados();

    $componente = criarEntidadeComDadosRecuperados("componente", $inputComponente["campos"]);
    $componente->adicionarCampo("id", "chave_primaria", NULL, NULL, $componente_id);
    $componente->adicionarCampo("ultima_atualizacao", "date", NULL, NULL, date('Y-m-d'));
    $componente->adicionarCampo("criacao", "date", NULL, NULL, date('Y-m-d'));

    $tipo = criarEntidadeComDadosRecuperados($tabela, $inputEspecifico["campos"]);
    $tipo->adicionarCampo("id", "chave_primaria", NULL, NULL, $id);


    $banco_de_dados = new BancoDeDados();    
    $banco_de_dados->editar($tipo);
    $banco_de_dados->editar($componente);
    
    header("Location: " . URL_PAGINAS . "visualizar_componente.php?tabela=" . $tabela . '&id=' . $id);
    die();
}
$metodo = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);
if($metodo == "POST")
{
    editar();
}






$banco_de_dados = new BancoDeDados();
$resultado = [];
$tabela = "";
$estruturaTabela = [];
$id = -1;
$componente_id;
if (isset($_GET['tabela']) && isset($_GET['id'])) {

    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    $resultado = $banco_de_dados->visualizar($tabela, $id);
    $estruturaTabela = GerenciadorDeEstruturas::recuperarEstrutura($tabela);

    $campo_componente_id = $resultado->getCampoEspecifico("componente_id");
    $componente_id =  $campo_componente_id->getValor();

    $componente = $banco_de_dados->visualizar("componente", $componente_id);
    $lista_ignorar_componente = ["tipo_id", "ultima_atualizacao", "criacao"];
    $lista_ignorar_especifico = ["componente_id"];}
?>
<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Editar " . ucwords($tabela) . " " . $id);?>
    <body>
        <div class="container">
        <?php adicionarMenu();?>
            <section class="corpo">
                    <form class="em-coluna" method="post">
                        <h4>Editar <?= $tabela ?> <?= $id ?> </h4>
                        <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="componente_id" value="<?= $componente_id ?>">
                                                
                        <h5>Geral</h5>
                        <?php Componente::gerarCamposFormulario($componente, "componente", $lista_ignorar_componente); ?>
                    
                        <h5>Especifico</h5>
                        <?php Componente::gerarCamposFormulario($resultado, $tabela, $lista_ignorar_especifico); ?>
                    
                        <button type="submit" class="form-botao form-botao-roxo">Editar</button>
                    </form>
            </section>
        </div>
    </body>
</html>
