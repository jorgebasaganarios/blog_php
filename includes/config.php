<?php
ob_start();
session_start();

//Datos de la BD
define('DBHOST','localhost');
define('DBUSER','jorgebr');
define('DBPASS','321jbr');
define('DBNAME','proyectophp');

$db = new PDO("mysql:host=".DBHOST.";port=3306;dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//El Timezone
date_default_timezone_set('Europe/Madrid');

//Función para cargar las clases
function __autoload($class) {
   
   $class = strtolower($class);

	//Si la llamada es desde los assets
   $classpath = 'clases/clase.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//Si la llamada es desde el admin
   $classpath = '../clases/clase.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//si la llamada es desde admin
   $classpath = '../../clases/clase.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 		
	 
}

$miembro = new Miembro($db); 
?>