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
function getRenderer(){
	if (  $GLOBALS["render"]) {
		return $GLOBALS["render"];
	} else {
		$GLOBALS["render"] = new Render();
		return $GLOBALS["render"];
	}
}
function getDbcon(){
	return AMP_Registry::getDbcon();
}
function getUser(){
    return new Staff( getUserId());
}
function getUserId(){
	trigger_error('NOT WRITTEN!');
}
function getViewPath( $view){
    $viewDirectory = getViewDirectory();
    return $viewDirectory[$view];
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
