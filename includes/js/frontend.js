jQuery(document).ready(function(){

    jQuery('.wcqb_button').click(function(){
        var product_id = jQuery(this).attr('data-product-id');
        var product_type = jQuery(this).attr('data-product-type');
        var selected = jQuery('form.cart input#wc_quick_buy_hook_'+product_id);
        var productform = selected.parent();
        productform.append('<input type="hidden" value="true" name="quick_buy" />');
		var submit_btn = productform.find('[type="submit"]');
		var is_disabled = submit_btn.is(':disabled');
		
		if(is_disabled){
			jQuery('html, body').animate({
				scrollTop: submit_btn.offset().top - 200
			}, 900);
		} else {
			productform.find('[type="submit"]').click();
		}
        
    });


	
	jQuery('form.cart').change(function(){
		var is_submit_disabled = jQuery(this).find('[type="submit"]').is(':disabled');
		if(is_submit_disabled){
			jQuery('.wcqb_button').attr('disabled','disable');
		} else {
			jQuery('.wcqb_button').removeAttr('disabled');
		}
	})

    jQuery("#wc_quick_buy_mobile").mask("(0399) 9999999");
	
	var input_city = jQuery("input[name=wc_quick_buy_city]");
    input_city.typeahead({
        source: ["Daharki", "Daska", "Daud Khel", "Daulatpur", "Depalpur", "Dera Allah Yar", "Dera Ghazi Khan", "Dera Ismail Khan", "Dera Murad Jamali", "Digri", "Dina", "Dinga", "Donga Bonga", "Dunia pur", "Esa Khel", "Faisalabad", "Faqirwali", "Fateh Jang", "Ferozwatowan", "Fort Abbass", "Gadoon Amazai", "Gaggo Mandi", "Gakhar Mandi", "Gambat", "Ghotki", "Gojra", "Goth Machi", "Guddu", "Gujran khan", "Gujranwala", "Gujrat", "Hafizabad ", "Harappa", "Hari pur", "Haroonabad", "Hasil pur", "Hassanabdal", "Hattar", "Hattian", "Havali Lakhan", "HawiliaN", "Hazro ", "Head Marala", "Hujra Shah Mukeem", "Hyderabad", "Iskandarabad", "Islamabad", "Jacobabad", "Jahaniya", "Jalalpur Jattan", "Jalalpur pirwala", "Jampur", "Jamshoro", "Jand", "Jaranwala", "Jatlaan", "Jatoi", "Jauharabad", "Jhang", "Jhelum", "Jin Pur", "K.N. Shah", "KHYBER", "Kabirwala", "Kahuta", "Kala Bagh", "Kala Shah Kaku", "Kallar Kahar", "Kallar Saddiyian", "Kamalia", "Kameer", "Kamoke", "Kamra ", "Kandh Kot", "Kandiaro", "Karachi", "Kashmore", "Kasur", "Khairpur Mirs", "Khan Bela", "Khan Pur", "Khanewal", "Khanpur dem", "Kharian", "Khewra", "Khurrianwala", "Khushab", "Klaske", "Kohat", "Kot Addu", "Kot Momin", "Kotla Arab Ali Khan", "Kotly AK", "Kotly Loharana", "Kunri", "Lahore", "Lala Musa", "Larkana", "Layya ", "Liaqat Pur", "Lodhran", "MATIARI", "Mainwali", "Malikwal", "Mandi Baha uddin", "Mandra", "Manga Mandi", "Mangla", "Mansahra", "Mardan", "Mehar", "Mehrabpur", "Melsi", "Mian Channu", "Minchanaabad", "Mirpur AK", "Mirpur Khas", "Mirpur Mathelo", "Mithi", "Mitiari", "Moro", "Multan", "Muridkay", "Murree", "Muzaffar gargh", "Muzaffarabad", "Narowal", "Nawab Shah", "Nooriabad", "Noshero Feroze", "Noudero", "Nowshera", "Nowshera virka", "Okara", "Pak Pattan Sharif", "Pani Aqil", "Pasroor", "Pattoke", "Peshawar", "Phalia", "Pind dadan Khan", "Pindi Gheb", "Pindi bhattiya ", "Piplan", "Pir Mahal", "Qamber Ali Khan", "Qila Deedar Singh", "Quaid abad", "Quetta", "Rabwah", "Rahimyar Khan", "Raiwind", "Rajanpur", "Ranipur", "Rato Dero", "Rawalpindi", "Rawat", "Renala Khurd", "Rohri", "SAMUNDRI", "SEKHAT", "SHOREKOT CANTT", "Sadiq Abad", "Sahiwal", "Sakhi Sarwar", "Sambrial", "Sanghar", "Sangla Hills", "Sanjarpur", "Sara-e-alamgir", "Sargodha", "Satiayana ", "Sawabi", "Sehwan Sharif", "Shahdadpur", "Shahdara", "Shahkot", "Shahpur Saddar", "Shakargarh", "Sheikhupura", "Shikarpur", "Shorkot", "Shuja Abad", "Sialkot", "Sillanwali", "Skrand", "Sohawa", "Sukkar", "Sumandari", "Sundar", "Swat", "Talagang", "Tandiliyawala", "Tando Adam", "Tando Allah Yar", "Tando Jam", "Tando Muhammad Khan", "Tarbela", "Tatlay wali ", "Taunsa Sharif", "Taxila", "Thatta", "Tobe Tek Singh", "Topi", "Tranda Muhammad Pannah", "Ubaro", "Ugoke", "Umer Kot", "Usta Muhammad", "Vehari", "Wah", "Wahn Bachran", "Wazirabad", "Yazman", "Zafarwal", "Zahir peer"],
        minLength: 1
    });



	jQuery('#payment_method_cod').attr('checked', true); //assume #tradio-1-2 is the id of the radio input.
	jQuery('#wc_quick_buy_quantity').val(jQuery('input#qty').val());

	jQuery('input#qty').on('change', function () {

		var qty = jQuery(this).val();
		jQuery('[name=wc_quick_buy_quantity]').val(qty);
	/*	jQuery('[name=wc_quick_buy_quantity] option').filter(function() { 
		    return (jQuery(this).text() == 'Blue'); //To select Blue
		}).prop('selected', true);*/

	}); 

	jQuery('#wc_quick_buy_form').parsley();

	jQuery('#wc_quick_buy_form').submit(function() {
	
			var thisForm = jQuery(this);
			var qb_button = thisForm.find('.wc_quick_buy_place_order');
		
			qb_button.attr('disabled','disable');

			jQuery('#ajax_loader').show();

			var action = thisForm.attr('action');

			jQuery.ajax({
				url : action,
				method : 'POST',
				data : thisForm.serializeArray(),
				dataType : 'json',
				success : function(response) {
	                if ( response.success == true) {

	                	jQuery('#ajax_loader').hide();
						jQuery('#ajax_message .inside').empty().html(response.message);
						window.location.href = response.url;
	            
					} else {
						
						qb_button.removeAttr('disabled');
						jQuery('#ajax_loader').hide();
						jQuery('#ajax_message .inside').empty().html(response.message);
						jQuery('#ajax_message').show().delay(3000).fadeOut('slow');
						
					}
				
				}
			});

			return false;
	});



    
});