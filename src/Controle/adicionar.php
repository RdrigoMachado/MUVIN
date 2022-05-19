<?php
require_once("../Gerenciamento/gerenciador_de_arquivos.php");
require_once("../Gerenciamento/gerenciador_de_banco_dados.php");
require_once("../config.php");

function checarSeTabelaExisteSeSimRetornaEstrutura()
{
    if (!isset($_POST['tabela'])) {
        header("Location: " . URL . "View/listar_tabelas.php?erro=tabela_nao_existe");
        die();
    }

    $tabela = filter_input(INPUT_POST, $_POST['tabela'], FILTER_SANITIZE_STRING);
    if (!is_string($tabela)) {
        header("Location: " . URL . "View/listar_tabelas.php?erro=tabela_nao_existe");
        die();
    }

    $gerenciadorArquivos = new GerenciadorDeArquivos();
    $estruturaTabela = $gerenciadorArquivos->recuperarEstruturaTabela(strtolower($tabela));
    if ($estruturaTabela == false) {
        header("Location: " . URL . "View/listar.php?tabela=" . $tabela . "&erro=arquivo");
        die();
    }
    return $estruturaTabela;
}

function populaEstruturaTabelaComValoresRecebidos($estruturaTabela)
{
    $novaEntrada["tabela"] = $estruturaTabela["tabela"];
    $novaEntrada["campos"] = [];
    foreach ($estruturaTabela["campos"] as $campo) {
        if (isset($_POST[$campo["nome"]])) {
            if ($campo["tipo"] == "int") {
                $valor = filter_input(INPUT_POST, $_POST[$campo["nome"]], FILTER_VALIDATE_INT);
            } else {
                $valor = filter_input(INPUT_POST, $_POST[$campo["nome"]], FILTER_SANITIZE_STRING);
            }
            $novoCampo["nome"] = $campo["nome"];
            $novoCampo["valor"] = $valor;
            $novaEntrada["campos"][] = $novoCampo;
        }
    }
    return $novaEntrada;
}


function adicionar()
{
    $gerenciadorBD = new GerenciadorDeBancoDados();
    $estruturaTabela = checarSeTabelaExisteSeSimRetornaEstrutura();
    $tabelaNome = $estruturaTabela["tabela"];

    $novaEntrada = populaEstruturaTabelaComValoresRecebidos($estruturaTabela);
    if ($gerenciadorBD->adicionar($novaEntrada)) {
        header("Location: " . URL . "View/listar.php?tabela=" . $tabelaNome);
        die();
    }
    header("Location: " . URL . "View/listar.php?tabela=" . $tabelaNome . "&erro=adicionar");
    die();
}

adicionar();