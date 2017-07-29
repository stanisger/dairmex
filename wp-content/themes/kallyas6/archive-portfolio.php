<?php get_header();
	
	global $znData;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}

?>
<section id="content" about="archive-portfolio">
	<div class="container">
		<div id="mainbody">
			<?php
				/*
				 * These templates will be used if not overridden by elements in Page Builder
				 */
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

				// Portfolio Sortable
				if ( isset( $znData['portfolio_style'] ) && $znData['portfolio_style'] == 'portfolio_sortable' ) { ?>
					<div class="row hg-portfolio ">
						<?php include( locate_template( 'template-helpers/loop-portfolio_sortable.php' ) ); ?>
					</div><!-- end row -->
				<?php }

				// Portfolio Carousel
				elseif ( isset( $znData['portfolio_style'] ) && $znData['portfolio_style'] == 'portfolio_carousel' ) { ?>
					<div class="row">
						<?php include( locate_template( 'template-helpers/loop-portfolio_carousel.php' ) ); ?>
					</div>
					
				<?php }

				// Portfolio Category
				elseif ( isset( $znData['portfolio_style'] ) && $znData['portfolio_style'] == 'portfolio_category' ) {
					include( locate_template( 'template-helpers/loop-portfolio_category.php' ) );
				}
			?>
		</div>
		<!-- end mainbody -->
	</div>
	<!-- end container -->
</section><!-- end #content -->

<?php get_footer(); ?>