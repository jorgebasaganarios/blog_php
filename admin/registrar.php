<?php
//include config
require_once('../includes/config.php');
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Register</title>
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

<div id="login">


<!-- 
FORM DE LOGIN ANTERIOR

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

-->

<div class="modal-dialog modal-login">
    <?php 
    if(isset($_GET['action'])){ 
    echo '<h3>Usuario '.$_GET['action'].'! <a href="..\index.php">Ir a Inicio</a>.</h3>'; 
    } 
    ?>
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Formulario de registro:</h4>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
      </div>
      <div class="modal-body">

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
                header('Location: login.php?action=registrado');
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

        <form action="" method="post">
          <div class="form-group">
            <i class="fa fa-user"></i>
            <input type="text" class="form-control" name="nombreusuario" placeholder="Nombre" required="required" value="<?php if(isset($error)){ echo $_POST['nombreusuario'];}?>">
          </div>
          <div class="form-group">
            <i class="fa fa-lock"></i>
            <input type="password" class="form-control" name="password" placeholder="Password" required="required" value="<?php if(isset($error)){ echo $_POST['password'];}?>">
          </div>
          <div class="form-group">
            <i class="fa fa-lock"></i>
            <input type="password" class="form-control" name="passwordConfirm" placeholder="Confirma Password" required="required" value="<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>">
          </div>
          <div class="form-group">
            <i class="fa fa-user"></i>
            <input type="text" class="form-control" name="email" placeholder="E-mail" required="required" value="<?php if(isset($error)){ echo $_POST['email'];}?>">
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block btn-lg" name="submit" value="Registrar">
          </div>
        </form>       
        <a href="..\index.php">Ir a Inicio</a>.
      </div>
    </div>
  </div>

</div>
</body>
</html>