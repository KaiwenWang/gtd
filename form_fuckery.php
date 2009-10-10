<?php
include('include/all_includes.php');

		$hour = new Hour();
		$form = new Form();
		$f = $form->getFieldsFor($hour);
		$field_html = $f->hours;
		
		echo $field_html;
?>