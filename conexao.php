<?php 

	session_start();
	header("Content-Type: text/html; charset=ISO-8859-1",true);

	class conexao {


		private $con = '';
		private $host = '';
		private $db = '';
		private $user = '';
		private $pass = '';


		public function __construct($host,$db,$user,$pass){
			$this->host = $host;
			$this->db = $db;
			$this->user = $user;
			$this->pass = $pass;

			$this->con = new PDO("mysql:host=".$host.";dbname=".$db.";",$user,$pass);



		}

		public function selectIndex(){

			$sql = "SELECT * FROM artigo ORDER BY cod DESC";
			$stmt = $this->con->prepare($sql);
			$stmt->execute();


			while ($row = $stmt->fetch()) {
			
				echo "<div class='box'><p><h1><div class='titulo'>".$row['titulo']."</div></h1></p><div class='description'>".$row['descricao']."</div>";
				echo '<br><br><a id="ancoraIndex" href="view.php?cod='.$row['cod'].'">Leia mais</a><br><br></div>';

			}
		}

		public function selectView(){

			$aux = $_GET['cod'];
			$sql = "SELECT * FROM artigo WHERE cod = ".$aux;
			$stmt = $this->con->prepare($sql);
		    $stmt->execute();

		    //Aqui começa as querys que irão achar o nome da categoria

		    $cod = 0;
		    $sql2 = "SELECT cod_cat FROM artigo WHERE cod = ".$aux;
		    $stmt2 = $this->con->prepare($sql2);
		    $stmt2->execute();

		    while($row2 = $stmt2->fetch()){
		    	$cod = $row2['cod_cat'];
		    }

		    $nomeCategoria = '';
		    $sql3 = "SELECT nome FROM categoria WHERE cod_cat = ".$cod;
		    $stmt3 = $this->con->prepare($sql3);
		    $stmt3->execute();

		    while($row3 = $stmt3->fetch()){
		    	$nomeCategoria = $row3['nome'];
		    }

		    //aqui termina

			while ($row = $stmt->fetch()) {

			echo "<p><h1><div class='title-view'>".$row['titulo']."</div></h1></p><div class='categoria'><p>Categoria: ".$nomeCategoria."</p></div><div class='content'><p>".$row['conteudo']."</p></div>";
			echo "<br><br><a id='btnVoltar' href='index.php'>Voltar</a>";

			}

		}

		//codigo do usuario. Esta parte é responsável por mosrar as telas dos usuários logados

		public function selectIndexUser(){

			$sql = "SELECT * FROM artigo ORDER BY cod DESC";
			$stmt = $this->con->prepare($sql);
			$stmt->execute();


			while ($row = $stmt->fetch()) {
			
				echo "<div class='box'><p><h1><div class='titulo'>".$row['titulo']."</div></h1></p><div class='description'>".$row['descricao']."</div>";
				echo '<br><br><a id="ancoraIndex" href="userview.php?cod='.$row['cod'].'">Editar</a><br><br></div>';

			}
		}

		public function selectUser($nome,$senha){

			$sql = "SELECT senha FROM usuario WHERE senha = ".$senha;

			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			$contador = 0;

			while ($row = $stmt->fetch()) {
				if($row['senha'] == $senha){
					$contador++;
				}
			}
			if($contador > 0){
				header('Location: userarea.php');
			}else{

				session_destroy();
				header('Location: index.php');
			}
		}

		

		public function selectViewUser(){

			$aux = $_GET['cod'];
			$sql = "SELECT * FROM artigo WHERE cod = $aux";
			$sql2 = "SELECT * FROM categoria";

			$stmt2 = $this->con->prepare($sql);
		    $stmt2->execute();
		    
		    //Código pra mostrar a categoria

		    $stmt3 = $this->con->prepare($sql2);
		    $stmt3->execute();
		    $res = $stmt3->fetchAll();

		    ?>
		    <form method="post" id="editForm">

			    <?php
			    foreach($res as $item){

			    	echo $item['nome'].": <input type='radio' name='categoria' value='".$item['nome']."'><br>";
			  	}

			  	echo "<br>";

			    
				while ($row = $stmt2->fetch()) {

					echo "<div class='textoUm'><input type='text' value='".$row['titulo']."' name='titulo'></div><br><br>";

					echo "<div class='textoUm'><input type='text' value='".$row['descricao']."' name='descricao'></div><br><br>";

					echo "<textarea rows='10' cols='67' form='editForm' name='corpoTexto'>".$row['conteudo']."</textarea><br><br>";

				}
			?>
				<input type="submit" name="salvar" value="salvar">&nbsp&nbsp
				<input type="submit" name="excluir" value="excluir"><br><br><br>
			</form>

			<?php

				if(isset($_POST['salvar'])){

					$titulo = $_POST['titulo'];
					$descricao = $_POST['descricao'];
					$categoria = $_POST['categoria'];
					$conteudo = $_POST['corpoTexto'];

					//codigo para achar o id da categoria na tabela categoria para passar na query 4

					$sql3 = "SELECT cod_cat FROM categoria WHERE nome = '".$categoria."'";
					$stmt4 = $this->con->prepare($sql3);
					$stmt4->execute();
					$codigo = 0;
					var_dump($stmt4);

					while($row3 = $stmt4->fetch()){
						$codigo = $row3['cod_cat'];
					}
				

					$sql4 = "UPDATE artigo SET titulo = '".$titulo."', descricao = '".$descricao."', conteudo = '".$conteudo."', cod_cat = ".$codigo." WHERE cod = ".$aux;

					$stmt5 = $this->con->prepare($sql4);
					$stmt5->execute();
					var_dump($stmt5);
					header('Location: userartigos.php');

				}
				if(isset($_POST['excluir'])){

					$sql5 = "DELETE FROM artigo WHERE cod = ".$aux;
					$stmt6 = $this->con->prepare($sql5);
					$stmt6->execute();
					header("Refresh: 0; url=userartigos.php");

				}

		}

		public function novoArtigo(){

			$sql = "SELECT * FROM categoria";
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			$res = $stmt->fetchAll();

			?>
				<form method="POST" id="novoArt">

					<?php
					foreach($res as $item){

						echo $item['nome'].": <input type='radio' name='categoria' value='".$item['nome']."'><br>";
					}
					?>
					<br>

					<input type="text" name="titulo" placeholder="Titulo" class="textoUm"><br><br>
					<input type="text" name="descricao" placeholder="Descricao"><br><br>
					<textarea  rows='10' cols='67' form="novoArt" placeholder="Corpo do texto" name="texto"></textarea><br><br>
					<input type="submit" name="salvar" value="salvar"><br><br><br><br>
					
				</form>

			<?php
			if(isset($_POST['salvar'])){
				$titulo = $_POST['titulo'];
				$descricao = $_POST['descricao'];
				$texto = $_POST['texto'];
				$categoria = $_POST['categoria'];
				$codigo = 0;

				$sql2 = "SELECT cod_cat FROM categoria WHERE nome = '".$categoria."'";
				$stmt2  = $this->con->prepare($sql2);
				$stmt2->execute();

				while($row = $stmt2->fetch()){
					$codigo = (int)$row['cod_cat'];
				}

				$sql3 = "INSERT INTO artigo VALUES (DEFAULT,'".$titulo."','".$descricao."','".$texto."',".$codigo.")";
				$stmt3 = $this->con->prepare($sql3);
				$stmt3->execute();
				header('Location: userartigos.php');

			}


		}

		public function categoria(){

			$sql = "SELECT * FROM categoria ORDER BY cod_cat ASC";
			$stmt6 = $this->con->prepare($sql);
			$stmt6->execute();

			?>
			<form method="post" id="formCategoria">
				<table>
					<tr>
						<th>Nome</th>
						<th>Codigo</th>
					</tr>
				<?php

					while($row = $stmt6->fetch()){

						echo "<tr><td>".$row['nome']."</td><td> &nbsp&nbsp&nbsp&nbsp".$row['cod_cat']."</td><td><input type='radio' name='categoria' value='".$row['nome']."' form='formCategoria'></td></tr>";

					}
				?>
				</table>
				<br><br><input type="text" name="cat">
				<br><br>
				<input type="submit" name="incluir" value="incluir">&nbsp&nbsp
				<input type="submit" name="excluir" value="excluir">&nbsp&nbsp
				<input type="submit" name="editar" value="editar">&nbsp&nbsp
			</form>
			<?php

				//if para o botão de incluir

				if(isset($_POST['incluir'])){
					header("Refresh: 0");
					$cat = $_POST['cat'];
					$sql2 = "INSERT INTO categoria VALUES (DEFAULT,'".$cat."')";
					$stmt7 = $this->con->prepare($sql2);
					$stmt7->execute();
					header("Refresh: 0");
			
				}

				//if para o botão de excluir

				if(isset($_POST['excluir'])){
					header("Refresh: 0");
					$categoria = $_POST['categoria'];

					$sql3 = "SELECT cod_cat FROM categoria WHERE nome = '".$categoria."' ";
					$stmt8 = $this->con->prepare($sql3);
					$stmt8->execute();

					$codigo = 0;
					while($row3 = $stmt8->fetch()){

						$codigo = (int)$row3['cod_cat'];

					}

					$sql4 = "DELETE FROM categoria WHERE cod_cat = ".$codigo;
					$stmt9 = $this->con->prepare($sql4);
					$stmt9->execute();
					header("Refresh: 0");
				}

				//if para o botão editar

				if(isset($_POST['editar'])){
					header("Refresh: 0");
					$categoria = $_POST['categoria'];

					echo "teste echo: ".$categoria."<br><br>";
					$cat = $_POST['cat'];
					$sql5 = "SELECT cod_cat FROM categoria WHERE nome = '".$categoria."'";
					$stmt9 = $this->con->prepare($sql5);
					$stmt9->execute();

					$codigo = 0;
					while($row4 = $stmt9->fetch()){

						$codigo = (int)$row4['cod_cat'];

					}

					$sql5 = "UPDATE categoria SET nome = '".$cat."' WHERE cod_cat = ".$codigo;
					$stmt10 = $this->con->prepare($sql5);
					$stmt10->execute();
					header("Refresh: 0");
				}

				

		}
}

?> 