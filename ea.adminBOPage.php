<?php

if( !defined('__ADMINBOPAGE') ) {
  define( '__ADMINBOPAGE' , 1 );

abstract class adminBOPage {
  
  protected $parentMenu;
  protected $pageTitle;
  protected $menuTitle;
  protected $capability;
  protected $menuId;
  protected $function;
  protected $businessObject;
  protected $listableField;
  protected $adminForm;
  
  public function __construct($params=null) {
    
    $params = (array)$params;
    $this->parentMenu = (array_key_exists('parentMenu', $params)) ? $params['parentMenu'] : 'post-new.php';
    $this->pageTitle = (array_key_exists('pageTitle', $params)) ? $params['pageTitle'] : 'Object admin';
    $this->menuTitle = (array_key_exists('menuTitle', $params)) ? $params['menuTitle'] : 'Object admin';
    $this->capability = (array_key_exists('capability', $params)) ? $params['capability'] : 'edit_pages';
    $this->menuId = (array_key_exists('menuId', $params)) ? $params['menuId'] : '';
    $this->function = (array_key_exists('function', $params)) ? $params['function'] : array( $this, 'adminCollection' );
    
    /*
    if($this->businessObject==null){
      wp_die('WP-Framework.Init Error (adminBOPage Class) - businessObject not define');
    }
    */
    
    add_submenu_page($this->parentMenu, $this->pageTitle,
                     $this->menuTitle, $this->capability, $this->menuId,
                     $this->function);
  }
  
  abstract protected function setBusinessObject();
  abstract protected function setListableField();
  abstract protected function setAdminForm();
  
/*
  public function dummyFunc($params=null) {
    echo '<pre>';
    print_r($this->businessObject->getById($params['objectId']));
    echo $params['action'];
    echo '</pre>';
  }
*/
  
  public function adminCollection($params=null) {
    
    if((isset($_GET['action']) && $_GET['action']=='add') ||
        (isset($_GET['action']) && $_GET['action']=='edit')) {
      
      $params = array('action'=>$_GET['action']);
      
      if(isset($_GET['object_id'])) {
        $params['objectId'] = $_GET['object_id'];
      }
      
      $this->adminObject($params);
      
    } else {
    
    // On regarde s'il y a le param GET d'effacement
    if(isset($_GET['object_id'])&&$_GET['action']=='delete'){

      // On verfie les permissions
      if(current_user_can($this->capability)&&wp_verify_nonce($_GET['_wpnonce'],'delete_object')){
        $this->businessObject->delete($_GET['object_id']);
        my_admin_alert('Suppression réussie.');
      }
    }

    // todo -> Pagination
    $objectCollection = $this->businessObject->getCollection(array('limit'=>999999));
    ?>
    <div class="wrap">
      <div id="icon-edit" class="icon32"><br /></div>
      
      <h2><?php echo $this->pageTitle ?> <a href="admin.php?page=<?php echo $this->menuId ?>&action=add" class="button add-new-h2">Ajouter</a></h2>
      
      <table class="widefat">
        <thead>
          <tr>
            <?php foreach ( $this->listableField as $column ) : ?>
            <th scope="col"><?php echo $column ?></th>
            <?php endforeach; ?>
            <th scope="col" colspan="2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ( (array) $objectCollection as $object ) :
          ?>
          
          <tr id="post-<?php echo $object->id; ?>" class="alternate" valign="top">
            
            <?php
              $keys = array_keys($this->listableField);
              foreach ( $keys as $key ) : 
            ?>
            <td><?php echo $object->$key ?></td>
            <?php endforeach; ?>
            
            <td><a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=<?php echo $this->menuId; ?>&amp;action=edit&amp;object_id=<?php echo $object->id; ?>">Editer</a></td>
            <td><a href="<?php echo wp_nonce_url( get_option('siteurl') . '/wp-admin/admin.php?page='.$this->menuId.'&amp;action=delete&amp;object_id='.$object->id, 'delete_object'); ?>">Effacer</a></td>
          </tr>
          <?php
          endforeach;
          ?>
        </tbody>
      </table>
    </div>
  <?php
    }

  } // fin de la methode adminCollection

  public function adminObject($params) {
    
    // On verifie si on edite sinon on ajoute
    $edit = ($params['action']=='edit') ? true : false;
    
    if(isset($_POST['save_object'])){
      // Secu, teste les permissions
      if(current_user_can($this->capability)&&wp_verify_nonce($_POST['ea_nonce'], 'add_or_update')){
        //phpinfo(32);
        
        // On recupere et on nettoie les donnees POST
        // c'est en commentaire car il y a un problème avec les tableaux des checkbox
        //$_POST = array_map(array($this, 'cleanData'), $_POST);
        
        //print_r($_POST);

        $data = array();
        foreach($this->adminForm->getFieldsetArray() as $fieldset) {
          foreach($fieldset->getFieldArray() as $field) {
            
            // pour forcer les groupes de checkbox vident ou les fichiers
            if(!isset($_POST[$field->name])) {
              if(isset($_FILES[$field->name])) {
                $data[$field->name] = $_FILES[$field->name];
                $data[$field->name] = $field->preProcess($data[$field->name]);
              } else {
                $data[$field->name] = array();
                $data[$field->name] = $field->preProcess($data[$field->name]);
              }
            }
            
            // pour les fichiers
            //if()
            
            if($_POST[$field->name] != "") {
              $data[$field->name] = $_POST[$field->name];
              //print_r($data[$field->name]);
              $data[$field->name] = $field->preProcess($data[$field->name]);
              //echo $field->name;
            } else {
              //echo $field->name;
            }
            //echo $field->label.'<br>';
          }
        }
        
        //echo '<pre>';
        //print_r($data);
        //echo '</pre>';
        //$this->businessObject->show_errors();
        if($edit == true) { // on modifie
          $id = (int)$params['objectId'];
          $state = $this->businessObject->update($id, $data);
          if($state > 0) {
            my_admin_alert('Mis à jour réussi! ');
          } else {
            // Une erreur apparait lorsque l'on enregistre sans faire de modification mais tout semble ok...?
            // Un test a été fait avec la db et ceci semble provenir du fait que lorsqu'il n'y a pas de changement,
            // la bd retourne 0 pour aucune ligne affectée par l'update
            //my_admin_alert('Une erreur s\'est produite! ');
          }
          
        } else { // on ajoute
          $id = (int)$this->businessObject->add($data);
          if($id > 1) {
            my_admin_alert('Ajout réussi!');
          } else {
            my_admin_alert('Une erreur s\'est produite!');
          }
          
        }
        
      }
    }
    $formData = $this->businessObject->getById((int)$params['objectId']);
    //print_r($formData);
    $this->adminForm->show($formData);

  }
  
  private function cleanData($data) {
    //if(!is_array()) {
    $data = trim($data);
    //$data = htmlentities($data);
    $data = mysql_real_escape_string($data);
    //}
    return $data;
  }
  
  
  public function __destruct() {}
  
}

} // end define test


?>