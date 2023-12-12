<?php
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
  header("Location: " . URL_PAGINAS . "login.php");
  die();
}
?>
<!DOCTYPE html>
<html>
  <?php adicionarTitulo("Administração");?>
  <body>
    <div class="container">
      <?php adicionarMenu();?>
      <section class="corpo">
        Bem vindo(a), <?= $_SESSION["nome"] ?>!
      </section>
    </div>
  </body>
</html>
