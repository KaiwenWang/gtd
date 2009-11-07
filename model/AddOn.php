<?php

class AddOn extends  ActiveRecord {

	var $datatable = "add_on";
	var $name_field = "name";
	var $_class_name = "AddOn";
        protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	
    						'support_contract_id'	:  'SupportContract',
    						'name'  		:  'text',
    						'amount'  		:  'float',
    						'description'  	:  'textarea',
    						'date'  		:  'date',
    						'invoice_id'  	:  'Invoice'
    					},
    		'required' : {

    					}
    		}";
    function __construct( $id = null){
        parent::__construct( $id);
    }

    function getAddOns(){
        if (!$this->addons){
            $addons = $this->getData('amount');
            if (!$addons) $addons = 0;
            $this->addons= $addons;
            return $addons;
        }
    }

    function getTotalAddOns(){
        $add_ons = $this->getAddOns();
        $total_add_ons = 0;
        foreach ($hours as $hour){
            $total_add_ons += $add_ons->getAddOns();
        }
        return $total_add_ons;
    }	

	}

?>
