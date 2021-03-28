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
		$link = $_SESSION["link"];
		$numlinks = 1;
		if (isset($_COOKIE["numlinks"])) {
			$numlinks = $_COOKIE["numlinks"];
			$numlinks++;
		}

		setcookie("numlinks", $numlinks, time() + 60 * 60 * 24 * 1000);
		setcookie("link$numlinks", $link, time() + 60 * 5);
	?>
	<div id="caixaUpload">
		<table id="table">
		<tr>
			<td>
				<p id="titolUpload">Historial links</p>
				<?php
					echo '<a href="'.$link.'"><p id="textUpload" style="margin-top: 0em; margin-left: 4em;">'.$link.'</p></a>';
				?>
			</td>
		</tr>
	</div>
</body>
</html>