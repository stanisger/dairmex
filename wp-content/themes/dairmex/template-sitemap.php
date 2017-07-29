<?php
/**
 * Template Name: Sitemap
 *
 * @package Tisson
 * @author Muffin Group
 */

get_header();
?>

<!-- #Content -->
<div id="Content" class="subpage">
	<div class="container">

		<?php 
			if( have_posts() ){
				the_post();
				get_template_part( 'content', 'page' );
			} 
		?>
		
		<div class="one column">
			<ul class="list">
				<?php wp_list_pages( 'title_li=' ); ?>
			</ul>
		</div>
		
	</div>
</div>

<?php get_footer(); ?>