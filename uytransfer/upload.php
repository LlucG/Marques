<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Uy! Transfer Upload</title>
<link rel="icon" type="image/x-icon" href="images/favicon.png" />
<link rel="stylesheet" type="text/css" href="css/estilos.css" />
</head>

<body>
	<?php include 'php/header.php'; ?>
	<?php
		//print_r($_POST);
		//print_r($_FILES);
		$imgerror = false;
		$nom = date("Y") . date("m") . date("d") . rand(11111, 99999);
		$extensio = pathinfo($_FILES['arxiu']['name'], PATHINFO_EXTENSION);
		move_uploaded_file($_FILES['arxiu']['tmp_name'], "files/". $nom . "." .$extensio);
		$link ='<a href="http://localhost/Marques/uytransfer/files/'.$nom.".".$extensio.'"><p id="textUpload" style="margin-bottom: 2em;">http://localhost/Marques/uytransfer/files/'.$nom.'</p></a>';
	?>
	<div id="caixaUpload">
		<?php 
			if ($imgerror) {
				echo '<img src="images/error.jpg" style="border-radius: 50%; float: left;">';
			} else {
				echo '<img src="images/correcte.jpg" style="border-radius: 50%; float: left;">';
			}
		?>
		<table id="table">
			<tr>
				<td><p id="titolUpload">Arxiu enviat correctament</p></td>
			</tr>
			<tr>
				<td>
					<?php if (!empty($_POST["nom"])) {
						echo '<p id="textUpload" style="margin-top: 0em;">Hola ',$_POST["nom"],' utilitza aquest link per compartir l\'arxiu</p>';
					} else {
						echo '<p id="textUpload" style="margin-top: 0em;">Oye tu utilitza aquest link per compartir l\'arxiu</p>';
					} ?>

				</td>
			</tr>
			<tr>
				<td><?php echo $link ?></td>
			</tr>
		</table>
		
		
	</div>
</body>
</html>