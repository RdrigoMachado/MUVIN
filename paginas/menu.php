<nav class="login-nav">
    <a href="admin/p/login.php">Login</a>
    </nav>

<section class="top">
    <div  class="esquerda-menu">
        <img  id="imgheader" src="imagens/logo.png">
    </div>
    <script src="aviso.js"></script>

    

    <nav class="menu">
        <ul>
            <li><a href="index.php" onclick="exibirAlertaEVoltar();">Contato</a></li>
            <li><a href="catalogo.php?pagina=1">Catalogo</a></li>
            <li><a onclick="document.getElementById('id02').style.display='block'">Filtro</a></li>
            <li><a href="index.php">Inicio</a></li>
        </ul>
    </nav>

    
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

                <button class="w3-button w3-green" onclick="document.getElementById('id02').style.display='none'" type="submit" value="Filtrar">Filtrar</button>

                <button onclick="document.getElementById('id02').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
                <br><br>
            </form>

            </div>
    </div>


</section>     