<?php
/**
 * The Header for our theme.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->

<!-- head -->
<head>

<!-- meta -->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<?php if( mfn_opts_get('responsive') ) echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">'; ?>

<title><?php
global $post;
if( mfn_opts_get('mfn-seo') && is_object($post) && get_post_meta( get_the_ID(), 'mfn-meta-seo-title', true ) ){
	echo stripslashes( get_post_meta( get_the_ID(), 'mfn-meta-seo-title', true ) );
} else {
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', 'tisson' ), max( $paged, $page ) );
}
?></title>

<?php if( is_single() ): ?>
	<script>var switchTo5x=true;</script>
	<script src="http://w.sharethis.com/button/buttons.js"></script>
	<script>stLight.options({publisher: "ur-6568e777-919c-a5dd-ac31-98a6fa2e6b2d"}); </script>
<?php endif; ?>
<?php do_action('wp_seo'); ?>

<link rel="shortcut icon" href="<?php mfn_opts_show('favicon-img',THEME_URI .'/images/favicon.ico'); ?>" type="image/x-icon" />	

<!-- wp_head() -->
<?php wp_head();?>
</head>

<!-- body -->
<body <?php body_class(); ?>>	
	
	<?php 
		get_template_part( 'includes/header', 'top-area' );

		if( ! is_404() ){
			
			$slider = false;
			if( get_post_type()=='page' ) $slider = get_post_meta( get_the_ID(), 'mfn-post-slider', true );
			
			if( $slider && function_exists( 'putRevSlider' ) ){
				
				// Revolution Slider
				echo '<div id="mfn-rev-slider">';
					putRevSlider( $slider );
				echo '</div>';
				
			} elseif( trim( wp_title( '', false ) ) ){

				// Subheader Featured Image
				$subheader_style 	= '';
				$subheader_id		= get_the_ID();

				if ( (!is_front_page()) && (!is_page()) && (!is_single()) ) {
					$subheader_id = get_option( 'page_for_posts' );
				}				
				
				if( ( ( $subheader_id == get_option('page_for_posts') ) || ( get_post_type() == 'page' ) ) && has_post_thumbnail($subheader_id) ){
					$subheader_image = wp_get_attachment_image_src( get_post_thumbnail_id($subheader_id), 'full' );
					$subheader_style = 'style="background-image:url('. $subheader_image[0] .');"';
				}

				// Page title
				echo '<div id="Subheader" '. $subheader_style .'>';
					echo '<div class="container">';
						echo '<div class="sixteen columns">';
							if( get_post_type()=='page' || is_single() ){
								echo '<h1 class="title">'. $post->post_title .'</h1>';
							} else {
								echo '<h1 class="title">'. trim( wp_title( '', false ) ) .'</h1>';
							}
						echo '</div>';
					echo '</div>';
				echo '</div>';
				
				// Breadcrumbs
				echo '<div id="Breadcrumbs">';
					echo '<div class="container">';
						echo '<div class="sixteen columns">';
							mfn_breadcrumbs();
						echo '</div>';
					echo '</div>';
				echo '</div>';
				
			}
		} else {
			// Error 404
			echo '<div id="Subheader">';
				echo '<div class="container">';
					echo '<div class="sixteen columns">';
// 						echo '<h1 class="title">'. __( 'Error 404', 'tisson' ) .'</h1>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	?>
	
	<!-- #Wrapper -->
	<div id="Wrapper">