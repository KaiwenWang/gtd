<?php
class testForm extends UnitTestCase{
	function testCreateFieldForExistingModel(){
		$hour = new Hour();
		$hour->set(array('description'=>'Test','support_contract_id'=>1,'date'=>'2010-02-20','hours'=>'2.5'));
		$hour->save();
    $hour_id = $hour->get('id');
		$form = new Form( array( 'controller'=>'simpleTest', 'action'=>'test'));
		$f = $form->getFieldSetFor($hour);
		$field_html = $f->hours;
		$this->assertEqual('<input type="text" value="2.5" id = "ActiveRecord[Hour]['.$hour_id.'][hours]" class = "hours-field Hour-field float-field" name = "ActiveRecord[Hour]['.$hour_id.'][hours]" />',$field_html);
    $hour->delete();

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
		$hour = new Hour();
		$hour->set(array('description'=>'SimpleTest Hour Description 2','support_contract_id'=>1,'date'=>'2010-02-20','hours'=>'2.5', 'discount'=>'1'));
		$hour->save();
    $hour_id = $hour->get('id');

		$form = new Form( array( 'controller'=>'Hour', 'action'=>'update', 'method'=>'post'));

		$f = $form->getFieldSetFor($hour);
		$html = $f->description;
		$html .= $f->hours;
		$html .= $f->discount;
		
		$form->content = $html;
		$form_html = $form->html;
		$correct_html = '<form method="post" action="index.php" class = "standard-form" >
<input type="hidden" name="controller" value="Hour"/>
<input type="hidden" name="action" value="update"/>
<input type="text" value="SimpleTest Hour Description 2" id = "ActiveRecord[Hour]['.$hour_id.'][description]" class = "description-field Hour-field text-field" name = "ActiveRecord[Hour]['.$hour_id.'][description]" /><input type="text" value="2.5" id = "ActiveRecord[Hour]['.$hour_id.'][hours]" class = "hours-field Hour-field float-field" name = "ActiveRecord[Hour]['.$hour_id.'][hours]" /><input type="text" value="1" id = "ActiveRecord[Hour]['.$hour_id.'][discount]" class = "discount-field Hour-field float-field" name = "ActiveRecord[Hour]['.$hour_id.'][discount]" /><div class="submit-container"><input type="submit" class="submit_btn" value="submit"/></div>
</form>
';
		$this->assertEqual($correct_html, $form_html);
    $hour->delete();
	}
}
?>
