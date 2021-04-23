<?php
	require "header.php";
	include 'config.php';
	if ($conn->connect_error) {
			echo "Hi ha hagut un error";
	} else {
		$sql = "SELECT * FROM productes";

		if (isset($_GET["cat"])) {
			$cat = $_GET["cat"];

			$sql = "SELECT * FROM productes WHERE categoria = ".$cat;
		}

		$result = $conn->query($sql);
	}
?>
		<div class="container m-5 mx-auto">
			<div class="row">
				<div class="col-2 offset-1">
					<div class="list-group">
						<a href="comprar.php?cat=1" class="list-group-item list-group-item-action">Arròs</a>
						<a href="comprar.php?cat=2" class="list-group-item list-group-item-action">Begudes</a>
						<a href="comprar.php?cat=3" class="list-group-item list-group-item-action">Drogueria</a>
						<a href="comprar.php?cat=4" class="list-group-item list-group-item-action">Conserves</a>
						<a href="comprar.php?cat=5" class="list-group-item list-group-item-action">Esmorzars</a>
						<a href="comprar.php?cat=6" class="list-group-item list-group-item-action">Mascotes</a>
						<a href="comprar.php?cat=7" class="list-group-item list-group-item-action">Lactis i ous</a>
						<a href="comprar.php?cat=8" class="list-group-item list-group-item-action">Llegums</a>
						<a href="comprar.php?cat=9" class="list-group-item list-group-item-action">Oli, vinagre i sal</a>
						<a href="comprar.php?cat=10" class="list-group-item list-group-item-action">Pasta</a>
						<a href="comprar.php?cat=11" class="list-group-item list-group-item-action">Salses i espècies</a>
						<a href="comprar.php?cat=12" class="list-group-item list-group-item-action">Snacks i aperitius</a>
						<a href="comprar.php?cat=13" class="list-group-item list-group-item-action">Sopa i puré</a>
					</div>
				</div>
				<div class="col-8">
					<h3 class="text-white">
						<?php 
						if (isset($_GET["cat"])) {
							$sql2 = "SELECT nom FROM categories WHERE id_categoria = ".$cat;
							$result2 = $conn->query($sql2);
							$mostrarcat = $result2->fetch_assoc();
							echo $mostrarcat["nom"];
							// print_r($result2);
						} else {
							echo "Els nostres productes";
						}
						?>
					</h3>
					<table class="table">        
						<tr> 
							<th>Producte</th> 
							<th>Categoria</th>
							<th class="text-right">Preu</th>
							<th></th>
						</tr>
						<?php 
							if ($result) {
								if ($result->num_rows > 0) {
									$row = $result->fetch_assoc();
									while($row) {
										$codi = $row["codi"];
										$categoria = (int)$row["categoria"];
										$sql2 = "SELECT nom FROM categories WHERE id_categoria = ".$categoria;
										$result2 = $conn->query($sql2);
										$mostrarcat = $result2->fetch_assoc();
										// print_r($result2);

										$nom = $row["nom"];
										$preu = $row["preu"];
										$unitats_stock = $row["unitats_stock"];
										$image = $row["imatge"];

										echo "<tr>";
											echo '<td class="align-middle">';
												echo '<img src="'.$image.'" class="img-thumbnail mr-2" style="height: 50px;" />'.$nom;
											echo '</td>';
											echo '<td class="align-middle">'.$mostrarcat["nom"].'</td>';
											echo '<td class="align-middle text-right">'.$preu.'</td>';
											echo '<td class="align-middle">';
												echo '<form class="form-inline" action="carrito.php" method="post">';
													echo '<div class="form-group">';
														echo '<input type="hidden" name="codi" value="'.$codi.'" />';
														echo '<input type="number" class="form-control form-control-sm mr-2" name="quantitat" min="1" value="1" style="width: 50px;" />';
														echo '<button type="submit" class="btn btn-primary"><i class="fas fa-cart-plus"></i></button>';
													echo '</div>';
												echo '</form>';
											echo '</td>';
										echo '</tr>';

										$row = $result->fetch_assoc();
									}
									echo "</table>";
								} else {
									echo "<p>No hay ningún/a usuario/a</p>";
								}
							} else {
								echo "ERROR al seleccionar los datos";
							}
							$conn->close();
						?>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
