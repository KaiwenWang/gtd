<?php
class HourEdit extends PageController {
    var $_class_name = 'HourEdit';

    function __construct(){
        parent::__construct();
    }
    function get( $params){
        $r =& getRenderer();
        $hour_id = $this->params( 'hour_id');
        $h = new Hour( $hour_id );
        $e = new Estimate( $h->getData( 'estimate_id'));
        $form = $r->field( $h, 'estimate_id', array( 'project_id'=>$e->getData( 'project_id')));
        $form .= $r->field( $h, 'hours');
        $form .= $r->submit( );
        $form = $r->form( 'post', 'HourEdit', $form );

        return $r->template('template/standard_inside.html',
                            array(
                            'title' => 'Create/Edit Hour',
                            'controls' => '',
                            'body' => $form
                            ));
    }

    function post( $posted_object ) {
        if( !$posted_object->is_valid( )) {
            $this->render_for_get( array( 'errors' => $posted_object->errors( )) );
            
        }

    }
}
?>
