<?php
require_once ('AMP/System/Data/Data.inc.php');
class Amp_Data_Set extends AMPSystem_Data_Set {

    function Amp_Data_Set ( &$dbcon ) {
        $this->init($dbcon);
    }
	function instantiateItems($rows, $class) {
		if(empty($rows) or !$rows or !$class or !(class_exists($class))) return false;

		$items = array();
		foreach ($rows as $row) {
			$object =& new $class();
			$object->setData($row);
			$items[$object->id] = &$object;
		}

		return $items;
	}

}
?>
