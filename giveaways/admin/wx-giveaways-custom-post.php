<?php 

/* giveaways custom post type hook here   */


 function wx_giveaways_custom_post() {

    $labels = [
        "name" => esc_html__( "Giveaways", "wx-giveaways" ),
        "singular_name" => esc_html__( "Giveaways", "wx-giveaways" ),
        "menu_name" => esc_html__( "Giveaways", "wx-giveaways" ),
        "all_items" => esc_html__( "All Giveaways", "wx-giveaways" ),
        "add_new" => esc_html__( "Add New Giveaways", "wx-giveaways" ),
    ];

    $args = [
        "label" => esc_html__( "Giveaways", "wx-giveaways" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "can_export" => false,
        "rewrite" => [ "slug" => "giveaways", "with_front" => true ],
        "query_var" => true,
        "menu_position" => 5,
        "menu_icon" => "dashicons-sos",
        "supports" => [ "title", "editor", "thumbnail", 'excerpt' ],
        "taxonomies" => [ "giveaways_category" ],
        "show_in_graphql" => false,
    ];

    register_post_type( "giveaways", $args );
    //flush_rewrite_rules();

    $labels = array(
        'name' => _x( 'Giveaways Categories', 'wx-giveaways' ),
        'singular_name' => _x( 'Giveaways Category', 'wx-giveaways' ),
        'search_items' =>  __( 'Search Category' , 'wx-giveaways'),
        'popular_items' => __( 'Popular Category', 'wx-giveaways' ),
        'all_items' => __( 'All Category', 'wx-giveaways' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Category' , 'wx-giveaways'), 
        'update_item' => __( 'Update Category' , 'wx-giveaways'),
        'add_new_item' => __( 'Add New Category' , 'wx-giveaways'),
        'new_item_name' => __( 'New Category Name' , 'wx-giveaways'),
        'separate_items_with_commas' => __( 'Separate category with commas', 'wx-giveaways' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories', 'wx-giveaways' ),
        'menu_name' => __( 'Category' , 'wx-giveaways'),
      ); 
      
    
      
      register_taxonomy('giveaways_category','giveaways',array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'giveaways-category' ),
      ));
}


add_action( 'init', 'wx_giveaways_custom_post');

require_once('wx-giveawasys-button-shortcode.php');