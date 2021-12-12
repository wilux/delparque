<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://wayramarketing.com.ar
 * @since      1.0.0
 *
 * @package    Click_Order_Chat
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete DB info
delete_option('click-order-chat');
 
// for site options in Multisite
delete_site_option('click-order-chat');