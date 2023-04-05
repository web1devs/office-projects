<?php 

/*plugin uninstall  */
function wx_giveaways_uninstall(){
    unregister_post_type('giveaways');
}



register_deactivation_hook( __FILE__,'wx_giveaways_uninstall');


/*====== admin menu start here ===== */

 function wx_submenu_page(){
    ?>
    
    
<div id="giveaways_contaniner">
    
    <div class="giveways_title">
        <h2>Giveaways Setup</h2>
    </div>
           
    <label for="cupon ">Number Of Entries Input Field Label</label>
    <input type="text" name="entrie_number_input_field_label" id="entrie_number" value="<?php echo get_option('entrie_number_label',true)?>">
    <br/><br/>
    <label for="giveaways_search" class="search_admin_setting_label">Search Input Field Label</label>
    <input type="text" name="search_giveaways_label" id="giveaways_search" value="<?php echo get_option('search_giveaways_label',true)?>">
    <br/><br/>

    <label for="giveaways_additional_entry" class="additional_entry">Giveaways Additional Entry Label</label>
    <input type="text" name="giveaways_additional_entry" id="giveaways_additional_entry"value="<?php echo get_option('giveaways_additional_entry',true); ?>">
    
    <label for="giveaways_estimate_value" class="giveaways_estimate_value">Giveaways Estimate Value Label </label>
    <input type="text" name="giveaways_estimate_value" id="giveaways_estimate_value" value="<?php echo get_option('giveaways_estimate_value',true);?>">
    <!-- order status field here -->

    <label for="viral_sweep_api_key" class="viral_sweep_api_key">Viralsweep API key</label>
    <input class="w30p" type="text" name="viral_sweep_api_key" id="viral_sweep_api_key" value="<?php echo get_option('viral_sweep_api_key',true);?>">

    <label for="giveways_order_status"><?php _e('Select order status when entries will be given','wx-giveaway');?></label>
    <select id="giveways_order_status" name="giveaway_entry_order_status" class="giveways_order">
        <?php
           
            $statuses = wc_get_order_statuses();
            $giveaway_entry_order_status = get_option('giveaway_entry_order_status',true);
            foreach ( $statuses as $status => $status_name ) {
                $status = str_replace( 'wc-', '', $status );
                echo '<option value="' . esc_attr( $status ) . '" ' . selected( $status, $giveaway_entry_order_status, false ) . '>' . esc_html( $status_name ) . '</option>';
            }
        ?>
	</select>
    <br/><br/>

    <div id="loader_sesction">
       <?php 
        echo '<img src="' . esc_url( plugins_url( 'assets/images/loader.gif', __FILE__ ) ) . '" id="loader_img"> ';
       ?>
    </div>
    <input type="button" name="save" class="button" value="Save Change">

    
</div>

<p id="ppp"></p>
    
    <?php
 }

  
function wx_add_menu_under_giveaways_custom_post(){
    add_submenu_page('edit.php?post_type=giveaways','Giveaways Setup','Settings','manage_options','giveways-settings','wx_submenu_page','');
 }
add_action('admin_menu', 'wx_add_menu_under_giveaways_custom_post');
