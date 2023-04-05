<?php 

/* =======Add metaboxes for giveways custom_post tupe========*/

function meta_box_for_giveaways($post){
    add_meta_box(
        'giveaways_meta', 
        __('Giveaways Data','wx-giveaways'),
        'wx_giveaways_add_metaboxes',
        'giveaways'
    );
}
add_action('add_meta_boxes', 'meta_box_for_giveaways');
/* callback function for metaboxes */

function wx_giveaways_add_metaboxes($post){

    $open_date_val = get_post_meta( $post->ID, 'giveaways_opening_date', true);
    $close_date_val = get_post_meta( $post->ID, 'giveaways_closing_date', true);
    $draw_date_val = get_post_meta( $post->ID, 'giveaways_draw_date', true);

    $giveaways_status_val = get_post_meta( $post->ID, 'giveaways_status', true);
    ?>
    <table style="width:100%;">
        <tr>
            <td>
                <label for="opening_date_time"><?php _e('Giveaways opening date & time','wx-giveaways');?></label><br/>
                <input type="text" class="" id="opening_date_time" name="giveaways_opening_date" value="<?php echo esc_attr( $open_date_val );?>" value="" placeholder="">
            </td>
            <td>
                <label for="closing_date_time"><?php _e('Giveaways closing date & time','wx-giveaways');?></label><br/>
                <input type="text" class="" id="closing_date_time"name="giveaways_closing_date" value="<?php echo esc_attr( $close_date_val );?>" value="" placeholder="">
            </td>
            <td>
                <label for=""><?php _e('Giveaways draw date & time','wx-giveaways');?></label><br/>
                <input type="text" class="" id="draw_date_time"name="giveaways_draw_date" value="<?php echo esc_attr( $draw_date_val );?>" value="" placeholder="">
            </td>
            <td>
                <label for="giveaways_status"><?php _e('Giveaways status','wx-giveaways');?></label><br/>
                <select name="giveaways_status" id="giveaways_status" class="">
                    <option value="current" <?php selected( $giveaways_status_val, 'current');?>>Current</option>
                    <option value="past" <?php selected( $giveaways_status_val, 'past');?>>Past</option>
                </select>
            </td>
            <td>
                <label for="viralsweep_giveaways_id"><?php _e('Viralsweep promotion/giveaways ID','wx-giveaways');?></label><br/>
                <input type="text" id="viralsweep_giveaways_id" name="viralsweep_giveaways_id" value="<?php echo get_post_meta( $post->ID, 'viralsweep_giveaways_id', true);?>">
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <label id="giveaways_estimated_value"><?php echo __("Giveaways Estimated value","wx-giveaways");?></label><br/>
                <input type="text" id="giveaways_estimated_value" name="giveaways_estimated_value" value="<?php echo get_post_meta( $post->ID, 'giveaways_estimated_value', true);?>">
                
            </td>
        </tr>
    </table>
    
    <?php
}


function wx_giveaways_save_metabox($post){

    //save  giveaways_opening_date  metabox

    if(isset($_POST['giveaways_opening_date'])){
        update_post_meta($post,'giveaways_opening_date', $_POST['giveaways_opening_date']);
    }

    //save  giveaways_closing_date  metabox
    if(isset($_POST['giveaways_closing_date'])){
        update_post_meta($post,'giveaways_closing_date', $_POST['giveaways_closing_date']);
    }

    //save  giveaways_status  metabox
    if(isset($_POST["giveaways_status"])){

        $giveaways_status_val =  $_POST["giveaways_status"];
        update_post_meta($post,'giveaways_status',$giveaways_status_val);
    }

    // save giveaway_draw_metabox

    if(isset($_POST["giveaways_draw_date"])){

        update_post_meta($post,'giveaways_draw_date',$_POST["giveaways_draw_date"]);
    }

    if(isset($_POST["viralsweep_giveaways_id"])){

        update_post_meta($post,'viralsweep_giveaways_id',$_POST["viralsweep_giveaways_id"]);
    }
    if(isset($_POST["giveaways_estimated_value"])){

        update_post_meta($post,'giveaways_estimated_value',$_POST["giveaways_estimated_value"]);
    }
}


add_action('save_post_giveaways','wx_giveaways_save_metabox',10,1);


/* =======Add metaboxes for giveways custom_post tupe end========*/


/* single product meta box  */
function giveaways_search_input_meta($id){
?>
    <div class="search_panel">

    
        <br><br>

       
        <label for="seach" class="search_label"><?php _e(get_option('search_giveaways_label',true),'wx-giveaways');?></label>
        <input type="search" name="giveaway_search_entry" class="giveaways_search" value="" autocomplete="off">
        
        <br><br>
        <div class="selected_giveaways">

        <?php

           $pre_giveaways=get_post_meta($id,'giveaways_ids',true);
           
            if(!empty($pre_giveaways)){
                $ids=explode(',',$pre_giveaways);
                foreach($ids as $gid){
                    $title = get_the_title($gid);
                    echo'<span>
                        '.$title.'
                        <span class="giveaway_close" data-id="'.$gid.'" onclick="giveaway_list_close(this)">X</span>
                    </span>';
                }
            }
        
        ?>
        </div>
        <div class="giveaways_list"></div>


    </div>
<?php

}
/* add new field on single product  */

function wx_giveaways_extra_field_on_product_panel(  ){

    // $product = wc_get_product( get_the_ID() );

    woocommerce_wp_text_input( array( 
        'id'=>'giveaways_ticket_number',
        'label' => __( get_option('entrie_number_label',true),'wx-giveaways'),
        'wrapper_class' => 'aaaaa',
        'type'=>'number',

    ) );

    // woocommerce_wp_text_input(array(
    //     "id"=>"giveaways_tiket_validite_duration",
    //     "label"=> __("Giveaways Ticket validity Duration ","wx-giveaways"),
    //     "type"=>"text",
    //     "wrapper_class"=>"tiket_validite_duration",
    //     "value"=> ""
    // ));

    woocommerce_wp_text_input(array(
        "id"=>"giveaways_additional_entry",
        "label"=> __(get_option('giveaways_additional_entry',true),"wx-giveaways"),
        "type"=>"number",
        "wrapper_class"=>"giveaw_additional_entry",
        "value"=> get_post_meta(get_the_ID(),'giveaways_additional_entry',true)
    ));


    

    /* hidden field for simple product*/
?>
    <input type="hidden" name="giveaways_multi_entries" class="giveways_multi_entries" value="<?php echo get_post_meta(get_the_ID(),'giveaways_ids',true);?>">

<?php

    giveaways_search_input_meta(get_the_ID());

    
}


add_action('woocommerce_product_options_general_product_data','wx_giveaways_extra_field_on_product_panel');

/* save custom field data for single product */

/* save simple product custom field data  */

function wx_giveaways_save_simple_product_custom_meta( $post_id ){

    $simple_entry_val = $_POST['giveaways_ticket_number'];

    $giveaways_multiple_entries_val = $_POST['giveaways_multi_entries'];

    // $giveaways_tiket_validite_duration = $_POST['giveaways_tiket_validite_duration'];
    $giveaways_additional_entry = $_POST["giveaways_additional_entry"];


    if(isset( $simple_entry_val ) ){

        update_post_meta( $post_id,'giveaways_ticket_number',$simple_entry_val);
        
    }

    update_post_meta( $post_id,'giveaways_ids',$giveaways_multiple_entries_val);

    // update_post_meta( $post_id,'giveaways_tiket_validite_duration',$giveaways_tiket_validite_duration);

    update_post_meta($post_id,'giveaways_additional_entry', $giveaways_additional_entry);


}

add_action( 'woocommerce_process_product_meta_simple', 'wx_giveaways_save_simple_product_custom_meta' );

/* single product meta box  end*/


/* variation meta sention */

function wx_giveaways_extra_field_on_variation_after_price($loop, $variation_data, $variation){

    woocommerce_wp_text_input( array(
        'id' => 'giveaways_ticket_number[' . $loop . ']',
        'class' => 'short',
        'label' => __( get_option('entrie_number_label',true), 'wx-giveaways' ),
        'value' => get_post_meta( $variation->ID, 'giveaways_ticket_number', true ),
        'type'=>'number'
    ) );

    // woocommerce_wp_text_input(array(
    //     "id"=>"giveaways_ticket_validite_duration_var[".$loop."]",
    //     "label"=> __("Giveaways Ticket validity Duration ","wx-giveaways"),
    //     "wrapper_class"=>"tiket_validite_duration",
    //     "type"=>"date",
    // ));

    woocommerce_wp_text_input(array(
        "id"=>"giveaways_additional_entry[". $loop."]",
        "label"=> __(get_option('giveaways_additional_entry',true),"wx-giveaways"),
        "type"=>"number",
        "wrapper_class"=>"giveaw_additional_entry",
        "value"=> get_post_meta( $variation->ID, 'giveaways_additional_entry', true )
    ));





    echo '<input type="hidden" name="giveaways_multi_entries['.$loop.']" class="giveways_multi_entries" value="'. get_post_meta($variation->ID,'giveaways_ids',true).'">';

    giveaways_search_input_meta($variation->ID);

  
}
add_action( 'woocommerce_variation_options_pricing',  'wx_giveaways_extra_field_on_variation_after_price' , 10, 3 ); 


/* variation extra field data save method here  */

function wx_giveaways_entries_field_save_data( $variation_id, $i ){

    $extra_entry_field = isset($_POST["giveaways_ticket_number"][$i])?$_POST["giveaways_ticket_number"][$i]:'';
    update_post_meta( $variation_id, 'giveaways_ticket_number', esc_attr( $extra_entry_field ) );

    // giveaways_ids  
    $giveaways_multi_entries = $_POST['giveaways_multi_entries'][$i];
    update_post_meta( $variation_id, 'giveaways_ids', esc_attr( $giveaways_multi_entries ) );

    // additional entry field 
    $giveaways_additional_entry = $_POST["giveaways_additional_entry"][$i];
    update_post_meta($variation_id,'giveaways_additional_entry', $giveaways_additional_entry);



 }

add_action('woocommerce_save_product_variation', 'wx_giveaways_entries_field_save_data',10,2);

/* variation meta sention end*/


/* giveway search for  single product */
function wx_giveaways_search(){

    // var_dump($_POST['keyword']);

    $search_keyword = $_POST["keyword"];
    $exids = $_POST["exids"];

    $args = array(
        's'=>$search_keyword,
        'exact'=>0,
        'post_type'=>'giveaways',
        'posts_per_page'=>10,

    );

    if($exids){
        $ids = explode(',',$exids);
        $args['post__not_in'] = $ids;
    }

    $giveaway_query = new WP_Query($args);

    ?>
     <ul class="search_dropdown">
    <?php

    while($giveaway_query->have_posts()){
        

        $giveaway_query->the_post();

        $post_title = get_the_title();

        ?>
            <li data-id="<?php echo get_the_ID()?>" data-name="<?php  echo $post_title; ?>" onclick="choose_this_giveaways(this)"><?php  echo $post_title; ?></li>
        <?php
        
    }
    ?>
     </ul>
    <?php

    wp_reset_postdata(); 
    die();
}
add_action('wp_ajax_giveaways_search','wx_giveaways_search');
add_action('wp_ajax_nopiv_giveaways_search','wx_giveaways_search');



/* add new column on order table */
 function wx_giveaways_add_order_admin_list_column($columns){

    $columns["number_of_tickets"] = "Number Of Tickets";

    return $columns;
 }
add_filter('manage_edit-shop_order_columns','wx_giveaways_add_order_admin_list_column');

/* display tikcket number*/

function wx_giveaways_display_ticket_number_column_content($column){

    global $post;

    if("number_of_tickets" === $column ){

        $total_tickets = get_post_meta($post->ID, 'total_tickets', true);

        echo  $total_tickets;

    }

}
add_action('manage_shop_order_posts_custom_column','wx_giveaways_display_ticket_number_column_content');
