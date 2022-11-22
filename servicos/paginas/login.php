<!-- Utilizado para definir que este documento segue as regras de sintaxe do HTML 5 -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
		<title>Muvin</title>
		<meta charset="utf-8">
        <img  id="imgheader" src="../imagens/logo.png">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" type="image/x-icon" href="imagens/favicon.ico">

		<link rel="stylesheet" type="text/css" href="../css/menu.css">
		<link rel="stylesheet" type="text/css" href="../css/corpo.css">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">        
		<link rel="stylesheet" type="text/css" href="../css/linhaDoTempo.css">           
		<link rel="stylesheet" type="text/css" href="../css/footer.css">                         
        <link rel="stylesheet" type="text/css" href="../css/overlay.css">   
		<link rel="stylesheet" type="text/css" href="../css/slider.css">   
		<link rel="stylesheet" type="text/css" href="../css/login.css"> 
	</head>
	<body>
		
	<hr>
	<?php require './menu.php' ?>

		
		
		<form action="cadastrar.php" method="post">

		<div class="divlogin" >	

			<table  class="tabelalogin">		
				<thead>	
					<tr>				
						<td colspan="3" align="center"><h2>Login</h2></td>					
					</tr>				
					
					<br>
				</thead>			
				<tbody>	
					
					<tr>				
						<td align="right"><h3><label>Usuário:</label></h3></td>
						<td align="left"><input type="text" name="usuario" required></td>
								
					</tr>
					<tr>				
						<td align="right"><h3><label>Senha:</label></h3></td>
						<td align="left"><input type="password" name="senha" required ></td>
								
					</tr>
					
					
						
				</tbody>		
				<tfoot>	
					<tr>				
						<td colspan="2" align="right">
						
						<br>
						<input type="submit" align="center" value="Logar">
						</td>
									
					</tr>			
				</tfoot>	
			</table>

		</div>
		
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br>

		
		</form>	
		<hr>
		
		
		
		<?php require './rodape2.php' ?>
		
	</body>
</html>