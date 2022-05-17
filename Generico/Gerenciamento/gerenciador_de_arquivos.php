<?php
const TABELAS = "../Arquivos/tabelas.txt";
class GerenciadorDeArquivos
{

    static public function tabelaJaExiste($nomeTabela)
    {
        $handle = fopen(TABELAS, "r");
        if ($handle) {
            while (($linha = fgets($handle)) !== false) {
                $aux = substr($linha, 0, -2);
                if ($aux == $nomeTabela) {
                    return true;
                }
            }
            fclose($handle);
        }
        return false;
    }

    public function adicionarNomeTabela($nomeTabela)
    {
        if (file_put_contents(TABELAS, $nomeTabela . PHP_EOL, FILE_APPEND | LOCK_EX) !== false) {
            return true;
        }
        return false;
    }

    public function removerNomeTabela($nomeTabela)
    {
        $conteudo = file_get_contents(TABELAS);
        $conteudo = str_replace($nomeTabela . PHP_EOL, "", $conteudo);
        if (file_put_contents(TABELAS, $conteudo, LOCK_EX) !== false) {
            return true;
        }
        return false;
    }

    public function criarArquivoTabela($esquema)
    {
        $nomeArquivo = $esquema["tabela"] . ".txt";
        if (file_put_contents("../Arquivos/" . $nomeArquivo, json_encode($esquema)) !== false) {
            return true;
        }
        return false;
    }

    public function deletarArquivoTabela($nome)
    {
        @unlink("../Arquivos/" . $nome);
    }

    static public function listarNomesTabelas()
    {
        $tabelas = array();

        $handle = fopen(TABELAS, "r");
        if ($handle) {
            while (($linha = fgets($handle)) !== false) {
                $aux = substr($linha, 0, -2);
                $tabelas[] = $aux;
            }
            fclose($handle);
        }
        return $tabelas;
    }

    public function recuperarEstruturaTabela($nomeTabela)
    {
        $nomeArquivo = $nomeTabela . ".txt";
        $arrayTabela = NULL;
        if ($this->tabelaJaExiste($nomeTabela) == false) {
            return false;
        }
        try {
            $arrayTabela = file_get_contents("../Arquivos/" . $nomeArquivo);
            return json_decode($arrayTabela, true);
        } catch (Exception $e) {
            return false;
        }
    }

}
