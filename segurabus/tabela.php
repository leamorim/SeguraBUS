<html>
	<body>
		<h1>Registro dos Assaltos</h1>
		
		<?php
			//cria conexão
			$connect=mysqli_connect('localhost','root','','segurabus');
			if($connect)
			{}
			else{echo 'Não conectado ao Banco de Dados';}
			//comando SQL(SELECT)
			$result=mysqli_query($connect,"SELECT * FROM assaltos");
		?>
		<table border=1>
			<tr>
				<td>ID</td>
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
				<td><?php echo $result1=$row['Id']; ?></td>
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