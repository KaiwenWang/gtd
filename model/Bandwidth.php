<?php
class Bandwidth extends ActiveRecord {

	var $datatable = "bandwidth";
	var $name_field = "gigs_over";

    protected static $schema_json = "{	
			'fields'   : {	
							'support_contract_id'	:  'SupportContract',
							'gigs_over'	:  'float',
							'date'  	:  'date'
						},
			'required' : {
							
						}
			}";
    function __construct(  $id = null){
        parent::__construct( $id);
    }
}
