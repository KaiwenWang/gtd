<?php
/**
    Main Utilities
    
    Helper functions used throughout the system.
    
    @package utility
*/
#require_once('../gtd_includes.php');
function getRenderer(){
	return new HtmlRenderer();
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
    require_once( 'view_directory.php');
    $viewDirectory = getViewDirectory();
    return $viewDirectory[$view];
}
?>
