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
	
    	<div id="mapa" style="height: 370px; width: 600px" >
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
		<form class="selecione" id="form" name="form3" method="post" action="index.php">
		<div align="right">
		<input type="hidden" name="enviar" value="enviar" />
		<input name="ok" type="image" src="img/ok.png" class="ok"/></div>
		<text id="botao_txt"> Voltar para a Tela Inicial <text/>
		</form>
		
		<?php
			//cria conexão
			$connect=mysqli_connect('localhost','root','','segurabus');
			if($connect){}
			else{echo 'Não conectado ao Banco de Dados';}
			//comando SQL(SELECT)
			$result=mysqli_query($connect,"SELECT * FROM assaltos");
			$row=mysqli_fetch_array($result);
			$status=$row['status'];
		?>
		
		<h1 id="titulo_estatistica" >Estatística</h1>
		<table id="tab_estatistica" border=1>
			<tr>
				<td>Linha</td>
				<td>Latitude</td>
				<td>Longitude</td>
				<td>Data e hora</td>
				<td>Descrição</td>
			</tr>
			<?php
				$idAnterior=-1;
				$row=mysqli_fetch_array($result);
				$idAtual=$row['Id'];
				while($idAtual != NULL){
					if($idAnterior!=$idAtual){
			?>
			<tr>
				<td><?php echo $result1=$row['linha']; ?></td>
				<td><?php echo $result1=$row['latitude']; ?></td>
				<td><?php echo $result1=$row['longitude']; ?></td>
				<td><?php echo $result1=$row['data_hora']; ?></td>
				<td><?php echo $result1=$row['Descricao']; ?></td>
				<?php
					$idAnterior = $idAtual;
					$row=mysqli_fetch_array($result);
					$idAtual=$row['Id'];
				?>
			</tr>
					<?php } else{} ?>
				<?php } ?>
		</table>
		
    </body>
	
</html>