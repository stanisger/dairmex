<?php

	global $term, $znData, $post;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}
?>
<div class="span12">
	<div class="row hg-portfolio-carousel">
		<?php
			$i = 1;
			if ( have_posts() ): while ( have_posts() ): the_post();
				// Get post meta information
				$post_meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
				$post_meta_fields = maybe_unserialize( $post_meta_fields );
				?>
				<div class="span6">
					<div class="ptcontent">
						<h3 class="title">
							<a href="<?php the_permalink(); ?>">
								<span class="name"><?php the_title(); ?></span>
							</a>
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
							<span class="seemore"><a
									href="<?php the_permalink(); ?>"><?php _e( 'See more &rarr;', THEMENAME ); ?></a></span>
						</div>
						<!-- end item links -->
					</div>
					<!-- end item content -->
				</div>
				<div class="span6">
					<div class="ptcarousel">
						<div class="controls">
							<a href="#" class="prev"><span
									class="icon-chevron-left icon-white"></span></a>
							<a href="#" class="next"><span
									class="icon-chevron-right icon-white"></span></a>
						</div>
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
											$portfolio_media = str_replace( '', '&amp;', $portfolio_media );
										}

										// Display the media
										echo '<li>';
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
										echo '<li>';
									}
								}
							?>
						</ul>
					</div>
					<!-- end ptcarousel -->
				</div>

				<?php
				if ( $i % $znData['portfolio_per_page_show'] != 0 ) {

					echo '<div class="span12"><hr class="bs-docs-separator"></div>';
				}
				$i ++;
				?>
			<?php endwhile; ?>
            <?php wp_reset_query(); ?>
			<?php endif; ?>
	</div>
	<!-- end portfolio layout -->
	<?php
		echo '<div class="clear"></div>';
		echo '<div class="span12" >';
		zn_pagination();
		echo '</div>';
	?>
</div>
