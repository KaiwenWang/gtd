<?php

class ProductInstance extends ActiveRecord {

	var $datatable = "userdata";
	var $name_field = "custom1";
	var $_class_name = "ProductInstance";
	var $_search_criteria_global = array( "modin = 68");
	
    function __construct( $id = null){
        parent::__construct( $id);
        $this->mergeData(array("modin"=>"68"));
    }
	function _adjustSetData($data) {
		$this->legacyFieldName($data,'custom1', "domain_name" );
		$this->legacyFieldName($data,'custom2', "technology" );
		$this->legacyFieldName($data,'custom12', "dns_notes" );
		$this->legacyFieldName($data,'custom13', "other_domain_names" );
		$this->legacyFieldName($data,'custom14', "server" );
		$this->legacyFieldName($data,'custom15', "subsites" );
		$this->legacyFieldName($data,'custom17', "server_account" );
		$this->legacyFieldName($data,'custom18', "apache_file" );
		$this->legacyFieldName($data,'custom19', "contract_id" );
		$this->legacyFieldName($data,'custom20', "wordpress" );
		$this->legacyFieldName($data,'custom21', "oscom" );
		$this->legacyFieldName($data,'custom22', "drupal" );
		$this->legacyFieldName($data,'custom23', "secure_domain" );
		$this->legacyFieldName($data,'custom24', "china_ip" );
		$this->legacyFieldName($data,'custom25', "phplist" );		
		$this->legacyFieldName($data,'Company', "company_id" );
		$this->legacyFieldName($data,'Notes', "notes" );
	}
    function makeCriteriaModin( $value ) {
        return $this->_makeCriteriaEquals( 'modin', $value );
    }
	function makeCriteriaDomainName( $value ) {
		return $this->_makeCriteriaEquals( 'custom1', $value );
	}
	function makeCriteriaTechnology( $value ) {
		return $this->_makeCriteriaEquals( 'custom2', $value );
	}
	function makeCriteriaDnsNotes( $value ) {
		return $this->_makeCriteriaEquals( 'custom12', $value );
	}
	function makeCriteriaOtheroOmainNames( $value ) {
		return $this->_makeCriteriaEquals( 'custom13', $value );
	}
	function makeCriteriaServer( $value ) {
		return $this->_makeCriteriaEquals( 'custom14', $value );
	}
	function makeCriteriaSubsites( $value ) {
		return $this->_makeCriteriaEquals( 'custom15', $value );
	}
	function makeCriteriaServerAccount( $value ) {
		return $this->_makeCriteriaEquals( 'custom17', $value );
	}
	function makeCriteriaApacheFile( $value ) {
		return $this->_makeCriteriaEquals( 'custom18', $value );
	}
	function makeCriteriaSupportContractId( $value ) {
		return $this->_makeCriteriaEquals( 'custom19', $value );
	}
	function makeCriteriaWordpress( $value ) {
		return $this->_makeCriteriaEquals( 'custom20', $value );
	}
	function makeCriteriaOscom( $value ) {
		return $this->_makeCriteriaEquals( 'custom21', $value );
	}
	function makeCriteriaDrupal( $value ) {
		return $this->_makeCriteriaEquals( 'custom22', $value );
	}
	function makeCriteriaSecureDomain( $value ) {
		return $this->_makeCriteriaEquals( 'custom23', $value );
	}
	function makeCriteriaChinaIp( $value ) {
		return $this->_makeCriteriaEquals( 'custom24', $value );
	}
	function makeCriteriaPhplist( $value ) {
		return $this->_makeCriteriaEquals( 'custom25', $value );
	}
	

	function makeCriteriaCompanyId( $value ) {
		return $this->_makeCriteriaEquals( 'Company', $value );
	}
	function makeCriteriaNotes( $value ) {
		return $this->_makeCriteriaEquals( 'Notes', $value );
	}


}

?>
