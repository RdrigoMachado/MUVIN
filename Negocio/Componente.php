<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");
require_once("../Persistencia/BancoDeDados.php");

class Componente{


    public static function gerarCamposFormulario($entidade)
    {
        $tipo = "";
        foreach ($entidade->getCampos() as $campo)
        {
            if($campo->getTipo() == "chave_estrangeira")
            {
                Componente::criarCampoSelect( $campo->getNome(), $campo->getReferencia(), $campo->getValor());
            }
            elseif ($campo->getTipo() != "chave_primaria")
            {
                switch ($campo->getTipo())
                {
                    case 'int': case 'float':
                        $tipo = "number";
                        break;
                    case 'text': case 'varchar':
                        $tipo = "text";
                        break;
                    case 'date':
                        $tipo = "date";
                        break;
                }
                Componente::criarCampoComTipo($tipo, $campo->getNome(), $campo->getValor());
            }
        }
    }

    private static function criarCampoSelect($nome, $tabelaReferencia, $selecionado = NULL)
    {
    
        $bancoDeDados = new BancoDeDados();
        $referencias = $bancoDeDados->listar($tabelaReferencia);

        $estruturaReferencia = GerenciadorDeEstruturas::recuperarEstrutura($tabelaReferencia);
        $display = $estruturaReferencia->getDisplay();
    
        $campoSelect = '<label height="20">' . ucwords($nome) . '</label>
            <select class="form-select" name="' . $nome . '" ';
        if(!empty($referencias))
        {
            $campoSelect = $campoSelect . '>
            ';
            foreach($referencias as $referencia)
            {   
                $valor = Componente::procurarCampoPorNome("id", $referencia->getCampos());
                $label = Componente::procurarCampoPorNome($display, $referencia->getCampos());
                $campoSelecionado = "";
                if ($valor->getValor() == $selecionado) 
                {
                    $campoSelecionado = ' selected';
                }
               
                $campoSelect = $campoSelect . '
                 <option value="' . $valor->getValor() . '"' . $campoSelecionado . '>' . ucwords($label->getValor()) . '</option>';
            }
        }
        else 
        {
            $campoSelect = $campoSelect . ' disabled >';
        }
        print($campoSelect . '
            </select>');
    }
    
    
    private static  function criarCampoComTipo($tipo, $nome, $valorAtual = '')
    {
        if($valorAtual != '')
        {
            $valorAtual = ' value="' . $valorAtual . '"';
        }
        $campo = '<label>' . ucwords($nome) . '</label>
         <input class="form-control" name="' . $nome . '" type="' .$tipo . '" ' . $valorAtual;
        if($tipo == "float")
        {
            $campo = $campo . 'step=0.01';
        }
        print( $campo . '>
        ');
    }

    private static  function procurarCampoPorNome($nomeCampo, $campos)
    {
        foreach ($campos as $campo) 
        {
            if ($campo->getNome() === $nomeCampo) 
            {
                return $campo;
            }
        }
        return null;
    }

    /**
     * Filtra os valores dos campos fornecidos pelo usuario e gera um array com a mesma estrutura com os valores filtrados
     */
    private static function limpaEValidaTipoCampos($entidadeEstrutura, $inputUsuario)
    {
        $camposLimpos = [];
        foreach($entidadeEstrutura->getCampos() as $campo)
        {
           switch($campo->getTipo())
            {
                case 'int':
                case 'chave_primaria':
                case 'chave_estrangeira':
                    if(isset($inputUsuario[$campo->getNome()])){
                        $campo->setValor((int) filter_var($inputUsuario[$campo->getNome()], FILTER_SANITIZE_NUMBER_INT));
                    }
                    break;
                case 'float':
                    $campo->setValor((float) filter_var($inputUsuario[$campo->getNome()], FILTER_SANITIZE_NUMBER_FLOAT));
                    break;
                default :
                    $campo->setValor((string) filter_var($inputUsuario[$campo->getNome()], FILTER_SANITIZE_STRING));
                    break;
            }     
            $camposLimpos[] = $campo;
        }  
    
        return $camposLimpos;
    }

    /**
     * Filtra os valores do input do usuario e gera um novo array com a mesma estrutura com os valores filtrados
     */
    public static function limparInputUsuario($inputUsuario)
    {
        $inputLimpo["tabela"]   = filter_var($inputUsuario["tabela"], FILTER_SANITIZE_STRING);
        $entidadeEstrutura = GerenciadorDeEstruturas::recuperarEstrutura($inputLimpo["tabela"]);
        if($entidadeEstrutura == NULL)
        {
            return [];
        }
        $inputLimpo['campos']   = Componente::limpaEValidaTipoCampos($entidadeEstrutura, $inputUsuario);
        return $inputLimpo;
    }


}