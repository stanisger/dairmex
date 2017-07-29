<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php 
		$posts_meta = array();
		$posts_meta['time'] = get_post_meta($post->ID, 'mfn-post-time', true);
		$posts_meta['comments'] = get_post_meta($post->ID, 'mfn-post-comments', true);
		$posts_meta['categories'] = get_post_meta($post->ID, 'mfn-post-categories', true);
		$posts_meta['tags'] = get_post_meta($post->ID, 'mfn-post-tags', true);
	?>
	
	<?php 
		if( $posts_meta['time'] || $posts_meta['comments'] || $posts_meta['categories'] ){
			echo '<div class="meta">';
				if( $posts_meta['time'] ) echo '<div class="date"><i class="icon-calendar"></i> '. get_the_time('j.m.Y') .'</div>';
				if( $posts_meta['comments'] ) echo '<span class="sep">|</span><div class="comments"><i class="icon-comment-alt"></i> '. mfn_comments_number() .'</div>';
				if( $posts_meta['categories'] ) echo '<span class="sep">|</span><div class="category"><i class="icon-reorder"></i> '. get_the_category_list(', ') .'</div>';							
			
				if( $posts_meta['tags'] && ( $terms = get_the_terms( false, 'post_tag' ) ) ){
					echo '<span class="sep">|</span><div class="tags">';
						echo '<i class="icon-tags"></i> ';
						$terms_count = count( $terms );
						foreach( $terms as $term ){
							$terms_count--;
							$sep = ( $terms_count ) ? ',' : false;
							$link = get_term_link( $term, 'post_tag' );
							echo '<a href="' . esc_url( $link ) . '" rel="tag"><span>' . $term->name . $sep .'</span></a> ';
						}
					echo '</div>';
				}
			echo '</div>';
		}
	?>
	
	<div class="photo">
		<?php 
			if( $blog_slider = get_post_meta( get_the_ID(), 'mfn-post-slider', true ) ){
				putRevSlider( $blog_slider );
			} elseif( $video = get_post_meta($post->ID, 'mfn-post-vimeo', true) ){
				echo '<iframe class="scale-with-grid" src="http://player.vimeo.com/video/'. $video .'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'."\n";
			} elseif( $video = get_post_meta($post->ID, 'mfn-post-youtube', true) ){
				echo '<iframe class="scale-with-grid" src="http://www.youtube.com/embed/'. $video .'" frameborder="0" allowfullscreen></iframe>'."\n";
			} elseif( has_post_thumbnail() ){
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
				echo '<a class="fancybox" href="'. $large_image_url[0] .'">';
					the_post_thumbnail( 'blog', array('class'=>'scale-with-grid' ));
				echo '</a>';
			}
		?>			
	</div>
	
	<div class="post_content">	
		<?php the_content( false ); ?>
	</div>
	
	<?php wp_link_pages(array('before' => '<p><strong>'.  __('Pages:', 'mfn-opts') .'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>	
	
	<?php if( get_post_meta($post->ID, 'mfn-post-social', true) ): ?>
		<div class="share">
			<span class='st_sharethis_hcount' displayText='ShareThis'></span>
			<span class='st_facebook_hcount' displayText='Facebook'></span>
			<span class='st_twitter_hcount' displayText='Tweet'></span>
			<span class='st_email_hcount' displayText='Email'></span>
		</div>
	<?php endif; ?>
	
</div>

<?php comments_template( '', true ); ?>