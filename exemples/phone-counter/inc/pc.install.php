<?php
/**
Installation de l'extension
	- initialisation des tables de la bd
	- Initialisation des permissions
 */

// Creation de la table lors de l'installation
function pc_install() {
    
    // Creation des tables si elles n'existent pas
    pc_init_db();

    // Initialisation des permissions
    pc_init_permission();
}

// Ajout des permissions
function pc_init_permission() {
    if(function_exists('get_role')) {

        // Recupere l'objet "Role administrateur"
        $role = get_role('administrator');

        // Si la permission "use_pc" n'existe pas, on l'ajoute
        if($role != null && !$role->has_cap('use_pc')){
            $role->add_cap('use_pc');
        }

        // Pareil pour la permission "admin_pc"
        if($role != null && !$role->has_cap('admin_pc')) {
            $role->add_cap('admin_pc');
        }

        // On supprime la variable de notre fonction
        unset($role);

        // On procede de la meme facon pour le role "Editeur" sauf qu'on lui
        // ajoute uniquement la permission "use_pc"
        $role = get_role('editor');
        if($role != null && !$role->has_cap('use_pc')) {
            $role->add_cap('use_pc');
        }

        // On supprime la variable de notre fonction
        unset($role);
    }
}

function pc_init_db() {
    global $wpdb, $table_pc_stats;
    $table_pc_stats = $wpdb->prefix."pc_stats";

    // Verifie si la table n'existe pas
    if($wpdb->get_var("show table like '{$table_pc_stats}'") != $table_pc_stats){

        // Construction la requete SQL de creation de table
        $sql =
            'CREATE TABLE '.$table_pc_stats.' (
              id INTEGER AUTO_INCREMENT,
              date TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
              url VARCHAR(255),
              ip_addr VARCHAR(255),
              PRIMARY KEY (id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';

        // Execution de la requete
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql);

    }

}
?>
