<?php

if( !defined('__BUSINESSEXTENDEDOBJECT') ) {
  define( '__BUSINESSEXTENDEDOBJECT' , 1 );

abstract class businessExtendedObject {
  
  protected $obj_table;
  protected $dbase;
  protected $extended_object;
  protected $joinField;
  protected $tbStructArray;
  protected $extTbStructArray;
  
  public function __construct() {
    global $wpdb;
    $this->dbase = $wpdb;
    $this->tbStructArray = array();
    $this->extTbStructArray = array();
  }
  
  public function getById($id) {    
    $id = (int)$id;
    return $this->dbase->get_row(
        "SELECT {$this->obj_table}.*, {$this->extended_object->getObjectTable()}.*
        FROM {$this->obj_table}, {$this->extended_object->getObjectTable()}
        WHERE {$this->extended_object->getObjectTable()}.id = {$id}
        AND {$this->obj_table}.{$this->joinField} = {$this->extended_object->getObjectTable()}.id");
  }
      
  public function getCollection($params=null) {
    
    $params = (array)$params;
    $limit = (array_key_exists('limit', $params)) ? $params['limit'] : 20;
    $offset = (array_key_exists('offset', $params)) ? $params['offset'] : 0;
    $whereClause = (array_key_exists('whereClause', $params)) ? $params['whereClause'] : '';
    $orderField = (array_key_exists('orderField', $params)) ? $params['orderField'] : $this->obj_table.'.id';
    $sort = (array_key_exists('sort', $params)) ? $params['sort'] : 'ASC';
    
    if($whereClause != '') {
      if(is_array($whereClause)) {
        $tmpClause = $whereClause;
        $whereClause = '';
        foreach($tmpClause as $wc) {
          $whereClause .= ' AND '.$wc;
        }
      } else {
        $whereClause = ' AND '.$whereClause;
      }
    }
    
    if($orderField != '') {
      $orderField = 'ORDER BY '.$orderField.' '.$sort;
    }
    
    return $this->dbase->get_results(
        "SELECT {$this->obj_table}.*, {$this->extended_object->getObjectTable()}.*
        FROM {$this->obj_table}, {$this->extended_object->getObjectTable()}
        WHERE {$this->obj_table}.{$this->joinField} = {$this->extended_object->getObjectTable()}.id
        {$whereClause}
        {$orderField}
        LIMIT {$offset}, {$limit}");
    
  }
  
  public function getCollectionCount($params=null) {

    $params = (array)$params;
    $limit = (array_key_exists('limit', $params)) ? $params['limit'] : 20;
    $offset = (array_key_exists('offset', $params)) ? $params['offset'] : 0;
    $whereClause = (array_key_exists('whereClause', $params)) ? $params['whereClause'] : '';
    $orderField = (array_key_exists('orderField', $params)) ? $params['orderField'] : $this->obj_table.'.id';
    $sort = (array_key_exists('sort', $params)) ? $params['sort'] : 'ASC';
    $countField = (array_key_exists('countField', $params)) ? $params['countField'] : $this->extended_object->getObjectTable().'.id';
    $groupByField = (array_key_exists('groupByField', $params)) ? $params['groupByField'] : '';
    
    if($whereClause != '') {
      $whereClause = 'AND '.$whereClause;
    }
    
    if($orderField != '') {
      if($orderField == 'total') {
        $orderField = 'ORDER BY '.$orderField.' '.$sort;
      } else {
        $orderField = 'ORDER BY '.$orderField.' '.$sort;
      }
      
    }

    if($groupByField != '') {
      $groupByField = 'GROUP BY '.$this->obj_table.'.'.$groupByField;
    }
        
    return $this->dbase->get_results(
        "SELECT count({$countField}) as total, {$this->obj_table}.*, {$this->extended_object->getObjectTable()}.*
        FROM {$this->obj_table}, {$this->extended_object->getObjectTable()}
        WHERE {$this->obj_table}.{$this->joinField} = {$this->extended_object->getObjectTable()}.id
        {$whereClause}
        {$groupByField}
        {$orderField}
        LIMIT {$offset}, {$limit}");
    
  }
  
  public function add($params) {
    if(empty($this->tbStructArray) || empty($this->extTbStructArray)) {
      $this->setTableStructArray();
    }
    
    $params = (array)$params;
    $splitParams = $this->splitParams($params);
    
    $extId = $this->extended_object->add($splitParams[1]);
    
    if($extId != null && $extId > 0) {
      $splitParams[0][$this->joinField] = $extId;
      $this->dbase->insert($this->obj_table,$splitParams[0]);
      if($this->dbase->insert_id != null && $this->dbase->insert_id > 0) {
        return $extId;
      } else {
        // Todo: rollback de la première insertion
        return 0;
      }
    } else {
      return 0;
    }
    
  }
  
  public function update($id, $params) {
    if(empty($this->tbStructArray) || empty($this->extTbStructArray)) {
      $this->setTableStructArray();
    }
    
    $params = (array)$params;
    $splitParams = $this->splitParams($params);
    
    $id = (int)$id;
    
    if(!empty($splitParams[1])) {
      $state = $this->extended_object->update($id, $splitParams[1]);
    }
    
    if(!empty($splitParams[0])) {
      $state = $this->dbase->update($this->obj_table, $splitParams[0], array($this->joinField=>$id));
    }
    
    // pas vraiment pertinent dans le contexte...
    return $state;
  }
  
  public function delete($id=0) {
    $id = (int)$id;
    $state = $this->dbase->query("DELETE FROM {$this->extended_object->getObjectTable()} WHERE id = '{$id}'");
    $state = $this->dbase->query("DELETE FROM {$this->obj_table} WHERE {$this->joinField} = '{$id}'");
    
    // pas vraiment pertinent dans le contexte...
    return $state;
  }
  
  public function getObjectTable() {
    return $this->obj_table;
  }
  
  private function setTableStructArray() {

    $fields = $this->dbase->get_results("DESCRIBE {$this->obj_table}");
    foreach($fields as $field) {
      array_push($this->tbStructArray, $field->Field);
    }

    $fields = $this->dbase->get_results("DESCRIBE {$this->extended_object->getObjectTable()}");
    foreach($fields as $field) {
      array_push($this->extTbStructArray, $field->Field);
    }
    
    unset($fields);

  }
  
  private function splitParams($params) {
    $tmpArray = array();
    foreach($params as $param) {
      if(in_array(key($params), $this->tbStructArray)) {
        $tmpArray[0][key($params)] = $param;
      }
      if(in_array(key($params), $this->extTbStructArray)) {
        $tmpArray[1][key($params)] = $param;
      }      
      next($params);
    }
    return $tmpArray;
  }
  
  abstract protected function setObjectTable();
  
  abstract protected function setExtendedObject();
  
  abstract protected function setJoinField();
  
  public function __destruct() {}
  
  
}

} // end define test

?>