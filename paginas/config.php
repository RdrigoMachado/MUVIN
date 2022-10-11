<?php
//const URL = "https://www.ufrgs.br/museudeinformatica/admin/";
const URL = "../paginas/";
const URL_NEGOCIO = "../Negocio/";
const MENU_PRINCIPAL =
    '<div class="container p-3 my-3 bg-light text-dark rounded">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link"  href="'. URL .'criar_tipo.php">Criar Tipo</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link"  href="'. URL .'listar_tipos.php">Listar Tipos</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link"  href="'. URL .'criar_tabela.php">Criar Tabela<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link"  href="'. URL .'listar_tabelas.php">Listar Tabelas</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>';