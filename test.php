<?php
require_once('include/all_includes.php');
require_once('lib/simpletest/unit_tester.php');
require_once('lib/simpletest/reporter.php');

if( !defined('TEST_MODE') || TEST_MODE == false) {
	bail('Set TEST_MODE to true in database_config file. DO NOT RUN TESTS ON THE PRODUCTION SERVER.');
	exit;
}
isset($_GET['test'])	? $test_suite = $_GET['test']
						: $test_suite = 'all';

$test = &new TestSuite( $test_suite.' tests' );

switch ($test_suite){
	case 'model':
		$test->addTestFile('test/model_tests.php');
		break;
	case 'form':
		$test->addTestFile('test/form_tests.php');
		break;
	case 'controller':
		$test->addTestFile('test/controller_tests.php');
		break;
	case 'billing':
		$test->addTestFile('test/billing_tests.php');
		break;
	case 'all':
		$test->addTestFile('test/model_tests.php');
		$test->addTestFile('test/form_tests.php');
		$test->addTestFile('test/controller_tests.php');
		$test->addTestFile('test/billing_tests.php');
		break;
	case 'php':
		phpinfo();
}

$test->run(new HtmlReporter());
