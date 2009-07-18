<?php
class ProjectList extends PageController {
    var $_class_name = 'ProjectList';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
		
		$page_title = 'All Projects';
		
		$select_by_staff = $r->classSelect( 'Staff',
											array(	'name'=>'staff_id',
													'selected_value'=>$params['staff_id'],
													'select_none'=>'All Staff Members'),
											array('sort'=>'first_name'));
		$select_by_staff .= $r->submit();
		$select_by_staff = $r->form( 'get', 'ProjectList', $select_by_staff);
		$controls = $r->view('basicList', array('Projects by Staff'=>$select_by_staff));

		$search_criteria = array();
		$search_criteria['sort'] = 'custom17,custom4';#status,launch_date

		if ( $params['staff_id']) {
			$staff = new Staff( $params['staff_id']);
			$search_criteria['staff_id'] = $staff->id;
			$page_title = $staff->getName().'\'s Projects';
		}

        $projects = getMany( 'Project', $search_criteria); 
        $project_table = $r->view('projectTable', $projects, array('id'=>'project'));

        $html = $project_table;

        return $r->template('template/standard_inside.html',
                            array(
                            'title'=>$page_title,
                            'controls'=>$controls,
                            'body'=>$html
                            ));
    }
}
?>
