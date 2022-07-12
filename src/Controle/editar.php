<?php
require_once("../BancoDeDados/BandoDeDados.php");
require_once("../BancoDeDados/PersistenciaDeEstruturas.php");
require_once ("../config.php");

class Editar
{
    static public function editar()
    {
        $gerenciadorArquivos = new GerenciadorDeArquivos();
        $gerenciadorBD = new GerenciadorDeBancoDados();
        $estruturaTabela = [];
        $tabela = "";
        $id = -1;
        if (isset($_POST['tabela']) && isset($_POST['id']))
        {
        $tabela = filter_var($_POST['tabela'], FILTER_SANITIZE_STRING);
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

        $estruturaTabela = $gerenciadorArquivos->recuperarEstruturaTabela($tabela);
        if ($estruturaTabela == false)
        {
        redirecionar();
        }
        } else {
            redirecionar();
        }
        //filtrar
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

        if($gerenciadorBD->editar($novaEntrada))
        {
            header("Location: " . URL . "View/visualizar.php?tabela=" . $tabela . '&id=' . $id);

        } else {
            header("Location: " . URL . "View/listar.php?tabela=" . $tabela . "&erro=adicionar");
        }
        die();
    }
}

Editar::editar();
