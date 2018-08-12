<?php

include('clase.password.php');

class Miembro extends Password{

    private $db;

	function __construct($db){
		parent::__construct();

		$this->_db = $db;
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

	private function get_user_hash($nombreusuario){

		try {

			$stmt = $this->_db->prepare('SELECT idmiembro, nombreusuario, password FROM miembros WHERE nombreusuario = :nombreusuario');
			$stmt->execute(array('nombreusuario' => $nombreusuario));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}


	public function login($nombreusuario,$password){

		$miembro = $this->get_user_hash($nombreusuario);

		if($this->password_verify($password,$miembro['password']) == 1){

		    $_SESSION['loggedin'] = true;
		    $_SESSION['idmiembro'] = $miembro['idmiembro'];
		    $_SESSION['nombreusuario'] = $miembro['nombreusuario'];
		    return true;
		}
	}


	public function logout(){
		session_destroy();
	}

}


?>
