<?php

isset($_GET['test'])	? $test_suite = $_GET['test']
: $test_suite = 'all';

if ($test_suite == 'phpinfo'){
  phpinfo();
  exit;
}

$doc_root = $_SERVER['DOCUMENT_ROOT'];

require_once('boot/bootstrap.php');
require_once('lib/simpletest/autorun.php');
require_once('lib/simpletest/unit_tester.php');
require_once('lib/simpletest/reporter.php');

if( !defined('TEST_MODE') || TEST_MODE == false) {
  bail('Set TEST_MODE to true in database_config file. DO NOT RUN TESTS ON THE PRODUCTION SERVER.');
  exit;
}

$test = new TestSuite($test_suite . ' tests' );

switch ($test_suite){
case 'model':
  $test->addFile($doc_root . 'test/model_tests.php');
  $test->addFile($doc_root . 'test/hour_tests.php');		
  break;
case 'form':
  $test->addFile($doc_root . 'test/form_tests.php');
  break;
case 'controller':
  $test->addFile($doc_root . 'test/controller_tests.php');
  break;
case 'billing':
  $test->addFile($doc_root . 'test/billing_tests.php');
  break;
case 'invoicing':
  $test->addFile($doc_root . 'test/invoicing_tests.php');
  break;
case 'all':
  $test->addFile($doc_root . 'test/model_tests.php');
  $test->addFile($doc_root . 'test/hour_tests.php');		
  $test->addFile($doc_root . 'test/form_tests.php');
  $test->addFile($doc_root . 'test/controller_tests.php');
  $test->addFile($doc_root . 'test/billing_tests.php');
  break;
case 'delete_test_records':
  include('test/delete_test_records.php');
  break;
}

$test->run(new HtmlReporter());
