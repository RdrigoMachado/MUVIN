<?php



/*

$idade = [];

for ($i = 1925; $i <= 2025; $i++) {

    echo "<div name='$i' class='$i'>$i</div>";

    $idade[] = "$i";
}
*/



?>

<h1 id="anos_h1"></h1>


<div class="linha-tempo">

    <div class="conteudo">



        <!-- Renderizar todos os anos de 1925 até 2025, fazer igual eu fiz na paginação, mas pegando um array com
    os anos totais, programar para que cada ano seja renderizado dentro da respectiva div que possuí o mesmo ano. 
estudar como branchs funcionam no git pq sendo sincero n sei se vai ficar legal.-->

        <?php


        foreach ($anos as $ano) {

            $x = json_encode($ano);

            $array_anos_fabricacao = json_decode($x, true);

            echo "<div name='" . $array_anos_fabricacao[0]["ano_fabricacao"] . "' class='conteudoV'>";

            foreach ($ano as $componente) {
                echo '<div class="tooltip">';

                echo '<img class="tooltopimage" src="',  $componente["imagem"], '" onclick="on(', $componente["id"], ')" >';

                echo '<span class="tooltiptext">', 'Modelo: ', $componente["modelo"],
                '<br>Ano: ', $componente["ano_fabricacao"],
                ' </span>';
                echo '</div><br>';
            }
            echo "</div>";
        }



        ?>



        <script>
            var linhaTempo = document.querySelector('.linha-tempo');

            linhaTempo.addEventListener("scroll", function() {

                // Obter o valor atual de scrollLeft
                var scrollLeftValue = linhaTempo.scrollLeft;

                // Exibir o valor no console (você pode ajustar isso conforme necessário)
                console.log("Posição da barra de rolagem: " + scrollLeftValue);


                document.getElementById("anos_h1").innerText = scrollLeftValue;

            });


            // Insere a div2 dentro da div1
        </script>

    </div>
</div>