<?php 
    /*
    Plugin Name: Cool Twitter Plugin 
    Plugin URI: https://github.com/ClaudiuCreanga/cool-twitter-wordpress-plugin
    Description: Plugin for showing your tweets on your blog
    Author: Claudiu Creanga
    Version: 1.0
    Author URI: http://claudiucreanga.me
    */
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
<h2>Staff Details</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'my-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Accountant Name</th>
        <td><input type="text" name="accountant_name" value="<?php echo esc_attr( get_option('accountant_name') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Accountant Phone Number</th>
        <td><input type="text" name="accountant_phone" value="<?php echo esc_attr( get_option('accountant_phone') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Accountant Email</th>
        <td><input type="text" name="accountant_email" value="<?php echo esc_attr( get_option('accountant_email') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php 
}
	

?>