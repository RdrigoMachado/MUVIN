<?php
//define("URL", "https://www.ufrgs.br/museudeinformatica");
define("URL",  "https://localhost/Muvin/");
define("URL_PAGINAS",  URL . "admin/p/");
function adicionarMenu()
{
    echo ' 
        <section class="menu">
            <ul class="menu">
                <li class="menu-item"><a class="menu-item-link" href="'.URL_PAGINAS. 'consulta/listar_tipos.php"> Tabelas </a></li>
                <li class="menu-item"> Criação 
                    <ul class="submenu">
                        <li class="menu-item"><a class="menu-item-link" href="'.URL_PAGINAS. 'criacao/criar_novo_tipo.php"> Criar Novo Tipo </a></li>
                        <li class="menu-item"><a class="menu-item-link" href="'.URL_PAGINAS. 'criacao/listar_tipos.php"> Listar Tipos </a></li> 
                        <li class="menu-item"><a class="menu-item-link" href="'.URL_PAGINAS. 'criacao/criar_tabela_generica.php"> Criar Tabela Generica</a></li>
                    </ul>
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
        <link rel="stylesheet" href="../style/form.css">
        <link rel="stylesheet" href="../style/header.css">
    </head> ';
}