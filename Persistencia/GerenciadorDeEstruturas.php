<?php
require_once("../Negocio/Entidade.php");

const ESTRUTURAS = __DIR__. "/estruturas.txt";
const TIPOS = __DIR__. "/tipos.txt";
const CAMINHO_ESTRUTURAS = __DIR__ . "/estruturas/";


class GerenciadorDeEstruturas
{

    private static function checaSeExisteNoArquivo($arquivo, $nome){
        $ponteiroArquivo = fopen($arquivo, "r");
        if (!$ponteiroArquivo) 
        {
            return false;
        }
        while (($linha = fgets($ponteiroArquivo)) !== false) {
            $nomeRegistrado = str_replace(array("\r", "\n"), '', $linha);
            if ($nomeRegistrado === $nome) {
                return true;
            }
        }
        return false;
    }

    public static function estruturaJaExiste($nome)
    {
        if(GerenciadorDeEstruturas::checaSeExisteNoArquivo(ESTRUTURAS, $nome) == true)
            return true;
        if(GerenciadorDeEstruturas::checaSeExisteNoArquivo(TIPOS, $nome) == true)
            return true;
       
        return false;
    }

    public static function adicionarEstrutura($entidade, $estrutura_de_tipo = false)
    {
        if(GerenciadorDeEstruturas::estruturaJaExiste($entidade->getNome()))
        {
           return false;
        }

        if(!GerenciadorDeEstruturas::adicionarRegistro($entidade->getNome(), $estrutura_de_tipo))
        {
            return false;
        }
        if(!GerenciadorDeEstruturas::criarArquivo($entidade))
        {
            GerenciadorDeEstruturas::removerRegistro($entidade->getNome());
            return false;

        }
        return true;
    }

    private static function adicionarTipo($nome)
    {
        if (file_put_contents(TIPOS, $nome . PHP_EOL, FILE_APPEND | LOCK_EX) !== false)
        {
            return true;
        }
        return false;
    }

    private static function adicionarTabela($nome)
    {
        if (file_put_contents(ESTRUTURAS, $nome . PHP_EOL, FILE_APPEND | LOCK_EX) !== false)
        {
            return true;
        }
        return false;
    }

    private static function adicionarRegistro($nome, $estrutura_de_tipo)
    {
        if($estrutura_de_tipo == true)
        {
           return GerenciadorDeEstruturas::adicionarTipo($nome);
        }
        else 
        {
            return GerenciadorDeEstruturas::adicionarTabela($nome);
        }
    }


    private static function removerRegistroTipo($nome)
    {
        $conteudo = file_get_contents(TIPOS);
        $conteudo = str_replace($nome . PHP_EOL, "", $conteudo);
        if (file_put_contents(TIPOS, $conteudo, LOCK_EX) !== false) {
            return true;
        }
        return false;
    }

    private static function removerRegistroTabela($nome)
    {
        $conteudo = file_get_contents(ESTRUTURAS);
        $conteudo = str_replace($nome . PHP_EOL, "", $conteudo);
        if (file_put_contents(ESTRUTURAS, $conteudo, LOCK_EX) !== false) {
            return true;
        }
        return false;
    }

    private static function removerRegistro($nome)
    {
        if(GerenciadorDeEstruturas::removerRegistroTipo)
        return true;
        if(GerenciadorDeEstruturas::removerRegistroTabela)
            return true;

        return false;
    }

    private static function criarArquivo($entidade)
    {
        $nomeArquivo = $entidade->getNome() . ".txt";
        if (file_put_contents(CAMINHO_ESTRUTURAS . $nomeArquivo, $entidade->codificaParaJSON()) !== false) 
        {
            return true;
        }
        return false;
    }

    public static function recuperarEstrutura($nome)
    {
        if (!GerenciadorDeEstruturas::estruturaJaExiste($nome) && $nome != "componente") {
            return NULL;
        }

        try {
            $nomeArquivo = $nome . ".txt";
            $arrayTabela = file_get_contents(CAMINHO_ESTRUTURAS . $nomeArquivo);
            return new Entidade($arrayTabela);
        } catch (Exception $e) {
            return NULL;
        }
    }


    /**
     * Listagem de nome de arquivos
     */

    public static function listarNomesTipos()
    {
        return GerenciadorDeEstruturas::listarEntradasArquivo(TIPOS);
    }

    public static function listarNomesEstruturas()
    {
        return GerenciadorDeEstruturas::listarEntradasArquivo(ESTRUTURAS);
    }

    private static function listarEntradasArquivo($arquivo)
    {
        $ponteiroArquivo = fopen($arquivo, "r");
        if (!$ponteiroArquivo)
        {
            return [];
        }
        
        $tabelas = [];
        while (($linha = fgets($ponteiroArquivo)) !== false)
        {
            $aux = str_replace(array("\r", "\n"), '', $linha);
            $tabelas[] = $aux;
        }
        
        fclose($ponteiroArquivo);
        return $tabelas;
    }

}
