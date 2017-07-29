<?php
/*
Plugin Name: WP Responsive Menu
Plugin URI: http://magnigenie.com/wp-responsive-menu-mobile-menu-plugin-wordpress/
Description: WP Responsive Menu adds a cool sliding responsive menu to your site.
Version: 1.0
Author: Nirmal Ram
Author URI: http://magnigenie.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 *
 * Enable Localization
 *
 */
load_plugin_textdomain('wprmenu', false, basename( dirname( __FILE__ ) ) . '/lang' );

/**
 *
 * Add admin settings
 *
 */
if( is_admin() ) require dirname(__FILE__).'/admin.php';

add_action( 'wp_enqueue_scripts', 'wprmenu_enqueue_scripts' ); // add required js/css files

function wprmenu_enqueue_scripts() {
	wp_enqueue_script('jquery.transit', plugins_url( '/js/jquery.transit.min.js', __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('sidr', plugins_url( '/js/jquery.sidr.js', __FILE__ ), array( 'jquery' ));
	wp_enqueue_script('wprmenu.js', plugins_url( '/js/wprmenu.js', __FILE__ ), array( 'jquery' ));

	wp_enqueue_style( 'wprmenu.css' , plugins_url('css/wprmenu.css', __FILE__) );
}


add_action( 'admin_enqueue_scripts', 'wprmenu_admin_scripts' );
function wprmenu_admin_scripts() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wprmenu-admin-js', plugins_url('js/wprmenu-admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), false, true );
}

$options = get_option('wprmenu_options');

add_action('wp_footer', 'wprmenu_menu', 100);

function wprmenu_menu() {
	$options = get_option('wprmenu_options');
	if($options['enabled']) :
		?>
		<div id="wprmenu_bar" class="wprmenu_bar" data-from_width="<?php echo $options['from_width'] ?>">
			<div class="wprmenu_ic">
				<span class="wprmenu_ic_1"></span>
				<span class="wprmenu_ic_2"></span>
				<span class="wprmenu_ic_3"></span>
			</div>
			<div class="menu_title">
				<?php echo $options['bar_title'] ?>
				<?php if($options['bar_logo']) echo '<img class="bar_logo" src="'.$options['bar_logo'].'"/>' ?>
			</div>
		</div>

		<div id="wprmenu_menu" class="wprmenu_levels <?php echo $options['position'] ?> <?php if($options["nesting_icon"] != '') echo 'wprmenu_custom_icons'  ?>" data-custom_icon="<?php echo $options["nesting_icon"]  ?>" data-custom_icon_open="<?php echo $options["nesting_icon_open"]  ?>" data-zooming="<?php echo $options["zooming"] ?>" >
			<ul id="wprmenu_menu_ul">
				<?php
				$menus = get_terms('nav_menu',array('hide_empty'=>false));
				if($menus) : foreach($menus as $m) :
					if($m->term_id == $options['menu']) $menu = $m;
				endforeach; endif;
				if(is_object($menu)) :
					wp_nav_menu( array('menu'=>$menu->name,'container'=>false,'items_wrap'=>'%3$s'));
				endif;
				?>
			</ul>
		</div>
		<?php
	endif;
}


function wprmenu_header_styles() {
	$options = get_option('wprmenu_options');
	if($options['enabled']) :
		?>
		<style id="wprmenu_css" type="text/css" >
			/* apply appearance settings */
			#wprmenu_bar {
				background: <?php echo $options["bar_bgd"] ?>;
				<?php if (is_admin_bar_showing()) : ?>
					top:28px;
				<?php endif; ?>
			}
			#wprmenu_bar .menu_title, #wprmenu_bar .wprmenu_icon_menu {
				color: <?php echo $options["bar_color"] ?>;
			}
			#wprmenu_menu {
				background: <?php echo $options["menu_bgd"] ?>!important;
			}
			#wprmenu_menu.wprmenu_levels ul li {
				border-bottom:1px solid <?php echo $options["menu_border_bottom"] ?>;
				border-top:1px solid <?php echo $options["menu_border_top"] ?>;
			}
			#wprmenu_menu ul li a {
				color: <?php echo $options["menu_color"] ?>;
			}
			#wprmenu_menu ul li a:hover {
				color: <?php echo $options["menu_color_hover"] ?>;
			}
			#wprmenu_menu.wprmenu_levels a.wprmenu_parent_item {
				border-left:1px solid <?php echo $options["menu_border_top"] ?>;
			}
			#wprmenu_menu .wprmenu_icon_par {
				color: <?php echo $options["menu_color"] ?>;
			}
			#wprmenu_menu .wprmenu_icon_par:hover {
				color: <?php echo $options["menu_color_hover"] ?>;
			}
			#wprmenu_menu.wprmenu_levels ul li ul {
				border-top:1px solid <?php echo $options["menu_border_bottom"] ?>;
			}
			#wprmenu_bar .wprmenu_ic span {
				background: <?php echo $options["menu_icon_color"] ?>;
			}
			<?php
			//when option "hide bottom borders is on...
			if($options["menu_border_bottom_show"] === 'no') { ?>
				#wprmenu_menu, #wprmenu_menu ul, #wprmenu_menu li {
					border-bottom:none!important;
				}
				#wprmenu_menu.wprmenu_levels > ul {
					border-bottom:1px solid <?php echo $options["menu_border_top"] ?>!important;
				}
				.wprmenu_no_border_bottom {
					border-bottom:none!important;
				}
				#wprmenu_menu.wprmenu_levels ul li ul {
					border-top:none!important;
				}
			<?php } ?>

			#wprmenu_menu.left {
				width:<?php echo $options["how_wide"] ?>%;
				left: -<?php echo $options["how_wide"] ?>%;
			    right: auto;
			}
			<?php if (is_admin_bar_showing()) : ?>
				#wprmenu_menu.left ul#wprmenu_menu_ul, #wprmenu_menu.right ul#wprmenu_menu_ul {
					padding-top: 70px; /* 42 + 28 */
				}
			<?php endif; ?>
			#wprmenu_menu.right {
				width:<?php echo $options["how_wide"] ?>%;
			    right: -<?php echo $options["how_wide"] ?>%;
			    left: auto;
			}


			<?php if($options["nesting_icon"] != '') : ?>
				#wprmenu_menu .wprmenu_icon:before {
					font-family: 'fontawesome'!important;
				}
			<?php endif; ?>

			<?php if($options["menu_symbol_pos"] == 'right') : ?>
				#wprmenu_bar .wprmenu_ic {
					float: <?php echo $options["menu_symbol_pos"] ?>!important;
					margin-right:0px!important;
				}
				#wprmenu_bar .bar_logo {
					pading-left: 0px;
				}
			<?php endif; ?>


			/* show the bar and hide othere navigation elements */
			@media only screen and (max-width: <?php echo $options["from_width"] ?>px) {
				html { padding-top: 42px!important; }
				#wprmenu_bar { display: block!important; }
				<?php
				if(count($options['hide']) > 0) {
					echo implode(', ', $options['hide']);
					echo ' { display:none!important; }';
				}
				?>
			}
			/* hide the bar & the menu */
			@media only screen and (min-width: <?php echo (int)$options["from_width"]+1 ?>px) {
			}

		</style>
		<?php
	endif;
}
add_action('wp_head', 'wprmenu_header_styles');