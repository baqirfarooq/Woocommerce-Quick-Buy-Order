<?php
/**
 * functionality of the plugin.
 *
 * @link       @TODO
 * @since      1.0
 *
 * @package    @TODO
 * @subpackage @TODO
 * @author     Baqir Farooq <bmconcepts@hotmail.com>
 */
if ( ! defined( 'WPINC' ) ) { die; }

class WooCommerce_Quick_Buy_Shortcode {
    /**
     * Class Constructor
     */
    public function __construct() {
        add_shortcode( 'wc_quick_buy', array($this,'add_quick_buy_button') );
		add_shortcode( 'wc_quick_buy_link', array($this,'quick_buy_link') );
		add_shortcode( 'wc_quick_buy_form', array($this,'quick_buy_form') );
    }
    
    public function add_quick_buy_button($attrs){
        $show_button = false;
        $output = '';
		global $product; 
        
        $attrs = shortcode_atts( array('label' => wc_qb_option('label'),'product' => null),  $attrs );
        
        if($attrs['product'] == null){
			global $product;
			$shortcode_product = $product;
		} else {
			$shortcode_product = wc_get_product($attrs['product']);
		}
        
        if(!$shortcode_product){return '';}
        
        
        if($shortcode_product->is_in_stock()){ $show_button = true; }
        if($show_button){ 
            $output = WooCommerce_Quick_Buy()->func()->generate_button(array('product' => $shortcode_product,'label' => $attrs['label'])); 
        }
        
		return $output;
    }

    public function quick_buy_form($attrs)
    {
	    $show_button = false;
        $output = '';
		global $product; 

        $attrs = shortcode_atts( array('label' => wc_qb_option('label'),'product' => null),  $attrs );
  
        if($attrs['product'] == null){
			global $product;
			$shortcode_product = $product;
		} else {
			$shortcode_product = wc_get_product($attrs['product']);
		}
        

      	  if(!$shortcode_product){return '';}
        
        
	        if($shortcode_product->is_in_stock()){ $show_button = true; }
	        if($show_button){ 
	            $output = WooCommerce_Quick_Buy()->func()->generate_button(array('product' => $shortcode_product,'label' => $attrs['label'])); 
	        }

    	   $current_user = wp_get_current_user();
		   $email =	($current_user) ? $current_user->user_email : '';
		   $user_name =	($current_user) ? $current_user->display_name : '';

           $output .= '<div class="box-wrapper">
			<div class="inside"><h3>'.wc_qb_option('sp_qb_form_heading').'</h3>
			<form action="'.admin_url('admin-ajax.php').'" name="'.WCQB_DB.'form" id="'.WCQB_DB.'form" data-parsley-validate>';
	   			
	   			$output .=  wp_nonce_field( 'wc_quick_buy_action', 'wc_quick_buy_nonce' );

	   			$output .= '
	   			<input type="hidden" name="action" id="action" class="form-control" value="create_wc_quick_buy">
				
				<input type="hidden" name="'.WCQB_DB.'product_id" id="'.WCQB_DB.'product_id" class="form-control" value="'.$product->id.'">

	            <p class="form-row form-row billing-first-name" id="billing_first_name_field"><label for="'.WCQB_DB.'name" class="">Full Name <abbr class="required" title="required">*</abbr></label><input type="text" data-parsley-required-message="Please enter your fullname" class="input-text " name="'.WCQB_DB.'name" id="'.WCQB_DB.'name" placeholder="Name" required  value="'.$user_name.'"></p>

	            <p class="form-row form-row form-row-first validate-email" id="billing_email_field"><label for="'.WCQB_DB.'email" class="">Email Address <abbr class="required" title="required">*</abbr></label><input type="email" class="input-text " name="'.WCQB_DB.'email" id="'.WCQB_DB.'email" placeholder="" data-parsley-required-message="Please enter your email" required autocomplete="email" value="'.$email.'"></p>

	            <p class="form-row form-row mask-mobile" id="billing_phone_field"><label for="'.WCQB_DB.'mobile" class="">Mobile Number <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text mask-mobile" name="'.WCQB_DB.'mobile" data-parsley-required-message="Please enter your mobile no." id="'.WCQB_DB.'mobile" required placeholder="Mobile Number" value=""></p>

	            <p class="form-row form-row mask-address" id="address_field"><label for="'.WCQB_DB.'address" class="">Address <abbr class="required" title="required">*</abbr></label><textarea  class="input-text " name="'.WCQB_DB.'address" id="'.WCQB_DB.'address" required placeholder="Address" data-parsley-required-message="Please enter your address" value=""></textarea></p>
				
		

	            <p class="form-row form-row mask-city" id="city_field"><label for="'.WCQB_DB.'city" class="">City <abbr class="required" title="required">*</abbr></label><input type="text" data-parsley-required-message="Please enter your city" class="input-text " name="'.WCQB_DB.'city" id="'.WCQB_DB.'city" placeholder="City" required value=""></p>

			

	            <p class="form-row form-row mask-quantity" id="quantity_field"><label for="'.WCQB_DB.'quantity" class="">Quantity <abbr class="required" title="required">*</abbr></label>'.wcqb_quantity_input($product).'</p>

				<div class="form-row place-order">

					<div class="wrapper"><button type="submit" class="button alt '.WCQB_DB.'place_order" name="'.WCQB_DB.'place_order" id="'.WCQB_DB.'place_order" value="">'.wc_qb_option('sp_qb_form_btn_text').'</button></div>
				
				</div>

			</form></div></div>';

			$output .= '<style>form#wc_quick_buy_form input,form#wc_quick_buy_form select,form#wc_quick_buy_form textarea{width:95%;margin:0!important}.parsley-errors-list li{padding:0;margin:0;color:red}select#wc_quick_buy_quantity{width:100%!important}.box-wrapper .inside{padding:20px}.box-wrapper{box-shadow:0 0 4px rgba(0,0,0,.27);border-radius:5px;position:relative;margin-bottom:20px;background-color:#FFF}</style>';
        
			return $output;
    }
	

	public function quick_buy_link($attrs){
		$output = '';
		$attrs = shortcode_atts( array(
			'product' => null,
			'qty' => wc_qb_option('product_qty'),
			'label' => wc_qb_option('label'),
			'type' => 'button',
            'htmlclass' => null,
		),  $attrs );
		
		if($attrs['product'] == null){
			global $product;
			$attrs['product'] = $product;
		} else {
			$attrs['product'] = wc_get_product($attrs['product']);
		}
		
		extract($attrs);
		
        if(!$product){return '';}
        
		if($type == 'link'){
			$output = WooCommerce_Quick_Buy()->func()->get_product_addtocartLink($product,$qty);
		} else if($type == 'button'){
			$args = array('product' => $product, 'label' => $label,'tag' => 'link','class' => $htmlclass );
			$output = WooCommerce_Quick_Buy()->func()->generate_button($args);
		}
		
		return $output;
	}




}

return new WooCommerce_Quick_Buy_Shortcode;