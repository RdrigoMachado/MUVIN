<?php
const TABELAS_GENERICAS = "../Persistencia/Arquivos/tabelas_genericas.txt";
const TABELAS_ESPECIFICAS = "../Persistencia/Arquivos/tabelas_especificas.txt";
const CAMINHO_ESTRUTURAS_GENERICAS = "../Persistencia/Arquivos/EstruturasGenericas/";
const CAMINHO_ESTRUTURAS_ESPECIFICAS = "../Persistencia/Arquivos/EstruturasEspecificas/";


class PersistenciaDeEstruturas
{

    public static function tabelaGenericaJaExiste($nome)
    {
        return PersistenciaDeEstruturas::tabelaJaExiste($nome, TABELAS_GENERICAS);
    }

    public static function tabelaEspecificaJaExiste($nome)
    {
        return PersistenciaDeEstruturas::tabelaJaExiste($nome, TABELAS_ESPECIFICAS);
    }

    private static function nomeDeTabelaEstaRegistradoNoArquivo($nome, $ponteiroArquivo)
    {
        while (($linha = fgets($ponteiroArquivo)) !== false) {
            $nomeRegistrado = substr($linha, 0, -2);
            if ($nomeRegistrado === $nome) {
                return true;
            }
        }
        return false;
    }

    private static function tabelaJaExiste($nome, $arquivoDeRegistros)
    {
        $ponteiroArquivo = fopen($arquivoDeRegistros, "r");
        if (!$ponteiroArquivo) {
            return false;
        }
        $estaRegistado = PersistenciaDeEstruturas::nomeDeTabelaEstaRegistradoNoArquivo($nome, $ponteiroArquivo);
        fclose($ponteiroArquivo);
        return $estaRegistado;
    }

    public static function adicionarNomeTabelaGenerica($nome)
    {
        if (file_put_contents(TABELAS_GENERICAS, $nome . PHP_EOL, FILE_APPEND | LOCK_EX) !== false) {
            return true;
        }
        return false;
    }

    public static function adicionarNomeTabelaEspecifica($nome)
    {
        if (file_put_contents(TABELAS_ESPECIFICAS, $nome . PHP_EOL, FILE_APPEND | LOCK_EX) !== false) {
            return true;
        }
        return false;
    }

    private static function removerRegistroTabela($nome, $arquivoDeRegistros)
    {
        $conteudo = file_get_contents($arquivoDeRegistros);
        $conteudo = str_replace($nome . PHP_EOL, "", $conteudo);
        if (file_put_contents($arquivoDeRegistros, $conteudo, LOCK_EX) !== false) {
            return true;
        }
        return false;
    }

    public static function removerRegistroTabelaGenerica($nome)
    {
        return PersistenciaDeEstruturas::removerRegistroTabela($nome, TABELAS_GENERICAS);
    }

    public static function removerRegistroTabelaEspecifica($nome)
    {
        removerRegistroTabela($nome, TABELAS_ESPECIFICAS);
    }


    public static function criarArquivoTabelaGenerica($esquema)
    {
        return PersistenciaDeEstruturas::criarArquivoTabela($esquema, CAMINHO_ESTRUTURAS_GENERICAS);
    }

    public static function criarArquivoTabelaEspecifica($esquema)
    {
        return PersistenciaDeEstruturas::criarArquivoTabela($esquema, CAMINHO_ESTRUTURAS_ESPECIFICAS);
    }


    private static function criarArquivoTabela($esquema, $caminhoEstruturas)
    {
        $nomeArquivo = $esquema["tabela"] . ".txt";
        if (file_put_contents($caminhoEstruturas . $nomeArquivo, json_encode($esquema)) !== false) {
            return true;
        }
        return false;
    }


    public static function deletarArquivoTabelaGenerica($nome)
    {
        @unlink(CAMINHO_ESTRUTURAS_GENERICAS . $nome);
    }

    public static function deletarArquivoTabelaEspecifica($nome)
    {
        @unlink(CAMINHO_ESTRUTURAS_ESPECIFICAS . $nome);
    }


    private static function gerarArrayComNomesTabelasRegistradas($ponteiroArquivo)
    {
        $tabelas = array();

        while (($linha = fgets($ponteiroArquivo)) !== false) {
            $aux = substr($linha, 0, -2);
            $tabelas[] = $aux;
        }
        return $tabelas;
    }

    private static function listarNomesTabelas($arquivoDeRegistros)
    {
        $ponteiroArquivo = fopen($arquivoDeRegistros, "r");
        if (!$ponteiroArquivo) {
            return [];
        }
        $tabelas = PersistenciaDeEstruturas::gerarArrayComNomesTabelasRegistradas($ponteiroArquivo);
        fclose($ponteiroArquivo);
        return $tabelas;
    }


    public static function listarNomesTabelasGenericas()
    {
        return PersistenciaDeEstruturas::listarNomesTabelas(TABELAS_GENERICAS);

    }

    public static function listarNomesTabelasEspecificas()
    {
        return PersistenciaDeEstruturas::listarNomesTabelas(TABELAS_ESPECIFICAS);

    }


    public static function recuperarEstruturaTabelaGenerica($nome)
    {
        return PersistenciaDeEstruturas::recuperarEstruturaTabela($nome, CAMINHO_ESTRUTURAS_GENERICAS, TABELAS_GENERICAS);
    }

    public static function recuperarEstruturaTabelaEspecifica($nome)
    {
        return PersistenciaDeEstruturas::recuperarEstruturaTabela($nome, CAMINHO_ESTRUTURAS_ESPECIFICAS, TABELAS_ESPECIFICAS);
    }

    private static function recuperarEstruturaTabela($nome, $caminhoEstruturas, $arquivoDeRegistros)
    {

        if (!PersistenciaDeEstruturas::tabelaJaExiste($nome, $arquivoDeRegistros)) {
            return false;
        }
        try {
            $nomeArquivo = $nome . ".txt";
            $arrayTabela = file_get_contents($caminhoEstruturas . $nomeArquivo);
            return json_decode($arrayTabela, true);
        } catch (Exception $e) {
            return false;
        }
    }


}
