<?php
/*--------------------------------------------------------------------------------------------------
	Portfolio Category
--------------------------------------------------------------------------------------------------*/

function _portfolio_category( $options )
{
	wp_reset_query();
	global $post, $znData;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}

	// how many posts per page
	$posts_per_page = isset( $options['ports_per_page_visible'] ) ? $options['ports_per_page_visible'] : 4;

	// Get current page
	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : null;
	if(is_null($paged)){
		$paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
	}

	// Build query
	$queryArgs = array (
		'post_type'      => 'portfolio',
		'paged'          => $paged,
		'showposts'      => $posts_per_page,
		'tax_query'      => array (
			array (
				'taxonomy' => 'project_category',
				'field'    => 'id',
				'terms'    => $options['portfolio_categories']
			),
		),
	);

	$theQuery = new WP_Query($queryArgs);

	echo '<div class="span12">';

	if ( $theQuery->have_posts() ) {
		// Start the loop
		while ( $theQuery->have_posts() ) {
			$theQuery->the_post();

			// Get post meta information
			$post_meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
			$post_meta_fields = maybe_unserialize( $post_meta_fields );

			echo '<div class="row-fluid">';
			echo '<div class="span6">';
			echo '<div class="img-intro">';

			if ( ! empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
				$size      = zn_get_size( 'eight' );
				$has_image = false;

				// Modified portfolio display
				// Check to see if we have images
				if ( $portfolio_image = $post_meta_fields['port_media']['0']['port_media_image_comb'] ) {
					if ( is_array( $portfolio_image ) ) {
						if ( $saved_image = $portfolio_image['image'] ) {
							if ( ! empty( $portfolio_image['alt'] ) ) {
								$saved_alt = 'alt="' . $portfolio_image['alt'] . '"';
							}
							else {
								$saved_alt = '';
							}

							if ( ! empty( $portfolio_image['title'] ) ) {
								$saved_title = 'title="' . $portfolio_image['title'] . '"';
							}
							else {
								$saved_title = '';
							}

							$has_image = true;
						}
					}
					else {
						$saved_image = $portfolio_image;
						$has_image   = true;
						$saved_alt   = '';
						$saved_title = '';
					}

					if ( $has_image ) {
						$image = vt_resize( '', $saved_image, $size['width'], '', true );
					}
				}

				// Check to see if we have video
				$portfolio_media = $post_meta_fields['port_media']['0']['port_media_video_comb'];

				if ( isset( $image ) && ! empty( $image ) && is_array( $image ) ) {
					if ( ! empty( $saved_image ) && $portfolio_media ) {
						echo '<a href="' . $portfolio_media . '" data-type="video" rel="prettyPhoto" class="hoverLink">';
						echo '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" ' . $saved_alt . ' ' . $saved_title . ' />';
						echo '</a>';
					}
					elseif ( ! empty( $saved_image ) ) {
						if ( ! empty( $znData['zn_link_portfolio'] ) && $znData['zn_link_portfolio'] == 'yes' ) {
							echo '<a href="' . get_permalink() . '" data-type="image" class="hoverLink">';
							echo '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" ' . $saved_alt . ' ' . $saved_title . ' />';
							echo '</a>';
						}
						else {
							echo '<a href="' . $saved_image . '" data-type="image" rel="prettyPhoto" class="hoverLink">';
							echo '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" ' . $saved_alt . ' ' . $saved_title . ' />';
							echo '</a>';
						}
					}
					elseif ( $portfolio_media ) {
						echo get_video_from_link( $portfolio_media, '', $size['width'], $size['height'] );
					}
				}
			}

			echo '</div><!-- img intro -->';
			echo '</div>';

			echo '<div class="span6">';
			echo '<h3 class="title">';
			echo '<a href="' . get_permalink() . '" >' . get_the_title() . '</a>';
			echo '</h3>';
			echo '<div class="pt-cat-desc">';

			the_content();

			echo '</div><!-- pt cat desc -->';
			echo '</div>';
			echo '</div><!-- end row -->';
		} // end while
	} // end if has posts
	echo '<div class="row-fluid zn_content_no_margin">';
	echo '<div class="span12">';

	WpkZnPagination::show($theQuery);
	wp_reset_postdata();

	echo '</div>';
	echo '</div>';
	echo '</div>';

}
