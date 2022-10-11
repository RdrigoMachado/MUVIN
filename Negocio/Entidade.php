<?php
require_once("Campo.php");

class Entidade{

    private $nome;
    private $display = "id";
    private $campos = [];

   public function __construct($entidadeJSON = NULL)
   {
        if($entidadeJSON != NULL)
        {
            $arrayEntidade = json_decode($entidadeJSON, true);
            $this->nome = $arrayEntidade["tabela"];
            $this->display = $arrayEntidade["display"];
            $this->adicionarCampos($arrayEntidade["campos"]);
        }
    }

    /**
     * Recebe array de campos e cria objetos do tipo Campo e os adiciona a lista de campos da entidade
     */
    public function adicionarCampos($campos)
    {
        foreach($campos as $campo){
            $nome = $campo["nome"];
            $tipo = $campo["tipo"];
            $tamanho = isset($campo["tamanho"])? $campo["tamanho"] : NULL;
            $referencia = isset($campo["referencia"])? $campo["referencia"] : NULL;
            $valor = isset($campo["valor"])? $campo["valor"] : NULL;
            $this->adicionarCampo($nome, $tipo, $tamanho, $referencia, $valor);
        }
    }

    public function adicionarCampo($nome, $tipo, $tamanho = NULL, $referencia = NULL, $valor = NULL)
    {        
        try
        {
            $campo = new Campo($nome, $tipo, $tamanho, $referencia, $valor);
            $this->campos[] = $campo;
        }
        catch(Exception $e)
        {
            echo 'Exceção: ',  $e->getMessage(), "\n";
        }
    }

    /**
     * Recebe list de objs do tipo Campo e adiciona na lista de campos
     */
    public function adicionarNovosCampos($campos)
    {
        foreach($campos as $campo)
        {
            $this->adicionarNovoCampo($campo);
        }

    }

    /*
    *Recebe um obj do tipo Campo e adiciona na lista de campos
    */
    public function adicionarNovoCampo($campo)
    {
        $this->campos[] = $campo;
    }

    public function getCampos()
    {
        return $this->campos;
    }

    public function setNome($nome)
    {
        $this->nome = $this->filtrarString($nome);
    }

    public function getNome()
    {
        return $this->nome;
    }  
    
    public function getCampoEspecifico($nome_campo)
    {
        foreach($this->campos as $campo)
        {
            if($campo->getNome() == $nome_campo)
            {
                return $campo;
            }
        }
        return NULL;
    }

    public function setDisplay($display)
    {
        $this->display = $this->filtrarString($display);
    }

    public function getDisplay()
    {
        return $this->display;
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

    public function codificaParaJSON()
    {
        $arrayEstrutura["tabela"] = $this->nome;
        $arrayEstrutura["display"] = $this->display;
        $arrayEstrutura["campos"] = $this->gerarArrayCampos();
        return json_encode($arrayEstrutura);
    }

    private function gerarArrayCampos()
    {
        $campos = [];
        foreach($this->campos as $campo){
           $campos[] = $campo->toArray();
        }
        return $campos;
    }

}