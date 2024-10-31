<?php
/*
Plugin Name: Plugmatter GDPR Bot Integration
Plugin URI: https://plugmatter.com/gdprbot
Description: The Plugmatter GDPR Bot Integration plugin helps you install Plugmatter GDPR Bot code snippet on your WordPress site. Plugmatter GDPR Bot service is an all in one GDPR, ePrivacy and CCPA compliance solution. It is designed to give you a complete hands-free and stress-free compliance experience. Right from cookie monitoring, beautiful cookie consent popups to privacy policy generator.
Version: 1.0.1
Author: Plugmatter 
Author URI: https://plugmatter.com
Text Domain: Plugmatter
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

define('Plugmatter_GDPR_PACKAGE', 'plugmatter_gdprbot');

// plugin uninstallation
register_uninstall_hook( __FILE__, 'pm_gdpr_fn_uninstall' );

function pm_gdpr_fn_uninstall() {
    if(get_option('pm_gdpr_licence_key') != "") {
        delete_option( 'pm_gdpr_licence_key' );
    }
}

add_action( 'admin_menu', 'pm_gdpr_plugin_settings');

function pm_gdpr_css() {
  wp_register_style('pm_gdpr_plugin_css',plugins_url('css/style.css', __FILE__));
  wp_enqueue_style('pm_gdpr_plugin_css');
}

// Enqueue styles and js
add_action('admin_enqueue_scripts','pm_gdpr_css');


/**
 * Registers a new settings page under Settings.
 */

function pm_gdpr_plugin_settings() {
    add_options_page(
        'Plugmatter GDPR Bot Settings Page', 
        'GDPR Bot Integration', 
        'manage_options', 
        'pm_gdpr_settings',
        'pm_gdpr_settings_page'
    );
}

function pm_gdpr_settings_page(){
    require_once( plugin_dir_path( __FILE__ ) . 'pages/pm-gdpr-license.php');
}

add_action( 'wp_footer', function () { 
    if(get_option('pm_gdpr_licence_key') != "") {
    ?>
        <script async type="text/javascript" 
            src="https://plugmatter.com/api/gdprbot/?hash=<?php echo get_option('pm_gdpr_licence_key'); ?>"></script>
<?php 
    }
} );

