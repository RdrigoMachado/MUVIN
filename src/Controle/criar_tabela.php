<?php
require_once("../Gerenciamento/gerenciador_de_banco_dados.php");
require_once("../Gerenciamento/gerenciador_de_arquivos.php");
require_once("Parser.php");
require_once("../config.php");


function registrarTabela($estruturaTabela)
{
    $gerenciadorDeArquivos = new GerenciadorDeArquivos();
    if ($gerenciadorDeArquivos->tabelaJaExiste($estruturaTabela["tabela"]) == true) {
        return false;
    }
    if (!$gerenciadorDeArquivos->adicionarNomeTabela($estruturaTabela["tabela"])) {
        return false;
    }
    if ($gerenciadorDeArquivos->criarArquivoTabela($estruturaTabela)) {
        return true;
    }

    $gerenciadorDeArquivos->removerNomeTabela($estruturaTabela["tabela"]);
    return false;

}


function removerRegistroTabela($estruturaTabela)
{
    $gerenciadorDeArquivos = new GerenciadorDeArquivos();
    $gerenciadorDeArquivos->removerNomeTabela($estruturaTabela["tabela"]);
    $gerenciadorDeArquivos->deletarArquivoTabela($estruturaTabela["tabela"] . ".txt");
}


function criar()
{
    $estruturaTabela = Parser::parseHTMLArrayParaEstruturaTabela($_POST['tabela']);
    $queryTabela = Parser::parseEstruturaParaQuerySQL($estruturaTabela);

    if ($estruturaTabela == []) {
        header("Location: " . URL . "View/erro.php?erro=valores-invalidos");
        die();
    }

    if (!registrarTabela($estruturaTabela)) {
        header("Location: " . URL . "View/erro.php?erro=arquivo");
        die();
    }

    $gerenciadorBD = new GerenciadorDeBancoDados();
    if ($gerenciadorBD->criarTabela($queryTabela)) {
        header("Location: " . URL . "View/sucesso.php");
        die();
    }
    removerRegistroTabela($estruturaTabela);
    header("Location: " . URL . "View/erro.php?erro=bd");
    die();

}

criar();
//$estruturaTabela = Parser::parseHTMLArrayParaEstruturaTabela($_POST['tabela']);
//$novoCampo['nome'] = "teste";
//$novoCampo['tipo'] = 'int';
//print_r($estruturaTabela);
//print("<br>");
//print("<br>");
//print("<br>");
//$estruturaTabela = Parser::adicionarCampoEmEstruturaTabela($estruturaTabela, $novoCampo);
//print_r($estruturaTabela);