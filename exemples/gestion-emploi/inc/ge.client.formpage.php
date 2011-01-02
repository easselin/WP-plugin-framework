<?php
/*
if(!function_exists('show_demande_form')) {
function show_demande_form() {
  
  if(isset($_POST['nom'])) :
  //phpinfo(32);
  
  // Nettoie les variables
  $clean = $_POST;
  $erreur = array();
  array_walk($clean, 'trim');
  
  // Valide les donnees
  $notEmpty = array('nom', 'adresse', 'telephone', 'courriel', 'langue', 'emplois_recherches', 'nb_heures_recherchees', 'salaire_horaire_desire', 'date_debut');
  $count=0;
  foreach($notEmpty as $item) {
    if($clean[$item] == "") {
      $count++;
    }
  }
  if($count != 0){
    array_push($erreur, "Une erreur s'est produite, le formulaire est incomplet");
  }
  
  $email_pattern = '/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i';
  if(!preg_match($email_pattern, $clean['courriel'])) {
    array_push($erreur, "Une erreur s'est produite avec le courriel");
  }
  
  $clean['langue'] = implode(',', $clean['langue']);
  if($clean['autres_langues'] != '') {
    $clean['langue'] .= ','.$clean['autres_langues'];
  }
  
  $clean['outils_informatiques'] = implode(',', $clean['outils_informatiques']);
  if($clean['autres_outils'] != '') {
    $clean['outils_informatiques'] .= ','.$clean['autres_outils'];
  }
  
  if(!isset($clean['possede_auto'])) {
    $clean['possede_auto'] = '0';
  } else {
    $clean['possede_auto'] = '1';
  }
  
  $dispo_jour = $dispo_soir = $dispo_nuit = '';
  $jours = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
  foreach($jours as $jour) {
    if(in_array($jour, $clean['dispo_jour'])) {
      $dispo_jour .= '1';
    } else {
      $dispo_jour .= '0';
    }
    if(in_array($jour, $clean['dispo_soir'])) {
      $dispo_soir .= '1';
    } else {
      $dispo_soir .= '0';
    }
    if(in_array($jour, $clean['dispo_nuit'])) {
      $dispo_nuit .= '1';
    } else {
      $dispo_nuit .= '0';
    }
  }
  
  if(count($erreur) < 1) {
     // ajout de la demande...
     $data = array(
      'nom'=>$clean['nom'],
      'adresse'=>$clean['adresse'],
      'telephone'=>$clean['telephone'],
      'cellulaire'=>$clean['cellulaire'],
      'courriel'=>$clean['courriel'],
      'langues_parlees'=>$clean['langue'],
      'emplois_recherches'=>$clean['emplois_recherches'],
      'nb_heures_recherchees'=>$clean['nb_heures_recherchees'],
      'salaire_horaire_desire'=>$clean['salaire_horaire_desire'],
      'regions_disponibles'=>$clean['regions_disponibles'],
      'date_debut'=>$clean['date_debut'],
      'outils_informatiques'=>$clean['outils_informatiques'],
      'possede_auto'=>$clean['possede_auto'],
      'references'=>$clean['references'],
      'dispo_jour'=>$dispo_jour,
      'dispo_soir'=>$dispo_soir,
      'dispo_nuit'=>$dispo_nuit
     );
     
     $demande = new Demande();
     $id = (int)$demande->add($data);
     
                   
     $clean['nom'] = $clean['adresse'] = $clean['telephone'] = $clean['cellulaire'] = $clean['courriel'] = $clean['langue'] = $clean['autres_langues'] = $clean['fichier_cv'] = $clean['emplois_recherches'] = $clean['nb_heures_recherchees'] = $clean['salaire_horaire_desire'] = $clean['regions_disponibles'] = $clean['date_debut'] = $clean['dispo_jour'] = $clean['dispo_soir'] = $clean['dispo_nuit'] = $clean['outils_informatiques'] = $clean['autres_outils'] = $clean['possede_auto'] = $clean['references'] = '';
      
     $message = 'Votre demande d\'emploi a été complétée.';

  }
  
else :

  $clean['nom'] = $clean['adresse'] = $clean['telephone'] = $clean['cellulaire'] = $clean['courriel'] = $clean['langue'] = $clean['autres_langues'] = $clean['fichier_cv'] = $clean['emplois_recherches'] = $clean['nb_heures_recherchees'] = $clean['salaire_horaire_desire'] = $clean['regions_disponibles'] = $clean['date_debut'] = $clean['dispo_jour'] = $clean['dispo_soir'] = $clean['dispo_nuit'] = $clean['outils_informatiques'] = $clean['autres_outils'] = $clean['possede_auto'] = $clean['references'] = '';

endif;
?>
    <?php
    if($message!='') {
      echo '<p class="message">'.$message.'</p>';
    }
    if(count($erreur) > 0) {
      foreach($erreur as $err) {
        echo '<p class="message-err">'.$err.'</p>';
      }
    }
    ?>
    
    <form method="post" action="" enctype="multipart/form-data">
      
      <fieldset id="informations_personnelles" class="">
        <legend>Informations personnelles</legend>
        
        <ul>
          <li>
            <label for="nom">Nom <span>*</span></label><br />
            <input type="text" name="nom" value="<?php echo $clean['nom'] ?>" id="nom" />
          </li>
          <li>
            <label for="adresse">Adresse <span>*</span></label><br />
            <input type="text" name="adresse" value="<?php echo $clean['adresse'] ?>" id="adresse" />
          </li>
          <li>
            <label for="telephone">Téléphone <span>*</span></label><br />
            <input type="text" name="telephone" value="<?php echo $clean['telephone'] ?>" id="telephone" />
          </li>
          <li>
            <label for="cellulaire">Cellulaire</label><br />
            <input type="text" name="cellulaire" value="<?php echo $clean['cellulaire'] ?>" id="cellulaire" />
          </li>
          <li>
            <label for="courriel">Courriel <span>*</span></label><br />
            <input type="text" name="courriel" value="<?php echo $clean['courriel'] ?>" id="courriel" />
          </li>
          <li>
            <label for="langues">Langues <span>*</span></label><br />
            <input type="checkbox" name="langue[]" value="francais" id="langue_francais" />
            <label for="langue_francais">Français</label><br />
            <input type="checkbox" name="langue[]" value="anglais" id="langue_anglais" />
            <label for="langue_anglais">Anglais</label><br />
          </li>
          <li>
            <label for="autres_langues">Autres langues (séparées par une virgule)</label><br />
            <input type="text" name="autres_langues" value="<?php echo $clean['autres_langues'] ?>" id="autres_langues" />
          </li>
          <li>
            <label for="fichier_cv">Curriculum Vitae (CV) <span>*</span></label><br />
            <input type="file" name="fichier_cv" value="" id="fichier_cv" />
          </li>          
        </ul>

      </fieldset>
      
      <fieldset id="informations_relatives_a_emploi" class="">
        <legend>Informations relatives à l'emploi</legend>
        <ul>
          <li>
            <label for="emplois_recherches">Travail recherché <span>*</span></label><br />
            <textarea name="emplois_recherches" id="emplois_recherches"><?php echo $clean['emplois_recherches'] ?></textarea>
          </li>
          <li>
            <label for="nb_heures_recherchees">Nombre d'heures de travail désiré (par semaine) <span>*</span></label><br />
            <input type="text" name="nb_heures_recherchees" value="<?php echo $clean['nb_heures_recherchees'] ?>" id="nb_heures_recherchees" />
          </li>
          <li>
            <label for="salaire_horaire_desire">Salaire horaire attendu <span>*</span></label><br />
            <input type="text" name="salaire_horaire_desire" value="<?php echo $clean['salaire_horaire_desire'] ?>" id="salaire_horaire_desire" />
          </li>
          <li>
            <label for="regions_disponibles">Régions disponibles</label><br />
            <textarea name="regions_disponibles" id="regions_disponibles"><?php echo $clean['regions_disponibles'] ?></textarea>
          </li>

        </ul>

      </fieldset>
            
      <fieldset id="disponibilites" class="">
        <legend>Disponibilités</legend>
        <ul>
          <li>
            <label for="date_debut">Date de début <span>*</span></label><br />
            <input type="text" name="date_debut" value="<?php echo $clean['date_debut'] ?>" id="date_debut" />
          </li>
          <li>
            <table>
              <tr>
                <th>&nbsp;</th>
                <th>Lundi</th>
                <th>Mardi</th>
                <th>Mercredi</th>
                <th>Jeudi</th>
                <th>Vendredi</th>
                <th>Samedi</th>
                <th>Dimanche</th>
              </tr>
              <tr>
                <th>Jour</th>
                <td><input type="checkbox" name="dispo_jour[]" id="dispo_jour_Lundi" value="Lundi" /></td>
                <td><input type="checkbox" name="dispo_jour[]" id="dispo_jour_Mardi" value="Mardi" /></td>
                <td><input type="checkbox" name="dispo_jour[]" id="dispo_jour_Mercredi" value="Mercredi" /></td>
                <td><input type="checkbox" name="dispo_jour[]" id="dispo_jour_Jeudi" value="Jeudi" /></td>
                <td><input type="checkbox" name="dispo_jour[]" id="dispo_jour_Vendredi" value="Vendredi" /></td>
                <td><input type="checkbox" name="dispo_jour[]" id="dispo_jour_Samedi" value="Samedi" /></td>
                <td><input type="checkbox" name="dispo_jour[]" id="dispo_jour_Dimanche" value="Dimanche" /></td>
              </tr>
              <tr>
                <th>Soir</th>
                <td><input type="checkbox" name="dispo_soir[]" id="dispo_soir_Lundi" value="Lundi" /></td>
                <td><input type="checkbox" name="dispo_soir[]" id="dispo_soir_Mardi" value="Mardi" /></td>
                <td><input type="checkbox" name="dispo_soir[]" id="dispo_soir_Mercredi" value="Mercredi" /></td>
                <td><input type="checkbox" name="dispo_soir[]" id="dispo_soir_Jeudi" value="Jeudi" /></td>
                <td><input type="checkbox" name="dispo_soir[]" id="dispo_soir_Vendredi" value="Vendredi" /></td>
                <td><input type="checkbox" name="dispo_soir[]" id="dispo_soir_Samedi" value="Samedi" /></td>
                <td><input type="checkbox" name="dispo_soir[]" id="dispo_soir_Dimanche" value="Dimanche" /></td>
              </tr>
              <tr>
                <th>Nuit</th>
                <td><input type="checkbox" name="dispo_nuit[]" id="dispo_nuit_Lundi" value="Lundi" /></td>
                <td><input type="checkbox" name="dispo_nuit[]" id="dispo_nuit_Mardi" value="Mardi" /></td>
                <td><input type="checkbox" name="dispo_nuit[]" id="dispo_nuit_Mercredi" value="Mercredi" /></td>
                <td><input type="checkbox" name="dispo_nuit[]" id="dispo_nuit_Jeudi" value="Jeudi" /></td>
                <td><input type="checkbox" name="dispo_nuit[]" id="dispo_nuit_Vendredi" value="Vendredi" /></td>
                <td><input type="checkbox" name="dispo_nuit[]" id="dispo_nuit_Samedi" value="Samedi" /></td>
                <td><input type="checkbox" name="dispo_nuit[]" id="dispo_nuit_Dimanche" value="Dimanche" /></td>
              </tr>
            </table>
          </li>
        </ul>
        
      </fieldset>
      
      <fieldset id="outils_informatiques" class="">
        <legend>Outils informatiques</legend>
        <ul>
          <li>
            <input type="checkbox" name="outils_informatiques[]" value="suite_office" id="suite_office" />
            <label for="suite_office">Suite Microsoft Office</label><br />
          </li>
          <li>
            <label for="autres_outils">Autres</label><br />
            <input type="text" name="autres_outils" value="<?php echo $clean['autres_outils'] ?>" id="autres_outils" />
          </li>

        </ul>
        
      </fieldset>
      
      <fieldset id="autres_informations" class="">
        <legend>Autres informations</legend>
        <ul>
          <li>
            <input type="checkbox" name="possede_auto[]" value="possede_auto" id="possede_auto" />
            <label for="possede_auto">Possède une auto</label><br />
          </li>
          <li>
            <label for="references">Références</label><br />
            <textarea name="references" id="references"><?php echo $clean['references'] ?></textarea>
          </li>

        </ul>
        
      </fieldset>
      
      <fieldset id="envoyer" class="">
        
        <input type="submit" name="envoyer" value="Postuler" id="envoyer" class="" />
        
      </fieldset>
      
    </form>


 
<script>

	$(document).ready(function() {
		$( "#date_debut" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});

</script>
  <?php
}
  
} // end function_exists
*/
?>