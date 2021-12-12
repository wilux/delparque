<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wayramarketing.com.ar
 * @since      1.0.0
 *
 * @package    click-order-chat
 * @subpackage click-order-chat/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap wayra-coc-admin">
    <h2>Wayra - Click to Order or Chat</h2>
    <span class="wayra-coc-title" ><?php printf( __( 'This plugin is develop with %s by', 'wayra-click-to-order-or-chat' ), '<i class="dashicons-before dashicons-heart"></i>' ); ?> <a href="https://wayramarketing.com.ar" target="_blank">Juan Manuel Acebal</a><br>
    <?php _e( 'If you want to help me to continue develop useful plugins', 'wayra-click-to-order-or-chat' ); ?> <a id="donate" href="https://www.wayramarketing.com.ar/donar" target="_blank"><?php _e( 'buy me a cup of coffee', 'wayra-click-to-order-or-chat' ); ?></a><i id="coffee" class="dashicons-before dashicons-coffee"></i></span>
    
    <form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
    <?php
        //Grab all options
        $options = get_option( $this->plugin_name );

        // Check if Woocommerce is active
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
        $is_woocommerce_active = is_plugin_active('woocommerce/woocommerce.php');
        
        // General options
        $phone_number = ( isset( $options['phone_number'] ) && ! empty( $options['phone_number'] ) ) ? $options['phone_number'] : '';
        $open_new_window = ( isset( $options['open_new_window'] ) && ! empty( $options['open_new_window'] ) ) ? true : false;

        // Floating button options
        $show_floating = ( isset( $options['show_floating'] ) && ! empty( $options['show_floating'] ) ) ? true : false;
        $floating_button = ( ! isset( $options['floating_button'] ) ) ? 1 : $options['floating_button'];
        $floating_text = ( isset( $options['floating_text'] ) && ! empty( $options['floating_text'] ) ) ? $options['floating_text'] : '';
        $floating_label_text = ( isset( $options['floating_label_text'] ) && ! empty( $options['floating_label_text'] ) ) ? $options['floating_label_text'] : '';
        $hide_on_mobile = ( isset( $options['hide_on_mobile'] ) && ! empty( $options['hide_on_mobile'] ) ) ? true : false;
        
        // Woocommerce 
        $remove_add_to_cart = ( isset( $options['remove_add_to_cart'] ) && ! empty( $options['remove_add_to_cart'] ) ) ? true : false;
        $remove_proceed_to_checkout = ( isset( $options['remove_proceed_to_checkout'] ) && ! empty( $options['remove_proceed_to_checkout'] ) ) ? true : false;
        
        // Woocommerce : Product page and Store
        $show_on_product_page = ( isset( $options['show_on_product_page'] ) && ! empty( $options['show_on_product_page'] ) ) ? true : false;
        $show_not_purchasable = ( isset( $options['show_not_purchasable'] ) && ! empty( $options['show_not_purchasable'] ) ) ? true : false;
        $show_on_store = ( isset( $options['show_on_store'] ) && ! empty( $options['show_on_store'] ) ) ? true : false;
        $product_template = ( isset( $options['product_template'] ) && ! empty( $options['product_template'] ) ) ? $options['product_template'] : esc_attr__( "Hi, i'm interested in: *{{title}}*\n{{attributes}}\nPrice: {{price}}\nURL: {{link}}\nRegards!", 'wayra-click-to-order-or-chat' );
        $product_button_text = ( isset( $options['product_button_text'] ) && ! empty( $options['product_button_text'] ) ) ? $options['product_button_text'] : esc_attr__( 'Ask in WhatsApp', 'wayra-click-to-order-or-chat' );

        // Woocommerce: Cart
        $show_on_cart = ( isset( $options['show_on_cart'] ) && ! empty( $options['show_on_cart'] ) ) ? true : false;
        $cart_product_template = ( isset( $options['cart_product_template'] ) && ! empty( $options['cart_product_template'] ) ) ? $options['cart_product_template'] : esc_attr__( "{{quantity}} x *{{title}}*\nPrice: {{price}}\nURL: {{link}}", 'wayra-click-to-order-or-chat' );
        $cart_template = ( isset( $options['cart_template'] ) && ! empty( $options['cart_template'] ) ) ? $options['cart_template'] : esc_attr__( "Hi, i want to order:\n{{product_list}}\n*TOTAL: {{total}}*\nThanks!", 'wayra-click-to-order-or-chat' );
        $cart_button_text = ( isset( $options['cart_button_text'] ) && ! empty( $options['cart_button_text'] ) ) ? $options['cart_button_text'] : esc_attr__( "Ask in WhatsApp", 'wayra-click-to-order-or-chat' );
        $clear_cart = ( isset( $options['clear_cart'] ) && ! empty( $options['clear_cart'] ) ) ? true : false;
        $redirect_after_click = ( isset( $options['redirect_after_click'] ) && ! empty( $options['redirect_after_click'] ) ) ? $options['redirect_after_click'] : '';

        settings_fields( $this->plugin_name );
        do_settings_sections( $this->plugin_name );

    ?>
    <h3><?php _e( 'General', 'wayra-click-to-order-or-chat' ); ?></h3>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-phone_number"><?php _e( 'WhatsApp Number', 'wayra-click-to-order-or-chat' ); ?> <?php if( empty( $phone_number ) ) echo '<span style="color:red">*</span>'; ?></label></th>
                <td><input type="number" required id="<?php echo $this->plugin_name; ?>-phone_number" name="<?php echo $this->plugin_name; ?>[phone_number]" value="<?php echo $phone_number; ?>" class="regular-text <?php if( empty( $phone_number ) ) echo 'wayra-coc-error'; ?>"/>
                <p class="description" id="tagline-description"><?php _e( 'Insert the phone number starting with the country code.', 'wayra-click-to-order-or-chat' ); ?> <code><?php _e( 'e.g. 54 for Argentina', 'wayra-click-to-order-or-chat' ); ?></code></p></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-open_new_window"><?php _e( 'Open in new window', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-open_new_window" name="<?php echo $this->plugin_name; ?>[open_new_window]" value="1" <?php checked( $open_new_window ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Check this to open WhatsApp link in new window.', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <h3><?php _e( 'Floating Button', 'wayra-click-to-order-or-chat' ); ?></h3>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-show_floating"><?php _e( 'Show floating button', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_floating" name="<?php echo $this->plugin_name; ?>[show_floating]" value="1" <?php checked( $show_floating ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Show WhatsApp floating button on entire site.', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-floating_button"><?php _e( 'Button style', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td class="wayra-coc-flex">
                    <input type="radio" id="<?php echo $this->plugin_name; ?>-floating_button" name="<?php echo $this->plugin_name; ?>[floating_button]" value="1" <?php checked( $floating_button, 1 ); ?> />
                    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/floating-01.png'; ?>" width="45px" style="margin-bottom: -13px; margin-right: 30px" />
                    <input type="radio" id="<?php echo $this->plugin_name; ?>-floating_button" name="<?php echo $this->plugin_name; ?>[floating_button]" value="2" <?php checked( $floating_button, 2 ); ?> />
                    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'images/floating-02.png'; ?>" width="50px" style="margin-bottom: -13px;" />
                </td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-floating_text"><?php _e( 'Message to send', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="text" id="<?php echo $this->plugin_name; ?>-floating_text" name="<?php echo $this->plugin_name; ?>[floating_text]" value="<?php echo $floating_text; ?>" class="regular-text"/>
                <p class="description" id="tagline-description"><?php _e( 'Insert the default message that send when someone click the button.', 'wayra-click-to-order-or-chat' ); ?> <code><?php _e( ' e.g. "Hi, i have a question"', 'wayra-click-to-order-or-chat' ); ?></code></p></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-floating_label_text"><?php _e( 'Text on button hover', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><textarea id="<?php echo $this->plugin_name; ?>-floating_label_text" name="<?php echo $this->plugin_name; ?>[floating_label_text]" rows="2" cols="50" class="regular-text"><?php echo $floating_label_text; ?></textarea>
                <p class="description" id="tagline-description"><?php _e( 'Insert the text that someone see on button hover.', 'wayra-click-to-order-or-chat' ); ?> <code><?php _e( 'e.g. "Chat with us"', 'wayra-click-to-order-or-chat' ); ?></code></p></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-hide_on_mobile"><?php _e( 'Hide button on mobile', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-hide_on_mobile" name="<?php echo $this->plugin_name; ?>[hide_on_mobile]" value="1" <?php checked( $hide_on_mobile ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Hide the floating button on mobile.', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <h3>WooCommerce <?php if ( ! $is_woocommerce_active ) { ?><span class="wayra-coc-inactive">( <?php _e( 'Inactive', 'wayra-click-to-order-or-chat' ); ?> )</span><?php } ?></h3>
    <?php if ( ! $is_woocommerce_active ) { ?>
    <p><?php _e( 'For simplificate the config we hide the WooCommerce config options because the plugin is inactive.', 'wayra-click-to-order-or-chat' ); ?></p>
    <?php } else { ?>  
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-remove_add_to_cart"><?php _e( 'Remove Add to Cart Buttons', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-remove_add_to_cart" name="<?php echo $this->plugin_name; ?>[remove_add_to_cart]" value="1" <?php checked( $remove_add_to_cart ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Remove the Woocommerce Add to Cart buttons on entire site to use WhatsApp buttons.', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-remove_proceed_to_checkout"><?php _e( 'Remove button Proceed to Checkout', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-remove_proceed_to_checkout" name="<?php echo $this->plugin_name; ?>[remove_proceed_to_checkout]" value="1" <?php checked( $remove_proceed_to_checkout ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Remove the Woocommerce Proceed to Checkout button on Cart and mini cart.', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>
        </tbody>
    </table>

    <h4><?php _e( 'Products page and Store', 'wayra-click-to-order-or-chat' ); ?></h4>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-show_on_product_page"><?php _e( 'Show button on products', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_on_product_page" name="<?php echo $this->plugin_name; ?>[show_on_product_page]" value="1" <?php checked( $show_on_product_page ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Show WhatsApp button on products', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-show_not_purchasable"><?php _e( 'Show button on not purchasable products', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_not_purchasable" name="<?php echo $this->plugin_name; ?>[show_not_purchasable]" value="1" <?php checked( $show_not_purchasable ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Show WhatsApp button on product without price or out of stock.', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-show_on_store"><?php _e( 'Show button on Store', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_on_store" name="<?php echo $this->plugin_name; ?>[show_on_store]" value="1" <?php checked( $show_on_store ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Show WhatsApp button on store and related products.', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-product_template"><?php _e( 'Product message', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><textarea id="<?php echo $this->plugin_name; ?>-product_template" name="<?php echo $this->plugin_name; ?>[product_template]" rows="4" cols="50" class="regular-text"><?php echo $product_template; ?></textarea>
                <p class="description" id="tagline-description"><?php _e( 'This is the message that recive someone click on product WhatsApp button.', 'wayra-click-to-order-or-chat' ); ?><br>
                <code><?php _e( 'You can use {{title}}, {{price}}, {{link}}, {{SKU}} and *word* for bold.', 'wayra-click-to-order-or-chat' ); ?></code><br>
                <code><?php _e( '{{attributes}} tag show in variable products a new line for each attribute and their selected value.', 'wayra-click-to-order-or-chat' ); ?></code>
                </p></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-product_button_text"><?php _e( 'Product button text', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="text" id="<?php echo $this->plugin_name; ?>-product_button_text" name="<?php echo $this->plugin_name; ?>[product_button_text]" value="<?php echo $product_button_text; ?>" class="regular-text"/>
                <p class="description" id="tagline-description"><?php _e( 'Insert the button text.', 'wayra-click-to-order-or-chat' ); ?> <code><?php _e( 'e.g. "Ask in WhatsApp"', 'wayra-click-to-order-or-chat' ); ?></code></p></td>
            </tr>
        </tbody>
    </table>

    <h4><?php _e( 'Cart', 'wayra-click-to-order-or-chat' ); ?></h4>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-show_on_cart"><?php _e( 'Show button on cart page', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-show_on_cart" name="<?php echo $this->plugin_name; ?>[show_on_cart]" value="1" <?php checked( $show_on_product_page ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Show WhatsApp button in Cart to ask for all the cart', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-cart_product_template"><?php _e( 'Cart product message', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><textarea id="<?php echo $this->plugin_name; ?>-cart_product_template" name="<?php echo $this->plugin_name; ?>[cart_product_template]" rows="4" cols="50" class="regular-text"><?php echo $cart_product_template; ?></textarea>
                <p class="description" id="tagline-description"><?php _e( 'This message is part of the message that recive someone click on Cart WhatsApp button.', 'wayra-click-to-order-or-chat' ); ?><br>
                <code><?php _e( 'You can use {{title}}, {{price}}, {{subtotal}}, {{link}}, {{SKU}} and *word* for bold.', 'wayra-click-to-order-or-chat' ); ?></code><br>
                <code><?php _e( '{{attributes}} tag show in variable products a new line for each attribute and their selected value.', 'wayra-click-to-order-or-chat' ); ?></code>
                </p></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-cart_template"><?php _e( 'Cart message', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><textarea id="<?php echo $this->plugin_name; ?>-cart_template" name="<?php echo $this->plugin_name; ?>[cart_template]" rows="4" cols="50" class="regular-text"><?php echo $cart_template; ?></textarea>
                <p class="description" id="tagline-description"><?php _e( 'This message the message that recive someone click on Cart WhatsApp button.', 'wayra-click-to-order-or-chat' ); ?><br>
                <code><?php _e( 'You can use {{product_list}}, {{total}} and *word* for bold.', 'wayra-click-to-order-or-chat' ); ?></code></p></td>
            </tr>

            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-cart_button_text"><?php _e( 'Cart button text', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="text" id="<?php echo $this->plugin_name; ?>-cart_button_text" name="<?php echo $this->plugin_name; ?>[cart_button_text]" value="<?php echo $cart_button_text; ?>" class="regular-text"/>
                <p class="description" id="tagline-description"><?php _e( 'Insert the text of the the button.', 'wayra-click-to-order-or-chat' ); ?> <code><?php _e( 'e.g. "Ask for this products on WhatsApp"', 'wayra-click-to-order-or-chat' ); ?></code></p></td>
            </tr>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-clear_cart"><?php _e( 'Clear Cart after click', 'wayra-click-to-order-or-chat' ); ?></label></th>
                <td><input type="checkbox" id="<?php echo $this->plugin_name; ?>-clear_cart" name="<?php echo $this->plugin_name; ?>[clear_cart]" value="1" <?php checked( $clear_cart ); ?> />
                <span class="description" id="tagline-description"><?php _e( 'Clear the WooCommerce Cart after click on WhatsApp button', 'wayra-click-to-order-or-chat' ); ?></span></td>
            </tr>
            <tr id="redirect_after_clear" <?php if ( empty( $clear_cart ) ) echo 'style="display:none"'; ?>>
                <th><?php _e( 'Redirect WooCommerce after clear the Cart', 'wayra-click-to-order-or-chat' ) ?></th>
                <td>
                    <?php 
                    $args = array(
                        'selected'         => $redirect_after_click,
                        'name'             => $this->plugin_name . '[redirect_after_click]',
                        'show_option_none' => __('Select a page', 'wayra-click-to-order-or-chat'),
                    );
                    wp_dropdown_pages( $args ); 
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php } ?>
    <h3><?php _e( 'Customize CSS style', 'wayra-click-to-order-or-chat' ); ?></h3>
    <span style="font-size:14px;"><?php _e( 'If you need to customize any button, we add an empty class in each type of buttons. You are welcome ;)', 'wayra-click-to-order-or-chat' ); ?></span>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row"><?php _e( 'Floating button', 'wayra-click-to-order-or-chat' ); ?></th>
                <td><code>.wayra-coc-floating</code></td>
            </tr>
            <?php if ( $is_woocommerce_active ) { ?>
            <tr>
                <th scope="row"><?php _e( 'Product page button', 'wayra-click-to-order-or-chat' ); ?></th>
                <td><code>.wayra-coc-product</code></td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Store and related products buttons', 'wayra-click-to-order-or-chat' ); ?></th>
                <td><code>.wayra-coc-shop</code></td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Cart button', 'wayra-click-to-order-or-chat' ); ?></th>
                <td><code>.wayra-coc-cart</code></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php submit_button( __( 'Save all changes', 'wayra-click-to-order-or-chat' ), 'primary','submit', TRUE ); ?>
    </form>
</div>
