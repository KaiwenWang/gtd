<?php
/**
    Main Utilities
    
    Helper functions used throughout the system.
    
    @package utility
*/
function bail( $msg){
	echo $msg;
	trigger_error( $msg);
	exit();
}
function &getRenderer(){
	static $render = null;
	if( $render === null) $render = new Render();
	return $render;
}
function getDbcon(){
	return AMP_Registry::getDbcon();
}
function getOne( $class, $search_criteria = array()){
	$finder = new $class();
	$objects = $finder->find( $search_criteria);
	return array_shift($objects);
}
function getMany( $class, $search_criteria = array()){
	$finder = new $class();
	$objects = $finder->find( $search_criteria);
	return $objects;
}
function getAll( $class){
	$finder = new $class;
	$objects = $finder->find( array());
	return $objects;
}
?>