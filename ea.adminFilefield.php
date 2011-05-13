<?php

if( !defined('__FILEFIELD') ) {
  define( '__FILEFIELD' , 1 );

class Filefield extends Field {
  
  public $savepath;
  public $fileUrl;
    
  public function __construct($params) {
    $params = (array)$params;
    parent::__construct($params);
    $this->savepath = (array_key_exists('savepath', $params)) ? $params['savepath'] : ABSPATH.'wp-content/uploads';
    $this->fileUrl = (array_key_exists('fileUrl', $params)) ? $params['fileUrl'] : content_url().'/uploads';
    if($this->preCallback == null) {
      $this->preCallback = array($this, 'saveFileToDisk');
    }
  }
  
  public function show($params=null) {

    $data = get_object_vars((object)$params);
    $value = (isset($data[$this->name])) ? stripslashes($data[$this->name]) : '';
    
    echo '
      <label for="'.$this->name.'">'.$this->label.'</label><br/>
      <input type="hidden" name="'.$this->name.'-hid" value="'.$value.'">
      <input type="file" name="'.$this->name.'" size="28" tabindex="" value="" id="'.$this->name.'" /><br />
      <a href="'.$this->fileUrl.'/'.$value.'" target="_blank">'.$value.'</a>
    ';

  }
  
  public function saveFileToDisk($value) {
    //print_r($value);
    
    $newvalue = '';
    
    if(isset($value['name']) && $value['name'] != "") {
      
      $filename = post_slug(stripslashes($value['name']));
    
      if($filename != ''){
        $filepath = $this->savepath.'/'.$filename;
        
        if(move_uploaded_file($value['tmp_name'], $filepath)) {
          //echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
            //" has been uploaded";
        } else{
          echo "There was an error uploading the file, please try again!";
        }

      }
      $newvalue = $filename;
      
    } elseif(isset($_POST[$this->name.'-hid']) && $_POST[$this->name.'-hid'] != "") {
      $newvalue = $_POST[$this->name.'-hid'];
    }
    
    //$newvalue = '';
    return $newvalue;
  }
}

} // end define test

?>