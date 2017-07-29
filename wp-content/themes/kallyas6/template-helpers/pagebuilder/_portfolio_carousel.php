<?php
/*--------------------------------------------------------------------------------------------------
	Portfolio Carousel Layout
--------------------------------------------------------------------------------------------------*/

function _portfolio_carousel( $options )
{
	global $znData;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}
	// how many posts to retrieve
	$maxEntries = isset( $options['ports_per_page'] ) ? absint($options['ports_per_page']) : 12;
    $postsPerPage = isset( $options['ports_per_page_visible'] ) ? absint($options['ports_per_page_visible']) : 4;

    // This is important to be global
    global $paged;

    if(empty($paged)){
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : null;
        if(is_null($paged)){
            $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
        }
    }
    $currentPage = $paged;

	$query = array (
		'post_type'      => 'portfolio',
		'paged'          => $currentPage,
		'posts_per_page' => $postsPerPage,
		'tax_query'      => array (
			array (
				'taxonomy' => 'project_category',
				'field'    => 'id',
				'terms'    => $options['portfolio_categories']
			)
		),
        'showposts' => $postsPerPage,
	);
    $theQuery = new WP_Query($query);
	// Start the query
	?>
	<div class="span12">
		<?php if ( $theQuery->have_posts() ): while ( $theQuery->have_posts() ): $theQuery->the_post();
			global $post;
			// Get post meta information
			$post_meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
			$post_meta_fields = maybe_unserialize( $post_meta_fields );
			?>
			<div class="row-fluid hg-portfolio-carousel">
				<div class="span6">
					<div class="ptcontent">
						<h3 class="title">
							<a href="<?php the_permalink(); ?>"><span class="name"><?php the_title(); ?></span></a>
						</h3>

						<div class="pt-cat-desc">
							<?php
								if ( preg_match( '/<!--more(.*?)?-->/', $post->post_content ) ) {
									the_content( '' );
								}
								else {
									the_excerpt();
								}
							?>
						</div>
						<!-- end item desc -->
						<div class="itemLinks">
							<?php
								if ( ! empty ( $post_meta_fields['sp_link']['url'] ) ) {
									echo '<span><a href="' . $post_meta_fields['sp_link']['url'] . '" target="' . $post_meta_fields['sp_link']['target'] . '" >' . __( "Live Preview: ", THEMENAME ) . '<strong>' . $post_meta_fields['sp_link']['url'] . '</strong></a></span>';
								}
							?>
							<span class="seemore">
								<a href="<?php the_permalink(); ?>"><?php _e( 'See more &rarr;', THEMENAME ); ?></a>
							</span>
						</div>
						<!-- end item links -->
					</div>
					<!-- end item content -->
				</div>
				<div class="span6">
					<div class="ptcarousel">
						<?php if ( count( $post_meta_fields['port_media'] ) > 1 ) {
							?>
							<div class="controls">
								<a href="#" class="prev"><span class="icon-chevron-left icon-white"></span></a>
								<a href="#" class="next"><span class="icon-chevron-right icon-white"></span></a>
							</div>
						<?php
						}
						?>
						<ul class="ptcarousel1">
							<?php
								if ( ! empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
									foreach ( $post_meta_fields['port_media'] as $media ) {
										$size      = zn_get_size( 'eight' );
										$has_image = false;

										// Modified portfolio display
										// Check to see if we have images
										if ( $portfolio_image = $media['port_media_image_comb'] ) {
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
										if ( $portfolio_media = $media['port_media_video_comb'] ) {
										}

										// Display the media
										echo '<li>';
										if ( ! empty( $saved_image ) && $portfolio_media ) {
											echo '<a href="' . $portfolio_media . '" data-type="video" rel="prettyPhoto" class="hoverLink">';
											echo '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" ' . $saved_alt . ' ' . $saved_title . ' />';
											echo '</a>';
										}
										elseif ( ! empty( $saved_image ) )
										{
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
										echo '</li>';
									}
								}
							?>
						</ul>
					</div>
					<!-- end ptcarousel -->
				</div>
				<div class="span12"><hr class="bs-docs-separator"></div>
			</div><!-- end portfolio layout -->
		<?php endwhile; ?>
		<?php endif; ?>
		<?php
			echo '<div class="clear"></div>';
            if(empty($maxEntries)){
                $maxEntries = 12;
            }
            if(empty($postsPerPage)){
                $postsPerPage = 4;
            }
            // This has to be calculated because there LIMIT on the SELECT query
            $numPages = ceil($maxEntries/$postsPerPage);
			echo '<div class="span12" >'.WpkZnPagination::show($theQuery, $numPages, $currentPage).'</div>';
            wp_reset_postdata();
		?>
	</div>
	<?php
	$zn_pcarousel = array (
		'zn_pcarousel' => "
            jQuery(function($){
                // ** Portfolio Carousel
                var carousels =	jQuery('.ptcarousel1');
                if(carousels && carousels.length > 0) {
                    carousels.each(function(index, element) {
                        if ( $(this).children().length > 1 ){
                            $(this).carouFredSel({
                                responsive: true,
                                items: { width: 570 },
                                prev	: {	button : $(this).parent().find('a.prev'), key : \"left\" },
                                next	: { button : $(this).parent().find('a.next'), key : \"right\" },
                                auto: {timeoutDuration: 5000},
                                scroll: { fx: \"crossfade\", duration: \"1500\" }
                            });
                        }
                    });
                }
                // *** end Portfolio Carousel
            });"
	);
	zn_update_array( $zn_pcarousel );
}
