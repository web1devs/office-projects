<?php 

$post_types = array(
  esc_html__('Giveaways',' wx-giveaway') => 'giveaways', // post | giveaways | 'giveaways_category'
);

$is_admin = is_admin();


// Get Post Categories.
$args = array(
  'taxonomy' => 'giveaways_category',
  'orderby' => 'name',
  'order'   => 'ASC',
  'hide_empty' => false,
);
$blog_types = ($is_admin) ? get_categories($args) : array('All' => 'all');

// $cats = get_categories($args);
// print_r($cats);

$blog_options = array("All" => "all");

if( $is_admin ) {
	foreach ($blog_types as $type) {
		if(isset($type->name) && isset($type->slug)) {
			$blog_options[htmlspecialchars($type->slug)] = htmlspecialchars($type->slug);
    }
	}
} else {
	$blog_options['All'] = 'all';
}

// print_r($blog_options);

vc_map( 
    array(
  "name" => __( "Giveaway Post Gird", "wx-giveaway" ),
  "base" => "give-way",
  "category" => __( "Giveaway", "wx-giveaway"),
  "params" => array(
    array(
      "type" => "textfield",
      "heading" => __( "Posts Per page", "wx-giveaway" ),
      "param_name" => "posts_per_page",
			"description" => esc_html__("How many posts would you like to display per page?  Enter as a number example \"10\"", "wx-giveaway")
    ),
    array(
      "type" => "dropdown_multi",
      "heading" => esc_html__("Giveaways Category", "wx-giveaway"),
      "param_name" => "giveaways_category",
      "value" => $blog_options,
      'save_always' => true,
      // "dependency" => array('element' => "post_type", 'value' => 'post'),
      "description" => esc_html__("Please select the category you would like to display for your blog. You can also select multiple category if needed (ctrl + click on PC and command + click on Mac).", "wx-giveaway")
    ),
    array(
			"type" => "dropdown",
			"heading" => esc_html__("Order", "wx-giveaway"),
			"param_name" => "order",
			"admin_label" => false,
			"value" => array(
				'Descending' => 'DESC',
				'Ascending' => 'ASC',
			),
			'save_always' => true,
			"description" => esc_html__("Designates the ascending or descending order - defaults to descending", "wx-giveaway")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Orderby", "wx-giveaway"),
			"param_name" => "orderby",
			"admin_label" => false,
			"value" => array(
				'Date' => 'date',
				'Author' => 'author',
				'Title' => 'title',
				'Last Modified' => 'modified',
				'Random' => 'rand',
				'Comment Count' => 'comment_count'
			),
			'save_always' => true,
			"description" => esc_html__("Sort retrieved posts by parameter - defaults to date", "wx-giveaway")
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Pagination", "wx-giveaway"),
			"param_name" => "pagination",
			"admin_label" => false,
			"value" => array(
				'None' => 'none',
				'Number Pagination' => 'number-more',
				// 'Load More' => 'load-more',
				//'Page Number Links' => 'page-numbers',
			),
			'save_always' => true
		),
    array(
      'type' => 'dropdown',
      'heading' => esc_html__( 'Columns', 'wx-giveaway' ),
      'param_name' => 'columns',
      // "dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image','mouse_follow_image')),
      'value' => array(
        '4' => '4',
        '3' => '3',
        '2' => '2',
        '1' => '1'
      ),
      'std' => '4',
      'save_always' => true
    ),
    /*
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Grid Item Spacing", "wx-giveaway"),
      "param_name" => "grid_item_spacing",
      'save_always' => true,
			"dependency" => array('element' => "grid_style", 'value' => array('content_overlaid','content_under_image','vertical_list')),
      "value" => array(
        esc_html__("None", "wx-giveaway") => "none",
        "5px" => "5px",
        "10px" => "10px",
        "15px" => "15px",
        "25px" => "25px",
        "35px" => "35px",
        "40px" => "40px",
        "45px" => "45px",
        "2%" => "1vw",
        "4%" => "2vw",
        "6%" => "3vw",
        "8%" => "4vw",
      ),
      "description" => esc_html__("Please select the spacing you would like between your items. ", "wx-giveaway")
    ),
    */
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Grid Item Style", "wx-giveaway"),
      "param_name" => "grid_style",
      'save_always' => true,
      "value" => array(
        "Default" => "style_2",
        "Style - 1" => "style_1",
        "Style - 2" => "style_2"
      ),
      "description" => esc_html__("Please select the style you would like for your items to display in the grid view on.", "wx-giveaway")
    ),
    
    array(
      "type" => "textfield",
      "heading" => esc_html__("Grid Item Height", "wx-giveaway"),
      "param_name" => "grid_item_height",
      "placeholder" => esc_html__("350px", "wx-giveaway"),
      "description" => esc_html__("Please enter the height you would like for your items to display in. Default height auto that the grid is viewed on. ", "wx-giveaway")
    ),
		array(
      "type" => "dropdown",
      "class" => "",
      'save_always' => true,
      "heading" => esc_html__("Image Size", "wx-giveaway"),
      "param_name" => "image_size",
      "value" => array(
        "Default (Large)" => "large",
				"Small" => "thumbnail",
				"Small Landscape" => "portfolio-thumb",
				"Medium" => "medium",
				"Landscape" => "portfolio-thumb_large",
        "Large Featured" => "large_featured",
				"Full" => 'full'
      ),
			"description" => esc_html__("This option allows to you control what size image will load for each item in the grid. Useful to fine tune quality based on your specific use case.", "wx-giveaway"),
      'std' => 'large',
    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("CSS Class Name", "wx-giveaway"),
			"param_name" => "css_class_name",
			"description" => esc_html__("Add in any extra CSS Classes that you wish to be applied to the Post Grid element.", "wx-giveaway"),
		),





	

  )
 ) 
 );