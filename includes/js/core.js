
jQuery('#payment_method_cod').attr('checked', true); //assume #tradio-1-2 is the id of the radio input.
jQuery('#quantity_qb').val(jQuery('input#qty').val());

jQuery('input#qty').on('change', function () {
	jQuery('#quantity_qb').val(jQuery(this).val());
}); 

jQuery('#formQuickBuy').parsley();

jQuery('#formQuickBuy').submit(function() {

		jQuery('#ajax_loader').show();

		var $thisForm = jQuery(this);

		var action = $thisForm.attr('action');

		jQuery.ajax({
			url : action,
			method : 'POST',
			data : $thisForm.serializeArray(),
			dataType : 'json',
			success : function(response) {
                if ( response.result ) {
               /*     $thisbutton.closest('.item').remove();
                    jQuery('.badge.badge-inverse').empty().text(response.item_count);*/
                    // add Az
                    // jQuery(".shopping_cart_mini").html(response.fragments.toString());
                    // End add Az
				}
				jQuery('#ajax_loader').hide();
				jQuery('#ajax_message .inside').empty().html(response.message);
				jQuery('#ajax_message').show().delay(3000).fadeOut('slow');
			}
		});

		return false;
});


