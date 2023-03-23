<?php
require_once(realpath(__DIR__ . "/../Persistencia/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Persistencia/BancoDeDados.php"));

class Componente{


    private static function campoDeveSerIgnorado($lista_ignorar, $campo)
    {
        foreach($lista_ignorar as $ignorar)
        {
            if($campo == $ignorar)
            {
                    return true;
            }
        }
        return false;
    }

    public static function gerarCamposFormulario($entidade, $vetor = '', $lista_ignorar = [])
    {
        $tipo = "";
        foreach ($entidade->getCampos() as $campo)
        {
            if(Componente::campoDeveSerIgnorado($lista_ignorar, $campo->getNome()))
            {
                continue;
            }
            if($campo->getTipo() == "chave_estrangeira")
            {
                Componente::criarCampoSelect( $campo->getNome(), $campo->getReferencia(), $campo->getValor(), $vetor);
            }
            elseif ($campo->getTipo() != "chave_primaria")
            {
                switch ($campo->getTipo())
                {
                    case 'int': case 'float':
                        $tipo = "number";
                        break;
                    case 'date':    
                        $tipo = "date";
                        break;
                    case 'ano':
                        $tipo = "ano";
                        break;
                    case 'text': case 'varchar': default:  
                        $tipo = "text";
                }
                Componente::imprimirCampo($tipo, $campo->getNome(), $campo->getValor(), $vetor);
            }
        }
    }

    public static function criarCampoSelect($nome, $tabelaReferencia, $selecionado = NULL, $vetor = '', $opcional = false)
    {
    
        $bancoDeDados = new BancoDeDados();
        $referencias = $bancoDeDados->listar($tabelaReferencia);

        $estruturaReferencia = GerenciadorDeEstruturas::recuperarEstrutura($tabelaReferencia);
        $display = $estruturaReferencia->getDisplay();
    
        if($vetor == '')
        {
            $campoSelect = '<label height="20">' . ucwords($nome) . '</label>
            <select class="form-select" name="' . $nome . '" ';
        }
        else
        {              
            $campoSelect = '<label height="20">' . ucwords($nome) . '</label>
            <select class="form-select" name="' . $vetor . '['. $nome . ']" ';
        }
        if(!empty($referencias))
        {
            $campoSelect = $campoSelect . '>
            ';
            if($opcional){
                $campoSelect .= '<option value="-1">Todos</option>';
            }
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
    
    
    private static  function imprimirCampo($tipo, $nome, $valorAtual = '', $vetor = '')
    {
        if($valorAtual != '')
        {
            $valorAtual = ' value="' . $valorAtual . '"';
        }
        $campo = '<label>' . ucwords($nome) . '</label>' .  PHP_EOL . '<input class="form-control" ';
        if($vetor == '')
        {
            $campo = $campo . 'name="' .  $nome . '" ';
        }
        else
        {
            $campo = $campo . 'name="' . $vetor . '[' .  $nome . ']" ';   
        }
        if($tipo == "ano") {
            $campo = $campo . 'type="number" min="1000" max="' . date("Y") . '"';
        }
        else if($tipo == "float")
        {
            $campo = $campo . 'type="' .$tipo . '" step=0.01';
        }
        else
        {
            $campo = $campo . 'type="' .$tipo . '" ';
        }
        print( $campo  . $valorAtual. '>');
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
            if(!isset($inputUsuario[$campo->getNome()])){
                continue;
            }
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

    public static function limparInputEspecifico($inputEspecifico, $tabela){
        $entidadeEstrutura = GerenciadorDeEstruturas::recuperarEstrutura($tabela);
        if($entidadeEstrutura == NULL)
        {
            return [];
        }
        $inputLimpo['campos']   = Componente::limpaEValidaTipoCampos($entidadeEstrutura, $inputEspecifico);
        return $inputLimpo;
    }



    private static function pegarValorDisplay($nome_tabela, $id)
    {
        $banco_de_dados = new BancoDeDados();

        $entidade = $banco_de_dados->visualizar($nome_tabela, $id);
        $display = $entidade->getDisplay();
        $campo_display = $entidade->getCampoEspecifico($display);
        return $campo_display->getValor();
    }

    public static function adminVisualizarCampos($campos)
    {
        echo "<table class='tabela'>";

        foreach($campos as $campo)
        {
            if($campo->getTipo() == "chave_estrangeira")
            {
                echo "<tr><th>" , ucwords(str_replace('_id', ' ', $campo->getNome())) , ":</th>";
                echo  "<td>", ucwords(str_replace('_', ' ', Componente::pegarValorDisplay($campo->getReferencia(), $campo->getValor()))) , "</td></tr>";
            }
            elseif($campo->getTipo() != "chave_primaria")

            {
                echo "<tr><th>" , ucwords(str_replace('_', ' ', $campo->getNome())) , ":</th>";

                echo "<td>" , ucwords(str_replace('_', ' ', $campo->getValor())) , "</td></tr>";
            }
           
         
            
        }
        echo "</table>";

    }



    public static function imprimirDadosComponente($id){
        $banco_de_dados = new BancoDeDados();
        $componente = $banco_de_dados->visualizar("componente", $id);
      
        $campo_referencia = $componente->getCampoEspecifico("tipo_id");
        $nome_especifico = Componente::pegarValorDisplay($campo_referencia->getReferencia(), $campo_referencia->getValor());
        
        $especifico = $banco_de_dados->listar($nome_especifico, 'componente_id="' . $id . '"');
        echo "<table class='tabela'>";
            $campos[] = $componente->getCampoEspecifico("tipo_id");
            Componente::visualizarCampos($campos);
            Componente::visualizarCampos($especifico[0]->getCampos());
            Componente::visualizarCampos($componente->getCampos(), array("tipo_id"));
        echo "</table>";
    }


    private static function visualizarCampos($campos, $pular = [])
    {
        foreach($campos as $campo)
        {
            if(in_array($campo->getNome(), $pular) ||
                $campo->getNome() == "ultima_atualizacao" || 
                $campo->getNome() == "criacao" ||
                $campo->getNome() == "cid" ||
                $campo->getNome() == "componente_id")
            {
                continue;
            }
            if($campo->getTipo() == "chave_estrangeira")
            {
                echo "<tr><th>" , ucwords(str_replace('_id', ' ', $campo->getNome())) , ":</th>";
                echo  "<td>", ucwords(str_replace('_', ' ', Componente::pegarValorDisplay($campo->getReferencia(), $campo->getValor()))) , "</td></tr>";
            }
            elseif($campo->getTipo() != "chave_primaria")

            {
                echo "<tr><th>" , ucwords(str_replace('_', ' ', $campo->getNome())) , ":</th>";

                echo "<td>" , ucwords(str_replace('_', ' ', $campo->getValor())) , "</td></tr>";
            }
        }
    }
}