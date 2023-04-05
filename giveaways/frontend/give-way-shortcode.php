<?php 
add_shortcode('give-way','news_title_section_func');
function news_title_section_func($jekono){
	$result = shortcode_atts(array(
		'posts_per_page' =>'4',
		'columns' =>'4',
		'giveaways_category' =>'all',
		'image_size' =>'medium',
		'pagination' =>'',
		'order' =>'date',
		'orderby' =>'ASC',
		'css_class_name' =>'',
		// 'grid_item_spacing' =>'',
		'grid_item_height' =>'auto',
		'grid_style' =>'style_2',
		
	),$jekono);

	extract($result);

	ob_start(); 
	?>

<!--Start blog section-->
<section class="give-way-project">
    <div class="give-way-container">
        <div class="giv-way-row-wrap <?=$css_class_name?>">
        
            <?php 
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

            $arguments=array(
                'post_type' => 'giveaways', // giveaways | post
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'orderby' => $orderby, // Or 'date' any other valid value for 'orderby' | $orderby
                'order' => $order, // Or 'ASC' for ascending order | $order,
                // 'category_name' => 'all', // Your category slug or name | $giveaways_category
                
            );

            if($giveaways_category!='all' && $giveaways_category!=''){
                $arguments['tax_query'] = array(
                    array (
                        'taxonomy' => 'giveaways_category',
                        'field' => 'slug',
                        'terms' => $giveaways_category,
                    )
                );
            }

            $q = new WP_Query($arguments);
            if($q->have_posts()) {
                while($q->have_posts()):$q->the_post();
            ?>
            <?php if($grid_style=="style_1"){ ?>
            <div class="product_box gird-<?=$columns?>" style="height:<?=$grid_item_height?>;">
                
                <div class="product_header">
                    <div class="product_title">
                        <h4 class="heading"><?php the_title();?></h4>
                        <h4 class="heading product_price"> 
                            <?php 
                            $price = get_post_meta( get_the_ID(), 'giveaways_estimated_value', true );
                            if($price){
                                echo 'VALUED: '.$price;
                            }
                            ?>
                        </h4>
                    </div>

                    <span class="sub-heading">
                        <?php

                        // $postContent = wp_trim_words(get_the_content(),'5','');
                        if ( has_excerpt() ){
                            $postExcerpt = wp_trim_words(get_the_excerpt(),'5','');
                            echo $postExcerpt;
                        }
                      
                        ?>
                    </span>
                </div>

                <div class="product_image">
                    <?php the_post_thumbnail($image_size);?>
                </div>
                <div class="clock-btn">
                
                    <div class="counter-clock-wrapper">
                        
                        <?php echo do_shortcode('[cClock id="'.get_the_ID().'"]'); ?>
                        
                    </div>
                    <div class="product_action">
                        <a href="<?php the_permalink();?>" class="button" >
                            <?php echo esc_html('Enter now');?>
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </div>
                </div>
            </div>
                <!-- The end 1st style -->
                <?php } else { ?>

            <div class="product_box gird-<?=$columns?> style-2" style="height:<?=$grid_item_height?>;">
                <div class="product_image">
                    <?php the_post_thumbnail($image_size);?>
                </div>

                <div class="product_header">
                    <a href="<?php the_permalink();?>" >
                        <div class="product_title">
                            <h4 class="heading"><?php the_title();?></h4>
                            <h4 class="heading product_price"> 
                                <?php 
                                $price = get_post_meta( get_the_ID(), 'giveaways_estimated_value', true );
                                if($price){
                                    echo 'VALUED: '.$price;
                                }
                                ?>
                            </h4>
                        </div>

                        <span class="sub-heading">
                            <?php

                            // $postContent = wp_trim_words(get_the_content(),'5','');
                            if ( has_excerpt() ){
                                $postExcerpt = wp_trim_words(get_the_excerpt(),'5','');
                                echo $postExcerpt;
                            }
                        
                            ?>
                        </span>
                    </a>
                </div>

                <div class="clock-btn">
                
                    <div class="counter-clock-wrapper">
                        
                        <?php echo do_shortcode('[cClock id="'.get_the_ID().'"]'); ?>
                        
                    </div>
                    <div class="product_action">
                        <a href="<?php the_permalink();?>" class="button" >
                            <?php echo esc_html('Learn More');?>
                        </a>
                    </div>
                </div>
            </div>
                <!-- The end 2nd style -->
                <?php } ?>
           
            <?php endwhile;?> 
            
        </div>
        <?php 
        
        if ($pagination == 'number-more') {

            $total_pages = $q->max_num_pages;

            if ($total_pages > 1){
    
                $current_page = max(1, get_query_var('paged'));
    
                echo '<div class="give-way-pagination">'. paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => 'page/%#%',
                    'current' => $current_page,
                    'total' => $total_pages,
                    'prev_text'    => __('« prev'),
                    'next_text'    => __('next »'),
                )).'</div>';
    
            } 
        }
       


    }
        wp_reset_query();?>
    </div>

</section>
<!--End news section-->

<?php
	return ob_get_clean();
}

 ?>



