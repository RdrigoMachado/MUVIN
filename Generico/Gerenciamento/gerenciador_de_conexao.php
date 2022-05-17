<?php

class GerenciadorDeConexao
{
    private $config;

    function __construct()
    {
        $this->config = parse_ini_file('db.ini');
    }

    public function abrirConexao(){

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

}