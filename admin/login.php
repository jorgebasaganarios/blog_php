<?php
//include config
require_once('../includes/config.php');


//Comprobar si está logeado
if( $user->is_logged_in() ){ header('Location: index.php'); } 
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
</head>
<body>

<div id="login">

	<?php

	//Hacer submit del loggin
	if(isset($_POST['submit'])){ 

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if($user->login($username,$password)){ 

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
	<p><label>Nombre: </label><input type="text" name="username" value=""  /></p>
	<p><label>Password: </label><input type="password" name="password" value=""  /></p>
	<p><label></label><input type="submit" name="submit" value="Login"  /></p>
	</form>

</div>
</body>
</html>
