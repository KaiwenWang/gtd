<?php
class ProjectDetail extends PageController {
    var $_class_name = 'ProjectList';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
		if( !$params['id']) Bail('No id given.');
		$project = new Project( $params['id']);
		$select_project = $r->view( 'jumpSelect', $project);

		$project_info = $r->view('projectInfo', $project);
        $contact_table = $r->view('contactTable',$project->getContacts());
		$estimate_table = $r->view('estimateTable', $project->getEstimates());

        return $r->template('template/standard_inside.html',
                            array(
                            'title' => $project->getName(),
                            'controls' => $select_project,
                            'body' => $project_info.$contact_table.$estimate_table
                            ));
    }
}
?>
