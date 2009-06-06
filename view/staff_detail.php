<?php
/**
  	staffDetail
    
    View that displays details on a staff member
                 
    @return html
    @package view

*/

function staffDetail( $staff, $o){
	$html = '';
	$html .= '<h2>Details for '.$staff->getName().'</h2>';

	$html .= '<h3>Projects </h3>';	
	
	$r =& getRenderer();
	$projects = $staff->getProjects();
	if (!$projects) { 
		return $html; 
	}
	$html .= $r->view( 'projectTable', $projects);
	
	return $html;
	
}
?>