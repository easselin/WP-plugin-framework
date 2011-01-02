<?php
/* 
Plugin Name: Phone Counter
Plugin URI: http://www.ericasselin.com
Description: Keep track of click on phone number
Version: 0.1.2
Author: Eric Asselin
Author URI: http://www.ericasselin.com
*/

require(dirname(__FILE__).'/inc/fonctions.plugins.php');
require(dirname(__FILE__).'/inc/pc.db.php');
require(dirname(__FILE__).'/inc/pc.css.php');
require(dirname(__FILE__).'/inc/pc.js.php');
require(dirname(__FILE__).'/inc/pc.dashboard.php');
require(dirname(__FILE__).'/inc/pc.install.php');

// Installation du plugin (fichier zag.install.php)
register_activation_hook(__FILE__, 'pc_install');

// Fonction d'initialisation du plugin
add_action('plugins_loaded', 'pc_init');

function pc_init(){

    // Initialisation Admin
    if(is_admin()){
      add_action('wp_print_scripts', 'pc_ScriptsActionAdmin');
    } else {
      add_action('wp_print_scripts', 'pc_ScriptsActionTheme');
    }
    
}

function pc_ScriptsActionAdmin() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('postbox');
  wp_enqueue_script('post');
  wp_enqueue_script('thickbox');
}

function pc_ScriptsActionTheme() {
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js');
  wp_enqueue_script('jquery');
}

?>