<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://pavstyuk.ru
 * @since      1.0.0
 *
 * @package    Basic_Post_Ajax
 * @subpackage Basic_Post_Ajax/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Basic_Post_Ajax
 * @subpackage Basic_Post_Ajax/includes
 * @author     Mikhail <Pavstyuk@yandex.ru>
 */
class Basic_Post_Ajax_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'basic-post-ajax',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
