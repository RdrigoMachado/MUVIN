<?php
require_once("../Persistencia/BancoDeDados.php");

function listarComponentes()
{
  $banco_de_dados = new BancoDeDados();
  $componentes = $banco_de_dados->listar("componente");
  $lista_componentes = [];

  foreach ($componentes as $componente)
  {
    foreach ($componente->getCampos() as $campo)
    {
      $auxiliar[$campo->getNome()] = $campo->getValor();
    }
    $lista_componentes[]= $auxiliar;
    unset($auxiliar);
  }
  return $lista_componentes;
}