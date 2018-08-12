<?php //include config
require_once('../includes/config.php');

//Si no está logeado redirige a login
if(!$miembro->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin - Agregar publicación</title>
   <!-- <link rel="stylesheet" href="style/estilo1.css">
   <link rel="stylesheet" href="style/estilo2.css"> -->
   <link rel="stylesheet" href="../style/css/bootstrap.css">
  <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
  <!-- DE PRUEBA <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>-->
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

			/*DE PRUEBA
			tinymce.init({
				selector: 'textarea'});*/

  </script>
</head>
<body>

<div class="container">
	<h1>Proyecto DAW 2018</h1>
	<hr />
	<?php include('menu.php');?>
	
	<p><a href="index.php">Volver</a></p>

	<h2>Agregar publicación</h2>

	<?php

	//Si se hace el submit del form, procesarlo
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//Recoger la información del form
		extract($_POST);

		//Validación básica
		if($titulopubli ==''){
			$error[] = 'Introduce un nombre de página.';
		}

		if($resumen ==''){
			$error[] = 'Introduce una descripción.';
		}

		if($contenido ==''){
			$error[] = 'Introduce el contenido.';
		}

		if(!isset($error)){

			try {

				//Hacer insert en BD
				$stmt = $db->prepare('INSERT INTO publicaciones (titulopubli,resumen,contenido,fechapubli) VALUES (:titulopubli, :resumen, :contenido, :fechapubli)') ;
				$stmt->execute(array(
					':titulopubli' => $titulopubli,
					':resumen' => $resumen,
					':contenido' => $contenido,
					':fechapubli' => date('Y-m-d H:i:s')
				));

				//Redirigir a la página principal.
				header('Location: index.php?action=añadida');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//Comprobar si hay errores.
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label>Title</label><br />
		<input type='text' name='titulopubli' value='<?php if(isset($error)){ echo $_POST['titulopubli'];}?>'></p>

		<p><label>Description</label><br />
		<textarea name='resumen' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['resumen'];}?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='contenido' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['contenido'];}?></textarea></p>

		<p><input type='submit' name='submit' value='Aceptar'></p>

	</form>

</div>
