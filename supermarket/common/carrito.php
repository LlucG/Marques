<?php
session_start();

if (!isset($_SESSION["carrito"])) $_SESSION["carrito"] = array();

function afegirProducte($pCodi, $pNom, $pPreu, $pQuantitat) {
	$afegit = false;

	if ($pQuantitat >= 1) {
		
		$posicio = buscarProducte($pCodi);
		
		if ($posicio == -1) {
			$nouProducte = array("codi" => $pCodi,"nom" => $pNom,"preu" => $pPreu,"quantitat" => $pQuantitat);
			array_push($_SESSION["carrito"], $nouProducte);
		} else {
			$_SESSION["carrito"][$posicio]["quantitat"] += $pQuantitat;
		}

		$afegit = true;
	}

	return $afegit;
}

function buscarProducte($pCodi) {
	$posicio = -1;

	for ($i = 0; $i < count($_SESSION["carrito"]) && $posicio == -1; $i++) {
		if ($_SESSION["carrito"][$i]["codi"] == $pCodi) $posicio = $i;
	}

	return $posicio;
}

function eliminarProducte($pCodi) {
	$eliminat = false;

	$posicio = buscarProducte($pCodi);

	if ($posicio != -1) {
		unset($_SESSION["carrito"][$posicio]);
		sort($_SESSION["carrito"]);
		$eliminat = true;
	}

	return $eliminat;
}

function importProducte($pCodi) {
	$import = 0;

	$posicio = buscarProducte($pCodi);

	if ($posicio != -1) {
		$import = $_SESSION["carrito"][$posicio]["quantitat"] * $_SESSION["carrito"][$posicio]["preu"];
	}

	return round($import, 2);
}

function importTotal() {
	$import = 0;

	foreach ($_SESSION["carrito"] as $producte) {
		$import += importProducte($producte["codi"]);
	}

	return round($import, 2);
}

?>