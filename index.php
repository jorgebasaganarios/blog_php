<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Proyecto DAW 2018</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div id="wrapper">

		<h1>Blog</h1>
		<hr />

		<ul id='adminmenu'>
			<li><a href='index.php'>Inicio</a></li>
			<li><a href='who.php'>Sobre el autor</a></li>
			<li><a href="contact.php">Datos de contacto</a></li>

			<?php 
				if (!isset($_SESSION['username'])) {
			?>
			<li><a href="admin/login.php">Login</a></li>
			<li><a href="admin/register.php">Register</a></li>
			<?php
				}
			?>

			<?php 
				if (isset($_SESSION['username'])) {
			?>
			<li><a href="admin/index.php">Panel de administración</a></li>
			<li><a href="admin/logout.php">Logout</a></li>
			<?php
				}
			?>

		</ul>
		<div class='clear'></div>
		<hr />

		<?php
			try {

				$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
						echo '<p>Publicado el '.date('jS M Y H:i:s', strtotime($row['postDate'])).'</p>';
						echo '<p>'.$row['postDesc'].'</p>';				
						echo '<p><a href="viewpost.php?id='.$row['postID'].'">Leer más</a></p>';				
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>

	</div>


</body>
</html>