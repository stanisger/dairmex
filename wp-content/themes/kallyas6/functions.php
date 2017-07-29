<?php
	/*--------------------------------------------------------------------------------------------------
	File: functions.php

	Description: This is the main functions file for this theme

	Please be careful when editing this file

	--------------------------------------------------------------------------------------------------*/
	
	define( 'THEMENAME', 'Kallyas' );
	
	define( 'OPTIONS', 'zn_kallyas_options' );
	
	define( 'THEME_VERSION', '3.6.9' );
	
	if ( function_exists( 'icl_get_home_url' ) ) {
		
		define( 'HOME_URL', icl_get_home_url() );
	}
	
	else {
		
		define( 'HOME_URL', get_home_url() );
	}
	
	$get_stylesheet_directory = get_stylesheet_directory();
	
	$get_stylesheet_directory_uri = get_stylesheet_directory_uri();
	
	$get_template_directory_uri = get_template_directory_uri();
	
	if ( ! defined( 'ADMIN_PATH' ) ) {
		define( 'ADMIN_PATH', $get_stylesheet_directory . '/admin/' );
	}
	
	if ( ! defined( 'ADMIN_DIR' ) ) {
		define( 'ADMIN_DIR', $get_stylesheet_directory_uri . '/admin/' );
	}
	
	if ( ! defined( 'THEME_DIR' ) ) {
		define( 'THEME_DIR', $get_stylesheet_directory_uri );
	}
	
	if ( ! defined( 'MASTER_THEME_DIR' ) ) {
		define( 'MASTER_THEME_DIR', $get_template_directory_uri );
	}
	
	if ( ! defined( 'IMAGES_URL' ) ) {
		define( 'IMAGES_URL', $get_template_directory_uri . '/images' );
	}
	
	if ( ! defined( 'ADMIN_IMAGES_DIR' ) ) {
		define( 'ADMIN_IMAGES_DIR', $get_template_directory_uri . '/admin/images' );
	}
	
	if ( ! defined( 'ADMIN_MASTER_ADMIN_DIR' ) ) {
		define( 'ADMIN_MASTER_ADMIN_DIR', $get_template_directory_uri . '/admin/' );
	}
	
	//++@wpk
	$wpkContentDir = ( defined( 'WP_CONTENT_DIR' ) ? trailingslashit( WP_CONTENT_DIR ) : ABSPATH . '/wp-content/' );
	require( $wpkContentDir . 'themes/kallyas/plugins/wpk-notifications/wpk-notifications.php' );
	require( $wpkContentDir . 'themes/kallyas/admin/framework/ZnDebug.php' );
	unset( $wpkContentDir );
	//--
	
	/*--------------------------------------------------------------------------------------------------

Load all options inside $znData to be used in the theme

--------------------------------------------------------------------------------------------------*/
	
	/**
	 * @global $data
	 * @deprecated
	 * @since 3.6.3
	 * @use $znData instead
	 */
	global $data;
	
	$___temp = $data = $znData = get_option( OPTIONS );
	
	/*
	 * @hook after_setup_theme
	 * Loads after the theme functions.php file is loaded...may break other things ?
	 */
	add_action( 'after_setup_theme', 'wpk_zn_on_init' );
	if ( ! function_exists( 'wpk_zn_on_init' ) ) {
		function wpk_zn_on_init()
		{
			if ( is_admin() ) {
				include_once( locate_template( array ( 'admin/zn-init.php' ), false ) );
			}
			else {
				// LOAD WOOCOMMERCE CONFIG FILE
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					locate_template( array ( 'woocommerce/zn-woocommerce-init.php' ), true, false );
				}
				locate_template( array ( 'admin/framework/function-vt-resize.php' ), true, false );
				locate_template( array ( 'template-helpers/content-page.php' ), true, false );
				locate_template( array ( 'template-helpers/shortcodes.php' ), true, false );
			}



		}
	}

	// The Widgets needs to be loaded in both admin and frontend !
	locate_template( array ( 'widgets/widget-blog-categories.php' ), true, false );
	locate_template( array ( 'widgets/widget-archive.php' ), true, false );
	locate_template( array ( 'widgets/widget-menu.php' ), true, false );
	locate_template( array ( 'widgets/widget-twitter.php' ), true, false );
	locate_template( array ( 'widgets/widget-contact-details.php' ), true, false );
	locate_template( array ( 'widgets/widget-mailchimp.php' ), true, false );
	locate_template( array ( 'widgets/widget-tag-cloud.php' ), true, false );
	locate_template( array ( 'widgets/widget-latest_posts.php' ), true, false );
	locate_template( array ( 'widgets/widget-social_buttons.php' ), true, false );
	locate_template( array ( 'widgets/widget-flickr.php' ), true, false );
	
	/*
	 * @hook after_setup_theme
	 */
	add_action( 'after_setup_theme', 'wpk_zn_on_after_setup_theme' );
	if ( ! function_exists( 'wpk_zn_on_after_setup_theme' ) ) {
		function wpk_zn_on_after_setup_theme()
		{
			load_theme_textdomain( THEMENAME, get_template_directory() . '/languages' );
			add_theme_support( 'woocommerce' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
		}
	}

	/**
	 * Register the Page Builder scripts to admin footer
	 *
	 * @hook admin_footer
	 */
	add_action( 'admin_footer', 'wpk_zn_admin_enqueue_scripts', 100 );
	if ( ! function_exists( 'wpk_zn_admin_enqueue_scripts' ) ) {
		function wpk_zn_admin_enqueue_scripts()
		{
            if(WpkZn::canLoadResources('post.php') || WpkZn::canLoadResources('post-new.php')) {
                wp_enqueue_script( 'wpk-zn-page-builder', get_template_directory_uri() . '/admin/js/wpk-zn-page-builder.js', array( 'jquery' ), THEME_VERSION );
            }
		}
	}

	/*--------------------------------------------------------------------------------------------------

	Shortcodes fixer

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'shortcode_empty_paragraph_fix' ) ) {
		
		function shortcode_empty_paragraph_fix( $content )
		{
			
			$array = array (
				
				'<p>['    => '[',
				']</p>'   => ']',
				']<br />' => ']'
			
			);
			
			return $content = strtr( $content, $array );
		}
	}
	
	add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );
	
	/*--------------------------------------------------------------------------------------------------

GET THE MEDIA ID FROM URL

--------------------------------------------------------------------------------------------------*/
	
	function pn_get_attachment_id_from_url( $attachment_url = '' )
	{
		
		global $wpdb;
		
		$attachment_id = false;
		
		// If there is no url, return.
		
		if ( empty( $attachment_url ) ) {
			return $attachment_id;
		}
		
		// Get the upload directory paths
		
		$upload_dir_paths = wp_upload_dir();
		
		// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
		
		if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
			
			// If this is the URL of an auto-generated thumbnail, get the URL of the original image
			
			$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
			
			// Remove the upload path base directory from the attachment URL
			
			$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
			
			// Finally, run a custom database query to get the attachment ID from the modified attachment URL
			
			$attachment_id = $wpdb->get_var(
				
				$wpdb->prepare( "
				SELECT wposts.ID
					FROM {$wpdb->posts} AS wposts
					 	INNER JOIN {$wpdb->postmeta} AS wpostmeta
							ON wposts.ID = wpostmeta.post_id
						WHERE wpostmeta.meta_key = '_wp_attached_file'
							AND wpostmeta.meta_value = '%s'
							AND wposts.post_type = 'attachment'", $attachment_url ) );
		}
		return $attachment_id;
	}
	
	/*--------------------------------------------------------------------------------------------------

Check if we are on the taxonomy archive page. We will display all items if it is selected

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_portfolio_taxonomy_pagination' ) ) {
		
		function zn_portfolio_taxonomy_pagination( $query )
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( isset( $znData['portfolio_per_page'] ) && ! empty( $znData['portfolio_per_page'] ) ) {
				
				if ( ( is_tax( 'project_category' ) && $query->is_main_query() ) || ( is_post_type_archive( 'portfolio' ) && $znData['portfolio_style'] == 'portfolio_sortable' ) ) {
					
					set_query_var( 'posts_per_page', $znData['portfolio_per_page'] );
				}
			}
			
			if ( isset( $znData['portfolio_per_page_show'] ) && ! empty( $znData['portfolio_per_page_show'] ) ) {
				
				if ( ( is_tax( 'project_category' ) && $query->is_main_query() ) || ( is_post_type_archive( 'portfolio' ) && $znData['portfolio_style'] != 'portfolio_sortable' ) ) {
					
					set_query_var( 'showposts', $znData['portfolio_per_page_show'] );
				}
			}
		}
	}
	add_action( 'pre_get_posts', 'zn_portfolio_taxonomy_pagination' );
	
	/*--------------------------------------------------------------------------------------------------

Show the page builder elements based on area

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_get_template_from_area' ) ) {
		
		function zn_get_template_from_area( $area, $post_id, $meta_fields, $sidebar = false )
		{
			
			if ( isset( $meta_fields ) && isset( $meta_fields[ $area ] ) ) {
				
				global $post;
				
				$GLOBALS['meta_fields'] = $meta_fields;
				
				if ( $area == 'content_main_area' || $area == 'content_grey_area' || $area == 'content_bottom_area' ) {
					
					$sizes = array (
						
						"four"       => "0.25",
						"one-third"  => "0.33",
						"eight"      => "0.5",
						"two-thirds" => "0.66",
						"twelve"     => "0.75",
						"sixteen"    => "1",
					
					);
					
					$size = 0;
					
					$i = 0;
					
					$all_elements = count( $meta_fields[ $area ] );
					
					$no_margin = '';
					
					foreach ( $meta_fields[ $area ] as $options ) {
						
						if ( $all_elements == 1 && $options['dynamic_element_type'] == '_shop_features' ) {
							
							$no_margin = 'shop-features';
						}
						
						if ( $size == '0' ) {
							
							if ( $sidebar == true ) {
								
								$row_style = 'row-fluid zn-row-' . $i;
							}
							else {
								
								$row_style = 'row zn-row-' . $i;
							}
							
							echo '<div class="' . $row_style . ' ' . $no_margin . '">';
						}

						locate_template( '/template-helpers/pagebuilder/' . $options['dynamic_element_type'] . '.php', true, true );
						
						$options['dynamic_element_type']( $options );
						
						if ( isset ( $options['_sizer'] ) ) {
							
							$size += $sizes[ $options['_sizer'] ];
						}
						
						$i ++;
						
						if ( $size == '1' || $size == '0.99' || $size == '0.91' || $size == '0.88' || $all_elements == $i ) {
							
							echo '</div>';
							
							$size = 0;
						}
					}
				}
				else {
					
					foreach ( $meta_fields[ $area ] as $options ) {
						
						locate_template( '/template-helpers/pagebuilder/' . $options['dynamic_element_type'] . '.php', true, true );
						
						$options['dynamic_element_type']( $options );
					}
				}
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Load/set the theme translation files

Translations can be filed in the /languages/ directory

--------------------------------------------------------------------------------------------------*/
	
	//	load_theme_textdomain( THEMENAME, get_template_directory() . '/languages' );
	
	/*--------------------------------------------------------------------------------------------------

Get the page number

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'get_page_number' ) ) {
		
		function get_page_number()
		{
			
			// If the home page is a static page, the query_var will be "page" not "paged"
			
			$pn = get_query_var( 'paged', null ); // default
			
			if ( is_null( $pn ) ) {
				
				$pn = get_query_var( 'page', 1 );
			}
			
			print ' | ' . __( 'Page ', THEMENAME ) . $pn;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Wrap post images in HoverBorder Class

--------------------------------------------------------------------------------------------------*/
	
	add_filter( 'the_content', 'zn_wrap_images' );
	
	if ( ! function_exists( 'zn_wrap_images' ) ) {
		
		function zn_wrap_images( $content )
		{
			$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)><img(.*?)class=('|\")(.*?)(.*?)(alignleft|alignright|aligncenter|alignnone)(.*?)('|\")(.*?)>/i";
			
			$replacement = '<a$1href=$2$3.$4$5 class="hoverBorder $11"$6><img class="$10$12"$14>';
			
			$content = preg_replace( $pattern, $replacement, $content );

			return $content;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Calculate proper size

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_get_size' ) ) {
		
		function zn_get_size( $size, $sidebar = null, $extra = 0 )
		{
			
			global $znData;
			
			$span_sizes = array (
				
				"four"               => "span3",
				"one-third"          => "span4",
				"span5"              => "span5",
				"eight"              => "span6",
				"two-thirds"         => "span8",
				"twelve"             => "span9",
				"sixteen"            => "span12",
				"portfolio_sortable" => 'portfolio_sortable'
			
			);

			// 1170 LAYOUT
			
			if ( $znData['zn_width'] == '1170' ) {
				
				$image_width = array (
					
					"four"               => "270",
					"one-third"          => "370",
					"span5"              => "470",
					"eight"              => "570",
					"two-thirds"         => "770",
					"twelve"             => "870",
					"sixteen"            => "1170",
					"span2"              => "170",
					"span3"              => "270",
					"span4"              => "370",
					"span6"              => "570",
					"span7"              => "670",
					"span8"              => "770",
					"span9"              => "870",
					"span10"             => "970",
					"span11"             => "1070",
					"span12"             => "1170",
					"portfolio_sortable" => '260'
				
				);
			}
			
			// 960 LAYOUT
			
			elseif ( $znData['zn_width'] == '960' ) {
				
				$image_width = array (
					
					"four"               => "220", // DONE
					
					"one-third"          => "370",
					"eight"              => "460", // DONE
					
					"two-thirds"         => "770",
					"twelve"             => "870",
					"sixteen"            => "960", // DONE
					
					"span3"              => "220", // DONE
					
					"span4"              => "300", // DONE
					
					"span5"              => "460",
					"span6"              => "460", // DONE
					
					"span7"              => "670",
					"span8"              => "770",
					"span9"              => "870",
					"span10"             => "970",
					"span11"             => "1070",
					"span12"             => "960", // DONE
					
					"portfolio_sortable" => '210'
				
				);
			}
			
			if ( $sidebar ) {
				
				$image_width[ $size ] = $image_width[ $size ] - 300 - $extra;
			}
			
			elseif ( isset ( $extra ) ) {
				
				$image_width[ $size ] = $image_width[ $size ] - $extra;
			}
			
			$n_height = $image_width[ $size ] / ( 16 / 9 );
			
			//echo $sizes[$size];
			
			$new_size = array ();
			
			if ( isset ( $span_sizes[ $size ] ) ) {
				
				$new_size['sizer'] = $span_sizes[ $size ];
			}
			
			if ( isset ( $image_width[ $size ] ) ) {
				
				$new_size['width'] = $image_width[ $size ];
			}
			
			$new_size['height'] = $n_height;

			return $new_size;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

SET THE CONTENT WIDTH

--------------------------------------------------------------------------------------------------*/
	
	if ( ! isset( $content_width ) ) {
		
		$content_width = 1170;
	}
	
	if ( ! function_exists( 'zn_adjust_content_width' ) ) {
		
		function zn_adjust_content_width()
		
		{
			
			global $content_width, $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			// 1170 LAYOUT
			
			if ( $znData['zn_width'] == '960' ) {
				
				$content_width = 960;
			}
		}
	}
	
	add_action( 'template_redirect', 'zn_adjust_content_width' );
	
	/*--------------------------------------------------------------------------------------------------

OVERRIDE WORDPRESS POST GALLERY SHORTCODE

--------------------------------------------------------------------------------------------------*/
	
	remove_shortcode( 'gallery', 'gallery_shortcode' );
	
	if ( ! function_exists( 'zn_custom_gallery' ) ) {
		
		function zn_custom_gallery( $attr )
		{
			
			global $post;
			
			static $instance = 0;
			
			$instance ++;
			
			if ( ! empty( $attr['ids'] ) ) {
				
				// 'ids' is explicitly ordered, unless you specify otherwise.
				
				if ( empty( $attr['orderby'] ) ) {
					$attr['orderby'] = 'post__in';
				}
				
				$attr['include'] = $attr['ids'];
			}
			
			// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			
			if ( isset( $attr['orderby'] ) ) {
				
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				
				if ( ! $attr['orderby'] ) {
					unset( $attr['orderby'] );
				}
			}
			
			// declare vars
			
			$id      = 0;
			$order   = 'RAND';
			$orderby = 'none';
			$size    = 0;
			$itemtag = $captiontag = $icontag = '';
			
			$columns = 0;
			
			extract( shortcode_atts( array (
				
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => 'dl',
				'icontag'    => 'dt',
				'captiontag' => 'dd',
				'columns'    => 3,
				'size'       => 'thumbnail',
				'include'    => '',
				'exclude'    => ''
			
			), $attr ) );
			
			$id = intval( $id );
			
			if ( 'RAND' == $order ) {
				$orderby = 'none';
			}
			
			if ( ! empty( $include ) ) {
				
				$_attachments = get_posts( array (
					'include'        => $include,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby
				) );
				
				$attachments = array ();
				
				foreach ( $_attachments as $key => $val ) {
					
					$attachments[ $val->ID ] = $_attachments[ $key ];
				}
			}
			
			elseif ( ! empty( $exclude ) ) {
				
				$attachments = get_children( array (
					'post_parent'    => $id,
					'exclude'        => $exclude,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby
				) );
			}
			
			else {
				
				$attachments = get_children( array (
					'post_parent'    => $id,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => $order,
					'orderby'        => $orderby
				) );
			}
			
			if ( empty( $attachments ) ) {
				return '';
			}
			
			if ( is_feed() ) {
				
				$output = "\n";
				
				foreach ( $attachments as $att_id => $attachment ) {
					$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
				}
				
				return $output;
			}
			
			$itemtag = tag_escape( $itemtag );
			
			$captiontag = tag_escape( $captiontag );
			
			$icontag = tag_escape( $icontag );
			
			$valid_tags = wp_kses_allowed_html( 'post' );
			
			if ( ! isset( $valid_tags[ $itemtag ] ) ) {
				$itemtag = 'dl';
			}
			
			if ( ! isset( $valid_tags[ $captiontag ] ) ) {
				$captiontag = 'dd';
			}
			
			if ( ! isset( $valid_tags[ $icontag ] ) ) {
				$icontag = 'dt';
			}
			
			$columns = intval( $columns );
			
			$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
			
			$float = is_rtl() ? 'right' : 'left';
			
			$selector = "gallery-{$instance}";
			
			$gallery_style = $gallery_div = '';
			
			if ( apply_filters( 'use_default_gallery_style', true ) ) {

				$gallery_style = "
<style type='text/css'>
	#{$selector} {
		margin: auto;
	}
	#{$selector} .gallery-item {
		float: {$float};
		margin-top: 10px;
		text-align: center;
		width: {$itemwidth}%;
	}
	#{$selector} .gallery-caption {
		margin-left: 0;
	}
</style>
<!-- see gallery_shortcode() in wp-includes/media.php -->";
			}
			
			$size_class = sanitize_html_class( $size );
			
			$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
			
			$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
			
			$num_ids = count( $attachments );
			
			$i = 1;
			
			$c = 1;
			
			$num_columns = 12 / $columns;
			
			$uid = uniqid( 'pp_' );
			
			foreach ( $attachments as $id => $attachment ) {
				
				if ( $c == 1 || $c % ( $columns + 1 ) == 0 ) {
					
					$output .= '<div class="row-fluid zn_image_gallery">';
					
					$c = 1;
				}
				
				if ( $captiontag && trim( $attachment->post_excerpt ) ) {
					
					$title_caption = wptexturize( $attachment->post_excerpt );
				}
				
				else {
					
					$title_caption = '';
				}
				
				$output .= '<div class="span' . $num_columns . '">';
				
				$output .= '<a rel="prettyPhoto[' . $uid . ']" href="' . wp_get_attachment_url( $id ) . '" title="' . $title_caption . '" class="hoverBorder">';
				
				$output .= wp_get_attachment_image( $id, $size, 0, $attr );
				
				$output .= '</a>';
				
				$output .= '</div>';
				
				if ( ( $columns > 0 && $i % $columns == 0 ) || $i == $num_ids ) {
					
					$output .= '</div>';
				}
				
				$i ++;
				
				$c ++;
			}
			
			$output .= '</div>';
			
			return $output;
		}
	}
	
	add_shortcode( 'gallery', 'zn_custom_gallery' );
	
	//add_theme_support('post-formats', array('aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));
	
	/*--------------------------------------------------------------------------------------------------

Logo SEO function

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_logo' ) ) {
		
		function zn_logo()
		
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			$logo = '';
			
			if ( empty( $znData['head_show_logo'] ) || ( ! empty( $znData['head_show_logo'] ) && $znData['head_show_logo'] == 'yes' ) ) {
				
				if ( is_front_page() ) {
					
					if ( isset ( $znData['logo_upload'] ) && ! empty ( $znData['logo_upload'] ) ) {
						
						$logo = '<h1 id="logo"><a href="' . HOME_URL . '"><img src="' . $znData['logo_upload'] . '" alt="' . get_bloginfo( 'name' ) . '" title="' . get_bloginfo( 'description' ) . '" /></a></h1>';
					}
					
					else {
						
						$logo = '<h1 id="logo"><a href="' . HOME_URL . '">' . get_bloginfo( 'name' ) . '</a></h1>';
					}
				}
				
				else {
					
					if ( isset ( $znData['logo_upload'] ) && ! empty ( $znData['logo_upload'] ) ) {
						
						$logo = '<h3 id="logo"><a href="' . HOME_URL . '"><img src="' . $znData['logo_upload'] . '" alt="' . get_bloginfo( 'name' ) . '" title="' . get_bloginfo( 'description' ) . '" /></a></h3>';
					}
					
					else {
						
						$logo = '<h3 id="logo"><a href="' . HOME_URL . '">' . get_bloginfo( 'name' ) . '</a></h3>';
					}
				}
			}
			
			return $logo;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Favicon function

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_favicon' ) ) {
		
		function zn_favicon()
		
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( isset( $znData['custom_favicon'] ) && ! empty( $znData['custom_favicon'] ) ) {
				
				$favicon = '<link rel="shortcut icon" href="' . $znData['custom_favicon'] . '"/>';
			}
			
			else {
				
				$favicon = '<link rel="shortcut icon" href="' . get_bloginfo( 'template_directory' ) . '/images/favicons/favicon.ico"/>';
			}
			
			echo $favicon;
		}
	}
	
	add_action( 'wp_head', 'zn_favicon' );
	
	/*--------------------------------------------------------------------------------------------------

Load the css for the theme

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_add_styles' ) ) {
		
		function zn_add_styles()
		{
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( ! is_admin() ) {
				
				wp_enqueue_style( 'zn-bootstrapcss', MASTER_THEME_DIR . '/css/bootstrap.css', array (), false, 'all' );
				
				//  Superfish menu
				
				wp_enqueue_style( 'zn-superfish', MASTER_THEME_DIR . '/addons/superfish_responsive/superfish.css', array (), false, 'all' );
				
				// TEMPLATE MAIN STYLE
				
				wp_enqueue_style( 'zn-templtecss', MASTER_THEME_DIR . '/css/template.css', array (), false, 'all' );
				
				// if responsive
				
				if ( $znData['zn_responsive'] == 'yes' ) {
					
					wp_enqueue_style( 'zn-bootstrap-responsivecss', MASTER_THEME_DIR . '/css/bootstrap-responsive.css', array (), false, 'all' );
				} //if not
				
				else {
					
					// 1170 LAYOUT
					
					if ( $znData['zn_width'] == '1170' ) {
						
						// this will contain override of the grid (no media query inside)
						
						wp_enqueue_style( 'zn-bootstrap-1170css', MASTER_THEME_DIR . '/css/bootstrap-1170.css', array (), false, 'all' );
					} // 960 LAYOUT
					
					else {
						//wp_enqueue_style('zn-tweacks960', MASTER_THEME_DIR . '/css/bootstrap-960.css',array() ,false,'all');
						
					}
				}
				
				// Pretty Photo
				
				wp_enqueue_style( 'pretty_photo', MASTER_THEME_DIR . '/addons/prettyphoto/prettyPhoto.css', array (), false, 'all' );
				
				// Superfish menu
				
				wp_enqueue_style( 'zn-superfish', MASTER_THEME_DIR . '/addons/superfish_responsive/superfish.css', array (), false, 'all' );
				
				// Main Wordpress style
				
				wp_enqueue_style( 'theme_style', THEME_DIR . '/style.css', array (), false, 'all' );
				
				wp_enqueue_style( 'Lato_default', '//fonts.googleapis.com/css?family=Lato:300,400,700,900&amp;v1&amp;subset=latin,latin-ext', false, 1.0, 'screen' );
				
				wp_enqueue_style( 'Open+Sans_default', '//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&amp;v1&amp;subset=latin,latin-ext', false, 1.0, 'screen' );
				
				/*	Load Google Fonts if they are needed */
				
				$subset = '';

				$one_array_font = array ();
				
				$all_final_fonts = array ();
				
				$normal_faces = array (
					'arial',
					'verdana',
					'trebuchet',
					'georgia',
					'times',
					'tahoma',
					'palatino',
					'helvetica'
				);
				
				if ( is_array( $znData['fonts'] ) ) {
					
					$znData['fonts'] = array_unique( $znData['fonts'] );
				}
				else {
					
					$znData['fonts'] = array ();
				}
				
				if ( empty ( $znData['all_g_fonts'] ) ) {
					//	$znData['all_g_fonts'] = array();
					
				}
				
				foreach ( $znData['fonts'] as $key => $font ) {
					
					if ( ! in_array( $font, $normal_faces ) ) {
						
						$one_array_font[ $font ] = array ( 'variant' => array ( 'regular' ) );
					}
				}
				
				if ( ! empty ( $znData['all_g_fonts'] ) ) {
					
					$one_array_font = array_merge( $one_array_font, $znData['all_g_fonts'] );
				}
				
				if ( ! empty ( $znData['g_fonts_subset'] ) ) {
					
					$subset = '&amp;subset=' . str_replace( ' ', '', $znData['g_fonts_subset'] );
				}
				
				foreach ( $one_array_font as $font => $variants ) {
					
					if ( ! empty( $font ) ) {
						
						$font = str_replace( ' ', '+', $font );
						
						$variants = implode( ',', array_values( $variants['variant'] ) );
						
						$all_final_fonts[] = $font . ':' . $variants;
					}
				}
				
				$gfont = implode( '|', $all_final_fonts );
				
				wp_enqueue_style( 'zn_all_g_fonts', '//fonts.googleapis.com/css?family=' . $gfont . '' . $subset );
				
				if ( $znData['zn_main_style'] == 'dark' ) {
					
					wp_enqueue_style( 'zn-dark-style', MASTER_THEME_DIR . '/css/dark-theme.css', array (), false, 'all' );
				}
				
				// Generated css file - The options needs to be saved in order to generate new file
				
				if ( is_multisite() ) {
					$uploads = wp_upload_dir();
					wp_enqueue_style( 'options', $uploads['baseurl'] . '/options.css', 'style' );
				}
				else {
					wp_enqueue_style( 'options', MASTER_THEME_DIR . '/css/options.css', 'style' );
				}
			}
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'zn_add_styles' );
	
	/*--------------------------------------------------------------------------------------------------

Add extra data to head

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_head' ) ) {
		
		function zn_head()
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			?>
			
			<!--[if lte IE 9]>
			<link rel="stylesheet" type="text/css" href="<?php echo MASTER_THEME_DIR; ?>/css/fixes.css"/>
			<![endif]-->
			<!--[if lte IE 8]>
			<script src="<?php echo MASTER_THEME_DIR; ?>/js/respond.js"></script>
			<script type="text/javascript">
				var $buoop = {
					vs: {
						i: 8, f: 6, o: 10.6, s: 4, n: 9
					}
				};
				
				$buoop.ol = window.onload;
				
				window.onload = function ()
				{
					
					try {
						
						if ($buoop.ol) $buoop.ol();
					
					}
					catch (e) {
					}
					
					var e = document.createElement("script");
					
					e.setAttribute("type", "text/javascript");
					
					e.setAttribute("src", "<?php echo get_current_scheme();?>://browser-update.org/update.js");
					
					document.body.appendChild(e);
				
				};
			
			</script>
			
			<![endif]-->
			
			
			
			<?php
			
			
			
			if ( isset( $znData['face_og'] ) && ! empty( $znData['face_og'] ) ) {
				
				?>
				
				<!-- Facebook OpenGraph Tags - Replace with your own -->
				
				<meta property="og:title" content="<?php zn_opengraph_default_title(); ?>"/>
				
				<meta property="og:type" content="<?php zn_opengraph_default_type(); ?>"/>
				
				<meta property="og:url"
					  content="<?php echo get_current_scheme() . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
				
				<?php opengraph_default_image(); ?>
				
				<meta property="og:site_name" content=" <?php bloginfo( 'name' ); ?>"/>
				
				<meta property="fb:app_id"
					  content="<?php echo $znData['face_AP_ID']; ?>"/> <!-- PUT HERE YOUR OWN APP ID - you could get errors if you don't use this one -->
				
				<meta property="og:description" content=" <?php bloginfo( 'description' ); ?>"/>
				
				<!-- END Facebook OpenGraph Tags -->
			
			<?php
			}
			
			?>
			
			<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
			
			<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
		
		<?php
		}
	}
	
	add_action( 'wp_head', 'zn_head' );
	
	/*--------------------------------------------------------------------------------------------------

ENABLE/DISABLE responsive

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_responsive' ) ) {
		
		function zn_responsive()
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			/* ADD RESPONSIVE META */
			
			if ( $znData['zn_responsive'] == 'yes' ) {
				
				echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
			}
		}
	}
	
	add_action( 'wp_head', 'zn_responsive' );
	
	/*--------------------------------------------------------------------------------------------------

ZN PAGE LOADING

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_page_loading' ) ) {
		
		function zn_page_loading()
		
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( isset( $znData['page_preloader'] ) && $znData['page_preloader'] == 'yes' ) {
				
				echo '<div id="page-loading"></div>';
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

ZN FACEBOOK OPEN GRAPH

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_f_o_g' ) ) {
		
		function zn_f_o_g()
		
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( isset( $znData['face_og'] ) && $znData['face_og'] ) { ?>
				
				<div id="fb-root"></div>
				<script type="text/javascript">
					
					(function (d, s, id)
					{
						
						var js, fjs = d.getElementsByTagName(s)[0];
						
						if (d.getElementById(id)) {
							return;
						}
						
						js = d.createElement(s);
						
						js.id = id;
						
						js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $znData['face_AP_ID'];
						?>";
						
						fjs.parentNode.insertBefore(js, fjs);
						
					}(document, 'script', 'facebook-jssdk'));
				
				</script>
			
			<?php }
		}
	}
	
	$zn_array = array ();
	
	//global $content_and_sidebar;
	
	$content_and_sidebar = true;
	
	if ( ! function_exists( 'zn_flag_content_and_sidebar' ) ) {
		
		function zn_flag_content_and_sidebar()
		{
			
			global $content_and_sidebar;
			
			$content_and_sidebar = false;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Load the javascript files only if needed

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'smart_load' ) ) {
		
		function smart_load()
		{
            if(is_admin()){
                return;
            }
			global $post, $znData;
			if ( ! isset( $znData ) || empty( $znData ) ) {
				$znData = get_option( OPTIONS );
			}
			
			if ( $post ) {
				
				if ( is_archive() && get_post_type() == 'product' ) {
					
					$shop_page_id = get_option( 'woocommerce_shop_page_id' );
					
					$meta_fields = get_post_meta( $shop_page_id, 'zn_meta_elements', true );
					
					$meta_fields = maybe_unserialize( $meta_fields );
				}
				
				else {
					
					$meta_fields = get_post_meta( get_queried_object_id(), 'zn_meta_elements', true );
					
					$meta_fields = maybe_unserialize( $meta_fields );
				}
				
				// All the page builder areas
				
				$areas = array (
					'header_area',
					'action_box_area',
					'content_main_area',
					'content_grey_area',
					'content_bottom_area'
				);
				
				$metas = array ();
				
				foreach ( $areas as $area ) {
					
					if ( isset ( $meta_fields[ $area ] ) ) {
						
						$metas = array_merge( $metas, $meta_fields[ $area ] );
					}
				}

				foreach ( $metas as $options ) {
					
					// CHECK IF WE HAVE CONTENT AND SIDEBAR
					if ( isset($options['dynamic_element_type'])){
						if ( $options['dynamic_element_type'] == '_content_sidebar' ) {

							zn_flag_content_and_sidebar();
						}

						// Load Paralax effect

						if ( $options['dynamic_element_type'] == '_rev_slider' ) {

							if ( $options['revslider_paralax'] ) {

								wp_enqueue_script( 'zn_parallax', MASTER_THEME_DIR . '/addons/paralax/parallax.js', array ( 'jquery' ), '1.3', true );
							}
						}

						// Load ISOTOPE FOR PORTFOLIO SORTABLE

						if ( $options['dynamic_element_type'] == '_portfolio_sortable' ) {

							wp_enqueue_script( 'isotope', MASTER_THEME_DIR . '/js/jquery.isotope.min.js', array ( 'jquery' ), '1.4.8', true );
						}

						// Carousel Slider ( CIRCULAR CONTENT)

						if ( $options['dynamic_element_type'] == '_circ1' || $options['dynamic_element_type'] == '_circ2' ) {

							wp_enqueue_style( 'circular_carousel', MASTER_THEME_DIR . '/sliders/circular_content_carousel/css/circular_content_carousel.css', 'style' );

							if ( $options['dynamic_element_type'] == '_circ2' ) {

								wp_enqueue_style( 'circular_carousel_alternative', MASTER_THEME_DIR . '/sliders/circular_content_carousel/css/circular_content_carousel_alternative.css', 'style' );
							}

							wp_enqueue_script( 'mousewheel', MASTER_THEME_DIR . '/sliders/circular_content_carousel/js/jquery.mousewheel.js', array ( 'jquery' ), '1.3', true );

							wp_enqueue_script( 'swipe', MASTER_THEME_DIR . '/sliders/circular_content_carousel/js/jquery.swipe.js', array ( 'jquery' ), '1.3', true );

							wp_enqueue_script( 'contentcarousel', MASTER_THEME_DIR . '/sliders/circular_content_carousel/js/jquery.contentcarousel.js', array ( 'jquery' ), '1.3', true );
						}

						// Nivo Slider

						if ( $options['dynamic_element_type'] == '_nivoslider' ) {

							wp_enqueue_style( 'nivo_slider', MASTER_THEME_DIR . '/sliders/nivo_slider/css/nivo-slider.css', 'style' );

							wp_enqueue_style( 'zn_shadows', MASTER_THEME_DIR . '/css/shadows.css', 'style' );

							wp_enqueue_script( 'nivo_slider', MASTER_THEME_DIR . '/sliders/nivo_slider/js/jquery.nivo.slider.pack.js', array ( 'jquery' ), '1.3', true );
						}

						// Wow Slider

						if ( $options['dynamic_element_type'] == '_wowslider' ) {

							wp_enqueue_style( 'wow_slider', MASTER_THEME_DIR . '/sliders/wow_slider/css/style.css', 'style' );

							wp_enqueue_style( 'zn_shadows', MASTER_THEME_DIR . '/css/shadows.css', 'style' );

							wp_enqueue_script( 'wow_slider', MASTER_THEME_DIR . '/sliders/wow_slider/js/wowslider.js', array ( 'jquery' ), '1.3', true );

							wp_enqueue_script( 'wow_slider_' . $options['ww_transition'] . '', MASTER_THEME_DIR . '/sliders/wow_slider/js/' . $options['ww_transition'] . '.js', array (
								'jquery',
								'wow_slider'
							), '1.3', true );
						}

						// Product Loupe

						if ( $options['dynamic_element_type'] == '_static6' ) {
// Replaces the broken default loupe plugin
wp_enqueue_style('kallyas-jquery-loupe-css', MASTER_THEME_DIR.'/addons/jquery_loupe/jquery.loupe.css', false, THEME_VERSION);
wp_enqueue_script('kallyas-jquery-loupe-js', MASTER_THEME_DIR.'/addons/jquery_loupe/jquery.loupe.js', array('jquery'), THEME_VERSION);
                        }

						// Carousel Fred plugin
                        $validTypes = array(
                            '_testimonial_slider',
                            '_woo_products',
                            '_woo_limited',
                            '_testimonial_slider2',
                            '_screenshoot_box',
                            '_partners_logos',
                            '_recent_work',
                            '_recent_work2',
                            '_wpk_latest_posts_carousel',
                            '_pslider',
                            '_portfolio_carousel',
                        );

						if ( in_array($options['dynamic_element_type'], $validTypes)) {

							wp_enqueue_script( 'pslider', MASTER_THEME_DIR . '/sliders/caroufredsel/jquery.carouFredSel-6.0.4-packed.js', array ( 'jquery' ), '6.0.4', true );
						}

						// Event Countdown

						if ( $options['dynamic_element_type'] == '_static7' ) {

							wp_enqueue_script( 'zn_event_countdown', MASTER_THEME_DIR . '/js/jquery.countdown.js', array ( 'jquery' ), '1.3', true );
						}

						// FLICKR FEED

						if ( $options['dynamic_element_type'] == '_flickrfeed' ) {

							wp_enqueue_script( 'flickr_feed', MASTER_THEME_DIR . '/addons/flickrfeed/jquery.jflickrfeed.min.js', array ( 'jquery' ), '6.0.4', true );
						}
					}

					
					// Load Mailchimp JS only if used by widget or event countdown
					
					if ( is_active_widget( false, false, 'zn_mailchimp', true ) ) {
						
						$zn_mailchimp = array (
							'zn_mailchimp' =>
								
								"/* PREPARE THE NEWSLETTER AND SEND DATA TO MAILCHIMP */

					jQuery('.nl-submit').click(function() {

						ajax_url = jQuery(this).parent().attr('data-url');

						result_placeholder = jQuery(this).parent().next('span.zn_mailchimp_result');

						jQuery.ajax({

							url: ajax_url,

							type: 'POST',

							data: {

								zn_mc_email: jQuery(this).prevAll('.nl-email').val(),

								zn_mailchimp_list: jQuery(this).prev('.nl-lid').val(),

								zn_ajax: '' // Change here with something different

							},

							success: function(data){

								result_placeholder.html(data);

							},

							error: function() {

								result_placeholder.html('ERROR.').css('color', 'red');

							}

						});

						return false;

					});

				"
						);
						
						zn_update_array( $zn_mailchimp );
					}
					
					// Load Portfolio Slider
					if ( isset($options['dynamic_element_type'])){
						if ( $options['dynamic_element_type'] == '_pslider' ) {

							wp_enqueue_style( 'pslider', MASTER_THEME_DIR . '/sliders/caroufredsel/caroufredsel.css', 'zn-style' );
						}

						// Load IOS SLIDER CSS

						if ( $options['dynamic_element_type'] == '_iosSlider' ) {

							wp_enqueue_style( 'ios_slider', MASTER_THEME_DIR . '/sliders/iosslider/style.css', 'style' );
						}

						// Load Map marker

						if ( $options['dynamic_element_type'] == '_static4' || $options['dynamic_element_type'] == '_static4_multiple' ) {

							wp_enqueue_script( 'gmap', get_current_scheme() . '://maps.google.com/maps/api/js?sensor=false', array ( 'jquery' ), '1.3', false );

							wp_enqueue_script( 'gmap_mapmarker', MASTER_THEME_DIR . '/js/mapmarker.jquery.js', array ( 'jquery' ), '1.3', true );
						}
					}

				} // end foreach
				
				// Load ISOTOPE FOR PORTFOLIO SORTABLE
				if ( is_post_type_archive( 'portfolio' ) && $znData['portfolio_style'] == 'portfolio_sortable' ) {
					
					wp_enqueue_script( 'isotope', MASTER_THEME_DIR . '/js/jquery.isotope.min.js', array ( 'jquery' ), '1.4.8', true );
					
					$zn_isotope = array (
						'zn_isotope' =>
							
							"

					;(function($){

						$(function($){

							// settings

							var sortBy = '', 			// SORTING: date / name

								sortAscending = true, 	// SORTING ORDER: true = Ascending / false = Descending

								theFilter = '';	        // DEFAULT FILTERING CATEGORY



							$('#sortBy li a').each(function(index, element) {

								var t = $(this);

								if(t.attr('data-option-value') == sortBy){
									t.addClass('selected');
								}
							});

							$('#sort-direction li a').each(function(index, element) {

								var t = $(this);

								if(t.attr('data-option-value') == sortAscending.toString()){
									t.addClass('selected');
								}
							});

							$('#portfolio-nav li a').each(function(index, element) {

								var t = $(this),

									tpar = t.parent();

								if(t.attr('data-filter') == theFilter) {
									$('#portfolio-nav li a').parent().removeClass('current');
									tpar.addClass('current');
								}

							});



							// don't edit below unless you know what you're doing

							if ($(\"ul#thumbs\").length > 0)

							{

								var container = $(\"ul#thumbs\");

								container.isotope({

									itemSelector : \".item\",

									animationEngine : \"jquery\",

									animationOptions: {

										duration: 250,

										easing: \"easeOutExpo\",

										queue: false

									},

									filter: theFilter,

									sortAscending : sortAscending,

									getSortData : {

										name : function ( elem ) {

											return elem.find(\"span.name\").text();

										},

										date : function ( elem ) {

											return elem.attr(\"data-date\");

										}

									},

								  sortBy: sortBy

								});

							}

						});

					})(jQuery);

				"
					);
					
					zn_update_array( $zn_isotope );
				}
				
				// Load Portfolio Carousel
				if ( is_post_type_archive( 'portfolio' ) && $znData['portfolio_style'] == 'portfolio_carousel' ) {
					
					wp_enqueue_script( 'pslider', MASTER_THEME_DIR . '/sliders/caroufredsel/jquery.carouFredSel-6.0.4-packed.js', array ( 'jquery' ), THEME_VERSION, true );
					
					$zn_pcarousel = array (
						'zn_pcarousel' =>
							
							"

					;(function($) {

						$(function($){

							/* Portfolio Carousel */

							var carousels =	$('.ptcarousel1');

							carousels.each(function(index, element) {

								$(this).carouFredSel({

									responsive: true,

									items: { width: 570 },

									prev	: {	button : $(this).parent().find('a.prev'), key : \"left\" },

									next	: { button : $(this).parent().find('a.next'), key : \"right\" },

									auto: {timeoutDuration: 5000},

									scroll: { fx: \"crossfade\", duration: \"1500\" }

								});

							});

							/* End Portfolio Carousel */

						});

					})(jQuery);

				"
					);
					
					zn_update_array( $zn_pcarousel );
				}
			}
		}
	}
	add_action( 'wp_enqueue_scripts', 'smart_load' );
	
	/**
	 * [kfn_loadStyles Load stylesheets in frontend]
	 *
	 * @return void
	 */
	
	function kfn_zn_add_styles()
	{
		
		if ( ! is_admin() ) {
			
			// CSS3 Panels
			wp_enqueue_style( 'css3_panels', MASTER_THEME_DIR . '/sliders/css3panels/css3panels.css' );
			
			// icarousel
			wp_enqueue_style( 'icarousel_demo', MASTER_THEME_DIR . '/sliders/icarousel/css/demo3.css' );
			wp_enqueue_style( 'icarousel', MASTER_THEME_DIR . '/sliders/icarousel/css/icarousel.css' );
			
			// Shadow
			wp_enqueue_style( 'zn_shadows', MASTER_THEME_DIR . '/css/shadows.css' );
		}
	}
	
	add_action( 'init', 'kfn_zn_add_styles' );
	
	/*--------------------------------------------------------------------------------------------------

Load the javascript files for this theme

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_add_script' ) ) {
		
		function zn_add_script()
		{
			global $znData;
			if ( ! isset( $znData ) || empty( $znData ) ) {
				$znData = get_option( OPTIONS );
			}
			if ( ! is_admin() ) {
				
				wp_enqueue_script( 'jquery' );
				
				// ENQUEUE DEFAULT SCRIPTS
				
				// Adds JavaScript to pages with the comment form to support sites with
				
				// threaded comments (when in use).
				
				if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
					wp_enqueue_script( 'comment-reply' );
				}
				
				wp_enqueue_script( 'bootstrap', MASTER_THEME_DIR . '/js/bootstrap.min.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array (), '2.6.2' );
				wp_enqueue_script( 'jquery-zplugins', MASTER_THEME_DIR . '/js/plugins.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'jquerysuperfish', MASTER_THEME_DIR . '/addons/superfish_responsive/superfish_menu.js', array ( 'jquery' ), '1.4.8', true );
				
				// Menu Follow
				
				if ( $znData['menu_follow'] == 'yes' ) {
					
					$zn_chaser = array (
						'zn_chaser' =>
							
							"

							var doc = $(document),
								win = $(window), chaser, forch,
								forchBottom, visible;

							function shown() { visible = true; }
							function hidden() { visible = false; }

							var chaser = $('#main_menu ul.sf-menu').clone().hide()
								.appendTo(document.body).wrap('<div class=\"chaser\"><div class=\"container\"><div class=\"row\"><div class=\"span12\"></div></div></div></div>');
							if ( $('#content').length > 0 ) {
								forch = $('#content').first();
								forchBottom = forch.offset().top + 2;
								hidden();
								win.on('scroll', function () {
									var top = doc.scrollTop();
									if (!visible && top > forchBottom) {
										chaser.fadeIn(300, shown);
									} else if (visible && top < forchBottom) {
										chaser.fadeOut(200, hidden);
									}
								});
							}

							/* Activate Superfish Menu for Chaser */
							$('.chaser ul.sf-menu').supersubs({ minWidth: 12, maxWidth: 27, extraWidth: 1}).superfish({delay:250, dropShadows:false, autoArrows:true, speed:300});

				"
					);
					
					zn_update_array( $zn_chaser );
				}
				
				if ( $znData['page_preloader'] == 'yes' ) {
					
					$zn_preloader = array (
						'zn_preloader' =>
							
							"

						var pageLoading = $('#page-loading');
						if(pageLoading.length > 0){
							setTimeout(function() {
								pageLoading.fadeOut();
							}, 1000);
						}


				"
					);
					
					zn_update_array( $zn_preloader );
				}
				
				// RESPONSIVE MENU
				
				if (isset($znData['res_menu_style']) && isset($znData['zn_responsive']) &&
					$znData['res_menu_style'] == 'select' && $znData['zn_responsive'] == 'yes' ) {
					
					$zn_smooth_menu = array (
						'zn_smooth_menu' =>

							"
							/* Activate Superfish Menu */

							var sfDelay = 600;
							if($('html').hasClass('isie')){
								sfDelay = 300;
							}

							$('#main_menu > ul').supersubs({

								minWidth:    12,
								maxWidth:    27,
								extraWidth:  1

							}).superfish({

								delay:sfDelay,
								dropShadows:false,
								autoArrows:true,
								speed:300

							}).mobileMenu({

								switchWidth: 960,
								topOptionText: '" . __( "SELECT A PAGE", THEMENAME ) . "',
								indentString: '&nbsp;&nbsp;&nbsp;'
						});
				"
					);
					
					zn_update_array( $zn_smooth_menu );
				}
				
				elseif (isset($znData['res_menu_style']) && $znData['res_menu_style'] == 'smooth' &&
						isset($znData['zn_responsive']) && $znData['zn_responsive'] == 'yes' ) {
					
					$zn_smooth_menu = array (
						'zn_smooth_menu' =>
							
							"

							/* Activate Superfish Menu */

							var sfDelay = 600;

							if($('html').hasClass('isie')){

								sfDelay = 300;

							}

							$('#main_menu > ul')

							.supersubs({

								minWidth:    12,   // minimum width of sub-menus in em units

								maxWidth:    27,   // maximum width of sub-menus in em units

								extraWidth:  1     // extra width can ensure lines don't sometimes turn over

							}).superfish({

								delay:sfDelay,

								dropShadows:false,

								autoArrows:true,

								speed:300

							});



						$(window).resize(function() {

							$('#main_menu > ul').supersubs({

								minWidth:    12,   // minimum width of sub-menus in em units

								maxWidth:    27,   // maximum width of sub-menus in em units

								extraWidth:  1     // extra width can ensure lines don't sometimes turn over

							});

						});


				"
					);
					
					zn_update_array( $zn_smooth_menu );
				}
				
				else {
					
					$zn_smooth_menu = array (
						'zn_smooth_menu' => "
							/* Activate Superfish Menu */
							var sfDelay = 600;
							if($('html').hasClass('isie')){
								sfDelay = 300;
							}
							var sfMainMenu = $('#main_menu > ul');
							if(sfMainMenu && sfMainMenu.length > 0) {
                                sfMainMenu.supersubs({
                                    minWidth:    12,   // minimum width of sub-menus in em units
                                    maxWidth:    27,   // maximum width of sub-menus in em units
                                    extraWidth:  1     // extra width can ensure lines don't sometimes turn over
                                }).superfish({
                                    delay:sfDelay,
                                    dropShadows:false,
                                    autoArrows:true,
                                    speed:300
                                });
                            }"
					);
					zn_update_array( $zn_smooth_menu );
				}
				
				// REGISTER IOS SLIDER
				
				wp_register_script( 'ios_slider_min', MASTER_THEME_DIR . '/sliders/iosslider/jquery.iosslider.min.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'ios_slider_min' );
				wp_register_script( 'ios_slider_kalypso', MASTER_THEME_DIR . '/sliders/iosslider/jquery.iosslider.kalypso.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'ios_slider_kalypso' );
				wp_register_script( 'css3_panels', MASTER_THEME_DIR . '/sliders/css3panels/css3panels.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'css3_panels' );
				wp_register_script( 'icarousel', MASTER_THEME_DIR . '/sliders/icarousel/js/icarousel.packed.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'icarousel' );
				wp_register_script( 'mousewheel', MASTER_THEME_DIR . '/sliders/icarousel/js/jquery.mousewheel.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'mousewheel' );
				wp_register_script( 'raphael_min', MASTER_THEME_DIR . '/sliders/icarousel/js/raphael-min.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'raphael_min' );
				wp_register_script( 'flex_slider', MASTER_THEME_DIR . '/sliders/flex_slider/js/jquery.flexslider-min.js', array ( 'jquery' ), '1.3', true );
				wp_enqueue_script( 'flex_slider' );
				wp_register_script( 'flex_slider_colors', MASTER_THEME_DIR . '/sliders/flex_slider/js/jquery.animate-colors-min.js', array ( 'jquery' ), '1.3', true );

				// Prety photo
				
				wp_enqueue_script( 'pretty_photo', MASTER_THEME_DIR . '/addons/prettyphoto/jquery.prettyPhoto.js', array ( 'jquery' ), '1.3', true );
				
				if ( is_active_widget( false, false, 'tp_widget_recent_tweets', true ) ) {
					
					wp_enqueue_script( 'flex_slider' );
					
					$twitter_fader = array (
						'zn_twitter_fader' =>
							
							"

					jQuery('.twitter-feed').flexslider({

						selector: '.tweets > div',

						controlNav:false,

						directionNav:false

					});

				"
					);
					
					zn_update_array( $twitter_fader );
				}
				
				if ( is_tax( 'project_category' ) && $znData['portfolio_style'] == 'portfolio_sortable' ) {
					
					wp_enqueue_script( 'isotope', MASTER_THEME_DIR . '/js/jquery.isotope.min.js', array ( 'jquery' ), '1.4.8', true );
					
					$zn_isotope = array (
						'zn_isotope' =>
							
							"

					;(function($){

						$(function($){

							// settings

							var sortBy = 'date', 	  // SORTING: date / name

								sortAscending = true, // SORTING ORDER: true = Ascending / false = Descending

								theFilter = '';	      // DEFAULT FILTERING CATEGORY



							$('#sortBy li a').each(function(index, element) {

								var t = $(this);

								if(t.attr('data-option-value') == sortBy){
									t.addClass('selected');
								}
							});

							$('#sort-direction li a').each(function(index, element) {

								var t = $(this);

								if(t.attr('data-option-value') == sortAscending.toString()){
									t.addClass('selected');
								}
							});

							$('#portfolio-nav li a').each(function(index, element) {

								var t = $(this),
									tpar = t.parent();

								if(t.attr('data-filter') == theFilter) {
									$('#portfolio-nav li a').parent().removeClass('current');
									tpar.addClass('current');
								}
							});



							// don't edit below unless you know what you're doing

							if ($(\"ul#thumbs\").length > 0){

								var container = $(\"ul#thumbs\");

								container.isotope({

								  itemSelector : \".item\",

								  animationEngine : \"jquery\",

								  animationOptions: {

									  duration: 250,

									  easing: \"easeOutExpo\",

									  queue: false

								  },

								  filter: theFilter,

								  sortAscending : sortAscending,

								  getSortData : {

									  name : function ( elem ) {

										  return elem.find(\"span.name\").text();

									  },

									  date : function ( elem ) {

										  return elem.attr(\"data-date\");

									  }

								  },

								  sortBy: sortBy

								});

							}

						});

					})(jQuery);

				"
					);
					
					zn_update_array( $zn_isotope );
				}
				
				if ( is_tax( 'project_category' ) && $znData['portfolio_style'] == 'portfolio_carousel' ) {
					
					wp_enqueue_script( 'isotope', MASTER_THEME_DIR . '/js/jquery.isotope.min.js', array ( 'jquery' ), '1.4.8', true );
					
					wp_enqueue_script( 'pslider', MASTER_THEME_DIR . '/sliders/caroufredsel/jquery.carouFredSel-6.0.4-packed.js', array ( 'jquery' ), '6.0.4', true );
					
					$zn_pcarousel = array (
						'zn_pcarousel' =>
							
							"

					;(function($) {


							// ** Portfolio Carousel

							var carousels =	$('.ptcarousel1');

							carousels.each(function(index, element) {

								$(this).carouFredSel({

									responsive: true,

									items: { width: 570 },

									prev : { button : $(this).parent().find('a.prev'), key : \"left\" },

									next : { button : $(this).parent().find('a.next'), key : \"right\" },

									auto: {timeoutDuration: 5000},

									scroll: { fx: \"crossfade\", duration: \"1500\" }

								});

							});

							// *** end Portfolio Carousel


					})(jQuery);

				"
					);
					
					zn_update_array( $zn_pcarousel );
				}
				
				// WOOCOMMERCE CART
				
//				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//
//				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
//
//					if ( isset( $znData['woo_show_cart'] ) && $znData['woo_show_cart'] ) {
//
//						global $woocommerce;
//						$add_to_cart =  __( 'Item Added to cart!', THEMENAME );
//						$zn_woo_cart = array (
//							'zn_woo_cart' =>
//
//								""
//						);
//
//						zn_update_array( $zn_woo_cart );
//					}
//				}
				
				global $pagenow;
				
				// Event Countdown
				
				if ( $znData['cs_enable'] == 'yes' && ! is_user_logged_in() && ! is_admin() && $pagenow != 'wp-login.php' ) {
					
					wp_enqueue_script( 'zn_event_countdown', MASTER_THEME_DIR . '/js/jquery.countdown.js', array ( 'jquery' ), '1.3', true );
					
					$zn_event_countdown_coming_soon = array (
						'zn_event_countdown_coming_soon' =>
							
							"

					;(function($) {

						var counter = {

							init: function (d)

							{

								jQuery('#Counter').countdown({

									until: new Date(d),

									layout: counter.layout(),

									labels: ['" . __( 'years', THEMENAME ) . "', '" . __( 'months', THEMENAME ) . "', '" . __( 'weeks', THEMENAME ) . "', '" . __( 'days', THEMENAME ) . "', '" . __( 'hours', THEMENAME ) . "', '" . __( 'min', THEMENAME ) . "', '" . __( 'sec', THEMENAME ) . "'],

									labels1: ['" . __( 'year', THEMENAME ) . "', '" . __( 'month', THEMENAME ) . "', '" . __( 'week', THEMENAME ) . "', '" . __( 'day', THEMENAME ) . "', '" . __( 'hour', THEMENAME ) . "', '" . __( 'min', THEMENAME ) . "', '" . __( 'sec', THEMENAME ) . "']

								});

							},

							layout: function ()

							{

								return '<li>{dn}<span>{dl}</span></li>' +

										'<li>{hnn}<span>{hl}</span></li>' +

										'<li>{mnn}<span>{ml}</span></li>' +

										'<li>{snn}<span>{sl}</span></li>';

							}

						}

						// initialize the counter

						jQuery(document).ready(function() {

							counter.init(\"" . $znData['cs_date']['date'] . " " . $znData['cs_date']['time'] . "\");

						});

					})(jQuery);

				"
					);
					
					zn_update_array( $zn_event_countdown_coming_soon );
					
					$zn_mailchimp = array (
						'zn_mailchimp' =>
							
							"// PREPARE THE NEWSLETTER AND SEND DATA TO MAILCHIMP

					jQuery('.nl-submit').click(function()

					{

						ajax_url = jQuery(this).parent().attr('data-url');

						result_placeholder = jQuery(this).parent().next('span.zn_mailchimp_result');

						jQuery.ajax({

							url: ajax_url,

							type: 'POST',

							data: {

								zn_mc_email: jQuery(this).prevAll('.nl-email').val(),

								zn_mailchimp_list: jQuery(this).prev('.nl-lid').val(),

								zn_ajax: '' // Change here with something different

							},

							success: function(data){

								result_placeholder.html(data);
							},

							error: function() {

								result_placeholder.html('ERROR.').css('color', 'red');

							}

						});

						return false;

					});

				"
					);
					
					zn_update_array( $zn_mailchimp );
				}
				
				// Load the theme scripts
				
				wp_enqueue_script( 'zn-script', MASTER_THEME_DIR . '/js/znscript.js', array ( 'jquery' ), '1.0.0', true );
				wp_localize_script( 'zn-script', 'zn_do_login', array (
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'add_to_cart_text' => __( 'Item Added to cart!', THEMENAME )
				) );
			}
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'zn_add_script' );
	
	/*--------------------------------------------------------------------------------------------------

Update inline scripts

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_update_array' ) ) {
		
		function zn_update_array( $script )
		{
			
			$zn_array = wp_cache_get( 'zn_array' );
			
			$zn_array[ key( $script ) ] = $script[ key( $script ) ];
			
			wp_cache_set( 'zn_array', $zn_array );
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Load the inline JS

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_load_inline_js' ) ) {
		
		function zn_load_inline_js( $script )
		{
			
			$zn_array = wp_cache_get( 'zn_array' );
			
			if ( is_array( $zn_array ) && ! empty( $zn_array ) ) {
				
				$script = '<script type="text/javascript">';
				$script .= '(function ($){';
				foreach ( $zn_array as $tt ) {
					$script .= $tt."\n";
				}
				$script .= '})(jQuery)';
				$script .= '</script>';
				
				echo $script;
			}
		}
	}
	
	add_action( 'wp_footer', 'zn_load_inline_js', 100 );
	
	/*--------------------------------------------------------------------------------------------------

Add Google analytics to page

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'wp_footer', 'add_googleanalytics' );
	
	if ( ! function_exists( 'add_googleanalytics' ) ) {
		
		function add_googleanalytics()
		
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( isset( $znData['google_analytics'] ) && ! empty( $znData['google_analytics'] ) ) {
				
				echo stripslashes( $znData['google_analytics'] );
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Register the menus : Top menu, default menu , footer menu

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'init', 'zn_register_menu' );
	
	if ( ! function_exists( 'zn_register_menu' ) ) {
		
		function zn_register_menu()
		
		{
			
			if ( function_exists( 'wp_nav_menu' ) ) {
				
				add_theme_support( 'nav-menus' );
				
				register_nav_menus( array ( 'main_navigation' => esc_html__( 'Main Navigation', THEMENAME ) ) );
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Show the menu by location

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_show_nav' ) ) {
		
		function zn_show_nav( $location )
		{
			$menu_class = '';
			if ( $location == 'header_navigation' ) {
				
				$menu_class = 'topnav navRight ';
			}
			
			elseif ( $location == 'main_navigation' ) {
				
				$menu_class = 'sf-menu nav clearfix';
			}
			
			$menu = cache_wp_nav_menu(
				
				$location,
				
				array (
					'theme_location' => $location,
					'link_before'    => '',
					'link_after'     => '',
					'container'      => '',
					'menu_class'     => $menu_class,
					'fallback_cb'    => '',
					'echo'           => false
				)
			
			);
			
			echo $menu;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

MENU CACHING FUNCTION - NEED OPTION IN ADMIN FOR THIS

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'cache_wp_nav_menu' ) ) {
		
		function cache_wp_nav_menu( $location = false, $args = array (), $prime_cache = false, $skip_cache = false )
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( empty( $znData['cache_menu'] ) || ( ! empty ( $znData['cache_menu'] ) && $znData['cache_menu'] == 'no' ) ) {
				
				if ( ! is_array( $args ) ) {
					
					// kos - previously declared default value of $args was "false"
					
					// because of that, we need to check now if the $args is provided in the old boolean form...
					
					$args = array ();
				}
				
				$args['echo'] = true;
				
				return wp_nav_menu( $args );
			}
			
			// kos - as mentioned above, the previously default value of $args was boolean, but still we access it as if
			
			// it were an array...so we need to check whether or not this argument is an array before continuing
			
			if ( ! is_array( $args ) ) {
				
				$args = array ();
			}
			
			// we also need to check whether or not there is the "echo" entry in it
			
			if ( ! isset( $args['echo'] ) ) {
				
				$args['echo'] = false;
			}
			
			/* Sanitize function arguments */
			
			$echo = (bool) $args['echo'];
			
			$args['echo'] = false;
			
			$queried_object = (int) get_queried_object_id();
			
			if ( ! $queried_object ) {
				
				$queried_object = 0;
			}
			
			$cache_key = md5( serialize( $args ) . '-' . $queried_object . '-' . $location );
			
			$saved_menu = (array) get_transient( 'zn_menu_transient' );
			
			$menu = isset( $saved_menu[ $cache_key ] ) ? true : false;
			
			if ( $skip_cache === true || false === $menu ) {
				
				$saved_menu[ $cache_key ] = wp_nav_menu( $args );
				
				set_transient( 'zn_menu_transient', $saved_menu, 86400 );
			}
			
			if ( $echo ) {
				echo $saved_menu[ $cache_key ];
			}
			
			else {
				return $saved_menu[ $cache_key ];
			}
		}
	}
	
	function hh_update_nav_menu_objects( $menu_id = null, $menu_data = null )
	{
		
		delete_transient( 'zn_menu_transient' );
	}
	
	add_action( 'wp_update_nav_menu', 'hh_update_nav_menu_objects' );
	
	/*--------------------------------------------------------------------------------------------------

Add specific css class to active item

--------------------------------------------------------------------------------------------------*/
	
	add_filter( 'nav_menu_css_class', 'zn_active_item_classes', 10, 2 );
	
	if ( ! function_exists( 'zn_active_item_classes' ) ) {
		
		function zn_active_item_classes( $classes = array (), $menu_item = false )
		{
			
			if ( in_array( 'current-menu-item', $menu_item->classes ) || in_array( 'current-menu-ancestor', $menu_item->classes ) ) {
				
				$classes[] = 'active';
			}
			
			return $classes;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Load video iframe from link

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'get_video_from_link' ) ) {
		
		function get_video_from_link( $string, $css = null, $width = '425px', $height = '239px' )
		{
			
			// Save old string in case no video is provided
			
			$old_string = $string;
			
			$video_url = parse_url( $string );
			
			if ( $video_url['host'] == 'www.youtube.com' || $video_url['host'] == 'youtube.com' ) {
				
				preg_match( '#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $string, $matches );
				
				$string = '<iframe class="' . $css . '" width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $matches[0] . '?iv_load_policy=3&enablejsapi=0&amp;wmode=transparent&amp;modestbranding=1&amp;rel=0&amp;showinfo=0&amp;feature=player_embedded" frameborder="0" allowfullscreen></iframe>';
			}
			
			elseif ( $video_url['host'] == 'www.dailymotion.com' ) {
				
				$id = strtok( basename( $old_string ), '_' );
				
				$string = '<iframe frameborder="0" width="' . $width . '" height="' . $height . '" src="//www.dailymotion.com/embed/video/' . $id . '"></iframe>';
			}
			
			else {
				
				$string = preg_replace(
					
					array (
						
						'#http://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i',
						'#https://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i'
					
					)
					
					, '<iframe class="youtube-player ' . $css . '" type="text/html" src="//player.vimeo.com/video/$2" width="' . $width . '" height="' . $height . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>', $string );
			}
			
			// If no video link was provided return the full link
			
			if ( $string != $old_string ) {
				
				return $string;
			}
			
			return null;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Comments display function

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_comment' ) ) {
		
		function zn_comment( $comment, $args, $depth )
		{
			
			$GLOBALS['comment'] = $comment; ?>

			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				
				<div id="comment-<?php comment_ID(); ?>">
					
					<div class="comment-author vcard">
						
						<?php echo get_avatar( $comment, $size = '50' ); ?>
						
						<?php printf( __( '<cite class="fn">%s</cite>', THEMENAME ), get_comment_author_link() ) ?> <?php echo __( "says :", THEMENAME ); ?> <?php comment_reply_link( array_merge( $args, array (
							'depth'     => $depth,
							'max_depth' => $args['max_depth']
						) ) ) ?>
					
					</div>
					
					
					
					<?php if ( $comment->comment_approved == '0' ) : ?>
						
						<em><?php _e( 'Your comment is awaiting moderation.', THEMENAME ) ?></em>
						
						<br/>
					
					<?php endif; ?>
					
					
					
					<div class="comment-meta commentmetadata"><a
							
							href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
							
							<?php printf( __( '%1$s at %2$s', THEMENAME ), get_comment_date(), get_comment_time() ) ?></a><?php edit_comment_link( __( '(Edit)', THEMENAME ), '  ', '' ) ?>
					
					</div>
					
					
					
					<?php comment_text() ?>
					
					<div class="zn-separator sep_normal zn-margin-d"></div>
					
					<?php /* if ($args['max_depth'] != $depth) { ?>

		<?php //=> ??? } */ ?>
				
				</div>
			
			</li>
		
		<?php
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Sidebar Functions

--------------------------------------------------------------------------------------------------*/
	
	if ( function_exists( 'register_sidebar' ) ) {
		
		register_sidebar( array (
			
			'name'          => 'Default Sidebar',
			'id'            => 'defaultsidebar',
			'description'   => esc_html__( 'This is the default sidebar. You can choose from the theme\'s options page where the widgets from this sidebar will be shown.', THEMENAME ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle title">',
			'after_title'   => '</h3>'
		
		) );
	}
	
	if ( function_exists( 'register_sidebar' ) ) {
		
		register_sidebar( array (
			
			'name'          => 'Hidden Panel Sidebar',
			'id'            => 'hiddenpannelsidebar',
			'description'   => esc_html__( 'This is the sidebar for the hidden panel in the header. You can choose from the theme\'s options page where the widgets from this sidebar will be shown.', THEMENAME ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle title">',
			'after_title'   => '</h3>'
		
		) );
	}
	
	/*--------------------------------------------------------------------------------------------------

Hidden panel Sidebar

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_hidden_pannel' ) ) {
		
		function zn_hidden_pannel()
		{
			if ( is_active_sidebar( 'hiddenpannelsidebar' ) ) {
				global $znData;
				$bgColor = ( isset( $znData['hidden_panel_bg'] ) ? $znData['hidden_panel_bg'] : '#fff' );
				$fgColor = ( isset( $znData['hidden_panel_fg'] ) ? $znData['hidden_panel_fg'] : '#000000' );
				?>
				<div class="support_panel" id="sliding_panel" style="background: <?php echo $bgColor; ?>;">
					<style type="text/css">
						#sliding_panel * {
							color: <?php echo $fgColor;?>;
						}
					</style>
					<div class="container">
						<?php if ( ! dynamic_sidebar( 'hiddenpannelsidebar' ) ) : endif; ?>
					</div>
				</div><!-- end support panel -->
			<?php
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Footer sidebars

--------------------------------------------------------------------------------------------------*/
	
	if ( isset ( $znData['footer_row1_widget_positions'] ) && ! empty ( $znData['footer_row1_widget_positions'] ) ) {
		
		$f_row1 = key( json_decode( stripslashes( $znData['footer_row1_widget_positions'] ) ) );
		
		if ( function_exists( 'register_sidebars' ) ) {
			
			if ( $f_row1 > 1 ) {
				
				$args = array (
					
					'name'          => 'Footer row 1 - widget %d',
					'id'            => "znfooter",
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle title m_title">',
					'after_title'   => '</h3>'
				);
				
				register_sidebars( $f_row1, $args );
			}
			else {
				
				$args = array (
					
					'name'          => 'Footer row 1 - widget 1',
					'id'            => "znfooter",
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle title m_title">',
					'after_title'   => '</h3>'
				);
				
				register_sidebars( 1, $args );
			}
		}
	}
	
	if ( isset ( $znData['footer_row2_widget_positions'] ) && ! empty ( $znData['footer_row2_widget_positions'] ) ) {
		
		$f_row1 = key( json_decode( stripslashes( $znData['footer_row2_widget_positions'] ) ) );
		
		if ( function_exists( 'register_sidebars' ) ) {
			
			if ( $f_row1 > 1 ) {
				
				$args = array (
					
					'name'          => 'Footer row 2 - widget %d',
					'id'            => "znfooter",
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle title m_title">',
					'after_title'   => '</h3>'
				);
				
				register_sidebars( $f_row1, $args );
			}
			else {
				
				$args = array (
					
					'name'          => 'Footer row 2 - widget 1',
					'id'            => "znfooter",
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle title m_title">',
					'after_title'   => '</h3>'
				);
				
				register_sidebars( 1, $args );
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Dynamic Sidebars Function

--------------------------------------------------------------------------------------------------*/
	
	if ( isset ( $znData['sidebar_generator'] ) && is_array( $znData['sidebar_generator'] ) ) {
		
		$sidebars = $znData['sidebar_generator'];
		
		foreach ( $znData['sidebar_generator'] as $sidebar ) {
			
			if ( $sidebar['sidebar_name'] ) {
				
				register_sidebar( array (
					
					'name'          => $sidebar['sidebar_name'],
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle title">',
					'after_title'   => '</h3>'
				
				) );
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Modify the search form

--------------------------------------------------------------------------------------------------*/
	
	add_filter( 'get_search_form', 'zn_search_form' );
	
	if ( ! function_exists( 'zn_search_form' ) ) {
		
		function zn_search_form( $form )
		{
			$form = '<div class="search">';
			
			$form .= '	<form id="searchform" action="' . home_url( '/' ) . '" method="get">';
			
			$form .= '		<input id="s" name="s" maxlength="20" class="inputbox" type="text" size="20" value="' . __( 'SEARCH ...', THEMENAME ) . '" onblur="if (this.value==\'\') this.value=\'' . __( 'SEARCH ...', THEMENAME ) . '\';" onfocus="if (this.value==\'' . __( 'SEARCH ...', THEMENAME ) . '\') this.value=\'\';" />';
			
			$form .= '		<input type="submit" id="searchsubmit" value="go" class="icon-search"/>';
			
			$form .= '	</form>';
			
			$form .= '</div>';
			
			return $form;
		}
	}
	
	// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
	
	add_filter( 'add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
	
	if ( ! function_exists( 'woocommerce_header_add_to_cart_fragment' ) ) {
		
		function woocommerce_header_add_to_cart_fragment( $fragments )
		{
			
			global $woocommerce;
			
			ob_start();
			
			?>
			
			<span
				
				class="cart_details"><?php echo sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, THEMENAME ), $woocommerce->cart->cart_contents_count ); ?> <?php _e( "Total of", THEMENAME ); ?> <?php echo $woocommerce->cart->get_cart_total(); ?>
				
				<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"
				
				   title="<?php _e( 'View your shopping cart', THEMENAME ); ?>"
				
				   class="checkout"><?php _e( "Checkout", THEMENAME ); ?> <span
						class="icon-chevron-right"></span></a></span>
			
			<?php
			
			$fragments['span.cart_details'] = ob_get_clean();
			
			return $fragments;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

GET current SCHEME

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'get_current_scheme' ) ) {
		
		function get_current_scheme()
		{
			
			$scheme = 'http';
			
			if ( isset( $_SERVER["HTTPS"] ) && ( $_SERVER["HTTPS"] == "on" ) ) {
				
				$scheme .= "s";
			}
			
			return $scheme;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

GET current page URL

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'current_page_url' ) ) {
		
		function current_page_url()
		
		{
			
			$pageURL = get_current_scheme() . '://';
			
			if ( isset( $_SERVER["SERVER_PORT"] ) && ( (int) $_SERVER["SERVER_PORT"] != 80 ) ) {
				
				$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
			}
			
			else {
				
				$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			}
			
			return $pageURL;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Remove rel attribute from the category list for HTML validation purposes

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'remove_category_rel' ) ) {
		
		function remove_category_rel( $result )
		{
			
			$result = str_replace( 'rel="category tag"', '', $result );
			
			$result = str_replace( 'rel="category"', '', $result );
			
			return $result;
		}
	}
	
	add_filter( 'the_category', 'remove_category_rel' );
	
	add_filter( 'wp_list_categories', 'remove_category_rel' );
	
	/*--------------------------------------------------------------------------------------------------

Blog Excerpt Functions

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'custom_excerpt_length' ) ) {
		
		function custom_excerpt_length( $length )
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			$excerpt = 55;
			
			if ( ! empty ( $znData['blog_excerpt_limit'] ) ) {
				
				$excerpt = $znData['blog_excerpt_limit'];
			}
			
			return $excerpt;
		}
	}
	
	if ( ! function_exists( 'clear_excerpt_more' ) ) {
		
		function clear_excerpt_more( $more )
		{
			
			return '';
		}
	}
	
	add_filter( 'excerpt_more', 'clear_excerpt_more' );
	
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	
	if ( ! function_exists( 'zn_limit_content' ) ) {
		
		function zn_limit_content( $string, $word_limit )
		{
			
			$words = explode( " ", $string );
			
			return implode( " ", array_splice( $words, 0, $word_limit ) );
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Pagination Functions

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_pagination' ) ) {
		
		function zn_pagination( $pages = '', $range = 2 )
		{
			
			$showitems = ( $range * 2 ) + 1;
			
			global $paged;
			
			if ( empty( $paged ) ) {
				$paged = 1;
			}
			
			if ( $pages == '' ) {
				
				global $wp_query;
				
				$pages = $wp_query->max_num_pages;
				
				if ( ! $pages ) {
					
					$pages = 1;
				}
			}
			
			if ( 1 != $pages ) {
				
				//__( 'Published in', THEMENAME )
				
				echo "<div class='pagination'>";
				
				echo '<ul>';
				
				if ( 1 == $paged ) {
					
					echo '<li class="pagination-start"><span class="pagenav">' . __( 'Start', THEMENAME ) . '</span></li>';
					
					echo '<li class="pagination-prev"><span class="pagenav">' . __( 'Prev', THEMENAME ) . '</span></li>';
				}
				else {
					
					echo '<li class="pagination-start"><a href="' . get_pagenum_link( 1 ) . '">' . __( 'Start', THEMENAME ) . '</a></li>';
					
					echo '<li class="pagination-prev"><a href="' . get_pagenum_link( $paged - 1 ) . '">' . __( 'Prev', THEMENAME ) . '</a></li>';
				}
				
				for ( $i = 1; $i <= $pages; $i ++ ) {
					
					if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
						
						//echo ($paged == $i)? "<span class='current zn_default_color_active'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive zn_default_color' >".$i."</a>";
						
						echo ( $paged == $i ) ? '<li><span class="pagenav">' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
					}
				}
				
				if ( $paged < $pages ) {
					
					echo '<li class="pagination-next"><a href="' . get_pagenum_link( $paged + 1 ) . '">' . __( 'Next', THEMENAME ) . '</a></li>';
					
					echo '<li class="pagination-end"><a href="' . get_pagenum_link( $pages ) . '">' . __( 'End', THEMENAME ) . '</a></li>';
				}
				else {
					
					echo '<li class="pagination-next"><span class="pagenav">' . __( 'Next', THEMENAME ) . '</span></li>';
					
					echo '<li class="pagination-end"><span class="pagenav">' . __( 'End', THEMENAME ) . '</span></li>';
				}
				
				echo '</ul>';
				
				echo '<div class="clear"></div>';
				
				echo '' . __( 'Page', THEMENAME ) . ' ' . $paged . ' ' . __( 'of', THEMENAME ) . ' ' . $pages . '';
				
				echo "</div>\n";
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Portfolio Post Type

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'init', 'zn_portfolio_post_type' );
	
	if ( ! function_exists( 'zn_portfolio_post_type' ) ) {
		
		function zn_portfolio_post_type()
		{
			$permalinks = get_option( 'zn_permalinks' );
			
			$slug = true;
			
			if ( ! empty( $permalinks['port_item'] ) ) {
				
				$slug = array ( 'slug' => $permalinks['port_item'] );
			}
			
			$labels = array (
				
				'name'               => __( 'Portfolios', THEMENAME ),
				'singular_name'      => __( 'Portfolio Item', THEMENAME ),
				'add_new'            => __( 'Add New Portfolio Item', THEMENAME ),
				'all_items'          => __( 'All Portfolio Items', THEMENAME ),
				'add_new_item'       => __( 'Add New Portfolio', THEMENAME ),
				'edit_item'          => __( 'Edit Portfolio Item', THEMENAME ),
				'new_item'           => __( 'New Portfolio Item', THEMENAME ),
				'view_item'          => __( 'View Portfolio Item', THEMENAME ),
				'search_items'       => __( 'Search Portfolio Items', THEMENAME ),
				'not_found'          => __( 'No Portfolio Items found', THEMENAME ),
				'not_found_in_trash' => __( 'No Portfolio Items found in trash', THEMENAME ),
				'parent_item_colon'  => __( 'Parent Portfolio:', THEMENAME ),
				'menu_name'          => __( 'Portfolio Items', THEMENAME ),
			
			);
			
			$args = array (
				
				'labels'              => $labels,
				'description'         => "",
				'public'              => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_nav_menus'   => true,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 100,
				'menu_icon'           => ADMIN_IMAGES_DIR . '/portfolio.png',
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array ( 'title', 'editor', 'excerpt' ),
				'has_archive'         => true,
				'rewrite'             => $slug,
				'query_var'           => true,
				'can_export'          => true
			
			);
			
			register_post_type( 'portfolio', $args );
		}
	}
	
	// Flush Rewrite rules
	
	if ( ! function_exists( 'zn_rewrite_flush' ) ) {
		
		function zn_rewrite_flush()
		{
			flush_rewrite_rules();
		}
	}
	
	add_action( 'after_switch_theme', 'zn_rewrite_flush' );
	
	/*--------------------------------------------------------------------------------------------------

Portfolio Post Taxonomy

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'init', 'zn_portfolio_category', 0 );
	
	if ( ! function_exists( 'zn_portfolio_category' ) ) {
		
		function zn_portfolio_category()
		
		{
			
			$slug = true;
			
			$permalinks = get_option( 'zn_permalinks' );
			
			if ( ! empty( $permalinks['port_tax'] ) ) {
				
				$slug = array ( 'slug' => $permalinks['port_tax'] );
			}
			
			// Add new taxonomy, make it hierarchical (like categories)
			
			$labels = array (
				
				'name'              => __( 'Categories', THEMENAME ),
				'singular_name'     => __( 'Category', THEMENAME ),
				'search_items'      => __( 'Search Categories', THEMENAME ),
				'all_items'         => __( 'All Categories', THEMENAME ),
				'parent_item'       => __( 'Parent Category', THEMENAME ),
				'parent_item_colon' => __( 'Parent Category:', THEMENAME ),
				'edit_item'         => __( 'Edit Category', THEMENAME ),
				'update_item'       => __( 'Update Category', THEMENAME ),
				'add_new_item'      => __( 'Add New Category', THEMENAME ),
				'new_item_name'     => __( 'New Category Name', THEMENAME ),
				'menu_name'         => __( 'Portfolio categories', THEMENAME ),
			
			);
			
			register_taxonomy( 'project_category', 'portfolio', array (
				
				'hierarchical' => true,
				'labels'       => $labels,
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => $slug,
			
			) );
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Breadcrumbs

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_breadcrumbs' ) ) {
		
		function zn_breadcrumbs()
		{
			global $post, $znData, $wp_query;
			
			$delimiter   = '&raquo;';
			$home        = __( 'Home', THEMENAME );
			$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
			
			$before = '<span class="current">'; // tag before the current crumb
			$after  = '</span>'; // tag after the current crumb
			
			$prepend = '';
			
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				
				$permalinks = get_option( 'woocommerce_permalinks' );
				
				$shop_page_id = wc_get_page_id( 'shop' );
				
				$shop_page = get_post( $shop_page_id );
				
				if ( $shop_page_id && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) && get_option( 'page_on_front' ) !== $shop_page_id ) {
					$prepend = '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_permalink( wc_get_page_id( 'shop' ) ) . '">' . get_the_title( wc_get_page_id( 'shop' ) ) . '</a></li>';
				}
			}
			
			$homeLink = home_url();
			
			if ( is_front_page() ) {
				
				echo '<ul xmlns:v="' . get_current_scheme() . '://rdf.data-vocabulary.org/#" class="breadcrumbs fixclear"><li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . $homeLink . '">' . $home . '</a></li></ul>';
			}
			
			elseif ( is_home() ) {
				
				if ( function_exists( 'icl_t' ) ) {
					
					$title = icl_t( THEMENAME, 'Archive Page Title', do_shortcode( stripslashes( $znData['archive_page_title'] ) ) );
				}
				
				else {
					
					$title = do_shortcode( stripslashes( $znData['archive_page_title'] ) );
				}
				
				echo '<ul xmlns:v="' . get_current_scheme() . '://rdf.data-vocabulary.org/#" class="breadcrumbs fixclear"><li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . $homeLink . '">' . $home . '</a></li><li>' . $title . '</li></ul>';
			}
			
			else {
				
				echo '<ul xmlns:v="' . get_current_scheme() . '://rdf.data-vocabulary.org/#" class="breadcrumbs fixclear"><li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . $homeLink . '">' . $home . '</a></li>';
				
				if ( is_category() ) {
					
					$thisCat = get_category( get_query_var( 'cat' ), false );
					
					if ( $thisCat->parent != 0 ) {
						$cats = get_category_parents( $thisCat->parent, true, '|zn_preg|' );
					}
					else $cats = get_category_parents( $thisCat, true, '|zn_preg|' );

					if(! empty($cats) && ! is_wp_error($cats)) {
						$cats = explode( '|zn_preg|', $cats );
						foreach ( $cats as $s_cat ) {
							if ( ! empty ( $s_cat ) ) {
								$s_cat = str_replace( '<a', '<a rel="v:url" property="v:title" ', $s_cat );
								echo '<li typeof="v:Breadcrumb">' . $s_cat . '</li>';
							}
						}
					}
					
					echo '<li>' . __( "Archive from category ", THEMENAME ) . '"' . single_cat_title( '', false ) . '"</li>';
				}
				
				elseif ( is_tax( 'product_cat' ) ) {
					
					echo $prepend;
					
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					
					$parents = array ();
					
					$parent = $term->parent;
					
					while ( $parent ) {
						
						$parents[] = $parent;
						
						$new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
						
						$parent = $new_parent->parent;
					}
					
					if ( ! empty( $parents ) ) {
						
						$parents = array_reverse( $parents );
						
						foreach ( $parents as $parent ) {
							
							$item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
							
							echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title"  href="' .
							
								 get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a></li>';
						}
					}
					
					$queried_object = $wp_query->get_queried_object();
					
					echo '<li>' . $queried_object->name . '</li>';
				}
				
				elseif ( is_tax( 'project_category' ) || is_post_type_archive( 'portfolio' ) ) {
					
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					
					if ( ! empty( $term->parent ) ) {
						
						$parents = array ();
						
						$parent = $term->parent;
						
						while ( $parent ) {
							
							$parents[] = $parent;
							
							$new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
							
							$parent = $new_parent->parent;
						}
						
						if ( ! empty( $parents ) ) {
							
							$parents = array_reverse( $parents );
							
							foreach ( $parents as $parent ) {
								
								$item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
								
								echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title"  href="' .
								
									 get_term_link( $item->slug, 'project_category' ) . '">' . $item->name . '</a></li>';
							}
						}
					}
					
					$queried_object = $wp_query->get_queried_object();

					$menuItem = $queried_object->name;
					//@wpk: #68 - Replace "portfolio" with the one set by the user in the permalinks page
					if ( strcasecmp( 'portfolio', $queried_object->name ) == 0 ) {
						$menuItem = $queried_object->rewrite['slug'];
					}

					echo '<li>' . $menuItem . '</li>';
				}
				
				elseif ( is_tax( 'documentation_category' ) ) {
					
					$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
					
					$parents = array ();
					
					$parent = $term->parent;
					
					while ( $parent ) {
						
						$parents[] = $parent;
						
						$new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
						
						$parent = $new_parent->parent;
					}
					
					if ( ! empty( $parents ) ) {
						
						$parents = array_reverse( $parents );
						
						foreach ( $parents as $parent ) {
							
							$item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ) );
							
							echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title"  href="' .
							
								 get_term_link( $item->slug, 'documentation_category' ) . '">' . $item->name . '</a></li>';
						}
					}
					
					$queried_object = $wp_query->get_queried_object();
					
					echo '<li>' . $queried_object->name . '</li>';
				}
				
				elseif ( is_search() ) {
					
					echo '<li>' . __( "Search results for ", THEMENAME ) . '"' . get_search_query() . '"</li>';
				}
				
				elseif ( is_day() ) {
					
					echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title"  href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
					
					echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title"  href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li>';
					
					echo '<li>' . get_the_time( 'd' ) . '</li>';
				}
				
				elseif ( is_month() ) {
					
					echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title"  href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
					
					echo '<li>' . get_the_time( 'F' ) . '</li>';
				}
				
				elseif ( is_year() ) {
					
					echo '<li>' . get_the_time( 'Y' ) . '</li>';
				}
				
				elseif ( is_post_type_archive( 'product' ) && get_option( 'page_on_front' ) !== wc_get_page_id( 'shop' ) ) {
					
					$_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : ucwords( get_option( 'woocommerce_shop_slug' ) );
					
					if ( is_search() ) {
						
						echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_post_type_archive_link( 'product' ) . '">' . $_name . '</a></li><li>' . __( 'Search results for &ldquo;', THEMENAME ) . get_search_query() . '</li>';
					}
					
					elseif ( is_paged() ) {
						
						echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_post_type_archive_link( 'product' ) . '">' . $_name . '</a></li>';
					}
					
					else {
						
						echo '<li>' . $_name . '</li>';
					}
				}
				
				elseif ( is_single() && ! is_attachment() ) {
					
					if ( get_post_type() == 'portfolio' ) {
						
						// Show category name
						
						$cats = get_the_term_list( $post->ID, 'project_category', ' ', '|zn_preg|', '|zn_preg|' );
						
						$cats = explode( '|zn_preg|', $cats );
						
						if ( ! empty ( $cats['0'] ) ) {
							
							$s_cat = str_replace( '<a', '<a rel="v:url" property="v:title" ', $cats['0'] );
							
							echo '<li typeof="v:Breadcrumb">' . $s_cat . '</li>';
						}
						
						// Show post name
						
						echo '<li>' . get_the_title() . '</li>';
					}
					
					elseif ( get_post_type() == 'product' ) {
						
						echo $prepend;
						
						if ( $terms = wp_get_object_terms( $post->ID, 'product_cat' ) ) {
							
							$term = current( $terms );
							
							$parents = array ();
							
							$parent = $term->parent;
							
							while ( $parent ) {
								
								$parents[] = $parent;
								
								$new_parent = get_term_by( 'id', $parent, 'product_cat' );
								
								$parent = $new_parent->parent;
							}
							
							if ( ! empty( $parents ) ) {
								
								$parents = array_reverse( $parents );
								
								foreach ( $parents as $parent ) {
									
									$item = get_term_by( 'id', $parent, 'product_cat' );
									
									echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a></li>';
								}
							}
							
							echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_term_link( $term->slug, 'product_cat' ) . '">' . $term->name . '</a></li>';
						}
						
						echo '<li>' . get_the_title() . '</li>';
					}
					
					elseif ( get_post_type() != 'post' ) {
						
						$post_type = get_post_type_object( get_post_type() );
						
						$slug = $post_type->rewrite;
						
						//print_r($slug);
						
						echo '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
						
						if ( $showCurrent == 1 ) {
							echo '<li>' . get_the_title() . '</li>';
						}
					}
					
					else {
						
						// Show category name
						
						$cat = get_the_category();
						
						$cat = $cat[0];
						
						$cats = get_category_parents( $cat, true, '|zn_preg|' );
						if(! empty($cats) && ! is_wp_error($cats)) {
							$cats = explode( '|zn_preg|', $cats );
							foreach ( $cats as $s_cat ) {
								if ( ! empty ( $s_cat ) ) {
									$s_cat = str_replace( '<a', '<a rel="v:url" property="v:title" ', $s_cat );
									echo '<li typeof="v:Breadcrumb">' . $s_cat . '</li>';
								}
							}
						}
						// Show post name
						
						echo '<li>' . get_the_title() . '</li>';
					}
				}
				
				elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
					
					$post_type = get_post_type_object( get_post_type() );
					
					if ( ! empty ( $post_type->labels->singular_name ) ) {
						
						echo '<li>' . $post_type->labels->singular_name . '</li>';
					}
				}
				elseif ( is_attachment() )
				{
					$parent = get_post( $post->post_parent );
					$cat = get_the_category( $parent->ID );
					if ( ! empty( $cat ) ) {
						$cat = $cat[0];
						$cats = get_category_parents( $cat, true, ' ' . $delimiter . ' ' );
						if(! empty($cats) && ! is_wp_error($cats)) {
							echo $cats;
						}
						echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>';
						echo '<li>' . get_the_title() . '</li>';
					}
					else {
						echo '<li>' . get_the_title() . '</li>';
					}
				}
				elseif ( is_page() && ! is_subpage() ) {
					if ( $showCurrent == 1 ) {
						echo '<li>' . get_the_title() . '</li>';
					}
				}
				elseif ( is_page() && is_subpage() ) {
					
					$parent_id = $post->post_parent;
					
					$breadcrumbs = array ();
					
					while ( $parent_id ) {
						
						$page = get_post( $parent_id );
						
						$breadcrumbs[] = '<li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
						
						$parent_id = $page->post_parent;
					}
					
					$breadcrumbs = array_reverse( $breadcrumbs );
					
					for ( $i = 0; $i < count( $breadcrumbs ); $i ++ ) {
						echo $breadcrumbs[ $i ];
					}
					
					if ( $showCurrent == 1 ) {
						echo '<li>' . get_the_title() . '</li>';
					}
				}
				elseif ( is_tag() ) {
					echo '<li>' . __( "Posts tagged ", THEMENAME ) . '"' . single_tag_title( '', false ) . '"</li>';
				}
				elseif ( is_author() ) {
					global $author;
					$userdata = get_userdata( $author );
					echo '<li>' . __( "Articles posted by ", THEMENAME ) . ( isset( $userdata->display_name ) ? $userdata->display_name : '' ) . '</li>';
				}
				elseif ( is_404() ) {
					echo '<li>' . __( "Error 404 ", THEMENAME ) . '</li>';
				}
				if ( get_query_var( 'paged' ) ) {
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
						echo ' (';
					}
					echo '<li>' . __( 'Page', THEMENAME ) . ' ' . get_query_var( 'paged' ) . '</li>';
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
						echo ')';
					}
				}
				echo '</ul>';
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Check if this is a subpage

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'is_subpage' ) ) {
		function is_subpage()
		{
			global $post;                              // load details about this page
			if ( is_page() && $post->post_parent ) {   // test to see if the page has a parent
				return $post->post_parent;             // return the ID of the parent post
			}
			// there is no parent so ...
			return false;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Login Form

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_login_form' ) ) {
		
		function zn_login_form()
		{
			// CHECK IF USER IS LOGGED IN
			
			global $znData, $wp;
			
			$current_url = home_url( $wp->request );
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( is_user_logged_in() || ! $znData['head_show_login'] ) {
				return;
			}
			?>
			
			<div class="login_register_stuff hide">
				
				<!-- Login/Register Modal forms - hidden by default to be opened through modal -->
				
				<div id="login_panel">
					
					<div class="inner-container login-panel">
						
						<?php // wp_login_form(  );
						?>
						
						<h3 class="m_title"><?php _e( "SIGN IN YOUR ACCOUNT TO HAVE ACCESS TO DIFFERENT FEATURES", THEMENAME ); ?></h3>
						
						
						<form id="login_form" name="login_form" method="post" class="zn_form_login"
						
							  action="<?php echo site_url( 'wp-login.php', 'login_post' ) ?>">
							
							
							<?php if ( get_option( 'users_can_register' ) ) { ?>
								
								<a href="#" class="create_account"
								
								   onClick="ppOpen('#register_panel', '280');"><?php _e( "CREATE ACCOUNT", THEMENAME ); ?></a>
							
							<?php } ?>
							
							<input type="text" id="username" name="log" class="inputbox"
							
								   placeholder="<?php _e( "Username", THEMENAME ); ?>">
							
							<input type="password" id="password" name="pwd" class="inputbox"
							
								   placeholder="<?php _e( "Password", THEMENAME ); ?>">
							
							<?php do_action( 'login_form' ); ?>
							
							<label class="zn_remember"><input type="checkbox" name="rememberme" id="rememberme"
							
															  value="forever"><?php _e( " Remember Me", THEMENAME ); ?>
							
							</label>
							
							<input type="submit" id="login" name="submit_button" class="zn_sub_button"
							
								   value="<?php _e( "LOG IN", THEMENAME ); ?>">
							
							<input type="hidden" value="login" class="" name="zn_form_action">
							
							<input type="hidden" value="zn_do_login" class="" name="action">
							
							<input type="hidden" value="<?php echo $current_url; ?>" class="zn_login_redirect"
							
								   name="submit">
							
							
							<div class="links">
								
								<a href="#"
								   onClick="ppOpen('#forgot_panel', '350');"><?php _e( "FORGOT YOUR PASSWORD?", THEMENAME ); ?></a>
							
							</div>
						
						</form>
					
					</div>
				
				</div>
				
				<!-- end login panel -->
				
				<?php
					
					$canRegister = (int) get_option( 'users_can_register' );
					
					if ( $canRegister ) { ?>
						
						<div id="register_panel">
							<div class="inner-container register-panel">
								<h3 class="m_title"><?php _e( "CREATE ACCOUNT", THEMENAME ); ?></h3>
								
								<form id="register_form" name="login_form" method="post" class="zn_form_login"
									  action="<?php echo site_url( 'wp-login.php?action=register', 'login_post' ) ?>">
									
									<p>
										<input type="text" id="reg-username" name="user_login" class="inputbox"
											   placeholder="<?php _e( "Username", THEMENAME ); ?>">
									</p>
									
									<p>
										<input type="text" id="reg-email" name="user_email" class="inputbox"
											   placeholder="<?php _e( "Email", THEMENAME ); ?>">
									</p>
									
									<p>
										<input type="password" id="reg-pass" name="user_password" class="inputbox"
											   placeholder="<?php _e( "Your password", THEMENAME ); ?>">
									</p>
									
									<p>
										<input type="password" id="reg-pass2" name="user_password2" class="inputbox"
											   placeholder="<?php _e( "Verify password", THEMENAME ); ?>">
									</p>
									
									<p>
										<input type="submit" id="signup" name="submit" class="zn_sub_button"
											   value="<?php _e( "CREATE MY ACCOUNT", THEMENAME ); ?>">
									</p>
									
									<input type="hidden" value="register" name="zn_form_action">
									<input type="hidden" value="zn_do_login" name="action">
									<input type="hidden" value="<?php echo $current_url; ?>" class="zn_login_redirect"
										   name="submit">
									
									
									<div class="links">
										<a href="#"
										   onClick="ppOpen('#login_panel', '800');"><?php _e( "ALREADY HAVE AN ACCOUNT?", THEMENAME ); ?></a>
									</div>
								</form>
							</div>
						
						</div><!-- end register panel -->
					
					<?php } ?>
				
				
				
				<div id="forgot_panel">
					
					<div class="inner-container forgot-panel">
						
						<h3 class="m_title"><?php _e( "FORGOT YOUR DETAILS?", THEMENAME ); ?></h3>
						
						
						<form id="forgot_form" name="login_form" method="post" class="zn_form_lost_pass"
						
							  action="<?php echo site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ?>">
							
							<p>
								
								<input type="text" id="forgot-email" name="user_login" class="inputbox"
								
									   placeholder="<?php _e( "Username or E-mail", THEMENAME ); ?>">
							
							</p>
							
							
							<p>
								
								<input type="submit" id="recover" name="submit" class="zn_sub_button"
								
									   value="<?php _e( "SEND MY DETAILS!", THEMENAME ); ?>">
							
							</p>
							
							
							<div class="links">
								
								<a href="#"
								   onClick="ppOpen('#login_panel', '800');"><?php _e( "AAH, WAIT, I REMEMBER NOW!", THEMENAME ); ?></a>
							
							</div>
						
						</form>
					
					</div>
				
				</div>
				
				<!-- end register panel -->
			
			</div><!-- end login register stuff -->
		
		<?php
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Login Form - Stop redirecting if ajax is used

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_stop_redirecting' ) ) {
		
		function zn_stop_redirecting( $redirect_to, $request, $user )
		{
			if ( empty ( $_POST['ajax_login'] ) ) {
				
				return $redirect_to;
			}
		}
	}
	add_filter( "login_redirect", "zn_stop_redirecting", 10, 3 );
	
	/*--------------------------------------------------------------------------------------------------

Facebook Open Graph functions

--------------------------------------------------------------------------------------------------*/
	
	/* DEFAULT TITLE*/
	
	if ( ! function_exists( 'zn_opengraph_default_title' ) ) {
		
		function zn_opengraph_default_title()
		{
			global $post;
			if ( is_home() || is_front_page() ) {
				$title = get_bloginfo( 'name' );
			}
			else {
				$title = get_the_title();
			}
			echo strip_tags( $title );
		}
	}
	
	if ( ! function_exists( 'zn_opengraph_default_type' ) ) {
		
		function zn_opengraph_default_type()
		
		{
			
			$type = 'blog';
			
			if ( is_singular( array ( 'post', 'page', 'aside', 'status' ) ) ) {
				
				$type = 'article';
			}
			
			else if ( is_author() ) {
				
				$type = 'profile';
			}
			
			echo $type;
		}
	}
	
	if ( ! function_exists( 'opengraph_default_image' ) ) {
		
		function opengraph_default_image()
		
		{
			
			if ( is_singular() ) {
				
				global $post;
				
				$images = array ();
				
				if ( has_post_thumbnail( $post->ID ) ) {
					
					$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
					
					$images[] = $thumbnail_src['0'];
				}
				
				$content = $post->post_content;
				
				$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
				
				if ( $output !== false ) {
					
					foreach ( $matches[1] as $match ) {
						
						// If the image path is relative, add the site url to the beginning
						
						if ( ! preg_match( '/^https?:\/\//', $match ) ) {
							
							// Remove any starting slash with ltrim() and add one to the end of site_url()
							
							$match = site_url( '/' ) . ltrim( $match, '/' );
						}
						
						$images[] = $match;
					}
				}
				
				foreach ( $images as $image ) {
					
					if ( $image ) {
						
						//$image[] = $thumbnail[0];
						
						echo '<meta property="og:image" content="' . $image . '"/>';
					}
				}
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

CHECK FOR IS COMING SOON PAGE

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_coming_soon_page' ) ) {
		
		function zn_coming_soon_page()
		
		{
			
			global $znData, $pagenow;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( $znData['cs_enable'] == 'yes' && ! is_user_logged_in() && ! is_admin() && $pagenow != 'wp-login.php' ) {
				
				get_template_part( 'coming_soon_page' );
				
				exit();
			}
		}
	}
	
	add_action( 'init', 'zn_coming_soon_page', 26 );
	
	/*--------------------------------------------------------------------------------------------------

Add Ajax status to page

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_has_ajax' ) ) {
		
		function zn_has_ajax()
		
		{
			
			//    global $has_ajax;
			
			if ( isset ( $_POST['cform_submit'] ) ) {
				
				global $post, $znData;
				
				if ( $post ) {
					
					$meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
					
					$meta_fields = maybe_unserialize( $meta_fields );
					
					// All the page builder areas
					
					$areas = array (
						'header_area',
						'action_box_area',
						'content_main_area',
						'content_grey_area',
						'content_bottom_area'
					);
					
					$metas = array ();
					
					foreach ( $areas as $area ) {
						
						if ( isset ( $meta_fields[ $area ] ) ) {
							
							$metas = array_merge( $metas, $meta_fields[ $area ] );
						}
					}
					
					foreach ( $metas as $options ) {
						
						// CONTACT FORM
						
						if ( $options['dynamic_element_type'] == '_c_form' ) {
							
							if ( isset ( $_POST['cform_submit'] ) ) {
								
								$body = '';
								
								$name = '';
								
								$email = '';
								
								$headers = array ();
								
								$headers[] = 'MIME-Version: 1.0';
								
								$headers[] = 'Content-type: text/html; charset=utf-8';
								
								$captcha = false;
								
								foreach ( $options['zn_cf_fields'] as $field ) {
									
									$field_name = preg_replace( '~[\W\s]~', '_', $field['zn_cf_name'] );
									
									// Compoese the mail
									
									if ( isset ( $_POST[ $field_name ] ) ) {
										
										$body .= $field['zn_cf_name'] . ' : ' . $_POST[ $field_name ] . "<br />";
										
										if ( $field['zn_cf_f_email'] ) {
											
											$email = $_POST[ $field_name ];
										}
										
										if ( $field['zn_cf_f_name'] ) {
											
											$name = $_POST[ $field_name ];
										}
									}
									
									if ( $field['zn_cf_type'] == 'captcha' ) {
										
										$captcha = true;
									}
								}
								
								if ( ! empty ( $name ) ) {
									
									$headers[] = 'From: ' . $name . ' <' . $email . '>';
								}
								
								if ( ! empty ( $email ) ) {
									
									$headers[] = 'Reply-To: ' . $email;
								}
								
								if ( $captcha && ! empty( $znData['rec_priv_key'] ) ) {
									
									locate_template( array ( 'template-helpers/recaptchalib.php' ), true, false );
									
									$privatekey = $znData['rec_priv_key'];
									
									$resp = recaptcha_check_answer( $privatekey,
										
										$_SERVER["REMOTE_ADDR"],
										
										$_POST["recaptcha_challenge_field"],
										
										$_POST["recaptcha_response_field"] );
									
									if ( ! $resp->is_valid ) {
										
										// What happens when the CAPTCHA was entered incorrectly
										
										die ( "The reCAPTCHA wasn't entered correctly. Please try again." );
									}
									
									else {
										
										if ( wp_mail( $options['zn_cf_email_address'], $options['zn_cf_button_subject'], $body, $headers ) ) {
											
											echo 'sent';
										}
										
										else {
											
											echo 'mail_not_sent';
										}
									}
								}
								
								else {
									
									if ( wp_mail( $options['zn_cf_email_address'], $options['zn_cf_button_subject'], $body, $headers ) ) {
										
										echo 'sent';
									}
									
									else {
										
										echo 'mail_not_sent';
									}
								}
							}
						}
					}
				}
				
				//wp_enqueue_scripts();
				
				exit();
			}
		}
	}
	
	add_action( 'get_header', 'zn_has_ajax' );
	
	/*--------------------------------------------------------------------------------------------------

*

THEME UPDATE 1.1

1.1 - Added new menu position for the header

*

--------------------------------------------------------------------------------------------------*/
	
	/*--------------------------------------------------------------------------------------------------

New TOP NAVIGATION

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'init', 'zn_register_menu2' );
	
	if ( ! function_exists( 'zn_register_menu2' ) ) {
		
		function zn_register_menu2()
		
		{
			
			if ( function_exists( 'wp_nav_menu' ) ) {
				
				add_theme_support( 'nav-menus' );
				
				register_nav_menus( array (
					
					'header_navigation' => esc_html__( 'Header Navigation', THEMENAME ),
				
				) );
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Check for boxed layout or full

--------------------------------------------------------------------------------------------------*/
	
	// Add specific CSS class by filter
	
	add_filter( 'body_class', 'zn_body_class_names' );
	
	if ( ! function_exists( 'zn_body_class_names' ) ) {
		
		function zn_body_class_names( $classes )
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( ( ! empty( $znData['zn_boxed_layout'] ) && $znData['zn_boxed_layout'] == 'yes' ) || ( is_front_page() && ! empty( $znData['zn_home_boxed_layout'] ) && $znData['zn_home_boxed_layout'] == 'yes' ) ) {
				
				$classes[] = 'boxed';
			}
			
			if ( is_front_page() && ! empty( $znData['zn_home_boxed_layout'] ) && $znData['zn_home_boxed_layout'] == 'no' ) {
				
				$classes = array_diff( $classes, array ( "boxed" ) );
			}
			
			if ( isset( $znData['zn_width'] ) ) {
				
				if ( $znData['zn_width'] == '1170' && $znData['zn_responsive'] == 'yes' ) {
					
					$classes[] = 'res1170';
				}
				
				if ( $znData['zn_width'] == '960' ) {
					
					$classes[] = 'res960';
				}
			}

			if ( ! empty( $znData['zn_slider_header'] ) && $znData['zn_slider_header'] == 'yes' ) {
				
				$classes[] = 'slider_after_header';
			}


            $classes[] = 'kos_'.$znData['zn_slider_header'];

			return $classes;
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Add AFTER BODY ACTIONS

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'zn_after_body', 'zn_add_page_loading', 10 );
	
	if ( ! function_exists( 'zn_add_page_loading' ) ) {
		
		function zn_add_page_loading()
		
		{
			
			zn_page_loading();
		}
	}
	
	/* SUPPORT PANEL */
	
	add_action( 'zn_after_body', 'zn_add_hidden_panel', 10 );
	
	if ( ! function_exists( 'zn_add_hidden_panel' ) ) {
		
		function zn_add_hidden_panel()
		
		{
			
			zn_hidden_pannel();
		}
	}
	
	/* LOGIN FORM */
	
	add_action( 'zn_after_body', 'zn_add_login_form', 10 );
	
	if ( ! function_exists( 'zn_add_login_form' ) ) {
		
		function zn_add_login_form()
		{
			echo zn_login_form();
		}
	}
	
	/* OPEN GRAPH */
	
	add_action( 'zn_after_body', 'zn_add_open_graph', 10 );
	
	if ( ! function_exists( 'zn_add_open_graph' ) ) {
		
		function zn_add_open_graph()
		
		{
			
			zn_f_o_g();
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Add MENU to top area

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'zn_head_right_area', 'zn_add_navigation', 40 );
	
	if ( ! function_exists( 'zn_add_navigation' ) ) {
		
		function zn_add_navigation()
		
		{
			
			zn_show_nav( 'header_navigation' );
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Add Right content to action

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'zn_head_right_area', 'zn_hidden_pannel_link', 30 );
	
	if ( ! function_exists( 'zn_hidden_pannel_link' ) ) {
		
		function zn_hidden_pannel_link()
		
		{
			
			if ( is_active_sidebar( 'hiddenpannelsidebar' ) ) {
				
				?>
				
				<ul class="topnav navRight">
					
					<li>
						
						<a href="#" id="open_sliding_panel">
							
							<span class="icon-remove-circle icon-white"></span> <?php _e( 'SUPPORT', THEMENAME ); ?>
						
						</a>
					
					</li>
				
				</ul>
			
			<?php
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Login Form - Login/logout text

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'zn_head_right_area', 'zn_login_text', 20 );
	
	if ( ! function_exists( 'zn_login_text' ) ) {
		
		function zn_login_text()
		{
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			// CHECK IF OPTION IS ENABLED
			
			if ( ! $znData['head_show_login'] ) {
				
				return;
			}
			
			if ( is_user_logged_in() ) {
				
				echo '<ul class="topnav navRight"><li><a href="' . wp_logout_url( HOME_URL ) . '">' . __( "LOGOUT", THEMENAME ) . '</a></li></ul>';
				
				return;
			}
			
			echo '<ul class="topnav navRight"><li><a href="#login_panel" data-rel="prettyPhoto[login_panel]">' . __( "LOGIN", THEMENAME ) . '</a></li></ul>';
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

SHOW HEADER SOCIAL ICONS

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'zn_head_right_area', 'zn_header_social_icons', 10 );
	
	if ( ! function_exists( 'zn_header_social_icons' ) ) {
		
		function zn_header_social_icons()
		
		{
			
			global $znData;
			
			if ( ! isset( $znData ) || empty( $znData ) ) {
				
				$znData = get_option( OPTIONS );
			}
			
			if ( isset( $znData['social_icons_visibility_status'] ) && ( $znData['social_icons_visibility_status'] == 'yes' ) ) {
				
				if ( isset( $znData['header_social_icons'] ) && is_array( $znData['header_social_icons'] ) && ! empty( $znData['header_social_icons'][0]['header_social_icon'] ) ) {
					
					$icon_class = '';
					
					if ( isset( $znData['header_which_icons_set'] ) && $znData['header_which_icons_set'] == 'colored' ) {
						
						$icon_class = 'colored';
					}
					
					echo '<ul class="social-icons ' . $icon_class . ' topnav navRight">';
					
					foreach ( $znData['header_social_icons'] as $key => $icon ) {
						
						$link = '';
						
						$target = '';
						
						if ( isset ( $icon['header_social_link'] ) && is_array( $icon['header_social_link'] ) ) {
							
							$link = $icon['header_social_link']['url'];
							
							$target = 'target="' . $icon['header_social_link']['target'] . '"';
						}
						
						echo '<li class="' . $icon['header_social_icon'] . '"><a href="' . $link . '" ' . $target . '>' . $icon['header_social_title'] . '</a></li>';
					}
					
					echo '</ul>';
				}
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Add WOOCOMMERCE CART LINK

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'zn_head_right_area', 'zn_woocomerce_cart', 2 );
	
	if ( ! function_exists( 'zn_woocomerce_cart' ) ) {
		
		function zn_woocomerce_cart()
		
		{
			
			global $pagenow;
			
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && $pagenow != 'wp-activate.php' ) {
				
				global $znData;
				
				if ( ! isset( $znData ) || empty( $znData ) ) {
					
					$znData = get_option( OPTIONS );
				}
				
				if ( isset( $znData['woo_show_cart'] ) && $znData['woo_show_cart'] ) {
					
					global $woocommerce;
					
					?>
					
					<ul class="topnav navLeft">
						
						<li class="drop">
							
							<a id="mycartbtn" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"
							
							   title="<?php _e( 'View your shopping cart', THEMENAME ); ?>">
								
								<?php _e( "MY CART", THEMENAME ); ?>
							
							</a>
							
							
							<div class="pPanel">
								
								<div class="inner">

							<span class="cart_details"><?php
									
									echo sprintf( _n( '%d item', '%d items', $woocommerce->cart->cart_contents_count, THEMENAME ), $woocommerce->cart->cart_contents_count );
								
								?>
								, <?php _e( "Total of", THEMENAME ); ?> <?php echo $woocommerce->cart->get_cart_total(); ?>
								
								<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"
								
								   title="<?php _e( 'View your shopping cart', THEMENAME ); ?>"
								
								   class="checkout"><?php _e( "Checkout", THEMENAME ); ?> <span
										
										class="icon-chevron-right"></span>
								
								</a>

							</span>
								
								</div>
							
							</div>
						
						</li>
					
					</ul>
				
				<?php
				}
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

WPML language switcher

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'zn_head_right_area', 'zn_wpml_language_switcher', 3 );
	
	if ( ! function_exists( 'zn_wpml_language_switcher' ) ) {
		
		function zn_wpml_language_switcher()
		
		{
			
			if ( function_exists( 'icl_get_languages' ) ) {
				
				global $znData;
				
				if ( ! isset( $znData ) || empty( $znData ) ) {
					
					$znData = get_option( OPTIONS );
				}
				
				if ( isset( $znData['head_show_flags'] ) ) {
					
					echo '<ul class="topnav navLeft">';
					
					echo '<li class="languages drop"><a href="#"><span class="icon-globe icon-white"></span> ' . __( "LANGUAGES", THEMENAME ) . '</a>';
					
					echo '<div class="pPanel">';
					
					echo '<ul class="inner">';
					
					$languages = icl_get_languages( 'skip_missing=0' );
					
					if ( 1 < count( $languages ) ) {
						
						foreach ( $languages as $l ) {
							
							$active = '';
							
							$icon = '';
							
							if ( $l['active'] ) {
								
								$active = 'active';
								
								$icon = '<span class="icon-ok"></span></a></li>';
							}
							
							echo '<li class="' . $active . '"><a href="' . $l['url'] . '">' . $l['native_name'] . ' <img src="' . $l['country_flag_url'] . '" alt="' . $l['native_name'] . '" /> ' . $icon . '';
						}
					}
					
					echo '</ul>';
					
					echo '</div>';
					
					echo '</li>';
					
					echo '</ul>';
				}
			}
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Select first image in post

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'echo_first_image' ) ) {
		
		function echo_first_image()
		
		{
			
			global $post;
			
			$id = $post->ID;
			
			$attachments = get_children( array (
					'post_parent'    => $id,
					'numberposts'    => 1,
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
					'order'          => 'DESC',
					'orderby'        => 'menu_order date'
				)
			
			);
			
			// Search for and get the post attachment
			
			if ( ! empty( $attachments ) ) {
				
				$counter = - 1;
				
				foreach ( $attachments as $att_id => $attachment ) {
					
					$counter ++;
					
					if ( $counter < 0 ) {
						continue;
					}
					
					$src = wp_get_attachment_url( $att_id );
					
					return $src;
				}
				// Get the first img tag from content
				
			}
			
			else {
				
				//print_r($post->post_content);
				
				$first_img = '';
				
				$post = get_post( $id );
				
				ob_start();
				
				ob_end_clean();
				
				$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
				
				if ( ! empty( $matches[1][0] ) && basename( $matches[1][0] ) != 'trans.gif' ) {
					
					// Save Image URL
					
					return esc_url( $matches[1][0] );
				}
				
				elseif ( ! empty( $matches[1][1] ) ) {
					
					return esc_url( $matches[1][1] );
				}
			}
			
			return '';
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Documentation Post Type

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'init', 'zn_documentation_post_type' );
	
	if ( ! function_exists( 'zn_documentation_post_type' ) ) {
		
		function zn_documentation_post_type()
		
		{
			
			$slug = true;
			
			$permalinks = get_option( 'zn_permalinks' );
			
			if ( ! empty( $permalinks['doc_item'] ) ) {
				
				$slug = array ( 'slug' => $permalinks['doc_item'] );
			}
			
			$labels = array (
				
				'name'               => __( 'Documentation', THEMENAME ),
				'singular_name'      => __( 'Documentation Item', THEMENAME ),
				'add_new'            => __( 'Add New Documentation Item', THEMENAME ),
				'all_items'          => __( 'All Documentation Items', THEMENAME ),
				'add_new_item'       => __( 'Add New Documentation', THEMENAME ),
				'edit_item'          => __( 'Edit Documentation Item', THEMENAME ),
				'new_item'           => __( 'New Documentation Item', THEMENAME ),
				'view_item'          => __( 'View Documentation Item', THEMENAME ),
				'search_items'       => __( 'Search Documentation Items', THEMENAME ),
				'not_found'          => __( 'No Documentation Items found', THEMENAME ),
				'not_found_in_trash' => __( 'No Documentation Items found in trash', THEMENAME ),
				'parent_item_colon'  => __( 'Parent Documentation:', THEMENAME ),
				'menu_name'          => __( 'Documentation Items', THEMENAME ),
			
			);
			
			$args = array (
				
				'labels'              => $labels,
				'description'         => "",
				'public'              => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_nav_menus'   => true,
				'show_in_menu'        => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 100,
				'menu_icon'           => ADMIN_IMAGES_DIR . '/portfolio.png',
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array ( 'title', 'editor' ),
				'has_archive'         => true,
				'rewrite'             => $slug,
				'query_var'           => true,
				'can_export'          => true
			
			);
			
			register_post_type( 'documentation', $args );
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

Documentation Post Taxonomy

--------------------------------------------------------------------------------------------------*/
	
	add_action( 'init', 'zn_documentation_category', 0 );
	
	if ( ! function_exists( 'zn_documentation_category' ) ) {
		
		function zn_documentation_category()
		
		{
			
			$slug = true;
			
			$permalinks = get_option( 'zn_permalinks' );
			
			if ( ! empty( $permalinks['doc_tax'] ) ) {
				
				$slug = array ( 'slug' => $permalinks['doc_tax'] );
			}
			
			// Add new taxonomy, make it hierarchical (like categories)
			
			$labels = array (
				
				'name'              => __( 'Categories', THEMENAME ),
				'singular_name'     => __( 'Category', THEMENAME ),
				'search_items'      => __( 'Search Categories', THEMENAME ),
				'all_items'         => __( 'All Categories', THEMENAME ),
				'parent_item'       => __( 'Parent Category', THEMENAME ),
				'parent_item_colon' => __( 'Parent Category:', THEMENAME ),
				'edit_item'         => __( 'Edit Category', THEMENAME ),
				'update_item'       => __( 'Update Category', THEMENAME ),
				'add_new_item'      => __( 'Add New Category', THEMENAME ),
				'new_item_name'     => __( 'New Category Name', THEMENAME ),
				'menu_name'         => __( 'Documentation categories', THEMENAME ),
			
			);
			
			register_taxonomy( 'documentation_category', 'documentation', array (
				
				'hierarchical' => true,
				'labels'       => $labels,
				'show_ui'      => true,
				'query_var'    => true,
				'rewrite'      => $slug,
			
			) );
		}
	}
	
	/*--------------------------------------------------------------------------------------------------

LOGIN SYSTEM

--------------------------------------------------------------------------------------------------*/
	
	if ( ! function_exists( 'zn_do_login' ) ) {
		
		function zn_do_login()
		{
			if ( $_POST['zn_form_action'] == 'login' ) {
				
				$user = wp_signon();
				
				if ( is_wp_error( $user ) ) {
					
					echo '<div id="login_error">' . $user->get_error_message() . '</div>';
				}
				
				else {
					echo 'success';
				}
				
				exit;
			}
			
			elseif ( $_POST['zn_form_action'] == 'register' ) {
				$zn_error         = false;
				$zn_error_message = array ();
				
				if ( ! empty( $_POST['user_login'] ) ) {
					if ( username_exists( $_POST['user_login'] ) ) {
						$zn_error           = true;
						$zn_error_message[] = __( 'The username already exists', THEMENAME );
					}
					else {
						$username = $_POST['user_login'];
					}
				}
				else {
					$zn_error           = true;
					$zn_error_message[] = __( 'Please enter an username', THEMENAME );
				}
				
				if ( ! empty( $_POST['user_password'] ) ) {
					$password = $_POST['user_password'];
				}
				else {
					$zn_error           = true;
					$zn_error_message[] = __( 'Please enter a password', THEMENAME );
				}
				
				if ( ( empty( $_POST['user_password'] ) && empty( $_POST['user_password2'] ) ) || $_POST['user_password'] != $_POST['user_password2'] ) {
					$zn_error           = true;
					$zn_error_message[] = __( 'Passwords do not match', THEMENAME );
				}
				
				if ( ! empty( $_POST['user_email'] ) ) {
					if ( ! email_exists( $_POST['user_email'] ) ) {
						if ( ! filter_var( $_POST['user_email'], FILTER_VALIDATE_EMAIL ) ) {
							$zn_error           = true;
							$zn_error_message[] = __( 'Please enter a valid EMAIL address', THEMENAME );
						}
						else {
							$email = $_POST['user_email'];
						}
					}
					else {
						$zn_error           = true;
						$zn_error_message[] = __( 'This email address has already been used', THEMENAME );
					}
				}
				
				else {
					
					$zn_error = true;
					
					$zn_error_message[] = __( 'Please enter an email address', THEMENAME );
				}
				
				if ( $zn_error ) {
					
					echo '<div id="login_error">';
					
					foreach ( $zn_error_message as $error ) {
						
						echo $error . '<br />';
					}
					
					echo '</div>';
				}
				
				else {
					
					$user_data = array (
						
						'ID'           => '',
						'user_pass'    => $password,
						'user_login'   => $username,
						'display_name' => $username,
						'user_email'   => $email,
						'role'         => get_option( 'default_role' )
						// Use default role or another role, e.g. 'editor'
					
					);
					
					$user_id = wp_insert_user( $user_data );
					
					if ( ! function_exists( 'wp_new_user_notification' ) ) {
						include_once( trailingslashit( ABSPATH ) . 'wp-includes/pluggable.php' );
					}
					wp_new_user_notification( $user_id, $password );
					
					echo '<div id="login_error">' . __( 'Your account has been created. You can now login.', THEMENAME ) . '</div>';
				}
				
				exit;
			}
			
			elseif ( $_POST['zn_form_action'] == 'reset_pass' ) {
				
				echo do_action( 'login_form', 'resetpass' );
			}
		}
	}
	if ( ! is_user_logged_in() ) {
		add_action( "wp_ajax_nopriv_zn_do_login", "zn_do_login" );
	}
	
	//add_action( "wp_ajax_zn_do_login", "zn_do_login" );
	
	// Update 3.2
	
	// Fix for seo-workers not seeing multiple keyphrases
	
	add_filter( 'language_attributes', 'smc_language_attributes' );
	
	function smc_language_attributes( $content )
	{
		
		global $is_IE;
		
		if ( $is_IE ) {
			
			$browser = $_SERVER['HTTP_USER_AGENT'];
			
			$iev = '';
			
			if ( isset( $browser ) && ( strpos( $browser, 'MSIE' ) !== false ) ) {
				
				preg_match( '/MSIE (.*?);/', $browser, $matches );
				
				if ( count( $matches ) > 1 ) {
					
					$iev = floor( $matches[1] );
				}
			}
			
			return $content . ' class="no-js oldie ie' . $iev . ' isie" ';
		}
		
		return $content . ' class="no-js" ';
	}
	
	remove_action( 'wp_print_footer_scripts', array ( 'C_Photocrati_Resource_Manager', 'get_resources' ), 1 );
	
	// Add image sizes
	
	set_post_thumbnail_size( 280, 187 );
	
	add_image_size( 'full-width-image', 1170 );

	//<editor-fold desc="@wpk: Add support for Yoast plugin">
	if ( ! function_exists( 'zn_yoast_content_filter' ) ) {
		
		function zn_yoast_content_filter( $post_content, $post )
		{
			if ( ! empty( $post ) && isset( $post->ID ) ) {
				$metaFields = get_post_meta( $post->ID, 'zn_meta_elements', true );
				$post_content .= zn_flat_array( $metaFields );
			}
			return $post_content;
		}
	}
	
	if ( ! function_exists( 'zn_flat_array' ) ) {
		/**
		 * Flattens an array
		 *
		 * @param array|string $array
		 *
		 * @return string
		 */
		
		function zn_flat_array( $array )
		{
			
			$flat = '';
			
			if ( empty( $array ) ) {
				
				return $flat;
			}
			
			if ( is_array( $array ) ) {
				
				foreach ( $array as $key => $value ) {
					
					if ( is_array( $value ) ) {
						
						$flat .= zn_flat_array( $value );
					}
					
					else {
						
						$flat .= ' ' . $value;
					}
				}
			}
			
			else {
				
				return ' ' . $array;
			}
			
			return $flat;
		}
	}
	
	// Enable/disable the filter to test it
	
	add_filter( 'wpseo_pre_analysis_post_content', 'zn_yoast_content_filter', 10, 2 );
	
	//</editor-fold desc="@wpk: Add support for Yoast plugin">
	
	if ( ! function_exists( 'kall_extract_link' ) ) {
		/**
		 * This function will return the option
		 *
		 * @param      $link_array
		 * @param bool $class
		 * @param bool $attributes
		 *
		 * @return array An array containing a link start and link end HTML
		 */
		function kall_extract_link( $link_array, $class = false, $attributes = false )
		{
			
			if ( ! is_array( $link_array ) || empty( $link_array['url'] ) ) {
				
				$link['start'] = '<span ' . $attributes . ' class="' . $class . '">';
				
				$link['end'] = '</span>';
			}
			
			else {
				
				$link = array (
					'start' => '<a href="' . $link_array['url'] . '" ' . $attributes . ' class="' . $class . '" title="' . $link_array['title'] . '" target="' . $link_array['target'] . '">',
					'end'   => '</a>'
				);
			}
			
			return $link;
		}
	}
	
	//<editor-fold desc="@wpk: Display the Info Card when you hover over the logo.">
	/**
	 * Display the Info Card when you hover over the logo.
	 * This function is also available as an action: zn_show_infocard
	 */
	if ( ! function_exists( 'kfn_showInfoCard' ) ) {
		function kfn_showInfoCard()
		{
			global $get_stylesheet_directory_uri, $znData;

			if ( ! isset( $znData ) || empty( $znData ) ) {
				$znData = get_option( OPTIONS );
			}
			if ( ! isset( $znData['infocard_display_status'] ) ) {
				return;
			}
			if ( isset( $znData['infocard_display_status'] ) && ( $znData['infocard_display_status'] == 'no' ) ) {
				return;
			}

			$bgColorDefault = '#cd2122';
			$logoUrlDefault = $get_stylesheet_directory_uri . '/images/kallyas_icon.png';
			$bgColor        = ( ( isset( $znData['infocard_bg_color'] ) && ! empty( $znData['infocard_bg_color'] ) ) ? $znData['infocard_bg_color'] : $bgColorDefault );
			$logoUrl        = ( ( isset( $znData['infocard_logo_url'] ) && ! empty( $znData['infocard_logo_url'] ) ) ? $znData['infocard_logo_url'] : $logoUrlDefault );
			$cpyDesc        = ( ( isset( $znData['infocard_company_description'] ) && ! empty( $znData['infocard_company_description'] ) ) ? $znData['infocard_company_description'] : '' );
			$phone          = ( ( isset( $znData['infocard_company_phone'] ) && ! empty( $znData['infocard_company_phone'] ) ) ? $znData['infocard_company_phone'] : '' );
			$email          = ( ( isset( $znData['infocard_company_email'] ) && ! empty( $znData['infocard_company_email'] ) ) ? $znData['infocard_company_email'] : '' );
			$cpyName        = ( ( isset( $znData['infocard_company_name'] ) && ! empty( $znData['infocard_company_name'] ) ) ? $znData['infocard_company_name'] : '' );
			$address        = ( ( isset( $znData['infocard_company_address'] ) && ! empty( $znData['infocard_company_address'] ) ) ? $znData['infocard_company_address'] : '' );
			$mapLink        = ( ( isset( $znData['infocard_gmap_link'] ) && ! empty( $znData['infocard_gmap_link'] ) ) ? $znData['infocard_gmap_link'] : '' );
			$socialIcons    = ( ( isset( $znData['header_social_icons'] ) && ! empty( $znData['header_social_icons'] ) ) ? $znData['header_social_icons'] : null );
			?>

			<div id="infocard" style="background: <?php echo $bgColor;?>;">

				<div class="custom ">

					<div class="row-fluid ">

						<div class="span5">

							<p>&nbsp;</p>

							<p style="text-align: center;"><img src="<?php echo $logoUrl;?>" border="0" alt=""></p>

							<p style="text-align: center;"><?php echo $cpyDesc;?></p>

						</div>

						<div class="span7">

							<div class="custom contact-details">

								<p><strong><?php echo $phone;?></strong><br><?php _e( 'Email:', THEMENAME );?>&nbsp;<a
										href="mailto:<?php echo $email;?>"><?php echo $email;?></a></p>

								<p><?php echo $cpyName . '<br/>' . $address;?></p>

								<a href="<?php echo $mapLink;?>" target="_blank" class="map-link"><span
										class="icon-map-marker icon-white"></span>
									<span><?php _e( 'Open in Google Maps', THEMENAME );?></span></a>
							</div>

							<div style="height:20px;"></div>

							<?php
								if ( ! empty( $socialIcons ) ) {
									echo '<ul class="social-icons normal">';
									foreach ( $socialIcons as $i => $entry ) {
										$titleAttr  = esc_attr( $entry['header_social_title'] );
										$url        = $entry['header_social_link']['url'];
										$targetAttr = esc_attr( $entry['header_social_link']['target'] );
										$icon       = $entry['header_social_icon'];
										echo '<li class="' . $icon . '">';
										echo '<a title="' . $titleAttr . '" href="' . $url . '" target="' . $targetAttr . '">' . $titleAttr . '</a>';
										echo '</li>';
									}
									echo '</ul>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
		<?php }
	}

	add_action( 'zn_show_infocard', 'kfn_showInfoCard' );
	//</editor-fold desc="@wpk: Display the Info Card when you hover over the logo.">

	if ( ! function_exists( 'zn_woo_nonce_field' ) ) {
		
		/**
		 * Replaces the deprecated call to WooCommerce::nonce_field()
		 *
		 * @param      $action
		 * @param bool $referer
		 * @param bool $echo
		 *
		 * @return string
		 */
		function zn_woo_nonce_field( $action, $referer = true, $echo = true )
		{
			return wp_nonce_field( 'woocommerce-' . $action, '_wpnonce', $referer, $echo );
		}
	}

	/*
	 * Display the dismissible admin notice regarding the usage of the Cute3D Slider
	 */
	if ( ! function_exists( 'kallyasShowCuteSliderNotice' ) ) {
		
		/**
		 * Display the notification regarding the usage of the 3D Cute Slider
		 */
		function kallyasShowCuteSliderNotice()
		{
			do_action( 'wpk_dismissible_notice', 'error', __( 'The plugin 3D Cute Slider is no longer supported by
			its author and it was removed from Envato Marketplace. We will try to continue offering support for it as
			much as we can but we strongly recommend you to replace its usage with an other slider or continue using it at your own risk.', THEMENAME ), 'kallyas-dismiss-notice' );
		}
	}

	//<editor-fold desc="@wpk: Add option to select custom header in Edit Category page">
	if ( is_admin() && ( isset( $_REQUEST['taxonomy'] ) && $_REQUEST['taxonomy'] !== '' ) ) {
		add_action( sanitize_text_field( $_REQUEST['taxonomy'] ) . '_edit_form', 'wpk_zn_edit_category_form', 40, 1 );
	}

	if ( ! function_exists( 'wpk_zn_edit_category_form' ) ) {
		function wpk_zn_edit_category_form( $term )
		{ ?>
			<h2><?php _e( 'Kallyas Options', THEMENAME ); ?></h2>
			<table class="form-table">
				<tbody>
				<tr class="form-field form-required term-name-wrap">
					<th scope="row"><label
							for="wpk_zn_select_custom_header"><?php _e( 'Select header', THEMENAME ); ?></label></th>
					<td>
						<?php
							// GET ALL CUSTOM HEADERS
							$allHeaders = wpk_zn_getAllCustomHeaders();
							if ( ! empty( $allHeaders ) ) {
								echo '<select name="wpk_zn_select_custom_header" id="wpk_zn_select_custom_header">';
								// Check option to display the previously checked option
								$optData      = get_option( 'wpk_zn_select_custom_header_' . $term->term_id );
								$selectedSlug = 'zn_def_header_style'; // use default by default
								if ( ! empty( $optData ) ) {
									$selectedSlug = $optData;
								}
								foreach ( $allHeaders as $slug => $name ) {
									echo '<option value="' . $slug . '"';
									if ( $slug == $selectedSlug ) {
										echo ' selected="selected"';
									}
									echo '>' . $name . '</option>';
								}
								echo '</select>';
							}
						?>
						<p class="description"><?php _e( 'The custom header you want to display for this category.', THEMENAME ); ?></p>
					</td>
				</tr>
				</tbody>
			</table>
		<?php
		}
	}

	if ( ! function_exists( 'wpk_zn_getAllCustomHeaders' ) ) {
		/**
		 * Retrieve all custom headers
		 *
		 * @return array
		 */
		function wpk_zn_getAllCustomHeaders()
		{
			global $znData;
			$headers                        = array ();
			$headers['zn_def_header_style'] = __( 'Default style', THEMENAME );
			if ( isset ( $znData['header_generator'] ) && is_array( $znData['header_generator'] ) ) {
				foreach ( $znData['header_generator'] as $header ) {
					if ( isset ( $header['uh_style_name'] ) && ! empty ( $header['uh_style_name'] ) ) {
						$header_name             = strtolower( str_replace( ' ', '_', $header['uh_style_name'] ) );
						$headers[ $header_name ] = $header['uh_style_name'];
					}
				}
			}
			return $headers;
		}
	}

	if ( ! function_exists( 'wpk_zn_filterProductCatPost' ) ) {
		/**
		 * Save the custom header set in the edit category screen
		 */
		function wpk_zn_filterProductCatPost()
		{
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
				if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'editedtag' ) ) {
					if ( isset( $_POST['taxonomy'] ) && ( in_array( $_POST['taxonomy'], array (
							'category',
							'product_cat',
							'project_category'
						) ) )
					) {
						if ( isset( $_POST['wpk_zn_select_custom_header'] ) && ! empty( $_POST['wpk_zn_select_custom_header'] ) ) {
							if ( isset( $_POST['tag_ID'] ) && ! empty( $_POST['tag_ID'] ) ) {
								$customHeaderSlug = sanitize_text_field( $_POST['wpk_zn_select_custom_header'] );
								update_option( 'wpk_zn_select_custom_header_' . absint( $_POST['tag_ID'] ), $customHeaderSlug );
							}
						}
					}
				}
			}
		}

		if ( is_admin() ) {
			wpk_zn_filterProductCatPost();
		}
	}
	//</editor-fold desc="@wpk: Add option to select custom header in Edit Category page">

	//<editor-fold desc="@wpk: Add the Kallyas Options menu entry in the admin bar">
	add_action( 'admin_bar_menu', 'wpk_local_adminbar_notice', 100 );
	function wpk_local_adminbar_notice( $wp_admin_bar )
	{
		if ( is_user_logged_in() ) {
			if ( current_user_can( 'administrator' ) ) {
				$args = array (
					'id'    => 'kallyas-theme-options-menu-item',
					'title' => 'Kallyas Options',
					'href'  => admin_url( 'admin.php?page=Kallyas' ),
					'meta'  => array (
						'class' => 'wpk-kallyas-options-menu-item'
					)
				);
				$wp_admin_bar->add_node( $args );
			}
		}
	}

	add_action( 'admin_head', 'wpk_local_adminbar_notice_styles', 100 );
	add_action( 'wp_head', 'wpk_local_adminbar_notice_styles', 100 );
	function wpk_local_adminbar_notice_styles()
	{ ?>
		<style type="text/css" id="wpk_local_adminbar_notice_styles">
			#wpadminbar .ab-top-menu .wpk-kallyas-options-menu-item:hover div,
			#wpadminbar .ab-top-menu .wpk-kallyas-options-menu-item:active div,
			#wpadminbar .ab-top-menu .wpk-kallyas-options-menu-item:focus div,
			#wpadminbar .ab-top-menu .wpk-kallyas-options-menu-item div {
				color: #eee;
				cursor: default;
				background: #222;
				position: relative;
			}

			#wpadminbar .ab-top-menu .wpk-kallyas-options-menu-item:hover div {
				color: #45bbe6 !important;
			}

			#wpadminbar .ab-top-menu .wpk-kallyas-options-menu-item > .ab-item:before {
				content: '\f111';
				top: 2px;
			}
		</style>
	<?php }

	//</editor-fold desc="@wpk: Add the Kallyas Options menu entry in the admin bar">

	require( 'wpk-functions.php' );

    /**
     * Extend the search query to include the Page Builder elements
     *
     * @since v3.6.7
     */
    if(is_search()) {
        add_filter('pre_get_posts', array('WpkZn', 'updateSearchQuery'));
    }
