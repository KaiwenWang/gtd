<?
/**
    @package utility
*/

/**
    getViewDirectory
    
    returns an array of every view and the file path where it can be located.

    @return array keys are view function names, values are their file paths
*/
function &getViewDirectory(){
    static $view_directory = array(
		'testView' => 'view/test_view.php',
		'editHour' => 'view/edit_hour.php',
		'estimateTable' => 'view/estimate_table.php',
		'contactDetail' => 'view/contact_detail.php',
		'contactTable' => 'view/contact_table.php',
		'companyDetail' => 'view/company_detail.php',
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
		'hoursList' => 'view/hours_list.php'
    );
    return $view_directory;
}
?>
