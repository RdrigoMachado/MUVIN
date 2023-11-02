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
<link rel="stylesheet" type="text/css" href="../../css/login.css">

  <?php adicionarTitulo("Login");?>
  <body>
    <div class="container">
        <form action="<?=URL ?>admin/Negocio/Login.php" method="post">

            <div class="login-box">
                <label for="uname"><b>Nome</b></label> <br>
                <input type="text" placeholder="Nome do usuário" name="nome" required>

                <br><br>

                <label for="psw"><b>Senha</b></label> <br>
                <input type="password" placeholder="Senha" name="senha" required>
                <br><br>
                <a href="../../index.php">Voltar</a>
                <button type="submit">Login</button>
                
            </div>
        </form> 
    </div>
  </body>
</html>
