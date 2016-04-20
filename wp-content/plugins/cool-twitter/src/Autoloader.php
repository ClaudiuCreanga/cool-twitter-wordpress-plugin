<?php

/**
 * Autoloads MyPlugin classes using PSR-0 standard.
 */
 
class CoolTwitter_Autoloader
{
	/**
     * Registers CoolTwitter_Autoloader as an SPL autoloader.
     *
     * @param boolean $prepend
     */
	public static function register($prepend = false)
    {
        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array(new self, 'autoload'), true, $prepend);
        } else {
            spl_autoload_register(array(new self, 'autoload'));
        }
    }
 
    /**
     * Handles autoloading of CoolTwitter classes.
     *
     * @param string $class
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'CoolTwitter')) {
            return;
        }
        if (is_file($file = dirname(__FILE__).'/'.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            require_once $file;
        }
    }    
}