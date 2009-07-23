<?php

class Contact extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "First_Name";
	var $_class_name = "Contact";
    var $_search_criteria_global = array( "modin = 61");
	var $company;
    protected static $schema_json = "{	
			'fields'   : {	
							'first_name'  :  'text',
							'last_name'  :  'text',
							'company_id'  :  'Company',
							'title'  :  'text',
							'notes'  :  'textarea',
							'email'  :  'text',
							'phone'  :  'text',
							'fax'  :  'text',
							'street'  :  'text',
							'street_2'  :  'text',
							'city'  :  'text',
							'state'  :  'text',
							'zip'  :  'int',
							'is_billing_contact'  :  'bool',
							'is_primary_contact'  :  'bool',
							'is_technical_contact'  :  'bool',
							'preamp_id'  :  'int',
							'stasi_id'  :  'int',
							'stasi_project_id'  :  'int',
							'help_id'  :  'int'
						},
			'required' : {
							
						}
			}";
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"61"));
    }
	function getName(){
		$name = $this->getData('first_name');
		if( $this->getData('last_name')) $name .= ' '.$this->getData('last_name');
		return $name;
	}
    function getCompany(){
		if(!$this->company){
			$this->company = new Company( $this->getData('company_id'));
		}
		return $this->company;	
	}
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'First_Name', "first_name" );
		$this->legacyFieldName($data,'Last_Name', "last_name" );
		$this->legacyFieldName($data,'Company', "company_id" );
		$this->legacyFieldName($data,'occupation', "title" );
		$this->legacyFieldName($data,'Notes', "notes" );
		$this->legacyFieldName($data,'Email', "email" );
		$this->legacyFieldName($data,'Phone', "phone" );
		$this->legacyFieldName($data,'Work_Fax', "fax" );
		$this->legacyFieldName($data,'Street', "street" );
		$this->legacyFieldName($data,'Street_2', "street_2" );
		$this->legacyFieldName($data,'City', "city" );
		$this->legacyFieldName($data,'State', "state" );
		$this->legacyFieldName($data,'Zip', "zip" );
		$this->legacyFieldName($data,'custom2', "is_billing_contact" );
		$this->legacyFieldName($data,'custom3', "is_primary_contact" );
		$this->legacyFieldName($data,'custom4', "is_technical_contact" );
		$this->legacyFieldName($data,'custom5', "preamp_id" );
		$this->legacyFieldName($data,'custom6', "stasi_id" );
		$this->legacyFieldName($data,'custom7', "stasi_project_id" );
		$this->legacyFieldName($data,'custom8', "help_id" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }

	function makeCriteriaFirstName( $value ) {
		return $this->_makeCriteriaEquals( 'First_Name', $value );
	}
	function makeCriteriaLastName( $value ) {
		return $this->_makeCriteriaEquals( 'Last_Name', $value );
	}
	function makeCriteriaCompanyId( $value ) {
		return $this->_makeCriteriaEquals( 'Company', $value );
	}
	function makeCriteriaTitle( $value ) {
		return $this->_makeCriteriaEquals( 'occupation', $value );
	}
	function makeCriteriaNotes( $value ) {
		return $this->_makeCriteriaEquals( 'Notes', $value );
	}
	function makeCriteriaEmail( $value ) {
		return $this->_makeCriteriaEquals( 'Email', $value );
	}
	function makeCriteriaPhone( $value ) {
		return $this->_makeCriteriaEquals( 'Phone', $value );
	}
	function makeCriteriaWorkFax( $value ) {
		return $this->_makeCriteriaEquals( 'Work_Fax', $value );
	}
	function makeCriteriaStreet( $value ) {
		return $this->_makeCriteriaEquals( 'Street', $value );
	}
	function makeCriteriaStreet2( $value ) {
		return $this->_makeCriteriaEquals( 'Street_2', $value );
	}
	function makeCriteriaCity( $value ) {
		return $this->_makeCriteriaEquals( 'City', $value );
	}
	function makeCriteriaState( $value ) {
		return $this->_makeCriteriaEquals( 'State', $value );
	}
	function makeCriteriaZip( $value ) {
		return $this->_makeCriteriaEquals( 'Zip', $value );
	}




	function makeCriteriaBillable( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaPrimary( $value ) {
		return $this->_makeCriteriaEquals( 'custom3', $value );
	}
	function makeCriteriaTechnical( $value ) {
		return $this->_makeCriteriaEquals( 'custom4', $value );
	}
	function makeCriteriaPreampId( $value ) {
		return $this->_makeCriteriaEquals( 'custom5', $value );
	}
	function makeCriteriaStatsiId( $value ) {
		return $this->_makeCriteriaEquals( 'custom6', $value );
	}
	function makeCriteriaStasiProjectId( $value ) {
		return $this->_makeCriteriaEquals( 'custom7', $value );
	}
	function makeCriteriaHelpId( $value ) {
		return $this->_makeCriteriaEquals( 'custom8', $value );
	}


}

?>
