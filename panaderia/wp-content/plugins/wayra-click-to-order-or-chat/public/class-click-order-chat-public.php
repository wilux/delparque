<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wayramarketing.com.ar
 * @since      1.0.0
 *
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Click_Order_Chat
 * @subpackage Click_Order_Chat/public
 * @author     Juan Manuel Acebal <juanm@wayramarketing.com.ar>
 */
class Click_Order_Chat_Public {

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
	 * Save options.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $options    Save options.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Get config data from the DB
		$this->options = get_option( $this->plugin_name );
		$this->options['target'] = ( $this->options['open_new_window'] ) ? '_blank' : '_self';
		$this->options['whatsapp_link'] = ( wp_is_mobile() ) ? 'https://api.whatsapp.com/send?phone=' : 'https://web.whatsapp.com/send?phone=';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/click-order-chat-public.css', array(), $this->version, 'all' );
		
	}


	/**
	 * Include the partial that show the WhatsApp floating button.
	 *
	 * @since    1.0.0
	 */
	public function wayra_coc_floating_button() {
		
		// TODO: Hide on specific pages
		include_once( 'partials/' . $this->plugin_name . '-public-floating-button.php' );
	}


	/**
	 * Include the partial that show the WhatsApp button on WooCommerce.
	 *
	 * @since    1.0.0
	 * @param    array    $arg       Recive data to make in WooCommerce the WhatsApp button.
	 */
	private function wayra_coc_show_button( $arg ) {

		include( 'partials/' . $this->plugin_name . '-public-button.php' );
	}

	
	/**
	 * Parse the message template and prepare to send in url.
	 *
	 * @since    1.0.0
	 * @param    array    $tags       Recive and array with tags and their values to replace.
	 * @param    string    $text      Template string with {{tags}} to replace with values.
	 * @return	 string	   Return the parse template.
	 */
	private function wayra_coc_parse_template( $tags, $text ) {

		foreach ( $tags as $key => $value ) {
			$text = str_replace( '{{' . $key . '}}', $value, $text );
		}
		$text = str_replace( ' ', '+', $text );
		$text = str_replace( "\r\n", '%0D%0A', $text );

		return $text;
	}


	/**
	 * Add jQuery to parse the message template in variable products.
	 *
	 * @since    1.0.3
	 */
	function wayra_coc_variation_js() {
		global $product;

		if ( $product->is_type( 'variable' ) && is_product() ) {
		?>
			<script>
				function capitalize(string) {
					return string.charAt(0).toUpperCase() + string.slice(1);
				}
				jQuery(function($) {
					var button_class = '.single_variation_wrap .wayra-coc-product';
					
					// Disable WhatsApp button on load
					$(button_class).addClass("disabled");
					
					// Prevent click when is disabled
					$(button_class).on( 'click', function(e) {
						if( $(this).hasClass('disabled') ) {
							e.preventDefault();
							alert('<?php _e( 'Please choose the product options before consulting.', 'wayra-click-to-order-or-chat' ); ?>');
						}
					})
					
					$('.variations_form').on('woocommerce_variation_select_change', function() {
						// If there aren't a variation selected on change, disable WhatsApp button
						if( ! $('#variation_id').val() ) {
							$(button_class).addClass('disabled');
						}
					} );
					
					setTimeout(function() {
						$('.single_variation_wrap').on('show_variation', function (event, variation) {
							var url = '<?php echo get_permalink($product->get_id());?>?';
							var attributes = [];
							var allAttributesSet = true;
							$('table.variations select').each(function() {
								var value = $(this).val();
								if (value) {
									attributes.push({
										id: $(this).attr('name'),
										value: value
									});
								} else {
									allAttributesSet = false;
								}
							});
							if (allAttributesSet) {
								// If all atributtes are set, activate the WhatsApp button
								$(button_class).removeClass('disabled');
								
								var variations = '';
								$.each(attributes,function(key, val) {
									var attribute = val.id.replace('attribute_pa_','');
									
									if (variations != '') {
										variations += '%0D%0A'; // New line
										url += '&';
									}
									variations += capitalize(attribute) + ':+' + capitalize(val.value);
									url += val.id + '=' + val.value;
								});
								
								var sku = ( variation.sku == '' ) ? '<?php echo $product->get_sku(); ?>' : variation.sku;
								var symbol = '<?php echo html_entity_decode(get_woocommerce_currency_symbol()); ?>';
								var price = symbol + '+' + variation.display_price;

								var templateText = $(button_class).attr('href');
								var templateParsed = templateText.replace( '{{attributes}}', variations );	
								templateParsed = templateParsed.replace( '{{SKU}}', sku );
								templateParsed = templateParsed.replace( '{{price}}', price );
								templateParsed = templateParsed.replace( '{{link}}', encodeURIComponent(url) );
								
								$(button_class).attr( 'href', templateParsed );
							}
						} );
					}, 400 );
				});
			</script>
		<?php
		}
	}

	/**
	 * This function gets all value of the product and prepare args to render the button in wayra_coc_show_button function.
	 *
	 * @since    1.0.0
	 */
	public function wayra_coc_product_button() {

		// Get config data
		$product_template = $this->options['product_template']; 
		// e.g. "Hi, i interested in: *{{title}}*\r\nPrice: {{price}}\r\nURL: {{link}}\r\nThanks!";

		$product_button_text = $this->options['product_button_text']; 
		// e.g. 'Ask in Whatsapp';

		global $product;

		if ( $product->is_type( 'variable' ) && is_product() ) {
			// Proccess tags: price, link and SKU with jQuery on product page
			$tags = array(
				'title' => $product->get_name(),
			);
		} else {
			$tags = array(
				'price' => urldecode(get_woocommerce_currency_symbol()) . ' ' . $product->get_price(),
				'title' => $product->get_name(),
				'link' => urlencode( get_permalink( $product->get_id() ) ),
				'SKU' => $product->get_sku(),
				'attributes' => '',
			);
		}

		$text = $this->wayra_coc_parse_template( $tags, $product_template );

		// Add extra class to user customization
		$extra_class = ( is_product() ) ? 'wayra-coc-product' : 'wayra-coc-shop';
		
		$arg = array(
			'text' => $text,
			'div_class' => '',
			'button_text' => $product_button_text,
			'woocommerce_class' => '',
			'extra_class' => $extra_class,
		);
		$this->wayra_coc_show_button( $arg );
	}


	/**
	 * This function is attach to woocommerce_product_meta_start hook to show the WhatsApp button on products not purchasables.
	 *
	 * @since    1.0.0
	 */
	public function wayra_coc_not_purchasable_product_button() {
		global $product;
		
		if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
			$this->wayra_coc_product_button();
		}
	}

	/**
	 * This function is attach to woocommerce_after_add_to_cart_button hook to show the WhatsApp button on products and Store.
	 *
	 * @since    1.0.0
	 */
	public function wayra_coc_purchasable_product_button() {
		global $product;
		
		if ( $product->is_purchasable() ) {
			$this->wayra_coc_product_button();
		}
	}

	/**
	 * This function is attach to woocommerce_after_cart_totals hook to show the WhatsApp button on Cart.
	 *
	 * @since    1.0.0
	 */
	public function wayra_coc_cart_page_button() {

		// Get config data
		$cart_product_template = "\r\n" . $this->options['cart_product_template'] . "\r\n"; 
		// e.g. "\r\n{{quantity}} x *{{title}}*\r\nPrice: {{price}}\r\nURL: {{link}}\r\n";

		$cart_template = $this->options['cart_template']; 
		// e.g. "Hi, i whant :\r\n{{product_list}}\r\n*TOTAL: {{total}}*\r\nThanks!";

		$cart_button_text = $this->options['cart_button_text']; 
		// e.g. 'Ask in Whatsapp';

		// Loop over $cart items
		$product_list = '';
		$currency_symbol = urldecode(get_woocommerce_currency_symbol());
		$cart = WC()->cart->get_cart();

		foreach ( $cart as $cart_item ) {
		   	$product = $cart_item['data'];
		   
			// If product is variable, get attributes to replace tag
		   	$attributes = '';
			if ( 'variation' === $product->get_type() ) {
				foreach( $product->get_attributes() as $taxonomy => $value ) {
					if ( ! empty( $attributes ) ) {
						$attributes .= "\r\n";
					}
					$attributes .= ucfirst( wc_attribute_label( $taxonomy ) ) . ': ' . ucfirst( $value );
				}
			}

		   	$tags = array(
				'quantity' => $cart_item['quantity'],
				'price' => $currency_symbol . ' ' . $product->price,
				'subtotal' => $currency_symbol . ' ' . $cart_item['line_subtotal'],
				'title' => $product->get_name(),
				'attributes' => $attributes,
				'link' => urlencode( $product->get_permalink( $cart_item ) ),
				'SKU' => $product->get_sku(),
			);
			
		   	$product_list .= $this->wayra_coc_parse_template( $tags, $cart_product_template );
		}
		
		$tags = array(
			'total' => $currency_symbol . ' ' . WC()->cart->total,
			'product_list' => $product_list,
		);

		$text = $this->wayra_coc_parse_template( $tags, $cart_template );

		$arg = array(
			'text' => $text,
			'div_class' => 'wc-proceed-to-checkout',
			'button_text' => $cart_button_text,
			'woocommerce_class' => 'checkout-button',
			'extra_class' => 'wayra-coc-cart',
		);
		$this->wayra_coc_show_button( $arg );

		// Clear cart after click
		if ( 'yes' == $this->options['clear_cart'] ) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/click-order-chat-public-clear-cart.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * This function is attach to woocommerce_proceed_to_checkout hook to remove Proceed to Checkout button on Cart.
	 *
	 * @since    1.0.0
	 */
	function wayra_coc_remove_proceed_to_checkout() {
		remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20 );
	}


	/**
	 * This function force redirect Checkout to Cart if Proceed to Checkout is disabled
	 *
	 * @since    1.0.0
	 */
	function wayra_coc_redirect_checkout_to_cart() {
		$checkout_url = get_permalink( woocommerce_get_page_id( 'checkout' ) );
		$cart_url = get_permalink( woocommerce_get_page_id( 'cart' ) );

		$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
		$current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		if ( $current_url == $checkout_url ) {
			wp_redirect( $cart_url );
			exit();
		}
	}


	/**
	 * This function add CSS to hide Checkout button in mini cart
	 *
	 * @since    1.0.0
	 */
	function wayra_coc_hide_checkout_mini_cart_button() {
		wp_enqueue_style( 'hide-checkout-mini-cart-button', plugin_dir_url( __FILE__ ) . 'css/click-order-chat-public.css' );
		$css = "
			a.button.checkout {
				display: none !important;
			}";
        wp_add_inline_style( 'hide-checkout-mini-cart-button', $css );
	}

	/**
	 * This function just return false, to fix an error with __return_false
	 *
	 * @since    1.0.2
	 */
	public function wayra_return_false() {
		return false;
	}

	/**
	 * This function clear the WooCommerce Cart after click on WhatsApp button
	 *
	 * @since    1.0.3
	 */
	function wayra_ajax_clear_cart() {
		WC()->cart->empty_cart();

		$redirect_after_click = $this->options['redirect_after_click'] ?? '';

		http_response_code(200);
		if ( $page = get_permalink( $redirect_after_click ) ) {
			echo json_encode( array( 'redirect' => $page ) );
			die;
		}
	}
	
}
