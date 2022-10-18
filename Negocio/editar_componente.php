<?php
require_once("../Persistencia/BancoDeDados.php");
require_once("Entidade.php");
require_once("Componente.php");
require_once("../paginas/config.php");

$inputEspecifico = null;
$inputComponente = null;
$tabela;
$id;
$componente_id;

/**
 * Recupera valores filtrados do componente e do tipo
 * caso não consiga pegar os dados de um deles redireciona para listar_componentes
 */
function recuperaValoresPostados()
{
    global $inputComponente, $inputEspecifico, $tabela, $id, $componente_id;

    $tabela   = filter_var($_POST["tabela"], FILTER_SANITIZE_STRING);
    $id = (int) filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $componente_id = (int) filter_var($_POST['componente_id'], FILTER_SANITIZE_NUMBER_INT);

    $inputEspecifico = Componente::limparInputEspecifico($_POST[$tabela], $tabela);
    $inputComponente = Componente::limparInputEspecifico($_POST['componente'], 'componente');

    if($inputEspecifico == [] || $inputComponente  == [] )
    {
        header("Location: " . URL . "listar_componentes.php?tabela=" . $inputLimpo["tabela"] . "&erro=editar");
    }

}

function criarEntidadeComDadosRecuperados($nome_tabela, $campos)
{
    $entidade = new Entidade();
    $entidade->setNome($nome_tabela);
    $entidade->adicionarNovosCampos($campos);
    return $entidade;
}

function editar()
{
    global  $inputComponente, $inputEspecifico, $tabela, $id, $componente_id;

    recuperaValoresPostados();

    $componente = criarEntidadeComDadosRecuperados("componente", $inputComponente["campos"]);
    $componente->adicionarCampo("id", "chave_primaria", NULL, NULL, $componente_id);
    $componente->adicionarCampo("ultima_atualizacao", "date", NULL, NULL, date('Y-m-d'));
    $componente->adicionarCampo("criacao", "date", NULL, NULL, date('Y-m-d'));

//     foreach($componente->getCampos() as $campo){
//         print_r($campo);
//         print("<br>");
//     }
// die();

    $tipo = criarEntidadeComDadosRecuperados($tabela, $inputEspecifico["campos"]);
    $tipo->adicionarCampo("id", "chave_primaria", NULL, NULL, $id);


    $banco_de_dados = new BancoDeDados();    
    $banco_de_dados->editar($tipo);
    $banco_de_dados->editar($componente);
    
    header("Location: " . URL . "visualizar_componente.php?tabela=" . $tabela . '&id=' . $id);
    die();
}

editar();
