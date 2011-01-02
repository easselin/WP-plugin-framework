<?php

if( !defined('__BUSINESSOBJECT') ) {
  define( '__BUSINESSOBJECT' , 1 );

abstract class businessObject {
  
  protected $obj_table;
  protected $dbase;
  
  public function __construct() {
    global $wpdb;
    $this->dbase = $wpdb;
  }
  
  public function getById($id) {
    $id = (int)$id;
    return $this->dbase->get_row("SELECT {$this->obj_table}.*
                        FROM {$this->obj_table}
                        WHERE {$this->obj_table}.id = {$id}");
  }
      
  public function getCollection($params=null) {
    
    $params = (array)$params;
    $limit = (array_key_exists('limit', $params)) ? $params['limit'] : 20;
    $offset = (array_key_exists('offset', $params)) ? $params['offset'] : 0;
    $whereClause = (array_key_exists('whereClause', $params)) ? $params['whereClause'] : '';
    $orderField = (array_key_exists('orderField', $params)) ? $params['orderField'] : '';
    $sort = (array_key_exists('sort', $params)) ? $params['sort'] : 'ASC';
    
    if($whereClause != '') {
      $whereClause = 'AND '.$whereClause;
    }
    
    if($orderField != '') {
      $orderField = 'ORDER BY '.$this->obj_table.'.'.$orderField.' '.$sort;
    }
    
    return $this->dbase->get_results("SELECT {$this->obj_table}.*
                        FROM {$this->obj_table}
                        WHERE 1 = 1
                        {$whereClause}
                        {$orderField}
                        LIMIT {$offset}, {$limit}");
    
  }
  
  public function getCollectionCount($params=null) {

    $params = (array)$params;
    $limit = (array_key_exists('limit', $params)) ? $params['limit'] : 20;
    $offset = (array_key_exists('offset', $params)) ? $params['offset'] : 0;
    $whereClause = (array_key_exists('whereClause', $params)) ? $params['whereClause'] : '';
    $orderField = (array_key_exists('orderField', $params)) ? $params['orderField'] : '';
    $sort = (array_key_exists('sort', $params)) ? $params['sort'] : 'ASC';
    $countField = (array_key_exists('countField', $params)) ? $params['countField'] : 'id';
    $groupByField = (array_key_exists('groupByField', $params)) ? $params['groupByField'] : '';
    
    if($whereClause != '') {
      $whereClause = 'AND '.$whereClause;
    }
    
    if($orderField != '') {
      if($orderField == 'total') {
        $orderField = 'ORDER BY '.$orderField.' '.$sort;
      } else {
        $orderField = 'ORDER BY '.$this->obj_table.'.'.$orderField.' '.$sort;
      }
      
    }

    if($groupByField != '') {
      $groupByField = 'GROUP BY '.$this->obj_table.'.'.$groupByField;
    }
        
    return $this->dbase->get_results("SELECT count({$countField}) as total, {$this->obj_table}.*
                        FROM {$this->obj_table}
                        WHERE 1 = 1
                        {$whereClause}
                        {$groupByField}
                        {$orderField}
                        LIMIT {$offset}, {$limit}");
    
  }
  
  public function add($params) {
    
    $params = (array)$params;
    $this->dbase->insert($this->obj_table,$params);
    return $this->dbase->insert_id;
    
  }
  
  public function update($id, $params) {
    $id = (int)$id;
    $state = $this->dbase->update($this->obj_table, $params, array('id'=>$id));
    return $state;
  }
  
  public function delete($id) {
    $id = (int)$id;
    $state = $this->dbase->query("DELETE FROM {$this->obj_table} WHERE id = '{$id}'");
    return $state;
  }
  
  public function getObjectTable() {
    return $this->obj_table;
  }
  
  abstract protected function setObjectTable();
  
  public function __destruct() {}
  
  
}

} // end define test


?>