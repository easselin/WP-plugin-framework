<?php
/* 
Plugin Name: Gestion Emplois
Plugin URI: http://www.ericasselin.com
Description: Plate-forme de gestion des demandes d'emplois
Version: 0.1
Author: Eric Asselin
Author URI: http://www.ericasselin.com
*/

require(dirname(__FILE__).'/inc/fonctions.plugins.php');

require(dirname(__FILE__).'/inc/ge.db.php');
require(dirname(__FILE__).'/inc/ge.admin.php');
require(dirname(__FILE__).'/inc/ge.css.php');
//require(dirname(__FILE__).'/inc/ar.js.php');
//require(dirname(__FILE__).'/inc/ar.dashboard.php');
require(dirname(__FILE__).'/inc/ge.install.php');
require(dirname(__FILE__).'/inc/ge.client.formpage.php');

// Installation du plugin (fichier zag.install.php)
register_activation_hook(__FILE__, 'ge_install');

// Fonction d'initialisation du plugin
add_action('plugins_loaded', 'ge_init');

function ge_init(){

    // Initialisation Admin
    if(is_admin()){
      
      add_action('admin_menu','ge_add_menu');
      add_action('wp_print_scripts', 'ge_ScriptsActionAdmin');
    } else {
      add_action('wp_print_scripts', 'ge_ScriptsActionTheme');
    }
    
}

function ge_ScriptsActionAdmin() {
}

function ge_ScriptsActionTheme() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
  wp_enqueue_script('jquery');
  wp_register_script('ui-core', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js');
  wp_enqueue_script('ui-core');
}


?>