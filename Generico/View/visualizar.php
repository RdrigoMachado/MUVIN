<?php
require_once("../Gerenciamento/gerenciador_de_arquivos.php");
require_once("../Gerenciamento/gerenciador_de_banco_dados.php");
require_once("../config.php");

$gerenciadorArquivos = new GerenciadorDeArquivos();
$gerenciadorBD = new GerenciadorDeBancoDados();
$resultados = [];
$tabela = "";
$estruturaTabela = [];
$resultado = [];
$id = -1;
if (isset($_GET['tabela']) && isset($_GET['id'])) {
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

    $resultado = $gerenciadorBD->visualizar($tabela, $id);
    $estruturaTabela = $gerenciadorArquivos->recuperarEstruturaTabela($tabela);
    if ($estruturaTabela == false) {
        header("Location: " . URL . "View/erro.php?erro=arquivo-nao-encontrado");
        die();
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



    <h4>Visualização de <?= $estruturaTabela["tabela"] ?>
        <a class="btn btn-primary" href="<?= URL ?>View/listar.php?tabela=<?= $tabela ?>" role="button">Listar</a>
    </h4>
    <table class="table">
        <thead>
        <tr>
            <?php foreach ($estruturaTabela["campos"] as $campo): ?>
                <th scope="col"> <?= $campo["nome"] ?> </th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php foreach ($resultado as $campo): ?>
                <td> <?= $campo["valor"] ?> </td>
            <?php endforeach; ?>
        </tr>
        </tbody>
    </table>
    <a href="<?= URL ?>View/editar.php?tabela=<?= $tabela ?>&id=<?= $id ?>">Editar</a>
</div>

</body>
</html>
