<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("../Negocio/Componente.php");

require_once("config.php");
$lista_ignorar_componente = ["tipo_id", "ultima_atualizacao", "criacao"];
$lista_ignorar_especifico = ["componente_id"];


$estruturaTabela = [];

if (isset($_GET['tabela']))
{
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    
    $estruturaTabela = GerenciadorDeEstruturas::recuperarEstrutura($tabela);
    $estruturaComponente = GerenciadorDeEstruturas::recuperarEstrutura("componente");
    if ($estruturaTabela == NULL) {
        die();
    }
} else {
    die();
}

?>
<!DOCTYPE html>
<html>
    <?php adicionarTitulo("Adicionar Componente");?>
<body>
    <?php print(MENU_PRINCIPAL);?>

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
