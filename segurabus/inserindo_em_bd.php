<?php
  //Obtendo todos os dados informados no formulario
  $linha = $_POST['ocorrencia_linha'];
  $latitude = $_POST['ocorrencia_latitude'];
  $longitude = $_POST['ocorrencia_longitude'];
  $data_hora = $_POST['ocorrencia_data_hora'];
  $descricao = $_POST['ocorrencia_descricao'];
  
  $erro = NULL;
  if($linha == NULL)
  {
	  echo Linha deve ser inserido;
	  $erro = 1;
  }
  if($data_hora == NULL)
  {
	  echo Data e Hora deve ser inserido;
	  $erro = 1;
  }
  if($descricao == NULL)
  {
	  echo Descrição deve ser inserido;
	  $erro = 1;
  }
?>

<?php
	if($erro == NULL)
	{
		//Enviando para o Banco de Dados
		$strcon = mysqli_connect('localhost','root','','segurabus') or die('Erro ao conectar ao banco de dados');
		$sql = "INSERT INTO assaltos(linha, Latitude, Longitude, data_hora, Descricao) VALUES ";
		$sql .= "('$linha', '$latitude', '$longitude', '$data_hora','$descricao')"; 
		if($strcon->query($sql) == TRUE)
		{
			echo "Cadastro com sucesso";
		}
		else
		{
			echo "Erro ao cadastrar no banco de dados";
		}
	}
?>

<html lang="pt-br">
	<head>
		<meta charset="utf-8" />
		<title>SeguraBus: Inserindo</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
 
	<body>
		<img id="logo" src="img/logo.png" />
		
		<form class="selecione" id="confirmar_registro" name="confirmar_registro" method="post" action="index.php">
		<div align="right">
		<input type="hidden" name="enviar" value="enviar" />
		<input name="ok" type="image" src="img/ok.png" class="ok2"/></div>
		<text id="botao_txt"> Retornar ao menu principal <text/>
	</body>
</html>