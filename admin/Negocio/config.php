<?php
//define("URL", "https://www.ufrgs.br/museudeinformatica");
define("URL",  "https://localhost/Muvin/");
define("URL_PAGINAS",  URL . "admin/p/");
function adicionarMenu()
{
    echo ' 
        <section class="menu">
            <img class="menu-img" src=" ' .URL_PAGINAS. 'img/logo.png" alt="">
            
            <ul class="menu-itens">
                <li class="menu-item">
                    <a class="menu-item-link" href="'.URL. 'index.php"> Inicio </a>
                </li>
        
                <li class="menu-item">
                    <a class="menu-item-link" href="'.URL_PAGINAS. 'listar_todas_tabelas.php"> Tabelas </a>
                </li>
                <li class="menu-item">
                    <a class="menu-item-link" href="'.URL_PAGINAS. 'criar_novo_tipo.php"> Criar Tipo </a>
                </li>
                <li class="menu-item">
                    <a class="menu-item-link" href="'.URL_PAGINAS. 'criar_nova_tabela.php"> Criar Tabela</a>
                </li>
            </ul>
        </section>';
}
   
function adicionarTitulo($titulo)
{
    echo '
    <head>
        <meta charset="utf-8">
        <title> ' . $titulo . ' </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./style/form.css">
        <link rel="stylesheet" href="./style/principal.css">
    </head> ';
}