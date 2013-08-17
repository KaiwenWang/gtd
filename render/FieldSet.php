<?php
class FieldSet {
    var $new_object_counter;
    var $obj;
    var $is_new_object;

    function __construct( $obj, $new_object_counter = ''){
        $this->obj = $obj;
        $obj->id  ? $this->is_new_object = false
            : $this->is_new_object = true;

        $this->new_object_counter = $new_object_counter;
    }
    function __get( $field_name) {
        return $this->field($field_name);
    }
    function field( $field_name, $options = array()){
        $r = getRenderer();

        return $this->is_new_object ? $r->field( $this->obj, 
            $field_name,
            $options,
            $this->new_object_counter)

            : $r->field( $this->obj,
                $field_name,
                $options);
    }
}
