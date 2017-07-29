<?php
/**
 * The template for displaying all pages.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();
$sidebar = mfn_sidebar_classes();
?>
	
<!-- Content -->
<div id="Content">
	<div class="container">

		<!-- .content -->
		<?php 
			if( $sidebar ) echo '<div class="content">';
			
			while ( have_posts() )
			{
				the_post();
				get_template_part( 'includes/content', 'page' );
			}

			if( $sidebar ){
				echo '</div>';
			} else {
				echo '<div class="clearfix"></div>';
			}
		?>	
		
		<!-- Sidebar -->
		<?php 
			if( $sidebar ){
				get_sidebar();
			}
		?>

	</div>
</div>

<?php get_footer(); ?>