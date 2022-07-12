<?php
require_once("../Persistencia/BancoDeDados/BandoDeDados.php");
require_once("../Persistencia/Arquivos/PersistenciaDeEstruturas.php");
require_once ("../config.php");

class Editar
{

    function __construct(){}
    public static function editar()
    {
        if (!isset($_POST['tabela']) || !isset($_POST['id']))
        {
            header("Location: " . URL . "View/erro.php?erro=editar");
            die();
        }

        $tabela = filter_var($_POST['tabela'], FILTER_SANITIZE_STRING);
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

        $gerenciadorArquivos = new PersistenciaDeEstruturas();
        $gerenciadorBD = new BancoDeDados();

        $estruturaTabela = $gerenciadorArquivos->recuperarEstruturaTabelaGenerica($tabela);
        if ($estruturaTabela == false)
        {
            header("Location: " . URL . "View/erro.php?erro=editar");
            die();
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

$editor = new Editar();
$editor->editar();
