<?php 
require_once("./listar.php");
require_once("../Negocio/Componente.php");

    if(isset($_POST["pais"])){
        $pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_NUMBER_INT);
    }
    if(isset($_POST["fabricante"])){
        $fabricante = filter_input(INPUT_POST, 'fabricante', FILTER_SANITIZE_NUMBER_INT);
    }
    if(isset($_POST["tipo"])){
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);
    }

    $filtro = null;

    if(isset($pais) && $pais != -1){
        $filtro = "pais_id=" . $pais;
    } else {
        $pais = -1;
    }
    if(isset($fabricante) && $fabricante != -1)
    {
        if($filtro == null){ $filtro = "fabricante_id=" . $fabricante;}
        else{$filtro .= " AND fabricante_id=" . $fabricante;}
    } else {
        $fabricante = -1;
    }
    if(isset($tipo) && $tipo != -1)
    {
        if($filtro == null){ $filtro = "tipo_id=" . $tipo;}
        else{$filtro .= " AND tipo_id=" . $tipo;}
    } else {
        $tipo = -1;
    }

$anos = listarComponentes($filtro);


    
    

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Muvin</title>
		<meta charset="utf-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" type="text/css" href="css/menu.css">
		<link rel="stylesheet" type="text/css" href="css/corpo.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">        
		<link rel="stylesheet" type="text/css" href="css/linhaDoTempo.css">           
		<link rel="stylesheet" type="text/css" href="css/footer.css">                         
        <link rel="stylesheet" type="text/css" href="css/overlay.css">   
		<link rel="stylesheet" type="text/css" href="css/slider.css">  
		<link rel="stylesheet" type="text/css" href="css/tooltip.css">  
	</head>

    <body id="corpo" class="container">
   
    <img  id="imgheader" src="imagens/logo.png">
<div class="container">
    
        <?php require 'paginas/menu.php' ?>
        <br><br><br><br>
        <br><br><br><br>
        
        <form method="post" action="./index.php">        
            <?php 
                Componente::criarCampoSelect("pais", "pais", $pais, '', true);
                Componente::criarCampoSelect("fabricante", "fabricante", $fabricante, '', true);
                Componente::criarCampoSelect("tipo", "tipo", $tipo, '', true);
            ?> 
                <input type="submit" value="Filtrar">
        </form>

        <div style="overflow-x: auto">
            
            <div class="conteudo">     
                   
                <div class="conteudoV">
                    <div id="o" onclick="off()"></div><!-- fecha o overlay-->
                    <div id="overlay" ><!-- cria uma pagina a frente -->
                        <div class="container"></div>
                    </div>
                </div>


            <?php
                foreach($anos as $ano)
                {
                    echo '<div class="conteudoV">';
                    foreach($ano as $componente)
                    {
                        echo '<div class="tooltip">';

                        echo '<button onclick="on(' , $componente["id"], ')" type="button" class="button" ></button>';

                        echo '<span class="tooltiptext">', 'Modelo: ', $componente["modelo"] , '<br>Ano: ' , $componente["ano_fabricacao"] , ' </span>';

                        echo '</div>';
                    }
                    echo '</div>';

                }
            ?>

                 
<br><br><br><br>

                
            </div>
        </div>
						
        <?php require 'paginas/rodape.php' ?>
        
</div>
                            
      
        <script>
            

        </script>
     
        <script>
            //Abre e fecha o overlay da pagina
            function on(id) {
                document.getElementById("overlay").style.display = "block";
                document.getElementById("o").style.display = "block";
                document.getElementById("corpo").style.position = "fixed";
                carregaraInfos(id);
            }

            function off() {
            document.getElementById("overlay").style.display = "none";  
            document.getElementById("o").style.display = "none";        
            document.getElementById("corpo").style.position = "static";
            }



            async function fetchHtmlAsText(url) {
                return await (await fetch(url)).text();
            }

            // this is your `load_home() function`
            async function carregaraInfos(id) {
             
                const contentDiv = document.getElementById("overlay");
                contentDiv.innerHTML = await fetchHtmlAsText("info.php?id=" + id);
            }
        </script>
        <script>

        //faz passar as imagens como "slide"
        var slideIndex = 1;

        function plusDivs(n) {
        showDivs(slideIndex += n);
        }

        function currentDiv(n) {
        showDivs(slideIndex = n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            if (n > x.length) {slideIndex = 1}    
            if (n < 1) {slideIndex = x.length}
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";  
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" red", "");
                }
            x[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " red";
        }
        </script>
        
    </body>
</html>
