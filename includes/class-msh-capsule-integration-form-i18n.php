<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://awesome.com
 * @since      1.0.0
 *
 * @package    Msh_Capsule_Integration_Form
 * @subpackage Msh_Capsule_Integration_Form/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Msh_Capsule_Integration_Form
 * @subpackage Msh_Capsule_Integration_Form/includes
 * @author     Msh <awsome@gmail.com>
 */
class Msh_Capsule_Integration_Form_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'msh-capsule-integration-form',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
