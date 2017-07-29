<?php
/**
 * The main template file.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header(); 
$sidebar = mfn_sidebar_classes();
?>

<!-- #Content -->
<div id="Content">
	<div class="container">

		<!-- .content -->
		<?php 
			if( $sidebar ) echo '<div class="content">';
			echo '<div class="the_content the_content_wrapper">';
			
			while ( have_posts() )
			{
				the_post();
				get_template_part( 'includes/content', get_post_type() );
			}
			
			// pagination
			if(function_exists( 'mfn_pagination' )):
				mfn_pagination();
			else:
			?>
				<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'tisson')) ?></div>
				<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'tisson')) ?></div>
			<?php
			endif;
			
			echo '</div>';
			if( $sidebar ){
				echo '</div>';
			} else {
				echo '<div class="clearfix"></div>';
			}
		?>	
		
		<!-- Sidebar -->
		<?php 
			if( $sidebar ){
				get_sidebar( 'blog' );
			}
		?>

	</div>
</div>

<?php get_footer(); ?>