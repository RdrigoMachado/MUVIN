<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
  header("Location: " . URL_PAGINAS . "login.php?erro=login-necessario");
  die();
}

if(!isset($_GET['tabela']))
{
  echo "Página não existe";
  die();
}

$tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
$estrutura = GerenciadorDeEstruturas::recuperarEstrutura($tabela);

if(empty($estrutura))
{
  echo "Página não existe";
  die();
}

$bandoDeDados = new BancoDeDados();
$entidades = $bandoDeDados->listar($tabela);
$referencias = [];

foreach($estrutura->getCampos() as $campo){
  if($campo->getTipo() == "chave_estrangeira"){
    $referencias[$campo->getReferencia()] = $bandoDeDados->listar($campo->getReferencia());
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
  <?php adicionarTitulo("Listar " . ucwords($tabela));?>
  <body>
    <div class="container">
      <?php adicionarMenu();?>
      <section class="corpo">
        <div class="tabela">

          <h4>Lista de <?= $tabela ?> </h4>
            <a class="btn btn-primary" href="<?= URL_PAGINAS ?>adicionar_componente.php?tabela=<?= $tabela ?>" role="button">Adicionar</a>

          <table class="table">
            <thead>
              <tr>
                <?php foreach ($estrutura->getCampos() as $campo): ?>
                  <th scope="col"> <?= str_replace("_", " ", $campo->getNome()) ?> </th>
                <?php endforeach;?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($entidades as $entidades): ?>
              <tr>
                <?php foreach ($entidades->getCampos() as $campo): if($campo->getNome() == "id"): ?>
                  <th scope="row">
                    <a href="<?= URL_PAGINAS ?>visualizar_componente.php?tabela=<?= $tabela ?>&id=<?= $campo->getValor()?>"> <?= $campo->getValor()?> </a>
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
      </section>
    </div>
  </body>
</html>
