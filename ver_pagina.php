<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT idpagina, nombrepagina, contenido, fechacreacion FROM paginas WHERE idpagina = :idpagina');
$stmt->execute(array(':idpagina' => $_GET['id']));
$row = $stmt->fetch();

//Redireccionar si el post no existe.
if($row['idpagina'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Blog Proyecto DAW 2018 - <?php echo $row['nombrepagina'];?></title>
   <!-- <link rel="stylesheet" href="style/estilo1.css">
   <link rel="stylesheet" href="style/estilo2.css"> -->
   <link rel="stylesheet" href="style/css/bootstrap.css">
</head>
<body>

	<div class="container">

		<h1>Blog Proyecto DAW 2018</h1>
		<hr />
		<?php include('menu_pagina.php');?>
		<div class='clear'></div>


		<?php	
			echo '<div>';
				echo '<h1>'.$row['nombrepagina'].'</h1>';
				echo '<p>Creado en '.date('jS M Y', strtotime($row['fechacreacion'])).'</p>';
				echo '<p>'.$row['contenido'].'</p>';
			echo '</div>';
		?>

	</div>

</body>
</html>