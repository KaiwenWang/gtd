<?
/**
    @package view
*/
/**
    basicModelSelectBox
    
    Takes an array of any standard type of GTD_data_item objects and creates a select box where the value of each option is the id of the object, and the name of each option is the getName method of the object.
    
    $o options array:
    -<b>id</b> id of the select box
    -<b>name</b> name of the select box 
    -<b>class</b> class of the select box
    -<b>title</b> first option in select box, has no value
    -<b>selected_value</b> value of the option to be pre-selected
    
    @param array $data array of GTD_data_item objects
    @param array $o valid kays are id, class, name, title, selected_value 
    @return string html
*/

function basicModelSelectBox( $data, $o){
    $attributes_html = '';
    if( $o['id']) $attributes_html = 'id = "'.$o['id'].'" ';
    if( $o['class']) $attributes_html = 'class = "'.$o['class'].'" ';
    if( $o['name']) $attributes_html = 'name = "'.$o['name'].'" ';
        
    $options_html = '';
    if ( $o['title']) $options_html .= '<option value="">'.$o['title'].'</option>';
    foreach( $data as $m){
        if ( $m->id == $o['selected_value']){
            $selected = 'selected="selected"';
        } else{
            $selected = '';
        }
        $options_html .= '<option '.$selected.' value="'.$m->id.'">'.$m->getName().'</option>';
    }
    return "<select $attributes_html>$options_html</select>";
} 
?>