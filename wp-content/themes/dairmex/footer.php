<?php
/**
 * The template for displaying the footer.
 *
 * @package tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */
?>

</div>

<!-- #Footer -->		
<footer id="Footer">

	<div class="container">
		<?php
			$sidebars_count = 0;	
			for( $i = 1; $i <= 4; $i++ ){
				if ( is_active_sidebar( 'footer-area-'. $i ) ) $sidebars_count++;
			}
		
			$sidebar_class = '';
			if( $sidebars_count > 0 ){
				switch( $sidebars_count ){
					case 2: $sidebar_class = 'one-second'; break; 
					case 3: $sidebar_class = 'one-third'; break; 
					case 4: $sidebar_class = 'one-fourth'; break;
					default: $sidebar_class = 'one';
				}
			}
		?>
		
		<?php 
			for( $i = 1; $i <= 4; $i++ ){
				if ( is_active_sidebar( 'footer-area-'. $i ) ){
					echo '<div class="'. $sidebar_class .' column">';
						dynamic_sidebar( 'footer-area-'. $i );
					echo '</div>';
				}
			}
		?>

	</div>
	
	<div class="container">
		<div class="column one copyrights">
			<p>
				&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. <?php _e( 'All Rights Reserved.', 'tisson' ); ?>
				<?php _e( 'Powered by', 'tisson' ); ?> <a target="_blank" href="http://wordpress.org">WordPress</a>. <?php _e( 'Created by', 'tisson' ); ?> <a target="_blank" href="http://themeforest.net/user/muffingroup/portfolio?ref=muffingroup">Muffin group</a>.
			</p>
			<div class="social">
				<ul>
					<?php if( mfn_opts_get('social-facebook') ): ?><li class="facebook"><a target="_blank" href="<?php mfn_opts_show('social-facebook'); ?>" title="Facebook">F</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-googleplus') ): ?><li class="googleplus"><a target="_blank" href="<?php mfn_opts_show('social-googleplus'); ?>" title="Google+">G</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-twitter') ): ?><li class="twitter"><a target="_blank" href="<?php mfn_opts_show('social-twitter'); ?>" title="Twitter">L</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-vimeo') ): ?><li class="vimeo"><a target="_blank" href="<?php mfn_opts_show('social-vimeo'); ?>" title="Vimeo">V</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-youtube') ): ?><li class="youtube"><a target="_blank" href="<?php mfn_opts_show('social-youtube'); ?>" title="YouTube">X</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-flickr') ): ?><li class="flickr"><a target="_blank" href="<?php mfn_opts_show('social-flickr'); ?>" title="Flickr">N</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-linkedin') ): ?><li class="linked_in"><a target="_blank" href="<?php mfn_opts_show('social-linkedin'); ?>" title="LinkedIn">I</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-pinterest') ): ?><li class="pinterest"><a target="_blank" href="<?php mfn_opts_show('social-pinterest'); ?>" title="Pinterest">:</a></li><?php endif; ?>
					<?php if( mfn_opts_get('social-dribbble') ): ?><li class="dribbble"><a target="_blank" href="<?php mfn_opts_show('social-dribbble'); ?>" title="Dribbble">D</a></li><?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	
</footer>

<!-- wp_footer() -->
<?php wp_footer(); ?>

</body>
</html>