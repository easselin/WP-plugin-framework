<?php

function de_recherche_page_form() {

  // On teste les donnees du formulaire et on verifie le champ titre
  if(isset($_POST['search_object'])){
    //phpinfo(32);        
    de_recherche_list_page();

  } else {
    
?>
<div class="wrap">
    <div id="icon-edit" class="icon32"><br /></div>
    <h2>Rechercher dans les demandes d'emplois</h2>

    <form id="addlink" method="post" action="" enctype="multipart/form-data">
        <div id="poststuff" class="metabox-holder has-right-sidebar">
            <div id="post-body">
                <div id="post-body-content">
      <div id="infogendiv" class="stuffbox">

        <h3>Informations générales</h3>
        <div class="inside">
          <table style="width: 100%;"><tr><td>
      <label for="nom">Nom</label><br/>
      <input type="text" name="nom" size="28" tabindex="" value="" id="nom" />
    </td><td>
      <label for="adresse">Adresse</label><br/>

      <input type="text" name="adresse" size="28" tabindex="" value="" id="adresse" />
    </td></tr><tr><td>
      <label for="telephone">Téléphone</label><br/>
      <input type="text" name="telephone" size="28" tabindex="" value="" id="telephone" />
    </td><td>
      <label for="cellulaire">Cellulaire</label><br/>
      <input type="text" name="cellulaire" size="28" tabindex="" value="" id="cellulaire" />
    </td></tr><tr><td>

      <label for="courriel">Courriel</label><br/>
      <input type="text" name="courriel" size="28" tabindex="" value="" id="courriel" />
    </td><td>
    </td></tr><tr><td>

      <label for="langues_parlees">Langues parlées</label><br/>
      <textarea name="langues_parlees" id="langues_parlees" cols="24" rows="3"></textarea>
    </td></tr>
          </table>
        </div>
      </div>
      <div id="infogendiv" class="stuffbox">
        <h3>Informations sur les emplois</h3>

        <div class="inside">
          <table style="width: 100%;"><tr><td>
      <label for="emplois_recherches">Emplois recherchés</label><br/>
      <textarea name="emplois_recherches" id="emplois_recherches" cols="24" rows="3"></textarea>
    </td><td>
      <label for="regions_disponibles">Régions disponibles</label><br/>
      <textarea name="regions_disponibles" id="regions_disponibles" cols="24" rows="3"></textarea>

    </td></tr><tr><td>
      <label for="annees_experiences">Années expériences</label><br/>
      <input type="text" name="annees_experiences" size="28" tabindex="" value="" id="annees_experiences" />
    </td><td>
      <label for="nb_heures_recherchees">Nb d'heures recherchées</label><br/>
      <input type="text" name="nb_heures_recherchees" size="28" tabindex="" value="" id="nb_heures_recherchees" />
    </td></tr><tr><td>
      <label for="salaire_horaire_desire">Salaire horaire désiré</label><br/>

      <input type="text" name="salaire_horaire_desire" size="28" tabindex="" value="" id="salaire_horaire_desire" />
    </td><td>
        <input type="checkbox" name="possede_auto[]" tabindex="" value="Possède auto" id="possede_auto_Possède auto"  />
        <label for="possede_auto_Possède auto">Possède auto</label>
      </td></tr></tr>
          </table>
        </div>
      </div>

      <div id="infogendiv" class="stuffbox">
        <h3>Informations sur les disponibilités</h3>
        <div class="inside">
          <table style="width: 100%;"><tr><td>
      <label for="date_debut">Date de début</label><br/>
      <input type="text" name="date_debut" size="28" tabindex="" value="" id="date_debut" />
    </td></tr><tr><td><strong>Jour</strong><br />

        <input type="checkbox" name="dispo_jour[]" tabindex="" value="Lundi" id="dispo_jour_Lundi"  />
        <label for="dispo_jour_Lundi">Lundi</label>
      
        <input type="checkbox" name="dispo_jour[]" tabindex="" value="Mardi" id="dispo_jour_Mardi"  />
        <label for="dispo_jour_Mardi">Mardi</label>
      
        <input type="checkbox" name="dispo_jour[]" tabindex="" value="Mercredi" id="dispo_jour_Mercredi"  />
        <label for="dispo_jour_Mercredi">Mercredi</label>
      
        <input type="checkbox" name="dispo_jour[]" tabindex="" value="Jeudi" id="dispo_jour_Jeudi"  />

        <label for="dispo_jour_Jeudi">Jeudi</label>
      
        <input type="checkbox" name="dispo_jour[]" tabindex="" value="Vendredi" id="dispo_jour_Vendredi"  />
        <label for="dispo_jour_Vendredi">Vendredi</label>
      
        <input type="checkbox" name="dispo_jour[]" tabindex="" value="Samedi" id="dispo_jour_Samedi"  />
        <label for="dispo_jour_Samedi">Samedi</label>
      
        <input type="checkbox" name="dispo_jour[]" tabindex="" value="Dimanche" id="dispo_jour_Dimanche"  />
        <label for="dispo_jour_Dimanche">Dimanche</label>

      </td></tr><tr><td><strong>Soir</strong><br />
        <input type="checkbox" name="dispo_soir[]" tabindex="" value="Lundi" id="dispo_soir_Lundi"  />
        <label for="dispo_soir_Lundi">Lundi</label>
      
        <input type="checkbox" name="dispo_soir[]" tabindex="" value="Mardi" id="dispo_soir_Mardi"  />
        <label for="dispo_soir_Mardi">Mardi</label>
      
        <input type="checkbox" name="dispo_soir[]" tabindex="" value="Mercredi" id="dispo_soir_Mercredi"  />
        <label for="dispo_soir_Mercredi">Mercredi</label>

      
        <input type="checkbox" name="dispo_soir[]" tabindex="" value="Jeudi" id="dispo_soir_Jeudi"  />
        <label for="dispo_soir_Jeudi">Jeudi</label>
      
        <input type="checkbox" name="dispo_soir[]" tabindex="" value="Vendredi" id="dispo_soir_Vendredi"  />
        <label for="dispo_soir_Vendredi">Vendredi</label>
      
        <input type="checkbox" name="dispo_soir[]" tabindex="" value="Samedi" id="dispo_soir_Samedi"  />
        <label for="dispo_soir_Samedi">Samedi</label>
      
        <input type="checkbox" name="dispo_soir[]" tabindex="" value="Dimanche" id="dispo_soir_Dimanche"  />

        <label for="dispo_soir_Dimanche">Dimanche</label>
      </td></tr><tr><td><strong>Nuit</strong><br />
        <input type="checkbox" name="dispo_nuit[]" tabindex="" value="Lundi" id="dispo_nuit_Lundi"  />
        <label for="dispo_nuit_Lundi">Lundi</label>
      
        <input type="checkbox" name="dispo_nuit[]" tabindex="" value="Mardi" id="dispo_nuit_Mardi"  />
        <label for="dispo_nuit_Mardi">Mardi</label>
      
        <input type="checkbox" name="dispo_nuit[]" tabindex="" value="Mercredi" id="dispo_nuit_Mercredi"  />

        <label for="dispo_nuit_Mercredi">Mercredi</label>
      
        <input type="checkbox" name="dispo_nuit[]" tabindex="" value="Jeudi" id="dispo_nuit_Jeudi"  />
        <label for="dispo_nuit_Jeudi">Jeudi</label>
      
        <input type="checkbox" name="dispo_nuit[]" tabindex="" value="Vendredi" id="dispo_nuit_Vendredi"  />
        <label for="dispo_nuit_Vendredi">Vendredi</label>
      
        <input type="checkbox" name="dispo_nuit[]" tabindex="" value="Samedi" id="dispo_nuit_Samedi"  />
        <label for="dispo_nuit_Samedi">Samedi</label>

      
        <input type="checkbox" name="dispo_nuit[]" tabindex="" value="Dimanche" id="dispo_nuit_Dimanche"  />
        <label for="dispo_nuit_Dimanche">Dimanche</label>
      </td></tr></tr>
          </table>
        </div>
      </div>
      <div id="infogendiv" class="stuffbox">
        <h3>Autres informations</h3>

        <div class="inside">
          <table style="width: 100%;"><tr><td>
      <label for="outils_informatiques">Outils informatiques</label><br/>
      <textarea name="outils_informatiques" id="outils_informatiques" cols="24" rows="3"></textarea>
    </td><td>
      <label for="ge_references">Références</label><br/>
      <textarea name="ge_references" id="ge_references" cols="24" rows="3"></textarea>

    </td><td>
      <label for="note">Notes</label><br/>
      <textarea name="note" id="note" cols="24" rows="3"></textarea>
    </td></tr></tr>
          </table>
        </div>
      </div>
                            <div id="major-publishing-actions">

                            <div id="delete-action"></div>
                            <div id="publishing-action">
                                <input type="hidden" name="ea_nonce" value="77366b6ab9" />
                                <input type="submit" class="button-primary" name="search_object" value="Lancer la recherche" tabindex="99" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

</div>
<?php
  }
} // Fin de la fonction forfaits_page_form()

function de_recherche_list_page() {
  //phpinfo(32);

  $query = array();
  // On recupere et on nettoie les donnees POST
  $searchableString = array('nom', 'adresse', 'telephone', 'cellulaire', 'courriel', 'emplois_recherches',
                'regions_disponibles', 'langues_parlees', 'note', 'outils_informatiques', 'ge_references');
  foreach($searchableString as $src) {
    $str = stripslashes($_POST[$src]);
    if($str != '') {
      $str = $src.' like \'%'.$str.'%\'';
      array_push($query, $str);
    }
  }
  
  $searchableNumeric = array('annees_experiences', 'nb_heures_recherchees', 'salaire_horaire_desire');
  foreach($searchableNumeric as $src) {
    $str = stripslashes($_POST[$src]);
    if($str != '') {
      $str = $src.' = '.$str;
      array_push($query, $str);
    }
  }
  
  $searchableDate = array('date_debut');
  foreach($searchableDate as $src) {
    $str = stripslashes($_POST[$src]);
    if($str != '') {
      $str = $src.' like \'%'.$str.'%\'';
      array_push($query, $str);
    }
  }
  
  $dispo_jour = $dispo_soir = $dispo_nuit = '';
  $jours = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
  foreach($jours as $jour) {
    if(in_array($jour, (array)$_POST['dispo_jour'])) {
      $dispo_jour .= '1';
    } else {
      $dispo_jour .= '_';
    }
    if(in_array($jour, (array)$_POST['dispo_soir'])) {
      $dispo_soir .= '1';
    } else {
      $dispo_soir .= '_';
    }
    if(in_array($jour, (array)$_POST['dispo_nuit'])) {
      $dispo_nuit .= '1';
    } else {
      $dispo_nuit .= '_';
    }
  }
  array_push($query, ' dispo_jour like \''.$dispo_jour.'\'');
  array_push($query, ' dispo_soir like \''.$dispo_soir.'\'');
  array_push($query, ' dispo_nuit like \''.$dispo_nuit.'\'');

  if(!isset($_POST['possede_auto'])) {
    $possede_auto = '_';
  } else {
    $possede_auto = '1';
  }
  array_push($query, ' possede_auto like \''.$possede_auto.'\'');

  $demandes = new Demande();

  ?>
<div class="wrap">
  <div id="icon-edit" class="icon32"><br /></div>
  <h2>Résultats de la recherche <a href="<?php echo wp_nonce_url( get_option('siteurl') . '/wp-admin/admin.php?page=', 'de_recherche_page_form'); ?>" class="button add-new-h2">Nouvelle recherche</a></h2>
  <table class="widefat">
      <thead>
          <tr>
              <th scope="col">ID</th>
              <th scope="col">Nom</th>
              <th scope="col">Téléphone</th>
              <th scope="col">Courriel</th>
              <th scope="col" colspan="1">Actions</th>
          </tr>
      </thead>
      <tbody>
        <?php
        foreach ( (array) $demandes->getCollection(array('whereClause'=>$query)) as $demande ) :
            ?>
            <tr id="post-<?php echo $demande->id; ?>" class="alternate" valign="top">
                <td><?php echo $demande->id; ?></td>
                <td><?php echo stripslashes($demande->nom); ?></td>
                <td><?php echo stripslashes($demande->telephone); ?></td>
                <td><?php echo stripslashes($demande->courriel); ?></td>
                <td><a href="<?php echo get_option('siteurl'); ?>/wp-admin/admin.php?page=demandes&amp;action=edit&amp;object_id=<?php echo $demande->id; ?>">Editer</a></td>
                <!--<td><a href="<?php echo wp_nonce_url( get_option('siteurl') . '/wp-admin/admin.php?page=demandes&amp;action=delete&amp;object_id='.$demande->id, 'delete_object'); ?>">Effacer</a></td>-->
            </tr>
            <?php
        endforeach;
        ?>
      </tbody>
  </table>

</div>
<?php


?>
<?php
} 

?>