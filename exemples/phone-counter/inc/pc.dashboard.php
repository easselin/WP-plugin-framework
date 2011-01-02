<?php

function pc_dashboard_widget_function() {

	echo '
	  <style>
	    #pc_dashboard_widget .t {
        color:#777777;
        font-size:12px;
        padding-right:12px;
        padding-top:6px;
      }
      #pc_dashboard_widget td.b {
        font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
        font-size:14px;
        padding-right:6px;
        text-align:right;
        width:1%;
      }
      #pc_dashboard_widget table td {
        padding:3px 0;
        white-space:nowrap;
      }
    </style>
	  <div class="table table_content">
	    <table>
	      <tbody>';

  $counter = new Counter();
  $counters = $counter->getCollectionCount(array('orderField'=>'total', 'sort'=>'DESC', 'groupByField'=>'url'));

  foreach($counters as $row) {
    echo '<tr class="first"><td class="first b b-posts">';
    echo '<a href="'.$row->url.'">'.$row->total.'</a></td>';
    echo '<td class="t posts"><a href="'.$row->url.'">'.$row->url.'</a></td></tr>';
  }

  echo	'</tbody></table></div>';

}

function pc_dashboard_settings_function() {
  
  if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['pc_hidden_phone_number']) ) {
    $hiddenPhoneNumber = stripslashes($_POST['pc_hidden_phone_number']);
    update_option( 'pc_hidden_phone_number', $hiddenPhoneNumber );
  }

  if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['pc_real_phone_number']) ) {
    $realPhoneNumber = stripslashes($_POST['pc_real_phone_number']);
    update_option( 'pc_real_phone_number', $realPhoneNumber );
  }
  
  $hiddenPhoneNumber = get_option('pc_hidden_phone_number');
  $realPhoneNumber = get_option('pc_real_phone_number');;
  echo '<table><tr><td style="width:50%;padding-right:30px;">';
  echo '<p><label for="hidden-phone-number">' . __('Hidden Phone Number: ') . '</label>';
  echo '<input id="hidden-phone-number" name="pc_hidden_phone_number" type="text" value="' . $hiddenPhoneNumber . '" size="15" /></p>';
  echo '</td><td>';
  echo '<p><label for="real-phone-number">' . __('Real Phone Number: ') . '</label>';
  echo '<input id="real-phone-number" name="pc_real_phone_number" type="text" value="' . $realPhoneNumber . '" size="15" /></p>';
  echo '</td></tr></table>';
}

// Create the function use in the action hook
function pc_add_dashboard_widgets() {
	wp_add_dashboard_widget('pc_dashboard_widget', 'Phone Counter Statistics', 'pc_dashboard_widget_function', 'pc_dashboard_settings_function');
}
// Hook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'pc_add_dashboard_widgets' );

?>