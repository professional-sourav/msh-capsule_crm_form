<?php

/**
 *
 * @link              http://awesome.com
 * @since             1.0.0
 * @package           Msh_Capsule_Integration_Form
 *
 * @wordpress-plugin
 * Plugin Name:       Capsule Integration Form
 * Plugin URI:        http://awesome.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Msh
 * Author URI:        http://awesome.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       msh-capsule-integration-form
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
define( 'MSH_CAPSULE_INTEGRATION_FORM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-msh-capsule-integration-form-activator.php
 */
function activate_msh_capsule_integration_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-msh-capsule-integration-form-activator.php';
	Msh_Capsule_Integration_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-msh-capsule-integration-form-deactivator.php
 */
function deactivate_msh_capsule_integration_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-msh-capsule-integration-form-deactivator.php';
	Msh_Capsule_Integration_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_msh_capsule_integration_form' );
register_deactivation_hook( __FILE__, 'deactivate_msh_capsule_integration_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-msh-capsule-integration-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_msh_capsule_integration_form() {

	$plugin = new Msh_Capsule_Integration_Form();
	$plugin->run();

}
run_msh_capsule_integration_form();
