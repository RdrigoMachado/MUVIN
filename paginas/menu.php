<section class="top">
    <div  class="esquerda-menu">
        <img  id="imgheader" src="imagens/logo.png">
        <div class="titulo">
            <div class="nome-grande">
            MUVIN
            </div>
            <div class="nome-normal">
                Museu Virtual de Informática
            </div>    
        </div>    
    </div>
    
    <nav class="menu">
        <ul>
            <li><a href="catalogo.php">Sobre</a></li>
            <li><a href="catalogo.php">Outro</a></li>
            <li><a href="catalogo.php">Catalogo</a></li>
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
                <button onclick="document.getElementById('id02').style.display='none' type="submit" value="Filtrar">Filtrar</button>
        </form>

            <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                <button onclick="document.getElementById('id02').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
                
            </div>

            </div>
    </div>


</section>     