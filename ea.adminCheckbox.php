<?php

if( !defined('__CHECKBOX') ) {
  define( '__CHECKBOX' , 1 );

class Checkbox extends Field {
  
  public $groupArray;
  public $title;
  
  public function __construct($params) {
    $params = (array)$params;
    parent::__construct($params);
    $this->groupArray = (array_key_exists('group', $params)) ? $params['group'] : array();
    $this->title = (array_key_exists('title', $params)) ? $params['title'] : false;
    if($this->preCallback == null) {
      $this->preCallback = array($this, 'chkBinaryBuild');
    }
  }
  
  public function show($params=null) {

    $data = get_object_vars($params);
    
    if($this->title) {
      echo '<strong>'.$this->label.'</strong><br />';
    }
    
    $value = (isset($data[$this->name])) ? $data[$this->name] : '';
    $value = str_split($value);    
    $count = 0;
    
    foreach($this->groupArray as $unitChk) {
      
      $checked = '';
      if($value[$count] == '1') {
        $checked = 'checked="checked"';
      }
      
      //echo 'le callback est: '.$this->preCallback;
      echo '
        <input type="checkbox" name="'.$this->name.'[]" tabindex="" value="'.$unitChk.'" id="'.$this->name.'_'.$unitChk.'" '.$checked.' />
        <label for="'.$this->name.'_'.$unitChk.'">'.$unitChk.'</label>
      ';
      
      $count++;
      
    }
    
  }
  
  

  public function chkBinaryBuild($value) {
    //print_r($value);
    if(!is_array($value)) {
      $value = array();
    }

    $newvalue = '';
    
    foreach($this->groupArray as $unitChk) {
      //echo $unitChk;
      
      if(in_array($unitChk, $value)) {
        $newvalue .= '1';
      } else {
        $newvalue .= '0';
      }
      
    }
    //print_r($newvalue);
    return $newvalue;
  }
  
}

} // end define test

?>