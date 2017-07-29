<?php
/**
 * Taxanomy Portfolio Types
 *
 * @package Tisson
 * @author Muffin Group
 */

get_header(); 

$portfolio_page_id = mfn_opts_get( 'portfolio-page' );
switch ( get_post_meta($portfolio_page_id, 'mfn-post-layout', true) ) {
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

$translate['select-category'] = mfn_opts_get('translate') ? mfn_opts_get('translate-select-category','Select category:') : __('Select category:','tisson');
$translate['all'] = mfn_opts_get('translate') ? mfn_opts_get('translate-all','All') : __('All','tisson');
?>

<div id="Content" class="subpage<?php echo $class;?>">
	<div class="container">

		<!-- .content -->
		<?php if( $class ) echo '<div class="content">'; ?>
		
			<!-- .select_category -->
			<?php
			$menu_args = array(
				'taxonomy' => 'portfolio-types',
				'orderby' => 'name',
				'order' => 'ASC',
				'show_count' => 1,
				'hierarchical' => 1,
				'hide_empty' => 0,
				'title_li' => '',
				'depth' => 1,
				'walker' => new New_Walker_Category()
			);
			?>
			
			<div class="column one">
				<div class="Projects_header clearfix">       
					<div class="categories">
						<ul>
							<li class="label"><h6><?php echo $translate['select-category']; ?></h6></li>
							<?php
								$portfolio_page_id = mfn_opts_get( 'portfolio-page' );
							
								if( get_the_ID() == $portfolio_page_id ) {
									$current_class = ' class="current-cat"';
								} else {
									$current_class = "";
								}
							
								if( $portfolio_page_id ) {
									echo '<li'.$current_class.'><a href="'.get_page_link( $portfolio_page_id ).'">'. $translate['all'] .'</a></li>';
								}
							
								wp_list_categories( $menu_args ); 
							?>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="Projects_inside">	
				<?php 	
				$args = array( 
					'post_type' => 'portfolio',
					'posts_per_page' => mfn_opts_get( 'portfolio-posts', 6 ),
					'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
					'order' => mfn_opts_get( 'portfolio-order', 'ASC' ),
					'orderby' => mfn_opts_get( 'portfolio-orderby', 'menu_order' ),
					'taxonomy' => 'portfolio-types',
					'ignore_sticky_posts' => 1,
				);
				
				global $query_string;
				parse_str( $query_string, $qstring_array );
				$query_args = array_merge( $args, $qstring_array );
				
				$query = new WP_Query();
				$query->query( $query_args );
				
				if( $query->have_posts() )
			 	{
			 		echo '<ul class="da-thumbs">';
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
				get_sidebar( 'taxonomy' );
			}
		?>
			
	</div>
</div>

<?php get_footer(); ?>