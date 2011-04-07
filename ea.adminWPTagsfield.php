<?php

if( !defined('__WPTAGSFIELD') ) {
  define( '__WPTAGSFIELD' , 1 );

class WPTagsfield extends Field {
  
  public $taxonomy;
  
  public function __construct($params) {
    parent::__construct($params);
    $this->isInsertable = true;
    $this->taxonomy = (array_key_exists('taxonomy', $params)) ? $params['taxonomy'] : 'post_tag';
    $this->postCallback = array($this, 'maFonction');
  }
  
  public function show($params=null) {
    //print_r($params);
    $data = get_object_vars($params);
    //echo $data[$this->name];
    //print_r($data);
    $tags_array = wp_get_object_terms($data['id'], $this->taxonomy, array('fields' => 'names'));
    $value = implode(', ', $tags_array );
    //$value = (isset($data[$this->name])) ? stripslashes($data[$this->name]) : '';
    echo '
      <label for="'.$this->name.'">'.$this->label.'</label><br/>
      <input type="text" name="'.$this->name.'" size="28" tabindex="" value="'.$value.'" id="'.$this->name.'" />
    ';
  }
  
  public function maFonction($params) {
    // manque une facon de récupérer les tags...
    //echo $params['id'];
    //echo $_POST[$this->name];
    
    wp_delete_term( $params['id'], $this->taxonomy );
    // On recupere les tags
    $tags = explode(',',$_POST[$this->name]);
    // Nettoie les tags
    $clean_tags = array();
    foreach ((array)$tags as $tag){
      $clean_tags[] = trim($tag);
    }
    wp_set_object_terms($params['id'], $clean_tags, $this->taxonomy, false);
  }
  
}

} // end define test

?>