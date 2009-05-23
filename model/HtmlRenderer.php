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
    function expandable( $small_html, $large_html, $options){
        $html = "
            <div class='small-expandable'>
                $small_html
            </div>
            <div class='large-expandable'>
                $large_html
            </div>
        ";
        return $html;
    }
}
?>
