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
		session_start();
		#print_r($_POST);
		#print_r($_FILES);
		$extensiobool = false;
		$midabool = false;
		$extensio = pathinfo($_FILES['arxiu']['name'], PATHINFO_EXTENSION);
		if ($extensio == 'pdf' || $extensio == 'png' || $extensio == 'jpg' || $extensio == 'rar' || $extensio == 'zip') {
			$extensiobool = true;
		}
		if ($_FILES['arxiu']['size'] < 10000) {
			$midabool = true;
		}

		if ($extensiobool && $midabool) {
			$nom = date("Y") . date("m") . date("d") . rand(11111, 99999);
			move_uploaded_file($_FILES['arxiu']['tmp_name'], "files/". $nom . "." .$extensio);
			$link ='http://localhost/Marques/uytransfer/files/'.$nom.'.'.$extensio;
		}
		$_SESSION["link"] = $link;

		//Enviar mail php
		/*Abans d'enviar el correu electrònic es verificarà que l'email introduït tingui format d'email, és a dir, que contingui el caràcter @. Si no és així, es redireccionarà a l'usuari a index.php informant de l'error. Aquest error serà enviat com a paràmetre d'una petició get (per exemple, index.php?error_mail=1). Al mostrar novament el formulari de pujada (index.php) l'usuari ha de visualitzar algun missatge d'error que informi que l'email indicat no és vàlid.*/
		$email = $_POST["email"];
		$emailcorrectebool = false;
		if (!empty($_POST["email"])) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$emailcorrectebool = true;
			} else {
				header('Location: index.php');
			}
		}
			
		if ($emailcorrectebool && $extensiobool && $midabool && $_POST["linksino"] = 'on') {
			$tema = 'Link Uy Transfer';
			if (empty($_POST["missatge"])) {
				$missatge = 'Sorpresa!! Algú ha compartit un arxiu amb tu.' . "\n" . $link;
			} else {
				$missatge = $_POST["missatge"] . "\n" . $link;
			}
			mail($email, $tema, $missatge);
		}
	?>
	<div id="caixaUpload">
		<?php 
			if (empty($_FILES['arxiu']['name']) || !$extensiobool || !$midabool) {
				echo '<img src="images/error.jpg" style="border-radius: 50%; float: left;">';
			} else {
				echo '<img src="images/correcte.jpg" style="border-radius: 50%; float: left;">';
			}
		?>
		<table id="table">
			<tr>
				<td>
					<?php 
						if (!empty($_FILES['arxiu']['name']) && $extensiobool && $midabool) {
							echo '<p id="titolUpload" style="margin-left: 2em;">Arxiu enviat correctament</p>';
						} else if (!empty($_FILES['arxiu']['name']) && !$extensiobool) {
							echo '<p id="titolUpload" style="margin-top: 2.5em; margin-bottom: 2.5em; margin-left: 3em;">El format no és compatible</p></td>';
						} else if (!empty($_FILES['arxiu']['name']) && !$midabool) {
							echo '<p id="titolUpload" style="margin-top: 2.5em; margin-bottom: 2.5em; margin-left: 3em;">L\'arxiu és massa gran</p></td>';
						} else {
							echo '<p id="titolUpload" style="margin-top: 2.5em; margin-bottom: 2.5em; margin-left: 3em;">No \'ha enviat cap arxiu</p></td>';
						}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
						if (!empty($_FILES['arxiu']['name']) && $extensiobool && $midabool) {
							if (!empty($_POST["nom"])) {
								echo '<p id="textUpload" style="margin-top: 0em; margin-left: 4em;">Hola ',$_POST["nom"],' utilitza aquest link per compartir l\'arxiu</p>';
							} else {
								echo '<p id="textUpload" style="margin-top: 0em; margin-left: 5em;">Oye tu utilitza aquest link per compartir l\'arxiu</p>';
							} 
						}
					?>
				</td>
			</tr>
			<tr>
				<td><?php
						if (!empty($_FILES['arxiu']['name']) && $extensiobool && $midabool) {
							echo '<a href="'.$link.'"><p id="textUpload" style="margin-bottom: 2em; margin-left: 3.2em;">http://localhost/Marques/uytransfer/files/'.$nom.'</p></a>';
						}
					?>
				</td>
			</tr>
		</table>
		
		
	</div>
</body>
</html>