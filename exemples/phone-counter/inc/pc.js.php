<?php

function pc_counter_js() {

  $nonce = wp_create_nonce( 'pc' );

  $link = get_bloginfo('url');
  echo "
    <script type=\"text/javascript\">
    $('.pc-counter').click(function() {
      sender = $(this);
      senderId = this.id;
    	$.ajax({
    	  type: 'POST',
    	  url: '{$link}/wp-admin/admin-ajax.php',
    	  data: { action: 'pcupdate', _ajax_nonce: '{$nonce}', url:'{$_SERVER["REQUEST_URI"]}#'+senderId },
    	  dataType: 'html',
    	  success: function(html, textStatus) {
    	    sender.html(html);
    	  },
    	  error: function(xhr, textStatus, errorThrown) {
    	    alert(errorThrown);
    	  }
    	});
    });
    </script>
  ";
}

add_action('wp_footer','pc_counter_js');

function pc_update() {
  check_ajax_referer( "pc" );
  
  $counter = new Counter();
  $counter->add(array('url'=>$_POST["url"], 'ip_addr'=>$_SERVER["HTTP_HOST"]));

  echo get_option('pc_real_phone_number');
  die();
}

add_action( 'wp_ajax_pcupdate', 'pc_update' );
add_action('wp_ajax_nopriv_pcupdate', 'pc_update');



?>
