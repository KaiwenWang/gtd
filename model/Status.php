<?php
class Status extends ActiveRecord{

	var $datatable = "status";
	var $name_field = "description";

 	protected static $schema;
    protected static $schema_json = "{	
			'fields'   : {	'name'	: 	'text',
							'type'	: 	'type'
					   },
			'required' : {	'name',
							'type'
					   }
			}";


}
