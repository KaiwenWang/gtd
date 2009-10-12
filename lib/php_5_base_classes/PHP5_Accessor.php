<?php
class PHP5_Accessor {

	public function __set($key, $value) {
		$setter_method ='set'.ucfirst($key);
		
		if ( method_exists( $this, $setter_method)){
			return $this->$setter_method( $value);
		}
		$this->$key = $value;
	}
	public function __get($key) {
		$getter_method ='get'.ucfirst($key);
		
		if ( method_exists( $this, $getter_method)){
			return $this->$getter_method();
		}
		return $this->$key;
	}
}
?>