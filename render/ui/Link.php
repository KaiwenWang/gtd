<?php
class Link {

	function __construct( $params, $o = array()){
		$this->text = $params['text'];
		unset($params['text']);
		if(!empty( $params['url'] )){
			$this->url = $params['url'];
			unset($params['url']);
		}
		$this->params = $params;
		$this->options = $o; 
	}
	function getUrl(){
		if(empty($this->url)){
			$this->url = Router::url($this->params);
		}
		return $this->url;
	}
	function execute(){
    	return '<a href="'.$this->getUrl().'" '.Render::attr($this->options).'>'.$this->text.'</a>';
    }
}
