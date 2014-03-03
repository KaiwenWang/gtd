<?php

function hourWidget() {
  $html = "
    <div id='timer-widget-box' style='width: 0px;'>
      <div id='timer-widget-form'>
      <input type='text' name='timer' id='timer-time'>
      <input type='button' id='timer-pause' class='btn' value='Start'> 
      <input type='button' id='timer-submit' class='btn' value='Log' disabled='disabled'>
      </div>
    </div>
    <div id='timer-form-box' style='display:none'>
      <div id='timer-form'></div>
      <a id='timer-close' href='#'>x</a>
    </div>
    <div id='timer-link'>
      <img src='/client/img/bobomb.png'>
    </div>";

  return $html;
}

?>
