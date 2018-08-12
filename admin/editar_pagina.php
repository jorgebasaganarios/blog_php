<?php //include config
require_once('../includes/config.php');

//Si no está logeado redirige a login
if(!$miembro->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin - Modificar página</title>
   <!-- <link rel="stylesheet" href="style/estilo1.css">
   <link rel="stylesheet" href="style/estilo2.css"> -->
   <link rel="stylesheet" href="../style/css/bootstrap.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div class="container">
	<h1>Proyecto DAW 2018</h1>
	<hr />
	<?php include('menu.php');?>
	
	<p><a href="paginas.php">Volver</a></p>

	<h2>Modificar publicación</h2>


	<?php

	//Si se hace el submit del form, procesarlo
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//Recoger la información del form
		extract($_POST);

		//Validación básica
		if($idpagina ==''){
			$error[] = 'Esta página no tiene una ID válida!.';
		}

		if($nombrepagina ==''){
			$error[] = 'Introduce el nombre de la página.';
		}

		if($contenido ==''){
			$error[] = 'Introduce el contenido de la página.';
		}

		if(!isset($error)){

			try {

				//Hacer insert en BD
				$stmt = $db->prepare('UPDATE paginas SET nombrepagina = :nombrepagina, contenido = :contenido WHERE idpagina = :idpagina') ;
				$stmt->execute(array(
					':nombrepagina' => $nombrepagina,
					':contenido' => $contenido,
					':idpagina' => $idpagina
				));

				//Redirigir a la página principal.
				header('Location: paginas.php?action=actualizada');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//Comprobar si hay errores.
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT idpagina, nombrepagina, contenido FROM paginas WHERE idpagina = :idpagina') ;
			$stmt->execute(array(':idpagina' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='idpagina' value='<?php echo $row['idpagina'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='nombrepagina' value='<?php echo $row['nombrepagina'];?>'></p>

		<p><label>Content</label><br />
		<textarea name='contenido' cols='60' rows='10'><?php echo $row['contenido'];?></textarea></p>

		<p><input type='submit' name='submit' value='Actualizar'></p>

	</form>

</div>

</body>
</html>	
