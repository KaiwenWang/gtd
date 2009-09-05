<?php
function supportcontractIndex($d){
        $r =& getRenderer();
        
        return array(
				'title' => 'Support Contracts',
				'body' => $r->view('supportContractTable', $d->contracts)
				);
}
?>