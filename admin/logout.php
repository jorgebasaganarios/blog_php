<?php
//include config
require_once('../includes/config.php');

//Hacer Logout
$miembro->logout();
header('Location: ..\index.php'); 

?>