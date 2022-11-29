<?php
require_once("../Persistencia/BancoDeDados.php");

function listarComponentes()
{
  $banco_de_dados = new BancoDeDados();
  $componentes = $banco_de_dados->listar("componente", NULL, 'ano_fabricacao');
  $lista_componentes = [];

  foreach ($componentes as $componente)
  {
    foreach ($componente->getCampos() as $campo)
    {
      $auxiliar[$campo->getNome()] =  $campo->getValor();
    }
    //$auxiliar["imagens"] = pegarImagens($auxiliar['id']);
    $lista_componentes[]= $auxiliar;
    unset($auxiliar);
  }
  return $lista_componentes;
}


function pegarInformacoes($id){
  $banco_de_dados = new BancoDeDados();
  $componente = $banco_de_dados->visualizar("componente", $id);
  $dados;
  
  foreach ($componente->getCampos() as $campo)
  {
    $dados[$campo->getNome()] =  str_replace('_', ' ', strtoupper($campo->getNome() . ": " . $campo->getValor()));
  }
  return $dados;
}

function pegarImagens($id){
  $caminhos = [];
  $banco_de_dados = new BancoDeDados();
  $filtro = "componente_id = " . $id;

  $imagens = $banco_de_dados->listar("imagem", $filtro);

  foreach($imagens as $imagem)
  {
      $caminho = "../Persistencia/imagens/"
                  . $imagem->getCampoEspecifico("componente_id")->getValor() . "/"
                  . $imagem->getCampoEspecifico("nome")->getValor();
      $caminhos[] = $caminho;
  }
  return $caminhos;
}