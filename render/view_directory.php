<?php
/**
    @package utility
*/

/**
    getViewDirectory
    
    returns an array of every view and the file path where it can be located.

    @return array keys are view function names, values are their file paths
*/
function &getViewDirectory(){
    static $dir;
    if( !$dir ) {
        $dir = new ViewDirectory( );
    }
    return $dir;
}

class ViewDirectory {
    var $_view_paths = array('view');
    static $custom_locations = array(
		'testView' => 'view/test_view.php',
		'editHour' => 'view/edit_hour.php',
		'estimateTable' => 'view/estimate_table.php',
		'contactDetail' => 'view/contact_detail.php',
		'contactTable' => 'view/contact_table.php',
		'companyInfo' => 'view/company_info.php',
		'companyTable' => 'view/company_table.php',
		'projectTable' => 'view/project_table.php',
		'supportContractTable' => 'view/support_contract_table.php',
		'staffTable' => 'view/staff_table.php',
		'staffDetail' => 'view/staff_detail.php',
		'basicTable' => 'view/basic_table.php',
		'hoursByEstimate' => 'view/hours_by_estimate.php',
		'hoursForEstimate' => 'view/hours_for_estimate.php',
		'paymentTable' => 'view/payment_table.php',
		'projectInfo' => 'view/project_info.php',		
		'basicList' => 'view/basic_list.php',
		'hourListItem' => 'view/hour_list_item.php',
		'hoursList' => 'view/hours_list.php',
		'hourTable' => 'view/hour_table.php',
		'estimateInfo' => 'view/estimate_info.php'
    );

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
        $probable_filename = $this->underscore( $view_function_name );
        foreach( $this->_view_paths as $test_path ) {
            $test_filename = $test_path . DIRECTORY_SEPARATOR . $probable_filename . '.php';
            if( file_exists( $test_filename )) {
                return $test_filename;
            }
        }
        if( isset( $this->custom_locations[$view_function_name])) {
            return $this->custom_locations[$view_function_name];
        }

    }

}
?>
