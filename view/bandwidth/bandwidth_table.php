<?php

function bandwidthTable( $data, $options = array( )) {
    if( !$data ) return false;
    $r =& getRenderer();
    $table = array();
    $table['headers'] = array(	'ID',
    							'Date',
                                'Overage( GB )'
    							);
    $table['rows'] =  array();
    foreach($data as $e){
      $url = $e->getData('url');
      $table['rows'][] = array(	$e->id,
      							$e->getData( 'date'),
      							$e->getData('gigs_over')
      							);
    }
    $html = $r->view( 'basicTable', $table, array('title'=>'Bandwidth Overages', 'pager' => true));
    return $html;
}
?>
