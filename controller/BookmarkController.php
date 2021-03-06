<?php

class BookmarkController extends PageController {

  public $template = 'gtd_main_template';   
  var $before_filters = array('get_posted_records' => array('create', 'update', 'destroy'));
  
  function index($params) {
    $this->data->notes = getAll('Bookmark');
  }

  function new_form($params) {
    $this->data->bookmark = new Bookmark();
    $this->data->bookmark->set(array('staff_id' => Session::getUserId(), 'source' => $params['source'], 'description' => $params['description']));
  }

  function create($params) {
    $b = $this->new_bookmarks[0];
    $b->save();
    $this->redirectBack();
  }

  function destroy($params) {
    if(empty($params['id'])) bail('required param["id"] not set.');
    $bookmark = new bookmark($params['id']);
    $bookmark->destroy();
    $this->redirectBack();
  }

}

?>
