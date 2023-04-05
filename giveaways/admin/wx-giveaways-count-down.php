<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


// add countdown clock Short code
add_shortcode('cClock','countdown_clock_fun');
function countdown_clock_fun($atts){ 
    $result = shortcode_atts(array( 
    'id'=> '',
    ),$atts);

extract($result);
if($id>0){
    $post_id = $id;
}else{
    global $post;
    $post_id = $post->ID;
}
//opening date
$opening_date = get_post_meta($post_id,'giveaways_opening_date',true);
$closing_date = get_post_meta($post_id,'giveaways_closing_date',true);
$draw_date = get_post_meta($post_id,'giveaways_draw_date',true);


ob_start();

$date_str = $closing_date;
$c_date = new DateTime( $date_str);
$dw_date = $c_date->format('Y-m-d H:i:s');

 ?>

<!-- flip section start here -->
<div class="tick" data-credits="false" data-did-init="handleTickInit<?php echo $post_id;?>">
    <div data-repeat="true"
         data-layout="horizontal center fit"
         data-transform="preset(d, h, m, s) -> delay">
        <div class="tick-group">
            <div data-key="value"
                 data-repeat="true"
                 data-transform="pad(00) -> split -> delay">
                <span data-view="flip"></span>
            </div>
            <span data-key="label"
                  data-view="text"
                  class="tick-label"></span>
        </div>
    </div>
</div>

<script>
    function handleTickInit<?php echo $post_id;?>(tick) {
       
        let customDateTime = '<?php echo $dw_date; ?>';
        let counter = Tick.count.down(customDateTime);
        counter.onupdate = function(value) {
            tick.value = value;
        };

        counter.onended = function() {
            // hide counter, uncomment the next line
            tick.root.style.display = 'none';
            // show message, uncomment the next line
            document.querySelector('.tick-onended-message').style.display = '';
        };
    }
</script>
<div class="tick-onended-message" style="display:none">
    <?php
        if(strtotime(date('Y-m-d H:i:s'))>strtotime($dw_date)){
            $args = array(
                'headers' => array(
                    'x-api-key'=>VIRALSWEEP_API_KEY
                )
            );
            $promotion_id=get_post_meta($post_id,'viralsweep_giveaways_id',true);
            if($promotion_id>0){
                $body = wp_remote_retrieve_body( wp_remote_get( 'https://app.viralsweep.com/api/winners/'.$promotion_id,$args ) );
                $response = json_decode($body, true);
                if(count($response["winners"])>0){
                    $i=1;
                    foreach($response["winners"] as $winner){
                        $email = $winner["email"];
                        $prize = (isset($winner["prize"])?$winner["prize"]:'');
                        if($prize){
                            echo'<h2>'.$prize.'</h2>';
                            echo'<p>Winner '.$i.': '.$email.'</p>';
                        }else{
                            echo'<p>Winner '.$i.': '.$email.'</p>';
                        }

                        $i++;
                    }
                }
            }
        }
    ?>
</div>
<!-- End html code here  -->
<?php
return ob_get_clean();
}



