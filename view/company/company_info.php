<?php
/**
  	companyDetail
    
    View that displays details on a company
                 
    @return html
    @package view

*/

function companyInfo( $c, $o){
    $r =& getRenderer();

	$list_items = array(
						'Name'		=> $c->get('name'),
						'Notes'		=> $c->get('notes'),
						'Street'	=> $c->get('street'),
						'Street 2'	=> $c->get('street_2'),
						'City'		=> $c->get('city'),
						'State'		=> $c->get('state'),
						'Zip'		=> $c->get('zip'),
						'Phone'		=> $c->get('phone'),
						'Status'	=> $c->get('status')
					);
					
	$html = $r->view( 'basicList', $list_items);
	
	return $html;
	
}
?>
