<?php
//define("URL", "https://www.ufrgs.br/museudeinformatica");
define("URL",  "https://localhost/Muvin/");
define("URL_PAGINAS",  URL . "admin/p/");
function adicionarMenu()
{
    echo ' 
    <header class="header">
        <section class="container header-container">
            <div class="header-logo">
                <img class="logo" src="./assets/img/logo.png" alt="Logo"> 
            </div>
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
        </section>
    </header>';
}
   
function adicionarTitulo($titulo)
{
    echo '
    <head>
        <meta charset="utf-8">
        <title> ' . $titulo . '</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./assets/css/style.css">
        <link rel="stylesheet" href="./assets/css/header.css">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    </head>';
}