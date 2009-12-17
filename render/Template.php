<?php
class Template{
    var $_class_name = 'Template';
    var $html;
    
    function __construct($file_path){
         if (file_exists($file_path))
            $this->html = join("", file($file_path));
        else
            bail("Template file $template not found.");
    }
    function replace_tags($tags = array()){
        if (count($tags) > 0) {
            foreach ($tags as $tag => $data) {
                $data = ( file_exists( $data))  ? $this->runFile($data) : $data;
                $this->html = preg_replace( "/\[\[" . $tag . "\]\]/i", $data, $this->html);
            }
            $this->html = preg_replace( "/\[\[[^\]]*\]\]/", '', $this->html);
		}else{
            bail("No tags designated for replacement.");
		}
    }
    function runFile($file) {
        ob_start();
        include($file);
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
    function execute( $tags){
        $this->replace_tags( $tags);
        return $this->html;
    }
}
?>
