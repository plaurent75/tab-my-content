<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.patricelaurent.net/
 * @since             1.0.0
 * @package           Tab_My_Content
 *
 * @wordpress-plugin
 * Plugin Name:       Tab My Content
 * Plugin URI:        https://www.patricelaurent.net/portfolio/plugin/tab-my-content/
 * Description:       Tab My Content is an easy way to add tabs inside your content, page or post. A lightweight and easy way to Tab your content.
 * Version:           1.0.0
 * Author:            Patrice LAURENT
 * Author URI:        https://www.patricelaurent.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tab-my-content
 * Domain Path:       /languages
 * Donate link:       https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=B2H2MRHMRQS2Y
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tab-my-content-activator.php
 */
function activate_tab_my_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tab-my-content-activator.php';
	Tab_My_Content_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tab-my-content-deactivator.php
 */
function deactivate_tab_my_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tab-my-content-deactivator.php';
	Tab_My_Content_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tab_my_content' );
register_deactivation_hook( __FILE__, 'deactivate_tab_my_content' );


/**
 * get linked Post to current tab
 *
 * @param $tabmc_id
 *
 * @return false|int
 */
function is_tabmc_of($tabmc_id){
	// return false or POST ID
	return wp_get_post_parent_id($tabmc_id);
}

/**
 * Check if current post has tabs
 *
 * @param $post_id
 *
 * @return array
 */
function have_tabmc($post_id){
	$args = array(
		'post_parent' => $post_id,
		'post_type'   => 'tab_my_content',
		'numberposts' => -1,
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'asc',
	);
	return get_children($args);
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tab-my-content.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tab_my_content() {

	$plugin = new Tab_My_Content();
	$plugin->run();

}
run_tab_my_content();