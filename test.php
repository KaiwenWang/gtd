<?php
require_once('include/all_includes.php');
require_once('test/simpletest/unit_tester.php');
require_once('test/simpletest/reporter.php');

$test = &new TestSuite('All tests');
$test->addTestFile('test/model_tests.php');
$test->run(new HtmlReporter());

?>
