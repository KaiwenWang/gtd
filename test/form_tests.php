<?php
class testForm extends UnitTestCase{
	function testCreateFieldForExistingModel(){
		$hour = new Hour(20974);
		$form = new Form( array( 'controller'=>'simpleTest', 'action'=>'test'));
		$f = $form->getFieldSetFor($hour);
		$field_html = $f->hours;
		
		$this->assertEqual('<input type="text" value="2.5" id = "ActiveRecord[Hour][20974][hours]" class = "hours-field Hour-field float-field" name = "ActiveRecord[Hour][20974][hours]" />',$field_html);

	}
	function testCreateFieldForNewModel(){
		$hour = new Hour();
		$form = new Form( array( 'controller'=>'simpleTest', 'action'=>'test'));
		$f = $form->getFieldSetFor($hour);
		$field_html = $f->hours;

		$this->assertEqual('<input type="text" value="" id = "ActiveRecord[Hour][new-0][hours]" class = "hours-field Hour-field float-field" name = "ActiveRecord[Hour][new-0][hours]" />',$field_html);

	}
	function testCreateFieldsForMultipleNewModels(){
		$form = new Form( array( 'controller'=>'simpleTest', 'action'=>'test'));

		$hour1 = new Hour();
		$f1 = $form->getFieldSetFor($hour1);		
		$field_html = $f1->hours;

		$this->assertEqual('<input type="text" value="" id = "ActiveRecord[Hour][new-0][hours]" class = "hours-field Hour-field float-field" name = "ActiveRecord[Hour][new-0][hours]" />',$field_html);

		$hour2 = new Hour();		
		$f2 = $form->getFieldSetFor($hour2);
		$field_html = $f2->hours;

		$this->assertEqual('<input type="text" value="" id = "ActiveRecord[Hour][new-1][hours]" class = "hours-field Hour-field float-field" name = "ActiveRecord[Hour][new-1][hours]" />',$field_html);
		
	}
	function testCreateFormForOneObject(){
		$hour = new Hour(20974);

		$form = new Form( array( 'controller'=>'Hour', 'action'=>'update', 'method'=>'post'));

		$f = $form->getFieldSetFor($hour);
		$html = $f->description;
		$html .= $f->hours;
		$html .= $f->discount;
		
		$form->content = $html;
		$form_html = $form->html;
		
		$correct_html = '<form method="post" action="index.php" >
<input type="hidden" name="controller" value="Hour"/>
<input type="hidden" name="action" value="update"/>
<input type="text" value="SimpleTest Hour Description 2" id = "ActiveRecord[Hour][20974][description]" class = "description-field Hour-field text-field" name = "ActiveRecord[Hour][20974][description]" /><input type="text" value="2.5" id = "ActiveRecord[Hour][20974][hours]" class = "hours-field Hour-field float-field" name = "ActiveRecord[Hour][20974][hours]" /><input type="text" value="1" id = "ActiveRecord[Hour][20974][discount]" class = "discount-field Hour-field float-field" name = "ActiveRecord[Hour][20974][discount]" /><input type="submit" class="submit_btn" value="submit"/>

</form>
';
		$this->assertEqual($correct_html, $form_html);
	}
}
class testGetPostedRecords extends UnitTestCase{
	function testGetAllPostedRecordsFilter(){}
	function testFindPostedRecords(){}
}
class testSavePostedRecords extends UnitTestCase{
	function testSaveAllPostedRecordsFilter(){}
	function testSaveSelectedPostedRecords(){}
}
?>
