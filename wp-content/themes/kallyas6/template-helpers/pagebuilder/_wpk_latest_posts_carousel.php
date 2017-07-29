<?php

function _wpk_latest_posts_carousel( $options )
{
    $numPosts   = isset( $options['lpc_num_posts'] ) ? $options['lpc_num_posts'] : 10; // how many posts
    $categories = isset( $options['lpc_categories'] ) ? $options['lpc_categories'] : get_option('default_category');
    $title = isset( $options['lpc_title'] ) ? $options['lpc_title'] : __('Latest Posts', THEMENAME);

    // Start the query
    $queryArgs = array(
        'post_type'      => 'post',
        'posts_per_page' => $numPosts,
        'category__in' => $categories
    );
    $theQuery = new WP_Query($queryArgs);

    if ( $theQuery->have_posts() )
    {
        ?>
        <div class="latest_posts default-style latest-posts-carousel">
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="m_title"><?php echo $title;?></h3>
                    <div class="controls">
                        <a href="#" class="prev" style="display: inline;"><span class="icon-chevron-left"></span></a>
                        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) );?>" class="complete"><span class="icon-th"></span></a>
                        <a href="#" class="next" style="display: inline;"><span class="icon-chevron-right"></span></a>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <ul class="lp_carousel fixclear">
<?php
        // Start the loop
        while ( $theQuery->have_posts() ) {
            $theQuery->the_post();
            wpk_latest_posts_carousel_helper();
        } /* end while */
        wp_reset_postdata();
?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }
}

// this method generates the needed html for the carousel
//@see: wpk_latest_posts_carousel
function wpk_latest_posts_carousel_helper()
{
    // post categories
    $categories = get_the_category();
    $separator = ', ';
    $catList = '';
    if($categories){
        foreach($categories as $category) {
            $catList .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
        }
        $catList = trim($catList, $separator);
    }
    $permalink = get_the_permalink();
    $featuredImage = get_the_post_thumbnail();
    ?>
    <li class="post">
        <a href="#" class="hoverBorder plus">
            <span class="hoverBorderWrapper"><?php echo $featuredImage;?><span class="theHoverBorder"></span></span>
            <h6><a href="<?php echo $permalink;?>"><?php _e('Read more +', THEMENAME);?></a></h6>
        </a>
        <em><?php the_date();?> <?php _e('By', THEMENAME);?> <?php the_author();?> <?php _e('in', THEMENAME);?> <?php echo $catList;?></em>
        <h3 class="m_title"><a href="<?php echo $permalink;?>"><?php the_title();?></a></h3>
    </li>
<?php
}
