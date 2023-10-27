<?php 
require_once(realpath(__DIR__ . "/listar.php"));
require_once(realpath(__DIR__ . "/admin/Negocio/Componente.php"));


    if(isset($_POST["pais"])){
        $pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_NUMBER_INT);
    }
    if(isset($_POST["fabricante"])){
        $fabricante = filter_input(INPUT_POST, 'fabricante', FILTER_SANITIZE_NUMBER_INT);
    }
    if(isset($_POST["tipo"])){
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);
    }

    $filtro = null;

    if(isset($pais) && $pais != -1){
        $filtro = "pais_id=" . $pais;
    } else {
        $pais = -1;
    }
    if(isset($fabricante) && $fabricante != -1)
    {
        if($filtro == null){ $filtro = "fabricante_id=" . $fabricante;}
        else{$filtro .= " AND fabricante_id=" . $fabricante;}
    } else {
        $fabricante = -1;
    }
    if(isset($tipo) && $tipo != -1)
    {
        if($filtro == null){ $filtro = "tipo_id=" . $tipo;}
        else{$filtro .= " AND tipo_id=" . $tipo;}
    } else {
        $tipo = -1;
    }

$anos = listarComponentes($filtro);

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Muvin</title>
		<meta charset="utf-8">
		

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  

		<link rel="stylesheet" type="text/css" href="css/menu.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">                 
		<link rel="stylesheet" type="text/css" href="css/footer.css">                         
        <link rel="stylesheet" type="text/css" href="css/overlay.css">   
		<link rel="stylesheet" type="text/css" href="css/slider.css">  
		<link rel="stylesheet" type="text/css" href="css/corpo.css">   
       
		<link rel="stylesheet" type="text/css" href="css/catalogo.css"> 
		<link rel="stylesheet" type="text/css" href="css/tooltipCatalogo.css">
        
	
		

	</head>

    <body id="corpo" class="container">
    <div class="container">
        <div class="top">
            <?php require 'paginas/menu.php' ?>
        </div>
  
        
        
</div>               

    </body>
</html>
