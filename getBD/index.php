<html>
	<body>
		<h1>Checando conexão ao Banco de Dados</h1>
		<?php
			//cria conexão
			$connect=mysqli_connect('localhost','root','','segurabus');
			if($connect)
			{
				echo 'Conectado ao banco de dados<br />';
			}
			else{
				echo 'Não conectado';
			}
			//comando SQL(SELECT)
			$result=mysqli_query($connect,"SELECT * FROM assaltos");
		?>
		<table border="1">
			<tr>
				<td>ID</td>
				<td>Linha</td>
				<td>Latitude</td>
				<td>Longitude</td>
				<td>Data e hora</td>
				<td>Status</td>
			</tr>
			<?php while($row=mysqli_fetch_array($result)){  ?>
			<tr>
				<td><?php echo $result1=$row['id']; ?></td>
				<td><?php echo $result1=$row['linha']; ?></td>
				<td><?php echo $result1=$row['latitude']; ?></td>
				<td><?php echo $result1=$row['longitude']; ?></td>
				<td><?php echo $result1=$row['data_hora']; ?></td>
				<td><?php echo $result1=$row['status']; ?></td>
			</tr>
			<?php } ?>
		</table>
	</body>
</html>