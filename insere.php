<?php
		
            include("conexao.php");
            
			$nome = $_POST["nome"];
			$email = $_POST["email"];
			$salario = $_POST["salario"];
            $sexo = $_POST["sexo"];
            $cod_cidade = $_POST["cod_cidade"];
            
			$insert =
			"INSERT INTO cadastro(nome,email,salario,sexo,cod_cidade)
				 VALUES
			 ('$nome','$email','$salario','$sexo','$cod_cidade')";

			mysqli_query($conexao,$insert) or die(mysqli_error($conexao));
			
			
				echo "1";
?>