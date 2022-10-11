<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("config.php");

$bandoDeDados = new BancoDeDados();
$referencias = [];

if(isset($_GET['tabela'])){
  $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
  $entidades = $bandoDeDados->listar($tabela);
  $estrutura = GerenciadorDeEstruturas::recuperarEstrutura($tabela);
  if(empty($estrutura))
  {
    header("Location: " . URL . "listar_tipos.php");
    die();
  }

  foreach($estrutura->getCampos() as $campo){
    if($campo->getTipo() == "chave_estrangeira"){
      $referencias[$campo->getReferencia()] = $bandoDeDados->listar($campo->getReferencia());
    }
  }

}

function mostraValorPeloId($nome_referencia, $id, $referencias)
{
  foreach($referencias[$nome_referencia] as $referencia)
  {
    $campo_id = $referencia->getCampoEspecifico("id");
    if($campo_id->getValor() == $id)
    {
      $campo_display = $referencia->getCampoEspecifico($referencia->getDisplay());
      return $campo_display->getValor();
    }
  }
  return $id;
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

      <a class="btn btn-primary" href="<?= URL ?>adicionar_componente.php?tabela=<?= $tabela ?>" role="button">Adicionar</a>

    <table class="table">
      <thead>
        <tr>
          <?php foreach ($estrutura->getCampos() as $campo): ?>
            <th scope="col"> <?= $campo->getNome() ?> </th>
          <?php endforeach;?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($entidades as $entidades): ?>
        <tr>
          <?php foreach ($entidades->getCampos() as $campo): if($campo->getNome() == "id"): ?>
            <th scope="row">
              <a href="<?=URL?>visualizar.php?tabela=<?= $tabela ?>&id=<?= $campo->getValor()?>"> <?= $campo->getValor()?> </a>
            </th>
          <?php else:?>
            <td> 
              <?php 
              if($campo->getTipo() == "chave_estrangeira")
              {
                echo mostraValorPeloId($campo->getReferencia(), $campo->getValor(), $referencias);  
              }
              else
              {
                echo $campo->getValor();
              } 
              ?> </td>
          <?php endif; endforeach;?>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
  </div>
  </body>
</html>
