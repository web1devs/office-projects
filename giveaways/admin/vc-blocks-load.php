<?php

//================Vc block load code ==============================
	if( ! defined('ABSPATH' ) ) die('-1');
 	// Class started
 	Class stockVCExtendAddonClass{

 		function __construct(){
 			// we safely integrate with VC with this hook
 			add_action('init', array( $this, 'stockIntegrateWithVC'));
 		}

 		public function stockIntegrateWithVC() {
             // Checks if Visual Composer is not installed
 			if( ! defined( 'WPB_VC_VERSION' ) ){
 				add_action('admin_notices', array( $this, 'stockShowVcVersionNotice' ));
 				return;
             }
             

 			// vissual composer addons
			 include('give-way.php');
			 
			 // Load Stock Default Templates
            //  include_once plugin_dir_path(__FILE__). '/admin/vc-templates.php';
             			
 			}

 		// show visual composer version
 		public function stockShowVcVersionNotice() {
 			$theme_data = wp_get_theme();
 			echo '
	 			<div class="notice notice-warning">
				    <p>'.sprintf(__('<strong>%s</strong> recommends <strong><a href="'.site_url().'/wp-admin/themes.php?page=tgmpa-install-plugins" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'strock-crazycafe'), $theme_data->get('Name')).'</p>
				</div>
 			';
 		}
 	}

// Finally initialize code
new stockVCExtendAddonClass();