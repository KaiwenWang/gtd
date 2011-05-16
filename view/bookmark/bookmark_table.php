<?php

function bookmarkTable( $bookmarks, $o = array()){
	if( !$bookmarks) return;
    $r =& getRenderer();
    $table = array();
    $table['headers'] = array(	'ID',
    							'Bookmark'
    							);
    $table['rows'] =  array();
    foreach($bookmarks as $b){
      $table['rows'][] = array(	$b->id,
        "<a href='" .$b->getSource()."'>".$b->getDescription()."</a>"
      );
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Bookmarks'));
    return $html;
}
?>
