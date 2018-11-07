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
</head>
<body>

	<div class="container-fluid">
		<!--Menu-->

		<nav>
			
			<div class="row nav-bar">
				<div class="col-3"></div>
				<div class="col-6">
					<div class="logo">Source Code</div>
				</div>
				<div class="col-3">
					<a href="login.php"><input type="button" name="btn1" class="btn btn-outline-info btn-nav" value="Log In"></a>
				</div>

			</div>

		</nav>

		<!--Main content-->

		<main>
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6 main-posts">
					
					<?php 

						$con = new conexao("localhost","blog","root","");
						$con->selectIndex();


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