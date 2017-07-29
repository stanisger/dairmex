<?php
// Set the Options Array
global $znData;
if ( ! isset( $znData ) || empty( $znData ) ) {
	$znData = get_option( OPTIONS );
}
global $all_icon_sets, $bootstrap_icons, $zn_options;

include_once( locate_template( array ( 'admin/options/helper-icons.php' ), false ) );

$zn_admin_menu = array ();
$zn_options    = array ();

$zn_admin_menu[] = array (
	"name" => __( "General options", THEMENAME ),
	"id"   => "woo_general_options"
);

$zn_admin_menu[] = array (
	"name" => __( "Categories page", THEMENAME ),
	"id"   => "woo_category_options"
);

$zn_admin_menu[] = array (
	"name" => __( "Single item page", THEMENAME ),
	"id"   => "woo_single_options"
);

$bg_images_path = get_stylesheet_directory() . '/images/bg/'; // change this to where you store your bg images
$bg_images_url  = get_template_directory_uri() . '/images/bg/'; // change this to where you store your bg images
$bg_images      = array ();
if ( is_dir( $bg_images_path ) ) {
	if ( $bg_images_dir = opendir( $bg_images_path ) ) {
		while ( ( $bg_images_file = readdir( $bg_images_dir ) ) !== false ) {
			if ( stristr( $bg_images_file, ".png" ) !== false || stristr( $bg_images_file, ".jpg" ) !== false ) {
				$bg_images[] = $bg_images_url . $bg_images_file;
				natsort( $bg_images );
			}
		}
	}
}

/*--------------------------------------------------------------------------------------------------
	Get all dynamic headers
--------------------------------------------------------------------------------------------------*/
$header_option                        = array ();
$header_option['zn_def_header_style'] = __( 'Default style', THEMENAME );
if ( isset ( $znData['header_generator'] ) && is_array( $znData['header_generator'] ) ) {
	//$sidebars = $znData['sidebar_generator'];
	foreach ( $znData['header_generator'] as $header ) {
		if ( isset ( $header['uh_style_name'] ) && ! empty ( $header['uh_style_name'] ) ) {

			$header_name                   = strtolower( str_replace( ' ', '_', $header['uh_style_name'] ) );
			$header_option[ $header_name ] = $header['uh_style_name'];
		}
	}
}

/*--------------------------------------------------------------------------------------------------
WooCommerce options
--------------------------------------------------------------------------------------------------*/
$sidebar_option                   = array ();
$sidebar_option['defaultsidebar'] = __( 'Default Sidebar', THEMENAME );
if ( isset( $znData['sidebar_generator'] ) && is_array( $znData['sidebar_generator'] ) ) {
	$sidebars = $znData['sidebar_generator'];
	foreach ( $znData['sidebar_generator'] as $sidebar ) {
		if ( $sidebar['sidebar_name'] ) {
			$sidebar_option[ $sidebar['sidebar_name'] ] = $sidebar['sidebar_name'];
		}
	}
}

// Add default sidebar

/*
*			Start WOO GENERAL OPTIONS
------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'woo_general_options'
);

// Show CART in header

$zn_options[] = array (
	"name"        => __( "Enable Catalog Mode ?", THEMENAME ),
	"description" => __( "Choose yes if you want to turn your shop in a catalog mode shop ( all the purchase buttons will be removed. )", THEMENAME ),
	"id"          => "woo_catalog_mode",
	"std"         => __( "no", THEMENAME ),
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Yes", THEMENAME ),
		"no"  => __( "No", THEMENAME )
	)
);

$zn_options[] = array (
	"name"        => __( "Show MY CART in header", THEMENAME ),
	"description" => __( "Choose yes if you want to show a link to MY CART and the total value of the cart in
		the header", THEMENAME ),
	"id"          => "woo_show_cart",
	"std"         => __( "1", THEMENAME ),
	"type"        => "zn_radio",
	"options"     => array (
		"1" => __( "Show", THEMENAME ),
		"0" => __( "Hide", THEMENAME )
	)
);

// Show new items badge

$show_new_badge = array (
	"1" => __( "Show", THEMENAME ),
	"0" => __( "Hide", THEMENAME )
);
$zn_options[]   = array (
	"name"        => __( "Show new items badge ?", THEMENAME ),
	"description" => __( "Choose yes if you want to show a NEW item badge over the new products", THEMENAME ),
	"id"          => "woo_new_badge",
	"std"         => __( "1", THEMENAME ),
	"type"        => "zn_radio",
	"options"     => $show_new_badge
);

$zn_options[] = array (
	"name"        => __( "Hide small description in catalog view and related products ?", THEMENAME ),
	"description" => __( "Choose yes if you want to hide the short description in the catalog mode and related
		products", THEMENAME ),
	"id"          => "woo_hide_small_desc",
	"std"         => __( "no", THEMENAME ),
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Yes", THEMENAME ),
		"no"  => __( "No", THEMENAME )
	)
);

// Days to show as new
$zn_options[] = array (
	"name"        => __( "Days to show badge", THEMENAME ),
	"description" => __( "Please insert the number of days after a product is published to display the badge", THEMENAME ),
	"id"          => "woo_new_badge_days",
	"std"         => __( '3', THEMENAME ),
	"type"        => "text",
	'dependency'  => array ( 'element' => 'woo_new_badge', 'value' => array ( '1' ) ),
);

$zn_options[] = array (
	"name"        => __( "Products per page", THEMENAME ),
	"description" => __( "Enter the desired number of products to be displayed per page.", THEMENAME ),
	"id"          => "woo_show_products_per_page",
	"std"         => "9",
	"type"        => "text",
	"class"       => ""
);

	$zn_options[] = array (
	"type" => 'option_page_end'
);
/*
*			Start WOO CATEGORY OPTIONS
------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'woo_category_options'
);

$zn_options[] = array (
	"name"           => __( "Shop Archive Page Title", THEMENAME ),
	"description"    => __( "Enter the desired page title for the shop archive page.", THEMENAME ),
	"id"             => "woo_arch_page_title",
	"std"            => __( "OUR PRODUCTS", THEMENAME ),
	"type"           => "text",
	"translate_name" => __( "Shop Archive Page Title", THEMENAME ),
	"class"          => ""
);

$zn_options[] = array (
	"name"           => __( "Shop Archive Page Subitle", THEMENAME ),
	"description"    => __( "Enter the desired page subtitle for the Shop archive page.", THEMENAME ),
	"id"             => "woo_arch_page_subtitle",
	"std"            => __( "Shop category here with product list", THEMENAME ),
	"type"           => "text",
	"translate_name" => __( "Shop Archive Page Subtitle", THEMENAME ),
	"class"          => ""
);
$zn_options[] = array (
	"name"        => __( "Shop Archive Sidebar Position", THEMENAME ),
	"description" => __( "Select the position of the sidebar on Shop archive pages.", THEMENAME ),
	"id"          => "woo_arch_sidebar_position",
	"std"         => "right_sidebar",
	"type"        => "select",
	"options"     => array (
		'left_sidebar'  => __( "Left Sidebar", THEMENAME ),
		'right_sidebar' => __( "Right sidebar", THEMENAME ),
		"no_sidebar"    => __( "No sidebar", THEMENAME )
	),
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Shop Archive Default Sidebar", THEMENAME ),
	"description" => __( "Select the default sidebar that will be used on Shop archive pages.", THEMENAME ),
	"id"          => "woo_arch_sidebar",
	"std"         => "",
	"type"        => "select",
	"options"     => $sidebar_option,
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Image size", THEMENAME ),
	"description" => __( "Enter the desired image sizes for the category images. Please note that the single item image sizes can be set from WooCommerce options.", THEMENAME ),
	"id"          => "woo_cat_image_size",
	"std"         => "",
	"type"        => "image_size",
	"class"       => ""
);

$zn_options[] = array (
	"type" => 'option_page_end'
);
/*
*			Start WOO SINGLE OPTIONS
------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'woo_single_options'
);
$zn_options[] = array (
	"name"        => __( "Shop Single Sidebar Position", THEMENAME ),
	"description" => __( "Select the position of the sidebar on Shop Single pages.", THEMENAME ),
	"id"          => "woo_single_sidebar_position",
	"std"         => "right_sidebar",
	"type"        => "select",
	"options"     => array (
		'left_sidebar'  => __( "Left Sidebar", THEMENAME ),
		'right_sidebar' => __( "Right sidebar", THEMENAME ),
		"no_sidebar"    => __( "No sidebar", THEMENAME )
	),
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Shop Single Default Sidebar", THEMENAME ),
	"description" => __( "Select the default sidebar that will be used on Shop Single pages.", THEMENAME ),
	"id"          => "woo_single_sidebar",
	"std"         => "",
	"type"        => "select",
	"options"     => $sidebar_option,
	"class"       => ""
);

$zn_options[] = array (
	"type" => 'option_page_end'
);