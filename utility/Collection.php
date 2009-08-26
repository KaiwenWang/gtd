<?php
class Collection {
  private $properties = array();

  public function __set($key, $value) {
    if (is_array($value)) {
      $this->$key = $value;
    } else {
      $this->properties[$key] = $value;
    }
  }

  public function __get($key) {
    if (array_key_exists($key, $this->properties)) {
      return $this->properties[$key];
    }
    return null;
  }
} 
?>