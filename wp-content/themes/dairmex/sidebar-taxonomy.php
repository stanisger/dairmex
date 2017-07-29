<?php
/**
 * The Page Sidebar containing the widget area.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

$portfolio_page_id = mfn_opts_get( 'portfolio-page' );
$sidebars = mfn_opts_get( 'sidebars' );
$sidebar = get_post_meta($portfolio_page_id, 'mfn-post-sidebar', true);
$sidebar = $sidebars[$sidebar];
?>


<div class="four columns">
	<div class="widget-area clearfix">
		<?php if ( ! dynamic_sidebar ( $sidebar ) ):
			mfn_nosidebar();				
		endif; ?>
		<div class="widget-area-bottom"></div>
	</div>
</div>