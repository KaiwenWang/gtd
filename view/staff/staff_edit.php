<?php
function staffEdit( $d, $o = array() ) {
    $r = getRenderer();
    $edit_form = $r->view('staffEditForm',$d->staff);
    $script = '<script type="text/javascript"> 
      $("form input").change(function(event) {
      if($("input[name=\'new_password\']").val() != $("input[name=\'new_password_repeat\']").val()) {
        $(".submit-container input").attr("disabled", "disabled");
        $("input[name=\'new_password_repeat\']").css(\'border\', \'2px solid red\');
      } else {
        $(".submit-container input").removeAttr("disabled");
        $("input[name=\'new_password_repeat\']").css(\'border\', \'\');
      } 
    });
    </script>';

    return array(
        'title'	=> 'Edit: '.$d->staff->getName(),
        'body'	=> $edit_form . $script
    );
}
?>
