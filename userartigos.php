<?php 
	require_once ('conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Source Code</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">  
</head>
<body>

	<div class="container-fluid">
		<!--Menu-->

		<nav>
			
			<div class="row nav-bar">
				<div class="col-3">
					<div class="user-tip">
						<?php 
							echo "Ola ".$_SESSION['nome'];
						?>
					</div>
				</div>
				<div class="col-6">
					<div class="logo">Source Code</div>
				</div>
				<div class="col-3">
					
				</div>

			</div>

		</nav>

		<!--Main content-->

		<main>
			<div class="row">
				<div class="col-3 main-left">
					
					<a href="usercategoria.php"><button type="button" name="categoria">Categorias</button></a><br>
					<a href="userartigos.php"><button type="button" name="artigos">Artigos</button></a><br>
					<a href="logout.php"><button type="button" name="sair">Sair</button></a><br>

				</div>
				<div class="col-6 main-posts">
					
					<a href="novoartigo.php" id="ancoraIndex">Inserir novo artigo</a>
					<?php 

						$con = new conexao("localhost","blog","root","");
						$con->selectIndexUser();

					?>

				</div>
				<div class="col-3"></div>
			</div>

		</main>

		<!--Footer-->

		<footer>
			
		</footer>

	</div>

</body>
</html>