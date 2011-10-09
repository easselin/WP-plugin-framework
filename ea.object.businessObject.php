<?php

if( !defined('__BUSINESSOBJECT') ) {
  define( '__BUSINESSOBJECT' , 1 );

abstract class businessObject {
  
  protected static $obj_table;
  protected static $dbase;
  
  public function __construct() {
    global $wpdb;
    $this->dbase = $wpdb;
  }
  
  public static function getById($id) {
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
    $orderField = (array_key_exists('orderField', $params)) ? $params['orderField'] : 'id';
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
    $orderField = (array_key_exists('orderField', $params)) ? $params['orderField'] : 'id';
    $sort = (array_key_exists('sort', $params)) ? $params['sort'] : 'ASC';
    $countField = (array_key_exists('countField', $params)) ? $params['countField'] : 'id';
    $groupByField = (array_key_exists('groupByField', $params)) ? $params['groupByField'] : '';
    
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
    return $this->dbase->get_var("SELECT LAST_INSERT_ID()");
    
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
  
  public static function getListOptions($field) {
    $class = get_called_class();
    $obj = new $class();    
    $objects = $obj->getCollection(array('limit'=>9999, 'orderField'=>$field));
    $list = array();
    foreach($objects as $row) {
      $list[$row->id] = $row->$field;
    }
    return $list;
  }

  public function __destruct() {}
  
  
}

} // end define test

?>

<?php 

/******************************** 
 * Retro-support of get_called_class() 
 * Tested and works in PHP 5.2.4 
 * http://www.sol1.com.au/ 
 ********************************/ 
if(!function_exists('get_called_class')) { 
function get_called_class($bt = false,$l = 1) { 
    if (!$bt) $bt = debug_backtrace(); 
    if (!isset($bt[$l])) throw new Exception("Cannot find called class -> stack level too deep."); 
    if (!isset($bt[$l]['type'])) { 
        throw new Exception ('type not set'); 
    } 
    else switch ($bt[$l]['type']) { 
        case '::': 
            $lines = file($bt[$l]['file']); 
            $i = 0; 
            $callerLine = ''; 
            do { 
                $i++; 
                $callerLine = $lines[$bt[$l]['line']-$i] . $callerLine; 
            } while (stripos($callerLine,$bt[$l]['function']) === false); 
            preg_match('/([a-zA-Z0-9\_]+)::'.$bt[$l]['function'].'/', 
                        $callerLine, 
                        $matches); 
            if (!isset($matches[1])) { 
                // must be an edge case. 
                throw new Exception ("Could not find caller class: originating method call is obscured."); 
            } 
            switch ($matches[1]) { 
                case 'self': 
                case 'parent': 
                    return get_called_class($bt,$l+1); 
                default: 
                    return $matches[1]; 
            } 
            // won't get here. 
        case '->': switch ($bt[$l]['function']) { 
                case '__get': 
                    // edge case -> get class of calling object 
                    if (!is_object($bt[$l]['object'])) throw new Exception ("Edge case fail. __get called on non object."); 
                    return get_class($bt[$l]['object']); 
                default: return $bt[$l]['class']; 
            } 

        default: throw new Exception ("Unknown backtrace method type"); 
    } 
} 
} 
?>
