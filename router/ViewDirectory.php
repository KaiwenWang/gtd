<?php
class ViewDirectory {
    var $_view_paths = array('view');
    var $custom_locations = array(
		'jumpSelect' => 'view/control/jump_select.php',
		'testView' => 'view/test_view.php',
		'basicList' => 'view/basic/basic_list.php',
		'basicTable' => 'view/basic/basic_table.php',
		'basicFormContents' => 'view/basic/basic_form_contents.php',
		'bandwidthTable' => 'view/bandwidth/bandwidth_table.php',
		'estimateTable' => 'view/estimate/estimate_table.php',
		'estimatePrint' => 'view/estimate/estimate_print.php',
		'estimateInfo' => 'view/estimate/estimate_info.php',
		'estimateNewForm' => 'view/estimate/estimate_new_form.php',	
		'contactDetail' => 'view/contact/contact_detail.php',
		'contactTable' => 'view/contact/contact_table.php',
		'companyInfo' => 'view/company/company_info.php',
		'companyTable' => 'view/company/company_table.php',
		'companyNewForm' => 'view/company/company_new_form.php',
		'invoiceTable' => 'view/invoice/invoice_table.php',
		'productInstanceInfo' => 'view/product_instance/product_instance_info.php',
		'supportContractTable' => 'view/support_contract/support_contract_table.php',
		'staffTable' => 'view/staff/staff_table.php',
		'staffDetail' => 'view/staff/staff_detail.php',
		'paymentTable' => 'view/payment/payment_table.php',
		'projectInfo' => 'view/project/project_info.php',		
		'projectTable' => 'view/project/project_table.php',
		'projectNewForm' => 'view/project/project_new_form.php',
		'hourListItem' => 'view/hour/hour_list_item.php',
		'hourNewForm' => 'view/hour/hour_new_form.php',
		'hourTable' => 'view/hour/hour_table.php'
    );
 	private static $instance;

	public static function singleton() {
    	if(!isset(self::$instance)) {
    	  self::$instance = new ViewDirectory();
	    }
    	return self::$instance;
 	 } 

	private function __construct(){
		$this->router = Router::singleton();
	}
  	
    function underscore( $value ) {
        $start_set = split( ',', "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z" );
        $end_set = split( ',', "_a,_b,_c,_d,_e,_f,_g,_h,_i,_j,_k,_l,_m,_n,_o,_p,_q,_r,_s,_t,_u,_v,_w,_x,_y,_z" );
        $underscored = str_replace( $start_set, $end_set, $value );
        if( substr($underscored, 0, 1) == '_' ) {
            $underscored = substr($underscored,1 );
        }
        return $underscored;
    }

    function find( $view_function_name ) {
        if( isset( $this->custom_locations[$view_function_name])) return $this->custom_locations[$view_function_name];

        $probable_filename = $this->underscore( $view_function_name );

		$i++;
		
		$test_filename[$i] = 'view'.DIRECTORY_SEPARATOR.$this->underscore( $this->router->controller_prefix )
						  .DIRECTORY_SEPARATOR.$probable_filename.'.php';						  
		if( file_exists( $test_filename[$i] ))	return $test_filename[$i];

        foreach( $this->_view_paths as $test_path ) {
        	$i++;
            $test_filename[$i] = $test_path . DIRECTORY_SEPARATOR . $probable_filename . '.php';
            if( file_exists( $test_filename[$i] ))	return $test_filename[$i];
        }
        bail("View $view_function_name could not be found.<br>Lebowski looked in the following locations:<br>".array_dump($test_filename));
    }

}
?>
