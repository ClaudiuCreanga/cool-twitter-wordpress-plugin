<?php
	
namespace Shortcodes;

class Shortcode
{
	public function __construct()
	{
	    add_action('init',array($this,'add_shortcode'));
	}
    public function shortcode()
    {
	    return "Hello Dolly";
    }
    public function add_shortcode()
    {
	    add_shortcode('cool_twitter', array($this,'shortcode'));
    }
}

$shortcode = new Shortcode;