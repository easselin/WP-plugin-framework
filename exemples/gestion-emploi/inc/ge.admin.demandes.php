<?php

class DemandeAdmin extends adminBOPage {
  
  public function __construct() {
    $params = array(
      'parentMenu'=>'demandeMenu',
      'pageTitle'=>'Gestion des demandes d\'emplois',
      'menuTitle'=>'Demandes d\'emplois',
      'capability'=>'use_ge',
      'menuId'=>'demandes');
      
    parent::__construct($params);
    
    $this->setBusinessObject();
    $this->setListableField();
    $this->setAdminForm();
    
  }
  
  protected function setBusinessObject() {
    $this->businessObject = new Demande();
  }
  
  protected function setListableField() {
    $this->listableField = array(
      'id'=>'ID',
      'nom'=>'Nom',
      'telephone'=>'Téléphone',
      'courriel'=>'Courriel');
  }

  protected function setAdminForm() {
    
    $this->adminForm = new AdminForm('Ajout ou édition d\'une demande d\'emploi');
    
    /* Informations générales */
    $fsInfos = new Fieldset(array('title'=>'Informations générales', 'layout'=>2));
    
    $fsInfos->addField(new Textfield(array(
      'label'=>'Nom',
      'name'=>'nom')));
    
    $fsInfos->addField(new Textfield(array(
      'label'=>'Adresse',
      'name'=>'adresse')));
      
    $fsInfos->addField(new Textfield(array(
      'label'=>'Téléphone',
      'name'=>'telephone')));
    
    $fsInfos->addField(new Textfield(array(
      'label'=>'Cellulaire',
      'name'=>'cellulaire')));
      
    $fsInfos->addField(new Textfield(array(
      'label'=>'Courriel',
      'name'=>'courriel')));
    
    $fsInfos->addField(new Filefield(array(
      'label'=>'Fichier CV',
      'name'=>'fichier_cv')));
      
    $fsInfos->addField(new Textarea(array(
      'label'=>'Langues parlées',
      'name'=>'langues_parlees')));
      
    $this->adminForm->addFieldset($fsInfos);
    
    /* Informations sur les emplois */
    $fsEmplois = new Fieldset(array('title'=>'Informations sur les emplois', 'layout'=>2));
    
    $fsEmplois->addField(new Textarea(array(
      'label'=>'Emplois recherchés',
      'name'=>'emplois_recherches')));
      
    $fsEmplois->addField(new Textarea(array(
      'label'=>'Régions disponibles',
      'name'=>'regions_disponibles')));

    $fsEmplois->addField(new Textfield(array(
      'label'=>'Années expériences',
      'name'=>'annees_experiences')));
      
    $fsEmplois->addField(new Textfield(array(
      'label'=>'Nb d\'heures recherchées',
      'name'=>'nb_heures_recherchees')));
      
    $fsEmplois->addField(new Textfield(array(
      'label'=>'Salaire horaire désiré',
      'name'=>'salaire_horaire_desire')));
      
    $fsEmplois->addField(new Checkbox(array(
      'label'=>'Possède auto',
      'name'=>'possede_auto',
      'group'=>array('Possède auto'))));
      
    $this->adminForm->addFieldset($fsEmplois);
    
    /* Informations sur les disponibilités */
    $fsDispos = new Fieldset(array('title'=>'Informations sur les disponibilités', 'layout'=>1));
    
    $fsDispos->addField(new Textfield(array(
      'label'=>'Date de début',
      'name'=>'date_debut')));

    $fsDispos->addField(new Checkbox(array(
      'label'=>'Jour',
      'title'=>true,
      'name'=>'dispo_jour',
      'group'=>array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'))));
    
    $fsDispos->addField(new Checkbox(array(
      'label'=>'Soir',
      'title'=>true,
      'name'=>'dispo_soir',
      'group'=>array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'))));
    
    $fsDispos->addField(new Checkbox(array(
      'label'=>'Nuit',
      'title'=>true,
      'name'=>'dispo_nuit',
      'group'=>array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'))));
    
    $this->adminForm->addFieldset($fsDispos);

    /* Autres informations */
    $fsAutres = new Fieldset(array('title'=>'Autres informations', 'layout'=>3));

    $fsAutres->addField(new Textarea(array(
      'label'=>'Outils informatiques',
      'name'=>'outils_informatiques')));

    $fsAutres->addField(new Textarea(array(
      'label'=>'Références',
      'name'=>'ge_references')));

    $fsAutres->addField(new Textarea(array(
      'label'=>'Notes',
      'name'=>'note')));
          
    $this->adminForm->addFieldset($fsAutres);
    
  }

  public function __destruct() {}

}

?>