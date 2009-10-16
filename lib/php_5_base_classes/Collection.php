<?php
class Collection {
  private $properties = array();

  public function __set($key, $value) {
  	$setter_method ='set'.ucfirst($key);
  	if ( method_exists( $this, $setter_method)){
  		return $this->$setter_method = $value;
  	}
    if (is_array($value)) {
      $this->$key = $value;
    } else {
      $this->properties[$key] = $value;
    }
  }

  public function __get($key) {
  	$getter_method ='get'.ucfirst($key);
  	if ( method_exists( $this, $getter_method)){
  		return $this->$getter_method;
  	}
    if (array_key_exists($key, $this->properties)) {
      return $this->properties[$key];
    }
    return null;
  }
}
?>