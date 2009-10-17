<?php
require_once( 'controller/filter/DefaultFilterCollection.php');
class SimpleTestFilterCollection extends DefaultFilterCollection {
    function test_filter_collection( ) {
        $this->controller->filter_collection_enabled = true;
    }
}
?>
