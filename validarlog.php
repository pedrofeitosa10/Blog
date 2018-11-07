<?php 

	session_start();

	require_once ('conexao.php');

	if (isset($_POST['entrar'])) {

		if(($_POST['nome'] != '')&&($_POST['senha'] != '')){
			$nome = $_POST['nome'];
			$senha = $_POST['senha'];

			$_SESSION['nome'] = $nome;
			$_SESSION['senha'] = $senha;

			$con = new conexao("localhost","blog","root","");
			$con->selectUser($nome,$senha);


		}else{
			session_destroy();
			header('Location: index.php');
		}

	}
?>