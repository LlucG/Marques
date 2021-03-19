<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Uy! Transfer</title>
<link rel="icon" type="image/x-icon" href="images/favicon.png" />
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
</head>

<body>
	<?php include 'php/header.php'; ?>
	<div id="caixa">
		<form action="upload.php" method="post" enctype="multipart/form-data">
			<ul>
				<input type="text" name="nom" placeholder="El teu nom" class="input">
			</ul>
			<ul>
				<input type="file" name="arxiu" placeholder="Selecciona el teu arxiu" class="input">
			</ul>
			<ul>
				<input type="checkbox" name="linksino" id="linksino">
				<label for="linksino"><strong>Vols envair el link per correu?</strong></label>
			</ul>
			<ul>
				<input type="text" name="email" placeholder="Email destinatari" class="input">
			</ul>
			<ul>
				<label><strong>Missatge</strong></label><br>
				<textarea name="missatge" class="input" rows="6"></textarea>
			</ul>
			<ul>
				<input type="submit" name="Enviar">
			</ul>
		</form>
	</div>
</body>
</html>
