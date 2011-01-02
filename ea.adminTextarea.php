<?php

if( !defined('__TEXTAREA') ) {
  define( '__TEXTAREA' , 1 );

class Textarea extends Field {
  
  public function __construct($params) {
    parent::__construct($params);
  }
  
  public function show($params=null) {

    $data = get_object_vars($params);

    $value = (isset($data[$this->name])) ? stripslashes($data[$this->name]) : '';

    echo '
      <label for="'.$this->name.'">'.$this->label.'</label><br/>
      <textarea name="'.$this->name.'" id="'.$this->name.'" cols="24" rows="3">'.$value.'</textarea>
    ';
  }
  
}

} // end define test

?>