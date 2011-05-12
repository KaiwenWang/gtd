<?php
class Render{

	var $json;
	var $system_messages;

	function __construct(){
		$this->json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
	}
	function view( $view_function_name, $data, $options = array()){
	   	$viewDirectory = ViewDirectory::singleton();
	   	$path = $viewDirectory->find( $view_function_name );
	   	if( !$path) bail("<b>$view_function_name</b> cannot be found. Please add it to the View Directory.");
	   	if( !file_exists($path)) bail("View file <b>$path</b> does not exist, or has not been added to the View Directory.");
		require_once( $path);
	   	$response = $view_function_name( $data, $options);
		if(empty($options['get_tokens']) && is_array($response)) return $response['body'];
		return $response;
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
    static function msg( $text, $type='good'){
        $r = getRenderer();
        $msg = $r->template('templates/message.html', array( 'type'=>$type, 'message'=>$text));
        if(empty($_SESSION['gtd_msg'])) $_SESSION['gtd_msg'] = ''; 
        $_SESSION['gtd_msg'] .= $msg;
    } 
    function jsonEncode( $data){
    	return $this->json->encode( $data);
    }
    function jsonDecode( $data){
    	return $this->json->decode( $data);
    }    
    function css($stylesheet){
    	$html = '<link rel="Stylesheet" href="css/'.$stylesheet.'" type="text/css" />';
    }
	function objectSelect( $obj, $tokens, $search_criteria = array()){	
       	if ( !is_a( $obj, 'ActiveRecord')) bail( 'r->field() requires first parameter to be an ActiveRecord object');
  		$id = $obj->id;
		if ( !$id) $id = 'new';
		if ( $search_criteria) 	{	$objects = getMany( get_class($obj), $search_criteria);}
	    				else	{	$objects = getAll( get_class($obj));}
	    foreach( $objects as $o){
	    	$data[$o->id] = $o->getName();
	    }
	    if ( $id != 'new') $tokens['selected_value'] = $obj->id;
	    return $this->select( $data, $tokens);	
	}
	function classSelect( $class, $tokens, $search_criteria = array()){
		if( !class_exists($class)) bail("Class \"$class\" does not exist.");
		if ( $search_criteria) 	{	$objects = getMany( $class, $search_criteria);}
    else {	$objects = getAll( $class);}
	    foreach( $objects as $o){
	    	$data[$o->id] = $o->getName();
	    }
	    return $this->select( $data, $tokens);	
	}

	// Don't ever call dumpMessages, it's used by the FrontController.
	function _dumpMessages(){
		if(empty($_SESSION['gtd_msg'])) return;
		$msg = $_SESSION['gtd_msg'];
		unset($_SESSION['gtd_msg']);
		return $msg;
    }
/* REFACTORED!  PLEASE USE NEW HOTNESS INSTEAD */

	// refactored to UI:link($params,$o);
    function link( $controller, $parameters, $text = false, $o = array()){
		$parameters['controller'] = $controller;
		$parameters['text'] = $text;
		return UI::link($parameters,$o);
    }
	// refactored to Router:url($params);
    function url( $controller, $parameters){
    	$paramaters['controller'] = $controller;
		return Router::url($parameters);
	}
	// refactored to Form and Fieldset objects
    function form( $o ){
    	if( !( $o['action'] )) {
    		bail( "r->form called without action being set");
		}
    	if( !$o['controller'] ) {
    		bail( "r->form called without controller being set");
		}

		isset($o['method'])	? $method = $o['method']
							: $method = 'post';
							
		$attributes = $this->attr($o);

    	$tokens = array( 
    					'action' => $o['action'],
    					'controller' => $o['controller'],
    					'method' => $method,
    					'attributes' => $attributes,
    					'form-content' => $o['content']
    					);
    	
		return $this->template('templates/form_elements/form.html', $tokens);    
    }
    
    function field( $obj,$field_name,$search_criteria = array(),$new_object_index = 0){

       	if ( !is_a( $obj, 'ActiveRecord')) bail( 'r->field() requires first parameter to be a subclass of ActiveRecord');  	

		$model_type = get_class($obj);

  		$id = $obj->id;
		if ( !$id) {
			isset($new_object_index)	? $id = 'new-'.$new_object_index
										: $id = 'new';
		}
		
    	$field_type = $obj->getFieldType( $field_name);
    	$field_id = "ActiveRecord[$model_type][$id][$field_name]";
		$tokens =	array( 
    					'name' 	=> $field_id,
    					'id'	=> $field_id
    			    	);	

		if( isset($search_criteria['name'])){
			$tokens['name'] = $search_criteria['name'];
			unset($search_criteria['name']);
		}
		if( isset($search_criteria['selected_value']) ){
			$tokens['selected_value'] = $search_criteria['selected_value'];
			unset($search_criteria['selected_value']);
		}

		if( isset($search_criteria['select_none']) ){
			$tokens['select_none'] = $search_criteria['select_none'];
			unset($search_criteria['select_none']);
		}

		if( isset($search_criteria['title']) ){
			$tokens['title'] = $search_criteria['title'];
			unset($search_criteria['title']);
		}
		if ( is_array( $field_type)){
			$data = $field_type;
			if ( $id != 'new') $tokens['selected_value'] = $obj->getData( $field_name);
			$tokens['class'] =  "$field_name-field $model_type-field select-field";
			return $this->select( $data, $tokens);
		}

		if ( class_exists( $field_type)){
			$class = $field_type;
		 
			$search_criteria ? $objects = $class::getMany( $search_criteria)
							 : $objects = $class::getAll();
			if( $objects ) {
				foreach( $objects as $o) $data[$o->id] = $o->getName();
			} else {
				$data = array();
			}
			if ( $obj->get($field_name)){
				$tokens['selected_value'] = $obj->get( $field_name);
			}

			$tokens['class'] =  "$field_name-field $model_type-field select-field";
			return $this->select( $data, $tokens);
		}
		if ( $id != 'new') $tokens['value'] = $obj->getData( $field_name);
		$tokens['class'] =  "$field_name-field $model_type-field $field_type-field";
    	return $this->input( $field_type, $tokens);
    }
    function input( $field_type, $tokens = array()){
		if ($field_type == 'date') $tokens['class'] = 'date-field';	
    	if ( !( isset( $tokens['attributes']) && $tokens['attributes'])) $tokens['attributes'] = $this->attr($tokens);
    	if ( !( isset( $tokens['size']) && $tokens['size'])) $tokens['size'] = 15;
    	if ( isset( $tokens['value'])) $tokens['value'] = htmlspecialchars( $tokens['value']);
		if ( $field_type == "bool"){
			if (!empty($tokens['value'])) $tokens['checked'] = 'CHECKED';
		}
    	return $this->template( 'templates/form_elements/'.$field_type.'.html', $tokens);
    }
   	function select( $data, $o){
   		if (!$o['name']) bail('A select field must have token["name"] passed to it in order to work');
	    $attributes_html = $this->attr( $o);
	    $options_html = '';
		if ( isset( $o['title']) && $o['title']) $options_html .= '<option value="">'.htmlspecialchars($o['title']).'</option>';
	    foreach( $data as $value => $description){
        if ( isset( $o['selected_value']) && ($value == $o['selected_value'])){	
          $selected = 'selected="selected"';}
        else{	
          $selected = '';
        }
        $options_html .= '<option '.$selected.' value="'.$value.'">'
                            .htmlspecialchars( $description)
                         .'</option>';
	    }
	    if ( isset( $o['select_none']) && $o['select_none']) $options_html = '<option value="">'.$o['select_none'].'</option>'.$options_html;
	    return "<select $attributes_html>$options_html</select>";
	}
	function submit(){
		return $this->input( 'submit');
	}
	function hidden( $key, $value){
		return $this->input( 'hidden', array('name'=>$key,'value'=>$value));
	}
}
?>
