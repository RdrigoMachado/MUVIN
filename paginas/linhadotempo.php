<h1 id="anos_h1"></h1>


<div class="linha-tempo">



    <?php

    $anofinal = [];
    $anoinicial = [];

    foreach ($anos as $ano) {

        $anoFabricacao = $ano[0]["ano_fabricacao"];

        $anofinal[] = $anoFabricacao;
        $anoinicial[] = $anoFabricacao;

        echo "<div id='ano_fabric_$anoFabricacao' class='conteudotp'>";

        foreach ($ano as $componente) {
            echo '<div class="tooltip">';

            echo '<img class="tooltopimage" src="', $componente["imagem"], '" onclick="on(', $componente["id"], ')" >';

            echo '<span class="tooltiptext">', 'Modelo: ', $componente["modelo"],
                '<br>Ano: ', $componente["ano_fabricacao"],
                ' </span>';
            echo '</div>';
        }
        echo "</div>";
    }


    $anoinicial = min($anoinicial);
    $anofinal = max($anofinal);


    // Tratamento de erro para caso o ano inicial ou final não existam
    if ($anoinicial === null || $anofinal === null) {
        $anoinicial = 1980;
        $anofinal = 2000;
    }

    $anoinicial = $anoinicial - ($anoinicial % 10);


    // Impressão dos anos
    for ($i = $anoinicial; $i <= $anofinal; $i++) {

        $resto = $i % 10;

        if ($resto == 0) {
            echo "<div id='ano_$i' class='anostotais'><div class='text_center'>$i</div>";
        } else {
            echo "<div id='ano_$i' class='anostotais'><div class='text_center'></div>";
        }
        echo "<div class='tracinho' >l</div>";



        echo "</div>";

        $idade[] = "$i";
    }

    ?>



    <script>         /*         var linhaTempo = document.querySelector('.linha-tempo');
         linhaTempo.addEventListener("scroll", function() {
             // Obter o valor atual de scrollLeft             var scrollLeftValue = linhaTempo.scrollLeft;
             // Exibir o valor no console (você pode ajustar isso conforme necessário)             console.log("Posição da barra de rolagem: " + scrollLeftValue);

             document.getElementById("anos_h1").innerText = scrollLeftValue;
         });         */

        for (let i = 1925; i <= 2025; i++) {

            let con_anos = document.getElementById("ano_" + i); //pega o ano
            let con_tooltip = document.getElementById("ano_fabric_" + i); //pega o ano de fabric da tooltip





            // Verificando se ambos os elementos existem antes de tentar anexar
            if (con_anos && con_tooltip) {
                //exito

                // Adicionando div1 como um filho de div2
                con_anos.appendChild(con_tooltip);



            } else {
                //falha
            }


        }
    </script>

</div>