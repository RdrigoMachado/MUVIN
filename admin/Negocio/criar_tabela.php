<?php
require_once(realpath(__DIR__ . "/Entidade.php"));
require_once(realpath(__DIR__ . "/Campo.php"));
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/../config.php"));

const CHAVE_PRIMARIA = "chave_primaria";
const ID = "id";

/**
 * Filtra os valores dos campos fornecidos pelo usuario e gera um array com a mesma estrutura com os valores filtrados
 */
function limparCampos($campos)
{
    $camposLimpos = [];
    foreach($campos as $campo)
    {
        if(!isset($campo["nome"]) || !isset($campo["tipo"]))
        {
            return NULL;
        }
        $campoLimpo["nome"] = filter_var($campo["nome"], FILTER_SANITIZE_STRING);
        $campoLimpo["tipo"] = filter_var($campo["tipo"], FILTER_SANITIZE_STRING);
        
        if(isset($campo["tamanho"]))
        {
            $campoLimpo["tamanho"] = filter_var($campo["tamanho"], FILTER_SANITIZE_NUMBER_INT);
            $campoLimpo["tamanho"] = (int) ($campoLimpo["tamanho"]);
        }

        if(isset($campo["referencia"]))
        {
            $campoLimpo["referencia"] = filter_var($campo["referencia"], FILTER_SANITIZE_STRING);
        }
        
        $camposLimpos[] = $campoLimpo;
        unset($campoLimpo);
   }
   return $camposLimpos;
}

/**
 * Filtra os valores do input do usuario e gera um novo array com a mesma estrutura com os valores filtrados
 */
function limparInputUsuario($inputUsuario)
{
    if(!isset($inputUsuario["tabela_nome"]) || !isset($inputUsuario["campos"]))
    {
        throw new Exception("Dados necessários não foram fornecidos");
    }
    $inputLimpo["tabela"] = filter_var($inputUsuario["tabela_nome"], FILTER_SANITIZE_STRING);
    $inputLimpo['campos'] = limparCampos($inputUsuario["campos"]);
    
    return $inputLimpo;
}

function criarEntidade($inputUsuario)
{
    $inputLimpo = limparInputUsuario($inputUsuario);    
    $entidade = new Entidade();
    $entidade->setNome($inputLimpo["tabela"]);
    $entidade->adicionarCampo(ID, CHAVE_PRIMARIA);
    $entidade->adicionarCampos( $inputLimpo["campos"]);
    
    GerenciadorDeEstruturas::adicionarEstrutura($entidade);
    $bd = new BancoDeDados();
    $bd->criarTabela($entidade);
    
    header("Location: " . URL . "listar_tabelas.php?");
    die();
}

criarEntidade($_POST);
