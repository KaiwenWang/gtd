<?php
class Button extends PHP5_Accessor{
	public $controller;
	public $params;
	private $icons = array(
						'edit'=>'ui-icon-wrench',
						'show'=>'ui-icon-search',
						'destroy'=>'ui-icon-trash',
						'create'=>'ui-icon-circle-plus'
						);

	function __construct( $o = array()){
		$this->controller = $o['controller'];
		unset($o['controller']);
		if(!empty($o['button_type'])){
			$this->button_type = $o['button_type'];
			unset($o['button_type']);
		}else{
			$this->button_type = $o['action'];
		}
		$this->params = $o;
	}
	function getHtml(){
		$r = getRenderer();
		return $r->link( $this->controller,
						 $this->params,
						 $this->icon,
						 array('class'=>'button ui-state-default ui-corner-all')
						 );
	}
	function getIcon(){
		return '<span class="ui-icon '.$this->icons[$this->button_type].'"></span>';
	}
}
