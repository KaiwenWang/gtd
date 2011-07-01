<?php

function bookmarkTable( $bookmarks, $o = array()){
  if( !$bookmarks) return;
  $r =& getRenderer();
  $html = '<h4>Bookmarks</h4><ul id="bookmark-list">';  
  foreach($bookmarks as $b){
    $html.="
      <li>
        <a class='button' href='" .$b->getSource()."'>".$b->getDescription()."</a>
      <div class='destroy-bookmark-container'>
        " . UI::link( array(
          'controller'=>'Bookmark',
          'action'=>'destroy',
          'id'=>$b->id,
          'text'=>'<span class="ui-icon ui-icon-trash"></span>'),
           array('class'=>'button ui-state-default ui-corner-all'))
        ." </div><div class='clear'></div></li>";
  }
  $html .= '</ul>';
  return $html;
}
