<html>
	<head>
        <meta charset="utf-8" />
        <title>SeguraBus: Estatística</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>

	<body>
		<h1 id="titulo_estatistica" >Registro dos Assaltos</h1>
		
		<?php
		//----------------MONTANDO O MAPA--------------------
			//open connion to mysql db
			$conn = mysqli_connect("localhost","root","","segurabus") or die("Error " . mysqli_error($conn));
			
			//fetch table rows from mysql db
			$sql = "SELECT * FROM assaltos";
			$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

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
		?>
		
		<img id="logo" src="img/logo.png" />
	
    	<div id="mapa_estatistica" style="height: 370px; width: 600px" >
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
		
		<?php
		//------------------MONTANDO A TABELA-----------------
			//comando SQL(SELECT)
			$result=mysqli_query($conn,"SELECT * FROM assaltos");
		?>
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
		<?php
			//close the db connion
			mysqli_close($conn);
		?>
	</body>
</html>