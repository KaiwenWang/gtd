<?
/**
    @package utility
*/

/**
    getViewDirectory
    
    returns an array of every view and the file path where it can be located.

    @return array keys are view function names, values are their file paths
*/
function getViewDirectory(){
    return array(
        'basicModelSelectBox' => 'view/basic_model_select_box.php',
		'testView' => 'view/test_view.php',
		'companyTable' => 'view/company_table.php',
		'projectTable' => 'view/project_table.php',
		'supportContractTable' => 'view/support_contract_table.php',
		'staffTable' => 'view/staff_table.php',
		'basicTable' => 'view/basic_table.php',
		'hoursByEstimate' => 'view/hours_by_estimate.php',
		'hoursForEstimate' => 'view/hours_for_estimate.php',
		'paymentTable' => 'view/payment_table.php',
		'basicListItem' => 'view/basic_list_item.php',
		'hourListItem' => 'view/hour_list_item.php',
		'hoursList' => 'view/hours_list.php'
    );
}
?>