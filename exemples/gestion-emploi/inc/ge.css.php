<?php

function ge_css() { 
  
	$css_path = dirname(__FILE__).'/../css/ge.css';
	$css_url = WP_PLUGIN_URL.'/gestion-emploi/css/ge.css';

	if (file_exists($css_path)){
	  
	  $handle = 'ge-stylesheet';

		wp_register_style($handle, $css_url);
		wp_enqueue_style($handle);
		wp_print_styles();
	}

	$css_path = dirname(__FILE__).'/../css/jquery-ui-1.8.7.custom.css';
	$css_url = WP_PLUGIN_URL.'/gestion-emploi/css/jquery-ui-1.8.7.custom.css';

	if (file_exists($css_path)){
	  
	  $handle = 'ge-ui-stylesheet';

		wp_register_style($handle, $css_url);
		wp_enqueue_style($handle);
		wp_print_styles();
	}

}

add_action('wp_head','ge_css');

?>