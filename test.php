<?php
require_once('include/all_includes.php');
require_once('lib/simpletest/unit_tester.php');
require_once('lib/simpletest/reporter.php');

$test = &new TestSuite('All tests');
$test->addTestFile('test/model_tests.php');
$test->addTestFile('test/form_tests.php');
$test->run(new HtmlReporter());

?>
