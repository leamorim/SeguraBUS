<!DOCTYPE html>

<!-- Gera arquivo JSON para apontar no mapa o que existe no BD-->
<?php
	//open connection to mysql db
	$connection = mysqli_connect("localhost","root","","segurabus") or die("Error " . mysqli_error($connection));
	
	//fetch table rows from mysql db
	$sql = "SELECT Id, Latitude, Longitude, Descricao FROM assaltos ORDER BY data_hora DESC";
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
	
    	<div id="mapa" style="height: 370px; width: 1050px" >
        </div>
		
		<script src="js/jquery.min.js"></script>
 
        <!-- Maps API Javascript -->
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBsVSCQjs0oQ3jaM5EWXk9Q23LsiLx2Z58"></script>
        
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
		<form class="selecione" id="form3" name="form3" method="post" action="tabela.php">
		<div align="right">
		<input type="hidden" name="enviar" value="enviar" />
		<input name="ok" type="image" src="img/ok.png" class="ok"/></div>
		<text id="botao_txt"> Estatística <text/>
		</form>
		
		<?php
			//cria conexão
			$connect=mysqli_connect('localhost','root','','segurabus');
			if($connect){}
			else{echo 'Não conectado ao Banco de Dados';}
			//comando SQL(SELECT)
			$result=mysqli_query($connect,"SELECT linha, onibus, data_hora, Descricao, status FROM assaltos ORDER BY data_hora DESC");
			$row=mysqli_fetch_array($result);
			$status=$row['status'];
			if($status == 1)
			{
		?>		
		
		
		<h1 id="titulo_tab_alerta" >Assaltos ocorrendo</h1>
		<table id="tab_alerta" border=1 >
			<tr>
				<td>Linha</td>
				<td>Numero de ônibus</td>
				<td>Data e hora</td>
				<td>Descrição</td>
			</tr>
			<tr>
				<td><?php echo $result1=$row['linha']; ?></td>
				<td><?php echo $result1=$row['onibus']; ?></td>
				<td><?php echo $result1=$row['data_hora']; ?></td>
				<td><?php echo $result1=$row['Descricao']; ?></td>
			</tr>				
				
		</table>

		<!-- Botão que acessa outra página -->
		<form class="selecione" id="form2" name="form2" method="post" action="PHP/desativa.html">
		<div align="right">
		<input type="hidden" name="enviar" value="enviar" />
		<input name="ok" type="image" src="img/ok.png" class="ok"/></div>
		<text id="botao_txt"> Desativar alarme <text/>
		</form>

			<?php } ?>
		
		
		
		</body>
</html>