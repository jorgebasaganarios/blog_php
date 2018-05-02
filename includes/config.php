<?php
ob_start();
session_start();

//Datos de la BD
define('DBHOST','localhost');
define('DBUSER','jorgebr');
define('DBPASS','321jbr');
define('DBNAME','proyecto_php');

$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//El Timezone
date_default_timezone_set('Europe/Madrid');

//Cargar las clases necesarias
function __autoload($class) {
   
   $class = strtolower($class);

	//Si la llamada es desde assets
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	
	//Si la llamada es desde el admin
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//si la llamada es desde admin
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 		
	 
}

$user = new User($db); 
?>