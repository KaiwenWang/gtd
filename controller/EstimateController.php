<?php
class EstimateController extends PageController {

    function __construct(){
        parent::__construct();
    }
    function show( $params){
		$d = $this->data;
		
		$d->e = new Estimate( $params['id']);
		$d->project = new Project( $d->e->get('project_id'));
    }
}
?>
