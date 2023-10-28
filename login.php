<?php
require_once(realpath(__DIR__ . "/listar.php"));
require_once(realpath(__DIR__ . "/admin/Negocio/Componente.php"));

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Muvin</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/menu.css">
    <link rel="stylesheet" type="text/css" href="css/corpo.css">
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/linhaDoTempo.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/overlay.css">
    <link rel="stylesheet" type="text/css" href="css/slider.css">
    <link rel="stylesheet" type="text/css" href="css/tooltip.css">
    <script src="aviso.js"></script>


<body id="corpo" class="container">
    <section class="top">
        <div class="esquerda-menu">
            <img id="imgheader" src="imagens/logo.png">
        </div>
       


        <body>
            <br><br>

            <div class="login-box">
                <h2>Login</h2>
                <form>
                    <div class="user-box">
                        <input type="text" name="" required="">
                        <label>Username</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="" required="">
                        <label>Password</label>
                    </div>
                    <a href="index.php"> voltar </a>
                    <a href="index.php" onclick="exibirAlertaEVoltar();">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        Submit
                    </a>
                    
                </form>
            </div>


        </body>

</html>