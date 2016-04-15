<?php
	
	function cool_twitter_shortcode() {
    return "Hello Dolly";
}
 
function cool_twitter_register_shortcode() {
    add_shortcode( 'cool_twitter', 'cool_twitter_shortcode' );
}
 
add_action( 'init', 'cool_twitter_register_shortcode' );