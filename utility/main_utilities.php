<?php
/**
    Main Utilities
    
    Helper functions used throughout the system.
    
    @package utility
*/
function bail( $msg){
	echo $msg.'<br><br>';
	$trace = debug_backtrace();
//	AMP_dump($trace);
	$html = '<span style="text-decoration:underline">BACKTRACE</span><br><br>';
	foreach( $trace as $t){
		$html .= 'FILE: '.$t['file'].'<br>';
		$html .= 'LINE: '.$t['line'].'<br>';
		if(isset($t['class'])) {
			$function = $t['class'].'->'.$t['function'];
		} else{
			$function = $t['function'];
		}
		$html .= 'FUNCTION: '.$function.'<br>';
		$html .= '<br>';
	}
	echo $html;
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