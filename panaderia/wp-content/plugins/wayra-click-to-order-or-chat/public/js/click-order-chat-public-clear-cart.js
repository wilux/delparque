(function( $ ) {
	'use strict';

	$(function() {

		// Clear Cart on click on WhatsApp Cart button
		$('.wayra-coc-cart').on('click', function(e) {
			$.ajax({
                type: 'post',
                url: woocommerce_params['ajax_url'],
                data: {
                    action: 'clear_cart',
                },
                dataType: 'json',
                success: function(data) {
                    if(data.redirect) {
                        location.replace(data.redirect);
                    } else {
                        location.reload();
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            })
		});
	});

})( jQuery );
