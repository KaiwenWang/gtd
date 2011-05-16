<?php
class testHour extends UnitTestCase{
	function testCreatePair(){
    $staff_1 = new Staff();
    $staff_1->set(array('first_name'=>'First','last_name'=>'User'));
    $staff_1->save();
    
    $staff_2 = new Staff();
    $staff_2->set(array('first_name'=>'Second','last_name'=>'User'));
    $staff_2->save();
    
    $h = new Hour();
    $h->set(array(
     'hours' => 6,
     'staff_id' => $staff_1->id,
     'pair_id' => $staff_2->id
    ));
    $h->updateOrCreateWithPair();
    $this->assertTrue($h->id, 'should have an id');
    $this->assertTrue($h->get('pair_hour_id'), 'should have a pair hour id');

    $h2 = $h->getPairHour();
    $this->assertIsA($h2, 'Hour');
    $this->assertTrue($h2->id, 'should have an hour id');
    $this->assertEqual($h2->get('hours'),6);
        
    $h->set(array('hours'=>7));
    $h->updateOrCreateWithPair();
    
    $h3 = $h->getPairHour();
    $this->assertEqual($h2->id,$h3->id);
    $this->assertEqual($h3->get('hours'),7);
    
    $this->assertEqual($h3->getPairName(),$staff_1->getName());
    $this->assertEqual($h->getPairName(),$staff_2->getName());    
	}
}