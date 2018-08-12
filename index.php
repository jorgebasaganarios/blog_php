<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Proyecto DAW 2018</title>
   <!-- <link rel="stylesheet" href="style/estilo1.css">
   <link rel="stylesheet" href="style/estilo2.css"> -->
   <link rel="stylesheet" href="style/css/bootstrap.css">
</head>
<body>

	<div class="container">

		<h1>Blog Proyecto DAW 2018</h1>
		<hr />

		<?php include('menu_pagina.php');?>

		<?php
			try {

				$stmt = $db->query('SELECT idpubli, titulopubli, resumen, fechapubli FROM publicaciones ORDER BY idpubli DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h1><a href="ver_publi.php?id='.$row['idpubli'].'">'.$row['titulopubli'].'</a></h1>';
						echo '<p>Publicado el '.date('jS M Y H:i:s', strtotime($row['fechapubli'])).'</p>';
						echo '<p>'.$row['resumen'].'</p>';				
						echo '<p><a href="ver_publi.php?id='.$row['idpubli'].'">Leer más</a></p>';				
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	</div>

</body>
</html>