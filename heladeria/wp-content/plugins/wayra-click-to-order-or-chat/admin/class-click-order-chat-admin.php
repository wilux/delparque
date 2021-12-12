<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wayramarketing.com.ar
 * @since      1.0.0
 *
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/admin
 * @author     Juan Manuel Acebal <juanm@wayramarketing.com.ar>
 */
class Click_Order_Chat_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the scripts for the admin-facing side of the site.
	 *
	 * @since    1.0.5
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/click-order-chat-admin.js', array('jquery'), $this->version );
		
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/click-order-chat-admin.css', array(), $this->version, 'all' );

	}
	

	/**
	 * Register the administration menu for this plugin into the WordPress Settings menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		add_options_page('Click to Order or Chat', 'Click to Order or Chat', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page' ) );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		/*
		*  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
		*/
		$settings_link = array( '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', 'wayra-click-to-order-or-chat' ) . '</a>', );
		return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {

		include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

	}

	/**
	 * Validate the field based on type, and assign default value if it's necessary.
	 *
	 * @since    1.0.0
	 * @param      string    $field       		The field to validate.
	 * @param      string    $field_type    	The field type checkbox, input, select or textarea.
	 * @param      string    $default_value    	The default value to assign if it's empty.
	 * @return	   mixed	 field value or default value.
	 */
	private function validate_field( $field, $field_type, $default_value = '' ) {
		switch ( $field_type ) {

			case 'checkbox':
				return ( isset( $field ) && ! empty( $field ) ) ? true : false;
				break;
			case 'input':
				return ( isset( $field ) && ! empty( $field ) ) ? esc_attr( $field ) : $default_value;
				break;
			case 'select':
				return ( isset( $field ) && ! empty( $field ) ) ? esc_attr( $field ) : 1;
				break;
			case 'textarea':
				return ( isset( $field ) && ! empty( $field ) ) ? sanitize_textarea_field( $field ) : $default_value;

		}
	}


	/**
	 * Validate fields from admin area plugin settings
	 * 
	 * @since    1.0.0
	 * @param  	mixed 	$input as field form settings form
	 * @return 	mixed 	as validated fields
	 */
	public function validate( $input ) {

		$options = get_option( $this->plugin_name );

		// General options
		$options['phone_number'] = $this->validate_field( $input['phone_number'], 'input' );
		$options['open_new_window'] = $this->validate_field( $input['open_new_window'], 'checkbox' );

		// Floating button options
		$options['show_floating'] = $this->validate_field( $input['show_floating'], 'checkbox', true );
		$options['floating_button'] = $this->validate_field( $input['floating_button'], 'select' );
		$options['floating_text'] = $this->validate_field( $input['floating_text'], 'input');
		$options['floating_label_text'] = $this->validate_field( $input['floating_label_text'], 'textarea' );
		$options['hide_on_mobile'] = $this->validate_field( $input['hide_on_mobile'], 'checkbox', false );

		// Woocommerce
		$options['remove_add_to_cart'] = $this->validate_field( $input['remove_add_to_cart'], 'checkbox', false );
		$options['remove_proceed_to_checkout'] = $this->validate_field( $input['remove_proceed_to_checkout'], 'checkbox', false );

		// Woocommerce: Product and store
		$options['show_on_product_page'] = $this->validate_field( $input['show_on_product_page'], 'checkbox', true );
		$options['show_not_purchasable'] = $this->validate_field( $input['show_not_purchasable'], 'checkbox', true );
        $options['show_on_store'] = $this->validate_field( $input['show_on_store'], 'checkbox', false );
		
        $options['product_template'] = $this->validate_field( $input['product_template'], 'textarea' );
		$options['product_button_text'] = $this->validate_field( $input['product_button_text'], 'input');

		// Woocommerce: Cart
		$options['show_on_cart'] = $this->validate_field( $input['show_on_cart'], 'checkbox', true );
		$options['cart_product_template'] = $this->validate_field( $input['cart_product_template'], 'textarea' );
		$options['cart_template'] = $this->validate_field( $input['cart_template'], 'textarea' );
        $options['cart_button_text'] = $this->validate_field( $input['cart_button_text'], 'input');
		$options['clear_cart'] = $this->validate_field( $input['clear_cart'], 'checkbox', true );
		$options['redirect_after_click'] = $this->validate_field( $input['redirect_after_click'], 'input' );
		
		return $options;

	}

	public function options_update() {

		register_setting( $this->plugin_name, $this->plugin_name, array( 'sanitize_callback' => array( $this, 'validate' ), ) );

	}
}
