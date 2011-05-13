<?php

if( !defined('__TEXTFIELD') ) {
  define( '__TEXTFIELD' , 1 );

class Textfield extends Field {
  
  public function __construct($params) {
    parent::__construct($params);
  }
  
  public function show($params=null) {
    $disabled = ($this->disabled) ? 'disabled="disabled"' : '';
    //print_r($params);
    $data = get_object_vars((object)$params);
    //echo $data[$this->name];
    //print_r($data);
    $value = (isset($data[$this->name])) ? stripslashes($data[$this->name]) : '';
    echo '
      <label for="'.$this->name.'">'.$this->label.'</label><br/>
      <input type="text" name="'.$this->name.'" size="28" tabindex="" value="'.$value.'" id="'.$this->name.'" '.$disabled.' />
    ';
  }
  
}

} // end define test

?>