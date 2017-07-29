<?php
// Set the Options Array
$data = get_option( OPTIONS );
global $all_icon_sets, $bootstrap_icons, $wpdb;
include_once( locate_template( array ( 'admin/options/helper-icons.php' ), false ) );

$extra_options    = array ();
$zn_meta_elements = array ();

/*--------------------------------------------------------------------------------------------------
SET-UP META TYPES
--------------------------------------------------------------------------------------------------*/
$zn_meta_types = array (
	array (
		'title'    => __( 'Page Options', THEMENAME ),
		'id'       => 'page_options',
		'page'     => array ( 'page', 'product' ),
		'context'  => 'normal',
		'priority' => 'high'
	),
	array (
		'title'    => __( 'Post Options', THEMENAME ),
		'id'       => 'post_options',
		'page'     => array ( 'post' ),
		'context'  => 'normal',
		'priority' => 'high'
	),
	array (
		'title'    => __( 'Portfolio Options', THEMENAME ),
		'id'       => 'portfolio_options',
		'page'     => array ( 'portfolio', 'showcase' ),
		'context'  => 'normal',
		'priority' => 'high'
	),
	array (
		'title'    => __( 'General Options', THEMENAME ),
		'id'       => 'portfolio_g_options',
		'page'     => array ( 'portfolio' ),
		'context'  => 'normal',
		'priority' => 'high'
	),
	array (
		'title'    => __( 'Page Builder', THEMENAME ),
		'id'       => 'page_builder',
		'page'     => array ( 'post', 'page', 'portfolio', 'product' ),
		'context'  => 'normal',
		'priority' => 'high'
	),
	array (
		'title'    => __( 'Image Gallery', THEMENAME ),
		'id'       => 'woo_image_gallery',
		'page'     => array ( 'product' ),
		'context'  => 'normal',
		'priority' => 'high'
	),
);

/*--------------------------------------------------------------------------------------------------
Get all dynamic sidebars
--------------------------------------------------------------------------------------------------*/
$sidebar_option = array ( 'defaultsidebar' => 'Default Sidebar' );
if ( isset ( $data['sidebar_generator'] ) && is_array( $data['sidebar_generator'] ) ) {
	foreach ( $data['sidebar_generator'] as $sidebar ) {
		if ( isset( $sidebar['sidebar_name'] ) && !empty($sidebar['sidebar_name'])) {
			$sidebar_option[ $sidebar['sidebar_name'] ] = $sidebar['sidebar_name'];
		}
	}
}

/*--------------------------------------------------------------------------------------------------
Get CUTE SLIDER SLIDES
--------------------------------------------------------------------------------------------------*/
$revslider_options = array ();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'revslider/revslider.php' ) ) {

	// Table name
	$table_name = $wpdb->prefix . "revslider_sliders";

	// Get sliders
	$rev_sliders = $wpdb->get_results( "SELECT title,alias FROM $table_name" );

	// Iterate over the sliders
	foreach ( $rev_sliders as $key => $item ) {
		if ( isset( $item->alias ) && isset( $item->title ) ) {
			$revslider_options[ $item->alias ] = $item->title;
		}
	}
}

/*--------------------------------------------------------------------------------------------------
Get REVOLUTION SLIDER SLIDES
--------------------------------------------------------------------------------------------------*/
$cuteslider_options = array ();
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'CuteSlider/cuteslider.php' ) ) {
	$cuteslider_options = array ();
	// Table name
	$table_name = $wpdb->prefix . "cuteslider";

	// Get sliders
	$cute_sliders = $wpdb->get_results( "SELECT * FROM $table_name
										WHERE flag_hidden = '0' AND flag_deleted = '0'
										ORDER BY date_c ASC LIMIT 100" );
	// Iterate over the sliders
	foreach ( $cute_sliders as $key => $item ) {
		if ( isset( $item->id ) && isset( $item->name ) ) {
			$cuteslider_options[ $item->id ] = $item->name;
		}
	}
}

/*--------------------------------------------------------------------------------------------------
Get all dynamic headers
--------------------------------------------------------------------------------------------------*/
$header_option                        = array ();
$header_option['zn_def_header_style'] = __( 'Default style', THEMENAME );
if ( isset ( $data['header_generator'] ) && is_array( $data['header_generator'] ) ) {
	foreach ( $data['header_generator'] as $header ) {
		if ( isset ( $header['uh_style_name'] ) && ! empty ( $header['uh_style_name'] ) ) {
			$header_name                   = strtolower( str_replace( ' ', '_', $header['uh_style_name'] ) );
			$header_option[ $header_name ] = $header['uh_style_name'];
		}
	}
}

/*--------------------------------------------------------------------------------------------------
WOO IMAGE GALLERY
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"link_to"     => "woo_image_gallery",
	"name"        => __( "Image Gallery", THEMENAME ),
	"description" => __( "Please select more images for this product. Please note that prior to this you will need to select a featured image that will be used as the main image for this product", THEMENAME ),
	"id"          => "woo_image_gallery",
	"std"         => '',
	"type"        => "group",
	"add_text"    => "Image",
	"remove_text" => "Image",
	"subelements" => array (
		array (
			"name"        => "Image",
			"description" => __( "Please select an image.", THEMENAME ),
			"id"          => "woo_single_image",
			"std"         => "",
			"type"        => "media"
		),

	)
);


/*--------------------------------------------------------------------------------------------------
Get Blog Categories
--------------------------------------------------------------------------------------------------*/
$args            = array (
	'type'         => 'post',
	'child_of'     => 0,
	'parent'       => '',
	'orderby'      => 'id',
	'order'        => 'ASC',
	'hide_empty'   => 1,
	'hierarchical' => 1,
	'taxonomy'     => 'category',
	'pad_counts'   => false
);
$blog_categories = get_categories( $args );

$option_blog_cat = array ();
foreach ( $blog_categories as $category ) {
	$option_blog_cat[ $category->cat_ID ] = $category->cat_name;
}

/*--------------------------------------------------------------------------------------------------
Get Portfolio categories
--------------------------------------------------------------------------------------------------*/
$args = array (
	'type'         => 'portfolio',
	'child_of'     => 0,
	'parent'       => '',
	'orderby'      => 'id',
	'order'        => 'ASC',
	'hide_empty'   => 1,
	'hierarchical' => 1,
	'taxonomy'     => 'project_category',
	'pad_counts'   => false
);

$port_categories = get_categories( $args );

$option_port_cat = array ();
if ( ! empty( $port_categories ) ) {
	foreach ( $port_categories as $category ) {
		if ( isset( $category->cat_ID ) && isset( $category->cat_name ) ) {
			$option_port_cat[ $category->cat_ID ] = $category->cat_name;
		}
	}
}

//@since v3.6.8
//@see: Latest Posts Category
$wpkPostCategories = get_categories();
if(! empty($wpkPostCategories)){
    $tmp = array();
    foreach($wpkPostCategories as $category){
        if ( isset( $category->cat_ID ) && isset( $category->cat_name ) ) {
            $tmp[ $category->cat_ID ] = $category->cat_name;
        }
    }
    $wpkPostCategories = $tmp;
    unset($tmp);
}


/*--------------------------------------------------------------------------------------------------
Get Shop categories
--------------------------------------------------------------------------------------------------*/
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	$args = array (
		'type'         => 'shop',
		'child_of'     => 0,
		'parent'       => '',
		'orderby'      => 'id',
		'order'        => 'ASC',
		'hide_empty'   => 1,
		'hierarchical' => 1,
		'taxonomy'     => 'product_cat',
		'pad_counts'   => false
	);

	$shop_categories = get_categories( $args );

	$option_shop_cat = array ();
	if ( ! empty( $shop_categories ) ) {
		foreach ( $shop_categories as $category ) {
			if ( isset( $category->cat_ID ) && isset( $category->cat_name ) ) {
				$option_shop_cat[ $category->cat_ID ] = $category->cat_name;
			}
		}
	}
}
else {
	$option_shop_cat = array ();
}

/*--------------------------------------------------------------------------------------------------
//
//
//	Portfolio Area options
//	
//	
--------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Event Countdown
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_options",
	"name"        => __( "Project Link", THEMENAME ),
	"description" => __( "Please choose the url for this project", THEMENAME ),
	"id"          => "sp_link",
	"std"         => "",
	"type"        => "link",
	"options"     => array ( '_blank' => __( "New window", THEMENAME ), '_self' => __( "Same window", THEMENAME ) )
);

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_options",
	"name"        => __( "Collaborators", THEMENAME ),
	"description" => __( "Please enter the collaborators for this project", THEMENAME ),
	"id"          => "sp_col",
	"std"         => "",
	"type"        => "text"
);

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_options",
	"name"        => __( "Show social icons?", THEMENAME ),
	"description" => __( "Select yes if you want to show the social share icons or no if you want to
					 hide them.", THEMENAME ),
	"id"          => "sp_show_social",
	"std"         => "yes",
	"options"     => array ( "yes" => __( "Yes", THEMENAME ), "no" => __( "No", THEMENAME ) ),
	"type"        => "zn_radio"
);

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_options",
	"name"        => __( "Portfolio Item Media", THEMENAME ),
	"description" => __( "Portfolio Item Media", THEMENAME ),
	"id"          => "port_media",
	"std"         => '',
	"type"        => "group",
	"use_name"    => "port_med_name",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"subelements" => array (
		array (
			"name"        => __( "Media Name", THEMENAME ),
			"description" => __( "Here you can enter a name for this image/video. It will only appear in the edit page.", THEMENAME ),
			"id"          => "port_med_name",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Select image", THEMENAME ),
			"description" => __( "Select the desired image that you want to use.", THEMENAME ),
			"id"          => "port_media_image_comb",
			"std"         => "",
			"type"        => "media",
			"alt"         => true,
			"class"       => "port_media_type-combined"
		),
		array (
			"name"        => __( "Video URL", THEMENAME ),
			"description" => __( "Please enter the Youtube or Vimeo URL for your
											video.", THEMENAME ),
			"id"          => "port_media_video_comb",
			"std"         => "",
			"type"        => "text",
			"class"       => "port_media_type-combined"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
//
//
//	DEFAULT PAGE BUILDER ELEMENTS
//	
//	
--------------------------------------------------------------------------------------------------*/


	$__znDefaultElements = array(
		'_image_box'           => __( 'Image Box', THEMENAME ),
		'_image_box2'          => __( 'Images Box', THEMENAME ),
		'_service_box'         => __( 'Service Box', THEMENAME ),
		'_service_box2'        => __( 'Services Element', THEMENAME ),
		'_recent_work'         => __( 'Recent Work', THEMENAME ),
		'_recent_work2'        => __( 'Recent Work 2', THEMENAME ),
		'_call_banner'         => __( 'Call Out Banner', THEMENAME ),
		'_features_element'    => __( 'Features Element', THEMENAME ),
		'_features_element2'   => __( 'Features Element 2', THEMENAME ),
		'_latest_posts'        => __( 'Latest Posts', THEMENAME ),
		'_latest_posts2'       => __( 'Latest Posts 2', THEMENAME ),
		'_latest_posts3'       => __( 'Latest Posts 3', THEMENAME ),
		'_latest_posts4'       => __( 'Latest Posts 4', THEMENAME ),
		'_accordion'           => __( 'Accordion', THEMENAME ),
		'_testimonial_box'     => __( 'Testimonial Box', THEMENAME ),
		'_testimonial_slider'  => __( 'Testimonials Fader', THEMENAME ),
		'_testimonial_slider2' => __( 'Testimonials Slider', THEMENAME ),
		'_step_box'            => __( 'Steps Box', THEMENAME ),
		'_step_box2'           => __( 'Steps Box 2', THEMENAME ),
		'_step_box3'           => __( 'Steps Box 3', THEMENAME ),
		'_partners_logos'      => __( 'Partners Logos', THEMENAME ),
		'_keyword'             => __( 'Keywords Element', THEMENAME ),
		'_infobox'             => __( 'Info Box', THEMENAME ),
		'_infobox2'            => __( 'Info Box 2', THEMENAME ),
		'_flickrfeed'          => __( 'Flickr Feed', THEMENAME ),
		'_circle_title_box'    => __( 'Circle Title Text Box', THEMENAME ),
		'_text_box'            => __( 'Text Box', THEMENAME ),
		'_screenshoot_box'     => __( 'Screenshots Box', THEMENAME ),
		'_hover_box'           => __( 'Hover Box', THEMENAME ),
		'_vertical_tabs'       => __( 'Vertical Tabs', THEMENAME ),
		'_tabs'                => __( 'Horizontal Tabs', THEMENAME ),
		'_stats_box'           => __( 'Stats Box', THEMENAME ),
		'_c_form'              => __( 'Contact Form', THEMENAME ),
		'_historic'            => __( 'Historic Element', THEMENAME ),
		'_team_box'            => __( 'Team Box', THEMENAME ),
		'_image_gallery'       => __( 'Image Gallery', THEMENAME ),
		'_woo_products'        => __( 'Shop Products Presentation', THEMENAME ),
		'_woo_limited'         => __( 'Shop Limited Offers', THEMENAME ),
		'_shop_features'       => __( 'Shop Features', THEMENAME ),
		'_video_box'           => __( 'Video Box', THEMENAME ),
		'_portfolio_category'  => __( 'Portfolio Category', THEMENAME ),
		'_portfolio_sortable'  => __( 'Portfolio Sortable', THEMENAME ),
		'_portfolio_carousel'  => __( 'Portfolio Carousel Layout', THEMENAME ),
		'_photo_gallery'       => __( 'Photo Gallery', THEMENAME ),
		'_content_sidebar'     => __( 'Content and Sidebar', THEMENAME ),
		'_zn_documentation'    => __( 'Documentation', THEMENAME ),
		'_zn_sidebar'          => __( 'Sidebar', THEMENAME ),
		'_pb_spacer_element'   => __( 'Spacer Element', THEMENAME ),
        //@since v3.6.8
		'_wpk_latest_posts_carousel'   => __( 'Latest Posts Carousel', THEMENAME ),
	);




/*--------------------------------------------------------------------------------------------------
Header Area Modules
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"link_to"     => "page_builder",
	"name"        => __( "Header Area Options", THEMENAME ),
	"description" => "",
	"id"          => "page_builder",
	"std"         => "",
	"type"        => "zn_dynamic_list",
	"add_text"    => "",
	"remove_text" => "",
	"options"     => array (
		"header_area"         => array (
			"area_name"    => "Header Area",
			"limit"        => 1,
			"area_options" => array (
				'_header_module'    => __( 'Custom Header Layout', THEMENAME ),
				'_iosSlider'        => __( 'iOS Slider', THEMENAME ),
				'_flexslider'       => __( 'Flex Slider', THEMENAME ),
				'_nivoslider'       => __( 'Nivo Slider', THEMENAME ),
				'_wowslider'        => __( 'Wow Slider', THEMENAME ),
				'_fancyslider'      => __( 'Fancy Slider', THEMENAME ),
				'_circ1'            => __( 'Circular Content Style 1', THEMENAME ),
				'_circ2'            => __( 'Circular Content Style 2', THEMENAME ),
				'_static1'          => __( 'STATIC CONTENT - Default', THEMENAME ),
				'_static2'          => __( 'STATIC CONTENT - Boxes', THEMENAME ),
				'_static3'          => __( 'STATIC CONTENT - Video', THEMENAME ),
				'_static4'          => __( 'STATIC CONTENT - Maps', THEMENAME ),
				'_static4_multiple' => __( 'STATIC CONTENT - Maps multiple locations', THEMENAME ),
				'_static5'          => __( 'STATIC CONTENT - Text Pop', THEMENAME ),
				'_static6'          => __( 'STATIC CONTENT - Product Loupe', THEMENAME ),
				'_static7'          => __( 'STATIC CONTENT - Event Countdown', THEMENAME ),
				'_static8'          => __( 'STATIC CONTENT - Video Background', THEMENAME ),
				'_static9'          => __( 'STATIC CONTENT - Simple Text', THEMENAME ),
				'_static10'         => __( 'STATIC CONTENT - Text and Register', THEMENAME ),
				'_static11'         => __( 'STATIC CONTENT - Text and Video', THEMENAME ),
				'_static12'         => __( 'STATIC CONTENT - Simple Text ( full width )', THEMENAME ),
				'_css_pannel'       => __( 'CSS3 Panels', THEMENAME ),
				'_icarousel'        => __( 'iCarousel', THEMENAME ),
				'_lslider'          => __( 'Laptop Slider', THEMENAME ),
				'_pslider'          => __( 'Portfolio Slider', THEMENAME ),
				'_cute_slider'      => __( '3d Cute Slider', THEMENAME ),
				'_rev_slider'       => __( 'Revolution Slider', THEMENAME ),
				'_zn_doc_header'    => __( 'Documentation Header', THEMENAME ),
			)
		),
		"action_box_area"     => array (
			"area_name"    => __( "Action Box Area", THEMENAME ),
			"limit"        => 1,
			"area_options" => array (
				'_action_box'      => __( 'Action Box', THEMENAME ),
				'_action_box_text' => __( 'Action Box Text', THEMENAME ),
			)
		),
		"content_main_area"   => array (
			"area_name"    => __( "Content Main Area", THEMENAME ),
			"limit"        => __( '999', THEMENAME ),
			"area_options" => $__znDefaultElements,
		),
		"content_grey_area"   => array (
			"area_name"    => __( "Content Grey Area", THEMENAME ),
			"limit"        => __( '999', THEMENAME ),
			"area_options" => $__znDefaultElements,
		),
		"content_bottom_area" => array (
			"area_name"    => __( "Content Bottom Area", THEMENAME ),
			"limit"        => __( '999', THEMENAME ),
			"area_options" => $__znDefaultElements,
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Content and Sidebar
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Content and Sidebar", THEMENAME ),
	"description" => __( "Content and Sidebar", THEMENAME ),
	"id"          => "_content_sidebar",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Content", THEMENAME ),
	"remove_text" => __( "Content", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name" => __( "Sizer Hidden Option", THEMENAME ),
			"desc" => __( "This element has no options. Using this element, the editor content along with the page selected sidebar will be placed in this location rather than on top of the page builder elements.", THEMENAME ),
			"id"   => "_sizer",
			"std"  => "sixteen",
			"type" => "description"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Sidebar
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Sidebar", THEMENAME ),
	"description" => __( "Sidebar", THEMENAME ),
	"id"          => "_zn_sidebar",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Sidebar", THEMENAME ),
	"remove_text" => __( "Sidebar", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => __( "four", THEMENAME ),
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Select sidebar", THEMENAME ),
			"description" => __( "Select your desired sidebar to be used on this
											post", THEMENAME ),
			"id"          => "sidebar_select",
			"std"         => "",
			"type"        => "select",
			"options"     => $sidebar_option
		),
		array (
			"name"        => __( "Show background ?", THEMENAME ),
			"description" => __( "Select yes if you want to show the default sidebar
											 background or no to use a transparent background.", THEMENAME ),
			"id"          => "sidebar_bg",
			"std"         => "yes",
			"type"        => "select",
			"options"     => array ( 'yes' => __( 'Yes', THEMENAME ), 'no' => __( 'No', THEMENAME ) )
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Spacer Element
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Spacer Element", THEMENAME ),
	"description" => __( "Spacer Element", THEMENAME ),
	"id"          => "_pb_spacer_element",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => __( "four", THEMENAME ),
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Set height", THEMENAME ),
			"description" => __( "Set the height, in pixels, for this element", THEMENAME ),
			"id"          => "spacer_height",
			"std"         => "30",
			"type"        => "text",
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Photo Gallery
--------------------------------------------------------------------------------------------------*/
// Single Photo Gallery
$extra_options['single_photo_gallery'] = array (
	"name"           => __( "Images", THEMENAME ),
	"description"    => __( "Here you can add your desired images.", THEMENAME ),
	"id"             => "single_photo_gallery",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Image", THEMENAME ),
	"remove_text"    => __( "Image", THEMENAME ),
	"group_title"    => "",
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title for this image.", THEMENAME ),
			"id"          => "spg_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Image", THEMENAME ),
			"description" => __( "Please select an image.", THEMENAME ),
			"id"          => "spg_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Video URL", THEMENAME ),
			"description" => __( "Please enter the URL for your video.", THEMENAME ),
			"id"          => "spg_video",
			"std"         => "",
			"type"        => "text"
		),

	)
);
$zn_meta_elements[] = array (
	"name"        => __( "Photo Gallery", THEMENAME ),
	"description" => __( "Photo Gallery", THEMENAME ),
	"id"          => "_photo_gallery",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Image", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (

		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Number of columns", THEMENAME ),
			"description" => __( "Select the desired number of columns for the
											images.", THEMENAME ),
			"id"          => "pg_num_cols",
			"std"         => __( "6", THEMENAME ),
			"type"        => "select",
			"options"     => array (
				'1' => __( '1', THEMENAME ),
				'2' => __( '2', THEMENAME ),
				'3' => __( '3', THEMENAME ),
				'4' => __( '4', THEMENAME ),
				'6' => __( '6', THEMENAME )
			)
		),
		array (
			"name"        => __( "Images Height", THEMENAME ),
			"description" => __( "Select the desired image height in pixels.", THEMENAME ),
			"id"          => "pg_img_height",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['single_photo_gallery']
	)
);

/*--------------------------------------------------------------------------------------------------
3D Cute Slider
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "3D Cute Slider", THEMENAME ),
	"description" => __( "3D Cute Slider", THEMENAME ),
	"id"          => "_cute_slider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Select slider", THEMENAME ),
			"description" => __( "Select the desired slider you want to use. Please note that the slider can be created from inside the Cute Slider option.", THEMENAME ),
			"id"          => "cuteslider_id",
			"std"         => "",
			"type"        => "select",
			"options"     => $cuteslider_options
		)
	)
);

/*--------------------------------------------------------------------------------------------------
REVOLUTION Slider
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Revolution Slider", THEMENAME ),
	"description" => __( "Revolution Slider", THEMENAME ),
	"id"          => "_rev_slider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Select slider", THEMENAME ),
			"description" => __( "Select the desired slider you want to use. Please note that the slider can be created from inside the Revolution Slider options page.", THEMENAME ),
			"id"          => "revslider_id",
			"std"         => "",
			"type"        => "select",
			"options"     => $revslider_options
		),
		array (
			"name"        => __( "Use Paralax effect", THEMENAME ),
			"description" => __( "Select yes if you have used the paralax classes
											when you created your slider.", THEMENAME ),
			"id"          => "revslider_paralax",
			"std"         => "0",
			"type"        => "select",
			"options"     => array ( 0 => __( 'No', THEMENAME ), 1 => __( 'Yes', THEMENAME ) )
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Video Box
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Video Box", THEMENAME ),
	"description" => __( "Video Box", THEMENAME ),
	"id"          => "_video_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Video URL", THEMENAME ),
			"description" => __( "Please enter a link to your desired video (
											Youtube and Vimeo ).", THEMENAME ),
			"id"          => "vb_video_url",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Image", THEMENAME ),
			"description" => __( "Please select an image that you want to display.If
											 no image is selected, the video will be shown directly.", THEMENAME ),
			"id"          => "vb_video_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Video title", THEMENAME ),
			"description" => __( "Please enter a title that will appear over the
											play icon. This will only be shown if you select an image.", THEMENAME ),
			"id"          => "vb_video_title",
			"std"         => "",
			"type"        => "text"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Service Box
--------------------------------------------------------------------------------------------------*/
// Single Service
$extra_options['single_service_elem'] = array (
	"name"           => __( "Services", THEMENAME ),
	"description"    => __( "Here you can add your desired service boxes.", THEMENAME ),
	"id"             => "single_service_elem",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Box", THEMENAME ),
	"remove_text"    => __( "Box", THEMENAME ),
	"group_title"    => "",
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Service title", THEMENAME ),
			"description" => __( "Please enter a title for this service box.", THEMENAME ),
			"id"          => "sbe_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Service Content", THEMENAME ),
			"description" => __( "Please enter a content for this service box.", THEMENAME ),
			"id"          => "sbe_content",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Sub Services", THEMENAME ),
			"description" => __( "Please enter your secondary services one on a
												line. These will appear when someone hovers over the service box
												.", THEMENAME ),
			"id"          => "sbe_services",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Title Icon", THEMENAME ),
			"description" => __( "Please select an icon that will appear on the
												left of the title.", THEMENAME ),
			"id"          => "sbe_image",
			"std"         => "",
			"type"        => "media"
		)
	)
);
$zn_meta_elements[] = array (
	"name"        => __( "Services Element", THEMENAME ),
	"description" => __( "Services Element", THEMENAME ),
	"id"          => "_service_box2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		$extra_options['single_service_elem']
	)
);

/*--------------------------------------------------------------------------------------------------
Image Gallery
--------------------------------------------------------------------------------------------------*/
// Single image gallery group
$extra_options['single_image_gallery'] = array (
	"name"           => __( "Images", THEMENAME ),
	"description"    => __( "Here you can add your desired images.", THEMENAME ),
	"id"             => "single_ig",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Image", THEMENAME ),
	"remove_text"    => __( "Image", THEMENAME ),
	"group_title"    => "",
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Image", THEMENAME ),
			"description" => __( "Please select an image.", THEMENAME ),
			"id"          => "sig_image",
			"std"         => "",
			"type"        => "media"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Image Gallery", THEMENAME ),
	"description" => __( "Image Gallery", THEMENAME ),
	"id"          => "_image_gallery",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Name", THEMENAME ),
			"description" => __( "Please enter a name for this team member", THEMENAME ),
			"id"          => "ig_title",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['single_image_gallery']
	)
);

/*--------------------------------------------------------------------------------------------------
Team Box
--------------------------------------------------------------------------------------------------*/
// team group
$extra_options['teb_single_social'] = array (
	"name"           => __( "Social Icons", THEMENAME ),
	"description"    => __( "Here you can add your desired social icons.", THEMENAME ),
	"id"             => "single_team_social",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Icon", THEMENAME ),
	"remove_text"    => __( "Icon", THEMENAME ),
	"group_title"    => "",
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Icon title", THEMENAME ),
			"description" => __( "Here you can enter a title for this social icon.Please note that this is just for your information as this text will not be visible on the site.", THEMENAME ),
			"id"          => "teb_social_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Social icon link", THEMENAME ),
			"description" => __( "Please enter your desired link for the social
												icon. If this field is left blank, the icon will not be linked.", THEMENAME ),
			"id"          => "teb_social_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Social icon", THEMENAME ),
			"description" => __( "Select your desired social icon.", THEMENAME ),
			"id"          => "teb_social_icon",
			"std"         => "",
			"options"     => $all_icon_sets,
			"type"        => "zn_icon_font"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Team Box", THEMENAME ),
	"description" => __( "Team Box", THEMENAME ),
	"id"          => "_team_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Name", THEMENAME ),
			"description" => __( "Please enter a name for this team member", THEMENAME ),
			"id"          => "teb_name",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Position", THEMENAME ),
			"description" => __( "Please enter a position for this team member", THEMENAME ),
			"id"          => "teb_position",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Description", THEMENAME ),
			"description" => __( "Please enter a description for this team member", THEMENAME ),
			"id"          => "teb_desc",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Member image", THEMENAME ),
			"description" => __( "Please select an image for this team member", THEMENAME ),
			"id"          => "teb_image",
			"std"         => "",
			"type"        => "media",
			"alt"         => true
		),
		array (
			"name"        => __( "Image link", THEMENAME ),
			"description" => __( "Please choose the link you want to use for the
											image.", THEMENAME ),
			"id"          => "teb_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
		$extra_options['teb_single_social']
	)
);

/*--------------------------------------------------------------------------------------------------
Historic
--------------------------------------------------------------------------------------------------*/
// Tabs group
$extra_options['historic_single'] = array (
	"name"           => __( "Events", THEMENAME ),
	"description"    => __( "Here you can add your desired events.", THEMENAME ),
	"id"             => "historic_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Event", THEMENAME ),
	"remove_text"    => __( "Event", THEMENAME ),
	"group_title"    => "",
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Event title", THEMENAME ),
			"description" => __( "Please enter a title for this event", THEMENAME ),
			"id"          => "she_event_name",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Event date", THEMENAME ),
			"description" => __( "Please enter the date for this event", THEMENAME ),
			"id"          => "she_event_date",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Event description", THEMENAME ),
			"description" => __( "Please enter a description for this event", THEMENAME ),
			"id"          => "she_event_desc",
			"std"         => "",
			"type"        => "textarea"
		),
	)
);
$zn_meta_elements[] = array (
	"name"        => __( "Historic Element", THEMENAME ),
	"description" => __( "Historic Element", THEMENAME ),
	"id"          => "_historic",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Start text", THEMENAME ),
			"description" => __( "Please enter a text that will appear as a start", THEMENAME ),
			"id"          => "he_start",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['historic_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Contact form element
--------------------------------------------------------------------------------------------------*/
// Tabs group
$extra_options['c_form'] = array (
	"name"           => __( "Fields", THEMENAME ),
	"description"    => __( "Here you can add your accordions.", THEMENAME ),
	"id"             => "zn_cf_fields",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Field", THEMENAME ),
	"remove_text"    => __( "Field", THEMENAME ),
	"group_title"    => "",
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Field Type", THEMENAME ),
			"description" => __( "Here you can select what type of field will be
												 displayed.", THEMENAME ),
			"id"          => "zn_cf_type",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				'text'     => __( 'Text', THEMENAME ),
				'textarea' => __( 'Textarea', THEMENAME ),
				'captcha'  => __( 'Captcha', THEMENAME )
			)
		),
		array (
			"name"        => __( "Field name", THEMENAME ),
			"description" => __( "Here you can enter the desired name for the
												this field", THEMENAME ),
			"id"          => "zn_cf_name",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Field Required ?", THEMENAME ),
			"description" => "Select if you want your field to be required.",
			"id"          => "zn_cf_required",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				true  => __( 'Yes', THEMENAME ),
				false => __( 'No', THEMENAME )
			)
		),
		array (
			"name"        => __( "Email Field?", THEMENAME ),
			"description" => __( "Select yes if this is the email field.Will be
												used as the reply to option when receiving a submission email.", THEMENAME ),
			"id"          => "zn_cf_f_email",
			"std"         => "false",
			"type"        => "select",
			"options"     => array (
				false => __( 'No', THEMENAME ),
				true  => __( 'Yes', THEMENAME )
			)
		),
		array (
			"name"        => __( "Name Field?", THEMENAME ),
			"description" => __( "Select yes if this will be the visitor's name
												field.Will be used as the reply to option when receiving a submission email.", THEMENAME ),
			"id"          => "zn_cf_f_name",
			"std"         => "false",
			"type"        => "select",
			"options"     => array (
				false => __( 'No', THEMENAME ),
				true  => __( 'Yes', THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (
	"link_to"     => "content_area",
	"name"        => __( "Contact Form", THEMENAME ),
	"description" => __( "Contact Form element", THEMENAME ),
	"id"          => "_c_form",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Field", THEMENAME ),
	"remove_text" => __( "Field", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => "content_area",
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Email Address", THEMENAME ),
			"description" => __( "Please enter the email address where you want the
											contact form submissions to be sent", THEMENAME ),
			"id"          => "zn_cf_email_address",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Description", THEMENAME ),
			"description" => __( "Here you can enter a description that will appear
											above the form.", THEMENAME ),
			"id"          => "zn_cf_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Submit Button Text", THEMENAME ),
			"description" => __( "Here you can enter the desired text that will
											appear on the submit button", THEMENAME ),
			"id"          => "zn_cf_button_value",
			"std"         => __( "Send Message", THEMENAME ),
			"type"        => "text"
		),
		array (
			"name"        => __( "Email Subject Text", THEMENAME ),
			"description" => __( "Here you can enter the desired subject text that
											will appear when receiving a mail from this form", THEMENAME ),
			"id"          => "zn_cf_button_subject",
			"std"         => __( "New Contact Form submission", THEMENAME ),
			"type"        => "text"
		),
		$extra_options['c_form']

	)
);

/*--------------------------------------------------------------------------------------------------
Stats Box
--------------------------------------------------------------------------------------------------*/
// STATS SINGLE
$extra_options['stats_single'] = array (
	"name"           => __( "Stats Boxes", THEMENAME ),
	"description"    => __( "Here you can add your desired stats boxes.", THEMENAME ),
	"id"             => "single_stats",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Stat Box", THEMENAME ),
	"remove_text"    => __( "Stat Box", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the desired title that will
												appear on the right of the icon.", THEMENAME ),
			"id"          => "sb_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Content", THEMENAME ),
			"description" => __( "Please enter the desired title that will
												appear bellow the icon/Title.", THEMENAME ),
			"id"          => "sb_content",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Icon", THEMENAME ),
			"description" => __( "Please select an icon that will appear on the
												left side of the title.", THEMENAME ),
			"id"          => "sb_icon",
			"std"         => "",
			"type"        => "media"
		)
	)
);
$zn_meta_elements[] = array (
	"name"        => __( "Stats Box", THEMENAME ),
	"description" => __( "Stats Box", THEMENAME ),
	"id"          => "_stats_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,eight,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the title for this box", THEMENAME ),
			"id"          => "stb_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Tab icon", THEMENAME ),
			"description" => __( "Select your desired icon that will appear on the left side of the title.", THEMENAME ),
			"id"          => "vts_tab_icon",
			"std"         => "",
			"options"     => $bootstrap_icons,
			"type"        => "zn_icon_font",
			""
		),
		$extra_options['stats_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Text Box
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Text Box", THEMENAME ),
	"description" => __( "Text Box", THEMENAME ),
	"id"          => "_text_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the title for this box", THEMENAME ),
			"id"          => "stb_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Content", THEMENAME ),
			"description" => __( "Please enter the box content", THEMENAME ),
			"id"          => "stb_content",
			"std"         => "",
			"type"        => "visual_editor",
		),
		array (
			"name"        => __( "Title style", THEMENAME ),
			"description" => __( "Select the desired style for the title of this
											box", THEMENAME ),
			"id"          => "stb_style",
			"type"        => "select",
			"std"         => "style1",
			"options"     => array (
				'style1' => __( 'Style 1', THEMENAME ),
				'style2' => __( 'Style 2', THEMENAME )
			),
		)
	)
);

/*--------------------------------------------------------------------------------------------------
HORIZONTAL TABS
--------------------------------------------------------------------------------------------------*/
// HORIZONTAL TABS SINGLE
$extra_options['hts_single'] = array (
	"name"           => __( "Tabs", THEMENAME ),
	"description"    => __( "Here you can add your desired tabs.", THEMENAME ),
	"id"             => "single_horizontal_tab",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Tab", THEMENAME ),
	"remove_text"    => __( "Tab", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Tab Title", THEMENAME ),
			"description" => __( "Please enter the desired title that will
												appear as tab.", THEMENAME ),
			"id"          => "vts_tab_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Tab Content Title", THEMENAME ),
			"description" => __( "Please enter the desired title that will
												appear inside the tab.", THEMENAME ),
			"id"          => "vts_tab_c_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Content", THEMENAME ),
			"description" => __( "Please enter the desired content for this
												tab.", THEMENAME ),
			"id"          => "vts_tab_c_content",
			"std"         => "",
			"type"        => "textarea"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Horizontal Tabs", THEMENAME ),
	"description" => __( "Horizontal Tabs", THEMENAME ),
	"id"          => "_tabs",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		$extra_options['hts_single']

	)
);

/*--------------------------------------------------------------------------------------------------
VERTICAL TABS
--------------------------------------------------------------------------------------------------*/
// VERTICAL TABS SINGLE
$extra_options['vts_single'] = array (
	"name"           => __( "Tabs", THEMENAME ),
	"description"    => __( "Here you can add your desired tabs.", THEMENAME ),
	"id"             => "single_vertical_tab",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Tab", THEMENAME ),
	"remove_text"    => __( "Tab", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Tab Title", THEMENAME ),
			"description" => __( "Please enter the desired title that will
												appear as tab.", THEMENAME ),
			"id"          => "vts_tab_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Tab icon", THEMENAME ),
			"description" => __( "Select your desired icon that will appear on
												the left side of the tab title.", THEMENAME ),
			"id"          => "vts_tab_icon",
			"std"         => "",
			"options"     => $bootstrap_icons,
			"type"        => "zn_icon_font",
			""
		),
		array (
			"name"        => __( "Tab Content Title", THEMENAME ),
			"description" => __( "Please enter the desired title that will
												appear inside the tab.", THEMENAME ),
			"id"          => "vts_tab_c_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Content", THEMENAME ),
			"description" => __( "Please enter the desired content for this
												tab.", THEMENAME ),
			"id"          => "vts_tab_c_content",
			"std"         => "",
			"type"        => "textarea"
		)
	)
);
$zn_meta_elements[] = array (
	"name"        => __( "Vertical Tabs", THEMENAME ),
	"description" => __( "Vertical Tabs", THEMENAME ),
	"id"          => "_vertical_tabs",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "eight",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		$extra_options['vts_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Hover Box
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Hover Box", THEMENAME ),
	"description" => __( "Hover Box", THEMENAME ),
	"id"          => "_hover_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title for this box.", THEMENAME ),
			"id"          => "hb_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Subtitle", THEMENAME ),
			"description" => __( "Please enter a subtitle for this box.", THEMENAME ),
			"id"          => "hb_subtitle",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Description", THEMENAME ),
			"description" => __( "Please enter a description for this box.", THEMENAME ),
			"id"          => "hb_desc",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Content Style", THEMENAME ),
			"description" => __( "Select the desired alignment for the content", THEMENAME ),
			"id"          => "hb_align",
			"type"        => "select",
			"std"         => "style1",
			"options"     => array (
				'zn_fill_class' => __( 'Normal', THEMENAME ),
				'centered'      => __( 'Centered', THEMENAME )
			),
		),
		array (
			"name"        => __( "Icon", THEMENAME ),
			"description" => __( "Please select an icon for this box.", THEMENAME ),
			"id"          => "hb_icon",
			"std"         => "",
			"type"        => "media",
		),
		array (
			"name"        => __( "Box Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use.", THEMENAME ),
			"id"          => "hb_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Screenshots Box
--------------------------------------------------------------------------------------------------*/
// FEATURES SINGLE
$extra_options['ssb_feat_single'] = array (
	"name"           => __( "Features", THEMENAME ),
	"description"    => __( "Here you can add your desired features.", THEMENAME ),
	"id"             => "ssb_feat_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Feature", THEMENAME ),
	"remove_text"    => __( "Feature", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the desired title for this
												feature.", THEMENAME ),
			"id"          => "ssb_single_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Description", THEMENAME ),
			"description" => __( "Please enter the desired description for this
												feature.", THEMENAME ),
			"id"          => "ssb_single_desc",
			"std"         => "",
			"type"        => "textarea"
		)
	)
);

// IMAGES SINGLE
$extra_options['ssb_imag_single'] = array (
	"name"           => __( "Images", THEMENAME ),
	"description"    => __( "Here you can add your screenshots images.", THEMENAME ),
	"id"             => "ssb_imag_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Image", THEMENAME ),
	"remove_text"    => __( "Image", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Image", THEMENAME ),
			"description" => __( "Please choose your desired screenshot.", THEMENAME ),
			"id"          => "ssb_single_screenshoot",
			"std"         => "",
			"type"        => "media"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Screenshots Box", THEMENAME ),
	"description" => __( "Screenshots Box", THEMENAME ),
	"id"          => "_screenshoot_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter title for this box.", THEMENAME ),
			"id"          => "ssb_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear as a button
											link.", THEMENAME ),
			"id"          => "ssb_link_text",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Button Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use.", THEMENAME ),
			"id"          => "ssb_button_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
		$extra_options['ssb_feat_single'],
		$extra_options['ssb_imag_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Circle Title Text Box
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Circle Title Text Box", THEMENAME ),
	"description" => __( "Circle Title Text Box", THEMENAME ),
	"id"          => "_circle_title_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Circle Text Title", THEMENAME ),
			"description" => __( "Please enter a small word that will appear on the
											left circle beside the main title.", THEMENAME ),
			"id"          => "ctb_circle_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Main Title", THEMENAME ),
			"description" => __( "Please enter a main title for this box.", THEMENAME ),
			"id"          => "ctb_main_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Content", THEMENAME ),
			"description" => __( "Please enter a content for this box.", THEMENAME ),
			"id"          => "ctb_content",
			"std"         => "",
			"type"        => "textarea",
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Flickr FEED
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Flickr Feed", THEMENAME ),
	"description" => __( "Flickr Feed", THEMENAME ),
	"id"          => "_flickrfeed",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title for this element", THEMENAME ),
			"id"          => "ff_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Flickr ID", THEMENAME ),
			"description" => __( "Please enter your Flickr ID", THEMENAME ),
			"id"          => "ff_id",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Image Size", THEMENAME ),
			"description" => __( "Select the desired image size for the Flickr
											images", THEMENAME ),
			"id"          => "ff_image_size",
			"type"        => "select",
			"std"         => "small",
			"options"     => array (
				'normal' => __( 'Normal', THEMENAME ),
				'small'  => __( 'Small', THEMENAME )
			),
		),
		array (
			"name"        => __( "Images to load", THEMENAME ),
			"description" => __( "Please enter the number of images that you want to
											 display", THEMENAME ),
			"id"          => "ff_images",
			"std"         => "6",
			"type"        => "text",
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Testimonial Slider
--------------------------------------------------------------------------------------------------*/
// TESTIMONIALS SINGLE
$extra_options['tfs_single'] = array (
	"name"           => __( "Testimonials", THEMENAME ),
	"description"    => __( "Here you can add your testimonials.", THEMENAME ),
	"id"             => "testimonials_slider_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Testimonial", THEMENAME ),
	"remove_text"    => __( "Testimonial", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Testimonial", THEMENAME ),
			"description" => __( "Please enter the desired testimonial.", THEMENAME ),
			"id"          => "tf_single_test",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Testimonial author", THEMENAME ),
			"description" => __( "Please enter the desired author for this
												testimonial.", THEMENAME ),
			"id"          => "tf_single_author",
			"std"         => "",
			"type"        => "text"
		)
	)
);
$zn_meta_elements[]          = array (
	"name"        => __( "Testimonial Slider", THEMENAME ),
	"description" => __( "Testimonial Slider", THEMENAME ),
	"id"          => "_testimonial_slider2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the Testimonials Fader title", THEMENAME ),
			"id"          => "tf_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Transition Speed", THEMENAME ),
			"description" => __( "Please enter a numeric value for the transition
											speed. Default is 2500", THEMENAME ),
			"id"          => "tf_speed",
			"std"         => "2500",
			"type"        => "text",
		),
		$extra_options['tfs_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Testimonial Fader
--------------------------------------------------------------------------------------------------*/
// TESTIMONIALS SINGLE
$extra_options['tf_single'] = array (
	"name"           => __( "Testimonials", THEMENAME ),
	"description"    => __( "Here you can add your testimonials.", THEMENAME ),
	"id"             => "testimonials_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Testimonial", THEMENAME ),
	"remove_text"    => __( "Testimonial", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Testimonial", THEMENAME ),
			"description" => __( "Please enter the desired testimonial.", THEMENAME ),
			"id"          => "tf_single_test",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Testimonial author", THEMENAME ),
			"description" => __( "Please enter the desired author for this
												testimonial.", THEMENAME ),
			"id"          => "tf_single_author",
			"std"         => "",
			"type"        => "text"
		)
	)
);
$zn_meta_elements[]         = array (
	"name"        => __( "Testimonial Fader", THEMENAME ),
	"description" => __( "Testimonial Fader", THEMENAME ),
	"id"          => "_testimonial_slider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the Testimonials Fader title", THEMENAME ),
			"id"          => "tf_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Description", THEMENAME ),
			"description" => __( "Please enter a description for this element", THEMENAME ),
			"id"          => "tf_desc",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Transition Speed", THEMENAME ),
			"description" => __( "Please enter a numeric value for the transition
											speed. Default is 5000", THEMENAME ),
			"id"          => "tf_speed",
			"std"         => "5000",
			"type"        => "text",
		),
		$extra_options['tf_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Info Box 2
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Info Box 2", THEMENAME ),
	"description" => __( "Info Box 2", THEMENAME ),
	"id"          => "_infobox2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Content", THEMENAME ),
			"description" => __( "Please enter the content for this box", THEMENAME ),
			"id"          => "ib2_title",
			"std"         => "",
			"type"        => "textarea",
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Info Box
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Info Box", THEMENAME ),
	"description" => __( "Info Box", THEMENAME ),
	"id"          => "_infobox",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the Info Box title", THEMENAME ),
			"id"          => "ib_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Subitle", THEMENAME ),
			"description" => __( "Please enter the Info Box subtitle", THEMENAME ),
			"id"          => "ib_subtitle",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Select Style", THEMENAME ),
			"description" => __( "Select the desired style for this element", THEMENAME ),
			"id"          => "ib_style",
			"type"        => "select",
			"std"         => "style1",
			"options"     => array (
				'infobox1' => __( 'Style 1', THEMENAME ),
				'infobox2' => __( 'Style 2', THEMENAME )
			),
		),
		array (
			"name"        => __( "Button Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear as button", THEMENAME ),
			"id"          => "ib_button_text",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Button Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use.", THEMENAME ),
			"id"          => "ib_button_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Keywords Element
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Keywords Element", THEMENAME ),
	"description" => __( "Keywords Element", THEMENAME ),
	"id"          => "_keyword",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Content", THEMENAME ),
			"description" => __( "Please enter the Keywords content", THEMENAME ),
			"id"          => "kw_content",
			"std"         => "",
			"type"        => "textarea",
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Partners Logos
--------------------------------------------------------------------------------------------------*/
// STEPS SINGLE
$extra_options['pl_single'] = array (
	"name"           => __( "Logos", THEMENAME ),
	"description"    => __( "Here you can add your partners logos.", THEMENAME ),
	"id"             => "partners_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Logo", THEMENAME ),
	"remove_text"    => __( "Logo", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Logo", THEMENAME ),
			"description" => __( "Please enter the logo for this partner.", THEMENAME ),
			"id"          => "lp_single_logo",
			"std"         => "",
			"type"        => "media",
			"alt"         => true
		),
		array (
			"name"        => __( "Logo Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use.", THEMENAME ),
			"id"          => "lp_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Partners Logos", THEMENAME ),
	"description" => __( "Partners Logos", THEMENAME ),
	"id"          => "_partners_logos",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "eight",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the title for this element.", THEMENAME ),
			"id"          => "pl_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Title Style", THEMENAME ),
			"description" => __( "Please select the style you want to use for this
											title.", THEMENAME ),
			"id"          => "pl_title_style",
			"std"         => "style1",
			"options"     => array (
				"style1" => __( "Style 1", THEMENAME ),
				"style2" => __( "Style 2", THEMENAME )
			),
			"type"        => "select"
		),
		$extra_options['pl_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Steps Box 3
--------------------------------------------------------------------------------------------------*/
// STEPS SINGLE
$extra_options['stp_single3'] = array (
	"name"           => __( "Steps", THEMENAME ),
	"description"    => __( "Here you can create your desired steps.", THEMENAME ),
	"id"             => "steps_single3",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Step", THEMENAME ),
	"remove_text"    => __( "Step", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Step content", THEMENAME ),
			"description" => __( "Please enter a content for this step.", THEMENAME ),
			"id"          => "stp_single_desc",
			"std"         => "",
			"type"        => "textarea"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Steps Box 3", THEMENAME ),
	"description" => __( "Steps Box 3", THEMENAME ),
	"id"          => "_step_box3",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title that will appear on over the
											boxes", THEMENAME ),
			"id"          => "stp_title",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['stp_single3']
	)
);

/*--------------------------------------------------------------------------------------------------
Steps Box
--------------------------------------------------------------------------------------------------*/
// STEPS SINGLE
$extra_options['stp_single2'] = array (
	"name"           => __( "Steps", THEMENAME ),
	"description"    => __( "Here you can create your desired steps.", THEMENAME ),
	"id"             => "steps_single2",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Step", THEMENAME ),
	"remove_text"    => __( "Step", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Step Title", THEMENAME ),
			"description" => __( "Please enter a title for this step.", THEMENAME ),
			"id"          => "stp_single_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Step content", THEMENAME ),
			"description" => __( "Please enter a content for this step.", THEMENAME ),
			"id"          => "stp_single_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Box Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use for
												this box.", THEMENAME ),
			"id"          => "stp_single_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Use alternative style?", THEMENAME ),
			"description" => __( "Select yes if you want your box to use a
												different background color and display an OK icon on the left", THEMENAME ),
			"id"          => "stp_single_ok",
			"type"        => "select",
			"std"         => "no",
			"options"     => array (
				'yes' => __( 'Yes', THEMENAME ),
				'no'  => __( 'No', THEMENAME )
			),
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Steps Box 2", THEMENAME ),
	"description" => __( "Steps Box 2", THEMENAME ),
	"id"          => "_step_box2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title that will appear on over the
											boxes", THEMENAME ),
			"id"          => "stp_title",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['stp_single2']
	)
);

/*--------------------------------------------------------------------------------------------------
Steps Box
--------------------------------------------------------------------------------------------------*/
// STEPS SINGLE
$extra_options['stp_single'] = array (
	"name"           => __( "Steps", THEMENAME ),
	"description"    => __( "Here you can create your desired Steps.", THEMENAME ),
	"id"             => "steps_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Step", THEMENAME ),
	"remove_text"    => __( "Step", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Step Title", THEMENAME ),
			"description" => __( "Please enter a title for this step.", THEMENAME ),
			"id"          => "stp_single_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Step content", THEMENAME ),
			"description" => __( "Please enter a content for this step.", THEMENAME ),
			"id"          => "stp_single_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Step icon", THEMENAME ),
			"description" => __( "Please enter an icon for this step.", THEMENAME ),
			"id"          => "stp_single_icon",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Step Icon Animation", THEMENAME ),
			"description" => __( "Select the desired animation for this step", THEMENAME ),
			"id"          => "stp_single_anim",
			"type"        => "select",
			"std"         => "tada",
			"options"     => array (
				'tada'            => __( 'Tada', THEMENAME ),
				'pulse'           => __( 'Pulse', THEMENAME ),
				'fadeOutRightBig' => __( 'Fade Out Right Big', THEMENAME )
			),
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Steps Box", THEMENAME ),
	"description" => __( "Steps Box", THEMENAME ),
	"id"          => "_step_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title that will appear on the first
											 box", THEMENAME ),
			"id"          => "stp_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Subtitle", THEMENAME ),
			"description" => __( "Please enter a subtitle that will appear on the
											first box", THEMENAME ),
			"id"          => "stp_subtitle",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Description", THEMENAME ),
			"description" => __( "Please enter a description that will appear on the
											 first box", THEMENAME ),
			"id"          => "stp_desc",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear as link in
											the first box under the description.", THEMENAME ),
			"id"          => "stp_text_link",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Bottom Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use.", THEMENAME ),
			"id"          => "stp_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
		$extra_options['stp_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Testimonial Box
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Testimonial Box", THEMENAME ),
	"description" => __( "Testimonial Box", THEMENAME ),
	"id"          => "_testimonial_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Author", THEMENAME ),
			"description" => __( "Please enter the quote author name", THEMENAME ),
			"id"          => "tb_author",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Author Company", THEMENAME ),
			"description" => __( "Please enter the quote author company/function", THEMENAME ),
			"id"          => "tb_author_com",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Author Quote", THEMENAME ),
			"description" => __( "Please enter the quote for this author", THEMENAME ),
			"id"          => "tb_author_quote",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Author logo", THEMENAME ),
			"description" => __( "Please select a logo for this author.", THEMENAME ),
			"id"          => "tb_author_logo",
			"std"         => "",
			"type"        => "media",
		),
		array (
			"name"        => __( "Testimonial style", THEMENAME ),
			"description" => __( "Select the desired style for this testimonial
											element", THEMENAME ),
			"id"          => "tb_style",
			"type"        => "select",
			"std"         => "style1",
			"options"     => array (
				'style1' => __( 'Style 1', THEMENAME ),
				'style2' => __( 'Style 2', THEMENAME )
			),
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Accordion
--------------------------------------------------------------------------------------------------*/
// Accordion SINGLE
$extra_options['acc_single'] = array (
	"name"           => __( "Accordions", THEMENAME ),
	"description"    => __( "Here you can create your desired accordions.", THEMENAME ),
	"id"             => "accordion_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Accordion", THEMENAME ),
	"remove_text"    => __( "Accordion", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title for this accordion.", THEMENAME ),
			"id"          => "acc_single_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Accordion content", THEMENAME ),
			"description" => __( "Please enter a content for this accordion.", THEMENAME ),
			"id"          => "acc_single_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Auto Colapsed", THEMENAME ),
			"description" => __( "Select yes if you want this accordion to be
												visible on page load.", THEMENAME ),
			"id"          => "acc_colapsed",
			"std"         => "no",
			"options"     => array (
				'yes' => __( 'Yes', THEMENAME ),
				'no'  => __( 'No', THEMENAME )
			),
			"type"        => "select"
		)
	)
);
$zn_meta_elements[] = array (
	"name"        => __( "Accordion", THEMENAME ),
	"description" => __( "Accordion", THEMENAME ),
	"id"          => "_accordion",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Enter a title for your Accordion element", THEMENAME ),
			"id"          => "acc_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Accordion Style", THEMENAME ),
			"description" => __( "Please select the style you want to use.", THEMENAME ),
			"id"          => "acc_style",
			"std"         => "style1",
			"options"     => array (
				'default-style' => __( 'Style 1', THEMENAME ),
				'style2'        => __( 'Style 2', THEMENAME ),
				'style3'        => __( 'Style 3', THEMENAME )
			),
			"type"        => "select",
		),
		$extra_options['acc_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Latest Posts 4
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Latest Posts 4", THEMENAME ),
	"description" => __( "Latest Posts 4", THEMENAME ),
	"id"          => "_latest_posts4",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "one-third,two-thirds,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "one-third",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Enter a title for your Latest Posts element", THEMENAME ),
			"id"          => "lp_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Number of posts", THEMENAME ),
			"description" => __( "Enter the number of posts that you want to show", THEMENAME ),
			"id"          => "lp_num_posts",
			"std"         => "3",
			"type"        => "text",
		),
		array (
			"name"        => __( "Blog Category", THEMENAME ),
			"description" => __( "Select the blog category to show items", THEMENAME ),
			"id"          => "lp_blog_categories",
			"mod"         => "multi",
			"std"         => "0",
			"type"        => "select",
			"options"     => $option_blog_cat
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Latest Posts 3
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Latest Posts 3", THEMENAME ),
	"description" => __( "Latest Posts 3", THEMENAME ),
	"id"          => "_latest_posts3",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Enter a title for your Latest Posts element", THEMENAME ),
			"id"          => "lp_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Blog page Link", THEMENAME ),
			"description" => __( "Enter the link to your blog page", THEMENAME ),
			"id"          => "lp_blog_page",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Number of posts", THEMENAME ),
			"description" => __( "Enter the number of posts that you want to show", THEMENAME ),
			"id"          => "lp_num_posts",
			"std"         => "2",
			"type"        => "text",
		),
		array (
			"name"        => __( "Blog Category", THEMENAME ),
			"description" => __( "Select the blog category to show items", THEMENAME ),
			"id"          => "lp_blog_categories",
			"mod"         => "multi",
			"std"         => "0",
			"type"        => "select",
			"options"     => $option_blog_cat
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Latest Posts 2
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Latest Posts 2", THEMENAME ),
	"description" => __( "Latest Posts 2", THEMENAME ),
	"id"          => "_latest_posts2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Enter a title for your Latest Posts element", THEMENAME ),
			"id"          => "lp_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Blog page Link", THEMENAME ),
			"description" => __( "Enter the link to your blog page", THEMENAME ),
			"id"          => "lp_blog_page",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Number of posts", THEMENAME ),
			"description" => __( "Enter the number of posts that you want to show", THEMENAME ),
			"id"          => "lp_num_posts",
			"std"         => "2",
			"type"        => "text",
		),
		array (
			"name"        => __( "Blog Category", THEMENAME ),
			"description" => __( "Select the blog category to show items", THEMENAME ),
			"id"          => "lp_blog_categories",
			"mod"         => "multi",
			"std"         => "0",
			"type"        => "select",
			"options"     => $option_blog_cat
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Latest Posts Element
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Latest Posts", THEMENAME ),
	"description" => __( "Latest Posts", THEMENAME ),
	"id"          => "_latest_posts",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Enter a title for your Latest Posts element", THEMENAME ),
			"id"          => "lp_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Blog page Link", THEMENAME ),
			"description" => __( "Enter the link to your blog page", THEMENAME ),
			"id"          => "lp_blog_page",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Blog Category", THEMENAME ),
			"description" => __( "Select the blog category to show items", THEMENAME ),
			"id"          => "lp_blog_categories",
			"mod"         => "multi",
			"std"         => "0",
			"type"        => "select",
			"options"     => $option_blog_cat
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Features Element 2
--------------------------------------------------------------------------------------------------*/
// FEATURES SINGLE
$extra_options['features_single2'] = array (
	"name"           => __( "Features Boxes", THEMENAME ),
	"description"    => __( "Here you can create your desired features boxes.", THEMENAME ),
	"id"             => "features_single2",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Feature box", THEMENAME ),
	"remove_text"    => __( "Feature box", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Feature title", THEMENAME ),
			"description" => __( "Please enter a title for this feature box.", THEMENAME ),
			"id"          => "fb_single_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Feature description", THEMENAME ),
			"description" => __( "Please enter a description for this feature
												box.", THEMENAME ),
			"id"          => "fb_single_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Feature icon", THEMENAME ),
			"description" => __( "Please select the desired icon to use.", THEMENAME ),
			"id"          => "fb_single_icon",
			"std"         => "ico1",
			"options"     => array (
				'ico1' => __( 'Chat', THEMENAME ),
				'ico2' => __( 'Document', THEMENAME ),
				'ico3' => __( 'Paint', THEMENAME ),
				'ico4' => __( 'Code', THEMENAME )
			),
			"type"        => "select",
		),
	)
);
$zn_meta_elements[] = array (
	"name"        => __( "Features Element 2", THEMENAME ),
	"description" => __( "Features Element 2", THEMENAME ),
	"id"          => "_features_element2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Enter a title for your Features element", THEMENAME ),
			"id"          => "fb_title",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['features_single2']
	)
);

/*--------------------------------------------------------------------------------------------------
Features Element
--------------------------------------------------------------------------------------------------*/
// FEATURES SINGLE
$extra_options['features_single'] = array (
	"name"           => __( "Features Boxes", THEMENAME ),
	"description"    => __( "Here you can create your desired features boxes.", THEMENAME ),
	"id"             => "features_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Feature box", THEMENAME ),
	"remove_text"    => __( "Feature box", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Feature title", THEMENAME ),
			"description" => __( "Please enter a title for this feature box.", THEMENAME ),
			"id"          => "fb_single_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Feature description", THEMENAME ),
			"description" => __( "Please enter a description for this feature
												box.", THEMENAME ),
			"id"          => "fb_single_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Feature icon", THEMENAME ),
			"description" => __( "Please choose an icon for this feature box.
												Please note that for best design , your icon should be 20x20 in size.", THEMENAME ),
			"id"          => "fb_single_icon",
			"std"         => "",
			"type"        => "media"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Features Element", THEMENAME ),
	"description" => __( "Features Element", THEMENAME ),
	"id"          => "_features_element",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,eight,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Enter a title for your Features element", THEMENAME ),
			"id"          => "fb_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Secondary title", THEMENAME ),
			"description" => __( "Enter a secondary title for your Features Element.
											Please note that this description will only appear if you choose to use the style 2.", THEMENAME ),
			"id"          => "fb_stitle",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Description ", THEMENAME ),
			"description" => __( "Enter a description for your Features Element.
											Please note that this description will only appear if you choose to use the style 2.", THEMENAME ),
			"id"          => "fb_desc",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Features Box Style", THEMENAME ),
			"description" => __( "Please select the style you want to use.", THEMENAME ),
			"id"          => "fb_style",
			"std"         => "style1",
			"options"     => array (
				'style1' => __( 'Style 1', THEMENAME ),
				'style2' => __( 'Style 2', THEMENAME ),
				'style3' => __( 'Style 3', THEMENAME )
			),
			"type"        => "select",
		),
		$extra_options['features_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Call Out Banner
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Call Out Banner", THEMENAME ),
	"description" => __( "Call Out Banner", THEMENAME ),
	"id"          => "_call_banner",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Main Title", THEMENAME ),
			"description" => __( "Enter a title for your Call Out Banner element", THEMENAME ),
			"id"          => "cab_main_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Secondary Title", THEMENAME ),
			"description" => __( "Enter a secondary title for your Call Out Banner
											element", THEMENAME ),
			"id"          => "cab_sec_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Button Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the right
											button.", THEMENAME ),
			"id"          => "cab_button_text",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Button Hover Image", THEMENAME ),
			"description" => __( "Please select an image that will appear when
											hovering the mouse over the button. If no image is chosen , the default OK image will be used", THEMENAME ),
			"id"          => "cab_button_image",
			"std"         => "",
			"type"        => "media",
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please choose the link you want to use for your
											button.", THEMENAME ),
			"id"          => "cab_button_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Portfolio Category
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Portfolio Category", THEMENAME ),
	"description" => __( "Portfolio Category", THEMENAME ),
	"id"          => "_portfolio_category",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Portfolio Category", THEMENAME ),
			"description" => __( "Select the portfolio category to show items", THEMENAME ),
			"id"          => "portfolio_categories",
			"mod"         => "multi",
			"std"         => "0",
			"type"        => "select",
			"options"     => $option_port_cat
		),
		array (
			"name"        => __( "Number of portfolio Items", THEMENAME ),
			"description" => __( "Please enter how many portfolio items you want to
											load.", THEMENAME ),
			"id"          => "ports_per_page",
			"std"         => "6",
			"type"        => "text"
		),
		array (
			"name"        => __( "Number of portfolio Items Per Page", THEMENAME ),
			"description" => __( "Please enter how many portfolio items you want to
											load on a page.", THEMENAME ),
			"id"          => "ports_per_page_visible",
			"std"         => "4",
			"type"        => "text"
		),
		array (
			"name"        => __( "Number of columns", THEMENAME ),
			"description" => __( "Please enter how many portfolio items you want to
											load on a page.", THEMENAME ),
			"id"          => "ports_num_columns",
			"std"         => "4",
			"options"     => array (
				'1' => __( '1', THEMENAME ),
				'2' => __( '2', THEMENAME ),
				'3' => __( '3', THEMENAME ),
				'4' => __( '4', THEMENAME ),
			),
			"type"        => "select"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Portfolio Sortable
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Portfolio Sortable", THEMENAME ),
	"description" => __( "Portfolio Sortable", THEMENAME ),
	"id"          => "_portfolio_sortable",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Portfolio Category", THEMENAME ),
			"description" => __( "Select the portfolio category to show items", THEMENAME ),
			"id"          => "portfolio_categories",
			"mod"         => "multi",
			"std"         => "0",
			"type"        => "select",
			"options"     => $option_port_cat
		),
		array (
			"name"        => __( "Number of portfolio Items", THEMENAME ),
			"description" => __( "Please enter how many portfolio items you want to
											load.", THEMENAME ),
			"id"          => "ports_per_page",
			"std"         => __( "6", THEMENAME ),
			"type"        => "text"
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Portfolio Carousel Layout
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Portfolio Carousel Layout", THEMENAME ),
	"description" => __( "Portfolio Carousel Layout", THEMENAME ),
	"id"          => "_portfolio_carousel",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Portfolio Category", THEMENAME ),
			"description" => __( "Select the portfolio category to show items", THEMENAME ),
			"id"          => "portfolio_categories",
			"mod"         => "multi",
			"std"         => "0",
			"type"        => "select",
			"options"     => $option_port_cat
		),
		// This is the number of items to select.
		array (
			"name"        => __( "Number of portfolio Items", THEMENAME ),
			"description" => __( "Please enter how many portfolio items you want to display.", THEMENAME ),
			"id"          => "ports_per_page",
			"std"         => 4,
			"type"        => "text"
		),
		/**
		 * The number of entries to display per page
		 */
		array (
			"name"        => __( "Number of portfolio Items Per Page", THEMENAME ),
			"description" => __( "Select the number of entries to display per page.", THEMENAME ),
			"id"          => "ports_per_page_visible",
			"std"         => __( "4", THEMENAME ),
			"type"        => "text"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Recent Work 2
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Recent Work 2", THEMENAME ),
	"description" => __( "Recent Work 2", THEMENAME ),
	"id"          => "_recent_work2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Recent Works Title", THEMENAME ),
			"description" => __( "Enter a title for your Recent Works element", THEMENAME ),
			"id"          => "rw_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Portfolio page link", THEMENAME ),
			"description" => __( "Please enter the link to your portfolio page.", THEMENAME ),
			"id"          => "rw_port_link",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Portfolio Category", THEMENAME ),
			"description" => __( "Select the portfolio category to show items", THEMENAME ),
			"id"          => "portfolio_categories",
			"mod"         => "multi",
			"std"         => __( "0", THEMENAME ),
			"type"        => "select",
			"options"     => $option_port_cat
		),
		array (
			"name"        => __( "Number of portfolio Items", THEMENAME ),
			"description" => __( "Please enter how many portfolio items you want to
											load.", THEMENAME ),
			"id"          => "ports_per_page",
			"std"         => __( "6", THEMENAME ),
			"type"        => "text"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Recent Work 1
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Recent Work", THEMENAME ),
	"description" => __( "Recent Work", THEMENAME ),
	"id"          => "_recent_work",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Recent Works Title", THEMENAME ),
			"description" => __( "Enter a title for your Recent Works element", THEMENAME ),
			"id"          => "rw_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Recent Works Description", THEMENAME ),
			"description" => __( "Please enter a description that will appear bellow
											 the title.", THEMENAME ),
			"id"          => "rw_desc",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Portfolio page link", THEMENAME ),
			"description" => __( "Please enter the link to your portfolio page.", THEMENAME ),
			"id"          => "rw_port_link",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Portfolio Category", THEMENAME ),
			"description" => __( "Select the portfolio category to show items", THEMENAME ),
			"id"          => "portfolio_categories",
			"mod"         => "multi",
			"std"         => __( "0", THEMENAME ),
			"type"        => "select",
			"options"     => $option_port_cat
		),
		array (
			"name"        => __( "Number of portfolio Items", THEMENAME ),
			"description" => __( "Please enter how many portfolio items you want to
											load.", THEMENAME ),
			"id"          => "ports_per_page",
			"std"         => __( "4", THEMENAME ),
			"type"        => "text"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
    LATEST POSTS CAROUSEL
@since v3.6.8
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
    "name"        => __( "Latest posts carousel", THEMENAME ),
    "description" => __( "Latest posts carousel", THEMENAME ),
    "id"          => "_wpk_latest_posts_carousel",
    "std"         => '',
    "type"        => "group",
    "add_text"    => __( "Item", THEMENAME ),
    "remove_text" => __( "Item", THEMENAME ),
    "hidden"      => true,
    "sizes"       => "sixteen",
    "link"        => true,
    "subelements" => array (
        array (
            "name"  => __( "Sizer Hidden Option", THEMENAME ),
            "desc"  => __( "This option is hidden.", THEMENAME ),
            "id"    => "_sizer",
            "std"   => "sixteen",
            "type"  => "hidden",
            "class" => 'zn_size_input'
        ),
        array (
            "name"        => __( "Title", THEMENAME ),
            "description" => __( "Enter a title for the latest posts carousel", THEMENAME ),
            "id"          => "lpc_title",
            "std"         => "",
            "type"        => "text",
        ),
        array (
            "name"        => __( "Posts Category", THEMENAME ),
            "description" => __( "Select the category to show items", THEMENAME ),
            "id"          => "lpc_categories",
            "mod"         => "multi",
            "std"         => 0,
            "type"        => "select",
            "options"     => $wpkPostCategories,
        ),
        array (
            "name"        => __( "Number of items", THEMENAME ),
            "description" => __( "Please enter how many items you want to load.", THEMENAME ),
            "id"          => "lpc_num_posts",
            "std"         => 10,
            "type"        => "text"
        )
    )
);

/*--------------------------------------------------------------------------------------------------
Service Box
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Service Box", THEMENAME ),
	"description" => __( "Service Box", THEMENAME ),
	"id"          => "_service_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Service Box Title", THEMENAME ),
			"description" => __( "Enter a title for your Service box", THEMENAME ),
			"id"          => "service_box_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Service Box Features", THEMENAME ),
			"description" => __( "Please enter your features one on a line.This will
											 create your features list with an arrow on the right.", THEMENAME ),
			"id"          => "service_box_features",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Image", THEMENAME ),
			"description" => __( "Please select an image that will appear on the
											left side of the title.", THEMENAME ),
			"id"          => "service_box_image",
			"std"         => "",
			"type"        => "media"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Images Box 2
--------------------------------------------------------------------------------------------------*/
$extra_options['ib2_single'] = array (
	"name"           => __( "Images", THEMENAME ),
	"description"    => __( "Here you can add your images.", THEMENAME ),
	"id"             => "ib2_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Image", THEMENAME ),
	"remove_text"    => __( "Image", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Image", THEMENAME ),
			"description" => __( "Please select an image.", THEMENAME ),
			"id"          => "ib2_image",
			"std"         => "",
			"type"        => "media",
			"alt"         => true
		),
		array (
			"name"        => __( "Image Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use.", THEMENAME ),
			"id"          => "ib2_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Image Width", THEMENAME ),
			"description" => __( "Please select the desired width for this image.The number 3 means the image will take a quarter of the space and 12 means it will take the full width of the page. Depending on the image sizes, you can stack images one under the other.", THEMENAME ),
			"id"          => "ib2_width",
			"std"         => "span4",
			"options"     => array (
				'span3'  => __( '3', THEMENAME ),
				'span4'  => __( '4', THEMENAME ),
				'span5'  => __( '5', THEMENAME ),
				'span6'  => __( '6', THEMENAME ),
				'span7'  => __( '7', THEMENAME ),
				'span8'  => __( '8', THEMENAME ),
				'span9'  => __( '9', THEMENAME ),
				'span10' => __( '10', THEMENAME ),
				'span11' => __( '11', THEMENAME ),
				'span12' => __( '12', THEMENAME )
			),
			"type"        => "select"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Images Box", THEMENAME ),
	"description" => __( "Images Box", THEMENAME ),
	"id"          => "_image_box2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Image Box Title", THEMENAME ),
			"description" => __( "Enter a title for your Image box", THEMENAME ),
			"id"          => "image_box_title",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['ib2_single']
	)
);

/*--------------------------------------------------------------------------------------------------
Image Box
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Image Box", THEMENAME ),
	"description" => __( "Image Box", THEMENAME ),
	"id"          => "_image_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Image Box Title", THEMENAME ),
			"description" => __( "Enter a title for your Image box", THEMENAME ),
			"id"          => "image_box_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => "Image Box Text",
			"description" => "Please enter a text that will appear inside your action Image button.",
			"id"          => "image_box_text",
			"std"         => "",
			"type"        => "textarea",
		),
		array (
			"name"        => __( "Image", THEMENAME ),
			"description" => __( "Please select an image that will appear above the
											title.", THEMENAME ),
			"id"          => "image_box_image",
			"std"         => "",
			"type"        => "media",
			"alt"         => true
		),
		array (
			"name"        => __( "Image Box Style", THEMENAME ),
			"description" => __( "Please select the style you want to use.", THEMENAME ),
			"id"          => "image_box_style",
			"std"         => "imgboxes_style1",
			"options"     => array (
				'imgboxes_style1' => __( 'Style 1', THEMENAME ),
				'style2'          => __( 'Style 2', THEMENAME ),
				'style3'          => __( 'Style 3', THEMENAME )
			),
			"type"        => "select",
		),
		array (
			"name"        => __( "Link text", THEMENAME ),
			"description" => __( "Enter a that will appear as link ove the image.", THEMENAME ),
			"id"          => "image_box_link_text",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Image Box link", THEMENAME ),
			"description" => __( "Please choose the link you want to use for your
											Image box button.", THEMENAME ),
			"id"          => "image_box_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		)
	)
);
/*--------------------------------------------------------------------------------------------------
Partners Logos
--------------------------------------------------------------------------------------------------*/
// STEPS SINGLE
$extra_options['sf_single'] = array (
	"name"           => __( "Features", THEMENAME ),
	"description"    => __( "Here you can add your shop features.", THEMENAME ),
	"id"             => "sf_single",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Feature", THEMENAME ),
	"remove_text"    => __( "Feature", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Icon", THEMENAME ),
			"description" => __( "Please select an icon.", THEMENAME ),
			"id"          => "lp_single_logo",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Line 1 text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the
												first line.", THEMENAME ),
			"id"          => "lp_single_line1",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Line 2 text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the
												second line.", THEMENAME ),
			"id"          => "lp_single_line2",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Feature Link", THEMENAME ),
			"description" => __( "Please choose the link you want to use.", THEMENAME ),
			"id"          => "lp_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Shop Features", THEMENAME ),
	"description" => __( "Shop Features", THEMENAME ),
	"id"          => "_shop_features",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Feature", THEMENAME ),
	"remove_text" => __( "Feature", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter the title for this element.", THEMENAME ),
			"id"          => "sf_title",
			"std"         => "",
			"type"        => "text",
		),
		$extra_options['sf_single']
	)
);
/*--------------------------------------------------------------------------------------------------
WooCommerce Limited Offers
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Shop Limited Offers", THEMENAME ),
	"description" => __( "Shop Products Presentation", THEMENAME ),
	"id"          => "_woo_limited",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,one-third,eight,two-thirds,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Element Title", THEMENAME ),
			"description" => __( "Enter a title for this element", THEMENAME ),
			"id"          => "woo_lo_title",
			"std"         => "",
			"type"        => "text",
		),
		array (
			"name"        => __( "Shop Category", THEMENAME ),
			"description" => __( "Select the shop category to show items", THEMENAME ),
			"id"          => "woo_categories",
			"mod"         => "multi",
			"std"         => __( "0", THEMENAME ),
			"type"        => "select",
			"options"     => $option_shop_cat
		),
		array (
			"name"        => __( "Number of products", THEMENAME ),
			"description" => __( "Please enter how many products you want to load.", THEMENAME ),
			"id"          => "prods_per_page",
			"std"         => __( "6", THEMENAME ),
			"type"        => "text"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
WooCommerce Items
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"name"        => __( "Shop Products Presentation", THEMENAME ),
	"description" => __( "Shop Products Presentation", THEMENAME ),
	"id"          => "_woo_products",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "four,eight,twelve,sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "four",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Show Latest Products", THEMENAME ),
			"description" => __( "Select yes if you want to show the latest products.", THEMENAME ),
			"id"          => "woo_lp_prod",
			"std"         => 1,
			"options"     => array ( '1' => __( 'Yes', THEMENAME ), '0' => __( 'No', THEMENAME ) ),
			"type"        => "select",
		),
		array (
			"name"        => __( "Latest Products Title", THEMENAME ),
			"description" => __( "Please enter a title for the latest products. If
											no title is set , the default title will be shown ( LATEST PRODUCTS )", THEMENAME ),
			"id"          => "woo_lp_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Show Best Selling Products", THEMENAME ),
			"description" => __( "Select yes if you want to show the best selling
											products.", THEMENAME ),
			"id"          => "woo_bs_prod",
			"std"         => 1,
			"options"     => array ( '1' => __( 'Yes', THEMENAME ), '0' => __( 'No', THEMENAME ) ),
			"type"        => "select",
		),
		array (
			"name"        => __( "Best Selling Title", THEMENAME ),
			"description" => __( "Please enter a title for the best selling products
											. If no title is set , the default title will be shown ( BEST SELLING PRODUCTS )", THEMENAME ),
			"id"          => "woo_bsp_title",
			"std"         => "",
			"type"        => "text"
		),

		array (
			"name"        => __( "Show Featured Products", THEMENAME ),
			"description" => __( "Select yes if you want to show the featured products.", THEMENAME ),
			"id"          => "woo_fp_prod",
			"std"         => 1,
			"options"     => array ( '1' => __( 'Yes', THEMENAME ), '0' => __( 'No', THEMENAME ) ),
			"type"        => "select",
		),
		array (
			"name"        => __( "Featured Products Title", THEMENAME ),
			"description" => __( "Please enter a title for the featured products. If
											no title is set, the default title will be shown ( FEATURED PRODUCTS )",
				THEMENAME ),
			"id"          => "woo_fp_title",
			"std"         => "",
			"type"        => "text"
		),

		array (
			"name"        => __( "Shop Category", THEMENAME ),
			"description" => __( "Select the shop category to show items", THEMENAME ),
			"id"          => "woo_categories",
			"mod"         => "multi",
			"std"         => __( "0", THEMENAME ),
			"type"        => "select",
			"options"     => $option_shop_cat
		),
		array (
			"name"        => __( "Number of products", THEMENAME ),
			"description" => __( "Please enter how many products you want to load.", THEMENAME ),
			"id"          => "prods_per_page",
			"std"         => __( "6", THEMENAME ),
			"type"        => "text"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Alternative page title
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"link_to"     => "page_options",
	"name"        => __( "Show Page Title?", THEMENAME ),
	"description" => __( "Choose yes if you want to show the page title above the content.", THEMENAME ),
	"id"          => "page_title_show",
	"std"         => "yes",
	"options"     => array ( "yes" => __( "Yes", THEMENAME ), "no" => __( "No", THEMENAME ) ),
	"type"        => "zn_radio",
);

$zn_meta_elements[] = array (
	"link_to"     => "page_options",
	"name"        => __( "Alternative Page Title", THEMENAME ),
	"description" => __( "Enter your desired title for this page. Please note that this title will appear on the top-right of your header if you choose to use a page header.If this field is not completed, the normal page title will appear in both top-right part of the header as well as the normal location of page title.", THEMENAME ),
	"id"          => "page_title",
	"std"         => "",
	"type"        => "text"
);

$zn_meta_elements[] = array (
	"link_to"     => "page_options",
	"name"        => __( "Page Subtitle", THEMENAME ),
	"description" => __( "Enter your desired subtitle for this page.Please note that the appearance
					of this subtitle is subject of default or custom options of the header part.", THEMENAME ),
	"id"          => "page_subtitle",
	"std"         => "",
	"type"        => "text"
);

$zn_meta_elements[] = array (
	"link_to"     => "page_options",
	"name"        => __( "Hide page subheader?", THEMENAME ),
	"description" => __( "Chose yes if you want to hide the page sub-header ( including sliders ). Please note
		that this option will overwrite the option set in the admin panel", THEMENAME ),
	"id"          => "zn_disable_subheader",
	"std"         => 'no',
	"options"     => array ( 'yes' => __( "Yes", THEMENAME ), 'no' => __( "No", THEMENAME ) ),
	"type"        => "select"
);

/*--------------------------------------------------------------------------------------------------
ACTION BOX
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Action Box", THEMENAME ),
	"description" => __( "Action Box", THEMENAME ),
	"id"          => "_action_box",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Action Box Title", THEMENAME ),
			"description" => __( "Enter a title for your action box", THEMENAME ),
			"id"          => "page_ac_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Action Box Button Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear inside your
											action box button.", THEMENAME ),
			"id"          => "page_ac_b_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Action Box link", THEMENAME ),
			"description" => __( "Please choose the link you want to use for your
											action box button.", THEMENAME ),
			"id"          => "page_ac_b_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		)
	)
);

/*--------------------------------------------------------------------------------------------------
ACTION BOX TEXT
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Action Box Text", THEMENAME ),
	"description" => __( "Action Box Text", THEMENAME ),
	"id"          => "_action_box_text",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Action Box Text", THEMENAME ),
			"description" => __( "Enter a description text for your action box", THEMENAME ),
			"id"          => "page_ac_title",
			"std"         => "",
			"type"        => "textarea"
		)
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Video Background
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "STATIC CONTENT - Video Background", THEMENAME ),
	"description" => __( "STATIC CONTENT - Video Background", THEMENAME ),
	"id"          => "_static8",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Line 1 Title", THEMENAME ),
			"description" => __( "Please enter a title that will appear on the first
											 line.", THEMENAME ),
			"id"          => "sc_vb_line1",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Line 2 Title", THEMENAME ),
			"description" => __( "Please enter a title that will appear on the
											second line.", THEMENAME ),
			"id"          => "sc_vb_line2",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Video Type", THEMENAME ),
			"description" => __( "Select what type of video background you want to
											use.", THEMENAME ),
			"id"          => "sc_vb_video_type",
			"std"         => "self",
			"options"     => array (
				"self"   => __( "Self hosted", THEMENAME ),
				"iframe" => __( "Video Iframe", THEMENAME )
			),
			"type"        => "zn_radio",
			"rel_id"      => "sc_vb_video_type",
		),
		array (
			"name"        => __( "Video link", THEMENAME ),
			"description" => __( "Please enter the video link as seen in the browser
											 address bar for the desired video.", THEMENAME ),
			"id"          => "sc_vb_embed",
			"std"         => "",
			"type"        => "text",
			'dependency'  => array ( 'element' => 'sc_vb_video_type', 'value' => array ( 'iframe' ) ),
		),
		array (
			"name"        => __( "Video file", THEMENAME ),
			"description" => __( "Please choose the video file you want to use.", THEMENAME ),
			"id"          => "sc_vb_sh_video1",
			"std"         => "",
			"type"        => "media",
			'dependency'  => array ( 'element' => 'sc_vb_video_type', 'value' => array ( 'self' ) ),
		),
		array (
			"name"        => __( "OGG Video file", THEMENAME ),
			"description" => __( "Please enter an ogg video file (.ogv).", THEMENAME ),
			"id"          => "sc_vb_sh_video2",
			"std"         => "",
			"type"        => "media",
			'dependency'  => array ( 'element' => 'sc_vb_video_type', 'value' => array ( 'self' ) ),
		),
		array (
			"name"        => __( "Video image Cover", THEMENAME ),
			"description" => __( "Please add an image cover for your video.", THEMENAME ),
			"id"          => "sc_vb_sh_video_cover",
			"std"         => "",
			"type"        => "media",
			'dependency'  => array ( 'element' => 'sc_vb_video_type', 'value' => array ( 'self' ) ),
		),
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Simple Text
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "STATIC CONTENT - Simple Text", THEMENAME ),
	"description" => __( "STATIC CONTENT - Simple Text", THEMENAME ),
	"id"          => "_static9",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Text", THEMENAME ),
			"description" => __( "Please enter your desired text.", THEMENAME ),
			"id"          => "sc_sc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Button Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear as a button
											bellow your text.", THEMENAME ),
			"id"          => "sc_button_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please choose the link you want to use for your
											button.", THEMENAME ),
			"id"          => "sc_button_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		)
	)

);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Simple Text ( full width )
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "STATIC CONTENT - Simple Text ( full width )", THEMENAME ),
	"description" => __( "STATIC CONTENT - Simple Text ( full width )", THEMENAME ),
	"id"          => "_static12",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Text", THEMENAME ),
			"description" => __( "Please enter your desired text.", THEMENAME ),
			"id"          => "sc_sc",
			"std"         => "",
			"type"        => "textarea"
		)
	)

);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Text and Register
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "STATIC CONTENT - Text and Register", THEMENAME ),
	"description" => __( "STATIC CONTENT - Text and Register", THEMENAME ),
	"id"          => "_static10",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Main title", THEMENAME ),
			"description" => __( "Please enter a main title.", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Subtitle", THEMENAME ),
			"description" => __( "Please enter a subtitle", THEMENAME ),
			"id"          => "ww_slide_subtitle",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Main Text", THEMENAME ),
			"description" => __( "Please enter a main text for this button", THEMENAME ),
			"id"          => "ww_slide_m_button",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_l_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please enter a link that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)

);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Text and Video
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "STATIC CONTENT - Text and Video", THEMENAME ),
	"description" => __( "STATIC CONTENT - Text and Video", THEMENAME ),
	"id"          => "_static11",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Main title", THEMENAME ),
			"description" => __( "Please enter a main title.", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Subtitle", THEMENAME ),
			"description" => __( "Please enter a subtitle", THEMENAME ),
			"id"          => "ww_slide_subtitle",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Main Text", THEMENAME ),
			"description" => __( "Please enter a main text for this button", THEMENAME ),
			"id"          => "ww_slide_m_button",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_l_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please enter a link that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Video", THEMENAME ),
			"description" => __( "Please enter the link for your desired video (
											youtube or vimeo ).", THEMENAME ),
			"id"          => "sc_ec_vime",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Video Description", THEMENAME ),
			"description" => __( "Please enter a description for this video that
											will appear above the video.", THEMENAME ),
			"id"          => "sc_ec_vid_desc",
			"std"         => "",
			"type"        => "text"
		),
	)

);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Event Countdown
--------------------------------------------------------------------------------------------------*/
// EVENT COUNTDOWN SINGLE
$extra_options['event_social'] = array (
	"name"           => __( "Social Icons", THEMENAME ),
	"description"    => __( "Here you can add your desired social icons.", THEMENAME ),
	"id"             => "single_ec_social",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Social Icon", THEMENAME ),
	"remove_text"    => __( "Social Icon", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Icon title", THEMENAME ),
			"description" => __( "Here you can enter a title for this social icon.Please note that this is just for your information as this text will not be visible on the site.", THEMENAME ),
			"id"          => "sc_ec_social_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Social icon link", THEMENAME ),
			"description" => __( "Please enter your desired link for the social icon. If this field is left blank, the icon will not be linked.", THEMENAME ),
			"id"          => "sc_ec_social_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Social icon", THEMENAME ),
			"description" => __( "Select your desired social icon.", THEMENAME ),
			"id"          => "sc_ec_social_icon",
			"std"         => "",
			"options"     => $all_icon_sets,
			"type"        => "zn_icon_font"
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "STATIC CONTENT - Event Countdown", THEMENAME ),
	"description" => __( "STATIC CONTENT - Event Countdown", THEMENAME ),
	"id"          => "_static7",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title.", THEMENAME ),
			"id"          => "sc_ec_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Video", THEMENAME ),
			"description" => __( "Please enter the link for your desired video (
											youtube or vimeo ).", THEMENAME ),
			"id"          => "sc_ec_vime",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Video Description", THEMENAME ),
			"description" => __( "Please enter a description for this video that
											will appear above the video.", THEMENAME ),
			"id"          => "sc_ec_vid_desc",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Date", THEMENAME ),
			"description" => __( "Here you can select the date until the countdown
											finishes.", THEMENAME ),
			"id"          => "sc_ec_date",
			"std"         => "",
			"type"        => "date_picker"
		),
		array (
			"name"        => __( "Mailchimp List ID", THEMENAME ),
			"description" => __( "Please enter your Mailchimp list id. In order to make Mailchimp work, you should
			also add your Mailchimp api key in the theme's admin page.", THEMENAME ),
			"id"          => "sc_ec_mlid",
			"std"         => "",
			"type"        => "text"
		),
		$extra_options['event_social'],
		array (
			"name"        => __( "Use normal or colored social icons?", THEMENAME ),
			"description" => __( "Here you can choose to use the normal social icons or the colored version of each icon.", THEMENAME ),
			"id"          => "sc_ec_social_color",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				'normal'  => __( 'Normal Icons', THEMENAME ),
				'colored' => __( 'Colored icons', THEMENAME )
			),
			"class"       => ""
		)
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Product Loupe
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (

	"name"        => __( "STATIC CONTENT - Product Loupe", THEMENAME ),
	"description" => __( "STATIC CONTENT - Product Loupe", THEMENAME ),
	"id"          => "_static6",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title.", THEMENAME ),
			"id"          => "sc_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Featured image", THEMENAME ),
			"description" => __( "Select an image that will appear on the right side
											 of the header", THEMENAME ),
			"id"          => "sc_lp_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Features list", THEMENAME ),
			"description" => __( "Please enter a title.", THEMENAME ),
			"id"          => "sc_lp_features",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Button 1 Text", THEMENAME ),
			"description" => __( "Please enter a text for the first button.", THEMENAME ),
			"id"          => "sc_lp_button1",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button 1 link", THEMENAME ),
			"description" => __( "Here you can add a link to the first button", THEMENAME ),
			"id"          => "sc_lp_button1_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Button 1 icon", THEMENAME ),
			"description" => __( "Select your desired icon that will appear on the
											left side of the button text.", THEMENAME ),
			"id"          => "sc_lp_button1_icon",
			"std"         => "",
			"options"     => $bootstrap_icons,
			"type"        => "zn_icon_font",
			""
		),
		array (
			"name"        => __( "Button 1 style", THEMENAME ),
			"description" => __( "Select the desired style for your button.", THEMENAME ),
			"id"          => "sc_lp_button1_style",
			"std"         => false,
			"type"        => "select",
			"options"     => array (
				"btn"             => "Default",
				"btn btn-primary" => __( "Primary", THEMENAME ),
				"btn btn-info"    => __( "Info", THEMENAME ),
				"btn btn-success" => __( "Success", THEMENAME ),
				"btn btn-warning" => __( "Warning", THEMENAME ),
				"btn btn-danger"  => __( "Danger", THEMENAME ),
				"btn btn-inverse" => __( "Inverse", THEMENAME ),
				"btn btn-link"    => __( "Link", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Button 1 icon style", THEMENAME ),
			"description" => __( "Select the desired style for your icon.", THEMENAME ),
			"id"          => "sc_lp_button1_icon_style",
			"std"         => false,
			"type"        => "select",
			"options"     => array (
				false        => __( "Normal icons", THEMENAME ),
				"icon-white" => __( "White icons", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Text between buttons", THEMENAME ),
			"description" => __( "Here you can add a text that will appear between
											your buttons", THEMENAME ),
			"id"          => "sc_bt_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button 2 Text", THEMENAME ),
			"description" => __( "Please enter a text for the second button.", THEMENAME ),
			"id"          => "sc_2p_button1",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button 2 link", THEMENAME ),
			"description" => __( "Here you can add a link to the second button", THEMENAME ),
			"id"          => "sc_lp_button2_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Button 2 icon", THEMENAME ),
			"description" => __( "Select your desired icon that will appear on the
											left side of the button text.", THEMENAME ),
			"id"          => "sc_lp_button2_icon",
			"std"         => "",
			"options"     => $bootstrap_icons,
			"type"        => "zn_icon_font",
			""
		),
		array (
			"name"        => __( "Button 2 style", THEMENAME ),
			"description" => __( "Select the desired style for your button.", THEMENAME ),
			"id"          => "sc_lp_button2_style",
			"std"         => false,
			"type"        => "select",
			"options"     => array (
				"btn"             => "Default",
				"btn btn-primary" => __( "Primary", THEMENAME ),
				"btn btn-info"    => __( "Info", THEMENAME ),
				"btn btn-success" => __( "Success", THEMENAME ),
				"btn btn-warning" => __( "Warning", THEMENAME ),
				"btn btn-danger"  => __( "Danger", THEMENAME ),
				"btn btn-inverse" => __( "Inverse", THEMENAME ),
				"btn btn-link"    => __( "Link", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Button 2 icon style", THEMENAME ),
			"description" => __( "Select the desired style for your icon.", THEMENAME ),
			"id"          => "sc_lp_button2_icon_style",
			"std"         => false,
			"type"        => "select",
			"options"     => array (
				false        => __( "Normal icons", THEMENAME ),
				"icon-white" => __( "White icons", THEMENAME )
			),
			"class"       => ""
		),
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Text Pop
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (

	"name"        => __( "STATIC CONTENT - Text Pop", THEMENAME ),
	"description" => __( "STATIC CONTENT - Text Pop", THEMENAME ),
	"id"          => "_static5",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Line 1 Text", THEMENAME ),
			"description" => __( "Please enter a text for the first line.", THEMENAME ),
			"id"          => "sc_pop_line1",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Line 2 Text", THEMENAME ),
			"description" => __( "Please enter a text for the second line.", THEMENAME ),
			"id"          => "sc_pop_line2",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Line 3 Text", THEMENAME ),
			"description" => __( "Please enter a text for the third line.", THEMENAME ),
			"id"          => "sc_pop_line3",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Line 4 Text", THEMENAME ),
			"description" => __( "Please enter a text for the fourth line.", THEMENAME ),
			"id"          => "sc_pop_line4",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Main Text", THEMENAME ),
			"description" => __( "Please enter a main text for this button", THEMENAME ),
			"id"          => "ww_slide_m_button",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_l_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please enter a link that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Maps
--------------------------------------------------------------------------------------------------*/

$zoom = array ();

for ( $i = 0; $i < 24; $i ++ ) {
	$zoom[ $i ] = $i;
}

$zn_meta_elements[] = array (

	"name"        => __( "STATIC CONTENT - Maps", THEMENAME ),
	"description" => __( "STATIC CONTENT - Maps", THEMENAME ),
	"id"          => "_static4",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Map Height", THEMENAME ),
			"description" => __( "Please enter height value in pixels for the map
											height.", THEMENAME ),
			"id"          => "sc_map_height",
			"std"         => "600",
			"type"        => "text"
		),
		array (
			"name"        => __( "Map Latitude", THEMENAME ),
			"description" => __( "Please enter the latitude value for your
											location.", THEMENAME ),
			"id"          => "sc_map_latitude",
			"std"         => "40.712785",
			"type"        => "text"
		),
		array (
			"name"        => __( "Map Longitude", THEMENAME ),
			"description" => __( "Please enter the longitude value for your
											location.", THEMENAME ),
			"id"          => "sc_map_longitude",
			"std"         => "-73.962708",
			"type"        => "text"
		),
		array (
			"name"        => __( "Zoom level", THEMENAME ),
			"description" => __( "Select the zoom level you want to use for this map
											 ( default is 14 )", THEMENAME ),
			"id"          => "sc_map_zoom",
			"std"         => "14",
			"type"        => "select",
			"options"     => $zoom,
			"class"       => ""
		),
		array (
			"name"        => __( "Map Type", THEMENAME ),
			"description" => __( "Select the desired map type you want to use.", THEMENAME ),
			"id"          => "sc_map_type",
			"std"         => "roadmap",
			"type"        => "select",
			"options"     => array (
				"ROADMAP"   => __( "Roadmap", THEMENAME ),
				"SATELLITE" => __( "Satellite", THEMENAME ),
				"TERRAIN"   => __( "Terrain", THEMENAME ),
				"HYBRID"    => __( "Hybrid", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Allow map dragging?", THEMENAME ),
			"description" => __( "Select yes if you want to use the drag ability
											over map.", THEMENAME ),
			"id"          => "sc_map_dragg",
			"std"         => "false",
			"type"        => "select",
			"options"     => array (
				'true'  => __( 'Yes', THEMENAME ),
				'false' => __( 'No', THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Allow mouse wheel?", THEMENAME ),
			"description" => __( "Select yes if you want to use the drag ability
											over map.", THEMENAME ),
			"id"          => "sc_map_zooming_mousewheel",
			"std"         => "false",
			"type"        => "select",
			"options"     => array (
				'true'  => __( 'Yes', THEMENAME ),
				'false' => __( 'No', THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Current location icon", THEMENAME ),
			"description" => __( "Select an icon that will appear as your current
											location", THEMENAME ),
			"id"          => "sc_map_icon",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Button Main Text", THEMENAME ),
			"description" => __( "Please enter a main text for this button", THEMENAME ),
			"id"          => "ww_slide_m_button",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_l_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please enter a link that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Maps Multiple Locations
--------------------------------------------------------------------------------------------------*/

$zoom = array ();

for ( $i = 0; $i < 24; $i ++ ) {
	$zoom[ $i ] = $i;
}

$extra_options['map_multiple'] = array (
	"name"           => __( "Locations", THEMENAME ),
	"description"    => __( "Here you can add your map locations.", THEMENAME ),
	"id"             => "single_multiple_maps",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Location", THEMENAME ),
	"remove_text"    => __( "Location", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Map Latitude", THEMENAME ),
			"description" => __( "Please enter the latitude value for your
												location.", THEMENAME ),
			"id"          => "sc_map_latitude",
			"std"         => "40.712785",
			"type"        => "text"
		),
		array (
			"name"        => __( "Map Longitude", THEMENAME ),
			"description" => __( "Please enter the longitude value for your
												location.", THEMENAME ),
			"id"          => "sc_map_longitude",
			"std"         => "-73.962708",
			"type"        => "text"
		),
		array (
			"name"        => __( "Current location icon", THEMENAME ),
			"description" => __( "Select an icon that will appear as your
												current location", THEMENAME ),
			"id"          => "sc_map_icon",
			"std"         => "",
			"type"        => "media"
		),
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "STATIC CONTENT - Maps multiple locations", THEMENAME ),
	"description" => __( "STATIC CONTENT - Maps multiple locations", THEMENAME ),
	"id"          => "_static4_multiple",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Map Height", THEMENAME ),
			"description" => __( "Please enter height value in pixels for the map
											height.", THEMENAME ),
			"id"          => "sc_map_height",
			"std"         => "600",
			"type"        => "text"
		),
		array (
			"name"        => __( "Zoom level", THEMENAME ),
			"description" => __( "Select the zoom level you want to use for this map
											 ( default is 14 )", THEMENAME ),
			"id"          => "sc_map_zoom",
			"std"         => __( "14", THEMENAME ),
			"type"        => "select",
			"options"     => $zoom,
			"class"       => ""
		),
		array (
			"name"        => __( "Map Type", THEMENAME ),
			"description" => __( "Select the desired map type you want to use.", THEMENAME ),
			"id"          => "sc_map_type",
			"std"         => "roadmap",
			"type"        => "select",
			"options"     => array (
				"ROADMAP"   => __( "Roadmap", THEMENAME ),
				"SATELLITE" => __( "Satellite", THEMENAME ),
				"TERRAIN"   => __( "Terrain", THEMENAME ),
				"HYBRID"    => __( "Hybrid", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Allow map dragging?", THEMENAME ),
			"description" => __( "Select yes if you want to use the drag ability
											over map.", THEMENAME ),
			"id"          => "sc_map_dragg",
			"std"         => "false",
			"type"        => "select",
			"options"     => array (
				'true'  => __( 'Yes', THEMENAME ),
				'false' => __( 'No', THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Allow mouse wheel?", THEMENAME ),
			"description" => __( "Select yes if you want to use the drag ability over map.", THEMENAME ),
			"id"          => "sc_map_zooming_mousewheel",
			"std"         => "false",
			"type"        => "select",
			"options"     => array (
				'true'  => __( 'Yes', THEMENAME ),
				'false' => __( 'No', THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Button Main Text", THEMENAME ),
			"description" => __( "Please enter a main text for this button", THEMENAME ),
			"id"          => "ww_slide_m_button",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the right side of the button", THEMENAME ),
			"id"          => "ww_slide_l_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please enter a link that will appear on the right side of the button", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		),
		$extra_options['map_multiple']
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Video
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (

	"name"        => __( "STATIC CONTENT - Video", THEMENAME ),
	"description" => __( "STATIC CONTENT - Video", THEMENAME ),
	"id"          => "_static3",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title for your boxes.", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Video Link", THEMENAME ),
			"description" => __( "Please enter the link to the video you want to embed ( Vimeo or Youtube ).", THEMENAME ),
			"id"          => "ww_slide_video",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Video Description", THEMENAME ),
			"description" => __( "Please enter a text that will appear under the video link.", THEMENAME ),
			"id"          => "ww_slide_video_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Element height", THEMENAME ),
			"description" => __( "Please enter a height value in pixels.Default is 400.", THEMENAME ),
			"id"          => "ww_height",
			"std"         => __( "300", THEMENAME ),
			"type"        => "text"
		),
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Boxes
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (

	"name"        => __( "STATIC CONTENT - Boxes", THEMENAME ),
	"description" => __( "STATIC CONTENT - Boxes", THEMENAME ),
	"id"          => "_static2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Title", THEMENAME ),
			"description" => __( "Please enter a title for your boxes.", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Box 1 Title", THEMENAME ),
			"description" => __( "Please enter a title for your first box.", THEMENAME ),
			"id"          => "ww_box1_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Box 1 image", THEMENAME ),
			"description" => __( "Select an image for this Box", THEMENAME ),
			"id"          => "ww_box1_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Box 1 Description", THEMENAME ),
			"description" => __( "Please enter a description text for your first box.", THEMENAME ),
			"id"          => "ww_box1_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Box 2 Title", THEMENAME ),
			"description" => __( "Please enter a title for your first box.", THEMENAME ),
			"id"          => "ww_box2_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Box 2 image", THEMENAME ),
			"description" => __( "Select an image for this Box", THEMENAME ),
			"id"          => "ww_box2_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Box 2 Description", THEMENAME ),
			"description" => __( "Please enter a description text for your first box.", THEMENAME ),
			"id"          => "ww_box2_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Box 3 Title", THEMENAME ),
			"description" => __( "Please enter a title for your first box.", THEMENAME ),
			"id"          => "ww_box3_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Box 3 image", THEMENAME ),
			"description" => __( "Select an image for this Box", THEMENAME ),
			"id"          => "ww_box3_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Box 3 Description", THEMENAME ),
			"description" => __( "Please enter a description text for your first box.", THEMENAME ),
			"id"          => "ww_box3_desc",
			"std"         => "",
			"type"        => "textarea"
		),
	)
);

/*--------------------------------------------------------------------------------------------------
STATIC CONTENT - Default
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (

	"name"        => __( "STATIC CONTENT - Default", THEMENAME ),
	"description" => __( "STATIC CONTENT - Default", THEMENAME ),
	"id"          => "_static1",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Main title", THEMENAME ),
			"description" => __( "Please enter a main title.", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Subtitle", THEMENAME ),
			"description" => __( "Please enter a subtitle", THEMENAME ),
			"id"          => "ww_slide_subtitle",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Main Text", THEMENAME ),
			"description" => __( "Please enter a main text for this button", THEMENAME ),
			"id"          => "ww_slide_m_button",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button Link Text", THEMENAME ),
			"description" => __( "Please enter a text that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_l_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Button link", THEMENAME ),
			"description" => __( "Please enter a link that will appear on the right
											side of the button", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Circular Content Style 2
--------------------------------------------------------------------------------------------------*/
// CIRCULAR CONTENT 2 SINGLE
$extra_options['circulartwo'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Circular Content Slides.", THEMENAME ),
	"id"             => "single_circ2",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "ww_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear over the image", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide title - Left Position", THEMENAME ),
			"description" => __( "Please enter a value in pixels for the left position of the title", THEMENAME ),
			"id"          => "ww_slide_title_left",
			"std"         => "10",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide title - Top Position", THEMENAME ),
			"description" => __( "Please enter a value in pixels for the top position of the title", THEMENAME ),
			"id"          => "ww_slide_title_top",
			"std"         => "200",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slider Title Size", THEMENAME ),
			"description" => __( "Here you can select the size of your title.", THEMENAME ),
			"id"          => "ww_slide_title_size",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				"small"  => __( "Small", THEMENAME ),
				"medium" => __( "Medium", THEMENAME ),
				"large"  => __( "Large", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Slide bottom title", THEMENAME ),
			"description" => __( "This title will appear on the bottom left of the slide", THEMENAME ),
			"id"          => "ww_slide_bottom_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide more text", THEMENAME ),
			"description" => __( "Please enter a text that you want to use as read more text", THEMENAME ),
			"id"          => "ww_slide_read_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide content title", THEMENAME ),
			"description" => __( "This title will appear after someone will press the read more text button, above the content.", THEMENAME ),
			"id"          => "ww_slide_content_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide content text", THEMENAME ),
			"description" => __( "This text will appear after someone will press the read more button. Please note that you can use HTML in this textarea.", THEMENAME ),
			"id"          => "ww_slide_desc_full",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Slide read more text", THEMENAME ),
			"description" => __( "Please enter a text that you want to use as read more text that will appear bellow the content", THEMENAME ),
			"id"          => "ww_slide_read_text_content",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Content read more link", THEMENAME ),
			"description" => __( "Here you can add a link bellow the content of your slide", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "Circular Content Style 2", THEMENAME ),
	"description" => __( "Circular Content Style 2", THEMENAME ),
	"id"          => "_circ2",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider.Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		$extra_options['circulartwo']

	)
);

/*--------------------------------------------------------------------------------------------------
Circular Content Style 1
--------------------------------------------------------------------------------------------------*/
// CIRCULAR CONTENT 1 SINGLE
$extra_options['circularone'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Circular Content Slides.", THEMENAME ),
	"id"             => "single_circ1",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "ww_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear over the image", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide description", THEMENAME ),
			"description" => __( "This description will appear under the title", THEMENAME ),
			"id"          => "ww_slide_desc",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Slide bottom title", THEMENAME ),
			"description" => __( "This title will appear on the bottom left of the slide", THEMENAME ),
			"id"          => "ww_slide_bottom_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide more text", THEMENAME ),
			"description" => __( "Please enter a text that you want to use as read more text", THEMENAME ),
			"id"          => "ww_slide_read_text",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide content title", THEMENAME ),
			"description" => __( "This title will appear after someone will press the read more text button, above the content.", THEMENAME ),
			"id"          => "ww_slide_content_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide content text", THEMENAME ),
			"description" => __( "This text will appear after someone will press the read more button. Please note that you can use HTML in this textarea.", THEMENAME ),
			"id"          => "ww_slide_desc_full",
			"std"         => "",
			"type"        => "textarea"
		),
		array (
			"name"        => __( "Slide read more text", THEMENAME ),
			"description" => __( "Please enter a text that you want to use as read more text that will appear bellow the content", THEMENAME ),
			"id"          => "ww_slide_read_text_content",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Content read more link", THEMENAME ),
			"description" => __( "Here you can add a link bellow the content of your slide", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "Circular Content Style 1", THEMENAME ),
	"description" => __( "Circular Content Style 1", THEMENAME ),
	"id"          => "_circ1",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider.Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Slidee height", THEMENAME ),
			"description" => __( "Please enter a height number in pixels ( for example : 450 )", THEMENAME ),
			"id"          => "ww_slider_height",
			"std"         => "450",
			"type"        => "text"
		),
		$extra_options['circularone']

	)
);

/*--------------------------------------------------------------------------------------------------
Fancy Slider
--------------------------------------------------------------------------------------------------*/
// FANCY SLIDER SINGLE
$extra_options['fancyslider'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Fancy Slider Slides.", THEMENAME ),
	"id"             => "single_fancy",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "ww_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Slide Color", THEMENAME ),
			"description" => __( "Here you can choose a color for this slide.", THEMENAME ),
			"id"          => "ww_slide_color",
			"std"         => '#699100',
			"type"        => "color"
		)
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "Fancy Slider", THEMENAME ),
	"description" => __( "Fancy Slider", THEMENAME ),
	"id"          => "_fancyslider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		$extra_options['fancyslider']

	)
);

/*--------------------------------------------------------------------------------------------------
WOW Slider
--------------------------------------------------------------------------------------------------*/
// WOW SLIDER SINGLE
$extra_options['wowslider'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Wow Slider Slides.", THEMENAME ),
	"id"             => "single_wow",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "ww_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear over the image", THEMENAME ),
			"id"          => "ww_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "ww_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "Wow Slider", THEMENAME ),
	"description" => __( "Wow Slider", THEMENAME ),
	"id"          => "_wowslider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider.Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ww_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Shadow style", THEMENAME ),
			"description" => __( "Select the desired shadow that you want to use for this slider.", THEMENAME ),
			"id"          => "ww_shadow",
			"std"         => "curved curved-hz-1",
			"type"        => "select",
			"options"     => array (
				'lifted'             => __( 'Lifted', THEMENAME ),
				'curled'             => __( 'Curled', THEMENAME ),
				'perspective'        => __( 'Perspective', THEMENAME ),
				'raised'             => __( 'Raised', THEMENAME ),
				"curved"             => __( "Curved", THEMENAME ),
				"curved curved-vt-1" => __( "curved curved-vt-1", THEMENAME ),
				"curved curved-vt-2" => __( "curved curved-vt-2", THEMENAME ),
				"curved curved-hz-1" => __( "curved curved-hz-1", THEMENAME ),
				"curved curved-hz-2" => __( "curved curved-hz-2", THEMENAME ),
				"lifted rotated"     => __( "lifted rotated", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Slider Transition", THEMENAME ),
			"description" => __( "Select the desired transition that you want to use for this slider.", THEMENAME ),
			"id"          => "ww_transition",
			"std"         => "blast",
			"type"        => "select",
			"options"     => array (
				'blast'  => __( 'Blast', THEMENAME ),
				'blinds' => __( 'Blinds', THEMENAME ),
				'blur'   => __( 'Blur', THEMENAME ),
				'fly'    => __( 'Fly', THEMENAME )
			),
			"class"       => ""
		),
		$extra_options['wowslider']

	)
);

/*--------------------------------------------------------------------------------------------------
Nivo Slider
--------------------------------------------------------------------------------------------------*/
// NIVO SLIDER SINGLE
$extra_options['nivoslider'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Nivo Slider Slides.", THEMENAME ),
	"id"             => "single_nivo",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "nv_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear over the image", THEMENAME ),
			"id"          => "nv_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "nv_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "Nivo Slider", THEMENAME ),
	"description" => __( "Nivo Slider", THEMENAME ),
	"id"          => "_nivoslider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider.Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "nv_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Shadow style", THEMENAME ),
			"description" => __( "Select the desired shadow that you want to use for this slider.", THEMENAME ),
			"id"          => "nv_shadow",
			"std"         => "curved curved-hz-1",
			"type"        => "select",
			"options"     => array (
				'lifted'             => __( 'Lifted', THEMENAME ),
				'curled'             => __( 'Curled', THEMENAME ),
				'perspective'        => __( 'Perspective', THEMENAME ),
				'raised'             => __( 'Raised', THEMENAME ),
				"curved"             => __( "Curved", THEMENAME ),
				"curved curved-vt-1" => __( "curved curved-vt-1", THEMENAME ),
				"curved curved-vt-2" => __( "curved curved-vt-2", THEMENAME ),
				"curved curved-hz-1" => __( "curved curved-hz-1", THEMENAME ),
				"curved curved-hz-2" => __( "curved curved-hz-2", THEMENAME ),
				"lifted rotated"     => __( "lifted rotated", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Slider Transition", THEMENAME ),
			"description" => __( "Select the desired transition that you want to use for this slider.", THEMENAME ),
			"id"          => "nv_transition",
			"std"         => "random",
			"type"        => "select",
			"options"     => array (
				'random'             => __( 'Random', THEMENAME ),
				'sliceDown'          => __( 'sliceDown', THEMENAME ),
				'sliceDownLeft'      => __( 'sliceDownLeft', THEMENAME ),
				'sliceUp'            => __( 'sliceUp', THEMENAME ),
				'sliceUpLeft'        => __( 'sliceUpLeft', THEMENAME ),
				'sliceUpDown'        => __( 'sliceUpDown', THEMENAME ),
				'sliceUpDownLeft'    => __( 'sliceUpDownLeft', THEMENAME ),
				'fold'               => __( 'fold', THEMENAME ),
				'fade'               => __( 'fade', THEMENAME ),
				'slideInRight'       => __( 'slideInRight', THEMENAME ),
				'slideInLeft'        => __( 'slideInLeft', THEMENAME ),
				'boxRandom'          => __( 'boxRandom', THEMENAME ),
				'boxRain'            => __( 'boxRain', THEMENAME ),
				'boxRainReverse'     => __( 'boxRainReverse', THEMENAME ),
				'boxRainGrow'        => __( 'boxRainGrow', THEMENAME ),
				'boxRainGrowReverse' => __( 'boxRainGrowReverse', THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Automatic Transition", THEMENAME ),
			"description" => __( "Select yes if you want the slider to auto advance to each slide, or no, in order to manually change the slide.", THEMENAME ),
			"id"          => "nv_auto_slide",
			"std"         => "1",
			"type"        => "select",
			"options"     => array ( '1' => __( 'No', THEMENAME ), '0' => __( 'Yes', THEMENAME ) ),
			"class"       => ""
		),
		array (
			"name"        => __( "Slider Pause Time", THEMENAME ),
			"description" => __( "How long each slide will show ( default is 5000 ).", THEMENAME ),
			"id"          => "nv_pause_time",
			"std"         => "5000",
			"type"        => "text"
		),
		$extra_options['nivoslider']

	)
);

/*--------------------------------------------------------------------------------------------------
Documentation Header
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Documentation Header", THEMENAME ),
	"description" => __( "Documentation Header", THEMENAME ),
	"id"          => "_zn_doc_header",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Header Style", THEMENAME ),
			"description" => __( "Select the header style you want to use for this page.Please note that header styles can be created from the theme's admin page.", THEMENAME ),
			"id"          => "hm_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		)
	)
);

/*--------------------------------------------------------------------------------------------------
Documentation
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Documentation", THEMENAME ),
	"description" => __( "Documentation", THEMENAME ),
	"id"          => "_zn_documentation",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Number of items", THEMENAME ),
			"description" => __( "Please enter the desired number of items that you want to be shown under each category.", THEMENAME ),
			"id"          => "doc_num_items",
			"std"         => __( "6", THEMENAME ),
			"type"        => "text"
		),
	)
);

/*--------------------------------------------------------------------------------------------------
Custom Header Layout
--------------------------------------------------------------------------------------------------*/
$zn_meta_elements[] = array (
	"name"        => __( "Custom Header Layout", THEMENAME ),
	"description" => __( "Custom Header Layout", THEMENAME ),
	"id"          => "_header_module",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Header Style", THEMENAME ),
			"description" => __( "Select the header style you want to use for this page.Please note that header styles can be created from the theme's admin page.", THEMENAME ),
			"id"          => "hm_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (

			"name"        => __( "Header Height", THEMENAME ),
			"description" => __( "Please enter your desired height in pixels for this header.", THEMENAME ),
			"id"          => "hm_header_height",
			"std"         => __( "300", THEMENAME ),
			"type"        => "text"
		),
		array (
			"name"        => __( "Show Breadcrumbs", THEMENAME ),
			"description" => __( "Select if you want to show the breadcrumbs or not.", THEMENAME ),
			"id"          => "hm_header_bread",
			"std"         => "",
			"type"        => "select",
			"options"     => array ( '1' => __( 'Show', THEMENAME ), '0' => __( 'Hide', THEMENAME ) ),
			"class"       => ""
		),
		array (
			"name"        => __( "Show Date", THEMENAME ),
			"description" => __( "Select if you want to show the current date under breadcrumbs or not.", THEMENAME ),
			"id"          => "hm_header_date",
			"std"         => "",
			"type"        => "select",
			"options"     => array ( '1' => __( 'Show', THEMENAME ), '0' => __( 'Hide', THEMENAME ) ),
			"class"       => ""
		),
		array (
			"name"        => __( "Show Page Title", THEMENAME ),
			"description" => __( "Select if you want to show the page title or not.", THEMENAME ),
			"id"          => "hm_header_title",
			"std"         => "",
			"type"        => "select",
			"options"     => array ( '1' => __( 'Show', THEMENAME ), '0' => __( 'Hide', THEMENAME ) ),
			"class"       => ""
		),
		array (
			"name"        => __( "Show Page Subtitle", THEMENAME ),
			"description" => __( "Select if you want to show the page subtitle or not.", THEMENAME ),
			"id"          => "hm_header_subtitle",
			"std"         => "",
			"type"        => "select",
			"options"     => array ( '1' => __( 'Show', THEMENAME ), '0' => __( 'Hide', THEMENAME ) ),
			"class"       => ""
		)
	)
);

/*--------------------------------------------------------------------------------------------------
CSS3 Pannels
--------------------------------------------------------------------------------------------------*/

// CSS3 SINGLE PANEL
$extra_options['css_panels'] = array (
	"name"           => __( "CSS Panels", THEMENAME ),
	"description"    => __( "Here you can create your CSS3 Panels.", THEMENAME ),
	"id"             => "single_css_panel",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Panel", THEMENAME ),
	"remove_text"    => __( "Panel", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Panel image", THEMENAME ),
			"description" => __( "Select an image for this Panel", THEMENAME ),
			"id"          => "panel_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Panel title", THEMENAME ),
			"description" => __( "Here you can enter a title that will appear on this panel.", THEMENAME ),
			"id"          => "panel_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Panel Title Position", THEMENAME ),
			"description" => __( "Here you can choose where the panel title will be shown", THEMENAME ),
			"id"          => "panel_title_position",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				''      => __( "Normal", THEMENAME ),
				'upper' => __( "Upper", THEMENAME )
			)
		),
		array (
			"name"        => __( "URL", THEMENAME ),
			"description" => __( "Set the url", THEMENAME ),
			"id"          => "title_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)

	)
);

$zn_meta_elements[] = array (

	"name"        => __( "CSS3 Panels", THEMENAME ),
	"description" => __( "CSS3 Panels", THEMENAME ),
	"id"          => "_css_pannel",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slider Height", THEMENAME ),
			"description" => __( "Please enter a numerical value in pixels for your slider height.", THEMENAME ),
			"id"          => "css_height",
			"std"         => __( "600", THEMENAME ),
			"type"        => "text",
			"class"       => ''
		),
		$extra_options['css_panels']
	)
);

/*--------------------------------------------------------------------------------------------------
Flex Slider
--------------------------------------------------------------------------------------------------*/
// Flex SLIDER SINGLE
$extra_options['flexslider'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Flex Slider Slides.", THEMENAME ),
	"id"             => "single_flex",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "fs_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear over the image", THEMENAME ),
			"id"          => "fs_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "fs_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "Flex Slider", THEMENAME ),
	"description" => __( "Flex Slider", THEMENAME ),
	"id"          => "_flexslider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider.Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "fs_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Show Thumbnails?", THEMENAME ),
			"description" => __( "Select if yes if you want to display thumbnails of images on the right side of the slider.", THEMENAME ),
			"id"          => "fs_show_thumbs",
			"std"         => "0",
			"type"        => "select",
			"options"     => array ( '1' => __( 'Yes', THEMENAME ), '0' => __( 'No', THEMENAME ) ),
			"class"       => ""
		),
		array (
			"name"        => __( "Shadow style", THEMENAME ),
			"description" => __( "Select the desired shadow that you want to use for this slider.", THEMENAME ),
			"id"          => "fs_shadow",
			"std"         => "curved curved-hz-1",
			"type"        => "select",
			"options"     => array (
				'lifted'             => __( 'Lifted', THEMENAME ),
				'curled'             => __( 'Curled', THEMENAME ),
				'perspective'        => __( 'Perspective', THEMENAME ),
				'raised'             => __( 'Raised', THEMENAME ),
				"curved"             => __( "Curved", THEMENAME ),
				"curved curved-vt-1" => __( "curved curved-vt-1", THEMENAME ),
				"curved curved-vt-2" => __( "curved curved-vt-2", THEMENAME ),
				"curved curved-hz-1" => __( "curved curved-hz-1", THEMENAME ),
				"curved curved-hz-2" => __( "curved curved-hz-2", THEMENAME ),
				"lifted rotated"     => __( "lifted rotated", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Slider Transition", THEMENAME ),
			"description" => __( "Select the desired transition that you want to use for this slider.", THEMENAME ),
			"id"          => "fs_transition",
			"std"         => "fade",
			"type"        => "select",
			"options"     => array (
				'fade'  => __( 'Fade', THEMENAME ),
				'slide' => __( 'Slide', THEMENAME )
			),
			"class"       => ""
		),
		$extra_options['flexslider']

	)
);

/*--------------------------------------------------------------------------------------------------
ICarousel
--------------------------------------------------------------------------------------------------*/
// ICAROUSEL SINGLE
$extra_options['icarousel'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your iCarousel Slides.", THEMENAME ),
	"id"             => "single_icarousel",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "ic_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear over the image", THEMENAME ),
			"id"          => "ic_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "ic_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "iCarousel", THEMENAME ),
	"description" => __( "iCarousel", THEMENAME ),
	"id"          => "_icarousel",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ic_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		$extra_options['icarousel']

	)
);

/*--------------------------------------------------------------------------------------------------
Laptop Slider
--------------------------------------------------------------------------------------------------*/
// LAPTOP SLIDER SINGLE
$extra_options['lslider'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Laptop Slider Slides.", THEMENAME ),
	"id"             => "single_lslides",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (

		array (
			"name"        => __( "Slide image", THEMENAME ),
			"description" => __( "Select an image for this Slide", THEMENAME ),
			"id"          => "ls_slide_image",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear over the image", THEMENAME ),
			"id"          => "ls_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "ls_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "Laptop Slider", THEMENAME ),
	"description" => __( "Laptop Slider", THEMENAME ),
	"id"          => "_lslider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => false,
	"link"        => true,
	"sizes"       => "sixteen",
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slider Description", THEMENAME ),
			"description" => __( "Here you can enter a description that will appear
											above the slider.", THEMENAME ),
			"id"          => "ls_slider_desc",
			"std"         => "",
			"type"        => "textarea",
			"class"       => ''
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ls_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		$extra_options['lslider']

	)
);

/*--------------------------------------------------------------------------------------------------
Portfolio Slider
--------------------------------------------------------------------------------------------------*/
// PORTFOLIO SLIDER SINGLE
$extra_options['pslider'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your Portfolio Slider Slides.", THEMENAME ),
	"id"             => "single_pslides",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide title", THEMENAME ),
			"description" => __( "This title will appear as browser title", THEMENAME ),
			"id"          => "ps_slide_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "ps_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME )
			)
		),
		array (
			"name"        => __( "Front Image", THEMENAME ),
			"description" => __( "Select an image that will appear on front", THEMENAME ),
			"id"          => "ps_slide_image1",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Left Image", THEMENAME ),
			"description" => __( "Select an image that will appear on left", THEMENAME ),
			"id"          => "ps_slide_image2",
			"std"         => "",
			"type"        => "media"
		),
		array (
			"name"        => __( "Right Image", THEMENAME ),
			"description" => __( "Select an image that will appear on right", THEMENAME ),
			"id"          => "ps_slide_image3",
			"std"         => "",
			"type"        => "media"
		),
	)
);

$zn_meta_elements[] = array (

	"name"        => __( "Portfolio Slider", THEMENAME ),
	"description" => __( "Portfolio Slider", THEMENAME ),
	"id"          => "_pslider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slider Description", THEMENAME ),
			"description" => __( "Here you can enter a description that will appear
											above the slider.", THEMENAME ),
			"id"          => "ps_slider_desc",
			"std"         => "",
			"type"        => "textarea",
			"class"       => ''
		),
		array (
			"name"        => __( "Slder Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "ps_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Sliding Direction", THEMENAME ),
			"description" => __( "Select the desired sliding direction.", THEMENAME ),
			"id"          => "ps_sliding_direction",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				"Horizontal" => __( "Horizontal", THEMENAME ),
				"Vertical"   => __( "Vertical", THEMENAME )
			),
			"class"       => ""
		),
		$extra_options['pslider']

	)
);

/*--------------------------------------------------------------------------------------------------
iOS Slider
--------------------------------------------------------------------------------------------------*/
// iOS SLIDER SINGLE
$extra_options['iosslider'] = array (
	"name"           => __( "Slides", THEMENAME ),
	"description"    => __( "Here you can create your iOS Slider Slides.", THEMENAME ),
	"id"             => "single_iosslider",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Slide", THEMENAME ),
	"remove_text"    => __( "Slide", THEMENAME ),
	"group_sortable" => true,
	"subelements"    => array (
		array (
			"name"        => __( "Slide Image", THEMENAME ),
			"description" => __( "Select an image for this slide", THEMENAME ),
			"id"          => "io_slide_image",
			"std"         => "",
			"type"        => "media",
			"alt"         => "yes"
		),
		array (
			"name"        => __( "Slide main title", THEMENAME ),
			"description" => __( "Enter a main title for this slide", THEMENAME ),
			"id"          => "io_slide_m_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide big title", THEMENAME ),
			"description" => __( "Enter a title for this slide", THEMENAME ),
			"id"          => "io_slide_b_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide small title", THEMENAME ),
			"description" => __( "Enter a small title for this slide", THEMENAME ),
			"id"          => "io_slide_s_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Slide link", THEMENAME ),
			"description" => __( "Here you can add a link to your slide", THEMENAME ),
			"id"          => "io_slide_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_self'  => __( "Same window", THEMENAME ),
				'_blank' => __( "New window", THEMENAME ),
			)
		),
		array (
			"name"        => __( "Link Image?", THEMENAME ),
			"description" => __( "Select yes if you want to also link the slide image. Please note that by enabling this option, in Internet Explorer 8 the swipe function won't behave properly.", THEMENAME ),
			"id"          => "io_slide_link_image",
			"std"         => "no",
			"type"        => "select",
			"options"     => array (
				"yes" => __( "Yes", THEMENAME ),
				"no"  => __( "No", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Slider Caption Style", THEMENAME ),
			"description" => __( "Select the desired style for this slide.", THEMENAME ),
			"id"          => "io_slide_caption_style",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				"style1" => __( "Style 1", THEMENAME ),
				"style2" => __( "Style 2", THEMENAME ),
				"style3" => __( "Style 3", THEMENAME ),
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Slder Caption Animation/Position", THEMENAME ),
			"description" => __( "Select the desired Animation/Position for this
												 slide.", THEMENAME ),
			"id"          => "io_slide_caption_pos",
			"std"         => "",
			"type"        => "select",
			"options"     => array (
				"zn_def_anim_pos" => __( "From Left", THEMENAME ),
				"fromright"       => __( "From Right", THEMENAME )
			),
			"class"       => ""
		)
	)
);

$zn_meta_elements[] = array (
	"name"        => __( "iOS Slider", THEMENAME ),
	"description" => __( "iOS Slider", THEMENAME ),
	"id"          => "_iosSlider",
	"std"         => '',
	"type"        => "group",
	"add_text"    => __( "Item", THEMENAME ),
	"remove_text" => __( "Item", THEMENAME ),
	"hidden"      => true,
	"sizes"       => "sixteen",
	"link"        => true,
	"subelements" => array (
		array (
			"name"  => __( "Sizer Hidden Option", THEMENAME ),
			"desc"  => __( "This option is hidden.", THEMENAME ),
			"id"    => "_sizer",
			"std"   => "sixteen",
			"type"  => "hidden",
			"class" => 'zn_size_input'
		),
		array (
			"name"        => __( "Slider Background Style", THEMENAME ),
			"description" => __( "Select the background style you want to use for this slider. Please note that styles can be created from the unlimited headers options in the theme admin's page.", THEMENAME ),
			"id"          => "io_header_style",
			"std"         => "",
			"type"        => "select",
			"options"     => $header_option,
			"class"       => ""
		),
		array (
			"name"        => __( "Slider Navigation", THEMENAME ),
			"description" => __( "Choose what type of navigation you want to use for your slide.", THEMENAME ),
			"id"          => "io_s_navigation",
			"std"         => "bullets",
			"type"        => "select",
			"options"     => array (
				"bullets" => __( "Bullets", THEMENAME ),
				"thumbs"  => __( "Thumbnails", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Add Fade Effect?", THEMENAME ),
			"description" => __( "Choose if you want to add a bottom fade effect to your slider.", THEMENAME ),
			"id"          => "io_s_fade",
			"std"         => "0",
			"type"        => "select",
			"options"     => array ( "1" => __( "Yes", THEMENAME ), "0" => __( "No", THEMENAME ) ),
			"class"       => ""
		),
		array (
			"name"        => __( "Use fixed width slider?", THEMENAME ),
			"description" => __( "Choose if you want to use a full width slider or a fixed width one.", THEMENAME ),
			"id"          => "io_s_width",
			"std"         => "0",
			"type"        => "select",
			"options"     => array (
				"0" => __( "Full Width", THEMENAME ),
				"1" => __( "Fixed
											Width", THEMENAME )
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Use fixed (scroll) slider?", THEMENAME ),
			"description" => __( "Choose if you want your slider to be fixed on the page when you scroll down", THEMENAME ),
			"id"          => "io_s_scroll",
			"std"         => "0",
			"type"        => "select",
			"options"     => array ( "1" => __( "Yes", THEMENAME ), "0" => __( "No", THEMENAME ) ),
			"class"       => ""
		),
		array (
			"name"        => __( "Transition Speed", THEMENAME ),
			"description" => __( "Enter a numeric value for the transition speed (default: 5000)", THEMENAME ),
			"id"          => "io_s_trans",
			"std"         => __( "5000", THEMENAME ),
			"type"        => "text"
		),
		array (
			"name"        => __( "Slider Height", THEMENAME ),
			"description" => __( "Enter a numeric value for the slider height.Please note that the value will be used as percentage. The default value is 39", THEMENAME ),
			"id"          => "io_s_s_height",
			"std"         => "",
			"type"        => "text"
		),
		$extra_options['iosslider']

	)
);

/*--------------------------------------------------------------------------------------------------
CONTENT AREA
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"link_to"     => "page_options",
	"name"        => __( "Page Layout Options", THEMENAME ),
	"description" => __( "Select your desired layout", THEMENAME ),
	"id"          => "page_layout",
	"std"         => "default",
	"type"        => "select",
	"options"     => array (
		'left_sidebar'  => __( "Left Sidebar", THEMENAME ),
		'right_sidebar' => __( "Right sidebar", THEMENAME ),
		"no_sidebar"    => __( "No sidebar", THEMENAME ),
		"default"       => __( "Default - Set from theme options", THEMENAME ),
	)
);

$page_sidebar       = array_merge( $sidebar_option, array ( 'default' => __( 'Default - Set from theme options', THEMENAME ) ) );
$zn_meta_elements[] = array (
	"link_to"     => "page_options",
	"name"        => __( "Select sidebar", THEMENAME ),
	"description" => __( "Select your desired sidebar to be used on this post", THEMENAME ),
	"id"          => "sidebar_select",
	"std"         => "default",
	"type"        => "select",
	"options"     => $page_sidebar
);

$zn_meta_elements[] = array (
	"link_to"     => "page_options",
	"name"        => __( "Page Builder Layout", THEMENAME ),
	"description" => __( "Select your desired layout for the page builder. You can choose to display
					all the page builder elements bellow the main page content and sidebar or display the Page
					builders Content Main Area bellow the main page content ( on the side of the sidebar )", THEMENAME ),
	"id"          => "page_builder_layout",
	"std"         => "default",
	"type"        => "select",
	"options"     => array (
		'default' => __( "Page builder bellow main content and sidebar", THEMENAME ),
		'style1'  => __( "Page builder and sidebar on same row", THEMENAME )
	)
);

/*--------------------------------------------------------------------------------------------------
SINGLE POST OPTIONS
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"link_to"     => "post_options",
	"name"        => __( "Post Layout Options", THEMENAME ),
	"description" => __( "Select your desired layout", THEMENAME ),
	"id"          => "page_layout",
	"std"         => "default",
	"type"        => "select",
	"options"     => array (
		'left_sidebar'  => __( "Left Sidebar", THEMENAME ),
		'right_sidebar' => __( "Right sidebar", THEMENAME ),
		"no_sidebar"    => __( "No sidebar", THEMENAME ),
		"default"       => __( "Default - Set from theme options", THEMENAME ),
	)
);

$page_sidebar       = array_merge( $sidebar_option, array ( 'default' => __( 'Default - Set from theme options', THEMENAME ) ) );
$zn_meta_elements[] = array (
	"link_to"     => "post_options",
	"name"        => __( "Select sidebar", THEMENAME ),
	"description" => __( "Select your desired sidebar to be used on this post", THEMENAME ),
	"id"          => "sidebar_select",
	"std"         => "default",
	"type"        => "select",
	"options"     => $page_sidebar
);

$zn_meta_elements[] = array (
	"link_to"     => "post_options",
	"name"        => __( "Show Social Share Buttons?", THEMENAME ),
	"description" => __( "Choose if you want to show the social share buttons bellow the post's content.", THEMENAME ),
	"id"          => "show_social",
	"std"         => "default",
	"type"        => "select",
	"options"     => array (
		'show'    => __( 'Show social buttons', THEMENAME ),
		'hide'    => __( 'Do not show social buttons', THEMENAME ),
		'default' => __( 'Default - Set from theme options', THEMENAME )
	)
);

$zn_meta_elements[] = array (
	"link_to"     => "post_options",
	"name"        => __( "Hide page subheader?", THEMENAME ),
	"description" => __( "Chose yes if you want to hide the page sub-header ( including sliders ). Please note
		that this option will overwrite the option set in the admin panel", THEMENAME ),
	"id"          => "zn_disable_subheader",
	"std"         => 'no',
	"options"     => array ( 'yes' => __( "Yes", THEMENAME ), 'no' => __( "No", THEMENAME ) ),
	"type"        => "select"
);

$zn_meta_elements[] = array (
	"link_to"     => "post_options",
	"name"        => __( "Page Builder Layout", THEMENAME ),
	"description" => __( "Select your desired layout for the page builder. You can choose to display all the page builder elements bellow the main page content and sidebar or display the Page builders Content Main Area bellow the main page content ( on the side of the sidebar )", THEMENAME ),
	"id"          => "page_builder_layout",
	"std"         => "default",
	"type"        => "select",
	"options"     => array (
		'default' => __( "Page builder bellow main content and sidebar", THEMENAME ),
		'style1'  => __( "Page builder and sidebar on same row", THEMENAME )
	)
);

/*--------------------------------------------------------------------------------------------------
PORTFOLIO POST OPTIONS
--------------------------------------------------------------------------------------------------*/

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_g_options",
	"name"        => __( "Show Title?", THEMENAME ),
	"description" => __( "Choose yes if you want to show the title above the content.", THEMENAME ),
	"id"          => "page_title_show",
	"std"         => "yes",
	"options"     => array ( "yes" => __( "Yes", THEMENAME ), "no" => __( "No", THEMENAME ) ),
	"type"        => "zn_radio",
);

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_g_options",
	"name"        => __( "Alternative Title", THEMENAME ),
	"description" => __( "Enter your desired title for this page. Please note that this title will appear on the top-right of your header if you choose to use a page header.If this field is not completed, the normal page title will appear in both top-right part of the header as well as the normal location of page title.", THEMENAME ),
	"id"          => "page_title",
	"std"         => "",
	"type"        => "text"
);

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_g_options",
	"name"        => __( "Subtitle", THEMENAME ),
	"description" => __( "Enter your desired subtitle for this page.Please note that the appearance
					of this subtitle is subject of default or custom options of the header part.", THEMENAME ),
	"id"          => "page_subtitle",
	"std"         => "",
	"type"        => "text"
);

$zn_meta_elements[] = array (
	"link_to"     => "portfolio_g_options",
	"name"        => __( "Hide page subheader?", THEMENAME ),
	"description" => __( "Chose yes if you want to hide the page subheader ( including sliders ). Please note
		that this option can be overridden from each page/post", THEMENAME ),
	"id"          => "zn_disable_subheader",
	"std"         => 'no',
	"options"     => array ( 'yes' => __( "Yes", THEMENAME ), 'no' => __( "No", THEMENAME ) ),
	"type"        => "select"
);
