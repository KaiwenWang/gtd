<?php

function bookmarkWidget() {
  $html = "
    <div id='bookmark-link'>
      <img src='/client/img/star.png'>
    </div>
    <div id='bookmark-form-box' style='display:none'>
      <div id='bookmark-form'></div>
      <a id='bookmark-close' href='#'>x</a>
    </div>";

  return $html;
}

?>
