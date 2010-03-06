<?php
abstract class Timer{

	static $name;
	static $start_time;
	static $end_time;
	static $total_time;

	static function start($name){
		self::$name = $name;
		self::$start_time = self::getCurrentTime();
	}

	static function stop(){
		self::$end_time = self::getCurrentTime();
		self::$total_time = round( (self::$end_time - self::$start_time), 3 );
		Util::log( 'TIMER : '. self::$name . ' took ' . self::$total_time.' seconds');	
	}

	static function getCurrentTime(){
		$mtime = explode(" ", microtime()); 
		return $mtime[1] + $mtime[0]; 
	}

}
