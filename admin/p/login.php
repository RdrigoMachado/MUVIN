<?php
require_once(realpath(__DIR__ . "/../Negocio/config.php"));

session_start();
if(isset($_SESSION["nome"] ))
{
  header("Location: " . URL_PAGINAS . "index.php");
  die();
}
?>
<!DOCTYPE html>
<html>
  <?php adicionarTitulo("Login");?>
  <body>
    <div class="container">
        <form action="<?=URL ?>admin/Negocio/Login.php" method="post">

            <div>
                <label for="uname"><b>Nome</b></label>
                <input type="text" placeholder="Nome do usuário" name="nome" required>

                <label for="psw"><b>Senha</b></label>
                <input type="password" placeholder="Senha" name="senha" required>

                <button type="submit">Login</button>
            </div>
        </form> 
    </div>
  </body>
</html>
