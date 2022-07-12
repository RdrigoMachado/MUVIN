<?php
require_once("../Persistencia/Arquivos/PersistenciaDeEstruturas.php");
require_once("../Persistencia/BancoDeDados/BandoDeDados.php");
require_once("../config.php");

$bandoDeDados = new BancoDeDados();
$resultados = [];
$tabela = "";

if(isset($_GET['tabela'])){
  $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
  $resultados = $bandoDeDados->listar($tabela);
  $estruturaTabela = PersistenciaDeEstruturas::recuperarEstruturaTabelaGenerica($tabela);
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

    <h4>Lista de <?= $tabela ?> </h4>

      <a class="btn btn-primary" href="<?= URL ?>/View/adicionar.php?tabela=<?= $tabela ?>" role="button">Adicionar</a>

    <table class="table">
      <thead>
        <tr>
          <?php foreach ($estruturaTabela["campos"] as $campo): ?>
            <th scope="col"> <?= $campo["nome"] ?> </th>
          <?php endforeach;?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($resultados as $resultado): ?>
        <tr>
          <?php foreach ($resultado as $campo): if($campo["nome"] == "id"): ?>
            <th scope="row">
              <a href="<?=URL?>/View/visualizar.php?tabela=<?= $tabela ?>&id=<?= $resultado[0]["valor"]?>"> <?= $campo["valor"]?> </a>
            </th>
          <?php else:?>
            <td> <?= $campo["valor"]?> </td>
          <?php endif; endforeach;?>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
  </div>
  </body>
</html>
