<div class="linha-tempo">

<div class="conteudo">



    <!-- Filtro -->
    <?php

    foreach ($anos as $ano) {
        echo '<div class="conteudoV">';

        foreach ($ano as $componente) {
            echo '<div class="tooltip">';

            echo '<img class="tooltopimage" src="',  $componente["imagem"], '" onclick="on(', $componente["id"], ')" >';

            echo '<span class="tooltiptext">', 'Modelo: ', $componente["modelo"],
            '<br>Ano: ', $componente["ano_fabricacao"],
            ' </span>';
            echo '</div><br>';
        }



        echo '<div class="anos">';
        echo $componente["ano_fabricacao"];
        echo '</div>';

        echo '</div>';
    }
    ?>

</div>
</div>