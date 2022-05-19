<?php
require_once("../Gerenciamento/gerenciador_de_arquivos.php");
require_once("../Gerenciamento/gerenciador_de_banco_dados.php");
require_once("../config.php");

$gerenciadorDeArquivos = new GerenciadorDeArquivos();

$estruturaTabela = [];

if (isset($_GET['tabela']))
{
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $estruturaTabela = $gerenciadorDeArquivos->recuperarEstruturaTabela($tabela);
    if ($estruturaTabela == false) {
        redirecionar();
    }
} else {
    redirecionar();
}



function redirecionar()
{
    header("Location: " . URL . "View/erro.php?erro=arquivo-nao-encontrado");
    die();
}

function criarCampoSelect($nome, $tabelaReferencia)
{

    $gerenciadorDeBD = new GerenciadorDeBancoDados();
    $valoresReferencia = $gerenciadorDeBD->listarTabela($tabelaReferencia);

    $gerenciadorDeArquivos = new GerenciadorDeArquivos();
    $estruturaTabelaReferencia = $gerenciadorDeArquivos->recuperarEstruturaTabela($tabelaReferencia);
    $display = $estruturaTabelaReferencia["display"];

    $campoSelect = '<label height="20">' . ucwords($nome) . '</label>  <select class="form-select" name="' . $nome . '" ';
    if(!empty($valoresReferencia))
    {
        $campoSelect = $campoSelect . '>';
        foreach($valoresReferencia as $valor)
        {
            $campoSelect = $campoSelect . '<option value="' . $valor["id"] . '">' . ucwords($valor[$display]) . '</option>';
        }
    } else {
        $campoSelect = $campoSelect . ' disabled >';
    }
    print($campoSelect . '</select>');
}


function criarCampoComTipo($tipo, $nome)
{
    $campo = '<label>' . ucwords($nome) . '</label> <input class="form-control" name="' . $nome . '" type="' .$tipo . '" ';
    if($tipo == "float")
    {
        $campo = $campo . 'step=0.01';
    }
    print($campo . '>');
}

function gerarCamposFormulario($estrutura)
{
    $tipo = "";
    foreach ($estrutura["campos"] as $campo)
    {
        if($campo["tipo"] == "chave_estrangeira")
        {
            criarCampoSelect( $campo['nome'], $campo['referencia']);
        } elseif ($campo["tipo"] != "chave_primaria")
        {
            switch ($campo["tipo"])
            {
                case 'int': case 'float':
                    $tipo = "number";
                    break;
                case 'text': case 'varchar':
                    $tipo = "text";
                    break;
                case 'date':
                    $tipo = "date";
                    break;
            }
            criarCampoComTipo($tipo, $campo['nome']);
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
<?php print(MENU_PRINCIPAL);?>

<div class="container p-3 my-3 bg-light text-dark rounded">

    <form action="<?= URL ?>Controle/adicionar.php" method="post">
        <h4>Adicionar <?= ucwords($estruturaTabela["tabela"]) ?> </h4>
        <input type="hidden" name="tabela" value="<?= $estruturaTabela["tabela"] ?>">
        <?php gerarCamposFormulario($estruturaTabela); ?>
        <br>
        <div>
            <button type="submit" class="btn btn-secondary btn-lg btn-block">Adicionar</button>
        </div>
    </form>
</div>
</body>
</html>
