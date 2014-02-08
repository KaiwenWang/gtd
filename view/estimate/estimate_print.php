<?php

function estimatePrint($estimates, $o = array()) {
  if(!$estimates) return;
  $r = getRenderer();
  $html = '';
  $html .= '<table id="estimate-print" cellpadding="10" border="0" cellspacing="0">';
  $html .= '<tr style="background: #DDEEEE"><td><b>Phase/Detail</b></td><td><b>Low</b></td><td><b>High</b></td></tr>';
   foreach($estimates as $e) {
    $html .= '<tr><td><b>' . $e->getName() . '</b><br />';
    $html .= $e->getData('notes') . '</td>';
    $html .= '<td>' . $e->getLowEstimate() . '</td>';
    $html .= '<td>' . $e->getHighEstimate() . '</td></tr>';
  }
  $html .= '</table>';
  return $html;
}

?>
