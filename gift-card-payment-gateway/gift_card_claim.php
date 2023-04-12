<?php
// http://localhost/www/checkout/order-received/2773/?key=wc_order_SzTC3wkfbGyS1


add_action('admin_head', 'gift_card_claim_css');
function gift_card_claim_css(){
?>
<style>
    .no_allowed {
        cursor: not-allowed;
    }
    img.loadin_img {
        width: 30px;
    }
    .gift_loding{
      animation: rotetSpin 3s linear infinite;
      display: inline-block;
      font-size: 18px;
      line-height: 0;
    }

    @keyframes rotetSpin {
        0%{
            transform: rotate(0deg);
        }
        100%{
            transform: rotate(360deg);
        }
    }

    .gift-claim-title {
        text-align: center;
        font-size: 30px;
    }

    .gift-wrap {
        display: flex;
    }

    .gift-wrap .gift-claim-setting-left,
    .gift-wrap .gift-claim-setting-right {
        background: white;
        padding: 10px;
        margin-right: 20px;
    }

    .bg-screen {
        background: #fff;
        width: auto;
        margin-right: 20px;
    }

    .bg-screen h3 {
        font-size: 24px;
        text-transform: uppercase;
        font-weight: 600;
        border-bottom: 1px solid #ddd;
        padding: 24px;
    }

    .btn-gift-claim {
        border: 0;
        background: #2271b1;
        padding: 7px 14px;
        border-radius: 3px;
        margin-top: 14px;
        color: #fff;
        cursor: pointer;
    }

    .btn-gift-claim:hover {
        background: #135e96;
    }

    .sereen-input-wrap {
        padding-left: 24px;
        padding-bottom: 30px;
    }

    .gift-input {
        border-color: #ddd;
    }

    .gift-btn-wrap a {
        text-decoration: none;
        border: 0;
        background: #2271b1;
        padding: 7px 14px;
        border-radius: 3px;
        margin-top: 14px;
        color: #fff;
        cursor: pointer;
    }

    .gift-btn-wrap a:hover {
        background: #135e96;
    }

    .all_role_wrap {
        display: flex;
        flex-direction: column;
    }

    .all_role_wrap label {
        margin-bottom: 8px;
    }
</style>
<?php 
}


add_action('wp_head', 'gifttowallet_gift_card_style');
function gifttowallet_gift_card_style(){
?>
<style>
  .gift_claim_form {
    margin-bottom: 30px;
  }
  .gift_claim_form .woocommerce-order-details__title {
    margin-bottom: 12px !important;
    border-bottom: 1px solid #ddd !important;
  }

  .Click-here {
    cursor: pointer;
    transition:background-image 3s ease-in-out;
  }
  
  .popup-model-main {
    text-align: center;
    overflow: hidden;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    -webkit-overflow-scrolling: touch;
    outline: 0;
    opacity: 0;
    -webkit-transition: opacity 0.15s linear, z-index 0.15;
    -o-transition: opacity 0.15s linear, z-index 0.15;
    transition: opacity 0.15s linear, z-index 0.15;
    z-index: -1;
    overflow-x: hidden;
    overflow-y: auto;
  }
  
  .model-open {
    z-index: 99999;
    opacity: 1;
    overflow: hidden;
  }
  .popup-model-inner {
    -webkit-transform: translate(0, -25%);
    -ms-transform: translate(0, -25%);
    transform: translate(0, -25%);
    -webkit-transition: -webkit-transform 0.3s ease-out;
    -o-transition: -o-transform 0.3s ease-out;
    transition: -webkit-transform 0.3s ease-out;
    -o-transition: transform 0.3s ease-out;
    transition: transform 0.3s ease-out;
    transition: transform 0.3s ease-out, -webkit-transform 0.3s ease-out;
    display: inline-block;
    vertical-align: middle;
    width: 600px;
    margin: 30px auto;
    max-width: 97%;
  }
  .popup-model-wrap {
    display: block;
    width: 100%;
    position: relative;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 6px;
    -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
    box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
    background-clip: padding-box;
    outline: 0;
    text-align: left;
    padding: 20px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    max-height: calc(100vh - 70px);
      overflow-y: auto;
  }
  .gift-btn-wrap {
    margin-top: 12px;
  }
  .pop-up-content-wrap p {
    margin-bottom: auto;
    line-height: 1.7em;
  }

  .pop-up-content-wrap .gift-card-info {
    margin-top: 16px;
  }
  .model-open .popup-model-inner {
    -webkit-transform: translate(0, 0);
    -ms-transform: translate(0, 0);
    transform: translate(0, 0);
    position: relative;
    z-index: 999;
  }
  .model-open .bg-overlay {
    background: #000000;
    z-index: 99;
      opacity: 0.85;
  }
  .bg-overlay {
    background: rgba(0, 0, 0, 0);
    height: 100vh;
    width: 100%;
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
    -webkit-transition: background 0.15s linear;
    -o-transition: background 0.15s linear;
    transition: background 0.15s linear;
  }
  .close-btn {
    position: absolute;
    right: 0;
    top: -30px;
    cursor: pointer;
    z-index: 99;
    font-size: 30px;
    color: #fff;
  }
    /*popup css The end*/

    .gift_loding{
        animation: rotetSpin 3s linear infinite;
        display: inline-block;
        font-size: 18px;
        line-height: 0;
    }

    @keyframes rotetSpin {
        0%{
            transform: rotate(0deg);
        }
        100%{
            transform: rotate(360deg);
        }
    }

</style>
<?php 
}


// === >>>> Dashboard Left side menu <<<< === \\

add_action("admin_menu", "wp_admin_dashboard_gift_card_menu_reg");
function wp_admin_dashboard_gift_card_menu_reg() {
    add_menu_page(
        __('Gift Card Payment','gtw-payment-gateway'), // page title <?=__('','gtw-payment-gateway')?
        __('Gift Card Payment','gtw-payment-gateway'), // menu title
        'manage_options', // capability
        'giftCardPay', // sluge
        'admin_gift_claim_page' // function
        // plugins_url('/img/icon.png',__DIR__) // icon url
    );

    //add submenu 2
    add_submenu_page(
        'giftCardPay', // parent menu slug
        __('Gift Card Pay Setting','gtw-payment-gateway'), // Page title
        'Settings', // Menu title
        'manage_options',  // Capability
        'giftSetting', // sub menu slug
        'gift_card_setting_fun' // sub meun funciton for page
    );

}

function admin_gift_claim_page() {
    echo '<h2>'.__('Gift Card Pay','gtw-payment-gateway').'</h2>';
}

// submenu page = claim_gift_card_fun
function gift_card_setting_fun() {
    // current_user_can('administrator');
    ?>
    <h2 class="gift-claim-title"><?=__('Settings Gift Card','gtw-payment-gateway')?></h2>
    <div class="gift-wrap">
        <!-- <div class="gift-claim-setting-left">

        </div> -->
        <div class="gift-claim-setting-right">

            <?php if( is_user_logged_in() ) { 
                
                ?>

            <table>
                <tbody class="gift-card-form">
                    <tr>
                        <td colspan="2">Partner Admin Or Employee login details</td>
                    </tr>
                    <tr>
                        <td><?=__('Email: ','gtw-payment-gateway')?></td>
                        <td>
                            <input class="gift-input" type="email" name="gift_to_wallet_use_email" value="<?php echo get_option('gift_to_wallet_email');?>">
                        </td>

                    </tr>
                    <tr>
                        <td><?=__('Password:','gtw-payment-gateway')?> </td>
                        <td><input class="gift-input" type="password" name="gift_to_wallet_use_password"
                                value="<?php echo get_option('gift_to_wallet_pass'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <div id="giftMessage"></div>
                    </tr>
                    <tr>
                        <td>
                            <input type="button" class="btn-gift-claim" value="SAVE"  onclick="gift_card_credential()" >
                            
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php } ?>

        </div>
    </div>
<?php
}



// Thanks page hook
add_action( 'woocommerce_thankyou', 'thakas_gift_card_input' );
function thakas_gift_card_input() {

    gift_card_token();

    // Only in thankyou "Order-received" page
    if( ! is_wc_endpoint_url( 'order-received' ) )
    return; // Exit

    global $wp;

    // Get the order ID
    $order_id       = absint( $wp->query_vars['order-received'] );
    $order          = wc_get_order($order_id);

    $orderStatus    = $order->get_status();
    $orderPaymentM  = $order->get_payment_method();

        if($orderStatus=='pending' && $orderPaymentM=='gifttowallet'){

    ?>
    <div class="gift_claim_form">
        <table id="discount-val"></table>

        <h2 class="woocommerce-order-details__title"><?=__('Gift card Claim','gtw-payment-gateway')?> </h2>
        <div id="processingMessage"></div>

        <input class="gift-input" type="text" name="gift_claim_card_number" value="" placeholder="<?=__('Enter Card Number','gtw-payment-gateway')?>">

        <?php 
        

        $old_payment = get_post_meta($order_id, 'total_payment', true );
        if($old_payment){
            $dueAmount = $order->get_total() - $old_payment;
        }else{
            $dueAmount = $order->get_total();
        }
        ?>
        <input type="hidden" name="pay_amount" value="<?php echo $dueAmount; ?>" >
        <span class="dis-btn">
            <button type="button" onclick="enter_gift_card_number()" class="Click-here" ><?=__('Claim','gtw-payment-gateway')?></button>
        </span>

        <!-- Add Popup section Start Now-->
        <div class="popup-wrap">

            <!-- <div class="Click-here">Click button</div> -->
            <div class="popup-model-main for_open">
                <div class="popup-model-inner">
                    <div class="close-btn">×</div>
                    <div class="popup-model-wrap">
                        <div class="pop-up-content-wrap" id="claim-card-info">
                            

                        </div>
                    </div>
                </div>
                <div class="bg-overlay"></div>
            </div>

        </div>
        <!-- Popup section The end -->
    </div>
    <?php 
    } else {
        echo "";
    }
}







// add your javaScript here
add_action('wp_footer', 'gifttowallet_gift_card_footer_script');
function gifttowallet_gift_card_footer_script(){
?>
<script>
    
    jQuery(".Click-here").on('click', function () {
        // jQuery(".popup-model-main").addClass('model-open');
    });
    jQuery(".close-btn, .bg-overlay").click(function () {
        jQuery(".popup-model-main").removeClass('model-open');
    });


    // Ajax Call with onclick='experience_gift_card_claim()'
    function experience_gift_card_claim() {
        
        let cardNum        = jQuery('.gift-card-info').find("input[name='cardId']").val();
        let currentBalance = jQuery('.gift-card-info').find("input[name='cardBal']").val();

        <?php 
                
        // Only in thankyou "Order-received" page
        if( ! is_wc_endpoint_url( 'order-received' ) )
        return; // Exit

        global $wp;

        // Get the order ID
        $order_id  = absint( $wp->query_vars['order-received'] );
        $order  = wc_get_order($order_id);
        
        $total_payment_before = get_post_meta($order_id, 'total_payment', true );
        $productAmount = $order->get_total();
        
        if($total_payment_before){
            $totalP = $productAmount - $total_payment_before; 
        }else {
            $totalP = $order->get_total();
        }
        ?>

        let orderId    = "<?php echo $order_id; ?>";
        let price    = "<?php echo $totalP; ?>";
        let tprice   = parseInt(price);
        let entryVal = parseInt(currentBalance);

        if(tprice >= entryVal) {
            jQuery('#claimSMS').html(`<?=__('Please wait we are processing ...','gtw-payment-gateway')?>`);
            jQuery('.dis-btn').html(`<button disabled class="btn-gift-claim" style="cursor: not-allowed;" type="button"><?=__('Claim','gtw-payment-gateway')?> <span class="gift_loding">&#10044;</span></button>`);

            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'experience_claim_type',
                    card_bal: currentBalance,
                    card_num: cardNum,
                    order_id: orderId
                },
                success: function(response) { 
                    jQuery('#claimSMS').html(``);

                    if(response.status === 'notok'){
                        jQuery('#processingMessage').html(`<h2 style="color: red;">${response.message}</h2>`);
                        jQuery(".popup-model-main").removeClass('model-open');
                        jQuery('.dis-btn').html(`<button onclick='enter_gift_card_number()' class="Click-here" type="button"><?=__('Claim','gtw-payment-gateway')?></button>`);
                        
                    }else{
                        jQuery('.dis-btn').html(`<button onclick='experience_gift_card_claim()' class="btn-gift-claim" type="button"><?=__('Claim','gtw-payment-gateway')?></button>`);
                        jQuery('#discount-val').html(`${response.html}`);
                        location.reload();
                    }
                    
                }
            });
        } else {
            jQuery('#claimSMS').html(`<?=__('Ops! you are trying to pay more than order payable amount!','gtw-payment-gateway')?>`);
        }
            
    }

    // Ajax Call with onclick='regular_gift_card_claim()'
    function regular_gift_card_claim() {
        let cardEntryVal   = jQuery('.gift-card-info').find("input[name='cardValue']").val();
        // let cardEntryVal   = 5;
        let cardNum        = jQuery('.gift-card-info').find("input[name='cardid']").val();
        let currentBalance = jQuery('.gift-card-info').find("input[name='cardBalance']").val();
        // let tid = jQuery('.gift-card-info').find("input[name='cardBalance']").val();

        
        <?php 
                
        // Only in thankyou "Order-received" page
        if( ! is_wc_endpoint_url( 'order-received' ) )
        return; // Exit

        global $wp;

        // Get the order ID
        $order_id  = absint( $wp->query_vars['order-received'] );
        $order  = wc_get_order($order_id);

        $total_payment_before = get_post_meta($order_id, 'total_payment', true );
        $productAmount = $order->get_total();

        if($total_payment_before){
            $totalP = $productAmount - $total_payment_before; 
        }else {
            $totalP = $order->get_total();
        }
         
        ?>

        let orderId    = "<?php echo $order_id; ?>";
        let price    = "<?php echo $totalP; ?>";
        let tprice   = parseInt(price);
        let entryVal = parseInt(cardEntryVal);
        // console.log(tprice);

         if(entryVal>0 && parseInt(currentBalance) >= entryVal &&  tprice >= entryVal ) {
            jQuery('#claimInfoMessage').html(`<?=__('Please wait we are processing ...','gtw-payment-gateway')?>`);
            jQuery('.dis-btn').html(`<button disabled class="btn-gift-claim" style="cursor: not-allowed;" type="button"><?=__('Claim','gtw-payment-gateway')?> <span class="gift_loding">&#10044;</span></button>`);

            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'regular_claim_type',
                    card_val: cardEntryVal,
                    card_bal: currentBalance,
                    card_num: cardNum,
                    order_id: orderId
                },
                success: function(response) { 
                    jQuery('#claimInfoMessage').html(``);

                    if(response.status === 'notok'){
                        jQuery('#processingMessage').html(`<h2 style="color: red;">${response.message}</h2>`);
                        jQuery(".popup-model-main").removeClass('model-open');
                        jQuery('.dis-btn').html(`<button onclick='enter_gift_card_number()' class="Click-here" type="button"><?=__('Claim','gtw-payment-gateway')?></button>`);

                    }else{
                        jQuery('.dis-btn').html(`<button onclick='regular_gift_card_claim()' class="btn-gift-claim" type="button"><?=__('Claim','gtw-payment-gateway')?></button>`);
                        jQuery('#discount-val').html(`${response.html}`);
                        location.reload();
                    }
                    
                }
            });
        } else {
            jQuery('#claimInfoMessage').html(`<?=__('Please input the correct amount','gtw-payment-gateway')?>`);
        }

    }

    // Form submit function onclick='enter_gift_card_number()'
    function enter_gift_card_number() {
        let cardNum = jQuery("input[name='gift_claim_card_number']").val();
        let cardPay = jQuery("input[name='pay_amount']").val();

        jQuery('#processingMessage').html(`<?=__('Please wait we are processing ...','gtw-payment-gateway')?>`);
        jQuery('.dis-btn').html(`<button disabled class="btn-gift-claim" style="cursor: not-allowed;" type="button"><?=__('Claim','gtw-payment-gateway')?><span class="gift_loding">&#10044;</spa></button>`);

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: {
                action: 'gift_card_info_on_popup',
                card_num: cardNum,
                pay_amount: cardPay

            },
            success: function(response) { 
            
                jQuery('#processingMessage').html('');
                jQuery('.dis-btn').html(`<button onclick='enter_gift_card_number()' class="btn-gift-claim" type="button"><?=__('Claim','gtw-payment-gateway')?></button>`);
                // console.log(response);

                if(response.status == 'notok') {
                    if(response.message == 'Unauthenticated'){

                         //if( is_user_logged_in() ) { }
                        jQuery('#processingMessage').html(`<p class="info">${response.html}</p>`);

                    }else{
                        jQuery('#processingMessage').html(`<p class="info">${response.message}</p>`);
                        // location.reload();
                    }
                } else {
                    jQuery(".popup-model-main.for_open").addClass('model-open');
                    
                    // let obj = JSON.parse(response.html);
                    // console.log(response.html);

                    jQuery('#claim-card-info').html(`${response.html}`);

                }
            }
        });
    }
 
</script>
<?php 
}

// Ajax process for gift_card_info_on_popup()
function gift_card_info_on_popup() {
    
        $giftCardNumber = sanitize_text_field($_POST["card_num"]);
        $amountDue      = sanitize_text_field($_POST["pay_amount"]);

        creat_token();
        $giftCardToken = get_option('gift_card_token');

        // echo $giftCardToken;
        $curl = curl_init();
        // SAND-EX-2 
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.gifttowallet.com/api/transactionlist?card_number='.$giftCardNumber,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$giftCardToken
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);

        $obj = json_decode($response, true);

        $apiCall = $obj['success']; // true | false

        // if($apiCall == false){
        if($obj["message"] == 'Unauthenticated'){
            if(current_user_can('administrator')){
                echo json_encode(['status'=>'notok', 'message' => 'Unauthenticated','html'=>__('Please set your credential from Dashboard.','gtw-payment-gateway')]);
            } else {
                $admin_email=get_option('admin_email');
                echo json_encode(['status'=>'notok', 'message' => 'Unauthenticated','html'=>__('Sorry! there is some issues in configuration, please contact with us at ','gtw-payment-gateway').$admin_email]);
            }
        } else {

        if(isset($obj["status"])){
            // invalid card
            echo json_encode(['status'=>'notok', 'message' => __('invalid card','gtw-payment-gateway'), 'html'=>'']);

        }else{
            // print_r($obj);

            $expiry_date=$obj["result"]["expiry_date"];
            $card_type=$obj["result"]["card_type"];
            $total_transactions=$obj["result"]["total_transactions"];

            $current_date=date("Y-m-d h:i:s");

            $date_current = strtotime($current_date);
            $date_expiry  = strtotime($expiry_date);


        if($date_current > $date_expiry){
            echo json_encode(['status'=>'notok', 'message' => __('Card expired','gtw-payment-gateway'),'html'=>'']);
        }else{
            if($card_type=='experience' && $total_transactions>0){
                echo json_encode(['status'=>'notok', 'message' => __('Card Used','gtw-payment-gateway'),'html'=>'']);
            }else{

                if($card_type=='experience'){

                    $cardNum = $obj["result"]["card_number"];
                    $cardBal = $obj["result"]["initial_balance"];
                    
                    $experience_html = '
                    <div>
                    
                        <h3>'.__('Information about the gift card you entered','gtw-payment-gateway').'</h3>
                        <p>'.__('Gift card number: ','gtw-payment-gateway').$cardNum.'</p>
                        <div class="gift-card-info">
                            <input type="hidden" name="cardId" value="'.$cardNum.'">
                            <input type="hidden" name="cardBal" value="'.$cardBal.'">
                        </div>

                        <p>'.__('Expiration date : ','gtw-payment-gateway').$obj["result"]["expiry_date"].'</p>
                        <p>'.__('Card Claim Value: ','gtw-payment-gateway').$cardBal.' Kr.</p>
                        <p>'.__('Payable Amount: ','gtw-payment-gateway').$amountDue.' kr.</p>
                        <div class="gift-btn-wrap">
                            <div id="claimSMS"></div>
                            <span class="dis-btn">
                                <button onclick="experience_gift_card_claim()" class="btn-gift-claim" type="button">'.__('Claim','gtw-payment-gateway').'</button>
                            </span>
                        
                        </div>
                    </div>
                    ';
                    echo json_encode(['status'=>'ok', 'message' => '','html'=> $experience_html]);
                
                    }else{
                        
                        $cardNum = $obj["result"]["card_number"];
                        $cardVal = $obj["result"]["current_balance"];
                        
                        $reg_html = '
                        <div>
                        
                            <h3>Information about the gift card you entered</h3>
                            <p>'.__('Gift card number : ','gtw-payment-gateway').$obj["result"]["card_number"].'</p>
                            <p>'.__('Expiration date  : ','gtw-payment-gateway').$obj["result"]["expiry_date"].'</p>
                            <p>'.__('Remaining balance: ','gtw-payment-gateway').$cardVal.'</p>
                            <p>'.__('Initial balance  : ','gtw-payment-gateway').$obj["result"]["initial_balance"].'</p>
                            <p>'.__('Claim Value:','gtw-payment-gateway').' <span>*</span> ('.__('Ex: 1, 100, 101, 1101, 111.110, 111110','gtw-payment-gateway').')</p>
                            <p>'.__('Payable Amount: ','gtw-payment-gateway').$amountDue.' kr.</p>
                            <div class="gift-card-info">
                                <input type="hidden" id="cardid" name="cardid" value="'.$cardNum.'">
                                <input type="hidden" name="cardBalance" value="'.$cardVal.'">
                                <input class="gift-input" type="number" name="cardValue" value="" placeholder="Enter Claim Value">
                            </div>
                            <div class="gift-btn-wrap">
                                <div id="claimInfoMessage"></div>
                                <span class="dis-btn">
                                    <button onclick="regular_gift_card_claim()" class="btn-gift-claim" type="button">'.__('Claim','gtw-payment-gateway').'</button>
                                </span>
                                
                            </div>
                        </div>
                        ';

                        echo json_encode(['status'=>'ok', 'message' => '','html'=> $reg_html]);
                        
                    }
                }
            }

        }

    }

    exit();

}
add_action('wp_ajax_gift_card_info_on_popup', 'gift_card_info_on_popup');
add_action('wp_ajax_nopriv_gift_card_info_on_popup', 'gift_card_info_on_popup');


// Ajax process for experience_claim_type()
function experience_claim_type() {

    $giftCardNumber   = sanitize_text_field($_POST["card_num"]);
    $giftCardValue    = sanitize_text_field($_POST["card_bal"]);
    $giftCardOrderId  = sanitize_text_field($_POST["order_id"]);
    $order  = wc_get_order($giftCardOrderId);
    // echo $giftCardNumber;

    // $cardRel= check_card_blance($giftCardNumber);

    // if($cardRel>0 && $cardRel=$giftCardValue){

        creat_token();
        $giftCardToken = get_option('gift_card_token');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.gifttowallet.com/api/card/reedem',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('card_number' => $giftCardNumber,'redeem_value' => $giftCardValue),
            CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$giftCardToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $obj = json_decode($response, true);
        //print_r($obj);
        if($obj["result"]){
            // $expiry_date      =$obj["result"]["expiry_date"];
            // $remainingBalance =$obj["result"]["remaining_balance"];
            $transactionId    =$obj["result"]["transaction_id"];

            $gift_card=$giftCardNumber;
            $gift_card_amount=$giftCardValue;
            $gift_card_tid   =$transactionId;
        
            $gift_cards  = get_post_meta($giftCardOrderId, 'gift_cards_payment_record', true );
            $payment_old = get_post_meta($giftCardOrderId, 'total_payment', true );
            if($gift_cards){

                array_push($gift_cards, [$gift_card,$gift_card_amount,$gift_card_tid]);
                    
                update_post_meta( $giftCardOrderId, 'gift_cards_payment_record', $gift_cards);
                $tpayment = $payment_old + $gift_card_amount;
                update_post_meta( $giftCardOrderId, 'total_payment', $tpayment);
                    
            }else{
                add_post_meta( $giftCardOrderId, 'gift_cards_payment_record', [[$gift_card,$gift_card_amount,$gift_card_tid]], true  );
                add_post_meta( $giftCardOrderId, 'total_payment', $gift_card_amount, true  );
                $tPayment=$gift_card_amount;
            }
            
            // change order status here
            $dueAmount = $order->get_total() - $tPayment;
            // echo $dueAmount; 

            if($dueAmount==0) {
                $order->update_status( 'completed' );
                $order->save();
            }
                
            echo json_encode(['status'=>'ok', 'message' => '','html'=> $thanks_html]);

        }else {
            echo json_encode(['status'=>'notok', 'message' => "Permission denied",'html'=> $thanks_html]);
        }

    exit();
}
add_action('wp_ajax_experience_claim_type', 'experience_claim_type');
add_action('wp_ajax_nopriv_experience_claim_type', 'experience_claim_type');


// Ajax process for regular_claim_type()
function regular_claim_type() {

    $giftCardNumber = sanitize_text_field($_POST["card_num"]);
    $giftCardValue  = sanitize_text_field($_POST["card_val"]);
    $giftCardBalan  = sanitize_text_field($_POST["card_bal"]);
    $giftCardOrderId  = sanitize_text_field($_POST["order_id"]);
    $order  = wc_get_order($giftCardOrderId);

    $cardRel= check_card_blance($giftCardNumber);

    if($cardRel>0 && $cardRel>=$giftCardValue){
        
        // echo $giftCardNumber;
        creat_token();
        $giftCardToken = get_option('gift_card_token');
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.gifttowallet.com/api/card/reedem',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('card_number' => $giftCardNumber,'redeem_value' => $giftCardValue),
            CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$giftCardToken
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;


        $obj = json_decode($response, true);
        // $apiRes = $obj['success']; //[success] => 1 | [message] => Reedem successfully. | [message] => Permission denied
        if($obj["result"]){
            $expiry_date      =$obj["result"]["expiry_date"];
            $remainingBalance =$obj["result"]["remaining_balance"];
            $transactionId    =$obj["result"]["transaction_id"];
            

            $thanks_html = '';

            $gift_card       =$giftCardNumber;
            $gift_card_amount=$giftCardValue;
            $gift_card_tid   =$transactionId;
            
            $gift_cards  = get_post_meta($giftCardOrderId, 'gift_cards_payment_record', true );
            $old_payment = get_post_meta($giftCardOrderId, 'total_payment', true );
            if($gift_cards){

                array_push($gift_cards, [$gift_card,$gift_card_amount,$gift_card_tid]);
                    
                update_post_meta( $giftCardOrderId, 'gift_cards_payment_record', $gift_cards);
                $tPayment = $old_payment+$gift_card_amount;
                update_post_meta( $giftCardOrderId, 'total_payment',$tPayment);
        
            }else{
                add_post_meta( $giftCardOrderId, 'gift_cards_payment_record', [[$gift_card,$gift_card_amount,$gift_card_tid]], true  );
                add_post_meta( $giftCardOrderId, 'total_payment', $gift_card_amount, true  );
                $tPayment=$gift_card_amount;
            }

            // change order status here
            $dueAmount = $order->get_total() - $tPayment;
            // echo $dueAmount; 

            if($dueAmount==0) {
                $order->update_status( 'completed' );
                $order->save();
            }

            echo json_encode(['status'=>'ok', 'message' => '','html'=> $thanks_html]);
        }else{
        echo json_encode(['status'=>'notok', 'message' => "Permission denied",'html'=> $thanks_html]);
        }

    }else {
        echo json_encode(['status'=>'notok', 'message' => "don't try to be smart",'html'=> $thanks_html]);
    }

    exit();
}
add_action('wp_ajax_regular_claim_type', 'regular_claim_type');
add_action('wp_ajax_nopriv_regular_claim_type', 'regular_claim_type');

add_action( 'woocommerce_thankyou', 'gift_card_session_data_remove' );
function gift_card_session_data_remove() {

    // Only in thankyou "Order-received" page
    if( ! is_wc_endpoint_url( 'order-received' ) )
    return; // Exit

    global $wp;

    // Get the order ID
    $order_id  = absint( $wp->query_vars['order-received'] );
    $order     = wc_get_order($order_id);

    $orderStatus  = $order->get_status();
    $orderPaymentM= $order->get_payment_method();
    // $orderPaymentMt  = $order->get_payment_method_title();

    if($orderStatus=='pending' && $orderPaymentM=='gifttowallet'){

        $gift_cards = get_post_meta($order_id, 'gift_cards_payment_record', true );
        //print_r($gift_cards);
        if($gift_cards && is_array($gift_cards)){
            ?>
            <div class="gift_card_amount_t">
                <h2 class="woocommerce-order-details__title"><?=__('Gift Card Payment Information','gtw-payment-gateway')?></h2>
                <table>
                    <thead>
                        <tr>
                            <th><?=__('Sl.:','gtw-payment-gateway')?></th>
                            <th><?=__('Gift Card No:','gtw-payment-gateway')?></th>
                            <th><?=__('Transaction Id','gtw-payment-gateway')?></th>
                            <th><?=__('Amount','gtw-payment-gateway')?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $amount = 0;
                    foreach($gift_cards as $k=>$card){
                    echo '
                    <tr>
                        <td>'.($k+1).'</td>
                        <td>'.$card[0].'</td>
                        <td>'.$card[2].'</td>
                        <td>'.$card[1].'</td>
                    </tr>';
                    $amount += $card[1];
                //break;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" ><b><?=__('Total Payment Amount','gtw-payment-gateway')?></b></td>
                            <td><?php echo $amount; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" ><?=__('Due amount','gtw-payment-gateway')?></td>
                            <td><?php 
                                $dueAmount = $order->get_total() - $amount;
                                echo $dueAmount; 
                            ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
        }
    }
}


// Ajax process for save data to option table.
function gift_to_wallet_save_credential() {
    $giftCardUserEmail = sanitize_email($_POST['email']);
    $giftCardUserPassword = sanitize_text_field($_POST['password']);
    
    if(is_email( $giftCardUserEmail )){

        update_option('gift_to_wallet_email',$giftCardUserEmail);
        update_option('gift_to_wallet_pass',$giftCardUserPassword);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.gifttowallet.com/api/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => $giftCardUserEmail,'password' => $giftCardUserPassword ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $obj = json_decode($response, true);
        if($obj["success"]==1){

            $giftToken = $obj["result"]["token"];
            $tokenSetTime = date('Y-m-d h:i:s');
            
            update_option('gift_card_token',$giftToken);
            update_option('gift_card_token_set_time',$tokenSetTime);

            echo json_encode(['status'=>'ok', 'message' => '' ]);
            // echo $response;
        } else {
            $token = " ";
            $tokenTime = " ";
            update_option('gift_card_token',$token);
            update_option('gift_card_token_set_time',$tokenTime);

            echo json_encode(['status'=>'not_ok', 'message' => __('Token was not ganarated plese check your credential Or try again after sometime.','gtw-payment-gateway') ]);
        }
        
    }else{
        
        echo json_encode(['status'=>'not_ok', 'message' => __('Plese input valid email','gtw-payment-gateway') ]);
    }
    exit();
}
add_action('wp_ajax_gift_to_wallet_save_credential', 'gift_to_wallet_save_credential');
add_action('wp_ajax_nopriv_gift_to_wallet_save_credential', 'gift_to_wallet_save_credential');


add_action('admin_footer', 'gift_card_pay_script');
function gift_card_pay_script(){
?>
<script>
    // Gift Card Claim Save Ajax Call
    function gift_card_credential() {
        ///let useGift  = jQuery('.gift-card-form').find(':checkbox:checked').val();
        
        let emailId = jQuery('.gift-card-form').find("input[name='gift_to_wallet_use_email']").val();
        let userPassword = jQuery('.gift-card-form').find("input[name='gift_to_wallet_use_password']").val();

        jQuery('#giftMessage').html(`<p class="info"><?=__('Please wait! we are processing...','gtw-payment-gateway')?></p>`);

        // WP Ajax Call
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            data: {
                action: 'gift_to_wallet_save_credential',
                email: emailId,
                password: userPassword
            },
            success: function (response) {

                jQuery('#giftMessage').html(" ");
                // console.log(typeof response);
                //let obj = JSON.parse(response);

                if (response.status == 'ok') {
                    jQuery('#giftMessage').html(`<p class="info"><?=__('Successfully saved your credential.','gtw-payment-gateway')?></p>`);
                } else {
                    jQuery('#giftMessage').html(`<p class="info">${response.message}</p>`);
                    // alert("This action only for admin.");
                    // console.log(response.message);
                    
                }
            }
        });
    }

</script>
<?php
}

function gift_card_token(){
    
    $giftCardToken = get_option('gift_card_token');
    $tokenSetTime  = get_option('gift_card_token_set_time');
    $userEmail     = get_option('gift_to_wallet_email');
    $userPass      = get_option('gift_to_wallet_pass');

    if($userEmail && $userPass){
        if($giftCardToken != null && $tokenSetTime != null){
            $datetime_1 = $tokenSetTime;
            $datetime_2 = date('Y-m-d h:i:s');
            $start_datetime = new DateTime($datetime_1); 
            $diff = $start_datetime->diff(new DateTime($datetime_2)); 
            $time = $diff->h; 
            
            if( $time > 20 ) {

                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://admin.gifttowallet.com/api/login',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('email' => $userEmail,'password' => $userPass ),
                ));
        
                $response = curl_exec($curl);
        
                curl_close($curl);
        
                $obj = json_decode($response, true);
                
                if($obj["success"]==1){

                    $giftToken = $obj["result"]["token"];
                    // update_user_meta( $userId, 'gift_card_token',$giftToken );
                    update_option('gift_card_token',$giftToken);
            
                    $tokenSetTime = date('Y-m-d h:i:s');
                    // update_user_meta( $userId, 'gift_card_token_set_time',$tokenSetTime );
                    update_option('gift_card_token_set_time',$tokenSetTime);
            
                    // echo $response;
                } else {
                    echo __("Token was not ganarated plese reload you page Or try again after sometime.",'gtw-payment-gateway');
                }
        
            } 

        } else {
            
            $curl = curl_init();
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://admin.gifttowallet.com/api/login',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('email' => $userEmail,'password' => $userPass ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $obj = json_decode($response, true);

            if($obj["success"]==1){

                $giftToken = $obj["result"]["token"];
                update_option('gift_card_token',$giftToken );
        
                $tokenSetTime = date('Y-m-d h:i:s');
                update_option('gift_card_token_set_time',$tokenSetTime );
        
                // echo $response;
            }
        }
    }
}


function creat_token(){
    $userEmail     = get_option('gift_to_wallet_email');
    $userPass      = get_option('gift_to_wallet_pass');

    $datetime_1 = get_option('gift_card_token_set_time');
    $datetime_2 = date('Y-m-d h:i:s');
    $start_datetime = new DateTime($datetime_1); 
    $diff = $start_datetime->diff(new DateTime($datetime_2)); 
    $time = $diff->h; 
    
    if( $time > 20 ) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.gifttowallet.com/api/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('email' => $userEmail,'password' => $userPass ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $obj = json_decode($response, true);

        if($obj["success"]==1){

            $giftToken = $obj["result"]["token"];
            update_option('gift_card_token',$giftToken );

            $tokenSetTime = date('Y-m-d h:i:s');
            update_option('gift_card_token_set_time',$tokenSetTime );

            // echo $response;
        }
    }
}


// Check Blance 

function check_card_blance($giftCardNumber){
    creat_token();
    $giftCardToken = get_option('gift_card_token');

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://admin.gifttowallet.com/api/transactionlist?card_number='.$giftCardNumber,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$giftCardToken
        ),
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);

    $obj = json_decode($response, true);

    $apiCall = $obj['success']; // true | false

    $expiry_date=$obj["result"]["expiry_date"];
    $card_type=$obj["result"]["card_type"];
    $total_transactions=$obj["result"]["total_transactions"];

    if($card_type=='experience' && $total_transactions>0){
        $cardVal = 0;
        return $cardVal;

    }else{
        if($card_type=='experience'){
            $cardNum = $obj["result"]["card_number"];
            $cardBal = $obj["result"]["initial_balance"];
        } else {
            $cardNum = $obj["result"]["card_number"];
            $cardVal = $obj["result"]["current_balance"];
        }
        return $cardVal;
    }
}
