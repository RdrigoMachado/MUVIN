<?php
require_once(realpath(__DIR__ . "/GerenciadorDeEstruturas.php"));
require_once(realpath(__DIR__ . "/../Negocio/Entidade.php"));

class BancoDeDados
{

    protected $conexao;
    protected $query;
    public $lastId;
    private $config;


    function __construct()
    {
        $this->config = parse_ini_file('db.ini');
        $this->conexao = $this->abrirConexao();
        $this->query = new PDOStatement();
        $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->lastId = null;
    }

    /**
     * Abre a conexao com o banco de dados
     */
    private function abrirConexao()
    {
        try
        {
            $pdo = new PDO('mysql:host=' . $this->config["host"] . ';dbname='.$this->config["db"],
                                $this->config['username'], $this->config['password'],
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e)
        {
            //remover quando estiver no servidor, salvar em log ao inves de imprimir
            echo 'Error: ' . $e->getMessage();
            exit();
        }
        return $pdo;
    }

    function __destruct()
    {
        $this->conexao = null;
        $this->query = null;
    }

    public function criarTabela($entidade)
    {
        $this->query = $this->conexao->prepare($this->construirQueryCreate($entidade));
        try
        {
            return $this->query->execute();
        } 
        catch (Exception $e) 
        {
            return FALSE;
        }
    }

    private function construirQueryCreate($entidade)
    {
        $createTable = "CREATE TABLE " . $entidade->getNome() . " (";

        foreach ($entidade->getCampos() as $campo)
        {
            if ($campo->getTipo() == "chave_primaria")
            {
                $novo_campo = $campo->getNome() . " int AUTO_INCREMENT PRIMARY KEY";
                $createTable = $createTable . $novo_campo . ", ";
                continue;
            }
            if ($campo->getTipo() == "chave_estrangeira")
            {
                $novo_campo = $campo->getNome() . " int, FOREIGN KEY (" . $campo->getNome() . ") REFERENCES " .
                            $campo->getReferencia() . "(id) ON DELETE CASCADE";
                $createTable = $createTable . $novo_campo . ", ";
                continue;
            }

            $novo_campo = $campo->getNome() . " " . $campo->getTipo();
            if ($campo->getTipo() == "varchar")
            {
                $novo_campo = $novo_campo . "(" . $campo->getTamanho() . ")";
            }
            $createTable = $createTable . $novo_campo . ", ";
        }
        $createTable = substr($createTable, 0, -2);
        $createTable = $createTable . ")";
        return $createTable;
    }

    /**
     * Recupera entradas da tabela indicada
     * Retorno: lista de entidade preenchida com os valores das entradas da tabela equivalente indicada
     */
    public function listar($nome_tabela, $filtro = NULL, $order = NULL)
    {
        $entidades_recuperadas = [];
        $busca = "SELECT * FROM " . $nome_tabela;
        if( $filtro )
        {
            $busca = $busca . " WHERE " . $filtro;            
        }
        if( $order )
        {
            $busca = $busca . " ORDER BY " . $order;            
        }
        
        $estrutura_entidade = GerenciadorDeEstruturas::recuperarEstrutura($nome_tabela);
        if($estrutura_entidade == NULL)
        {
            $entidades_recuperadas;
        }

        try
        {
            $this->query = $this->conexao->prepare($busca);
            $this->query->execute();
        } 
        catch (Exception $e)
        {
            return $entidades_recuperadas;
        }
        
        
        $valores_recuperados = $this->query->fetchAll(PDO::FETCH_ASSOC);
        if($valores_recuperados == [])
        {
            return $entidades_recuperadas;
        }

        foreach($valores_recuperados as $valor_recuperado)
        {
            $entidades_recuperadas[] = $this->criarEntidadeComValorRecuperado($estrutura_entidade, $valor_recuperado);
        }
        return $entidades_recuperadas;
    }

    /**
     * Recebe uma estrutura de entidade o valor de uma entrada da tabela equivalente
     * Retorno: entidade preenchida com os valores da entrada do banco de dados
     */
    private static function criarEntidadeComValorRecuperado($estrutura_entidade, $valor_recuperado)
    {
        $nova_entidade = new Entidade();
        $nova_entidade->setNome($estrutura_entidade->getNome());
        $nova_entidade->setDisplay($estrutura_entidade->getDisplay());

        foreach ($estrutura_entidade->getCampos() as $campo)
        {
            $nova_entidade->adicionarCampo($campo->getNome(),
                                            $campo->getTipo(),
                                            (int) $campo->getTamanho(),
                                            $campo->getReferencia(),
                                            $valor_recuperado[$campo->getNome()]);
        }
        return $nova_entidade;
    }

    public function login($nome, $senha){
        
        $this->query = $this->conexao->query('SELECT * FROM usuario WHERE nome="'. $nome . '"');
        $usuario = $this->query->fetch(PDO::FETCH_ASSOC);
        return password_verify($senha, $usuario["senha"]);
        
        
    }
    
    /**
     * Recebe nome da tabela e id da entrada
     * Retorno: retorna entidade equivalente a tabela com os valores da entrada indicada
     */
    public function visualizar($nome_tabela, $id)
    {
        $entidade = GerenciadorDeEstruturas::recuperarEstrutura($nome_tabela);
        
        $this->query = $this->conexao->query("SELECT * FROM " . $nome_tabela . " WHERE id=". $id);
        $valor_recuperada = $this->query->fetch(PDO::FETCH_ASSOC);
        
        if($valor_recuperada == false)
        {
            return NULL;
        }
        
        $entidade_recuperada = new Entidade();
        $entidade_recuperada->setNome($nome_tabela);
        $entidade_recuperada->setDisplay($entidade->getDisplay());
        foreach ($entidade->getCampos() as $campo) 
        {
           
            $entidade_recuperada->adicionarCampo($campo->getNome(),
                                                $campo->getTipo(),
                                                $campo->getTamanho(),
                                                $campo->getReferencia(),
                                                $valor_recuperada[$campo->getNome()] );
                                                
        }
    
        return $entidade_recuperada;
    }

    /**
     * Recebe entidade preenchida com valore e adiciona nova entrada na tabela equivalente
     * Retorno: ultimo id inserido
     */
    public function adicionar($entidade)
    {
        $this->query = $this->conexao->prepare($this->construirQueryInsert($entidade));
        $this->vinculaValores($entidade);
        $this->query->execute();
        
        if($this->query->rowCount() > 0)
        {
            return $this->conexao->lastInsertId();
        }
        return -1;
    }

    /**
     * Remove entrada que possui id recebido na tabela indicada
     * retorna true se ao menos uma entrada for deletada e falso caso nenhuma tenha sido afetada
     */
    public function deletar($tabela, $id)
    {
        $this->query =  $this->conexao->prepare("DELETE FROM " . $tabela . " WHERE id=" . $id);
        $this->query->execute();
        
        if($this->query->rowCount() > 0)
        {
            return true;
        }
        return false;
    }    

    /**
     * Constroi codigo SQL de insercao com marcadores para bind PDO
     */
    private function construirQueryInsert($entidade)
    {
        $campos = "";
        $parametros = "";

        foreach ($entidade->getCampos() as $campo) 
        {
            if ($campo->getNome() != "id") 
            {
                $campos .= $campo->getNome() . ", ";
                $parametros .= ":" . $campo->getNome() . ", ";
            }
        }
        $campos = substr($campos, 0, -2);
        $parametros = substr($parametros, 0, -2);
        return "INSERT INTO " . $entidade->getNome() . " (" . $campos . ") VALUES (" . $parametros . ")";
    }

    /**
     * Recebe um entidade preenchida com valores e edita a tabela equivalente
     * retorna true se ao menos uma entrada foi atualizada e falso caso nenhuma tenha sido afetada
     */
    public function editar($entidade)
    {
        $this->query = $this->conexao->prepare($this->construirQueryUpdate($entidade));
        $this->vinculaValores($entidade, true);
        $this->query->execute();

        if($this->query->rowCount() > 0)
        {
            return true;
        }
        return false;
    }

      /**
     * Constroi codigo SQL de update com marcadores para bind PDO
     */
    private function construirQueryUpdate($entidade)
    {
        $campos = "";
        foreach ($entidade->getCampos() as $campo) 
        {
            if($campo->getNome() != "id")
            {
                $campos .= $campo->getNome(). "=:" . $campo->getNome() . ", ";
            }
        }
        $campos = substr($campos, 0, -2);
        $query = "UPDATE " . $entidade->getNome() . " SET " . $campos . " WHERE  id=:id ";  
        return $query;
    }

    /**
     * Vincula valores de uma entidade nos marcadores de bind PDO
     * respectivos
     */
    private function vinculaValores($entidade, $editar = false)
    {
        foreach ($entidade->getCampos() as $campo)
        {
            if ($campo->getNome() == "id")
            {
                if($editar)
                {
                    $this->query->bindValue(":" . $campo->getNome(), $campo->getValor()); 
                }
            }
            else
            {
                $this->query->bindValue(":" . $campo->getNome(), $campo->getValor());
            }
        }

    }

}
