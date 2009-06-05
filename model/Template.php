<?php
class Template{
    var $_class_name = 'Template';
    var $html;
    
    function Template($path){
        $this->__construct($path);
    }
    function __construct($file_path){
         if (file_exists($file_path))
            $this->html = join("", file($file_path));
        else
            die("Template file $template not found.");
    }
    function replace_tags($tags = array()){
        if (count($tags) > 0)
            foreach ($tags as $tag => $data) {
                $data = ( file_exists( $data))  ? $this->runFile($data) : $data;
                $this->html = eregi_replace( "\[\[" . $tag . "\]\]", $data, $this->html);
            }
        else
            die("No tags designated for replacement.");
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