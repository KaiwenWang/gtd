<?php
function bookmarkTable( $bookmarks, $o = array()){
  if( !$bookmarks) return;
  $r =& getRenderer();
  $html = '<fieldset id="bookmarks"><legend>Bookmarks</legend><ul id="bookmark-list">';  
  foreach($bookmarks as $b){
    $html.="
      <li>
        <div class='destroy-bookmark-container'>
          " . UI::link( array(
            'controller'=>'Bookmark',
            'action'=>'destroy',
            'id'=>$b->id,
            'text'=>'<span class="ui-icon ui-icon-trash"></span>'),
             array('class'=>'btn ui-state-default ui-corner-all'))
          ." 
        </div>
        <a href='" .$b->getSource()."'>".$b->getDescription()."</a>
        <div class='clear'></div>
      </li>";
  }
  $html .= '</ul></fieldset>';
  return $html;
}

?>
