<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wayramarketing.com.ar
 * @since      1.0.0
 *
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/includes
 * @author     Juan Manuel Acebal <juanm@wayramarketing.com.ar>
 */
class Click_Order_Chat_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wayra-click-to-order-or-chat',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
