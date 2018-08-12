<?php //include config
require_once('../includes/config.php');

//Si no está logeado redirige a login
if(!$miembro->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin - Agregar usuario</title>
   <!-- <link rel="stylesheet" href="style/estilo1.css">
   <link rel="stylesheet" href="style/estilo2.css"> -->
   <link rel="stylesheet" href="../style/css/bootstrap.css">
</head>
<body>

<div class="container">
	<h1>Proyecto DAW 2018</h1>
	<hr />
	<?php include('menu.php');?>
	
	<p><a href="miembros.php">Volver</a></p>

	<h2>Añadir usuario</h2>

	<?php

	//Si se hace el submit del form, procesarlo
	if(isset($_POST['submit'])){

		//Recoger la información del form
		extract($_POST);

		//Validación básica
		if($nombreusuario ==''){
			$error[] = 'Introduce un nombre de usuario.';
		}

		if($password ==''){
			$error[] = 'Introduce una contraseña.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Confirma la contraseña.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Las contraseñas no coinciden.';
		}

		if($email ==''){
			$error[] = 'Introduce tu e-mail.';
		}

		if(!isset($error)){

			$hashedpassword = $miembro->password_hash($password, PASSWORD_BCRYPT);

			try {

				//Hacer insert en BD
				$stmt = $db->prepare('INSERT INTO miembros (nombreusuario,password,email) VALUES (:nombreusuario, :password, :email)') ;
				$stmt->execute(array(
					':nombreusuario' => $nombreusuario,
					':password' => $hashedpassword,
					':email' => $email
				));

				//Redirigir a la página principal.
				header('Location: miembros.php?action=agregado');
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

		<p><label>Nombre:</label><br />
		<input type='text' name='nombreusuario' value='<?php if(isset($error)){ echo $_POST['nombreusuario'];}?>'></p>

		<p><label>Contraseña:</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

		<p><label>Confirma contraseña:</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		<p><label>E-mail:</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>
		
		<p><input type='submit' name='submit' value='Agregar usuario'></p>

	</form>

</div>
