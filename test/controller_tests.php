<?php
require( 'test/fixtures/SimpletestController.php' );

class testFilters extends UnitTestCase{
    function testRunControllerMethodAsBeforeFilter( ){
        $cnt = new SimpletestController( );
        $cnt->disableResponse( );
        $cnt->execute( 'index');
        $this->assertEqual( $cnt->local_filters_okay, true );
    }
    function testRunFilterCollectionMethodAsBeforeFilter( ){
        $cnt = new SimpletestController( );
        $cnt->disableResponse( );
        $cnt->execute( 'test_filter_collection_action');
        $this->assertEqual( $cnt->filter_collection_enabled, true );
    }

}

class testController extends UnitTestCase {
    function testDisableResponseRenderer( ) {
        $cnt = new SimpletestController( );
        $cnt->execute( 'viewless_action');
        $this->assertFalse( $cnt->isResponseEnabled( ));
    }

}

class testControllerParams extends UnitTestCase{
    function testSettingExecuteParams(){
        $cnt = new SimpletestController( );
        $cnt->disableResponse( );
        $cnt->execute( 'viewless_action', array( 'foo' => 'bar' ));

        $this->assertEqual( $cnt->params('foo'), 'bar' );

    }
}
class testGetPostedRecords extends UnitTestCase{
    function testGetNewPostedRecordsFilter(){
        $test_params = array( );
        $test_params['ActiveRecord']['Hour']['new-0']['description'] = 'test Hour';
        $test_params['ActiveRecord']['Hour']['new-1']['description'] = 'another test Hour';

        $cnt = new SimpletestController( );
        $cnt->disableResponse( );
        $cnt->execute( 'count_new_records', $test_params );
        $this->assertEqual( count( $cnt->new_hours ), 2 );
    }
    function testGetUpdatedPostedRecordsFilter(){
        $test_params = array( );
        $test_params['ActiveRecord']['Hour']['123']['description'] = 'test Hour';
        $test_params['ActiveRecord']['Hour']['456']['description'] = 'another test Hour';

        $cnt = new SimpletestController( );
        $cnt->disableResponse( );
        $cnt->execute( 'count_new_records', $test_params );
        $this->assertEqual( count( $cnt->updated_hours ), 2 );
    }
}
/*
class testSavePostedRecords extends UnitTestCase{
	function testSaveAllPostedRecordsFilter(){}
	function testSaveSelectedPostedRecords(){}
}
 */
?>
