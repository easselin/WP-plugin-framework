<?php
/* 
 * Fonctions utiles pour les plugins de wordpress
 */


if(!function_exists('my_admin_alert')) {
/**
 *
 * @param <String> $texte
 * @param <String> $message_type
 *
 * @example $message_type peut prendre la valeur 'error' ou 'updated' par default
 */
function my_admin_alert($texte, $message_type='updated'){
    echo '<div id="message" class="'.$message_type.' fade"><p><strong>'.$texte.'</strong></p></div>';
}

} // end function_exists


if(!function_exists('list_option')) {
/** fonction pour afficher une liste d'options dans un <select> provenant d'une table MySQL
 * @param <String> $req -Requête SQL à afficher
 * @param <String> $champ -Champ de la table à afficher dans la liste
 * @param <String> $cvalue -Champ de la table à utiliser pour l'attribut value="" ou 0,1,2,3... si =NULL
 * @param <String> $default -Valeur sélectionnée par défaut
 * @example <?php list_option($pays, 'nom', 'code'); ?> où
 *          $pays=$db->requete_sql('select * from pays');
 */
function list_option($req, $champ, $cvalue=NULL, $default=NULL){
    echo '<option value="0" selected>'.$default.'</option>';
    if($cvalue==NULL){
        $value=0;
    }
    while($row = mysql_fetch_array($req)){
        if($cvalue!=NULL){
            $value = $row[$cvalue];
        }
        echo '<option value="'.$value.'" id="'.$row[$champ].'">'.htmlentities($row[$champ]).'</option>';
        if($cvalue==NULL){
            $value++;
        }
    }
}
} // end function_exists
?>
