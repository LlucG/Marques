<?php

function nomUsuariValid($pNomUsuari) {
	$valid = false;

	if (strlen($pNomUsuari) >= 8) {
		if (!strpos($pNomUsuari, " ") && !strpos($pNomUsuari, "'") && !strpos($pNomUsuari, "à") && !strpos($pNomUsuari, "À") && !strpos($pNomUsuari, "á") && !strpos($pNomUsuari, "Á") && !strpos($pNomUsuari, "è") && !strpos($pNomUsuari, "È") && !strpos($pNomUsuari, "é") && !strpos($pNomUsuari, "É") && !strpos($pNomUsuari, "ì") && !strpos($pNomUsuari, "Ì") && !strpos($pNomUsuari, "í") && !strpos($pNomUsuari, "Í") && !strpos($pNomUsuari, "ò") && !strpos($pNomUsuari, "Ò") && !strpos($pNomUsuari, "ó") && !strpos($pNomUsuari, "Ó") && !strpos($pNomUsuari, "ù") && !strpos($pNomUsuari, "Ù") && !strpos($pNomUsuari, "ú") && !strpos($pNomUsuari, "Ú") && !strpos($pNomUsuari, "ñ") && !strpos($pNomUsuari, "Ú") && !strpos($pNomUsuari, "Ñ") && !strpos($pNomUsuari, "ç") && !strpos($pNomUsuari, "Ç")) {

			$valid = true;
		}
	}

	return $valid;
}

function seguretatContrasenya($pContrasenya) {
	$grauSeguretat = -1;
	$majuscules = false;
	$digits = false;
	$noAlfanumeric = false;

	if (strlen($pContrasenya) >= 8) {
		$grauSeguretat++;

		for ($i = 0; $i < strlen($pContrasenya); $i++) {
			$ascii = ord(substr($pContrasenya, $i, 1));

			if ($ascii >= 65 && $ascii <= 90) $majuscules = true;
			elseif ($ascii >= 48 && $ascii <= 57) $digits = true;
			elseif ($ascii < 97 || $ascii > 122) $noAlfanumeric = true;
		}

		if ($majuscules) {
			$grauSeguretat++;
			if ($digits) {
				$grauSeguretat++;
				if ($noAlfanumeric) {
					$grauSeguretat++;
				}
			}
		}

	}

	return $grauSeguretat;
}

function esEmail($pEmail) {
	$mail = false;
	$posicioArroba = strpos($pEmail, "@");

	if ($posicioArroba > 0 && $posicioArroba < strlen($pEmail) - 1) {

		$domini = substr(strrchr($pEmail, "."), 1);

		if ($domini == "cat" || $domini == "es" || $domini == "com" || $domini == "net" || $domini == "org") {
			$mail = true;
		}
	}

	return $mail;
}

function NIFValid($pNIF) {
	$valid = false;
	$lletres = "TRWAGMYFPDXBNJZSQVHLCKE";

	if (strlen($pNIF) == 9) {
		$numero = substr($pNIF, 0, 8);
		$lletraNIF = strtoupper(substr($pNIF, 8));
		$lletraObtinguda = substr($lletres, $numero % 23, 1);

		if ($lletraNIF == $lletraObtinguda) $valid = true;
	}

	return $valid;
}

?>