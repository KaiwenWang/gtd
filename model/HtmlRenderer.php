<?
/**
    @package model
*/
class HtmlRenderer{

	var $_class_name = 'HtmlRenderer';

	function HtmlRenderer(){
		$this->__construct();
	}
	function __construct(){
	}
	function view( $view, $data, $options = array()){
	   $path = getViewPath( $view);
	   require_once( $path);
	   return $view( $data, $options);
	}
	function template( $template, $tokens){
	   $tpl = new Template( $template);
	   return $tpl->execute( $tokens);
    }
    function attr( $a = array()){
		$html = '';
    	if( $a['id']) $html .= 'id = "'.$a['id'].'" ';
    	if( $a['class']) $html .= 'class = "'.$a['class'].'" ';
    	if( $a['name']) $html .= 'name = "'.$a['name'].'" ';
    	return $html;
    }
    function form(){
    }
}
?>
