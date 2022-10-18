<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("../Negocio/Componente.php");

require_once("config.php");

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
    <?php print(MENU_PRINCIPAL);?>

<div class="container p-3 my-3 bg-light text-dark rounded">

    <h4>Editar <?= $tabela ?> <?= $id ?> </h4>
    <form action="<?= URL ?>../Negocio/editar_componente.php" method="post">
        <input type="hidden" name="tabela" value="<?= $estruturaTabela->getNome() ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="componente_id" value="<?= $componente_id ?>">
        
        <h5>Geral</h5>
        <?php Componente::gerarCamposFormulario($componente, "componente", $lista_ignorar_componente); ?>
        
        <br>
        <br>
        
        <h5>Especifico</h5>
        <?php Componente::gerarCamposFormulario($resultado, $tabela, $lista_ignorar_especifico); ?>
        
        <br>
        <div>
            <button type="submit" class="btn btn-secondary btn-lg btn-block">Editar</button>
        </div>
    </form>
</div>

</body>
</html>
