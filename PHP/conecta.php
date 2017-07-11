<?php
	

$usuario = "root";
$senha = "";
$host = "localhost";
$base = "segurabus2";	
	
$link = mysqli_connect($host, $usuario, $senha, $base);
 
	if (!$link) 
	{
		echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
		echo "Debugging erro: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
 
	echo "Sucesso: Sucesso ao conectar-se com a base de dados MySQL." . PHP_EOL;
 

	
?>