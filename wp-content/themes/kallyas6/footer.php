<?php
global $znData;
if ( ! isset( $znData ) || empty( $znData ) ) {
	$znData = get_option( OPTIONS );
}
?>
<?php
if ( empty( $znData['footer_show'] ) || ( ! empty( $znData['footer_show'] ) && $znData['footer_show'] == 'yes' ) ) { ?>
	<footer id="footer">
		<div class="container">
			<?php
				if ( ! empty ( $znData['footer_row1_widget_positions'] ) ) {

					if ( ( ! empty ( $znData['footer_row1_show'] ) && $znData['footer_row1_show'] == 'yes' ) || empty ( $znData['footer_row1_show'] ) ) {

						echo '<div class="row">';

						$number_of_columns = key( json_decode( stripslashes( $znData['footer_row1_widget_positions'] ) ) );
						$columns_array     = json_decode( stripslashes( $znData['footer_row1_widget_positions'] ), true );

						for ( $i = 1; $i <= $number_of_columns; $i ++ ) {
							echo '<div class="span' . $columns_array[ $number_of_columns ][0][ $i - 1 ] . '">';
							if ( ! dynamic_sidebar( 'Footer row 1 - widget ' . $i . '' ) ) : endif;
							echo '</div>';
						}

						echo '</div><!-- end row -->';
					}
				}

				if ( ! empty ( $znData['footer_row2_widget_positions'] ) ) {

					if ( ( ! empty ( $znData['footer_row2_show'] ) && $znData['footer_row2_show'] == 'yes' ) || empty ( $znData['footer_row2_show'] ) ) {

						echo '<div class="row">';

						$number_of_columns = key( json_decode( stripslashes( $znData['footer_row2_widget_positions'] ) ) );
						$columns_array     = json_decode( stripslashes( $znData['footer_row2_widget_positions'] ), true );

						for ( $i = 1; $i <= $number_of_columns; $i ++ ) {
							echo '<div class="span' . $columns_array[ $number_of_columns ][0][ $i - 1 ] . '">';
							if ( ! dynamic_sidebar( 'Footer row 2 - widget ' . $i . '' ) ) : endif;
							echo '</div>';
						}

						echo '</div><!-- end row -->';
					}
				}
			?>

			<div class="row">
				<div class="span12">
					<div class="bottom fixclear">
						<?php
							if ( isset( $znData['footer_social_icons'] ) && is_array( $znData['footer_social_icons'] ) && ! empty ( $znData['footer_social_icons'][0]['footer_social_icon'] ) ) {

								$icon_class = '';

								if ( $znData['footer_which_icons_set'] == 'colored' ) {
									$icon_class = 'colored';
								}

								echo '<ul class="social-icons ' . $icon_class . ' fixclear">';

								echo '<li class="title">' . __( 'GET SOCIAL', THEMENAME ) . '</li>'; // Translate

								foreach ( $znData['footer_social_icons'] as $key => $icon ) {

									$link   = '';
									$target = '';

									if ( isset ( $icon['footer_social_link'] ) && is_array( $icon['footer_social_link'] ) ) {
										$link   = $icon['footer_social_link']['url'];
										$target = 'target="' . $icon['footer_social_link']['target'] . '"';
									}

									echo '<li class="' . $icon['footer_social_icon'] . '"><a href="' . $link . '" ' . $target . '>' . $icon['footer_social_title'] . '</a></li>';
								}

								echo '</ul>';
							}
						?>

						<?php if ( $znData['copyright_text'] || $znData['footer_logo'] ) { ?>

							<div class="copyright">
								<?php
									if ( $znData['footer_logo'] ) {
										echo '<a href="' . home_url() . '"><img src="' . $znData['footer_logo'] . '" alt="' . get_bloginfo( 'name' ) . '" /></a>';
									}

									if ( $znData['copyright_text'] ) {
										echo '<p>' . stripslashes( $znData['copyright_text'] ) . '</p>';
									}
								?>
							</div><!-- end copyright -->
						<?php } ?>
					</div>
					<!-- end bottom -->
				</div>
			</div>
			<!-- end row -->
		</div>
	</footer>
<?php } ?>
</div><!-- end page_wrapper -->

<a href="#" id="totop"><?php echo __( 'TOP', THEMENAME ); ?></a>

<?php wp_footer(); ?>
</body>
</html>