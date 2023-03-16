<?php
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(!isset($_SESSION["nome"] ))
{
    echo "usuario nao fez login";
    echo password_hash("admin123", PASSWORD_DEFAULT);

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
