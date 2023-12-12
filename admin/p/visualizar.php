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

$bandoDeDados = new BancoDeDados();
$resultados = [];
$tabela = "";
$entidade;
$resultado = [];
$id = -1;
$referencias = [];

if (!isset($_GET['tabela']) || !isset($_GET['id']))
{
    echo "Página não existe";
    die();
}

$tabela = filter_var($_GET['tabela'], FILTER_SANITIZE_STRING);
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$resultado = $bandoDeDados->visualizar($tabela, $id);

if ($resultado == NULL) 
{
    echo "Página não existe";
    die();
}

foreach($resultado->getCampos() as $campo)
{
    if($campo->getTipo() == "chave_estrangeira")
    {
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
    <?php adicionarTitulo("Visualizar " . ucwords($tabela) . " " . $id);?>
    <body>
        <div class="container">
            <?php adicionarMenu();?>
            <section  class="corpo">
                <div class="tabela">
                <h4>Visualização de <a href="<?= URL_PAGINAS . 'listar.php?tabela=' . $tabela ?>"> <?= $tabela ?> </a></h4>
                <table>
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
                <a href="<?= URL_PAGINAS ?>editar.php?tabela=<?= $tabela ?>&id=<?= $id ?>">Editar</a>
                <a href="<?= URL_PAGINAS ?>deletar.php?tabela=<?= $tabela ?>&id=<?= $id ?>">DELETAR</a>
            </div>            
            </section>
        </div>
    </body>
</html>
