<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../Negocio/Entidade.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
  header("Location: " . URL . "index.php?erro=login-necessario");
  die();
}

function retornarId($tipos, $nome_procurado){
    foreach($tipos as $tipo){    
        $campo_nome = $tipo->getCampoEspecifico("nome");
        if($campo_nome->getValor() == $nome_procurado){
            $campo_id = $tipo->getCampoEspecifico("id");
            return $campo_id->getValor();
        }
    }
    return -1;
}

function adicionar()
{
    $tabela   = filter_var($_POST["tabela"], FILTER_SANITIZE_STRING);

    $inputEspecifico = Componente::limparInputEspecifico($_POST[$tabela], $tabela);
    $inputComponente = Componente::limparInputEspecifico($_POST['componente'], 'componente');
    if($inputEspecifico == [] || $inputComponente  == [] )
    {
        header("Location: " . URL . "listar_componentes.php?tabela=" . $inputLimpo["tabela"] . "&erro=adicionar");
    }

    $bancoDeDados = new BancoDeDados();
    $tipos = $bancoDeDados->listar("tipo");
    $id_tipo =  retornarId($tipos, $tabela);
    if($id_tipo == -1){
        header("Location: " . URL . "listar_componentes.php?tabela=" . $tabela . "&erro=tipo-nao-encontrado");
        die();
    }
    //adiciona componente e pega id
    
    $componente = new Entidade();
    $componente->setNome("componente");
    $componente->adicionarNovosCampos($inputComponente["campos"]);
    $componente->adicionarCampo("tipo_id", "chave_estrangeira", NULL, "tipo", $id_tipo);
    $componente->adicionarCampo("ultima_atualizacao", "date", NULL, NULL, date('Y-m-d'));
    $componente->adicionarCampo("criacao", "date", NULL, NULL, date('Y-m-d'));

    $id_adicionado = $bancoDeDados->adicionar($componente);
     
    if($id_adicionado == -1)
    {
        header("Location: " . URL_PAGINAS . "listar_componentes.php?tabela=" . $tabela . "&erro=adicionar");
        die();
    }

    $entidade = new Entidade();
    $entidade->setNome($tabela);
    $entidade->adicionarNovosCampos($inputEspecifico["campos"]);
    $entidade->adicionarCampo("componente_id", "chave_estrangeira", NULL, "componente", $id_adicionado);

    $id_adicionado = $bancoDeDados->adicionar($entidade);
    
    if ($id_adicionado != -1)
    {
        header("Location: " . URL_PAGINAS . "visualizar_componente.php?tabela=" .$tabela . "&id=" . $id_adicionado);
    }
    else
    {
        header("Location: " . URL_PAGINAS . "listar_componentes.php?tabela=" . $tabela . "&erro=adicionar");
    }
    die();
}


$metodo = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);
if($metodo == "POST")
{
    adicionar($_POST);
}





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
    echo "erro";
    die();
}

$estruturaComponente = GerenciadorDeEstruturas::recuperarEstrutura("componente");
?>


<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Adicionar Componente");?>
    <body>
        <div class="container">
        <?php adicionarMenu();?>
        <section class="corpo">
        
            <form method="post" class="em-coluna">
                <h4>Adicionar <?= ucwords($estruturaTabela->getNome()) ?> </h4>

                <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
                <h5>Geral</h5>
                <?php Componente::gerarCamposFormulario($estruturaComponente, 'componente', $lista_ignorar_componente); ?>
                
                <h5>Especifico</h5>
                <?php Componente::gerarCamposFormulario($estruturaTabela, $tabela, $lista_ignorar_especifico); ?>

                <button class="form-botao form-botao-roxo" type="submit">Salvar</button>
            </form>
        </section>
        </div>
    </body>
</html>
