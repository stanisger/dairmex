<?php
/**
 * Search template file.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header(); 
?>

<!-- #Content -->
<div id="Content" class="subpage<?php echo $class;?>">
	<div class="container">

		<!-- .content -->
		<?php 
			echo '<div class="the_content the_content_wrapper">';
			
			while ( have_posts() )
			{
				the_post();
				?>
					<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>					
						<?php the_content( false ); ?>		
					</div>
				<?php 
			}
			
			mfn_pagination(); // pagination
			
			echo '</div>';
		?>	

	</div>
</div>

<?php get_footer(); ?>