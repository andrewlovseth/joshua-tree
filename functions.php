<?php

require_once( plugin_dir_path( __FILE__ ) . '/functions/theme-support.php');

require_once( plugin_dir_path( __FILE__ ) . '/functions/enqueue-styles-scripts.php');

require_once( plugin_dir_path( __FILE__ ) . '/functions/acf.php');

require_once( plugin_dir_path( __FILE__ ) . '/functions/register-blocks.php');

require_once( plugin_dir_path( __FILE__ ) . '/functions/disable-gutenberg-editor.php');

require_once( plugin_dir_path( __FILE__ ) . '/functions/svg.php');

require_once( plugin_dir_path( __FILE__ ) . '/functions/ajax-load-more.php');

function curl_error_60_workaround( $handle, $r, $url ) {

    // Disable peer verification to temporarily resolve error 60.
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

}

add_action( 'http_api_curl', 'curl_error_60_workaround', 10, 3 );