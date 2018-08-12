<ul class="list-inline">
	<li><a href='index.php'>Inicio</a></li>

	<?php
	try {

		$stmt2 = $db->query('SELECT idpagina, nombrepagina FROM paginas');
		while($row2 = $stmt2->fetch()){
		
			echo '<li><a href="ver_pagina.php?id='.$row2['idpagina'].'">'.$row2['nombrepagina'].'</li>';
		}
	?>

	<?php 				

	} catch(PDOException $e2) {
	    echo $e2->getMessage();
	}
	?>

	<?php 
		if (!isset($_SESSION['nombreusuario'])) {
	?>
		<li><a href="admin/login.php">Login</a></li>
		<li><a href="admin/registrar.php">Registrar</a></li>
		<?php
		}
	?>

	<?php 
		if (isset($_SESSION['nombreusuario'])) {
	?>
		<li><a href="admin/index.php">Panel de administración</a></li>
		<li><a href="admin/logout.php">Logout</a></li>
		<?php
		}
	?>
</ul>
<div class='clear'></div>
<hr />