<?php
/**
 * Plugin Name: WooCommerce Gift Card Item
 * Description: Woocommerce Gift card system
 * Version: 1.0.0
 * textdomain: wc_gift_card
 */

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

class WC_Product_Pass_Gift_Card_Plugin {

    /**
     * Build the instance
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this,'wc_product_type_enqueue_script'));
        add_filter( 'product_type_options', array($this,'add_gift_card_product_option'));
        add_action( 'woocommerce_process_product_meta_simple',array($this, 'save_giftcard_option_fields' ) );
        add_action( 'woocommerce_product_options_pricing', array( $this, 'add_giftcard_pricing' ) );
        add_action( 'admin_footer', array( $this, 'enable_js_on_wc_product' ) );

        //add_filter( 'woocommerce_product_get_price', array($this,'custom_dynamic_regular_price'), 30, 2 );

        add_action( 'woocommerce_before_add_to_cart_quantity', array( $this, 'before_add_to_cart_qty' ),10 );

        add_filter( 'wc_get_template', array($this,'gift_card_modify_product_gallery_template'), 10, 5 );
        
    }
    
    public function wc_product_type_enqueue_script() {   
        wp_enqueue_style( 'wc_product_type_custom_css', plugin_dir_url( __FILE__ ) . 'assets/css/css.css?v='.time());
        wp_enqueue_script( 'wc_product_type_accounting_js_script', plugin_dir_url( __FILE__ ) . 'assets/js/accounting.js');
        wp_enqueue_style( 'jquery-uri-accordion-css', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', array('astra-theme-css'), '1.0.0', 'all' );
        wp_enqueue_script( 'jquery-accordion-js', 'https://code.jquery.com/jquery-3.6.0.js', array( 'jquery' ) );
        wp_enqueue_script( 'jquery-uri-accordion-js', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array( 'jquery' ) );
        wp_enqueue_script( 'wc_product_type_custom_script', plugin_dir_url( __FILE__ ) . 'assets/js/js.js?v='.time(),array('jquery'));
    }
    
    
    /**
     * Add 'Gift Card' product option
     */
    public function add_gift_card_product_option( $product_type_options ) {

        $product_type_options['gift_card'] = array(
            'id'            => '_gift_card',
            'wrapper_class' => 'show_if_simple',
            'label'         => __( 'Gift Card', 'wc_gift_card' ),
            'description'   => __( 'Gift Cards allow users to put in personalised messages.', 'wc_gift_card' ),
            'default'       => 'no'
        );

        return $product_type_options;

    }

    /**
     * Save the custom fields.
     */
    public function save_giftcard_option_fields( $post_id ) {
        
        $is_gift_card = isset( $_POST['_gift_card'] ) ? 'yes' : 'no';
        update_post_meta( $post_id, '_gift_card', $is_gift_card );

        $price = isset( $_POST['_giftcard_min_price'] ) ? sanitize_text_field( $_POST['_giftcard_min_price'] ) : '';
        update_post_meta( $post_id, '_giftcard_min_price', $price );
        
    }
    
    public function add_giftcard_pricing(){
        global $product_object;
        ?>
            <div id="_giftcard_min_price_box" class='options_group show_if_advanced'>
                <?php

                    woocommerce_wp_text_input(
                        array(
                            'id'          => '_giftcard_min_price',
                            'label'       => __( 'Giftcard min price ('.get_woocommerce_currency_symbol().')', 'wc_gift_card' ),
                            'value'       => $product_object->get_meta( '_giftcard_min_price', true ),
                            'default'     => '',
                            'placeholder' => 'Add pricing',
                            'data_type' => 'price',
                        )
                    );
                ?>
            </div>
		 
	    <?php
    }

    public function enable_js_on_wc_product() {
        global $post, $product_object;
  
        if ( ! $post ) { return; }
  
        if ( 'product' != $post->post_type ) :
          return;
        endif;
  
        $is_gift = false;
        if(($product_object && 'simple' === $product_object->get_type()) && get_post_meta($post->ID, '_gift_card',true)==='yes'){
            $is_gift=true;
        }
  
        ?>
        <script type='text/javascript'>
          jQuery(document).ready(function () {
              //alert("ok");
            //for Price tab
            jQuery('#_giftcard_min_price_box').hide();
  
            <?php if ( $is_gift ) { ?>
              jQuery('#_giftcard_min_price_box').show();
            <?php } ?>

            jQuery(document).change("input[name='_gift_card']",function(){
                
                if(jQuery("input[name='_gift_card']").is(":checked")){
                    
                    jQuery('#_giftcard_min_price_box').show();
                }else{
                    
                    jQuery('#_giftcard_min_price_box').hide();
                }
            })
           });
         </script>
         <?php
    }

    public function before_add_to_cart_qty(){
        global $post;
        $product=wc_get_product($post->ID);
        $is_gift=get_post_meta($post->ID,'_gift_card',true);
        $min_price=0;
        $currency=get_woocommerce_currency_symbol();
        if($is_gift=='yes'){
            $min_price=get_post_meta($post->ID,'_giftcard_min_price',true);
            if($min_price>0){
                
            }else{
                $min_price=$product->get_regular_price();
            }

            $default_image=plugin_dir_url( __FILE__ ).'assets/images/christmas-1.jpg';

            echo'<div id="price_area">
                <h2>Veldu mynd</h2>
                
                <div class="img_thumbnail">
                    <div class="tab">
                        <button type="button" class="tablinks active" onclick="openImgCat(event, \'Cat1\')">Almennt</button>
                        <button type="button" class="tablinks" onclick="openImgCat(event, \'Cat2\')">Afmæli</button>
                        <button type="button" class="tablinks" onclick="openImgCat(event, \'Cat3\')">Áramót</button>
                        <button type="button" class="tablinks" onclick="openImgCat(event, \'Cat4\')">Brúðkaup</button>
                        <button type="button" class="tablinks" onclick="openImgCat(event, \'Cat5\')">Ferming</button>
                        <button type="button" class="tablinks" onclick="openImgCat(event, \'Cat6\')">Útskrift</button>
                    </div>
                    <div id="Cat1" class="tabcontent" style="display: block;">
                        <ul>
                            <li>
                                <img class="active" onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_1_1.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_1_2.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_1_3.jpg" width="60">
                            </li>
                        </ul>
                    </div>
                    <div id="Cat2" class="tabcontent">
                        <ul>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_1.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_2.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_3.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_4.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_5.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_6.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_7.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_2_8.jpg" width="60">
                            </li>
                        </ul>
                    </div>
                    <div id="Cat3" class="tabcontent">
                        <ul>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_3_1.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_3_2.jpg" width="60">
                            </li>
                        </ul>
                    </div>
                    <div id="Cat4" class="tabcontent">
                        <ul>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_4_1.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_4_2.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_4_3.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_4_4.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_4_5.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_4_6.jpg" width="60">
                            </li>
                        </ul>
                    </div>
                    <div id="Cat5" class="tabcontent">
                        <ul>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_5_1.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_5_2.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_5_3.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_5_4.jpg" width="60">
                            </li>
                        </ul>
                    </div>
                    <div id="Cat6" class="tabcontent">
                        <ul>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_6_1.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_6_2.jpg" width="60">
                            </li>
                            <li>
                                <img onclick="selectThisGiftCardImage(this)" data-class="image1" src="' . plugin_dir_url(__FILE__) . 'assets/images/cat_6_3.jpg" width="60">
                            </li>
                        </ul>
                    </div>
                </div>
                
                <input type="hidden" name="gift_card_image" value="'.$default_image.'">
                <h2>Velja upphæð</h2>
                
                <input type="hidden" name="gift_card_amount" value="'.$min_price.'">
                <div class="radio_btn">
                    <label><input class="gift_card_default_amount" onchange="giftCardDefaultPrice(this)" checked type="radio" name="gift_card_default_price" value="'.$min_price.'">'.wc_price($min_price).'</label>
                    ';
                for($i=2;$i<5;$i++){
                    $price=$min_price*$i;
                    echo'<label><input onchange="giftCardDefaultPrice(this)" type="radio" name="gift_card_default_price" value="'.$price.'">'.wc_price($price).'</label>';
                }
                echo'<label><input onchange="giftCardDefaultPrice(this)" type="radio" name="gift_card_default_price" value="30000">'.wc_price(30000).'</label>';
                echo'</div>';
                echo'<div class="pform_area">';
                echo'<div class="custom_price">';
                echo'<span class="currency">'.$currency.'</span>';
                echo'<input placeholder="Önnur upphæð?" type="text" name="custom_price" readonly data-min="'.$min_price.'" onclick="giftCardCustomPriceEnable(this)" onfocusout="giftCardCustomAmountFocus(this)" onkeyup="giftCardCustomPriceChange(this)">';
                echo'<div id="gift-card-amount-error" class="gift-card-amount-error"></div>';
                echo'</div>';

                echo'<h2>Upplýsingar um afhendingu</h2>
                    <div class="toggleDateDivClass" id="toggleDateDiv" class="form_row">
                        <div class="col_2">
                            <input class="ckBox" onchange="toggleDateDiv(this);" type="checkbox" >
                        </div>
                        <div class="col_4">
                            <h2 style="margin-top:4px;">Senda síðar</h2>
                        </div>
                    </div>
                    <div class="dateDivClass" id="dateDiv" style="display:none">
                        <p>Viðtakandi mun fá gjafakortið sent á þeim degi og tíma sem þú velur hér</p>
                        <div class="form_row">
                            <div class="col_4">
                                <div class="form_group">
                                    <label>Dagsetning:</label>
                                    <input type="date" id="dDate" name="gift_card_date" onchange="deliveryDate(this)" autocomplete="off">
                                </div>
                            </div>
                            <div class="col_4">
                                <div class="form_group">
                                    <label >Klukkustund:</label><br/>
                                    <select name="gift_card_time_hour" id="gift_card_time_hour" class="form-select" aria-label="">';
                                    for($i=0;$i<24;$i++){
                                        echo'<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';
                                    }
                                    echo'</select>
                                </div>
                            </div>
                            <div class="col_4">
                                <div class="form_group">
                                    <label>Mínúta:</label><br/>
                                    <select name="gift_card_time_minute" id="gift_card_time_minute" class="form-select" aria-label="">';
                                        for($i=0;$i<60;$i++){
                                            echo'<option value="'.sprintf("%02d", $i).'">'.sprintf("%02d", $i).'</option>';
                                        }
                                    echo'</select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2>Upplýsingar um viðtakanda</h2>
					<div class="form_row">
						<div class="col_6">
							<div class="form_group">
								<label>Nafn: <span class="require">*</span></label>
								<input value="'.(isset($_POST["gift_card_recipient_name"])?$_POST["gift_card_recipient_name"]:'').'" autocomplete="off" type="text" name="gift_card_recipient_name" onkeyup="document.getElementById(\'gift_card_recipient_name_text\').innerHTML=this.value" required>
                                <span class="gift_card_recipient_name_span giftcardformError"></span>
							</div>						
						</div>
						<div class="col_6">
							<div class="form_group">
								<label>Netfang: <span class="require">*</span></label>
								<input value="'.(isset($_POST["gift_card_recipient_email"])?$_POST["gift_card_recipient_email"]:'').'" autocomplete="off" type="text" name="gift_card_recipient_email" required>
                                <span class="gift_card_recipient_email_span giftcardformError"></span>
							</div>					
						</div>
					</div>
                    <div class="form_row" id="">
                        <div class="col_6">
                            <div class="form_group">
                                <label>Símanúmer: <span class="require requirePhone">*</span></label>
                                <input value="'.(isset($_POST["gift_card_phone"])?$_POST["gift_card_phone"]:'').'" autocomplete="off" type="text" name="gift_card_phone" maxlength="7" minlength="7" required>
                                <span class="gift_card_phone_span giftcardformError"></span>
                            </div>
                        </div>
                    </div>
                    <p style="margin-top:5px;margin-bottom:10px">Viðtakandi fær gjafakortið sent í tölvupósti og/eða SMS. Ef þú vilt prenta gjafakortið út sjálf/ur skaltu skrá þitt netfang sem viðtakanda og þá færðu PDF gjafakort sent tilbúið til prentunar</p>
                    <div class="form_group">
                        <label>Skilaboð sem birtast á gjafabréf og í SMS:</label>
                        <textarea rows="3" name="gift_card_custome_message" onkeyup="giftCardMessagePreview(this)">'.(isset($_POST["gift_card_custome_message"])?$_POST["gift_card_custome_message"]:'').'</textarea>
                    </div>
                    <h2>Upplýsingar um þig</h2>
                    <p>Mikilvægt að setja nafn þitt hér svo að viðtakandi viti frá hverjum gjöfin er.</p>
                    <div class="form_group name_field">
                        <label>Nafn: <span class="require">*</span></label>
                        <input value="'.(isset($_POST["gift_card_sender_name"])?$_POST["gift_card_sender_name"]:'').'" autocomplete="off" type="text" name="gift_card_sender_name" onkeyup="document.getElementById(\'gift_card_recipient_email_text\').innerHTML=this.value" required>
                        <span class="gift_card_sender_name_span giftcardformError"></span>
                    </div>
                    <div class="form_group radio-buttob-form">
                        <label><input type="radio" name="send_mail_to_recipient" value="1"> Sendu tölvupóst til viðtakanda </label>
                        <label><input type="radio" name="send_mail_to_recipient" value="2"> Sendu sms til viðtakanda </label>
                        <label><input type="radio" name="send_mail_to_recipient" value="3" checked> Sendu sms & tölvupóst til viðtakanda</label>
                    </div>
                    <input type="hidden" name="product_id" value="'.$post->ID.'"/>

                </div>
            </div>';


        }
        
        
    }


    
    public function custom_dynamic_regular_price( $price, $product ) {
        $id=$product->get_id();
        $is_gift=get_post_meta($id,'_gift_card',true);
        $min_price=0;
        if($is_gift=='yes'){
            $min_price=get_post_meta($id,'_giftcard_min_price',true);
            if($min_price>0){
                return $regular_price=$min_price;
            }
        }else{
            return $product->get_regular_price();
        }
    }

    public function gift_card_modify_product_gallery_template( $located, $template_name, $args, $template_path, $default_path ){
        global $post;
        $is_gift=get_post_meta($post->ID,'_gift_card',true);
        if($is_gift=='yes'){
            if ( 'single-product/product-image.php' == $template_name ) {
                $located = $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/product-image.php';
            }
            
        }
        return $located;
    }
}

new WC_Product_Pass_Gift_Card_Plugin();



// test add to cart
function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

// Example


add_action('init',function(){
    if(isset($_POST["add-to-cart"]) && 1==2){
        $product_id = $_POST['add-to-cart']; //This is product ID
        if(get_post_meta($product_id, '_gift_card',true)==='yes'){
            $gift_card_time = $_POST["gift_card_time_hour"].':'.$_POST["gift_card_time_minute"];
            $gift_card_item_add_to_cart_meta=array(
                'gift_card_image'=>$_POST["gift_card_image"],
                'gift_card_amount'=>$_POST["gift_card_amount"],
                'gift_card_date'=>(empty($_POST["gift_card_date"])?date('d/m/Y'):$_POST["gift_card_date"]),
                'gift_card_time'=>$gift_card_time,
                'gift_card_recipient_name'=>$_POST["gift_card_recipient_name"],
                'gift_card_recipient_email'=>$_POST["gift_card_recipient_email"],
                'gift_card_phone'=>$_POST["gift_card_phone"],
                'gift_card_sender_name'=>$_POST["gift_card_sender_name"],
                'gift_card_custome_message'=>$_POST["gift_card_custome_message"],
                'send_mail_to_recipient'=>(isset($_POST["send_mail_to_recipient"])?$_POST["send_mail_to_recipient"]:0),

            );
            if ( is_session_started() === FALSE ) session_start();
            $_SESSION['lb_gift_card_add_to_cart_'.$product_id] = $gift_card_item_add_to_cart_meta;
        }
    }
});


add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',1,2);
 
if(!function_exists('wdm_add_item_data'))
{
    function wdm_add_item_data($cart_item_data,$product_id)
    {
        $unique_cart_item_key = md5( microtime().rand() );
        $cart_item_data['unique_key'] = $unique_cart_item_key;

        
        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
        global $woocommerce;
        $option='';
        if ( is_session_started() === FALSE ) session_start(); 
        if (isset($_SESSION['lb_gift_card_add_to_cart_'.$product_id])) {
            $option = $_SESSION['lb_gift_card_add_to_cart_'.$product_id];  
            unset($_SESSION['lb_gift_card_add_to_cart_'.$product_id]);    
            $new_value = array('wdm_user_custom_data_value' => $option);
            
        }
        if(empty($option))
            return $cart_item_data;
        else
        {    
            if(empty($cart_item_data)){
                return $new_value;
            }else{
                return array_merge($cart_item_data,$new_value);
            } 
        }
        
        //Unset our custom session variable, as it is no longer needed.
        
    }
}


add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 1, 3 );
if(!function_exists('wdm_get_cart_items_from_session'))
{
    function wdm_get_cart_items_from_session($item,$values,$key)
    {
        if (array_key_exists( 'wdm_user_custom_data_value', $values ) )
        {
            $item['wdm_user_custom_data_value'] = $values['wdm_user_custom_data_value'];
        }       
        return $item;
    }
}


add_filter('woocommerce_checkout_cart_item_quantity','wdm_add_user_custom_option_from_session_into_cart',1,3);  
add_filter('woocommerce_cart_item_price','wdm_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('wdm_add_user_custom_option_from_session_into_cart'))
{
 function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
        if(isset($values['wdm_user_custom_data_value'])){
            /*code to add custom data on Cart & checkout Page*/    
            if(count($values['wdm_user_custom_data_value']) > 0)
            {
                $return_string = $product_name ;
                $return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
                $return_string .= "<tr><td>Nafn viðtakanda: " . $values['wdm_user_custom_data_value']['gift_card_recipient_name'] . "</td></tr>";
                $return_string .= "<tr><td>Netfang viðtakanda: " . $values['wdm_user_custom_data_value']['gift_card_recipient_email'] . "</td></tr>";
                $return_string .= "<tr><td>Símanúmer: " . $values['wdm_user_custom_data_value']['gift_card_phone'] . "</td></tr>";
                $return_string .= "<tr><td>Nafn sendanda: " . $values['wdm_user_custom_data_value']['gift_card_sender_name'] . "</td></tr>";
                $return_string .= "<tr><td>Skilaboð: " . $values['wdm_user_custom_data_value']['gift_card_custome_message'] . "</td></tr>";
                $return_string .= "<tr><td>Dagsetning: " . $values['wdm_user_custom_data_value']['gift_card_date'] . " @ " . $values['wdm_user_custom_data_value']['gift_card_time'] . "</td></tr>";

                $return_string .= "</table>"; 
                return $return_string;
            }
            else
            {
                return $product_name;
            }
        }else{
            return $product_name;
        }
    }
}

// modify cart item image

add_filter( 'woocommerce_cart_item_thumbnail', 'wc_pro_cust_field_modify_cart_item_thumbnail',99,3);//$_product->get_image(), $cart_item, $cart_item_key );

function wc_pro_cust_field_modify_cart_item_thumbnail($product_image,$cart_item,$cart_item_key){

    if(isset($cart_item["wdm_user_custom_data_value"])){
        $product_image='<img src="'.$cart_item["wdm_user_custom_data_value"]["gift_card_image"].'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" loading="lazy" width="300" height="300">';
    }

    return $product_image;
}


add_action('woocommerce_before_cart_item_quantity_zero','wdm_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('wdm_remove_user_custom_data_options_from_cart'))
{
    function wdm_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values)
        {
        if ( $values['wdm_user_custom_data_value'] == $cart_item_key )
            unset( $woocommerce->cart->cart_contents[ $key ] );
        }
    }
}

add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
  function wdm_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb;
        $user_custom_values = $values['wdm_user_custom_data_value'];
        if(!empty($user_custom_values))
        {
            wc_add_order_item_meta($item_id,'Dagsetning',$user_custom_values['gift_card_date']);  
            wc_add_order_item_meta($item_id,'Tími',$user_custom_values['gift_card_time']);  
            wc_add_order_item_meta($item_id,'Nafn viðtakanda',$user_custom_values['gift_card_recipient_name']);  
            wc_add_order_item_meta($item_id,'recipient_name',[$user_custom_values['gift_card_recipient_name']]);  
            wc_add_order_item_meta($item_id,'recipient_email',[$user_custom_values['gift_card_recipient_email']]);  
            wc_add_order_item_meta($item_id,'Netfang viðtakanda',$user_custom_values['gift_card_recipient_email']);  
            wc_add_order_item_meta($item_id,'Símanúmer',$user_custom_values['gift_card_phone']);  
            wc_add_order_item_meta($item_id,'Nafn sendanda',$user_custom_values['gift_card_sender_name']);  
            wc_add_order_item_meta($item_id,'Message',$user_custom_values['gift_card_custome_message']);  
            wc_add_order_item_meta($item_id,'photo_url',array($user_custom_values['gift_card_image']));  
            wc_add_order_item_meta($item_id,'send_mail_to_recipient',array($user_custom_values['send_mail_to_recipient']));  
        }
  }
}


// set name price / custom price to cart

add_filter('woocommerce_cart_contents_changed', function($cart_contents) {
    $new_contents = [];
    foreach ($cart_contents as $k => $cart_item) {
        if( isset( $cart_item["wdm_user_custom_data_value"] ) ) {   
            $price=$cart_item["wdm_user_custom_data_value"]["gift_card_amount"];    
            $cart_item['data']->set_price($price);
                   
        }

        $new_contents[$k] = $cart_item;    
    }
    return array_merge($cart_contents, $new_contents);
},30,1);


function gift_custom_remove_all_quantity_fields( $return, $product ) {
    $id=$product->get_id();
    $is_gift=get_post_meta($id,'_gift_card',true);
    if($is_gift=='yes'){
        return true;
    }else{
        return $return;
    }
}
add_filter( 'woocommerce_is_sold_individually','gift_custom_remove_all_quantity_fields', 10, 2 );

// show pdf download link in order success page
add_action('woocommerce_order_item_meta_end','gift_item_pdf_download_link',10,3);
function gift_item_pdf_download_link($item_id, $item, $order){
    //print_r($item);
    $product_id = $item->get_product_id(); 
    if(get_post_meta($product_id, '_gift_card',true)==='yes'){
        echo'<a style="clear:both;display:block;" target="_blank" href="'.site_url().'?gift-card-pdf=true&gcpdf='.base64_encode($item_id).'" class="gift-card-pdf-download-link home-back">Sækja gjafakort</a>';
    }
    
}

// show pdf download in admin order page
add_action('woocommerce_after_order_itemmeta','admin_gift_item_pdf_download_link',10,3);
function admin_gift_item_pdf_download_link($item_id, $item, $product){
    
    $product_id = $item->get_product_id(); 
    if(get_post_meta($product_id, '_gift_card',true)==='yes'){
        echo'<a style="clear:both;display:block;" target="_blank" href="'.site_url().'?gift-card-pdf=true&gcpdf='.base64_encode($item_id).'" class="gift-card-pdf-download-link home-back">Sækja gjafakort</a>';
    }
    
}

// show custom gift card image at admin order detail page
add_filter('woocommerce_admin_order_item_thumbnail','gift_card_item_custom_thumbnail',10,3);
function gift_card_item_custom_thumbnail($product_get_image_thumbnail_array_title_false,  $item_id,  $item){
    $product_id = $item->get_product_id(); 
    if(get_post_meta($product_id, '_gift_card',true)==='yes'){
        $order_id = $item->get_order_id(); 
        $custome_image=wc_get_order_item_meta( $item_id, 'photo_url', true);

        $product_get_image_thumbnail_array_title_false='<img src="'.$custome_image[0].'" class="attachment-thumbnail size-thumbnail" alt="" loading="lazy" title="" width="150" height="150">';
    }
    return $product_get_image_thumbnail_array_title_false;
}

add_action('init',function(){
    if(isset($_GET["gift-card-pdf"]) && isset($_GET["gcpdf"])){
        if($_GET["gift-card-pdf"]=='true' && !empty($_GET["gcpdf"]) && base64_decode($_GET["gcpdf"])>0){
            $orderLineItemId=base64_decode($_GET["gcpdf"]);
            $link='aaa';
            //$output=true;
            include('gift-card-pdf.php');
        }
    }
});


function create_gift_to_wallet_entry($amount,$email,$name,$product_id,$item_id,$city,$post_code){

    $current_date=strtotime(date('d-m-Y'));
    $expiry_date=date('d-m-Y', strtotime('+2 years',$current_date));
    $brand='Gjafakort';
    // generate token
   
    /* Live part
    $token = get_option('gift_to_wallet_token');


    if($token){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.gifttowallet.com/api/card/bulkgenerate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'number_of_cards' => '1',
                'card_number_length' => '8',
                'card_number_format' => 'Numeric',
                'card_brand_name' => ''.$brand.'',
                'initial_balance' => ''.$amount.'',
                'current_balance' => ''.$amount.'',
                'expiry_date' => ''.$expiry_date.''
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token.''
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response=json_decode($response);
        if($response->status==1){
            
            $card=$response->result->cards;
            
            // update card info
            $phone=wc_get_order_item_meta( $item_id, 'Símanúmer', true);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://admin.gifttowallet.com/api/card/update-detail',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('card_number' => $card,'phone' => $phone,'email' => $email,'name' => $name),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$token.''
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            
            // create pass
            $expiry_date=str_replace("-", ".", $expiry_date);
            $template='ef6bc780-2797-491e-9823-83d1006bf459';
            create_card_pass($product_id,$name,$email,$template,$item_id,$card,$city,$post_code,$amount);
        }
    }// end token checking
    */

    // Test part
    $expiry_date=str_replace("-", ".", $expiry_date);
    $template='5c97cd8e-ca16-4de5-a61d-f73a9027ced5';
    $card=uniqid();
    create_card_pass($product_id,$name,$email,$template,$item_id,$card,$city,$post_code,$amount);
}

function create_card_pass($product_id,$name,$email,$template,$item_id,$card,$city,$post_code,$initial_amount){

    $initial_amount=number_format($initial_amount, 0, ',', '.');
    
	$curl = curl_init();
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://app.passcreator.com/api/pass?passtemplate='.$template.'&zapierStyle=false',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
		
		"passBackFields": [],
		"additionalProperties": {"6330398c2f5ec6.08160392":"'.$city.'","6148846f9a2e01.86392371":"'.$post_code.'","6148846f9a32a5.27847319":"'.$card.'","6148846f9a32d2.20923328":"'.$name.'","636a61d912c1a8.09853505":"'.$initial_amount.'","636a61d912c251.17724195":"'.$initial_amount.'"}
		
	}',
	  CURLOPT_HTTPHEADER => array(
		'Authorization: .pIhJs9w5vaMSirNHFItAMea7I.8YFLx_Z=pfG=UwkPvPJWzkBySiN1BgncESpzJ.v5QXGYC47Tn9HBY',
		'Content-Type: application/json'
	  ),
	));
	
	$response = curl_exec($curl);
	
	curl_close($curl);
	$apiResp = json_decode($response);

	global $wpdb;
	$passi_id=$apiResp->identifier;
	// insert data into database   
	$table_name = $wpdb->prefix . 'pass';     
	$wpdb->insert($table_name, array('name' => $name, 'email' => $email, 'card_number' => $card,
        'passi_id'=>$passi_id,'template'=>$template,
        'city'=>$city,
        'post_code'=>$post_code,
        'initial_amount'=>$initial_amount,
        'current_amount'=>$initial_amount,
        'status'=>1
    ));
	

    wc_add_order_item_meta($item_id,'giftcard_no',$card);
    wc_add_order_item_meta($item_id,'pass_link',$apiResp->linkToPassPage);
    wc_add_order_item_meta($item_id,'pass__identity',$passi_id);


}


function send_mail_to_user($name,$email,$url,$gift_card_new_mail=0,$attachment=false){
		
    $subject='Til hamingju með gjafakortið þitt!';
    
    $body='Kæri/kæra '.$name.'<br/><br/>
        Til hamingju með gjafakortið þitt!<br/><br/>
        Smelltu á hlekkinn til að sækja og setja gjafakortið í símann þinn ef þú hefur ekki nú þegar sótt það. Það tekur innan við eina mínútu OG þú getur sett sama kortið í fleiri en einn síma.<br/><br/>
        <a href="'.$url.'">'.$url.'</a><br/><br/>
        Hægt er að nálgast allar upplýsingar um staðinn sem kortið virkar hjá á <a href="https://byko.is/">www.byko.is</a><br/><br/>
        Einnig er hægt að prenta út meðfylgjandi gjafakort og greiða með því án þess að setja í símann.
        <br/></br><br/>Kveðja,<br/>
        BYKO';

    $to = $email;
    $headers = array('Content-Type: text/html;'); //  charset=UTF-8

    wp_mail( $to, $subject, $body, $headers,$attachment );

    //wh_log($name.' I am from send mail to user '.$to.' '.$url);
    
}


add_action( 'woocommerce_admin_order_data_after_order_details', 'wp_w1d_woocommerce_admin_order_data_after_details_action' );
function wp_w1d_woocommerce_admin_order_data_after_details_action( $order ){
	$orderid=$order->get_id();
    $show=false;
    $order_items = $order->get_items();
    foreach( $order_items as $item_id => $order_item ) {
        $product_id=$order_item->get_product_id(); 
        if(get_post_meta($product_id, '_gift_card',true)==='yes'){
            $gift_card=wc_get_order_item_meta($item_id,'giftcard_no',true);
            if($gift_card!=null){

            }else{
                $show=true;
                break;
            }
        }
    }

    if($show){
        echo'<a style="margin-top:20px;" href="/wp-admin/post.php?post='.$orderid.'&action=edit&gererate=true" class="btn btn-primary button button-primary">Generate Missing Card & Pass</a>';
    }
}

add_action('init',function(){
    if(is_admin()){
        if(isset($_GET["gererate"]) && isset($_GET["action"]) && isset($_GET["post"])){
            if(!empty($_GET["post"]) && !empty($_GET["gererate"])){
                gift_item_order_payment_complete( $_GET["post"] );
            }
        }
    }
});

add_action( 'woocommerce_payment_complete', 'gift_item_order_payment_complete' );

function gift_item_order_payment_complete( $order_id ) {
	global $wpdb;
	$order = wc_get_order( $order_id );
	$name=$order->get_billing_first_name();
    $email=$order->get_billing_email();
    $city=$order->get_billing_city();
    $post_code=$order->get_billing_postcode();
    $entryType = 'plastkort';
    $cardType = 'Gjafakort';
    $type=1;

	$order_items = $order->get_items();
    $makeOrderCompleted=false;
    $x=0;
	if ( !is_wp_error( $order_items ) ) {
        
		foreach( $order_items as $item_id => $order_item ) {
			// for products only:
			$product_id=$order_item->get_product_id(); 
            if(get_post_meta($product_id, '_gift_card',true)==='yes'){

                if(wc_get_order_item_meta($item_id,'giftcard_no',true)!=null){
                    continue;
                }
                // create gift card pos entry & create pass
                $giftAmount = $order_item->get_total();

                // email send to Netfang viðtakanda
                $recepient_email=wc_get_order_item_meta( $item_id, 'recipient_email', true)[0];
                $recepient_name=wc_get_order_item_meta( $item_id, 'recipient_name', true)[0];
                $send_mail_to_recipient=wc_get_order_item_meta( $item_id, 'send_mail_to_recipient', true)[0];
                $send_sms_to_recipient_phone=wc_get_order_item_meta( $item_id, 'Símanúmer', true);
                // process after gift card created at gift to wallet system
                create_gift_to_wallet_entry($giftAmount,$recepient_email,$recepient_name,$product_id,$item_id,$city,$post_code); 

                // insert gift card email queue    
                $date_=wc_get_order_item_meta( $item_id, 'Dagsetning', true);
                $time_=wc_get_order_item_meta( $item_id, 'Tími', true);
	            $prefered_date_time=implode("-", array_reverse(explode("/", $date_))).' '.$time_;
                $table_name = $wpdb->prefix . 'gift_card_email_queue';
                $wpdb->insert($table_name, 
                    array(
                        'order_id'=>$order_id,
                        'order_line_item_id' => $item_id, 
                        'status' => 0,
                        'prefered_date_time' =>$prefered_date_time
                    )
                );

                $makeOrderCompleted=true;
            }

            $x++;
		} // end foreach
	}

    if($x==1 && $makeOrderCompleted){
        $order->update_status( 'completed' );
    }
}


add_filter ('add_to_cart_redirect', 'redirect_to_checkout');

function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}

function wh_log($log_msg)
{
    $log_filename = "log";
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/log_' . time() . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_single_page_add_to_cart_callback' ); 
function woocommerce_single_page_add_to_cart_callback() {
    return __( 'Áfram í greiðslumáta', 'woocommerce' ); 
}

// Hook before calculate fees
//add_action('woocommerce_cart_calculate_fees' , 'add_user_discounts');
function add_user_discounts( WC_Cart $cart ){
    //any of your rules
    // Calculate the amount to reduce
    $discount = $cart->get_subtotal() * 0.11;

    $cart->add_fee( 'Afsláttur 11%', -$discount);
}

// validate giftcard input on checkout
add_filter( 'woocommerce_add_to_cart_validation', 'validate_card_details_in_the_cart', 10, 2 );
function validate_card_details_in_the_cart( $passed, $product_id) {

    $is_gift_card = get_post_meta($product_id, '_gift_card', true );
    
    if($is_gift_card=='yes'){

        if(trim($_POST['gift_card_recipient_name'])==''){
            wc_add_notice( sprintf( 'nafn er krafist'), 'error' );
            $passed = false; // don't add the new product to the cart
        }
        if(trim($_POST['gift_card_recipient_email'])=='' || !is_email(trim($_POST['gift_card_recipient_email']))){
            wc_add_notice( sprintf( 'Netfang er krafist'), 'error' );
            $passed = false; // don't add the new product to the cart
        }
        if(trim($_POST['gift_card_phone'])=='' || strlen(trim($_POST['gift_card_phone']))!=7 || !is_numeric(trim($_POST['gift_card_phone']))){
            wc_add_notice( sprintf( 'Símanúmer er krafist'), 'error' );
            $passed = false; // don't add the new product to the cart
        }
        /*if(trim($_POST['gift_card_custome_message'])==''){
            wc_add_notice( sprintf( 'Skilaboð sem birtast á gjafabréf og í SMS er krafist'), 'error' );
            $passed = false; // don't add the new product to the cart
        }*/
        if(trim($_POST['gift_card_sender_name'])==''){
            wc_add_notice( sprintf( 'Nafn sendanda er krafist'), 'error' );
            $passed = false; // don't add the new product to the cart
        }
    }
    return $passed;
}


//multiple giftcard start
add_action( 'init', 'my_script_enqueuer' );

function my_script_enqueuer() {
   wp_register_script( "gift_card_add_to_cart_script", WP_PLUGIN_URL.'/gift-card-item/gift_card_add_to_cart_script.js', array('jquery') );
   wp_localize_script( 'gift_card_add_to_cart_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_localize_script('gift_card_add_to_cart_script', 'WPURLS', array( 'siteurl' => get_option('siteurl') )); 
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'gift_card_add_to_cart_script' );

}

add_action("wp_ajax_gift_card_add_to_cart", "gift_card_add_to_cart");
add_action("wp_ajax_nopriv_gift_card_add_to_cart", "gift_card_add_to_cart");
function gift_card_add_to_cart() {

    //check error
    for($i=0; $i<count($_POST['product_id']); $i++){

        $product_id = $_POST['product_id'][$i];
        $gift_card_recipient_name = trim($_POST['gift_card_recipient_name'][$i]);
        $gift_card_recipient_email = trim($_POST['gift_card_recipient_email'][$i]);
        $gift_card_phone = trim($_POST["gift_card_phone"][$i]);
        $gift_card_sender_name = trim($_POST['gift_card_sender_name'][$i]);
        $error_arr=[];
        if(empty($gift_card_recipient_name)){
            $error_arr[] = array("product_id" => $product_id,"fieldname" => 'gift_card_recipient_name', "field_value" => $gift_card_recipient_name, "errorText" => 'Viðtakanda Nafn Áskilið.');        
        }
        if(empty($gift_card_recipient_email)){
            $error_arr[] = array("product_id" => $product_id,"fieldname" => 'gift_card_recipient_email', "field_value" => $gift_card_recipient_email, "errorText" => 'Viðtakanda Netfang Áskilið.');        
        }
        if(!is_email($gift_card_recipient_email)){
            $error_arr[] = array("product_id" => $product_id,"fieldname" => 'gift_card_recipient_email', "field_value" => $gift_card_recipient_email, "errorText" => 'Viðtakanda Netfang not valid.');        
        }
        if(empty($gift_card_phone) || strlen($gift_card_phone)!=7 || !is_numeric($gift_card_phone)){
            $error_arr[] = array("product_id" => $product_id,"fieldname" => 'gift_card_phone', "field_value" => $gift_card_phone, "errorText" => 'Viðtakanda Símanúmer Áskilið.');        
        }
        if(empty($gift_card_sender_name)){
            $error_arr[] = array("product_id" => $product_id,"fieldname" => 'gift_card_sender_name', "field_value" => $gift_card_sender_name, "errorText" => 'Nafn sendanda Áskilið.');        
        }

        if(count($error_arr)>0){
            $response['type'] = 'fail';
            $response['errorMessages'] = $error_arr;
            echo json_encode($response);
            exit;
        }
    }
    //check error end

    

    for($i=0; $i<count($_POST['product_id']); $i++){
        if($i>0) sleep(1);

        $product_id = $_POST['product_id'][$i];
        $product = wc_get_product( $product_id );
        //$gift_card_amount=$product->get_regular_price();
        
        $hour = empty($_POST["gift_card_time_hour"][$i])?'00': $_POST["gift_card_time_hour"][$i];
        $minute = empty($_POST["gift_card_time_minute"][$i])?'00': $_POST["gift_card_time_minute"][$i];
        $time  = $hour.':'.$minute;

        $gift_card_date = (empty($_POST["gift_card_date"][$i])?date('d/m/Y'):date("d/m/Y",strtotime($_POST["gift_card_date"][$i])));
        $gift_card_time = date("H:i:s", strtotime($time));
        
        $gift_card_recipient_name = trim($_POST['gift_card_recipient_name'][$i]);
        $gift_card_recipient_email = trim($_POST['gift_card_recipient_email'][$i]);
        $gift_card_phone = trim($_POST["gift_card_phone"][$i]);
        $gift_card_custome_message = $_POST['gift_card_custome_message'][$i];
        $gift_card_sender_name = trim($_POST['gift_card_sender_name'][$i]);
        $send_mail_to_recipient = $_POST['send_mail_to_recipient'][$i];

        $gift_card_image = $_POST['gift_card_image'][$i];
        $gift_card_amount = $_POST['gift_card_amount'][$i];

        $gift_card_item_add_to_cart_meta=array(
            'gift_card_amount'=>$gift_card_amount,
            'gift_card_date'=>$gift_card_date,
            'gift_card_time'=>$gift_card_time, // need to join hour & min
            'gift_card_recipient_name'=>$gift_card_recipient_name,
            'gift_card_recipient_email'=>$gift_card_recipient_email,
            'gift_card_sender_name'=>$gift_card_sender_name,
            'gift_card_phone'=>$gift_card_phone,
            'gift_card_custome_message'=>$gift_card_custome_message,
            'send_mail_to_recipient'=>$send_mail_to_recipient,
            'gift_card_image'=>$gift_card_image,
            'gift_card_amount'=>$gift_card_amount,

        );

        if ( is_session_started() === FALSE ) session_start();
        $_SESSION['lb_gift_card_add_to_cart_'.$product_id] = $gift_card_item_add_to_cart_meta;
        WC()->cart->add_to_cart( $product_id );
    }

    $response['type'] = 'success';
    $response['successMessages'] = 'Gift Cards added to cart successfully';
    echo json_encode($response);
    exit;
}