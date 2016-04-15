<?php 
    /*
    Plugin Name: Cool Simple Twitter Plugin 
    Plugin URI: https://github.com/ClaudiuCreanga/cool-twitter-wordpress-plugin
    Description: Plugin for showing your tweets on your blog
    Author: Claudiu Creanga
    Version: 1.0
    Author URI: http://claudiucreanga.me
    */
?>
<?php
class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_menu_page(
            'Twitter', 
            'Twitter', 
            'administrator', 
            'twitter_settings', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'twitter' );
        ?>
        <div class="wrap">
            <h2>Twitter Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'twitter_group' );   
                do_settings_sections( 'twitter-settings-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'twitter_group', // Option group
            'twitter', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'main_section', // ID
            'Connection Details', // Title
            array( $this, 'print_section_info' ), // Callback
            'twitter-settings-admin' // Page
        );  

        add_settings_field(
            'oauth_access_token', // ID
            'Oauth access token', // Title 
            array( $this, 'oauth_access_token_callback' ), // Callback
            'twitter-settings-admin', // Page
            'main_section' // Section           
        );      

        add_settings_field(
            'oauth_access_token_secret', 
            'Oauth access token secret', 
            array( $this, 'oauth_access_token_secret_callback' ), 
            'twitter-settings-admin', 
            'main_section'
        );       

        add_settings_field(
            'consumer_key', // ID
            'Consumer key', // Title 
            array( $this, 'consumer_key_callback' ), // Callback
            'twitter-settings-admin', // Page
            'main_section' // Section           
        );      

        add_settings_field(
            'consumer_secret', 
            'Consumer secret', 
            array( $this, 'oauth_access_token_secret_callback' ), 
            'twitter-settings-admin', 
            'main_section'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['oauth_access_token'] ) )
            $new_input['oauth_access_token'] = absint( $input['oauth_access_token'] );

        if( isset( $input['oauth_access_token_secret'] ) )
            $new_input['oauth_access_token_secret'] = sanitize_text_field( $input['oauth_access_token_secret'] );

		if( isset( $input['consumer_key'] ) )
            $new_input['consumer_key'] = sanitize_text_field( $input['consumer_key'] );

		if( isset( $input['consumer_secret'] ) )
            $new_input['consumer_secret'] = sanitize_text_field( $input['consumer_secret'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one by one its values
     */
    public function oauth_access_token_callback()
    {
        printf(
            '<input type="text" id="oauth_access_token" name="twitter[oauth_access_token]" value="%s" />',
            isset( $this->options['oauth_access_token'] ) ? esc_attr( $this->options['oauth_access_token']) : ''
        );
    }

    public function oauth_access_token_secret_callback()
    {
        printf(
            '<input type="text" id="oauth_access_token_secret" name="twitter[oauth_access_token_secret]" value="%s" />',
            isset( $this->options['oauth_access_token_secret'] ) ? esc_attr( $this->options['oauth_access_token_secret']) : ''
        );
    }
    
    public function consumer_key_callback()
    {
        printf(
            '<input type="text" id="consumer_key" name="twitter[consumer_key]" value="%s" />',
            isset( $this->options['consumer_key'] ) ? esc_attr( $this->options['consumer_key']) : ''
        );
    }
       
    public function consumer_secret_callback()
    {
        printf(
            '<input type="text" id="consumer_secret" name="twitter[consumer_secret]" value="%s" />',
            isset( $this->options['consumer_secret'] ) ? esc_attr( $this->options['consumer_secret']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new MySettingsPage();