<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              aleksandarperisic.com
 * @since             1.0.0
 * @package           Ap_Breaking_News
 *
 * @wordpress-plugin
 * Plugin Name:       AP Breaking News
 * Plugin URI:        aleksandarperisic.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Aleksandar
 * Author URI:        aleksandarperisic.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ap-breaking-news
 * Domain Path:       /languages
 * Requires at least: 5.6
 * Tested up to: 5.8
 * Requires PHP: 7.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Define other things also
 */
define( 'Ap_Breaking_News_VERSION', '1.0.0' );
define( 'AP_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'AP_MODULES_URL', plugins_url( '/', __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ap-breaking-news-activator.php
 */
function activate_ap_breaking_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ap-breaking-news-activator.php';
	Ap_Breaking_News_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ap-breaking-news-deactivator.php
 */
function deactivate_ap_breaking_news() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ap-breaking-news-deactivator.php';
	Ap_Breaking_News_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ap_breaking_news' );
register_deactivation_hook( __FILE__, 'deactivate_ap_breaking_news' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ap-breaking-news.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ap_breaking_news() {

	$plugin = new Ap_Breaking_News();
	$plugin->run();

}
run_ap_breaking_news();
