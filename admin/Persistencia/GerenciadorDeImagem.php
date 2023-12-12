<?php
const PASTAS_IMAGENS = __DIR__ . "/../../imagens/";

class GerenciadorDeImagem
{

    private static function criarPastaCasoNaoExista($id_componente)
    {
        if (!file_exists(PASTAS_IMAGENS . $id_componente)) {
            return mkdir(PASTAS_IMAGENS . $id_componente, 0777, true);
        }
        return true;
    }

    private static function salvarImagem($diretorio, $imagem)
    {
        return move_uploaded_file($imagem['tmp_name'], $diretorio . $imagem["name"] );
    }

    public static function adicionarImagem($id_componente, $imagem)
    {
        if(!GerenciadorDeImagem::criarPastaCasoNaoExista($id_componente))
        {
            return false;
        }

        if(!GerenciadorDeImagem::salvarImagem(PASTAS_IMAGENS . $id_componente . "/", $imagem))
        {
            return false;
        }

        return true;
    }
}