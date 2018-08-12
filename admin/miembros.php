<?php
//include config
require_once('../includes/config.php');

//Si no está logeado redirige a login
if(!$miembro->is_logged_in()){ header('Location: login.php'); }

//Mostrar mensaje desde las páginas de añadir y editar.
if(isset($_GET['deluser'])){ 

	//Si el ID de usuario es 1 ignorar, para no perder el usuario maestro.
	if($_GET['deluser'] !='1'){

		$stmt = $db->prepare('DELETE FROM miembros WHERE idmiembro = :idmiembro') ;
		$stmt->execute(array(':idmiembro' => $_GET['deluser']));

		header('Location: miembros.php?action=eliminado');
		exit;

	}
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Usuarios</title>
   <!-- <link rel="stylesheet" href="style/estilo1.css">
   <link rel="stylesheet" href="style/estilo2.css"> -->
    <link rel="stylesheet" href="..\style/tables/tables.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="/style/tables/tables.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
	  if (confirm("Estás seguro de que quieres eliminar '" + title + "'"))
	  {
	  	window.location.href = 'miembros.php?deluser=' + id;
	  }
  }
  </script>
</head>
<body>

	<div class="container">
		<h1>Proyecto DAW 2018</h1>
		<hr />
		<?php include('menu.php');?>

		<?php 
		//Mostrar mensaje desde las páginas de añadir y editar.
		if(isset($_GET['action'])){ 
			echo '<h3>Usuario '.$_GET['action'].'.</h3>'; 
		} 
		?>

	</div>

	<div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Usuarios</h2></div>
                    <!-- <div class="col-sm-4">
                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                    </div> -->
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                		<th>Nombre de usuario</th>
						<th>Email</th>
						<th>Modificar/Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        	try {
							$stmt = $db->query('SELECT idmiembro, nombreusuario, email FROM miembros ORDER BY nombreusuario');
							while($row = $stmt->fetch()){
							
							echo '<tr>';
							echo '<td>'.$row['nombreusuario'].'</td>';
							echo '<td>'.$row['email'].'</td>';
						?>
                            <td>
	                            <a href="editar_miembro.php?id=<?php echo $row['idmiembro'];?>" class="edit" title="Edit"><i class="material-icons">&#xE254;</i></a>
	                            <a href="javascript:deluser('<?php echo $row['idmiembro'];?>','<?php echo $row['nombreusuario'];?>')" class="delete" title="Delete"><i class="material-icons">&#xE872;</i></a>
                        	</td>
                        <?php 
									echo '</tr>';

								}

							} catch(PDOException $e) {
							    echo $e->getMessage();
							}
						?>
                    </tr>	
                </tbody>
            </table>
            <p><a href='add_miembro.php'>+ Añadir usuario</a></p>
        </div>
	</div>
</body>
</html>
