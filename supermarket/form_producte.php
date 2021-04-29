<?php
	session_start();
	require "header.php";
	include 'config.php';
	if ($conn->connect_error) {
			echo "Hi ha hagut un error";
	} else {
		$sql = "SELECT * FROM categories ORDER BY nom";

		$result = $conn->query($sql);
	}
				$correcte = 0;
				if (!empty($_POST["codi"])) {$codi = $_POST["codi"]; $correcte++;}
				if (!empty($_POST["nom"])) {$nom = $_POST["nom"]; $correcte++;}
				if (!empty($_POST["categoria"])) {$categoria = (int)$_POST["categoria"]; $correcte++;}
				if (!empty($_POST["preu"])) {$preu = (float)$_POST["preu"]; $correcte++;}
				if (!empty($_POST["stock"])) {$stock = (int)$_POST["stock"]; $correcte++;}
				if (!empty($_FILES['imatge']['name'])) {
					// print_r(pathinfo($_FILES['imatge']['name'], PATHINFO_EXTENSION));
					$extensio = pathinfo($_FILES['imatge']['name'], PATHINFO_EXTENSION);

					if ($extensio == 'PNG' || $extensio == 'png' || $extensio == 'JPG' || $extensio == 'jpg') {
						move_uploaded_file($_FILES['imatge']['tmp_name'], "images/productes". $codi . "." .$extensio);
						$imatge = "images/productes". $codi . "." .$extensio;
						$correcte++;
					}
				}

				if ($correcte == 6) {
					$sql = "INSERT INTO productes (codi, categoria, nom, preu, unitats_stock, imatge) VALUES ('".$codi."', ".$categoria.", '".$nom."', ".$preu.", ".$stock.", '".$imatge."')";
					$conn->query($sql);	
					echo '<div style="position: absolute; top: 10em; left: 2em; background-color: #79D332; border-radius: 2em;">';
					echo '<p style="text-align: center; vertical-align: middle; padding: 0.5em; margin-left: 1em; margin-right: 1em; margin-top: 1rem; font-weight: bold; color: black;">El producte <br> s\'ha pujat correctament</p>';
					echo '</div>';
				} else if (!empty($_POST)) {
					echo '<div style="position: absolute; top: 10em; left: 2em; background-color: #D33232; border-radius: 2em;">';
					echo '<p style="text-align: center; vertical-align: middle; padding: 0.5em; margin-left: 1em; margin-right: 1em; margin-top: 1rem; font-weight: bold; color: white;">Falten dades <br> o l\'arxiu no és una imatge</p>';
					echo '</div>';
				}

				// print_r($sql);
				// print_r($_FILES['imatge']['tmp_name']);

			?>
		<div class="container m-5 mx-auto text-white">
			<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-4 offset-2">
						<div class="form-group">
							<label for="codi">Codi:</label>
							<input type="text" class="form-control" name="codi" id="codi" 
							<?php if (!empty($_POST)) { echo 'value="'.$_POST["codi"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="nom">Nom:</label>
							<input type="text" class="form-control" name="nom" id="nom" 
							<?php if (!empty($_POST)) { echo 'value="'.$_POST["nom"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="categoria">Categoria:</label>
							<select class="form-control" name="categoria" id="categoria">
								<option value="">Selecciona una opció</option>
								<?php
									if ($result->num_rows > 0) {
										$row = $result->fetch_assoc();
										while($row) {
											$id_categoria = $row["id_categoria"];
											$nom = $row["nom"];

											if (!empty($_POST["categoria"])) { 
												if ($id_categoria == $categoria) {
													echo '<option selected value="'.$id_categoria.'">'.$nom.'</option>';
												} else {
													echo '<option value="'.$id_categoria.'">'.$nom.'</option>';
												}
											} else {
												echo '<option value="'.$id_categoria.'">'.$nom.'</option>';
											}
											$row = $result->fetch_assoc();
										}
									} else {
										alert("Error al seleccionar les dades");
									}
									$conn->close();
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="preu">Preu:</label>
							<input type="number" step="0.01" class="form-control" name="preu" id="preu" 
							<?php if (!empty($_POST)) { echo 'value="'.$_POST["preu"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="stock">Unitats en stock:</label>
							<input type="number" class="form-control" name="stock" id="stock" 
							<?php if (!empty($_POST)) { echo 'value="'.$_POST["stock"].'"';} ?>/>
						</div>
						<div class="form-group text-right">
							<a href="productes.php" class="btn btn-outline-secondary mx-2">Tornar</a>
							<button type="submit" class="btn btn-default">Guardar</button>
						</div>
					</div>
					<div class="col-4">
						<div class="form-group">
							<label for="imatge">Imatge:</label>
							<input type="file" class="form-control" name="imatge" id="imatge"/>
						</div>
						<div class="text-center">
							<img src=<?php if (!empty($_FILES['imatge']["name"])) { echo '"'.$imatge.'"';} else {
								echo '"images/productes/no-image.png"';
							} ?> class="img-thumbnail" style="height: 250px;" />
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
