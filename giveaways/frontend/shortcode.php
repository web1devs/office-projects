<?php
function single_giveaway_buy_product_button_shortcode( $atts = []) {
    global $post;
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	// override default attributes with user attributes
	$_atts = shortcode_atts(
		array(
			'product_id' => '',
		), $atts
	);
    $o='<a 
    class="nectar-button n-sc-button large accent-color has-icon regular-button giveaways_add_to_cart" 
    style="visibility: visible;" 
    data-color-override="false" 
    data-hover-color-override="false" 
    data-id="'.$_atts["product_id"].'" 
    data-g="'.$post->ID.'" 
    data-hover-text-color-override="#fff">Get Tickets<i class="icon-button-arrow"></i></a>';
	// return output
	return $o;
}

/**
 * Central location to create all shortcodes.
 */
function giveaways_shortcodes_init() {
	add_shortcode( 'giveaways_product_add_to_cart_button', 'single_giveaway_buy_product_button_shortcode' );
}

add_action( 'init', 'giveaways_shortcodes_init' );


// add Button Short code
add_shortcode('individual_giveaway_add_to_cart_button','btn_short_code_fun');
function btn_short_code_fun($jekono){ 
$result = shortcode_atts(array( 
   
   'text' =>'',
   'btn_size' =>'',
   'btn_style' =>'',
   'color_override' =>'',
   'btn_fonts' =>'',

),$jekono);
extract($result);
ob_start();
?>
<!-- Start html code here  -->

	<style>
		.giveways-btn {
			border: 0;
			cursor: pointer;
		}
		.medium {
			padding: 16px 50px;
			text-transform: uppercase;
			font-weight: 700;
			color:#b09c78;
		}
	</style>
	<!-- <a href="http://" target="_blank" rel="noopener noreferrer"></a> -->

	<button class="giveways-btn <?=$btn_size.' '.$btn_style?>" style="background: <?=$color_override?>;">
		<?=$text?>  <i class="<?=$btn_fonts?>"></i>
	</button>
	<!-- <div class="nectar-cta alignment_tablet_default alignment_phone_default display_tablet_inherit display_phone_inherit position_desktop_absolute right_position_desktop_40px left_position_desktop_40px bottom_position_desktop_40px "
	data-color="accent-color" data-using-bg="true" data-style="text-reveal-wave" data-display="block"
	data-alignment="center" data-text-color="custom">
		<span style="color: #ffffff;" class="nectar-button-type">
			<span class="link_wrap hover" style="padding-top: 0.8em; padding-right: 40px; padding-bottom: 0.8em; padding-left: 40px;">
				<a class="link_text" href="">
					<span class="text">
						<span class="char" style="animation-delay: 0s;">G</span>
						<span class="char" style="animation-delay: 0.015s;">e</span>
						<span class="char" style="animation-delay: 0.03s;">t</span>
						<span class="char" style="animation-delay: 0.045s;">S</span>
						<span class="char" style="animation-delay: 0.06s;">t</span>
						<span class="char" style="animation-delay: 0.075s;">a</span>
						<span class="char" style="animation-delay: 0.09s;">r</span>
						<span class="char" style="animation-delay: 0.105s;">t</span>
						<span class="char" style="animation-delay: 0.12s;">e</span>
						<span class="char" style="animation-delay: 0.135s;">d</span>
					</span>
				</a>
			</span>
		</span>
	</div> -->

<!-- End html code here  -->
<?php
return ob_get_clean();
}








/**
 * Button shortcode.
 *
 * @since 1.0
 */
function nectar_button_short_code_fun($atts, $content = null) {  
  
    extract(shortcode_atts(array(
			"size" => 'small', 
			"url" => '#', 
			'color' => 'Accent-Color', 
			'color_override' => '', 
			'hover_color_override' => '', 
			'hover_text_color_override' => '#fff', 
			"text" => 'Button Text', 
			'image' => '', 
			'open_new_tab' => '0'), $atts));
	
  	$target = ($open_new_tab === 'true') ? 'target="_blank"' : null;
  	
  	//icon
  	if(!empty($image) && strpos($image,'.svg') !== false) {
			
  		if(!empty($image)) { 
				$button_icon = '<img src="'.get_template_directory_uri() . '/css/fonts/svg/'.$image.'" alt="icon" />'; 
				$has_icon = ' has-icon'; 
			} else { 
				$button_icon = null; 
				$has_icon = null; 
			}
			
  	} else {

  		if(!empty($image)) { 
  			$fontawesome_extra = null; 
  			if(strpos($image, 'fa-') !== false) {
					$fontawesome_extra = 'fa '; 
				}
  			$button_icon = '<i class="' . $fontawesome_extra . $image .'"></i>'; 
				$has_icon = ' has-icon'; 
  		} 
  		else { 
				$button_icon = null; 
				$has_icon = null; 
			}
			
			if( strpos($image,'iconsmind-') !== false ) {
				wp_enqueue_style( 'iconsmind' );
			}
			
  	}
  	
  	//standard arrow icon
  	if($image === 'default-arrow') {
			$button_icon = '<i class="icon-button-arrow"></i>';
		}
  	
  	$stnd_button = null;
  	if( strtolower($color) === 'accent-color' || 
			strtolower($color) === 'extra-color-1' || 
			strtolower($color) === 'extra-color-2' || 
			strtolower($color) === 'extra-color-3') {
  		$stnd_button = " regular-button";
  	}
  	
  	$button_open_tag = '';

  	if($color === 'accent-color-tilt' || 
			$color === 'extra-color-1-tilt' || 
			$color === 'extra-color-2-tilt' || 
			$color === 'extra-color-3-tilt') {
				
  		$color = substr($color, 0, -5);
  		$color = $color . ' tilt';
  		$button_open_tag = '<div class="tilt-button-wrap"> <div class="tilt-button-inner">';
  	}

  	switch ($size) {
  		case 'small' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button small '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;
  		case 'medium' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button medium ' . esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;
  		case 'large' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button large '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;	
  		case 'jumbo' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button jumbo '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;	
  		case 'extra_jumbo' :
  			$button_open_tag .= '<a class="nectar-button n-sc-button extra_jumbo '. esc_attr(strtolower($color)) . $has_icon . $stnd_button.'" '. $target;
  			break;	
  	}
  	
  	$color_or                  = (!empty($color_override)) ? 'data-color-override="'. esc_attr($color_override).'" ' : 'data-color-override="false" ';	
  	$hover_color_override      = (!empty($hover_color_override)) ? ' data-hover-color-override="'. esc_attr($hover_color_override).'"' : 'data-hover-color-override="false"';
  	$hover_text_color_override = (!empty($hover_text_color_override)) ? ' data-hover-text-color-override="'. esc_attr($hover_text_color_override) .'"' :  null;	
  	$button_close_tag          = null;

  	if($color === 'accent-color tilt' || 
			$color === 'extra-color-1 tilt' || 
			$color === 'extra-color-2 tilt' || 
			$color === 'extra-color-3 tilt') {
			$button_close_tag = '</div></div>';
		}

  	if($color !== 'see-through-3d') {
			
  		if($color === 'extra-color-gradient-1' || 
      $color === 'extra-color-gradient-2' ||
       $color === 'see-through-extra-color-gradient-1' || 
       $color === 'see-through-extra-color-gradient-2') {
  			return $button_open_tag . ' href="' . esc_url($url) . '" '.$color_or.$hover_color_override.$hover_text_color_override.'><span class="start loading">' . wp_kses_post($text) . $button_icon. '</span><span class="hover">' . $text . $button_icon. '</span></a>'. $button_close_tag;
  		}
      else {
  			return $button_open_tag . ' href="' . esc_url($url) . '" '.$color_or.$hover_color_override.$hover_text_color_override.'><span>' . wp_kses_post($text) . '</span>'. $button_icon . '</a>'. $button_close_tag;
      }

  	}
    
  	else {

  		$color  = (!empty($color_override)) ? $color_override : '#ffffff';
  		$border = ($size !== 'jumbo') ? 8 : 10;
			
  		if($size ==='extra_jumbo') {
				$border = 20;
			}
  		return '
  		<div class="nectar-3d-transparent-button" data-size="'.esc_attr($size).'">
  		     <a href="'.esc_url($url).'"><span class="hidden-text">'.wp_kses_post($text).'</span>
  			<div class="inner-wrap">
  				<div class="front-3d">
  					<svg>
  						<defs>
  							<mask>
  								<rect width="100%" height="100%" fill="#ffffff"></rect>
  								<text class="mask-text button-text" fill="#000000" width="100%" text-anchor="middle">'.wp_kses_post($text).'</text>
  							</mask>
  						</defs>
  						<rect id="" fill="'.esc_attr($color).'" width="100%" height="100%" ></rect>
  					</svg>
  				</div>
  				<div class="back-3d">
  					<svg>
  						<rect stroke="'.esc_attr($color).'" stroke-width="'.esc_attr($border).'" fill="transparent" width="100%" height="100%"></rect>
  						<text class="button-text" fill="'.esc_attr($color).'" text-anchor="middle">'.wp_kses_post($text).'</text>
  					</svg>
  				</div>
  			</div>
  			</a>
  		</div>
  		';
  }
}

add_shortcode('individual_giveaway_add_to_cart', 'nectar_button_short_code_fun');