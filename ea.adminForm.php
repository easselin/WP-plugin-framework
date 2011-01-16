<?php

if( !defined('__ADMINFORM') ) {
  define( '__ADMINFORM' , 1 );

class AdminForm {
  
  protected $title;
  protected $fieldsetArray;
  protected $postCallbackArray;
  
  public function __construct($str) {
    $this->title = $str;
    $this->fieldsetArray = array();
    $this->postCallbackArray = array();
  }
  
  public function addFieldset($fieldset) {
    array_push($this->fieldsetArray, $fieldset);
  }
  
  public function addPostCallback($callback) {
    array_push($this->postCallbackArray, $callback);
  }

  public function show($params=null) {
    echo '
    <div class="wrap">
    <div id="icon-edit" class="icon32"><br /></div>
    <h2>'.$this->title.'</h2>

    <form id="addlink" method="post" action="" enctype="multipart/form-data">
        <div id="poststuff" class="metabox-holder has-right-sidebar">
            <div id="post-body">
                <div id="post-body-content">';
                
    foreach($this->fieldsetArray as $fieldset) {
      $fieldset->show($params);
    }
    
    echo '
                            <div id="major-publishing-actions">
                            <div id="delete-action"></div>
                            <div id="publishing-action">
                                <input type="hidden" name="ea_nonce" value="'.wp_create_nonce('add_or_update').'" />
                                <input type="submit" class="button-primary" name="save_object" value="Enregistrer" tabindex="99" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>';
  }
  
  public function getFieldsetArray() {
    return $this->fieldsetArray;
  }

  public function getPostCallbackArray() {
    return $this->postCallbackArray;
  }
  
  public function __destruct() {}
  
}

class Fieldset {
  
  protected $title;
  protected $fieldArray;
  protected $layout;

  public function __construct($params) {
    $this->fieldArray = array();
    $this->title = (array_key_exists('title', $params)) ? $params['title'] : 'Fieldset title';
    $this->layout = (array_key_exists('layout', $params)) ? $params['layout'] : 1;
  }
  
  public function addField($field) {
    array_push($this->fieldArray, $field);
  }
  
  public function show($params=null) {
    echo '
      <div id="infogendiv" class="stuffbox">
        <h3>'.$this->title.'</h3>
        <div class="inside">
          <table style="width: 100%;">';
    
    $count = 0;
    foreach($this->fieldArray as $field) {
      $count++;
      if($count == 1) {
        echo '<tr>';
      }
      
      echo '<td>';
      $field->show($params);
      //echo $count % $this->layout;
      echo '</td>';

      if($count == $this->layout) {
        echo '</tr>';
        $count = 0;
      }
      
      
    }
    if($count < $this->layout) { echo '</tr>'; }

    echo '
          </table>
        </div>
      </div>';
  }

  public function getFieldArray() {
    return $this->fieldArray;
  }
  
  public function __destruct() {}
    
}

abstract class Field {
  
  public $name;
  //protected $type; ??????
  public $label;
  public $preCallback;
  public $postCallback;
  public $isInsertable;
  
  public function __construct($params) {
    $params = (array)$params;
    $this->name = (array_key_exists('name', $params)) ? $params['name'] : 'fieldname';
    $this->label = (array_key_exists('label', $params)) ? $params['label'] : 'fieldlabel';
    $this->preCallback = (array_key_exists('preCallback', $params)) ? $params['preCallback'] : null;
    $this->postCallback = (array_key_exists('postCallback', $params)) ? $params['postCallback'] : null;
    $this->isInsertable = (array_key_exists('isInsertable', $params)) ? $params['isInsertable'] : true;
  }
  
  abstract public function show($params=null);

  public function preProcess($value) {
    //print_r($value);
    if($this->preCallback != null) {
      $value = call_user_func($this->preCallback, $value);
    }
    return $value;
  }
  
  public function getPostCallback($params=null) {
    return $this->postCallback;
  }
  
  public function __destruct() {}
  
}

include('ea.adminTextfield.php');
include('ea.adminTextarea.php');
include('ea.adminCheckbox.php');
include('ea.adminFilefield.php');
include('ea.adminWPTagsfield.php');

} // end define test

?>