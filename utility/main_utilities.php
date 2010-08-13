<?php
/**
    Main Utilities
    
    Helper functions used throughout the system.
    
    @package utility
*/
function bail( $msg){
	if(is_array($msg)) $msg = array_dump($msg);
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
				<h2 style="margin-bottom:2px;">ERROR MESSAGE</h2>'.$msg.'<br>
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
	if(is_array($objects)) return array_shift($objects);
}
function getMany( $class, $search_criteria = array()){
	if(empty($search_criteria)) return getAll($class);
	foreach($search_criteria as $key=>$value) if( empty($value)) unset( $search_criteria[$key]);
	$finder = new $class();
	$objects = $finder->find( $search_criteria);
	if(!$objects) $objects = array();
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

class Util {
	function date_format($string = false){
		return self::date_format_from_time( strtotime( $string ));
	}
	function date_format_from_time($time = false){
		if( !$time ) $time = time();
		return date('Y-m-d',$time);
	}
	function current_date(){
		return self::date_format_from_time( time());
	}
	function pretty_date($date){
		return date('m/d/Y',strtotime($date));
	}
    function is_a_date($date) {
        $null_dates = array(
            'mysql' => '0000-00-00',
            'unix' => '1969-12-31',
            'preamp' => '00-00-0000');
        return !(in_array($date, $null_dates) || !$date || $date < 0);
    }

    function start_of_month($date) {
        $start_date = strtotime($date);
        $start_month = date('m', $start_date);
		$start_year = date('Y', $start_date);

        $start_day = date('j', $start_date);
		if( $start_day >= 28 ) $start_month = $start_month + 1;

        return mktime( 0, 0, 0, $start_month, 1, $start_year );
    }

    function end_of_month($date) {
        $timestamp = strtotime($date);
        $one_month_later = strtotime("+1 month", $timestamp);
        $start_of_month = Util::start_of_month(date('Y-m-d', $one_month_later));
        $end_of_month = strtotime("-1 day", $start_of_month);
        return $end_of_month; 
    }

	function start_of_current_month(){
        $start_date = strtotime();
        $start_month = date('m', $start_date);
		$start_year = date('Y', $start_date);

        return mktime( 0, 0, 0, $start_month, 1, $start_year );

	}
	function end_of_current_month(){
        $start_of_month = Util::start_of_current_month();
        $one_month_later = strtotime("+1 month", $start_of_month);
        $end_of_month = strtotime("-1 day", $one_month_later);
        return $end_of_month; 
	}
    function percent_of_month_from_start($date) {
        $day_of_month = date('j', strtotime($date));

		if( $day_of_month < 10 ){
			return 0;	
		} elseif( $day_of_month < 20 ) {
			return .5;
		} else {
			return 1;
		}		
    }

    function percent_of_month_from_end($date) {
        $day_of_month = date('j', strtotime($date));

		if( $day_of_month > 20 ){
			return 0;	
		} elseif( $day_of_month > 10 ) {
			return .5;
		} else {
			return 1;
		}		
    }
    function dump($value) {
        print("<pre>");
        print_r($value);
        print("</pre>");
    }

    function days_in_month($date) {
        $timestamp = strtotime($date);
        $one_month_later = strtotime("+1 month", $timestamp);
        $start_of_month = Util::start_of_month(date('Y-m-d', $one_month_later));
        $end_of_month = strtotime("-1 day", $start_of_month);
        return date('d', $end_of_month);
    }
	function include_directory($path){
		$d = dir( rtrim($path,'/') ); 
		while (false!== ($filename = $d->read())) { 
			$file_path = "$path/$filename";
			if (substr($filename, -4) == '.php') {
	  			require_once $file_path; 
 			}
			if (is_dir($file_path) &&  $filename != '.' && $filename != '..'){
				self::include_directory($file_path);
			}
		} 
		$d->close(); 
	}
	function log($msg){
		trigger_error( "GTD LOGGER:: " . strip_tags($msg) );
#		echo $msg;
	}

	function isTestMode(){
		if( defined('TEST_MODE')) return TEST_MODE;
	}
}
