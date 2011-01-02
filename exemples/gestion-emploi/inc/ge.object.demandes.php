<?php

class Demande extends businessObject {
  
  public function __construct() {
    parent::__construct();
    $this->setObjectTable();
  }

  protected function setObjectTable() {
    $this->obj_table = $this->dbase->prefix."ge_demandes";
  }
  
  public function __destruct() {}
   
}

if(!function_exists('get_emplois_optionlist')){
  function get_emplois_list() {
    $xml = '';
    if (file_exists(ABSPATH.'wp-content/uploads/data/emplois.xml')) {
      $xml = simplexml_load_file(ABSPATH.'wp-content/uploads/data/emplois.xml');
      foreach($xml->group as $unGroup) {
        echo '<optgroup label="'.$unGroup->titre.'">';
        foreach($unGroup->emploi as $emploi) {
          echo '<option value="'.$emploi.'">'.$emploi.'</option>';
        }
        echo '</optgroup>';
      }
    } else {}
    
  }
}

?>