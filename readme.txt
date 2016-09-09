=== WooCommerce Quick Buy Order ===
Contributors: baqir farooq
Author URI: http://baqirmemon.github.io/
Plugin URL: https://wordpress.org/plugins/woocommerce-quick-buy-order/
Tags: Woocommerce,wc,Quick buy,add to cart,affiliate, cart, checkout, commerce, configurable, digital, order, download, downloadable, e-commerce, ecommerce, inventory, reports, sales, sell, shipping, shop, shopping, stock, store, tax, variable, widgets, woothemes, wordpress ecommerce
Requires at least: 3.0
Tested up to: 5.0
WC requires at least: 2.0
WC tested up to: 2.7
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Add Quick buy order form in woocommerce product single page and other page by product id. 

== Description ==
Add Quick buy form to pace order with simple checkout form
When User fill the form, place order and then redirect to thankyou page and admin can receive order in woocommerce orders.

***Now we support language translation. if you are intreasted.

[twitter https://twitter.com/baqirmemon]

**Settings Available Under**
`Woocommerce Settings ==> Products ==> WC Quick Buy Order Form`

**Available Shortcodes**
<code>
1. [wc_quick_buy_form] -- Used in product single page to show order form
2. [wc_quick_buy] -- Used in product loop eg : Product Listing / Single Product Page
3. [wc_quick_buy_link] -- Can be used anywhere 
</code>

**`[wc_quick_buy_form]` Shortcode Args**
<code>
1. product : product id to generate quick buy order form Eg : [wc_quick_buy_form product="22"]
1. button : product id to generate quick buy button Eg : [wc_quick_buy product="22"]
2. label : custom text for generated button Eg : [wc_quick_buy label="Hurry Up!!"]
</code>



= Plugin Contributers =
* <a href="https://twitter.com/baqirmemon" >Baqir farooq</a>


== Upgrade Notice ==
Please update the settings once you have updated the plugin. if not this plugin many not work.


== Screenshots ==
1. WC Quick Buy Order Form Settings
1. WC Quick Buy Settings
2. WC Quick Buy Settings
3. WC Quick Buy Settings
4. Product Listing View With Before AddToCart 
5. Product Listing View With After AddToCart 
6. Single Product View With Before AddToCart
7. Single Product View With After AddToCart
8. Single Product View With With To AddToCart
9. Single Product View With With To AddToCart
10. Shortcode Generator

== Installation ==

= Minimum Requirements =

* WordPress version 3.8 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater
* WooCommerce version 1.0 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install of WooCommerce Quick Buy Order, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "WooCommerce Quick Buy ORder" and click Search Plugins. Once you've found our plugin you can view details about it such as the the point release, rating and description. Most importantly of course, you can install it by simply clicking "Install Now"

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your Web Server via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

1. Installing alternatives:
 * via Admin Dashboard:
 * Go to 'Plugins > Add New', search for "WooCommerce Quick Buy Order", click "install"
 * OR via direct ZIP upload:
 * Upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
 * OR via FTP upload:
 * Upload `woocommerce-quick-buy` folder to the `/wp-content/plugins/` directory
 
2. Activate the plugin through the 'Plugins' menu in WordPress
3. For Settings Look at your `Woocommerce => Settings => Product => WC Quick Buy Order`

== Frequently Asked Questions ==

** How I Can Get Support For This Plugin**

* http://baqirmemon.github.io/
* https://wordpress.org/support/plugin/woocommerce-quick-buy-order 
* https://github.com/baqirmemon/woocommerce-quick-buy-order
* Email : bmconcepts@hotmail.com

**I have an idea for your plugin!**  
That's great. We are always open to your input, and we would like to add anything we think will be useful to a lot of people. Please send your comment/idea/issues to bmconcepts@hotmail.com

**I found a bug!**  
Oops. Please User github / WordPress to post bugs.  <a href="https://github.com/technofreaky/woocomerce-quick-buy/"> Open an Issue </a>

**How To Call This Plugin in a template File ?**  
This Plugin Can Be Called Using `<?php do_shortcode('[wc_quick_buy]') ?>` short code

**Where Are The Plugin Settings Available ?**
`Woo Commerce Settings ==> Products ==> WC Quick Buy Order`

**Where can I request new features**
Please open an issue at <a href="https://github.com/baqirmemon/woocommerce-quick-buy-order/> GitHub </a> and we will look into it


== Changelog ==

= 1.2 - 09/09/2016 =
* Create plugin.
