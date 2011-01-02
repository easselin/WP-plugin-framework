<?php

function pc_counter_css() { 
  
	$css_path = dirname(__FILE__).'/../css/pc.css';
	$css_url = WP_PLUGIN_URL.'/phone-counter/css/pc.css';

	if (file_exists($css_path)){
	  
	  $handle = 'pc-counter-stylesheet';

		wp_register_style($handle, $css_url);
		wp_enqueue_style($handle);
		wp_print_styles();
	}

}

add_action('wp_head','pc_counter_css');

?>