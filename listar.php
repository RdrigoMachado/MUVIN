<?php
require_once(realpath(__DIR__ . "/admin/Persistencia/BancoDeDados.php"));
require_once(realpath(__DIR__ . "/admin/Negocio/config.php"));

function listarComponentes($filtro = null)
{
  $banco_de_dados = new BancoDeDados();
  $componentes = $banco_de_dados->listar("componente", $filtro, 'ano_fabricacao');
  $lista_componentes = [];

  $ano = "";
  foreach ($componentes as $componente)
  {
    foreach ($componente->getCampos() as $campo)
    {
      
      $auxiliar[$campo->getNome()] =  $campo->getValor();
    }
    $imagens = pegarImagens($auxiliar["id"]);
    $auxiliar["imagem"] =  $imagens[0];
    $ano = $auxiliar["ano_fabricacao"];
    
    $lista_componentes[$ano][]= $auxiliar;
    unset($auxiliar);
    unset($imagens);
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
      $caminho = URL . "imagens/"
                  . $imagem->getCampoEspecifico("componente_id")->getValor() . "/"
                  . $imagem->getCampoEspecifico("nome")->getValor();
      $caminhos[] = $caminho;
  }
  return $caminhos;
}