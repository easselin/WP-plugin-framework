<?php

if( !defined('__TEXTFIELD') ) {
  define( '__TEXTFIELD' , 1 );

class Textfield extends Field {
  
  public function __construct($params) {
    parent::__construct($params);
  }
  
  public function show($params=null) {
    //print_r($params);
    $data = get_object_vars($params);
    //echo $data[$this->name];
    //print_r($data);
    $value = (isset($data[$this->name])) ? stripslashes($data[$this->name]) : '';
    echo '
      <label for="'.$this->name.'">'.$this->label.'</label><br/>
      <input type="text" name="'.$this->name.'" size="28" tabindex="" value="'.$value.'" id="'.$this->name.'" />
    ';
  }
  
}

} // end define test

?>