<?php
class NoteController extends PageController {
	public $template = 'gtd_main_template';
 	var $before_filters = array( 'get_posted_records' => 
 									array( 'create','update','destroy')
 								);
    
    function index( $params){
        $this->data->notes = getAll( 'Note');
    }
    function show( $params){
		if( !$params['id'] )	$bail('required param["id"] not set');
		
        $this->data->note = new note($params['id']);
    }
	function update( $params){
		$c = $this->updated_notes[0];
    	$c->save();
    	$this->redirectTo( array('controller'=>'Note',
    							 'action' => 'index',
    							 'company_id'=>$c->getCompany()->id
    							 ));
	}
	function create( $params){
		$n = $this->new_notes[0];
    	$n->save();
    	$this->redirectTo( array('controller'=>'Note',
    							 'action' => 'index',
    							 'company_id'=>$n->getCompany()->id
    							 ));
    }
	function new_form(){
        $this->data= new Note();
	    $this->data->set(array('staff_id'=>Session::getUserId()));
	}
	function destroy( $params){
		if(empty($params['id'])) bail('required param["id"] not set.');
		$note = new note($params['id']);
		$note->destroy();
		$this->redirectTo(array(
							'controller'=>'Note',
							'action'=>'index'
							));
    }
}
?>
