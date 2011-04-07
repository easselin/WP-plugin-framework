<?php

if( !defined('__CHECKBOX') ) {
  define( '__CHECKBOX' , 1 );

class Checkbox extends Field {
  
  public $groupArray;
  public $title;
  public $fieldType; // bin->binary, csi->comma separated ids
  
  public function __construct($params) {
    $params = (array)$params;
    parent::__construct($params);
    $this->groupArray = (array_key_exists('group', $params)) ? $params['group'] : array();
    $this->title = (array_key_exists('title', $params)) ? $params['title'] : false;
    $this->fieldType = (array_key_exists('fieldType', $params)) ? $params['fieldType'] : 'bin';
    if( $this->preCallback == null && $this->fieldType == 'bin' ) {
      $this->preCallback = array($this, 'chkBinaryBuild');
    } elseif( $this->preCallback == null && $this->fieldType == 'csi' ) {
      $this->preCallback = array($this, 'chkCSIBuild');
    }
  }
  
  public function show($params=null) {

    $data = get_object_vars($params);
    
    if($this->title) {
      echo '<strong>'.$this->label.'</strong><br />';
    }
    
    $value = (isset($data[$this->name])) ? $data[$this->name] : '';
    if( $this->fieldType == 'bin' ) {
      $value = str_split($value);
    } elseif( $this->fieldType == 'csi' ) {
      $value = explode(',', $value );
    }
    
    $count = 0;
    
    foreach($this->groupArray as $key => $unitChk) {
      
      $checked = $this->isChecked($count, $value, $key);
      
      //echo 'le callback est: '.$this->preCallback;
      echo '
        <input type="checkbox" name="'.$this->name.'[]" tabindex="" value="'.$key.'" id="'.$this->name.'_'.$key.'" '.$checked.' />
        <label for="'.$this->name.'_'.$key.'">'.$unitChk.'</label><br />
      ';
      
      $count++;
      
    }
    
  }
  
  private function isChecked($c, $v, $k) {

    if( $this->fieldType == 'bin' && $v[$c] == '1') {
      return 'checked="checked"';
      
    } elseif( $this->fieldType == 'csi' && in_array($k, $v)) {
      return 'checked="checked"';
      
    } else {
      return '';
    }
  }
  

  public function chkBinaryBuild($value) {
    if(!is_array($value)) {
      $value = array();
    }

    $newvalue = '';
    
    foreach($this->groupArray as $unitChk) {
      
      if(in_array($unitChk, $value)) {
        $newvalue .= '1';
      } else {
        $newvalue .= '0';
      }
      
    }
    return $newvalue;
  }
  
  public function chkCSIBuild($value) {
    if(!is_array($value)) {
      $value = array();
    }
    return implode(',', $value);
  }
  
}

} // end define test

?>