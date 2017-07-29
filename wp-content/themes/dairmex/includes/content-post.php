<?php
/**
 * The template for displaying content in the index.php template
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( array('clearfix','post') ); ?>>
	
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	
	<?php 
		$posts_meta = array();
		$posts_meta['time'] = mfn_opts_get( 'blog-time' );
		$posts_meta['comments'] = mfn_opts_get( 'blog-comments' );
		$posts_meta['categories'] = mfn_opts_get( 'blog-categories' );
		$posts_meta['tags'] = mfn_opts_get( 'blog-tags' );
	?>
	
	<?php 
		if( $posts_meta['time'] || $posts_meta['comments'] || $posts_meta['categories'] ){
			echo '<div class="meta">';
				if( $posts_meta['time'] ) echo '<div class="date"><i class="icon-calendar"></i> '. get_the_time('j.m.Y') .'</div>';
				if( $posts_meta['comments'] ) echo '<span class="sep">|</span><div class="comments"><i class="icon-comment-alt"></i> '. mfn_comments_number() .'</div>';
				if( $posts_meta['categories'] ) echo '<span class="sep">|</span><div class="category"><i class="icon-reorder"></i> '. get_the_category_list(', ') .'</div>';							
			echo '</div>';
		}
	?>
	
	<div class="photo">
		<?php 
			if( $blog_slider = get_post_meta( get_the_ID(), 'mfn-post-slider', true ) ){
				putRevSlider( $blog_slider );
			} elseif( $video = get_post_meta( $post->ID, 'mfn-post-vimeo', true ) ){
				echo '<iframe class="scale-with-grid" src="http://player.vimeo.com/video/'. $video .'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'."\n";
			} elseif( $video = get_post_meta( $post->ID, 'mfn-post-youtube', true ) ){
				echo '<iframe class="scale-with-grid" src="http://www.youtube.com/embed/'. $video .'?wmode=opaque" frameborder="0" allowfullscreen></iframe>'."\n";
			} elseif( has_post_thumbnail() ){
				echo '<a href="'. get_permalink() .'">';
					the_post_thumbnail( 'blog', array('class'=>'scale-with-grid' ) );
				echo '</a>';
			}
		?>
	</div>
	
	<div class="post_content">	
		<?php echo mfn_excerpt( get_the_ID(), 100, '<b><strong><h1><h2><h3><h4><h5><h6>' ); ?>
	</div>	
	
	<?php
		if( $posts_meta['tags'] && ( $terms = get_the_terms( false, 'post_tag' ) ) ){
			echo '<div class="footer">';
				echo '<p class="tags">';
					echo '<i class="icon-tags"></i> ';
					$terms_count = count( $terms );
					foreach( $terms as $term ){
						$terms_count--;
						$sep = ( $terms_count ) ? ',' : false;
						$link = get_term_link( $term, 'post_tag' );
						echo '<a href="' . esc_url( $link ) . '" rel="tag"><span>' . $term->name . $sep .'</span></a> ';
					}
				echo '</p>';
			echo '</div>';
		}
	?>
	
</div>