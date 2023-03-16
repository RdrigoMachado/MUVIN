<?php
require_once(realpath(__DIR__ . "/../admin/Negocio/config.php"));
?>
<section>
    <input type="checkbox" id="bt_menu" />
    <label for="bt_menu">&#9776;</label>
    <nav id="menu">
        <ul>
            <li><a href="index.php">Acessibilidade</a></li>
            <li><a onclick="document.getElementById('id02').style.display='block'" id="loginMenu">Filtro</a></li>
            <li><a href="#">Sobre</a>
                <ul>
                    <li><a href="#">Sub 1</a></li>
                    <li><a href="#">Sub 2</a></li>
                    <li><a href="#">Sub 3</a></li>
                </ul>
            </li>
            <li><a onclick="document.getElementById('id01').style.display='block'" id="loginMenu">Login</a></li>
        </ul>
    </nav>

    <div class="w3-container">

        <div id="id01" class="w3-modal">
            
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                <img src="img_avatar4.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
            </div>

            <form class="w3-container" method="POST" action="<?= URL?>admin/Negocio/Login.php">
                <div class="w3-section">
                <label><b>Username</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="nome" required>
                <label><b>Password</b></label>
                <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="senha" required>
                <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
                <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
                </div>
            </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
                <span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
            </div>

            </div>
    </div>
    <div class="w3-container">

        <div id="id02" class="w3-modal">
            
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

            <div class="w3-center"><br>
                <span onclick="document.getElementById('id02').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
            </div>
            
            <br><br>

            <form method="post" action="./index.php">        
            <?php 
                Componente::criarCampoSelect("pais", "pais", $pais, '', true);
                Componente::criarCampoSelect("fabricante", "fabricante", $fabricante, '', true);
                Componente::criarCampoSelect("tipo", "tipo", $tipo, '', true);
            ?> 
                <br><br>
                <button onclick="document.getElementById('id02').style.display='none' type="submit" value="Filtrar">Filtrar</button>
        </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('id02').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
                <span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
            </div>

            </div>
    </div>


</section>     