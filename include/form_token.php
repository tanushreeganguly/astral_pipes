<?php

class FormToken{
	
	private $formkey;
	private $oldkey;
	
	function __construct(){
		if( isset( $_SESSION['csrf'] ) ){
			$this->oldkey = $_SESSION['csrf'];
		}
	}
	
	private function generateKey(){
		$ip = $_SERVER['REMOTE_ADDR'];
		$uniqid = uniqid( mt_rand(), true );
		return md5( $ip.$uniqid );
	}
	
	public function outputKey(){
		$this->formkey = $this->generateKey();
		$_SESSION['csrf'] = $this->formkey;
		
		echo '<input type="hidden" name="csrf" value="'.$this->formkey.'" id="csrf">';
	}
	
	public function validateKey(){
		if( $_POST['csrf'] == $this->oldkey ){			
			return true;
		}
		else{			
			return false;
		}
	}
}

?>