<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://agustyapratama.com
 * @since             1.0.0
 * @package           Auto_Internal_Linking
 *
 * @wordpress-plugin
 * Plugin Name:       Auto Internal Linking by CodeWPX
 * Plugin URI:        https://agustyapratama.com
 * Description:       Automatically adds internal links to specific keywords in your posts for better SEO and user engagement. 
 * Version:           1.0.0
 * Author:            agustya pratama
 * Author URI:        https://agustyapratama.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       auto-internal-linking
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AUTO_INTERNAL_LINKING_VERSION', '1.0.0' );
define( 'CODEWPX_AIL_VERSION', '1.0.0' );  
define( 'CODEWPX_AIL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );  
define( 'CODEWPX_AIL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );  

// Autoloader
spl_autoload_register(function($class) {
    if (strpos($class, 'Codewpx_AIL_') === 0) {
        $file = CODEWPX_AIL_PATH . 'includes/' . str_replace(['Codewpx_AIL_', '_'], ['', '/'], $class) . '.php';
        if (file_exists($file)) require $file;
    }
});


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-auto-internal-linking-activator.php
 */
function activate_auto_internal_linking() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-auto-internal-linking-activator.php';
	Auto_Internal_Linking_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-auto-internal-linking-deactivator.php
 */
function deactivate_auto_internal_linking() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-auto-internal-linking-deactivator.php';
	Auto_Internal_Linking_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_auto_internal_linking' );
register_deactivation_hook( __FILE__, 'deactivate_auto_internal_linking' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require CODEWPX_AIL_PLUGIN_DIR . 'includes/class-auto-internal-linking.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_auto_internal_linking() {

	$plugin = new Auto_Internal_Linking();
	$plugin->run();

}
run_auto_internal_linking();
