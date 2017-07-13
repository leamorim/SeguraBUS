<!DOCTYPE html>

<!-- Gera arquivo JSON para apontar no mapa o que existe no BD-->
<?php
	//open connection to mysql db
	$connection = mysqli_connect("localhost","root","","segurabus") or die("Error " . mysqli_error($connection));
	
	//fetch table rows from mysql db
	$sql = "SELECT Id, Latitude, Longitude, Descricao FROM assaltos";
	$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

	//create an array
	$emparray = array();
	while($row =mysqli_fetch_assoc($result))
	{
		$emparray[] = $row;
	}
	
	//write to json file
	$fp = fopen('js/pontos.json', 'w');
	fwrite($fp, json_encode($emparray));
	fclose($fp);

	//close the db connection
	mysqli_close($connection);
	
	
?>

<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <title>SeguraBus: Mapa</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
 
    <body>
		<img id="logo" src="img/logo.png" />
	
    	<div id="mapa" style="height: 350px; width: 1320px" >
        </div>
		
		<script src="js/jquery.min.js"></script>
 
        <!-- Maps API Javascript -->
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD3pbQq21BdkOQnYeHWI56HvgbTzO0aOQU"></script>
        
        <!-- Caixa de informação -->
        <script src="js/infobox.js"></script>
		
        <!-- Agrupamento dos marcadores -->
		<script src="js/markerclusterer.js"></script>
 
        <!-- Arquivo de inicialização do mapa -->
		<script src="js/mapa.js"></script>
		
		<!-- Botão que acessa outra página -->
		<form class="selecione" id="form" name="form3" method="post" action="registrar_ocorrencia.php">
		<div align="right">
		<input type="hidden" name="enviar" value="enviar" />
		<input name="ok" type="image" src="img/ok.png" class="ok"/></div>
		<text id="botao_txt"> Registrar ocorrência <text/>
		</form>
		
		<!-- Botão que acessa outra página -->
		<form class="selecione" id="form2" name="form2" method="post" action="wfile.php">
		<div align="right">
		<input type="hidden" name="enviar" value="enviar" />
		<input name="ok" type="image" src="img/ok.png" class="ok"/></div>
		<text id="botao_txt"> Desativar alarme <text/>
		</form>
		
		<!-- Botão que acessa outra página -->
		<form class="selecione" id="form3" name="form3" method="post" action="tabela.php">
		<div align="right">
		<input type="hidden" name="enviar" value="enviar" />
		<input name="ok" type="image" src="img/ok.png" class="ok"/></div>
		<text id="botao_txt"> Registro dos assaltos <text/>
		</form>
		
		
    </body>
	
</html>