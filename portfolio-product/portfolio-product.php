<?php
/*
Plugin Name: WC PPT
Plugin URI: http://wooxperto.com/
Description: This plugin for every WC WordPress theme. WC PPT (Woocommerce Portfolio Product Type) is the fastest, fully customizable & beautiful plugin suitable for business websites. # Designed, Developed, Maintained & Supported by wooXperto.
Version: 1.0.0
Author: wooXperto
Author URI: https://www.linkedin.com/in/wooXperto/
License: 564.505
Text Domain: wc-portfolio-product-type
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

// ######## >>>> Define wcProductType plugin <<<< ########
define( 'WCPPT_ACC_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
define( 'WCPPT_ACC_PATH', plugin_dir_path( __FILE__ ) );
define( 'WCPPT_PLUGIN_VERSION', '1.0.0' );

// #1 Add New Product Type to Select Dropdown
add_filter( 'product_type_selector', 'woo_xperto_add_wc_ppt_product_type' );
function woo_xperto_add_wc_ppt_product_type( $types ){
    $types[ 'wc_ppt' ] = 'Portfolio Product';
    return $types;
}
  
// --------------------------
// #2 Add New Product Type Class
add_action( 'init', 'woo_xperto_create_wc_ppt_product_type' );
function woo_xperto_create_wc_ppt_product_type(){
    class WC_Product_Wc_Ppt extends WC_Product { // capital letter
      public function get_type() {
         return 'wc_ppt';
      }
    }
}
  
// --------------------------
// #3 Load New Product Type Class
add_filter( 'woocommerce_product_class', 'woo_xperto_woocommerce_product_class', 10, 2 );
function woo_xperto_woocommerce_product_class( $classname, $product_type ) {
    if ( $product_type == 'wc_ppt' ) {
        $classname = 'WC_Product_Wc_Ppt'; // capital letter
    }
    return $classname;
}
 
// --------------------------
// #4 Show Product Data General Tab Prices
add_action( 'woocommerce_product_options_general_product_data', 'woo_xperto_wc_ppt_product_type_show_price' );
function woo_xperto_wc_ppt_product_type_show_price() {
    wc_enqueue_js( "
         jQuery('select#product-type').change(function(){
            let ptype = jQuery(this).val();
            if(ptype=='wc_ppt'){
                jQuery('.product_data_tabs .general_options').show();
                jQuery('.product_data_tabs .inventory_tab').show();
                jQuery('.product_data_tabs li.active').removeClass('active');
                jQuery('.product_data_tabs .general_options').addClass('active');
                jQuery('div.panel').hide();
                jQuery('div.panel.woocommerce_options_panel').hide();
                jQuery('div#general_product_data').show();
                jQuery('.pricing').show();
                jQuery('._sale_price_field').addClass('hide_if_wc_ppt').hide();
                jQuery('.product-data-wrapper .tips').show();
            }else{

                jQuery('._sale_price_field').removeClass('hide_if_wc_ppt').show();

            }
         });
    ");

    global $product_object;
    if ( $product_object && 'wc_ppt' === $product_object->get_type() ) {
        wc_enqueue_js("
            jQuery('.product_data_tabs .general_options').show();
            jQuery('.product_data_tabs .inventory_tab').show();
            jQuery('.product_data_tabs li.active').removeClass('active');
            jQuery('.product_data_tabs .general_options').addClass('active');
            jQuery('div.panel').hide();
            jQuery('div.panel.woocommerce_options_panel').hide();
            jQuery('div#general_product_data').show();
            jQuery('.pricing').show();
            jQuery('._sale_price_field').addClass('hide_if_wc_ppt').hide();
            jQuery('.product-data-wrapper .tips').show();
        ");
    }


}

// --------------------------
// #5 Show Add to Cart Button
add_action( "woocommerce_wc_ppt_add_to_cart", function() {
    do_action( 'woocommerce_simple_add_to_cart' );
});



add_action( 'wp_enqueue_scripts', 'add_wc_ppt_product_ajax_add_to_cart');
function add_wc_ppt_product_ajax_add_to_cart(){
    global $post;
    wp_register_script( 'woo-ajax-add-to-cart', plugin_dir_url(__FILE__) .'includes/woo-ajax-add-to-cart.min.js', array( 'jquery', 'wc-add-to-cart' ), WCPPT_PLUGIN_VERSION, true );

    if ( function_exists( 'is_product' ) && is_product() ) {
        $product = wc_get_product( $post->ID );

        $enabled = apply_filters( 'qlwcajax_product_enabled', '__return_true', $product );
        if ( ($product->is_type( 'wc_ppt' ) || $product->is_type( 'simple' ) || $product->is_type( 'variable' )) && $enabled ) {

            wp_enqueue_script( 'woo-ajax-add-to-cart' );

        }
    }
}
add_filter('woocommerce_loop_add_to_cart_link','change_wc_ppt_add_to_cart_link',10,3);
function change_wc_ppt_add_to_cart_link($add_to_cart_html,$product,$args){
    if($product->get_type()=='wc_ppt'){
        return sprintf(
            '<a href="%s" data-quantity="%s" class="%s ajax_add_to_cart" %s>%s</a>',
            esc_url( '?add-to-cart='.$product->get_id() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            'Buy Online'
        );
    }else{
        return $add_to_cart_html;
    }
}

