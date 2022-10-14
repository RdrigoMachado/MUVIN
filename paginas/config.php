<?php
//const URL = "https://www.ufrgs.br/museudeinformatica/admin/";
const URL = "../paginas/";
const URL_NEGOCIO = "../Negocio/";
const MENU_PRINCIPAL =
   ' <header class="header">
        <section class="container header-container">
            <div class="header-logo">
                <img class="logo" src="./assets/img/logo.png" alt="Logo"> 
            </div>
            <ul class="menu">
                <li class="menu-item"><a class="menu-item-link" href="./criar_tipo.php"> Criar Tipo </a></li>
                <li class="menu-item"><a class="menu-item-link" href="./criar_tabela.php"> Criar Tabela </a></li>
                <li class="menu-item"><a class="menu-item-link" href="./listar_tabelas.php"> Tabelas </a></li>
                <li class="menu-item"><a class="menu-item-link" href="./listar_tipos.php"> Tipos </a></li> 
            </ul>
        </section>
    </header>';

function adicionarTitulo($titulo){
    echo '<head>
            <meta charset="utf-8">
            <title> ' . $titulo . '</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="./assets/css/style.css">
            <link rel="stylesheet" href="./assets/css/header.css">
            <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        </head>';
}