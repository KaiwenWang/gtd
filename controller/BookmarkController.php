<?php
class BookmarkController extends PageController {
	public $template = 'gtd_main_template';
 	
  var $before_filters = array( 'get_posted_records' => 
    array( 'create','update','destroy')
  );
    
  function index( $params){
      $this->data->notes = getAll( 'Bookmark');
  }
}
