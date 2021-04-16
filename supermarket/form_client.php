<?php
	require "header.php";
	include 'config.php';
	if ($conn->connect_error) {
		echo "Hi ha hagut un error";
	} else {
		$sql = "SELECT id_poblacio, nom FROM poblacions ORDER BY nom";
		//print_r($sql);
		$result = $conn->query($sql);
	}
	$correcte = false;
?>
		<div class="container m-5 mx-auto text-white">
			<form action=<?php if ($correcte) {echo "entrar.php";} else {echo htmlspecialchars($_SERVER["PHP_SELF"]);}?> method="post">
				<div class="row">
					<div class="col-4 offset-2">
						<div class="form-group">
							<label for="username">Nom d'usuari (obligatori):</label>
							<input type="text" class="form-control" name="username" id="username" <?php if (!empty($_POST)) { echo 'value="'.$_POST["username"].'"';} ?> />
						</div>
						<div class="form-group">
							<label for="pass">Contrasenya (obligatori):</label>
							<input type="password" class="form-control" name="pass" id="pass" <?php if (!empty($_POST)) { echo 'value="'.$_POST["pass"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="rp_pass">Repeteix la contrasenya (obligatori):</label>
							<input type="password" class="form-control" name="rp_pass" id="rp_pass" <?php if (!empty($_POST)) { echo 'value="'.$_POST["rp_pass"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="nombre">Nom (obligatori):</label>
							<input type="text" class="form-control" name="nombre" id="nombre" <?php if (!empty($_POST)) { echo 'value="'.$_POST["nombre"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="apellidos">Cognoms (obligatori):</label>
							<input type="text" class="form-control" name="apellidos" id="apellidos" <?php if (!empty($_POST)) { echo 'value="'.$_POST["apellidos"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="nif">NIF (obligatori):</label>
							<input type="text" class="form-control" name="nif" id="nif" <?php if (!empty($_POST)) { echo 'value="'.$_POST["nif"].'"';} ?>/>
						</div>
					</div>
					<div class="col-4">
						<div class="form-group">
							<label for="direccion">Adreça (obligatori):</label>
							<input type="text" class="form-control" name="direccion" id="direccion" <?php if (!empty($_POST)) { echo 'value="'.$_POST["direccion"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="codi_postal">Codi postal (obligatori):</label>
							<input type="text" class="form-control" name="codi_postal" id="codi_postal" <?php if (!empty($_POST)) { echo 'value="'.$_POST["codi_postal"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="poblacion">Població (obligatori):</label>
							<select class="form-control" name="poblacion" id="poblacion">
								<option <?php if (!empty($_POST)) { echo 'value="'.$_POST["poblacion"].'"';} ?>>Selecciona una opció</option>
								<?php 
									if ($result) {
										if ($result->num_rows > 0) {
											$row = $result->fetch_assoc();
											while($row) {
												$id = $row["id_poblacio"];
												$nom = $row["nom"];

												echo '<option value="'.$id.'">'.$nom.'</option>';

												$row = $result->fetch_assoc();
											}
										}
									} else {
										echo "ERROR al seleccionar les dades";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="telefono">Telèfon:</label>
							<input type="text" class="form-control" name="telefono" id="telefono" <?php if (!empty($_POST)) { echo 'value="'.$_POST["telefono"].'"';} ?>/>
						</div>
						<div class="form-group">
							<label for="codi_postal">Email:</label>
							<input type="text" class="form-control" name="mail" id="mail" <?php if (!empty($_POST)) { echo 'value="'.$_POST["mail"].'"';} ?>/>
						</div>
						<div class="form-group text-right">
							<button type="submit" class="btn btn-default">Enviar</button>
						</div>
					</div>
				</div>
			</form>
			<?php
				//if (!empty($_POST)) {
					if (!empty($_POST["username"])) {$username = $_POST["username"];}
					if (!empty($_POST["pass"])) {$pass = $_POST["pass"];}
					if (!empty($_POST["rp_pass"])) {$rp_pass = $_POST["rp_pass"];}
					if (!empty($_POST["nombre"])) {$nombre = $_POST["nombre"];}
					if (!empty($_POST["apellidos"])) {$apellidos = $_POST["apellidos"];}
					if (!empty($_POST["nif"])) {$nif = $_POST["nif"];}
					if (!empty($_POST["direccion"])) {$direccion = $_POST["direccion"];}
					if (!empty($_POST["codi_postal"])) {$codi_postal = $_POST["codi_postal"];}
					if (!empty($_POST["poblacion"])) {$poblacion = (int)$_POST["poblacion"];}
					if (!empty($_POST["telefono"])) {$telefono = $_POST["telefono"];}
					if (!empty($_POST["mail"])) {$mail = $_POST["mail"];}

					if (isset($username) && isset($pass) && isset($nombre) && isset($apellidos) && isset($nif) && isset($direccion) && isset($codi_postal) && isset($poblacion)) {
						$usuari = $conn->query("SELECT nom_usuari FROM clients WHERE nom_usuari = $username");
						if (empty($usuari)) {
							if ($pass == $rp_pass) {
								if (strlen($pass) > 3) {
									$nif_len = strlen($nif);
									if ($nif_len < 10 && $nif_len > 8 && is_numeric(substr($nif, 0, 8)) && !is_numeric(substr($nif, 9, 0))) {
										if (isset($mail)) {
											if (str_contains($mail, '@') && str_contains($mail, '.')) {
												if (isset($telefon)) {
													if (strlen($telefon) < 10 && strlen($telefon) > 8) {
														$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio, telefon, email) VALUES ($username, $pass, $nombre, $apellidos, $nif, $direccion, $codi_postal, $poblacion, $telefono, $mail)";
														//print_r($sql);
														$correcte = true;
														echo "HOLA";
														$conn->query($sql);
													} else {
														echo "Telèfon incorrecte";
													}
												} else {
													$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio, email) VALUES ($username, $pass, $nombre, $apellidos, $nif, $direccion, $codi_postal, $poblacion, $mail)";
													//print_r($sql);
													$correcte = true;
														echo "HOLA";
													$conn->query($sql);
												}											
											} else {
												echo "Email incorrecte";
											}
										} else {
											if (isset($telefon)) {
												if (strlen($telefon) < 10 && strlen($telefon) > 8) {
													$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio, telefon) VALUES ($username, $pass, $nombre, $apellidos, $nif, $direccion, $codi_postal, $poblacion, $telefono)";
													//print_r($sql);
													$correcte = true;
														echo "HOLA";
													$conn->query($sql);
												} else {
													echo "El telèfon és incorrecte";
												}
											} else {
												$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio) VALUES ($username, $pass, $nombre, $apellidos, $nif, $direccion, $codi_postal, $poblacion)";
													//print_r($sql);
													$correcte = true;
														echo "HOLA";
													$conn->query($sql);
											}
										}	
									} else {
										echo "Nif incorrecte";
									}
								} else {
									echo "La contrasenya és massa curta";
								}
							} else {
								echo "Les contrasenyes no coincideixen";
							}
						} else {
							echo "Aquest usuari ja existeix";
						}
					} else {
						echo "Falten dades obligatories";
					}
				//}
				$conn->close();
			?>
		</div>
	</body>
</html>
