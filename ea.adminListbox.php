<?php

if( !defined('__LISTBOX') ) {
  define( '__LISTBOX' , 1 );

class Listbox extends Field {
  
  public $options;
  public $selectedDefault;
  
  
  public function __construct($params) {
    $params = (array)$params;
    parent::__construct($params);
    $this->options = (array_key_exists('options', $params)) ? $params['options'] : array();
    $this->selectedDefault = (array_key_exists('selectedDefault', $params)) ? $params['selectedDefault'] : '';
  }
  
  public function show($params=null) {
    $data = get_object_vars((object)$params);
    $value = (isset($data[$this->name])) ? stripslashes($data[$this->name]) : '';
    
    echo '
      <label for="'.$this->name.'">'.$this->label.'</label><br/>
      <select name="'.$this->name.'" tabindex="" id="'.$this->name.'">';
    
    $count=0;
    foreach((array)$this->options as $key => $optValue) {
      $selected = ($key == $value) ? 'selected="selected"' : '';
      echo '<option value="'.$key.'" id="'.$this->name.'options'.$count.'" '.$selected.'>'.$optValue.'</option>';
      $count++;
    }
    
    echo '</select>';
  }
  
}

} // end define test

?>