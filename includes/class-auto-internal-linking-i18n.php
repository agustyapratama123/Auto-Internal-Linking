<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://agustyapratama.com
 * @since      1.0.0
 *
 * @package    Auto_Internal_Linking
 * @subpackage Auto_Internal_Linking/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Auto_Internal_Linking
 * @subpackage Auto_Internal_Linking/includes
 * @author     agustya pratama <agustyapratama76@gmail.com>
 */
class Auto_Internal_Linking_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'auto-internal-linking',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
