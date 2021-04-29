<?php
	session_start();
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
			<form method="post"<?php
				include 'common/validacions.php';

				$comptador = 0;
				$missatge = "";

				if (!empty($_POST["username"])) {
					$username = $_POST["username"]; 
					if(nomUsuariValid($username)){
						$comptador++;
					} else {
						$missatge = "L'usuari és incorrecte";
					} 
				} else {
					$missatge = "Falta l'usuari";
				}

				$rp_pass = "";
				if (!empty($_POST["rp_pass"])) {$rp_pass = $_POST["rp_pass"];}

				if (!empty($_POST["pass"])) {
					$pass = $_POST["pass"];
					if(seguretatContrasenya($pass) == 3){
						if ($pass == $rp_pass) {
							$comptador++;
						} else {
							$missatge = "Les contrasenyes no coincideixen";
						}
					} else {
						$missatge = "La contrasenya és poc segura";
					}
				} else {
					$missatge = "Falta la contrasenya";
				}

				if (!empty($_POST["nombre"])) {$nom = $_POST["nombre"]; $comptador++;} else {
					$missatge = "Falta el nom";
				}


				if (!empty($_POST["apellidos"])) {$cognoms = $_POST["apellidos"]; $comptador++;} else {
					$missatge = "Falten els cognoms";
				}


				if (!empty($_POST["nif"])) {
					$nif = $_POST["nif"];
					if(NIFValid($nif)){
						$comptador++;
					} else {
						$missatge = "NIF incorrecte";
					} 
				} else {
					$missatge = "Falta el NIF";
				}


				if (!empty($_POST["direccion"])) {$direccio = $_POST["direccion"]; $comptador++;} else {
					$missatge = "Falta la direccio";
				}


				if (!empty($_POST["codi_postal"])) {
						$codi_postal = (int)$_POST["codi_postal"]; 
						$comptador++; 
				} else {
					$missatge = "Falta el codi postal";
				}


				if (!empty($_POST["poblacion"])) {
					if ((int)$_POST["poblacion"] == 0) {
						$missatge = "Falta la poblacio";
						$comptador = 0;
					} else {
						$poblacio = (int)$_POST["poblacion"]; 
						$comptador++;
					}
				} else {
					$missatge = "Falta la poblacio";
				}

				if (!empty($_POST["telefon"])) {$telefon = $_POST["telefon"];}

				if (!empty($_POST["mail"])) {
					if(!esEmail($_POST["mail"])){
						$comptador = 0;
						$missatge = "L'email és incorrecte";
					} else {
						$mail = $_POST["mail"];
					}
				}

				if ($comptador >= 8) {
					if (isset($telefon) && !isset($mail)) {
						$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio, telefon) VALUES ('".$username."', '".$pass."', '".$nom."', '".$cognoms."', '".$nif."', '".$direccio."', ".$codi_postal.", ".$poblacio.", '".$telefon."')";
					$correcte = true;
						// print_r($sql);
					} else if (!isset($telefon) && isset($mail)) {
						$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio, email) VALUES ('".$username."', '".$pass."', '".$nom."', '".$cognoms."', '".$nif."', '".$direccio."', ".$codi_postal.", ".$poblacio.", '".$mail."')";
					$correcte = true;
						// print_r($sql);
					} else if (isset($telefon) && isset($mail)) {
						$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio, telefon, email) VALUES ('".$username."', '".$pass."', '".$nom."', '".$cognoms."', '".$nif."', '".$direccio."', ".$codi_postal.", ".$poblacio.", '".$telefon."', '".$mail."')";
					$correcte = true;
						// print_r($sql);
					} else {
						$sql = "INSERT INTO clients (nom_usuari, contrasenya, nom, cognoms, nif, adreca, codi_postal, poblacio) VALUES ('".$username."', '".$pass."', '".$nom."', '".$cognoms."', '".$nif."', '".$direccio."', ".$codi_postal.", ".$poblacio.")";
					$correcte = true;
						// print_r($sql);
					}
					// print_r($sql);
					$conn->query($sql);	
				}
				$conn->close();
			 	
			 	if ($correcte) {
			 		echo ' action="entrar.php"';
			 	} else {
			 		echo ' action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'"';
			 	}
			?>>
				<div align="center"><?php
					if (!empty($_POST) && !$correcte) {
						echo '<div class="bg-danger" style="width: 20%; border-radius: 1em; padding: 1em;">';
						echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
							  <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
							  <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
							</svg><br>';
						echo $missatge;
						echo "</div>";
					}
				?></div>
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
								<option value="0">Selecciona una opció</option>
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
							<label for="telefon">Telèfon:</label>
							<input type="text" class="form-control" name="telefon" id="telefon" <?php if (!empty($_POST)) { echo 'value="'.$_POST["telefon"].'"';} ?>/>
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
		</div>
	</body>
</html>
