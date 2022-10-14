<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("config.php");

$bandoDeDados = new BancoDeDados();
$resultados = [];
$tabela = "";
$entidade;
$resultado = [];
$id = -1;
$referencias = [];

if (isset($_GET['tabela']) && isset($_GET['id'])) {
    $tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    $resultado = $bandoDeDados->visualizar($tabela, $id);

    if ($resultado == NULL) {
        header("Location: " . URL . "View/erro.php?erro=arquivo-nao-encontrado");
        die();
    }

    foreach($resultado->getCampos() as $campo){
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
    <?php adicionarTitulo("Visualizar " . ucwords($tabela) . " " . $id);?>
<body>
    <?php print(MENU_PRINCIPAL);?>
<div class="container p-3 my-3 bg-light text-dark rounded">



    <h4>Visualização de <?= $resultado->getNome()?>
        <a class="btn btn-primary" href="<?= URL ?>listar.php?tabela=<?= $tabela ?>" role="button">Listar</a>
    </h4>
    <table class="table">
        <thead>
        <tr>
            <?php foreach ($resultado->getCampos() as $campo): ?>
                <th scope="col"> <?=  $campo->getNome() ?> </th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            
            <?php foreach ($resultado->getCampos() as $campo)
            {
                if($campo->getTipo() == "chave_estrangeira")
                {
                echo "<td>", mostraValorPeloId($campo->getReferencia(), $campo->getValor(), $referencias), "</td>" ;  
                }
                else
                {
                echo "<td>", $campo->getValor(), "</td>" ;
                } 
            }
            ?>
        </tr>
        </tbody>
    </table>
    <a href="<?= URL ?>editar.php?tabela=<?= $tabela ?>&id=<?= $id ?>">Editar</a>
    <a href="<?= URL_NEGOCIO ?>deletar.php?tabela=<?= $tabela ?>&id=<?= $id ?>">DELETAR</a>
</div>

</body>
</html>
