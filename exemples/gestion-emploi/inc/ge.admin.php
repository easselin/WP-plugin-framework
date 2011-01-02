<?php
/* 
Partie administration du plugin:
	- Ajout des menus
	- Page du formulaire
	- Page d'options
	- Page de gestion
	- Fonction de génération de l'alerte WordPress
*/

//require(dirname(__FILE__).'/ar.admin.options.php');
//require(dirname(__FILE__).'/ar.admin.help.php');

require(dirname(__FILE__).'/ea.adminForm.php');
require(dirname(__FILE__).'/ea.adminBOPage.php');

require(dirname(__FILE__).'/ge.admin.demandes.php');
require(dirname(__FILE__).'/ge.admin.recherche.php');



// Menu administrateur
function ge_add_menu(){
  /*
    // Menu reglage - Admin
    add_options_page('Galerie Réglages', 'Galerie Réglages', 'admin_zag',
                     'zags_options', 'zag_page_options');

    add_action( 'contextual_help', 'my_admin_help_function' );
    
    */
      
    add_menu_page( 'Demandes d\'emplois', 'Demandes d\'emplois', 'use_ge', 'demandeMenu', 'ge_dummyFunc', '', 110 );

    $demandeAdmin = new DemandeAdmin();
    
    unset($GLOBALS['submenu']['demandeMenu'][0]);
    
    add_submenu_page('demandeMenu', 'Rechercher dans les demandes d\'emplois',
                     'Faire une recherche', 'use_ge', '',
                     'de_recherche_page_form');

}

function ge_dummyFunc() {
    echo '<pre>';
    print_r($GLOBALS['menu']);
    echo '</pre>';
}

?>
