<?php 
    /*
    Plugin Name: Cool Twitter 
    Plugin URI: https://github.com/ClaudiuCreanga/cool-twitter-wordpress-plugin
    Description: Cool Simple Twitter Plugin for showing your tweets on your blog
    Author: Claudiu Creanga
    Version: 1.0
    Author URI: http://claudiucreanga.me
    */
?>
<?php
	// make sure the plugin does not expose any info if called directly
	if ( ! function_exists( 'add_action' ) ) {
		if ( ! headers_sent() ) {
			if ( function_exists( 'http_response_code' ) ) {
				http_response_code( 403 );
			} else {
				header( 'HTTP/1.1 403 Forbidden', true, 403 );
			}
		}
		exit( 'Hi there! I am a WordPress plugin requiring functions included with WordPress. I am not meant to be addressed directly.' );
	}
	
	require_once(dirname( __FILE__ ) . '/options.php');
	//require_once(dirname( __FILE__ ) . '/feed.php');
	require_once(dirname( __FILE__ ) . '/shortcode.php');