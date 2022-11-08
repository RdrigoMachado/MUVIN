<?php 
require_once("./listar.php");
$componentes = listarComponentes();

?>


<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Muvin</title>
		<meta charset="utf-8">
        <img  id="imgheader" src="imagens/logo.png">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" type="image/x-icon" href="imagens/favicon.ico">

		<link rel="stylesheet" type="text/css" href="css/menu.css">
		<link rel="stylesheet" type="text/css" href="css/corpo.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">        
		<link rel="stylesheet" type="text/css" href="css/linhaDoTempo.css">           
		<link rel="stylesheet" type="text/css" href="css/footer.css">                         
        <link rel="stylesheet" type="text/css" href="css/overlay.css">   
		<link rel="stylesheet" type="text/css" href="css/slider.css">  
		<link rel="stylesheet" type="text/css" href="css/tooltip.css">  
	</head>

    <body id="corpo">

        <?php require 'paginas/menu.php' ?>
<br><br><br><br>
<br><br><br><br>
                
        <div style="overflow-x: auto">
            
            <div class="conteudo">     
                   
                <div class="conteudoV">

                    <div id="o" onclick="off()"></div><!-- fecha o overlay-->
                        <div id="overlay" ><!-- cria uma pagina a frente -->
                            <div class="container">
                                <!-- imagens para o slide -->
                                <div class="content" style="max-width: 930px">
                                    <img class="mySlides" src="imagens/images1.jpg" style="height: 640px; width: 640px; display: block; margin-left: auto;margin-right: auto;">
                                    <img class="mySlides" src="imagens/images2.jpg" style="height: 640px; width: 640px; display: block; margin-left: auto;margin-right: auto;">
                                    <img class="mySlides" src="imagens/images3.jpg" style="height: 640px; width: 640px; display: block; margin-left: auto;margin-right: auto;">
                                </div>
                                
                                <div class="center">
                                    <div class="section">
                                        <!-- botoens para o slide -->
                                        <!-- chama as funções para passar o slide -->
                                        <div class="buttonSlide" onclick="plusDivs(-1)">❮ Prev</div>
                                        <div class="buttonSlide" onclick="plusDivs(1)">Next ❯</div>
                                    </div><br/>
                                    <!-- chama as funções para passar o slide pelos numeros -->
                                    <div class="pag demo" onclick="currentDiv(1)">01</div> 
                                    <div class="pag demo" onclick="currentDiv(2)">02</div> 
                                    <div class="pag demo" onclick="currentDiv(3)">03</div> 
                                </div>

                                <div class="texto">

                                </div>
                            </div>
                        </div>
                    </div>


            <?php 
                foreach($componentes as $componente)
                {
                    echo '<div class="conteudoV"><div class="tooltip">';

                    echo '<button onclick="on(' , $componente["id"], ')" type="button" class="button" ></button>';

                    echo '<span class="tooltiptext">', 'Modelo: ', $componente["modelo"] , '<br>Ano: ' , $componente["ano_fabricacao"] , ' </span>';

                    echo '</div> </div>';
                }
            ?>

                 
<br><br><br><br>

                
            </div>
        </div>
						
        

                            
      

        <script>
        //faz passar as imagens como "slide"
        var slideIndex = 1;
        showDivs(slideIndex);

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

        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="popper.min.js"></script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

        <script>
            //Abre e fecha o overlay da pagina
            function on() {
            document.getElementById("overlay").style.display = "block";
            document.getElementById("o").style.display = "block";
            document.getElementById("corpo").style.position = "fixed";
            }

            function off() {
            document.getElementById("overlay").style.display = "none";  
            document.getElementById("o").style.display = "none";        
            document.getElementById("corpo").style.position = "static";
            }
        </script>

        <?php require 'paginas/rodape.php' ?>
        
    </body>
</html>
