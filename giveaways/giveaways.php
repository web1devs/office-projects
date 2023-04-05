<?php 
/**
 * Plugin Name:       Giveaways
 * Plugin URI:        https://www.wooxperto.com/
 * Description:       Giveaways system  plugin is a WooCommerce Addon Plugin
 * Version:           1.0.0
 * Author:            WooXperto
 * Author URI:        https://www.wooxperto.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wx-giveaways
 * Domain Path:       /languages
 */
 define('TV',time()); 
 define('VIRALSWEEP_API_KEY',get_option('viral_sweep_api_key',true)); 
 class WX_Giveaways_post{

    function __construct() {

        
         /* include wx-giveaways-custom-post.php file here  */
        include_once plugin_dir_path(__FILE__).'/admin/wx-giveaways-custom-post.php';

        /* include wx-giveaways-product-meta.php file here  */
        include_once plugin_dir_path(__FILE__).'/admin/wx-giveaways-product-meta.php';

         /* include wx-giveaways-admin-settings.php file here  */
         include_once plugin_dir_path(__FILE__).'/admin/wx-giveaways-admin-settings.php';

          /* include wx-giveaways-count-down.php file here */
         include_once plugin_dir_path(__FILE__).'/admin/wx-giveaways-count-down.php';

         include_once plugin_dir_path(__FILE__). '/admin/vc-blocks-load.php';

       /* enqueue wx_giveaways js and css file here */

        add_action('admin_enqueue_scripts',[$this,'wx_giveaways_assets']);
        add_action('wp_enqueue_scripts',[$this,'wx_giveaways_assets_forntend']);

        /*Admin settings data from ajax*/

        add_action('wp_ajax_giveaways_settings_option',[$this,'wx_giveaways_settings_option_page']);
        add_action('wp_ajax_nopriv_giveaways_settings_option',[$this,'wx_giveaways_settings_option_page']);


    }

 /* giveaways Admin css and js  callback function here */

 public function wx_giveaways_assets(){
    wp_enqueue_style('giveaways-main-css', plugin_dir_url(__FILE__).'admin/assets/css/giveaways-admin-main.css',null,TV, 'all');
    wp_enqueue_style('giveaways-date-time-picker-css', plugin_dir_url(__FILE__).'admin/assets/css/jquery.datetimepicker.min.css',null,'1.0.0', 'all');
   

    wp_enqueue_script('giveaways-date-time-picker-js', plugin_dir_url( __FILE__ ).'admin/assets/js/jquery.datetimepicker.full.min.js',array('jquery'),'1.0.0',true);
    
    wp_enqueue_script('giveaways-custom-js', plugin_dir_url( __FILE__ ).'admin/assets/js/giveaways-custom.js',array('jquery'),TV,true);

    $xajax_url_arr = array(
        'xajaxurl' => admin_url('admin-ajax.php')
    );
    wp_localize_script('giveaways-custom-js','xajaxurl',$xajax_url_arr);
   
}

/* load css and js for forntend */
function wx_giveaways_assets_forntend(){
    wp_enqueue_style('giveaways-flip-css', plugin_dir_url(__FILE__).'frontend/assets/css/flip.min.css',null,'1.0.0', 'all');
    wp_enqueue_style('giveaways-css-css', plugin_dir_url(__FILE__).'frontend/assets/css/giveaways-css.css',null,TV, 'all');
    wp_enqueue_style('giveaways-grid-css', plugin_dir_url(__FILE__).'frontend/assets/css/style.css',null,TV, 'all');

    wp_enqueue_script('giveaways-flip-js', plugin_dir_url( __FILE__ ).'frontend/assets/js/flip.min.js',null,'1.0.0',false);
    wp_enqueue_script('giveaways-main-js', plugin_dir_url( __FILE__ ).'frontend/assets/js/giveaways.js',array('jquery'),TV,true);
}



/* admin setting data from ajax  call back funciton */
public function wx_giveaways_settings_option_page( ){

    $entry_number_label = sanitize_text_field ($_POST['entrie_number_input_field_label']);
    $search_giveaways_label = sanitize_text_field( $_POST['search_giveaways_label'] );

    $giveaways_order_status = sanitize_text_field( $_POST['giveways_order_status']);
    $giveaways_additional_entry = sanitize_text_field( $_POST['giveaways_additional_entry']);

    $giveaways_estimate_value = sanitize_text_field( $_POST['giveaways_estimate_value']);
    $viral_sweep_api_key = sanitize_text_field( $_POST['viral_sweep_api_key']);


    //echo $search_giveaways_label;

    update_option('entrie_number_label',$entry_number_label);
    update_option('search_giveaways_label',$search_giveaways_label);
    update_option('giveaway_entry_order_status',$giveaways_order_status);
    update_option('giveaways_additional_entry',$giveaways_additional_entry);
    update_option('giveaways_estimate_value',$giveaways_estimate_value);
    update_option('viral_sweep_api_key',$viral_sweep_api_key);
    

    echo'ok';
    exit();
}



} // end class 


 new WX_Giveaways_post();

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

//custom table

 function wx_giveaways_ticket_table(){
 
    global $wpdb;

    $table_ticket = "{$wpdb->prefix}wx_giveaways_ticket";

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE " .$table_ticket." (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        subscription_id bigint(20) NOT NULL,
        order_number bigint(20) NOT NULL,
        order_item_id bigint(20) NOT NULL,
        ticket_number varchar(100),
        from_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        to_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";


    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta( $sql );
        //exit();
}

register_activation_hook( __FILE__,'wx_giveaways_ticket_table');


// single giveaways items validation
add_filter( 'woocommerce_add_to_cart_validation', 'woocommerce_add_to_cart_validationcustom', 10, 3 );
function woocommerce_add_to_cart_validationcustom( $passed, $product_id, $quantity) {

	global $woocommerce;
	if( has_term( 35, 'product_cat', $product_id ) ) { // single giveaways items (must need a giveaways id)
        if(!isset($_REQUEST['gid'])){
            wc_add_notice( sprintf( __( "Giveaways not selected", "wx-giveaways" ) ) ,'error' );
            return false;
        }else{
            if($_REQUEST['gid']>0){

                $gid=$_REQUEST['gid'];
                $type=get_post_type($gid);
                if($type==='giveaway'){
                    $closing_date = get_post_meta($gid,'giveaways_closing_date',true);
                    $c_date = new DateTime( $closing_date);
                    $c_date = $c_date->format('Y-m-d H:i:s');
                    if(strtotime($c_date)<strtotime(date('Y-m-d H:i:s'))){
                        return $passed;
                    }else{
                        wc_add_notice( sprintf( __( "Sorry! The giveaway closed already. Please try another one.", "wx-giveaways" ) ) ,'error' );
                        return false;
                    }
                }else{
                    wc_add_notice( sprintf( __( "Giveaways not selected", "wx-giveaways" ) ) ,'error' );
                    return false;
                }
            }else{
                wc_add_notice( sprintf( __( "Giveaways not selected", "wx-giveaways" ) ) ,'error' );
                return false;
            }
        }
    }else{
        return $passed;
    }
	
}    

// giveaways add to cart
function giveaways_add_to_cart(){
    $pid=$_POST["pid"];
    $gid=$_POST["gid"];

    if($pid>0 && $gid>0){
        $type=get_post_type($gid);
        if($type==='giveaways'){
            $closing_date = get_post_meta($gid,'giveaways_closing_date',true);
            $c_date = new DateTime( $closing_date);
            $c_date = $c_date->format('Y-m-d H:i:s');
            if(strtotime($c_date)<strtotime(date('Y-m-d H:i:s'))){
                $response['type'] = 'error';
                $response['successMessages'] = 'Selected giveaway closed!';
                echo json_encode($response);
            }else{
                $giveaway_item_add_to_cart_meta=array(
                    'giveaway_pid'=>$pid,
                    'giveaway_gid'=>$gid

                );
                if ( is_session_started() === FALSE ) session_start();
                $_SESSION['wx_giveaways_add_to_cart_'.$pid] = $giveaway_item_add_to_cart_meta;
                WC()->cart->add_to_cart( $pid );

                $response['type'] = 'success';
                $response['successMessages'] = 'Item added to cart successfully';
                $response['redirect_url'] = wc_get_checkout_url();
                echo json_encode($response);
            }
        }else{
            $response['type'] = 'error';
            $response['successMessages'] = 'Giveaway not selected';
            echo json_encode($response);
        }
    }
    exit();
}
add_action('wp_ajax_giveaways_add_to_cart','giveaways_add_to_cart');
add_action('wp_ajax_nopiv_giveaways_add_to_cart','giveaways_add_to_cart');

add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',1,2);
 
if(!function_exists('wdm_add_item_data'))
{
    function wdm_add_item_data($cart_item_data,$product_id)
    {

        /*Here, We are adding item in WooCommerce session with, wdm_user_custom_data_value name*/
        global $woocommerce;
        if ( is_session_started() === FALSE ) session_start(); 
        if (isset($_SESSION['wx_giveaways_add_to_cart_'.$product_id])) {
            $option = $_SESSION['wx_giveaways_add_to_cart_'.$product_id];     
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
        unset($_SESSION['wx_giveaways_add_to_cart_'.$product_id]); 
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

add_filter('woocommerce_cart_item_name','wdm_add_user_custom_option_from_session_into_cart',1,3);  
//add_filter('woocommerce_cart_item_price','wdm_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('wdm_add_user_custom_option_from_session_into_cart'))
{
 function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
        
        if(isset($values['wdm_user_custom_data_value'])){
            /*code to add custom data on Cart & checkout Page*/    
            if(count($values['wdm_user_custom_data_value']) > 0)
            {
                $gid = $values['wdm_user_custom_data_value']["giveaway_gid"];
                $pid = $values['wdm_user_custom_data_value']["giveaway_pid"];
                $total = 0;
                $no_of_entries_regular = get_post_meta($pid,'giveaways_ticket_number',true);
                if($no_of_entries_regular>0)$total=$no_of_entries_regular;
                $no_of_entries_additional = get_post_meta($pid,'giveaways_additional_entry',true);
                if($no_of_entries_additional>0)$total=$total+$no_of_entries_additional;

                $total = $total * $values['quantity'];

                if($total>1){
                    $entry_label='Entries';
                }else{
                    $entry_label='Entry';
                }
                $return_string = $product_name .' - '.get_the_title($gid).' ('.$total.' '.$entry_label.')';

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


add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
if(!function_exists('wdm_add_values_to_order_item_meta'))
{
  function wdm_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce;
        global $wpdb;
        $table_name=$wpdb->prefix.'woocommerce_order_items';
        if(isset($values['wdm_user_custom_data_value'])){
            if(count($values['wdm_user_custom_data_value']) > 0)
            {
                $gid = $values['wdm_user_custom_data_value']["giveaway_gid"];
                $pid = $values['wdm_user_custom_data_value']["giveaway_pid"];
                wc_add_order_item_meta($item_id,'giveaway_id',[$gid]);

                $total = 0;
                $no_of_entries_regular = get_post_meta($pid,'giveaways_ticket_number',true);
                if($no_of_entries_regular>0)$total=$no_of_entries_regular;
                $no_of_entries_additional = get_post_meta($pid,'giveaways_additional_entry',true);
                if($no_of_entries_additional>0)$total=$total+$no_of_entries_additional;

                $total = $total * $values['quantity'];
                wc_add_order_item_meta($item_id,'giveaways_ticket_number',[$total]);

                // change order item name
                
                if($total>1){
                    $entry_label='Entries';
                }else{
                    $entry_label='Entry';
                }
                $modified_item_name = get_the_title($pid) .' - '.get_the_title($gid).' ('.$total.' '.$entry_label.')';

                $wpdb->query("update {$table_name} set order_item_name='{$modified_item_name}' where order_item_id={$item_id}");
            }
        }
  }
}




// add entries to ======


function wx_giveaways_checking_order_and_insert_data($order_id, $status_transition_from, $status_transition_to ){
 
    
    $giveaway_order_status_checking = get_option("giveaway_entry_order_status",true);
    $entries_added=get_post_meta($order_id,'entries_added',true);
    if( $status_transition_to === $giveaway_order_status_checking ){
        
        if($entries_added!=1){
            $order = wc_get_order($order_id);

            $email=$order->get_billing_email();
            $first_name=$order->get_billing_first_name();
            $last_name=$order->get_billing_last_name();

            $form_date = $order->get_date_created();
            $total_tickets=0;
            foreach($order->get_items() as $item_id => $item ){

                
                $product_id = $item->get_variation_id();
                if( $product_id === 0){
                    $product_id = $item->get_product_id();
                }
                
                $giveaways_ticket_number =  wc_get_order_item_meta($item_id,'giveaways_ticket_number', true);
                if($giveaways_ticket_number!=null){
                    if(is_array($giveaways_ticket_number)){
                        $tickets=(int)$giveaways_ticket_number[0]; 
                        $gid=wc_get_order_item_meta($item_id,'giveaway_id',true);
                        $giveaways_id=$gid[0];
                        if($giveaways_id>0){
                            $viralsweep_giveaways_id=get_post_meta($giveaways_id,'viralsweep_giveaways_id',true);
                            // email exists or not
                            $email_exists=false;
                            if($viralsweep_giveaways_id!=null){
                                $response=viralsweep_check_email($email,$viralsweep_giveaways_id);
                                if(isset($response->entries)){
                                    if(count($response->entries)>0) $email_exists=true;
                                }
                            }

                            if($email_exists){
                                if($tickets>0 && $viralsweep_giveaways_id!=null){
                                    viralsweep_update_entries($email,$tickets,$viralsweep_giveaways_id);
                                    wc_update_order_item_meta($item_id,'viralsweep_tickets',$tickets);
                                    $total_tickets+=$tickets;
                                }
                            }else{
                                $eid=wc_get_order_item_meta($item_id,'viralsweep_eid',true);
                                if($eid>0){
                                    if($tickets>0 && $viralsweep_giveaways_id!=null){
                                        viralsweep_update_entries($email,$tickets,$viralsweep_giveaways_id);
                                        wc_update_order_item_meta($item_id,'viralsweep_tickets',$tickets);
                                        $total_tickets+=$tickets;
                                    }
                                }else{
                                    if($tickets>0 && $viralsweep_giveaways_id!=null){
                                        $return_obj=viralsweep_insert_entries($email,$first_name,$last_name,$tickets,$viralsweep_giveaways_id);
                                        if($return_obj){
                                            if(isset($return_obj->success)){
                                                if($return_obj->success==1){
                                                    $total_tickets+=1;
                                                    $eid=$return_obj->eid;
                                                    wc_update_order_item_meta($item_id,'viralsweep_eid',$eid);
                                                    wc_update_order_item_meta($item_id,'viralsweep_tickets',$tickets);
                                                    $tickets=$tickets-1;
                                                    if($tickets>0){
                                                        viralsweep_update_entries($email,$tickets,$viralsweep_giveaways_id);
                                                        $total_tickets+=$tickets;
                                                    }
                                                }
                                            }
                                        }
                                        
                                    }
                                }
                            }
                        }
                    }
                }
                
                
            }// end foreach

            
            if($total_tickets>0){
                update_post_meta($order_id,'entries_added',1); 
                update_post_meta($order_id,'total_tickets',$total_tickets); 
            }
        }

    }else{
        if($entries_added==1){
            $order = wc_get_order($order_id);
            $email=$order->get_billing_email();

            $total_tickets=0;
            foreach($order->get_items() as $item_id => $item ){

                $product_id = $item->get_variation_id();
                if( $product_id === 0){
                    $product_id = $item->get_product_id();
                }
                
                $giveaways_ticket_number =  wc_get_order_item_meta($item_id,'viralsweep_tickets', true);
                if($giveaways_ticket_number>0){ 
                    $gid=wc_get_order_item_meta($item_id,'giveaway_id',true);
                    $giveaways_id=$gid[0];
                    if($giveaways_id>0){
                        $viralsweep_giveaways_id=get_post_meta($giveaways_id,'viralsweep_giveaways_id',true);
                        if($viralsweep_giveaways_id!=null){
                            $giveaways_ticket_number=(int)$giveaways_ticket_number;
                            viralsweep_update_entries($email,($giveaways_ticket_number*-1),$viralsweep_giveaways_id);
                            wc_update_order_item_meta($item_id,'viralsweep_tickets',0);
                        }
                    }
                }
                
                
                
            }// end foreach

            update_post_meta($order_id,'entries_added',0); 
            update_post_meta($order_id,'total_tickets',0); 
        }
    }

  

    
}

add_action("woocommerce_order_status_changed","wx_giveaways_checking_order_and_insert_data",333,3);

// viralsweep insert update entries
function viralsweep_insert_entries($email,$first_name,$last_name,$tickets,$promotion_id){
    $post_fields = array('email'=>$email,'first_name'=>$first_name,'last_name'=>$last_name);
    $process = curl_init();
    curl_setopt($process, CURLOPT_URL, 'https://app.viralsweep.com/api/entries/'.$promotion_id);
    curl_setopt($process, CURLOPT_HTTPHEADER, array('content-type: application/json',
    'x-api-key: '.VIRALSWEEP_API_KEY));
    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($post_fields));
    curl_setopt($process, CURLOPT_CUSTOMREQUEST, 'POST');
    $return = curl_exec($process);
    curl_close($process);
    return json_decode($return);
}

function viralsweep_update_entries($email,$tickets,$promotion_id){
    $post_fields = array('email' => $email,'points'=>$tickets,'description' => 'Entries');
    $process = curl_init();
    curl_setopt($process, CURLOPT_URL, 'https://app.viralsweep.com/api/points/'.$promotion_id);
    curl_setopt($process, CURLOPT_HTTPHEADER, array('content-type: application/json',
    'x-api-key: '.VIRALSWEEP_API_KEY));
    curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($post_fields));
    curl_setopt($process, CURLOPT_CUSTOMREQUEST, 'POST');
    $return = curl_exec($process);
    curl_close($process);
}

// viralsweep check entrent email exists or not
function viralsweep_check_email($email,$promotion_id){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.viralsweep.com/api/entries/'.$promotion_id.'?query='.$email.'&count=1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-api-key: '.VIRALSWEEP_API_KEY
        )
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return json_decode($response);
}

include('frontend/shortcode.php');
include('frontend/give-way-shortcode.php');

function giveaways_body_class($classes) {
    if(is_singular('giveaways')){
        global $post;
        $post_id=$post->ID;
        $closing_date = get_post_meta($post_id,'giveaways_closing_date',true);
        $c_date = new DateTime( $closing_date);
        $c_date = $c_date->format('Y-m-d H:i:s');
        if(strtotime(date('Y-m-d H:i:s'))>strtotime($c_date)){
            $classes[] = 'expired_giveaway';
        }

    }

    
    return $classes;
}

add_filter('body_class', 'giveaways_body_class',10,1);

