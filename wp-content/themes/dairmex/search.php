<?php
/**
 * The search template file.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header(); 
$sidebar = mfn_sidebar_classes(get_option( 'page_for_posts' ));
?>

<!-- #Content -->
<div id="Content">
	<div class="container">

		<!-- .content -->
		<div class="content" style="width:100% !important;">
			<div class="the_content the_content_wrapper">
			
				<?php
				while ( have_posts() )
				{
					the_post();
					?>
					<div class="post clearfix">
						<div class="desc no_meta no-post-thumbnail">
							<h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php echo mfn_excerpt( get_the_ID(), 100, '<p><b><strong>' ); ?>
						</div>
					</div>
					<?php
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
				?>
			
			</div>
		</div>

	</div>
</div>

<?php get_footer(); ?>