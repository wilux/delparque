<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wayramarketing.com.ar
 * @since      1.0.0
 *
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/includes
 * @author     Juan Manuel Acebal <juanm@wayramarketing.com.ar>
 */
class Click_Order_Chat {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Click_Order_Chat_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CLICK_ORDER_CHAT_VERSION' ) ) {
			$this->version = CLICK_ORDER_CHAT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'click-order-chat';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Click_Order_Chat_Loader. Orchestrates the hooks of the plugin.
	 * - Click_Order_Chat_i18n. Defines internationalization functionality.
	 * - Click_Order_Chat_Admin. Defines all hooks for the admin area.
	 * - Click_Order_Chat_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-click-order-chat-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-click-order-chat-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-click-order-chat-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-click-order-chat-public.php';

		$this->loader = new Click_Order_Chat_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Click_Order_Chat_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Click_Order_Chat_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Click_Order_Chat_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Save/Update our plugin options
		$this->loader->add_action('admin_init', $plugin_admin, 'options_update');

		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
	
		// Add Settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
	
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

	}

		
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$options = get_option( $this->get_plugin_name() );

		// Check if Woocommerce is active
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$is_woocommerce_active = is_plugin_active('woocommerce/woocommerce.php');

		if( ! empty( $options['phone_number'] ) ) {
			
			$plugin_public = new Click_Order_Chat_Public( $this->get_plugin_name(), $this->get_version() );

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );

			// Add float button
			if ( $options['show_floating'] ) {
				$this->loader->add_action( 'wp_footer', $plugin_public, 'wayra_coc_floating_button' );
			}
			
			if ( $is_woocommerce_active ) {

				// Remove add to cart button on all site
				if ( $options['remove_add_to_cart'] ) {
					$this->loader->add_filter( 'woocommerce_is_purchasable', $plugin_public, 'wayra_return_false' );
				}

				// Add button on product page (purchasable)
				if ( $options['show_on_product_page'] ) {
					$this->loader->add_action( 'woocommerce_after_add_to_cart_button', $plugin_public, 'wayra_coc_purchasable_product_button' );
					// Add jQuery to parse tags in variable products
					$this->loader->add_action( 'woocommerce_before_add_to_cart_quantity', $plugin_public, 'wayra_coc_variation_js' );
				}

				// Add button on product page (not purchasable)
				if ( $options['show_on_product_page'] && $options['show_not_purchasable'] ) {
					$this->loader->add_action( 'woocommerce_product_meta_start', $plugin_public, 'wayra_coc_not_purchasable_product_button' );
				}

				// Add button on cart
				if ( $options['show_on_cart'] && ! $options['remove_add_to_cart'] ) {
					$this->loader->add_action( 'woocommerce_after_cart_totals', $plugin_public, 'wayra_coc_cart_page_button' );
					$this->loader->add_action('wp_ajax_clear_cart', $plugin_public, 'wayra_ajax_clear_cart' );
					$this->loader->add_action('wp_ajax_nopriv_clear_cart', $plugin_public, 'wayra_ajax_clear_cart' );
				}

				// Add button on store (purchasable or not purchasable)
				if ( $options['show_on_store'] ) {
					$this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public,  'wayra_coc_product_button' );
				}

				// Remove Proceed to Chckout button on Cart
				if ( $options['remove_proceed_to_checkout'] ) {
					$this->loader->add_action( 'woocommerce_proceed_to_checkout', $plugin_public,  'wayra_coc_remove_proceed_to_checkout', 1 );
					$this->loader->add_action( 'init', $plugin_public,  'wayra_coc_redirect_checkout_to_cart', 1 );
					$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public,  'wayra_coc_hide_checkout_mini_cart_button' );
				}		
			}
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Click_Order_Chat_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
