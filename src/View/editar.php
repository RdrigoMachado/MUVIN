<?php
require_once("../Arquivos/PersistenciaDeEstruturas.php");
require_once("../BancoDeDados/BandoDeDados.php");
require_once("../config.php");

$gerenciadorBD = new GerenciadorDeBancoDados();
$resultado = [];
$tabela = "";
$estruturaTabela = [];
$id = -1;
if (isset($_GET['tabela']) && isset($_GET['id'])) {
    $tabela = filter_input(INPUT_GET, $_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_GET, $_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $resultado = $gerenciadorBD->visualizar($tabela, $id);
    $estruturaTabela = PersistenciaDeEstruturas::recuperarEstruturaTabelaGenerica($tabela);
}

function criarCampoSelect($nome, $tabelaReferencia, $atual)
{

    $gerenciadorDeBD = new GerenciadorDeBancoDados();
    $valoresReferencia = $gerenciadorDeBD->listarTabela($tabelaReferencia);

    $estruturaTabelaReferencia = PersistenciaDeEstruturas::recuperarEstruturaTabelaGenerica($tabelaReferencia);
    $display = $estruturaTabelaReferencia["display"];

    $campoSelect = '<label height="20">' . ucwords($nome) . '</label>  <select class="form-select" name="' . $nome . '" ';
    if (!empty($valoresReferencia)) {
        $campoSelect = $campoSelect . '>';
        foreach ($valoresReferencia as $valor) {
            $campoSelect = $campoSelect . '<option value="' . $valor["id"] . '"';
            if ($valor["id"] == $atual) {
                $campoSelect = $campoSelect . ' selected';
            }
            $campoSelect = $campoSelect . '>' . ucwords($valor[$display]) . '</option>';
        }
    } else {
        $campoSelect = $campoSelect . ' disabled >';
    }
    print($campoSelect . '</select>');
}


function criarCampoComTipo($tipo, $nome, $atual)
{
    $campo = '<label>' . ucwords($nome) . '</label> <input class="form-control" name="' . $nome . '" type="' . $tipo . '" value="' . $atual . '"';
    if ($tipo == "float") {
        $campo = $campo . 'step=0.01';
    }
    print($campo . '>');
}

function gerarCamposFormulario($estrutura, $atual)
{
    $tipo = "";
    foreach ($atual as $campo) {
        if ($campo["tipo"] == "chave_estrangeira") {
            criarCampoSelect($campo['nome'], $campo['referencia'], $campo['valor']);
        } elseif ($campo["tipo"] != "chave_primaria") {
            switch ($campo["tipo"]) {
                case 'int':
                case 'float':
                    $tipo = "number";
                    break;
                case 'text':
                case 'varchar':
                    $tipo = "text";
                    break;
                case 'date':
                    $tipo = "date";
                    break;
            }
            criarCampoComTipo($tipo, $campo['nome'], $campo['valor']);
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php print(MENU_PRINCIPAL); ?>

<div class="container p-3 my-3 bg-light text-dark rounded">

    <h4>Editar <?= $tabela ?> <?= $id ?> </h4>
    <form action="<?= URL ?>Controle/editar.php" method="post">
        <input type="hidden" name="tabela" value="<?= $estruturaTabela["tabela"] ?>">
        <input type="hidden" name="id" value="<?= $id ?>">
        <?php gerarCamposFormulario($estruturaTabela, $resultado); ?>

        <br>
        <div>
            <button type="submit" class="btn btn-secondary btn-lg btn-block">Editar</button>
        </div>
    </form>
</div>

</body>
</html>
