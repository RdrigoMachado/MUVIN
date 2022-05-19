<?php

class Parser
{

    private static function gerarCampoIdPadrao()
    {
        $campo['nome'] = "id";
        $campo['tipo'] = "chave_primaria";
        return $campo;
    }

    private static function filtrarNumero($nome_campo)
    {
        return filter_var($nome_campo, FILTER_VALIDATE_INT);
    }

    private static function filtrarString($nome_campo)
    {
        $valorFiltrado = filter_var($nome_campo, FILTER_SANITIZE_STRING);
        if (is_string($valorFiltrado)) {

            $valorFiltrado = str_replace(" ", "_", strtolower($valorFiltrado));
        }
        return $valorFiltrado;
    }

    private static function isTipoValido($tipo)
    {
        $tipos_validos = array("int", "varchar", "date", "float", "text", "chave_estrangeira");
        return in_array(strtolower($tipo), $tipos_validos);
    }

    private static function gerarCampoValido($arraCampo)
    {
        $campo = array();
        $nome = Parser::filtrarString($arraCampo['nome']);
        $tipo = Parser::filtrarString($arraCampo['tipo']);

        //verifica se nome e tipo sao validos e deixa strings em caixa baixa
        if (!is_string($nome) || $nome === "") {
            return [];
        }
        if (!is_string($tipo) || !Parser::isTipoValido($tipo)) {
            return [];
        }
        $campo['nome'] = $nome;
        $campo['tipo'] = $tipo;


        if ($campo['tipo'] === "varchar") {
            $tamanho = Parser::filtrarNumero($arraCampo['tamanho']);
            if (!is_int($tamanho) || $tamanho < 1 || $tamanho > 255) {
                return [];
            } else {
                $campo['tamanho'] = $tamanho;
                return $campo;
            }
        }

        if ($campo['tipo'] == "chave_estrangeira") {
            $tabela_referenciada = Parser::filtrarString($arraCampo['referencia']);
            if (!GerenciadorDeArquivos::tabelaJaExiste($tabela_referenciada)) {
                return [];
            }
            $campo['referencia'] = $tabela_referenciada;
            return $campo;
        }
        return $campo;
    }

    public static function parseHTMLArrayParaEstruturaTabela($arrayHTML)
    {
        $qtd_campos = Parser::filtrarNumero($arrayHTML['qtd_campos']);
        $nomeTabela = Parser::filtrarString($arrayHTML['tabela_nome']);

        //verifica se possui valor valido para numero de campos
        if (!is_int($qtd_campos) || $qtd_campos < 1) {
            return [];
        }

        //verifica se possui valor valido para nome da tabela
        if (!is_string($nomeTabela) || $nomeTabela == "") {
            return [];
        }

        $esquema = array();
        $esquema['tabela'] = strtolower($nomeTabela);
        $esquema['display'] = "id";

        $campos[] = Parser::gerarCampoIdPadrao();

        for ($indice = 1; $indice <= $qtd_campos; $indice++) {
            $campo = Parser::gerarCampoValido($arrayHTML["campo" . $indice]);
            if (empty($campo)) {
                return [];
            }
            $campos[] = $campo;
        }
        $esquema['campos'] = $campos;
        return $esquema;
    }

    public static function adicionarCampoEmEstruturaTabela($estruturaTabela, $novoCampo)
    {
        $estruturaTabela['campos'][] = Parser::gerarCampoValido($novoCampo);
        return $estruturaTabela;
    }


    public static function parseEstruturaParaQuerySQL($estruturaTabela)
    {
        $nomeTabela = $estruturaTabela['tabela'];
        $campos = $estruturaTabela['campos'];

        $createTable = "CREATE TABLE " . $nomeTabela . " (";

        foreach ($campos as $campo) {

            if ($campo['tipo'] == "chave_primaria") {
                $novo_campo = $campo['nome'] . " int AUTO_INCREMENT PRIMARY KEY";
                $createTable = $createTable . $novo_campo . ", ";
                continue;
            }
            if ($campo['tipo'] == "chave_estrangeira") {
                $novo_campo = $campo['nome'] . " int, FOREIGN KEY (" . $campo['nome'] . ") REFERENCES " .
                    $campo['referencia'] . "(id) ON DELETE CASCADE";
                $createTable = $createTable . $novo_campo . ", ";
                continue;
            }

            $novo_campo = $campo["nome"] . " " . $campo["tipo"];
            if ($campo['tipo'] == "varchar") {
                $novo_campo = $novo_campo . "(" . $campo['tamanho'] . ")";
            }
            $createTable = $createTable . $novo_campo . ", ";
        }
        $createTable = substr($createTable, 0, -2);
        return $createTable . ")";
    }


}