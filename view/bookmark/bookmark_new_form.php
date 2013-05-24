<?php
function bookmarkNewForm($d, $o = array()){
  $url = parse_url($_SERVER['HTTP_REFERER']);
  $local_url = $url['path'];
  if(isset($url['query']) && $url['query'] != '') {
    $local_url .= '?' . $url['query'];
  }
  
  $r =& getRenderer();
  $form = new Form( array( 'controller'=>'Bookmark', 'action'=>'create'));
  $fs = $form->getFieldSetFor($d->bookmark);

  //$html = '<h3 class="basic-form-header">Bookmark This Page</h3>'; 
  $html .= $fs->field('staff_id',array('field_type'=>'hidden'));
  //$html .= $fs->field('source',array('field_type'=>'hidden', 'value' => $local_url));
  $html .= '<input type="hidden" value="' . $local_url . '" id="ActiveRecord[Bookmark][new-0][source]" class="source-field Bookmark-field hidden-field" name="ActiveRecord[Bookmark][new-0][source]">';
  $html .= $fs->description;
  $html .= $form->getSubmitBtn();
  $form->content = $html; 
  return $form->html;
}
