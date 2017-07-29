<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header(); 

switch ( get_post_meta($post->ID, 'mfn-post-layout', true) ) {
	case 'left-sidebar':
		$class = ' with_aside aside_left';
		break;
	case 'right-sidebar':
		$class = ' with_aside aside_right';
		break;
	default:
		$class = '';
		break;
}
?>

<!-- #Content -->
<div id="Content" class="subpage<?php echo $class;?>">
	<div class="container">
	
		<!-- .content -->
		<?php 
			if( $class ) echo '<div class="content">';
			echo '<div class="the_content the_content_wrapper">';
			
			while ( have_posts() )
			{
				the_post();
				get_template_part( 'includes/content', 'single-portfolio' );
			}

			echo '</div>';
			if( $class ){
				echo '</div>';
			} else {
				echo '<div class="clearfix"></div>';
			}
		?>	
		
		<!-- Sidebar -->
		<?php 
			if( $class ){
				get_sidebar();
			}
		?>
			
	</div>
</div>

<?php get_footer(); ?>