<?php
/**
    Main Utilities
    
    Helper functions used throughout the system.
    
    @package utility
*/
function bail( $msg){
	$html = '';
	if (class_exists('Router')){
		$router = Router::singleton();
		$html .= '
				<h1 style="margin-bottom:0;">'.$router->controller.'</h1>
				<h3 style="margin:4px 0;">Action: '.$router->action.'</h3>
				<h3 style="margin:4px 0;">Method: '.$router->method.'</h3>
				<h3 style="margin:6px 0 2px 0;"><u>Params</u></h3></dt> 
				'.array_dump($router->params()).'
				';
	}
	$html .= '
				<h2 style="margin-bottom:2px;">FATAL ERROR</h2>'.$msg.'<br>
				<h2 style="margin-bottom:6px;">BACKTRACE</h2>
				'.backtrace().'
				';

	echo $html;
	trigger_error( strip_tags($msg));
	exit();
}
function backtrace(){
    $trace = debug_backtrace();
    $html = '';
    foreach( $trace as $t){
    		$file = 'FILE: '.$t['file'];
    		$line = 'LINE: '.$t['line'];

            isset($t['class'])	?  $function = $t['class'].'->'.$t['function']
								:  $function = $t['function'];
			$function = 'FUNCTION: '. $function;		

            $html .= "
            			$file <br>
            			$line <br>
            			$function <br><br>
            		 ";			
    }
    return $html;
}
function &getRenderer(){
	static $render = null;
	if( $render === null) $render = new Render();
	return $render;
}
function getUser(){
	return Session::getUser();
}
function getDbcon(){
    return AMP::getDbcon();
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
	if( !class_exists($class)) bail("Class $class does not exist");
	$finder = new $class;
	$objects = $finder->find( array());
	return $objects;
}
function array_dump($array){
		$html = '';
    	foreach( $array as $key => $value){
    		$html .= '['.$key.'] => '.var_export($value, true).'<br/>';
    	}
    	if(!$html) $html = 'empty array<br/>';
    	return $html;
}

function camel_case( $value ) {
    $start_set = split( ',', "_a,_b,_c,_d,_e,_f,_g,_h,_i,_j,_k,_l,_m,_n,_o,_p,_q,_r,_s,_t,_u,_v,_w,_x,_y,_z" );
    $end_set = split( ',', "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z" );
    $camel_cased = str_replace( $start_set, $end_set, $value );
    return $camel_cased;
}


function snake_case( $value ) {
    $start_set = split( ',', "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z" );
    $end_set = split( ',', "_a,_b,_c,_d,_e,_f,_g,_h,_i,_j,_k,_l,_m,_n,_o,_p,_q,_r,_s,_t,_u,_v,_w,_x,_y,_z" );
    $underscored = str_replace( $start_set, $end_set, $value );
    if( substr($underscored, 0, 1) == '_' ) {
        $underscored = substr($underscored,1 );
    }
    return $underscored;
}

function pluralize( $word ) {
    $term_end = substr( $word, -1 );
    // ending in Z
    if ("z" == $term_end ){
        $term_end = substr( $word, -2 );
        if ("zz" == $term_end ) return $word . 'es';
        return $word . 'zes';
    }
    // ending in Y
    if ("y" == $term_end ) return substr( $word, 0, strlen( $word )-1 ). "ies" ;
    // ending in Default 
    if ($term_end != "s" ) return $word ."s";
    else return $word .'es';
    return $word;
}


?>
