<?php
/**
    @package model
*/
/*
$r = getRenderer();
$hour = new Hour();

$html = $r->field( $hour, 'estimate_id', array('staff'=>''));
name='Model[Hour][new][estimate_id]'
$_POST['Model']['Hour'][123]['estimate_id'];

*/
class Render{

	var $_class_name = 'Render';
	var $json;
	var $system_messages;

	function __construct(){
		$this->json = new Services_JSON();
	}
	function view( $view_function_name, $data, $options = array()){
	   	$viewDirectory =& getViewDirectory();
	   	$path = $viewDirectory->find( $view_function_name );
	   	if( !$path) bail("<b>$view_function_name</b> cannot be found. Please add it to the View Directory.");
	   	if( !file_exists($path)) bail("View file <b>$path</b> does not exist, or has not been added to the View Directory.");
		require_once( $path);
	   	return $view_function_name( $data, $options);
	}
	function template( $template, $tokens){
	   $tpl = new Template( $template);
	   return $tpl->execute( $tokens);
    }
    function attr( $a = array()){
		$html = '';
    	if( isset($a['id']) && $a['id']) $html .= 'id = "'.$a['id'].'" ';
    	if( isset($a['class']) && $a['class']) $html .= 'class = "'.$a['class'].'" ';
    	if( isset($a['name']) && $a['name']) $html .= 'name = "'.$a['name'].'" ';
    	return $html;
    }
    function msg( $type, $text){
    	$msg = $this->template('template/message.html', array( 'type'=>$type, 'message'=>$text));
		$this->system_messages .= $msg;
    }
    function json( $data){
    	return $this->json->encode( $data);
    }
    function css($stylesheet){
    	$html = '<link rel="Stylesheet" href="css/'.$stylesheet.'" type="text/css" />';
    }
    function link( $controller, $parameters, $text = false, $o = array()){
	    $attributes_html = $this->attr( $o);
	    if( is_a( $parameters, 'ActiveRecord')){
			$obj = $parameters;
			if ( !$text) $text = $obj->getName();
	    }
    	return '<a href="'.$this->url( $controller, $parameters).'" '.$attributes_html.'>'.$text.'</a>';
    }
    function url( $controller, $parameters){
	    if( is_a( $parameters, 'ActiveRecord')){
			$obj = $parameters;
			$parameters = array( 'id' => $obj->id );
	    }
    	return 'index.php?controller='.$controller.'&'.http_build_query($parameters);
    }
    function form( $action, $controller, $content, $o = array()){
    	if( !( $action && $controller)) {
    		bail( "r->form called without action:$action or controller:$controller being set");
		}
		$attributes = $this->attr( $o);
    	$tokens =	array( 
    					'action' => $action,
    					'controller' => $controller,
    					'attributes' => $attributes,
    					'form-content' => $content
    					);
    	if ( isset( $o['redirect'])) $tokens['redirect'] = $this->input( 	'hidden',
    																array(	'name'=>'redirect',
    																		'value'=>$o['redirect']));
	    else $tokens['redirect'] = '';
		return $this->template('template/form_elements/form.html', $tokens);    
    }
    function field( $obj, $field_name, $search_criteria = array()){
       	if ( !is_a( $obj, 'ActiveRecord')) bail( 'r->field() requires first parameter to be a subclass of ActiveRecord');  	
  		$id = $obj->id;
		if ( !$id) $id = 'new';
    	$field_type = $obj->getFieldType( $field_name);
    	$field_id = 'ActiveRecord['.$obj->_class_name."][$id][$field_name]";
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
			if( !$search_criteria) $search_criteria = $obj->defaultSearchCriteria( $field_name);
			if( $search_criteria) 	{	$objects = getMany( $class, $search_criteria);}
							else	{	$objects = getAll( $class);}
			foreach( $objects as $o){
				$data[$o->id] = $o->getName();
			}
			if ( $id != 'new') $tokens['selected_value'] = $obj->getData( $field_name);
			$tokens['class'] =  $field_name.'-field '.$obj->_class_name.'-field select-field';
			return $this->select( $data, $tokens);
		}
		if ( $id != 'new') $tokens['value'] = $obj->getData( $field_name);
		$tokens['class'] =  $field_name.'-field '.$obj->_class_name.'-field '.$field_type.'-field';
    	return $this->input( $field_type, $tokens);
    }
    function input( $field_type, $tokens = array()){
    	if ( !( isset( $tokens['attributes']) && $tokens['attributes'])) $tokens['attributes'] = $this->attr($tokens);
    	if ( !( isset( $tokens['size']) && $tokens['size'])) $tokens['size'] = 15;
    	if ( isset( $tokens['value'])) $tokens['value'] = htmlentities($tokens['value']);
    	return $this->template( 'template/form_elements/'.$field_type.'.html', $tokens);
    }
   	function select( $data, $o){
   		if (!$o['name']) bail('A select field must have token["name"] passed to it in order to work');
	    $attributes_html = $this->attr( $o);
	    $options_html = '';
	    if ( isset( $o['title']) && $o['title']) $options_html .= '<option value="">'.$o['title'].'</option>';
	    foreach( $data as $value => $description){
	        if ( isset( $o['selected_value']) && $value == $o['selected_value']){	$selected = 'selected="selected"';}
	        							else	{	$selected = '';}
	        $options_html .= '<option '.$selected.' value="'.$value.'">'.$description.'</option>';
	    }
	    if ( isset( $o['select_none']) && $o['select_none']) $options_html = '<option value="">'.$o['select_none'].'</option>'.$options_html;
	    return "<select $attributes_html>$options_html</select>";
	}
	function objectSelect( $obj, $tokens, $search_criteria = array()){	
       	if ( !is_a( $obj, 'ActiveRecord')) bail( 'r->field() requires first parameter to be an ActiveRecord object');
  		$id = $obj->id;
		if ( !$id) $id = 'new';
		if ( $search_criteria) 	{	$objects = getMany( $obj->_class_name, $search_criteria);}
	    				else	{	$objects = getAll( $obj->_class_name);}
	    foreach( $objects as $o){
	    	$data[$o->id] = $o->getName();
	    }
	    if ( $id != 'new') $tokens['selected_value'] = $obj->id;
	    return $this->select( $data, $tokens);	
	}
	function classSelect( $class, $tokens, $search_criteria){
		if( !class_exists($class)) bail("Class \"$class\" does not exist.");
		if ( $search_criteria) 	{	$objects = getMany( $class, $search_criteria);}
	    				else	{	$objects = getAll( $class);}
	    foreach( $objects as $o){
	    	$data[$o->id] = $o->getName();
	    }
	    return $this->select( $data, $tokens);	
	}
	function submit(){
		return $this->input( 'submit');
	}
	// Don't ever call dumpMessages, it's used by the FrontController.
    function _dumpMessages(){
    	return $this->system_messages;
    }
}
?>
