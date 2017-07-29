<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       1.6.4
 */

get_header( 'shop' );

	// GET GLOBALS
	global $post;

	if(empty($post) || !isset($post->ID)){
		return;
	}

	global $znData;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}

	// GET THE META FIELDS
	$meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
	$meta_fields = maybe_unserialize( $meta_fields );

	/*--------------------------------------------------------------------------------------------------
		ACTION BOX AREA
	--------------------------------------------------------------------------------------------------*/
	zn_get_template_from_area( 'action_box_area', $post->ID, $meta_fields );


	// What sidebar to display: the one from Woo options or the one from the page options
	$sidebarID = '';

	// #1 Check Page options first
	$postMeta = get_post_meta($post->ID);
	if(! empty($postMeta) && !empty($meta_fields)){
        $info = $postMeta['zn_meta_elements'][0];
        $info = maybe_unserialize($info);
        $sid = (isset($info['sidebar_select']) ? $info['sidebar_select'] : '');
        // Check sidebar
        if(! empty($sid)){
            // check if has content
            if(WpkZn::isActiveSidebar($sid)){
                $sidebarID = $sid;
            }
        }
        unset($sid);
	}

	// Check WOO options if there are empty values
	if(empty($sidebarID)) {
		$optSid = (isset($znData['woo_single_sidebar']) && !empty($znData['woo_single_sidebar']) ? $znData['woo_single_sidebar'] : '');
		if(! empty($optSid) && WpkZn::isActiveSidebar($optSid)){
			$sidebarID = $optSid;
		}
		unset($optSid);
	}

    $postSidebarPosition = (isset($meta_fields['page_layout']) && !empty($meta_fields['page_layout']) ? $meta_fields['page_layout'] : '');

    if('no_sidebar' == $postSidebarPosition){
        $sidebarPosition = '';
    }
    elseif('default' == $postSidebarPosition){
        $optPos = (isset($znData['woo_single_sidebar_position']) && !empty($znData['woo_single_sidebar_position']) ? $znData['woo_single_sidebar_position'] : '');
        if(! empty($optPos)){
            $sidebarPosition = $optPos;
        }
        unset($optPos);
    }
    else {
        $sidebarPosition = $postSidebarPosition;
    }


	// Check to see whether or not we have a sidebar and a place to display it
	$has_sidebar = (!empty($sidebarID) && !empty($sidebarPosition));
?>
<section id="content">
	<div class="container">
		<div id="mainbody">
			<div class="row">
				<?php
					// Check if sidebar is enabled
					$content_css = 'span12';
					$sidebar_css = '';

					if($has_sidebar)
                    {
						// Left sidebar
						if($sidebarPosition == 'left_sidebar'){
							$content_css = 'span9 zn_float_right';
							$sidebar_css = 'sidebar-left';
						}
						// Right sidebar
						elseif($sidebarPosition == 'right_sidebar'){
							$content_css = 'span9';
							$sidebar_css = 'sidebar-right';
						}
					}
				?>

				<div class="<?php echo $content_css; ?>">
					<?php
						/**
						 * woocommerce_before_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
						 * @hooked woocommerce_breadcrumb - 20
						 */
						do_action( 'woocommerce_before_main_content' );
					?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'single-product' ); ?>

					<?php endwhile; // end of the loop. ?>

					<?php
						/**
						 * woocommerce_after_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the
						 *         content)
						 */
						do_action( 'woocommerce_after_main_content' );
					?>
				</div>

				<?php if ( $has_sidebar ) { ?>

					<div class="span3">
						<div id="sidebar" class="sidebar <?php echo $sidebar_css; ?>">
							<?php dynamic_sidebar( $sidebarID ); ?>
						</div>
					</div>
				<?php } ?>

			</div>
		</div>
	</div>
	<?php

		/*--------------------------------------------------------------------------------------------------
			START CONTENT AREA
		--------------------------------------------------------------------------------------------------*/
		if ( isset ( $meta_fields['content_main_area'] ) && is_array( $meta_fields['content_main_area'] ) ) {
			echo '<div class="container">';
			zn_get_template_from_area( 'content_main_area', $post->ID, $meta_fields );
			echo '</div>';
		}

		/*--------------------------------------------------------------------------------------------------
			START GRAY AREA
		--------------------------------------------------------------------------------------------------*/

		$cls = '';
		if ( ! isset ( $meta_fields['content_bottom_area'] ) || ! is_array( $meta_fields['content_bottom_area'] ) ) {
			$cls = 'noMargin';
		}

		if ( isset ( $meta_fields['content_grey_area'] ) && is_array( $meta_fields['content_grey_area'] ) ) {
			echo '<div class="gray-area ' . $cls . '">';
			echo '<div class="container">';

			zn_get_template_from_area( 'content_grey_area', $post->ID, $meta_fields );

			echo '</div>';
			echo '</div>';
		}


		/*--------------------------------------------------------------------------------------------------
			START BOTTOM AREA
		--------------------------------------------------------------------------------------------------*/


		if ( isset ( $meta_fields['content_bottom_area'] ) && is_array( $meta_fields['content_bottom_area'] ) ) {
			echo '<div class="container">';
			zn_get_template_from_area( 'content_bottom_area', $post->ID, $meta_fields );
			echo '</div>';
		}

	?>

</section>
<?php get_footer( 'shop' ); ?>
