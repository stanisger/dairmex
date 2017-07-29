<?php
/**
 * Template Name: Portfolio
 * Description: A Page Template that display portfolio items.
 *
 * @package Tisson
 * @author Muffin Group
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

$portfolio_isotope = mfn_opts_get('portfolio-isotope') ? ' portfolio-isotope' : '';
			
$translate['select-category'] = mfn_opts_get('translate') ? mfn_opts_get('translate-select-category','Select category:') : __('Select category:','tisson');
$translate['all'] = mfn_opts_get('translate') ? mfn_opts_get('translate-all','All') : __('All','tisson');
?>

<div id="Content" class="subpage<?php echo $class;?>">
	<div class="container<?php echo $portfolio_isotope;?>">

		<!-- .content -->
		<?php if( $class ) echo '<div class="content">'; ?>
		
			<!-- .select_category -->
			<div class="column one">
				<div class="Projects_header clearfix">       
					<div class="categories">
						<ul>
							<li class="label"><h6><?php echo $translate['select-category']; ?></h6></li>
							<?php 
								$portfolio_page_id = mfn_opts_get( 'portfolio-page' );
								echo '<li class="current-cat"><a rel="*" href="'.get_page_link( $portfolio_page_id ).'">'. $translate['all'] .'</a></li>';
								if( $portfolio_categories= get_terms('portfolio-types') ){
									
									foreach( $portfolio_categories as $category ){
										echo '<li><a rel=".'. $category->slug .'" href="'. get_term_link($category) .'">'. $category->name .' <span>('. $category->count .')</span></a></li>';
									}
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="Projects_inside">
				<?php 
				$portfolio_args = array( 
					'post_type' => 'portfolio',
					'posts_per_page' => mfn_opts_get( 'portfolio-posts', 6 ),
					'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'order' => mfn_opts_get( 'portfolio-order', 'ASC' ),
				    'orderby' => mfn_opts_get( 'portfolio-orderby', 'menu_order' ),
					'ignore_sticky_posts' => 1,
				);

				$query = new WP_Query();
				$query->query( $portfolio_args );

			 	if( $query->have_posts() )
			 	{
			 		echo '<ul class="Projects_inside_wrapper da-thumbs">';
						while ( $query->have_posts() )
						{
							$query->the_post();
							get_template_part( 'includes/content', 'portfolio' );
						}
					echo '</ul>';
					
					echo '<div class="column one">';
						mfn_pagination( $query );
					echo '</div>';
			 	}	
			 	wp_reset_query(); 
				?>	
			</div>

		<?php if( $class ) echo '</div>'; ?>
		
		<!-- sidebar -->
		<?php 
			if( $class ){
				get_sidebar();
			}
		?>
			
	</div>
</div>

<?php get_footer(); ?>