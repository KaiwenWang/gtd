<?php
class Form extends PHP5_Accessor{

	public $content;
	public $controller;
	public $action;
	public $method;

	protected $preset_fields = array();
	private $new_object_counters = array();
	private $does_submit_button_exist = false;
	
	function __construct( $o = array()){
		$this->controller = $o['controller'];
		$this->action = $o['action'];
		
		isset($o['class']) 	? $this->css_class = $o['class']
							: $this->css_class = 'standard-form';
							
		isset($o['id'])	? $this->css_id = $o['id']
						: $this->css_id = '';
						
		isset($o['method'])	? $this->method = $o['method']
							: $this->method = 'post';
		unset($o['action'],$o['method'],$o['class'],$o['id'],$o['controller']);
		$this->preset_fields = $o;	
	}
	function getSubmitBtn(){

		$this->does_submit_button_exist = true;

		$r = getRenderer();

		return  $r->submit();
	}
	function getHtml(){
		$r = getRenderer();
		
		if (!$this->does_submit_button_exist) $this->content .= '<div class="submit-container">'.$r->submit().'</div>';

		$form_content = $this->renderPresetFields()
						.$this->content;

		$html = $r->form( array(
							'action'=> $this->action, 
							'controller'=> $this->controller,
							'content'=> $form_content, 
							'method'=> $this->method,
							'class'=> $this->css_class,
						  	'id'=> $this->css_id
							)
						  );
		return $html;
	}
	function renderPresetFields(){
		$r = getRenderer();
		$hidden_fields = '';

		foreach( $this->preset_fields as $key => $value){
			if ( is_array( $value )){
				// if $value is an array, make a set of hidden inputs that will show up as $_REQUEST[$key] when submitted
				foreach( $value as $param_key => $param_value ){ 
					$hidden_fields .= $r->input('hidden', array('name'=>$key."[".$param_key."]",'value'=>$param_value));
				}
			} else {
    	   		$hidden_fields .= $r->input( 'hidden', array('name'=>$key,'value'=>$value));
			}
		}

		return $hidden_fields;
	}
	function getFieldSetFor( $obj){
		if( !is_a( $obj, 'ActiveRecord')) bail('Cannot get fields for non-ActiveRecord objects');

		$obj->id	? $fields = new FieldSet( $obj)
					: $fields = new FieldSet( $obj, $this->incrementNewObjectCounterFor( $obj));

		return $fields;
	}
	private function incrementNewObjectCounterFor( $obj){
		$class = get_class( $obj);

		isset($this->new_object_counters[$class])	? $this->new_object_counters[$class]++
													: $this->new_object_counters[$class] = 0;

		return $this->new_object_counters[$class];
	}
}
?>
