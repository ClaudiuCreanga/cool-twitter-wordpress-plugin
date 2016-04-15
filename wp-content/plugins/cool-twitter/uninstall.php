<?php
	
	// If uninstall is not called from WordPress, exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	    exit();
	}
	 
	$option_name = 'cool_twitter';
	 
	delete_option( $option_name );