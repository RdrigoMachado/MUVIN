<?php
require_once("../Gerenciamento/gerenciador_de_banco_dados.php");
require_once("../Gerenciamento/gerenciador_de_arquivos.php");
require_once("../config.php");

class CriarTabela
{


    private function pegarNumeroFiltrado($nome_campo)
    {
        return filter_input(INPUT_POST, $nome_campo, FILTER_VALIDATE_INT);
    }

    private function pegarStringFiltrado($nome_campo)
    {
        return filter_input(INPUT_POST, $nome_campo, FILTER_SANITIZE_STRING);
    }

    private function tipoValido($tipo)
    {
        $tipos_validos = array("int", "varchar", "date", "float", "text", "chave_estrangeira");
        return in_array($tipo, $tipos_validos);
    }

    private function gerarCampoValido($indice)
    {
        $campo = array();
        $campo['nome'] = $this->pegarStringFiltrado('campo_nome' . $indice);
        $campo['tipo'] = $this->pegarStringFiltrado('campo_tipo' . $indice);

        //verifica se nome e tipo sao validos e deixa strings em caixa baixa
        if (!is_string($campo['nome']) || $campo['nome'] == "") {
            return [];
        }
        if (!is_string($campo['tipo']) || !$this->tipoValido($campo['tipo'])) {
            return [];
        }
        $campo['nome'] = strtolower($campo['nome']);
        $campo['tipo'] = strtolower($campo['tipo']);


        if ($campo['tipo'] == "varchar") {
            $tamanho = $this->pegarNumeroFiltrado('campo_tamanho' . $indice);
            if (!is_int($tamanho) || $tamanho < 1 || $tamanho > 255) {
                return [];
            } else {
                $campo['tamanho'] = $tamanho;
            }
        } elseif ($campo['tipo'] == "chave_estrangeira") {
            $tabela_referenciada = $this->pegarStringFiltrado('referencia' . $indice);
            if (!GerenciadorDeArquivos::tabelaJaExiste($tabela_referenciada)) {
                return [];
            }
            $campo['referencia'] = $tabela_referenciada;
        }
        return $campo;
    }

    //retorna array a estrutura da tabela
    private function criarEstrutura()
    {
        $esquema = array();

        //verifica se possui valor valido para numero de campos
        $qtd_campos = $this->pegarNumeroFiltrado('qtd_campos');
        if (!is_int($qtd_campos) || $qtd_campos < 1) {
            return [];
        }
        //verifica se possui valor valido para nome da tabela
        $esquema['tabela'] = $this->pegarStringFiltrado('tabela_nome');
        if (!is_string($esquema['tabela']) || $esquema['tabela'] == "") {
            return [];
        }
        $esquema['tabela'] = strtolower($esquema['tabela']);
        //criar opcao de selecionar no momento de criar
        $esquema['display'] = "id";
        //campo id do tipo chave primaria eh default
        $id['nome'] = "id";
        $id['tipo'] = "chave_primaria";
        $campos[] = $id;
        for ($indice = 1; $indice <= $qtd_campos; $indice++) {
            $campo = $this->gerarCampoValido($indice);
            if (empty($campo)) {
                return [];
            }
            $campos[] = $campo;
        }
        $esquema['campos'] = $campos;
        return $esquema;
    }

    private function criaQuery($estruturaTabela)
    {
        $nomeTabela = $estruturaTabela['tabela'];
        $campos = $estruturaTabela['campos'];

        $createTable = "CREATE TABLE " . $nomeTabela . " (";
        foreach ($campos as $campo) {
            $novo_campo = "";
            if ($campo['tipo'] == "chave_primaria") {
                $novo_campo = $campo['nome'] . " int AUTO_INCREMENT PRIMARY KEY";
            } elseif ($campo['tipo'] == "chave_estrangeira") {
                $novo_campo = $campo['nome'] . " int, FOREIGN KEY (" . $campo['nome'] . ") REFERENCES " .
                    $campo['referencia'] . "(id) ON DELETE CASCADE";
            } else {
                $novo_campo = $campo["nome"] . " " . $campo["tipo"];
                if ($campo['tipo'] == "varchar") {
                    $novo_campo = $novo_campo . "(" . $campo['tamanho'] . ")";
                }
            }
            $createTable = $createTable . $novo_campo . ", ";
        }
        $createTable = substr($createTable, 0, -2);
        return $createTable . ")";
    }

    private function registrarTabela($estruturaTabela)
    {
        $gerenciadorDeArquivos = new GerenciadorDeArquivos();
        if ($gerenciadorDeArquivos->tabelaJaExiste($estruturaTabela["tabela"]) == true) {
            return false;
        }
        if ($gerenciadorDeArquivos->adicionarNomeTabela($estruturaTabela["tabela"])) {
            if ($gerenciadorDeArquivos->criarArquivoTabela($estruturaTabela)) {
                return true;
            } else {
                $gerenciadorDeArquivos->removerNomeTabela($estruturaTabela["tabela"]);
                return false;
            }
        } else {
            return false;
        }
    }

    private function removerRegistroTabela($estruturaTabela)
    {
        $gerenciadorDeArquivos = new GerenciadorDeArquivos();
        $gerenciadorDeArquivos->removerNomeTabela($estruturaTabela["tabela"]);
        $gerenciadorDeArquivos->deletarArquivoTabela($estruturaTabela["tabela"] . ".txt");
    }

    public function criar()
    {
        $gerenciadorBD = new GerenciadorDeBancoDados();
        $estruturaTabela = $this->criarEstrutura();

        if ($estruturaTabela == []) {
            header("Location: " . URL . "View/erro.php?erro=valores-invalidos");
            die();
        }

        if (!$this->registrarTabela($estruturaTabela)) {
            header("Location: " . URL . "View/erro.php?erro=arquivo");
        } else {
            $queryTabela = $this->criaQuery($estruturaTabela);
            if ($gerenciadorBD->criarTabela($queryTabela)) {
                header("Location: " . URL . "View/sucesso.php");
            } else {
                $this->removerRegistroTabela($estruturaTabela);
                header("Location: " . URL . "View/erro.php?erro=bd");
            }
        }
        die();
    }
}

$criarTabela = new CriarTabela();
$criarTabela->criar();
