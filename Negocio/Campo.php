<?php
require_once("../Persistencia/GerenciadorDeEstruturas.php");

class Campo{
    
    private $nome;
    private $tipo;
    private $tamanho = NULL;
    private $referencia = NULL;
    private $valor = NULL;

    function __construct($nome, $tipo, $tamanho = NULL, $referencia = NULL, $valor = NULL)
    {
        $this->setNome($nome);
        $this->setTipo($tipo);
        if($tamanho != NULL)
        {
            $this->setTamanho($tamanho);
        }
        if($referencia != NULL)
        {
            $this->setReferencia($referencia);
        }
        if($valor != NULL)
        {
            $this->setValor($valor);
        }
    }

    public function getNome()
    {
        return $this->nome;
    }
    
    public function getTipo()
    {
        return $this->tipo;
    }
    
    public function getTamanho()
    {
        return $this->tamanho;
    }
    
    public function getReferencia()
    {
        return $this->referencia;
    }
    
    public function getValor()
    {
        return $this->valor;
    }

    public function setNome($nome)
    {
        $nome = $this->filtrarString($nome);
        if($nome == NULL)
        {
            throw new Exception("Nome inválido");
        }
        $this->nome = $nome;
    }

    public function setTipo($tipo)
    {
        if(!$this->isTipoValido($tipo))
        {
            throw new Exception("Tipo informado não é valido");
        }
        $this->tipo = $tipo;
    }
    
    public function setTamanho($tamanho)
    {
        if(!is_int((int) $tamanho))
        {
            throw new Exception("Tamanho não é inteiro");
        }
        $this->tamanho = $tamanho;
    }

    public function setReferencia($referencia)
    {
        $referencia = $this->filtrarString($referencia);
        if($referencia == NULL)
        {
            throw new Exception("Referencia inválida");
        }
        if(!$this->existeReferencia($referencia))
        {
            echo $referencia;
            throw new Exception("Referencia inválida ");
        }
        $this->referencia = $referencia;
    }

    public function setValor($valor)
    {
        if($this->tipo == "int")
        {
            if(!is_int((int)$valor))
            {
                throw new Exception("Valor inválido");
            }
        }
        if($this->tipo == "float")
        {
            if(!is_float((float)$valor))
            {
                throw new Exception("Valor inválido");
            }
        }
        $this->valor = $valor;
    }

    private function filtrarString($atributo)
    {
        $valorFiltrado = str_replace(" ", "_", strtolower($atributo));
        if($valorFiltrado == NULL)
        {
            return NULL;
        }
        return $valorFiltrado;
    }

    private function isTipoValido($tipo)
    {
        $tipos_validos = array("int", "varchar", "date", "float", "text", "chave_primaria", "chave_estrangeira");
        if(in_array(strtolower($tipo), $tipos_validos))
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    private function existeReferencia($referencia)
    {
        return GerenciadorDeEstruturas::estruturaJaExiste($referencia) || $referencia == "componente";
    }

    public function toArray()
    {
        $arrayCampo["nome"] = $this->nome;
        $arrayCampo["tipo"] = $this->tipo;
        if($this->tamanho != NULL)
        {
            $arrayCampo["tamanho"] = $this->tamanho;
        }
        if($this->referencia != NULL)
        {
            $arrayCampo["referencia"] = $this->referencia;
        }
        return $arrayCampo;
    }

}