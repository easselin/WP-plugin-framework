<?php

class Counter extends businessObject {
  
  public function __construct() {
    parent::__construct();
    $this->setObjectTable();
  }

  protected function setObjectTable() {
    $this->obj_table = $this->dbase->prefix."pc_stats";
  }
  
  public function __destruct() {}
   
}

function show_counter($str="pc-counter-tel1") {

  $counter = new Counter();
  echo '
    <script type="text/javascript">
      document.write(\'<div class="pc-counter" id="'.$str.'">'.get_option('pc_hidden_phone_number').'</div>\');
    </script>
    <noscript><div class="pc-counter" id="'.$str.'">'.get_option('pc_real_phone_number').'</div></noscript>
  ';
  
}

?>