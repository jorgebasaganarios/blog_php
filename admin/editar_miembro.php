<?php //include config
require_once('../includes/config.php');

//Si no está logeado redirige a login
if(!$miembro->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Modificar usuario</title>
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

	<h2>Modificar usuario</h2>


	<?php

	//Si se hace el submit del form, procesarlo
	if(isset($_POST['submit'])){

		//Recoger la información del form
		extract($_POST);

		//Validación básica
		if($nombreusuario ==''){
			$error[] = 'Por favor, introduce el nombre de usuario.';
		}

		if( strlen($password) > 0){

			if($password ==''){
				$error[] = 'Por favor, introduce la contraseña.';
			}

			if($passwordConfirm ==''){
				$error[] = 'Confirma la contraseña.';
			}

			if($password != $passwordConfirm){
				$error[] = 'Las contraseñas no coinciden.';
			}

		}
		

		if($email ==''){
			$error[] = 'Introduce la dirección de e-mail.';
		}

		if(!isset($error)){

			try {

				if(isset($password)){

					$hashedpassword = $miembro->password_hash($password, PASSWORD_BCRYPT);

					//Actualizar en la BD.
					$stmt = $db->prepare('UPDATE miembros SET nombreusuario = :nombreusuario, password = :password, email = :email WHERE idmiembro = :idmiembro') ;
					$stmt->execute(array(
						':nombreusuario' => $nombreusuario,
						':password' => $hashedpassword,
						':email' => $email,
						':idmiembro' => $idmiembro
					));


				} else {

					//Actualizar BD.
					$stmt = $db->prepare('UPDATE miembros SET nombreusuario = :nombreusuario, email = :email WHERE idmiembro = :idmiembro') ;
					$stmt->execute(array(
						':nombreusuario' => $nombreusuario,
						':email' => $email,
						':idmiembro' => $idmiembro
					));

				}
				

				//Redirigir a la página principal.
				header('Location: miembros.php?action=updated');
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

			$stmt = $db->prepare('SELECT idmiembro, nombreusuario, email FROM miembros WHERE idmiembro = :idmiembro') ;
			$stmt->execute(array(':idmiembro' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='idmiembro' value='<?php echo $row['idmiembro'];?>'>

		<p><label>nombreusuario</label><br />
		<input type='text' name='nombreusuario' value='<?php echo $row['nombreusuario'];?>'></p>

		<p><label>Password (only to change)</label><br />
		<input type='password' name='password' value=''></p>

		<p><label>Confirm Password</label><br />
		<input type='password' name='passwordConfirm' value=''></p>

		<p><label>Email</label><br />
		<input type='text' name='email' value='<?php echo $row['email'];?>'></p>

		<p><input type='submit' name='submit' value='Actualizar'></p>

	</form>

</div>

</body>
</html>	
