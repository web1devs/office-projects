<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;
$product_id=$product->get_id();
$image_id=$product->get_image_id();
$default_image=plugin_dir_url( __FILE__ ).'assets/images/christmas-1.jpg';


$currency=get_woocommerce_currency_symbol();

$min_price=0;
$min_price=get_post_meta($product_id,'_giftcard_min_price',true);
if($min_price>0){
	
}else{
	$min_price=$product->get_regular_price();
}
?>

<div id="gift_card_image_box_html">
	
	<div id="product-top-images"><img src="<?=plugin_dir_url( __FILE__ )?>assets/images/logo_new_white.png"></div>
	<div class="image_box">
		<?php
			echo '<img src="'.$default_image.'" id="gift_card_image" class="gift_card_image gcard-image image1" style="display:block;">';
		?>
	</div>
	<div class="box_content">
		<div class="min_price">
			<p><strong>Dagsetning:</strong> <span id="Date" class="Date _Date"></span></p>
			<p id="gift_card_value" class="gift_card_value"><?=wc_price($min_price)?></p>
		</div>
		<div class="rec_name">
			<p style="display:none;"><span id="gift_card_recipient_name_text"></span></p>
			<p style="display:none;">Frá: <span id="gift_card_recipient_email_text"></span></p>
		</div>
		<div class="barcode-text-box">
			<div class="card_mgs">
				<p id="gift_card_message_text"  class="gift_card_message_text"></p>
			</div>
			<div class="barcode-image">
				<img class="qrcode-image" style="width: 130px;" src="<?=plugin_dir_url( __FILE__ )?>assets/images/qrcode-1.png">
			</div>
		</div>
		<div class="barcode-image-second">
				<img class="qrcode-image-second-mini" style="max-width: 230px;" src="<?=plugin_dir_url( __FILE__ )?>assets/images/barcode.jpg">
			</div>
	</div>



		<hr class="divider-line-hr">

				<table class="padding-bottom-table">
					<tr class="border-hide-product-page">
						<td class="product-table-bottom-text product-table-bottom-mobile">
							<p class="product-bottom-text">Til hamingju með gjafakort Byko. Skannaðu QR kóðann og fáðu gjafakortið beint í rafrænt veski í símanum þínum.  Eins og er er því miður ekki hægt að greiða með gjafakorti í vefverslun Byko.</p>
						</td>
					</tr>
				</table>

</div>
