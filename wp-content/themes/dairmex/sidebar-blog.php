<?php
/**
 * The Blog Sidebar containing the widget area.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

$posts_page_id = get_option( 'page_for_posts' );
$sidebars = mfn_opts_get( 'sidebars' );
$sidebar = get_post_meta($posts_page_id, 'mfn-post-sidebar', true);
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