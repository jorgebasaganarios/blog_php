<?php
//include config
require_once('../includes/config.php');

//Hacer Logout
$user->logout();
header('Location: index.php'); 

?>