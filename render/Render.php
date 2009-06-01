<?
/**
    @package model
*/
class Render{

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
    function form( $action, $controller, $o){
    	if( !( $action && $controller)) {
    		bail( "r->form called without action:$action or controller:$controller being set");
		}
		$attributes = $this->attr( $o);
    	$tokens =	array( 
    					'action' => $action,
    					'controller' => $controller,
    					'attributes' => $attributes,
    					);
    	if ( $o['redirect']) $tokens['redirect'] = '<input type="hidden" name="redirect" value="'.$o['redirect'].'">';
		if ( $o['load']) $tokens['load'] = '<input type="hidden" name="redirect" value="'.$o['load'].'">';		
		return $this->template('template/form_elements/form.html', $tokens);    
    }
    function field( $obj, $field_name, $search_criteria){
       	if ( !is_a( $obj, 'Gtd_Data_Item)')) bail( 'r->field() requires first parameter to be a subclass of GTD_Data_Item');  	
  		$id = $obj->id;
		if ( !$id) $id = 'new';
    	$field_type = $obj->getFieldType( $field_name);
    	$field_id = $field_name.'-'.$obj->_class_name.'-'.$id;
		$tokens =	array( 
    					'name' 	=> $field_id,
    					'id'	=> $field_id
    			    	);
		
		if ( is_array( $field_type)){
			$data = $field_type;
			if ( $id != 'new') $tokens['selected_value'] = $obj->getData( $field_name);
			$tokens['class'] =  $field_name.'-field '.$obj->_class_name.'-field select-field';
			return $this->select( $data, $tokens);
		}
		if ( class_exists( $field_type)){
			$class = $field_type;
			
			if ( $search_criteria) 	{	$objects = getMany( $class, $search_criteria);}
							else	{	$objects = getAll( $class);}
			foreach( $objects as $o){
				$data[$o->id] = $o->getName();
			}
			if ( $id != 'new') $tokens['selected_value'] = $obj->getData( $field_name);
			$tokens['class'] =  $field_name.'-field '.$obj->_class_name.'-field select-field';
			return $this->select( $data, $tokens);
		}
		$tokens['class'] =  $field_name.'-field '.$obj->_class_name.'-field '.$field_type.'-field';
    	return $this->input( $field_type, $tokens);
    }
    function input( $field_type, $tokens){
    	return $this->template( 'template/form_elements/'.$field_type.'.html', $tokens);
    }
   	function select( $data, $o){
	    $attributes_html = '';
	    if( $o['id']) $attributes_html = 'id = "'.$o['id'].'" ';
	    if( $o['class']) $attributes_html = 'class = "'.$o['class'].'" ';
	    if( $o['name']) $attributes_html = 'name = "'.$o['name'].'" ';
	        
	    $options_html = '';
	    if ( $o['title']) $options_html .= '<option value="">'.$o['title'].'</option>';
	    foreach( $data as $value => $description){
	        if ( $value == $o['selected_value']){	$selected = 'selected="selected"';}
	        							else	{	$selected = '';}
	        $options_html .= '<option '.$selected.' value="'.$value.'">'.$description.'</option>';
	    }
	    return "<select $attributes_html>$options_html</select>";
	} 
}
?>
