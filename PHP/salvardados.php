<?php
	
	include 'conecta.php';
	
	$latitude = $_GET["latitude"];
	$longitude = $_GET["longitude"];
	$linha = $_GET["linha"];
	$onibus = $_GET["onibus"];
	$status = $_GET["status"];

	
	
	$Insere_Banco = "INSERT INTO localizador (latitude,longitude,linha,onibus,status) values";
	$Insere_Banco .= "('$latitude','$longitude', '$linha', '$onibus', '$status')";
	
	
	if($link->query($Insere_Banco) == TRUE)
	{
		echo "Salvo com Sucesso!!!";	
	} 
	else
	{
		echo "Error ao salvar: " . $Insere_Banco . "<br>" . mysqli_error($Insere_Banco);
	}
	
	mysqli_close($link);
?>