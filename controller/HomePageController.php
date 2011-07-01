<?php
class HomePageController extends PageController {
	public $template = 'gtd_main_template';

    function index( $params = array()){
      $this->redirectTo( array('controller'=>'Staff','action'=>'show','id'=>Session::getUserId()));
    }        
}
?>
