<?php
require_once(realpath(__DIR__ . "/../Negocio/Componente.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));
require_once(realpath(__DIR__ . "/../Negocio/adicionar_imagem.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
  header("Location: " . URL_PAGINAS . "login.php?erro=login-necessario");
  die();
}

$metodo = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_SPECIAL_CHARS);
if($metodo == "POST")
{
    if(isset($_FILES['imagem']) && isset($_POST['id_componente']) && isset($_POST['id']) && isset($_POST['tabela'] ))
    {
        $id             = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $tabela         =       filter_var($_POST['tabela'], FILTER_SANITIZE_STRING);
        $id_componente  = (int) filter_var($_POST['id_componente'], FILTER_SANITIZE_NUMBER_INT);
        $imagem         = $_FILES['imagem'];
        adicionarImagem($imagem, $id_componente, $id, $tabela);
    }
}





$resultados = [];
$tabela = "";
$entidade;
$id = -1;
$referencias = [];

$tipo = null;
$componente = null;
$imagens = [];

function pegarValorComponenteId()
{   
    global  $tipo;
    $campo = $tipo->getCampoEspecifico("componente_id");
    return $campo->getValor();
}

function recuperaValores()
{
    global  $tipo, $componente, $tabela, $id, $imagens;
    
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

    $banco_de_dados = new BancoDeDados();

    $tipo = $banco_de_dados->visualizar($tabela, $id);
  
    $componente = $banco_de_dados->visualizar("componente", pegarValorComponenteId());
    if ($tipo == NULL  || $componente == NULL ) 
    {
        echo "Página não existe";
        die();
    }
    $filtro = "componente_id = " . $componente->getCampoEspecifico("id")->getValor();
    $imagens = $banco_de_dados->listar("imagem", $filtro);
}


if (!isset($_GET['tabela']) || !isset($_GET['id']))
{
    echo "Página não existe";
    die();
}
recuperaValores();
?>

<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Visualizar " . ucwords($tabela) . " " . $id);?>
    <body>
        <div class="container">
            <?php adicionarMenu();?>
            <section class="corpo">
                <div class="tabela">
                    <h4> Visualização de <?= $tipo->getNome()?> </h4>

                    <h4> Geral </h4>
                    <?php Componente::adminVisualizarCampos($componente->getCampos()); ?>
                    
                    <h4> Especifico </h4>
                    <?php Componente::adminVisualizarCampos($tipo->getCampos()); ?>
                    
                    <h4> Imagens </h4>
                    <?php
                        foreach($imagens as $imagem)
                        {
                            $caminho = URL . "imagens/"
                                        . $imagem->getCampoEspecifico("componente_id")->getValor() . "/"
                                        . $imagem->getCampoEspecifico("nome")->getValor();
                            echo "<img src='", $caminho ,"' width='300px'>"  ; 
                        } 
                    ?>
                    
                    <form method="POST" enctype="multipart/form-data"> 
                        <input hidden name="id_componente" value="<?=$componente->getCampoEspecifico('id')->getValor() ?>">
                        <input hidden name="tabela" value="<?=$tipo->getNome() ?>">
                        <input hidden name="id" value="<?=$tipo->getCampoEspecifico('id')->getValor() ?>">
                        <input type="file" name="imagem" accept="image/*">    
                        <br>
                        <button class="form-botao form-botao-roxo" type="submit">Salvar</button>
                    </form>
                    <div class="em-linha">
                        <a class="botao form-botao form-botao-roxo" href="<?= URL_PAGINAS ?>editar_componente.php?tabela=<?= $tabela  ?>&id=<?= $id ?>" role="button">Editar</a>
                        <a class="botao form-botao form-botao-roxo" href="<?= URL_PAGINAS ?>deletar.php?tabela=<?= $tabela    ?>&id=<?= $id ?>" role="button">DELETAR</a>
                        <a class="botao form-botao form-botao-roxo" href="<?= URL_PAGINAS ?>listar_componentes.php?tabela=<?= $tabela ?>" role="button">Listar</a>
                    </div>

                </div>
            </section>
        </div>
    </body>
</html>
