<?php
/*--------------------------------------------------------------------------------------------------
	Laptop Slider
--------------------------------------------------------------------------------------------------*/

function _lslider( $options )
{
	// LOAD CSS AND JS
	wp_enqueue_style( 'lslider', MASTER_THEME_DIR . '/sliders/flex_slider/css/flexslider-laptop.css' );
	wp_enqueue_script( 'flex_slider' );

	$style = 'zn_def_header_style';
	if ( isset ( $options['ls_header_style'] ) && ! empty ( $options['ls_header_style'] ) && $options['ls_header_style'] != 'zn_def_header_style' ) {
		$style = 'uh_' . $options['ls_header_style'];
	}

	$slider_desc = '';
	if ( isset ( $options['ls_slider_desc'] ) && ! empty ( $options['ls_slider_desc'] ) ) {
		$slider_desc = '<h3 class="centered">' . do_shortcode( $options['ls_slider_desc'] ) . '</h3>';
	}
	?>
	<div id="slideshow" class="gradient noGlare <?php echo $style; ?>">
		<div class="bgback"></div>
		<div class="laptop-slider-wrapper">
			<div class="container">

				<?php echo $slider_desc;?>

				<div class="laptop-mask">
					<div class="flexslider zn_laptop_slider">
						<ul class="slides">
							<?php
								if ( isset ( $options['single_lslides'] ) && is_array( $options['single_lslides'] ) ) {
									foreach ( $options['single_lslides'] as $slide )
									{
										$link_start = '';
										$link_end   = '';
										$caption    = '';
										$alt        = '';

										if ( isset ( $slide['ls_slide_link']['url'] ) && ! empty ( $slide['ls_slide_link']['url'] ) ) {

											// Link
											$link_start = '<a class="link" href="' . $slide['ls_slide_link']['url'] . '" target="' . $slide['ls_slide_link']['target'] . '">';
											$link_end   = '</a>';
										}

										if ( isset ( $slide['ls_slide_title'] ) && ! empty ( $slide['ls_slide_title'] ) ) {

											// Caption
											$caption = '<h2 class="flex-caption">' . $slide['ls_slide_title'] . '</h2>';
											$alt     = $slide['ls_slide_title'];
										}

										echo '<li>';

										echo $link_start;

										if ( isset ( $slide['ls_slide_image'] ) && ! empty ( $slide['ls_slide_image'] ) ) {
											$image = vt_resize( '', $slide['ls_slide_image'], '607', '380', true );
											echo '<img src="' . $image['url'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" alt="' . $alt . '" />';
										}
										echo $caption;

										echo $link_end;

										echo '</li>';
									}
								}
							?>
						</ul>
					</div>
					<!-- end #flexslider -->
				</div>
				<!-- laptop mask -->
			</div>
		</div>
	</div><!-- end slideshow -->
	<?php
	$zn_laptop_slider = array (
		'zn_laptop_slider' => "
			$(window).load(function(){

				function slideCompletezn_laptop_slider(args) {
					var caption = $(args.container).find('.flex-caption').attr('style', ''),
						thisCaption = $('.flexslider.zn_laptop_slider .slides > li.flex-active-slide').find('.flex-caption');
					thisCaption.animate({left:20, opacity:1}, 500, 'easeOutQuint');
				}

				$('.flexslider.zn_laptop_slider').flexslider({
					animation: 'fade',
					slideDirection: 'horizontal',
					slideshow: true,
					slideshowSpeed: 7000,
					animationDuration: 9600,
					directionNav: true,
					controlNav: false,
					keyboardNav: true,
					mousewheel: false,
					smoothHeight: false,
					randomize: false,
					slideToStart: 0,
					animationLoop: true,
					pauseOnAction: true,
					pauseOnHover: false,
					start: slideCompletezn_laptop_slider,
					after: slideCompletezn_laptop_slider
				});
			});"
	);
	zn_update_array( $zn_laptop_slider );
}
