<?php
class ProjectDetail extends PageController {
    var $_class_name = 'ProjectList';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();

		$project = new Project( $params['project_id']);
		$select_project = $r->objectSelect( $project, array('name'=>'project_id'));
		$select_project .= $r->submit();
		$select_project = $r->form( 'get', 'ProjectDetail', $select_project);

        
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
