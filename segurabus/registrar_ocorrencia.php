<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <title>SeguraBus: Registro de Ocorrência</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
 
    <body>
		<img id="logo" src="img/logo.png" />
		
		<form action="inserindo_em_bd.php" method="post" id="formulario">
			<div>
				<label for="linha">Linha de Ônibus:</label>
				<input type="int" name="ocorrencia_linha" />
			</div>
			<div>
				<label for="latitude">Latitude:</label>
				<input type="double" name="ocorrencia_latitude" />
			</div>
			<div>
				<label for="longitude">Longitude:</label>
				<input type="double" name="ocorrencia_longitude" />
			</div>
			<div>
				<label for="data_hora">Data e hora:</label>
				<input type="datetime-local" name="ocorrencia_data_hora" />
			</div>
			<div>
				<label for="descricao">Descrição:</label>
				<textarea name="ocorrencia_descricao"></textarea>
			</div>
			
			<div class="button">
				<button type="submit">Enviar ocorrência</button>
			</div>
		</form>
    </body>
</html>