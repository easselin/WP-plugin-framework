<?php
/**
Installation de l'extension
	- initialisation des tables de la bd
	- Initialisation des permissions
 */

// Creation de la table lors de l'installation
function ge_install() {
    
    // Creation des tables si elles n'existent pas
    ge_init_db();

    // Initialisation des permissions
    ge_init_permission();
}

// Ajout des permissions
function ge_init_permission() {
    if(function_exists('get_role')) {

        // Recupere l'objet "Role administrateur"
        $role = get_role('administrator');

        // Si la permission "use_ar" n'existe pas, on l'ajoute
        if($role != null && !$role->has_cap('use_ge')){
            $role->add_cap('use_ge');
        }

        // Pareil pour la permission "admin_pc"
        if($role != null && !$role->has_cap('admin_ge')) {
            $role->add_cap('admin_ge');
        }

        // On supprime la variable de notre fonction
        unset($role);

        // On procede de la meme facon pour le role "Editeur" sauf qu'on lui
        // ajoute uniquement la permission "use_pc"
        $role = get_role('editor');
        if($role != null && !$role->has_cap('use_ge')) {
            $role->add_cap('use_ge');
        }

        // On supprime la variable de notre fonction
        unset($role);
    }
}

function ge_init_db() {
    global $wpdb,
          $table_ge_demandes;
          
    $table_ge_demandes = $wpdb->prefix."ge_demandes";

    // Verifie si la table n'existe pas
    if($wpdb->get_var("show table like '{$table_ge_demandes}'") != $table_ge_demandes){

        // Construction la requete SQL de creation de table
        $sql =
            "CREATE TABLE {$table_ge_demandes} (
                id INT NOT NULL AUTO_INCREMENT ,
                nom VARCHAR(255) NOT NULL ,
                adresse VARCHAR(255) NOT NULL ,
                telephone VARCHAR(15) NOT NULL ,
                cellulaire VARCHAR(15) NULL ,
                fichier_cv VARCHAR(255) NULL ,
                emplois_recherches TEXT NULL ,
                regions_disponibles TEXT NULL ,
                annees_experiences INT NULL ,
                langues_parlees TEXT NULL ,
                courriel VARCHAR(255) NOT NULL ,
                nb_heures_recherchees INT NULL ,
                salaire_horaire_desire DECIMAL(12,2) NULL ,
                date_debut DATE NOT NULL,
                dispo_jour VARCHAR(7) NOT NULL DEFAULT \"0000000\",
                dispo_soir VARCHAR(7) NOT NULL DEFAULT \"0000000\",
                dispo_nuit VARCHAR(7) NOT NULL DEFAULT \"0000000\",
                possede_auto VARCHAR(1) NOT NULL DEFAULT \"0\" ,
                timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                note TEXT NULL ,
                outils_informatiques TEXT NULL ,
                ge_references TEXT NULL ,
                PRIMARY KEY (id)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
            
        // Execution de la requete
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql);

    }

}
?>
