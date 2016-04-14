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
        add_options_page(
            'Settings Admin', 
            'My Settings', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h2>My Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );   
                do_settings_sections( 'my-setting-admin' );
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
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
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
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

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
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new MySettingsPage();

?>




<?php 
	
function web_scraping_admin_actions() {
    add_menu_page("Twitter", "Twitter","administrator", "twitter_settings", "twitter_settings_page");
}
 
add_action('admin_menu', 'web_scraping_admin_actions');

add_action( 'admin_init', 'twitter_settings' );

function twitter_settings() {
	register_setting( 'my-plugin-settings-group', 'accountant_name' );
	register_setting( 'my-plugin-settings-group', 'accountant_phone' );
	register_setting( 'my-plugin-settings-group', 'accountant_email' );
}
	
function twitter_settings_page()
{
	?>
	<div class="wrap">
<h2>Twitter Details</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'my-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Oauth access token</th>
        <td><input type="text" name="oauth_access_token" value="<?php echo esc_attr( get_option('oauth_access_token') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Oauth access token secret</th>
        <td><input type="text" name="oauth_access_token_secret" value="<?php echo esc_attr( get_option('oauth_access_token_secret') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Consumer key</th>
        <td><input type="text" name="consumer_key" value="<?php echo esc_attr( get_option('consumer_key') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Consumer secret</th>
        <td><input type="text" name="consumer_secret" value="<?php echo esc_attr( get_option('consumer_secret') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php 
}
	

?>