<?php
require_once(realpath(__DIR__ . "/Entidade.php"));
require_once(realpath(__DIR__ . "/Campo.php"));
require_once(realpath(__DIR__ . "/config.php"));
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));

const CHAVE_PRIMARIA = "chave_primaria";
const ID = "id";
const COMPONENTE_ID = "componente_id";
const CHAVE_ESTRANGEIRA = "chave_estrangeira";
const REFERENCIA = "componente";

class Formulario{

    
    /**
     * Filtra os valores dos campos fornecidos pelo usuario e gera um array com a mesma estrutura com os valores filtrados
     */
    private static function limparCampos($campos)
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
    public static function limparInputUsuario($inputUsuario)
    {
        if(!isset($inputUsuario["tabela_nome"]) || !isset($inputUsuario["campos"]))
        {
            throw new Exception("Dados necessários não foram fornecidos");
        }
        $inputLimpo["tabela"] = str_replace(" ", "_", strtolower(strtolower(filter_var($inputUsuario["tabela_nome"], FILTER_SANITIZE_STRING))));
        $inputLimpo['campos'] = Formulario::limparCampos($inputUsuario["campos"]);
        
        return $inputLimpo;
    }

    public static function criarTipo($tipo_nome)
    {
        if($tipo_nome == "")
        {
            return false;
        }
        
        $novo_tipo = GerenciadorDeEstruturas::recuperarEstrutura("tipo");
        $novo_tipo->setNome("tipo");
        $novo_tipo->setCampoEspecifico("nome", $tipo_nome);
        
        $banco_de_dados = new BancoDeDados();
        if($banco_de_dados->adicionar($novo_tipo) == -1){
            return false;
        }
        return true;
    }

    public static function criarEntidade($inputLimpo, $novo_componente = true)
    {   
        $banco_de_dados = new BancoDeDados();
        
        $entidade = new Entidade();
        $entidade->setNome($inputLimpo["tabela"]);
        $entidade->adicionarCampo(ID, CHAVE_PRIMARIA);
        $entidade->adicionarCampos( $inputLimpo["campos"]);
        if($novo_componente)
        {
            $entidade->adicionarCampo(COMPONENTE_ID, CHAVE_ESTRANGEIRA, NULL, REFERENCIA, NULL);
        }
        
        if(!GerenciadorDeEstruturas::adicionarEstrutura($entidade, $novo_componente))
        {
            return false;
        }
        if(!$banco_de_dados->criarTabela($entidade))
        {
            GerenciadorDeEstruturas::removerEstrutura($entidade, $novo_componente);
            return false;
        }
        return true;
    }

}