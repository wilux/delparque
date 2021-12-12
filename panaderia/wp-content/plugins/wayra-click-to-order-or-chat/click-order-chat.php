<?php

/**
 *
 * @link              https://wayramarketing.com.ar
 * @since             1.0.0
 * @package           Click_Order_Chat
 *
 * @wordpress-plugin
 * Plugin Name:       Wayra - Click to Order or Chat
 * Plugin URI:        https://wayramarketing.com.ar/
 * Description:       A lightweight, easy and fast option to show a <strong>floating WhatsApp button</strong> and WooCommerce customization to <strong>add "Ask in WhatsApp" button on products, Store and Cart</strong>. You can hide the default "Add to Cart" button. We love simplicity and efficience. 
 * Version:           1.0.5
 * Author:            Juan Manuel Acebal
 * Author URI:        https://wayramarketing.com.ar
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wayra-click-to-order-or-chat
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'CLICK_ORDER_CHAT_VERSION', '1.0.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-click-order-chat-activator.php
 */
function activate_click_order_chat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-click-order-chat-activator.php';
	Click_Order_Chat_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-click-order-chat-deactivator.php
 */
function deactivate_click_order_chat() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-click-order-chat-deactivator.php';
	Click_Order_Chat_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_click_order_chat' );
register_deactivation_hook( __FILE__, 'deactivate_click_order_chat' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-click-order-chat.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_click_order_chat() {

	$plugin = new Click_Order_Chat();
	$plugin->run();

}
run_click_order_chat();
