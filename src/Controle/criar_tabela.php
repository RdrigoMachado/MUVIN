<?php
require_once("../Persistencia/BancoDeDados/BandoDeDados.php");
require_once("../Persistencia/Arquivos/PersistenciaDeEstruturas.php");
require_once("../Persistencia/Parser.php");
require_once("../config.php");


function registrarTabela($estruturaTabela)
{
    if (PersistenciaDeEstruturas::tabelaGenericaJaExiste($estruturaTabela["tabela"])) {
        print("ja existe");
        die();
        return false;
    }
    if (!PersistenciaDeEstruturas::adicionarNomeTabelaGenerica($estruturaTabela["tabela"])) {
        print("nao pode adicionar nome na lista");
        die();
        return false;
    }
    if (PersistenciaDeEstruturas::criarArquivoTabelaGenerica($estruturaTabela)) {

        return true;
    }

    PersistenciaDeEstruturas::removerRegistroTabelaGenerica($estruturaTabela["tabela"]);
    print("nao conseguiu criar arquivo");
    die();
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
    $estruturaTabela = Parser::criarEstruturaDaTabelaComBaseNoArrayHTML($_POST['tabela']);
    $queryTabela = Parser::criarComandoSQLDeCriacaoDeTabelaComBaseNaEstruturaDaTabela($estruturaTabela);

    if ($estruturaTabela == []) {
        header("Location: " . URL . "View/erro.php?erro=valores-invalidos");
        die();
    }

    if (!registrarTabela($estruturaTabela)) {
        header("Location: " . URL . "View/erro.php?erro=arquivo");
        die();
    }

    $bancoDeDados = new BancoDeDados();
    if ($bancoDeDados->criarTabela($queryTabela)) {
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