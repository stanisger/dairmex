<?php
/**
 * The template for displaying content in the single-portfolio.php template
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

$translate['project-description'] = mfn_opts_get('translate') ? mfn_opts_get('translate-project-description','Project Description:') : __('Project Description:','tisson');
$translate['client'] = mfn_opts_get('translate') ? mfn_opts_get('translate-client','Client:') : __('Client:','tisson');
$translate['date'] = mfn_opts_get('translate') ? mfn_opts_get('translate-date','Date:') : __('Date:','tisson');
$translate['category'] = mfn_opts_get('translate') ? mfn_opts_get('translate-category','Category:') : __('Category:','tisson');
$translate['project-url'] = mfn_opts_get('translate') ? mfn_opts_get('translate-project-url','Project URL:') : __('Project URL:','tisson');
$translate['visit-online'] = mfn_opts_get('translate') ? mfn_opts_get('translate-visit-online','Visit online &rarr;') : __('Visit online &rarr;','tisson');
$translate['back'] = mfn_opts_get('translate') ? mfn_opts_get('translate-back','Back to list') : __('Back to list','tisson');
?>

<div class="single-portfolio" id="portfolio-item-<?php the_ID(); ?>" >							
	
	<?php
		if( $blog_slider = get_post_meta( get_the_ID(), 'mfn-post-slider', true ) ){
			echo '<div class="photo">';
				putRevSlider( $blog_slider );
			echo '</div>';	
		} elseif ( $video = get_post_meta($post->ID, 'mfn-post-vimeo', true) ){
			echo '<div class="photo iframe"><iframe class="scale-with-grid" src="http://player.vimeo.com/video/'. $video .'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>'."\n";
		} elseif ( $video = get_post_meta($post->ID, 'mfn-post-youtube', true) ){
			echo '<div class="photo iframe"><iframe class="scale-with-grid" src="http://www.youtube.com/embed/'. $video .'" frameborder="0" allowfullscreen></iframe></div>'."\n";
		} elseif ( has_post_thumbnail() ){	
	?>
		<div class="photo">
			<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
			<a class="fancybox" href="<?php echo $large_image_url[0] ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'portfolio-single', array('class'=>'scale-with-grid' ));?>
			</a>
		</div>
	<?php } ?>

	<div class="desc">
		<h4><?php echo $translate['project-description']; ?></h4>
		<div class="sp-inside">
			
			<div class="sp-inside-left">
				<dl>
					<?php if( $client = get_post_meta($post->ID, 'mfn-post-client', true) ): ?>
						<dt><?php echo $translate['client']; ?></dt>
						<dd><i class="icon-user"></i> &nbsp;<?php echo $client; ?></dd>
					<?php endif; ?>		
					<?php if( $date = get_post_meta($post->ID, 'mfn-post-date', true) ): ?>
						<dt><?php echo $translate['date']; ?></dt>
						<dd><i class="icon-calendar"></i> &nbsp;<?php echo $date; ?></dd>
					<?php endif; ?>		
					<?php 
						$terms = get_the_terms($post->ID, 'portfolio-types'); 
						if( is_array( $terms ) ){
							$categories = '';
							foreach( $terms as $term ){
								$categories .= '<a href="'. site_url() .'/portfolio-types/'. $term->slug .'">'. $term->name .'</a>, ';
							}
							$categories = substr( $categories , 0, -2 );
							echo '<dt>'. $translate['category'] .'</dt>';
							echo '<dd>'. $categories .'</dd>';
						}
					?>
					<?php if( $link = get_post_meta($post->ID, 'mfn-post-link', true) ): ?>
						<dt><?php echo $translate['project-url']; ?></dt>
						<dd><i class="icon-external-link"></i> &nbsp;<a target="_blank" href="<?php echo $link; ?>"><?php echo $translate['visit-online']; ?></a></dd>	
					<?php endif; ?>						
				</dl>
			</div>
			
			<div class="sp-inside-right">
			
				<?php the_content( false ); ?>
				
				<?php 
				$portfolio_page_id = mfn_opts_get( 'portfolio-page' );
				if( $portfolio_page_id ):
				?>
					<footer>
						<a class="button button_small" href="<?php echo get_page_link( $portfolio_page_id ); ?>"><?php echo $translate['back']; ?></a>
					</footer>
				<?php endif; ?>
				
			</div>
					
		</div>
		
	</div>
	
</div>