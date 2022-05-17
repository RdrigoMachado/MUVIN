<?php
require_once("../Gerenciamento/gerenciador_de_arquivos.php");
require_once("../Gerenciamento/gerenciador_de_banco_dados.php");
require_once("../config.php");

class Adicionar{

    static public function adicionar(){
        $gerenciadorArquivos = new GerenciadorDeArquivos();
        $gerenciadorBD = new GerenciadorDeBancoDados();
        $estruturaTabela = [];
        $tabela = "";

        if (isset($_POST['tabela'])) {
            $tabela = filter_var($_POST['tabela'], FILTER_SANITIZE_STRING);
            $estruturaTabela = $gerenciadorArquivos->recuperarEstruturaTabela($tabela);
            if ($estruturaTabela == false) {
                header("Location: " . URL . "View/listar.php?tabela=" . $tabela . "&erro=arquivo");
                die();
            }
        } else {
            header("Location: " . URL . "View/listar_tabelas.php?erro=tabela_nao_existe");
            die();
        }

        $novaEntrada["tabela"] = $tabela;
        $novaEntrada["campos"] = [];
        foreach ($estruturaTabela["campos"] as $campo) {
            if (isset($_POST[$campo["nome"]])) {
                $valor = filter_var($_POST[$campo["nome"]], FILTER_SANITIZE_STRING);
                $novoCampo["nome"] = $campo["nome"];
                $novoCampo["valor"] = $valor;
                $novaEntrada["campos"][] = $novoCampo;
            }
        }

        if($gerenciadorBD->adicionar($novaEntrada))
        {
            header("Location: " . URL . "View/listar.php?tabela=" . $tabela);

        } else {
            header("Location: " . URL . "View/listar.php?tabela=" . $tabela . "&erro=adicionar");
        }
        die();
    }


}
Adicionar::adicionar();