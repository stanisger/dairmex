<!-- #Top_area -->
<div id="Top_area">

	<!-- #Top_bar -->
	<div id="Top_bar">
		<div class="container">
			<div class="sixteen columns">				

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
				
				<?php if( mfn_opts_get('telephone-number') ): ?>
					<div class="phone">
						<i class="icon-mobile-phone"></i> <a href="tel:<?php mfn_opts_show('telephone-number') ?>"><?php mfn_opts_show('telephone-number') ?></a>
					</div>
				<?php endif; ?>								
				
			</div>
		</div>
	</div>
	
	<!-- #Header -->
	<header id="Header">
		<div class="container">
			<div class="sixteen columns">
			
				<!-- #logo -->
				<?php if( is_front_page() ) echo '<h1>'; ?>
				<a id="logo" href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ); ?>">
					<img src="<?php mfn_opts_show('logo-img',THEME_URI .'/images/logo.png'); ?>" alt="<?php bloginfo( 'name' ); ?>" />
				</a>
				<?php if( is_front_page() ) echo '</h1>'; ?>
				
				<!-- main menu -->
				<?php mfn_wp_nav_menu(); ?>
				<a class="responsive-menu-toggle" href="#"><i class='icon-reorder'></i></a>
	
			</div>		
		</div>
	</header>

</div>