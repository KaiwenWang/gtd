<?

require_once('AMP/User/Profile/Profile.php');
require_once("gtd/util/basecamp.php");

function sync_project($gtdProj){
	#get all entries for that project
	#get staff, estimates and entries into arrays
	$staff = getStaff();
	$hours = getHours($gtdProj['id']);
	$est = getEsts($gtdProj['id']);

	$items = getBasecampHours($gtdProj['basecamp']);
	$x=0;
 	foreach ($items as $item) {
		#check entry to see if time entry enterned

		if (!$hours[$item->id]){
			#echo 'no hour entry movin forward <br>';
			#check to see if estimate is entered

			#echo 'est'.$est[$item->{'todo-item-id'}].'<br>' ;
			
			if (!$est[$item->{'todo-item-id'}] ){
				#echo 'no est entry moving forward <br>';
				#if no estimate create one
				$todo = getBasecampTodo($item->{'todo-item-id'});
			
				addEstimate($item->{'todo-item-id'},$todo->content,$gtdProj['id']);
				#echo 'added estimate '.$todo->content.'  '.$item->{'todo-item-id'}.'<br>';
				
			}

			# add hours 
			$est = getEsts($gtdProj['id']);

			addHours($item->{'id'}, $est[$item->{'todo-item-id'}], $staff[$item->{'person-id'}] ,$item->{'hours'}, $item->{'description'}, $item->{'date'});	
			#addHours($basecampID,$gtdEst,$gtdStaff,$hours,$desc,$date){	
			#echo 'added hour '.$staff[$item->{'person-id'}].' x '.$est[$item->{'todo-item-id'}].' <br>';
		#	echo $item->{'id'}.'   '. $est[$item->{'todo-item-id'}].'   '. $staff[$item->{'person-id'}] .'   '.$item->{'hours'}.'   '. $item->{'description'}.'   '. $item->{'date'}.'<br> dd  ';
			$hours = getHours($gtdProj['id']);
			#echo $item->description. ' entered <br><br><br>';	
			$x++;
		}
	}
	echo $x;
}


function getBasecampTodo($todo){

	$session = new Basecamp('raddesignsdavid','furmp32','https://radicaldesigns.clientsection.com');
	$todos = $session->todo_items($todo);
	return $todos;
}

function getBasecampHours($project){

	$session = new Basecamp('raddesignsdavid','furmp32','https://radicaldesigns.clientsection.com');
	$items = $session->time_entries($project);	
	$time =  $items->{'time-entry'};
	return $time;
}



function addEstimate($basecampID,$name,$gtdProj){
	$item = new AMP_User_Profile(AMP_Registry::getDbcon());
    $mergeData = array(
    	'modin' => '63',
		'custom1'=> $gtdProj,
        'custom2' => $name,
		'custom8'=> $basecampID
    );
    $item->mergeData($mergeData);
    $success = $item->save();
}


function addHours($basecampID,$gtdEst,$gtdStaff,$hours,$desc,$date){
	$item = new AMP_User_Profile(AMP_Registry::getDbcon());
    $mergeData = array(
    	'modin' => '62',
		'custom4'=> $gtdStaff,
        'custom11' => $basecampID,
		'custom5'=> $date,
        'custom2' => $gtdEst,
		'custom3'=> $desc,
        'custom6' => $hours	
    );
    $item->mergeData($mergeData);
    $success = $item->save();
}

function parse_xml($url){
#take the url and returns it as an array

	return $out;
}

function getProject($proj){
 	$finder = new AMP_User_Profile(AMP_Registry::getDbcon());
	$items = $finder->find(array('modin'=>'54','id'=>$proj));
	$out = array();
 	foreach ($items as $item) {
		$out['id'] = $item->getData('id');
		$out['basecamp'] = $item->getData('custom22');
	}

 	return $out;
}



function getStaff(){
# gets all of the staff with basecamp id and returns an arry where the basecamp id is the key and id is the value
 	$finder = new AMP_User_Profile(AMP_Registry::getDbcon());
	$items = $finder->find(array('modin'=>'65'));
	$out = array();
 	foreach ($items as $item) {
		if ($item->getData('custom1')){
			$out[$item->getData('custom1')] = $item->getData('id');
		}
	}
 	return $out;
}

function getHours($gtdProj){
#get all the hours logged to a pooject that have a basecamp id and returns array with basecamp as key and id as value
    $finder = new AMP_User_Profile(AMP_Registry::getDbcon());
    $ests = $finder->find(array('modin'=>'63','custom1'=>$gtdProj));
    $out = array();
    foreach ($ests as $est) {
        $items = $finder->find(array('modin'=>'62','custom2'=>$est->getData('id'
)));
        foreach ($items as $item) {
    if ($item->getData('custom11')){
                $out[$item->getData('custom11')] = $item->getData('id');
            }
        }
    }
    return $out;
}


function getEsts($gtdProj){
#get all the est logged to a pooject that have a basecamp id and returns array with basecamp as key and id as value
 	$finder = new AMP_User_Profile(AMP_Registry::getDbcon());
	$items = $finder->find(array('modin'=>'63','custom1'=>$gtdProj));
	$out = array();
 	foreach ($items as $item) {
		if ($item->getData('custom8')){
			$out[$item->getData('custom8')] = $item->getData('id');

		}
	}
 	return $out;

}	


sync_project(getProject('114'));

#$time_entries = getBasecampHours('2513159');
#AMP_dump($time_entries->{'time-entry'}]);
#echo $time_entries->time
#$time =  $time_entries->{'time-entry'};
#    $x=0;
#    AMP_dump($time);
#foreach( $time as $item){
#echo $item->date.'<br>x';
#$x++;
#}




#AMP_dump(getBasecampTodo('31471515'));

?>
