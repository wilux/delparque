(function( $ ) {
	'use strict';

	$(function() {

		// Togge tr to show or hide page list
		$('#click-order-chat-clear_cart').on('click', function(e) {
            $('#redirect_after_clear').toggle(300);
		});
	});

})( jQuery );
