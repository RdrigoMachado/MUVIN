<?php
require_once("Entidade.php");
require_once("Campo.php");
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");
require_once("../paginas/config.php");

const CHAVE_PRIMARIA = "chave_primaria";
const ID = "id";
const COMPONENTE_ID = "componente_id";
const CHAVE_ESTRANGEIRA = "chave_estrangeira";
const REFERENCIA = "componente";

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
        $campoLimpo["nome"] = str_replace(" ", "_", strtolower(filter_var($campo["nome"], FILTER_SANITIZE_STRING)));
        $campoLimpo["tipo"] = strtolower(filter_var($campo["tipo"], FILTER_SANITIZE_STRING));
        
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
    $inputLimpo["tabela"] = str_replace(" ", "_", strtolower(strtolower(filter_var($inputUsuario["tabela_nome"], FILTER_SANITIZE_STRING))));
    $inputLimpo['campos'] = limparCampos($inputUsuario["campos"]);
    
    return $inputLimpo;
}

function criarEntidade($inputUsuario)
{
    
    $inputLimpo = limparInputUsuario($inputUsuario);    
    
    $banco_de_dados = new BancoDeDados();
    
    $novo_tipo = GerenciadorDeEstruturas::recuperarEstrutura("tipo");
    $novo_tipo->setNome("tipo");
    $novo_tipo->setCampoEspecifico("nome", $inputLimpo["tabela"]);

    if($banco_de_dados->adicionar($novo_tipo) == -1){
        header("Location: " . URL . "listar_tipos.php?erro-adicionar-tipo");
        die();
    }
    $entidade = new Entidade();
    $entidade->setNome($inputLimpo["tabela"]);
    $entidade->adicionarCampo(ID, CHAVE_PRIMARIA);
    $entidade->adicionarCampos( $inputLimpo["campos"]);
    //Campo que liga com componente
    $entidade->adicionarCampo(COMPONENTE_ID, CHAVE_ESTRANGEIRA, NULL, REFERENCIA, NULL);
    
    GerenciadorDeEstruturas::adicionarEstrutura($entidade, $estrutura_de_tipo = true);
    $bd = new BancoDeDados();
    $banco_de_dados->criarTabela($entidade);
    
    header("Location: " . URL . "listar_tipos.php?");
    die();
}

criarEntidade($_POST);
