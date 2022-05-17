<?php
require_once("gerenciador_de_conexao.php");
require_once("gerenciador_de_arquivos.php");


class GerenciadorDeBancoDados
{

    protected $conexao;
    protected $query;
    public $lastId;

    function __construct()
    {
        $handler = new GerenciadorDeConexao();
        $this->conexao = $handler->abrirConexao();
        $this->query = new PDOStatement();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->lastId = null;
    }

    function __destruct()
    {
        $this->conexao = null;
        $this->query = null;
    }

    public function criarTabela($queryTabela)
    {
        $this->query = $this->conexao->prepare($queryTabela);
        try {
            return $this->query->execute();
        } catch (Exception $e) {
            return FALSE;
        }
    }

    public function _listar($nomeTabela)
    {

        $query = "select * from " . $nomeTabela;
        $this->query = $this->conexao->prepare($query);
        try {
            $this->query->execute();
            return $this->query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return FALSE;
        }

    }

    public function listar($nomeTabela)
    {
        $gerenciadorArquivos = new GerenciadorDeArquivos();
        $estrutura = $gerenciadorArquivos->recuperarEstruturaTabela($nomeTabela);
        $resultados_cru = $this->_listar($nomeTabela);
        $resultados = [];
        if($resultados_cru == [] || $estrutura == []){
            return $resultados;
        }

        foreach($resultados_cru as $resultado_cru){
            $resultado = [];

            foreach ($estrutura["campos"] as $campo) {
                $campo["nome"] = $campo["nome"];
                $campo["valor"] = $resultado_cru[$campo["nome"]];
                $resultado[] = $campo;
            }
            $resultados[] = $resultado;

        }
        return $resultados;
    }

    public function _visualizar($nomeTabela, $id)
    {
        $query = "select * from " . $nomeTabela . " where id=". $id;
        $this->query = $this->conexao->prepare($query);
        try{
            $resultado  = $this->query->execute();
            return $this->query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e){
            return FALSE;
        }

    }

    public function visualizar($nomeTabela, $id)
    {
        $gerenciadorArquivos = new GerenciadorDeArquivos();
        $estrutura = $gerenciadorArquivos->recuperarEstruturaTabela($nomeTabela);
        $resultado_cru = $this->_visualizar($nomeTabela, $id);

        $resultado = [];
        if($resultado_cru == [] || $estrutura == []){
            return $resultado;
        }

        foreach ($estrutura["campos"] as $campo) {
            $campo["nome"] = $campo["nome"];
            $campo["valor"] = $resultado_cru[0][$campo["nome"]];
            $resultado[] = $campo;
        }
        return $resultado;
    }

    public function adicionar($estruturaTabela)
    {
        $this->query = $this->conexao->prepare($this->construirQueryInsert($estruturaTabela));
        $this->vinculaValores($estruturaTabela);
        $resultado = $this->query->execute();
        $this->lastId = $this->conexao->lastInsertId();
        return $resultado;
    }

    private function construirQueryInsert($estruturaTabela)
    {
        $campos = "";
        $parametros = "";
        foreach ($estruturaTabela["campos"] as $campo) {
            if ($campo != "id") {
                $campos .= $campo["nome"] . ", ";
                $parametros .= ":" . $campo["nome"] . ", ";
            }
        }
        $campos = substr($campos, 0, -2);
        $parametros = substr($parametros, 0, -2);
        return "INSERT INTO " . $estruturaTabela["tabela"] . " (" . $campos . ") VALUES (" . $parametros . ")";
    }

    public function editar($estruturaTabela)
    {
        $this->query = $this->conexao->prepare($this->construirQueryUpdate($estruturaTabela));
        $this->vinculaValores($estruturaTabela, true);
        return $this->query->execute();
    }

    private function construirQueryUpdate($estruturaTabela)
    {
        $campos = "";
        foreach ($estruturaTabela["campos"] as $campo) {
            if($campo["nome"] != "id"){
                $campos .= $campo["nome"]. "=:" .$campo["nome"]. ", ";
            }
        }
        $campos = substr($campos, 0, -2);
        $query = "UPDATE " . $estruturaTabela["tabela"] . " SET " . $campos . " WHERE  id=:id ";
        return $query;
    }

    private function vinculaValores($estruturaTabela, $bindId = false)
    {
        foreach ($estruturaTabela["campos"] as $campo) {
            $valor = $campo["valor"];
            if ($campo == "id") {
                if ($bindId)
                    $this->query->bindValue(":" . $campo["nome"], $valor);
            } else {
                if ($valor == null)
                    $tipo = PDO::PARAM_NULL;
                $this->query->bindValue(":" . $campo["nome"], $valor);
            }
        }
    }


}
