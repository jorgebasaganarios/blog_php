<?php
//include config
require_once('../includes/config.php');

//Comprobar si está logeado
if( $miembro->is_logged_in() ){ header('Location: index.php'); } 
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
	<!-- <link rel="stylesheet" href="style/estilo1.css">
	<link rel="stylesheet" href="style/estilo2.css"> -->
    <link rel="stylesheet" href="../style/forms/forms.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<!-- 
FORM DE LOGIN ANTERIOR

<div id="login">	

	<form action="" method="post">
	<p><label>Nombre: </label><input type="text" name="nombreusuario" value=""  /></p>
	<p><label>Password: </label><input type="password" name="password" value=""  /></p>
	<p><label></label><input type="submit" name="submit" value="Login"  /></p>
	</form>

</div> 

-->


	<div class="modal-dialog modal-login">
	<?php 
	if(isset($_GET['action'])){ 
		echo '<h3>Usuario '.$_GET['action'].'!</h3>'; 
	} 
	?>
		<div class="modal-content">
			<div class="modal-header">				
				<h4 class="modal-title">Formulario de login:</h4>
				<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
			</div>
			<div class="modal-body">

				<?php

				//Hacer submit del loggin
				if(isset($_POST['submit'])){

					$nombreusuario = trim($_POST['nombreusuario']);
					$password = trim($_POST['password']);
					
					if($miembro->login($nombreusuario,$password)){

						//Al logearse volver a la página princial
						header('Location: index.php');
						exit;

					} else {
						$message = '<p class="error">Usuario o contraseña erróneos.</p>';
					}

				}

				if(isset($message)){ echo $message; }
				?>

				<form action="" method="post">
					<div class="form-group">
						<i class="fa fa-user"></i>
						<input type="text" class="form-control" name="nombreusuario" placeholder="Username" required="required">
					</div>
					<div class="form-group">
						<i class="fa fa-lock"></i>
						<input type="password" class="form-control" name="password" placeholder="Password" required="required">
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-block btn-lg" name="submit" value="Login">
					</div>
					<a href="..\index.php">Ir a Inicio</a>.
				</form>	
		</div>
	</div>

</body>
</html>
