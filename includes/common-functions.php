<?php 
global $wc_quick_buy_settings_values;
$wc_quick_buy_settings_values = array();

if(!function_exists('wc_quick_buy_db_settings')){
	function wc_quick_buy_db_settings(){
		global $wc_quick_buy_settings_values;
		$wc_quick_buy_settings_values = array();
		$wc_quick_buy_settings_values['redirect'] = get_option(WCQB_DB.'redirect');
		$wc_quick_buy_settings_values['custom_redirect'] = get_option(WCQB_DB.'custom_redirect');
		$wc_quick_buy_settings_values['product_types'] = get_option(WCQB_DB.'product_types');
		$wc_quick_buy_settings_values['single_product_auto'] = get_option(WCQB_DB.'single_product_auto');
		$wc_quick_buy_settings_values['single_product_pos'] = get_option(WCQB_DB.'single_product_pos');
		$wc_quick_buy_settings_values['listing_page_auto'] = get_option(WCQB_DB.'listing_page_auto');
		$wc_quick_buy_settings_values['listing_page_pos'] = get_option(WCQB_DB.'listing_page_pos');
		$wc_quick_buy_settings_values['product_qty'] = get_option(WCQB_DB.'product_qty');
		$wc_quick_buy_settings_values['label'] = get_option(WCQB_DB.'label');
		$wc_quick_buy_settings_values['class'] = get_option(WCQB_DB.'class');
		$wc_quick_buy_settings_values['btn_css'] = get_option(WCQB_DB.'btn_css');	
		$wc_quick_buy_settings_values['sp_qb_form_heading'] = get_option(WCQB_DB.'sp_qb_form_heading');	
		$wc_quick_buy_settings_values['sp_qb_form_btn_text'] = get_option(WCQB_DB.'sp_qb_form_btn_text');	   	
	}
}

if(!function_exists('wc_qb_option')){
	function wc_qb_option($key = ''){
		global $wc_quick_buy_settings_values;
		if(isset($wc_quick_buy_settings_values[$key])){
			return $wc_quick_buy_settings_values[$key];
		}
		return false;
	}
}

/* Woocommerce Quick Buy Dropdown */
function wcqb_quantity_input($product) {

	 $defaults = array(
	  'input_name' => WCQB_DB.'quantity',
	  'input_value' => '1',
	  'max_value'  => apply_filters( 'woocommerce_quantity_input_max', '', $product ),
	  'min_value'  => apply_filters( 'woocommerce_quantity_input_min', '', $product ),
	  'step'   => apply_filters( 'woocommerce_quantity_input_step', '1', $product ),
	  'style'   => apply_filters( 'woocommerce_quantity_style', 'float:left; margin-right:10px;', $product )
	 );

	 if (!empty($defaults['min_value']))
	  $min = $defaults['min_value'];
	  else $min = 1;

	 if (!empty($defaults['max_value']))
	  $max = $defaults['max_value'];
	  else $max = 20;

	 if (!empty($defaults['step']))
	  $step = $defaults['step'];
	  else $step = 1;

	 $options = '';
	 for($count = $min;$count <= $max;$count = $count+$step){
	  $options .= '<option value="' . $count . '">' . $count . '</option>';
	 }

	 return '<select name="'.WCQB_DB.'quantity" id="'.WCQB_DB.'quantity" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="qty '.WCQB_DB.'quantity">' . $options . '</select>';
}


add_action('wp_ajax_create_wc_quick_buy', 'prefix_ajax_create_wc_quick_buy');
add_action('wp_ajax_nopriv_create_wc_quick_buy', 'prefix_ajax_create_wc_quick_buy');
function prefix_ajax_create_wc_quick_buy()
{

  $nonce = $_POST['wc_quick_buy_nonce'];


  if ( ! wp_verify_nonce( $nonce, 'wc_quick_buy_action' ) ) {

     $response = json_encode(['success'=>false, 'message'=>'Error Accured']);

  } else {

 	  $quantity   = $_POST[WCQB_DB.'quantity']; //quantity
      $name 	  = explode(' ', ucwords($_POST[WCQB_DB.'name'])); //fullname
      $email      = $_POST[WCQB_DB.'email']; //email
      $phone      = $_POST[WCQB_DB.'mobile']; //mobile number
      $address  = $_POST[WCQB_DB.'address']; //address
      $city       = $_POST[WCQB_DB.'city']; //city
	    $country    = 'Pakistan'; //country name
      $product_id = trim($_POST[WCQB_DB.'product_id']); // woocommerce product id
      $payment_method = 'cod'; // default payment method COD
      $payment_method_title = 'Cash on delivery';
      $order_type = 'quick_buy'; // order type local

      $address = array(
        'first_name' => $name[0],
        'last_name'  => $name[1],
        'email'      => $email,
        'phone'      => $mobile,
        'address_1'  => $address,
        'address_2'  => '', 
        'city'       => $city,
        'state'      => '',
        'postcode'   => '',
        'country'    => $country 
      );




      $current_user = wp_get_current_user(); //get login user
      
      $user_id = ($current_user) ? $current_user->ID : 1;

      $product = wc_get_product($product_id); //get woocommerce product
      if( $product ) {
        
          $sale_price = $product->get_price();
          $discount   = 0;

          // Here we calculate the final price with the discount
          $sub_total = $quantity*$sale_price;
          $final_price = round($sub_total * ((100-$discount) / 100), 2);


          // Create the price params that will be passed with add_product(), if you have taxes you will need to calculate them here too
          $price_params = array( 'totals' => array( 'subtotal' =>  $sale_price, 'total' => $sub_total ) );

          $default_args = array(
            'status'        => '',
            'customer_id'   => $user_id,
            'customer_note' => 'Order place by Mr.'.$_POST['name'],
            'order_id'      => 0,
            'created_via'   => '',
            'cart_hash'     => '',
            'parent'        => 0,
          );

          $args       = wp_parse_args( $args, $default_args );
          $order_data = array();
      
          $order_data['post_type']     = 'shop_order';
          $order_data['post_status']   = 'wc-' . apply_filters( 'woocommerce_default_order_status', 'pending' );
          $order_data['ping_status']   = 'closed';
          $order_data['post_author']   = ($current_user) ? $current_user->ID : 1;
          $order_data['post_password'] = uniqid( 'order_' );
          $order_data['post_title']    = sprintf( __( 'Order &ndash; %s', 'woocommerce' ), strftime( _x( '%b %d, %Y @ %I:%M %p', 'Order date parsed by strftime', 'woocommerce' ) ) );
          $order_data['post_parent']   = absint( $args['parent'] );


          
          if ( $args['status'] ) {
            if ( ! in_array( 'wc-' . $args['status'], array_keys( wc_get_order_statuses() ) ) ) {
              return new WP_Error( 'woocommerce_invalid_order_status', __( 'Invalid order status', 'woocommerce' ) );
            }
            $order_data['post_status']  = 'wc-' . $args['status'];
          }

          if ( ! is_null( $args['customer_note'] ) ) {
            $order_data['post_excerpt'] = $args['customer_note'];
          }

       
          $order_id = wp_insert_post( apply_filters( 'woocommerce_new_order_data', $order_data ), true );

          $shipping_class = get_term_by('slug', $product->get_shipping_class(), 'product_shipping_class');

          WC()->shipping->load_shipping_methods();

          $shipping_methods = WC()->shipping->get_shipping_methods();

          // I have some logic for selecting which shipping method to use; your use case will likely be different, so figure out the method you need and store it in $selected_shipping_method

          $selected_shipping_method = $shipping_methods['free_shipping'];

          $class_cost = $selected_shipping_method->get_option('class_cost_' . $shipping_class->term_id);

          if ( is_wp_error( $order_id ) ) {
           return $order_id;
          }

          if ( is_numeric( $args['customer_id'] ) ) {
             update_post_meta( $order_id, '_customer_user', $args['customer_id'] );
          }

          update_post_meta( $order_id, '_order_total', $final_price);
          update_post_meta( $order_id, '_order_key', 'wc_' . apply_filters( 'woocommerce_generate_order_key', uniqid( 'order_' ) ) );
          update_post_meta( $order_id, '_order_currency', get_woocommerce_currency() );
          update_post_meta( $order_id, '_prices_include_tax', get_option( 'woocommerce_prices_include_tax' ) );
          update_post_meta( $order_id, '_customer_ip_address', WC_Geolocation::get_ip_address() );
          update_post_meta( $order_id, '_customer_user_agent', isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '' );
          update_post_meta( $order_id, '_customer_user', 0 );
          update_post_meta( $order_id, '_created_via', sanitize_text_field( $args['created_via'] ) );
          update_post_meta( $order_id, '_cart_hash', sanitize_text_field( $args['cart_hash'] ) );
          update_post_meta( $order_id, '_payment_method', $payment_method );
          update_post_meta( $order_id, '_payment_method_title', $payment_method_title );
          update_post_meta( $order_id, '_order_version', WC_VERSION );
          update_post_meta( $order_id, '_order_type_local', $order_type );
           
          $order = wc_get_order( $order_id );

          // add product
          $order->add_product($product, $quantity);
          $order->set_address( $address, 'billing' );
          $order->set_address( $address, 'shipping' );

          // $order->add_coupon( $code, ($discount/100) ); // not pennies (use dollars amount)

          // $order->set_total( ($discount/100) , 'order_discount'); // not pennies (use dollar amount)
          $order->set_total($final_price); // not pennies (use amount)
          $order->add_shipping(array (
              'id'       => $selected_shipping_method->id,
              'label'    => $selected_shipping_method->title,
              'cost'     => (float)$class_cost,
              'taxes'    => array(),
              'calc_tax' => 'per_order'
          ));

          // $order->calculate_totals();
           $return_url = WC_Gateway_COD::get_return_url( $order );
          // wp_set_object_terms( $order_id, 'completed', 'shop_order_status' );        

          do_action( 'woocommerce_new_order', $order_id );

          $response = json_encode([
            'success'=>true, 
            'message'=>'Your order has been Submitted Successfully!', 
            'orderId' => $order_id, 
            'url'=> $return_url
          ]);

      } else {
 
           $response = json_encode(['success'=>false, 'message'=>'Product Not Found']);

      }
           
  }
  echo $response;

  die();



}

/**
 * Display Metabox Order Type on order admin page
 **/

add_action( 'add_meta_boxes', 'order_type_add_meta_boxes' );

function order_type_add_meta_boxes(){

    add_meta_box(
        'woocommerce-order-my-custom',
        __( 'Order Type' ),
        'order_my_custom',
        'shop_order',
        'side',
        'default'
    );

}

function order_my_custom( $post ){
    
    $type = get_post_meta( $post->ID, '_order_type_local', true );

    wp_nonce_field( 'save_order_local_type', 'order_type_nonce' );

    woocommerce_wp_select( array( 'id' => 'order_type_service', 'label' => __('Order Type: ', 'woocommerce'), 'options' => array(

            'cart'             => __('Cart', 'woocommerce'),
            'whatsapp'         => __('WhatsApp', 'woocommerce'),
            'quick_buy'        => __('Quick Buy', 'woocommerce'),
            'wishlist'         => __('Wishlist', 'woocommerce'),
            'order'            => __('Normal', 'woocommerce'),
            'later'            => __('Later', 'woocommerce'),
            'admin'            => __('Admin', 'woocommerce'),
            'sms'              => __('SMS', 'woocommerce'),
            'viber'            => __('Viber', 'woocommerce'),
            'facebook'         => __('Facebook', 'woocommerce'),
            'instagram'        => __('Instagram', 'woocommerce'),
            'skype'            => __('Skype', 'woocommerce'),
            'line'             => __('Line', 'woocommerce'),
            'imo'              => __('IMO', 'woocommerce'),


    ) ) );
    woocommerce_wp_text_input( array( 'id' => 'order_type_local_link', 'class' => '','label' => __('Instructions: ', 'woocommerce') ) );

}

/**
 * Save Shipping Tracking information
 **/

add_action( 'save_post', 'save_order_local_type' );

function save_order_local_type( $post_id ) {

    // Check if nonce is set
    if ( ! isset( $_POST['order_type_nonce'] ) ) {
        return $post_id;
    }

    if ( ! wp_verify_nonce( $_POST['order_type_nonce'], 'save_order_local_type' ) ) {
        return $post_id;
    }

    // Check that the logged in user has permission to edit this post
    if ( ! current_user_can( 'edit_post' ) ) {
        return $post_id;
    }

    $type = sanitize_text_field( $_POST['order_type_service'] );
    update_post_meta( $post_id, '_order_type_local', $type );
}