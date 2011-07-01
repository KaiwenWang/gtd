<?php
function bookmarkNewForm($d, $o = array()){
  $r =& getRenderer();
  $form = new Form( array( 'controller'=>'Bookmark', 'action'=>'create'));
  $fs = $form->getFieldSetFor($d->bookmark);

  $html = '<h3 class="basic-form-header">Bookmark This Page</h3>'; 
  $html .= $fs->field('staff_id',array('field_type'=>'hidden'));
  $html .= $fs->field('source',array('field_type'=>'hidden'));
  $html .= $fs->description;
  $html .= $form->getSubmitBtn();
  $form->content = $html; 
  return $form->html;
}
