<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT idpubli, titulopubli, contenido, fechapubli FROM publicaciones WHERE idpubli = :idpubli');
$stmt->execute(array(':idpubli' => $_GET['id']));
$row = $stmt->fetch();

//Redireccionar si el post no existe.
if($row['idpubli'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Blog Proyecto DAW 2018 - <?php echo $row['titulopubli'];?></title>
   <link rel="stylesheet" href="style/css/bootstrap.css">
</head>
<body>

	<div class="container">

		<h1>Blog Proyecto DAW 2018</h1>
		<hr />
		<?php include('menu_pagina.php');?>
		

		<?php	
			echo '<div>';
				echo '<h1>'.$row['titulopubli'].'</h1>';
				echo '<p>Publicado en '.date('jS M Y', strtotime($row['fechapubli'])).'</p>';
				echo '<p>'.$row['contenido'].'</p>';
			echo '</div>';
		?>
	</div>

</body>
</html>