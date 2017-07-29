<?php
// Set the Options Array
$data = get_option( OPTIONS );
global $all_icon_sets, $bootstrap_icons;

include_once( locate_template( array ( 'admin/options/helper-icons.php' ), false ) );

$zn_admin_menu   = array ();
$zn_admin_menu[] = array (
	"name"     => __( "General Options", THEMENAME ),
	"id"       => "general_options",
	"submenus" => array (
		array (
			"name"  => __( "General options", THEMENAME ),
			"id"    => "zn_gen_options",
			"class" => "active"
		),
		array (
			"name"  => __( "Logo options", THEMENAME ),
			"id"    => "logo_options",
		),
		array (
			"name" => __( "Favicon options", THEMENAME ),
			"id"   => "favicon_options"
		),
		array (
			"name" => __( "WPML Options", THEMENAME ),
			"id"   => "wpml_options"
		),
		array (
			"name" => __( "Header options", THEMENAME ),
			"id"   => "theader_options"
		),
		array (
			"name" => __( "Footer options", THEMENAME ),
			"id"   => "copyright_options"
		),
		array (
			"name" => __( "Default Header options", THEMENAME ),
			"id"   => "def_header"
		),
		array (
			"name" => __( "Hidden panel options", THEMENAME ),
			"id"   => "hidden_panel"
		),
		array (
			"name" => __( "Google Analytics", THEMENAME ),
			"id"   => "google_analytics"
		),
		array (
			"name" => __( "Mailchimp", THEMENAME ),
			"id"   => "mailchimp_api"
		),
		array (
			"name" => __( "Facebook", THEMENAME ),
			"id"   => "facebook_options"
		),
		array (
			"name" => __( "reCaptcha", THEMENAME ),
			"id"   => "recaptcha_options"
		)
	)
);

$zn_admin_menu[] = array (
	"name"     => __( "Font Options", THEMENAME ),
	"id"       => "font_options",
	"submenus" => array (
		array (
			"name" => __( "General Font Options", THEMENAME ),
			"id"   => "font_options"
		),
		array (
			"name" => __( "Headings", THEMENAME ),
			"id"   => "font_heading_options"
		),
		array (
			"name" => __( "Body Fonts", THEMENAME ),
			"id"   => "font_body_options"
		),
		array (
			"name" => __( "Main Menu", THEMENAME ),
			"id"   => "font_menu_options"
		),
	)
);

$zn_admin_menu[] = array (
	"name"     => __( "Blog Options", THEMENAME ),
	"id"       => "blog_options",
	"submenus" => array (
		array (
			"name" => __( "Archive options", THEMENAME ),
			"id"   => "archive_blog_options"
		),
		array (
			"name" => __( "Single blog item options", THEMENAME ),
			"id"   => "single_blog_option"
		)
	)
);

$zn_admin_menu[] = array (
	"name" => __( "Page options", THEMENAME ),
	"id"   => "page_default_options"
);
$zn_admin_menu[] = array (
	"name" => __( "Portfolio options", THEMENAME ),
	"id"   => "portfolio_options"
);

$zn_admin_menu[] = array (
	"name" => __( "Documentation options", THEMENAME ),
	"id"   => "documentation_options"
);

$zn_admin_menu[] = array (
	"name" => __( "Layout options", THEMENAME ),
	"id"   => "layout_options"
);
$zn_admin_menu[] = array (
	"name" => __( "Color options", THEMENAME ),
	"id"   => "color_options"
);
$zn_admin_menu[] = array (
	"name" => __( "Unlimited headers", THEMENAME ),
	"id"   => "uh_headers"
);
$zn_admin_menu[] = array (
	"name" => __( "Unlimited sidebars", THEMENAME ),
	"id"   => "sidebar_options"
);
$zn_admin_menu[] = array (
	"name" => __( "Coming Soon Options", THEMENAME ),
	"id"   => "cs_options"
);
$zn_admin_menu[] = array (
	"name" => __( "404 Page Options", THEMENAME ),
	"id"   => "404_options"
);

$zn_admin_menu[] = array (
	"name" => __( "Advanced", THEMENAME ),
	"id"   => "advanced_options"
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
if ( isset ( $data['header_generator'] ) && is_array( $data['header_generator'] ) ) {
	//$sidebars = $data['sidebar_generator'];
	foreach ( $data['header_generator'] as $header ) {
		if ( isset ( $header['uh_style_name'] ) && ! empty ( $header['uh_style_name'] ) ) {
			$header_name                   = strtolower( str_replace( ' ', '_', $header['uh_style_name'] ) );
			$header_option[ $header_name ] = $header['uh_style_name'];
		}
	}
}

global $zn_options;
$zn_options = array ();

// SET THEME DEFAULTS

$color1 = '#81C50A'; // GREEN
$color2 = '#CCCCCC';
$color3 = '#FFFFFF'; // WHITE
$color4 = '#666666';
$color5 = '#999999';
$color6 = '#EBEBEB'; // Separator color
$color7 = '#ADADAD'; // Blog info link color

/*
	*			START GENERAL OPTIONS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'zn_gen_options'
);

$zn_options[] = array (
	"name"        => __( "Show Follow menu?", THEMENAME ),
	"description" => __( "Chose yes if you want the menu to follow the user on the page.", THEMENAME ),
	"id"          => "menu_follow",
	"std"         => '',
	"options"     => array ( 'yes' => __( "Yes", THEMENAME ), 'no' => __( "No", THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"name"        => __( "Responsive menu style", THEMENAME ),
	"description" => __( "Please choose the responsive menu style you want to use.", THEMENAME ),
	"id"          => "res_menu_style",
	"std"         => 'select',
	"options"     => array ( 'select' => __( "Drop down", THEMENAME ), 'smooth' => __( "Smooth menu", THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"name"        => __( "Use page preloader?", THEMENAME ),
	"description" => __( "Chose yes if you want to show a page preloader.", THEMENAME ),
	"id"          => "page_preloader",
	"std"         => 'no',
	"options"     => array ( 'yes' => __( "Yes", THEMENAME ), 'no' => __( "No", THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"name"        => __( "Hide page subheader?", THEMENAME ),
	"description" => __( "Chose yes if you want to hide the page subheader ( including sliders ). Please note
		that this option can be overridden from each page/post", THEMENAME ),
	"id"          => "zn_disable_subheader",
	"std"         => 'no',
	"options"     => array ( 'yes' => __( "Yes", THEMENAME ), 'no' => __( "No", THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"name"        => __( "Use first attached image ?", THEMENAME ),
	"description" => __( "Chose yes if you want the theme to display the first image inside a page if no
		featured image is present", THEMENAME ),
	"id"          => "zn_use_first_image",
	"std"         => 'yes',
	"options"     => array ( 'yes' => __( "Yes", THEMENAME ), 'no' => __( "No", THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"name"        => __( "Comments", THEMENAME ),
	"description" => __( "Chose where to display the comments: before or after the Page Builder content.", THEMENAME ),
	"id"          => "zn_set_location_page_comments",
	"std"         => 0,
	"options"     => array ( 0 => __( "Before", THEMENAME ), 1 => __( "After", THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			START LOGO OPTIONS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'logo_options'
);

// Logo Upload

$zn_options[] = array (
	"name"        => __( "Logo Upload", THEMENAME ),
	"description" => __( "Upload your logo.", THEMENAME ),
	"id"          => "logo_upload",
	"std"         => '',
	"type"        => "media"
);

// Logo auto size ?

$logo_size    = array (
	"yes"     => __( "Auto resize logo", THEMENAME ),
	"no"      => __( "Custom size", THEMENAME ),
	"contain" => __( "Contain in header", THEMENAME ),
);
$zn_options[] = array (
	"name"        => __( "Logo Size :", THEMENAME ),
	"description" => __( "Auto resize logo will use the image dimensions, Custom size let's you set the desired logo size and Contain in header will select the proper logo size so that it will be displayed in the header.", THEMENAME ),
	"id"          => "logo_size",
	"std"         => "yes",
	"type"        => "zn_radio",
	"options"     => $logo_size,
);

// Logo Dimensions

$default_size = array (
	'height' => '42',
	'width'  => '126'
);
$zn_options[] = array (
	"name"        => __( "Logo manual sizes", THEMENAME ),
	"description" => __( 'Please insert your desired logo size in pixels ( for example "35" )', THEMENAME ),
	"id"          => "logo_manual_size",
	"std"         => $default_size,
	"type"        => "image_size",
	'dependency'  => array ( 'element' => 'logo_size', 'value' => array ( 'no' ) ),
);

// Logo typography for link

$zn_options[] = array (
	"name"        => __( "Logo Link Options", THEMENAME ),
	"description" => __( "Specify the logo typography properties. Will only work if you don't upload a logo image.", THEMENAME ),
	"id"          => "logo_font",
	"std"         => array (
		'size'   => '36px',
		'face'   => 'Open Sans',
		'style'  => 'normal',
		'color'  => '#000',
		'height' => '40px'
	),
	"type"        => "typography"
);

// Logo Hover Typography

$zn_options[] = array (
	"name"        => __( "Logo Link Hover Color", THEMENAME ),
	"description" => __( "Specify the logo hover color. Will only work if you don't upload a logo image. ", THEMENAME ),
	"id"          => "logo_hover",
	"std"         => array (
		'color' => '#CD2122',
		'face'  => ''
	),
	"type"        => "typography"
);
$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start FAVICON OPTIONS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'favicon_options'
);
$zn_options[] = array (
	"name"        => __( "Favicon Image", THEMENAME ),
	"description" => __( "Upload your desired favicon image.", THEMENAME ),
	"id"          => "custom_favicon",
	"std"         => '',
	"type"        => "media"
);
$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start GENERAL FONT OPTIONS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'font_options'
);

$zn_options[] = array (
	"name"        => __( "Google fonts subsets", THEMENAME ),
	"description" => __( "Here you can add your google fonts subsets that you want to use (like Latin and Cyrillic for example). Please note that each subset must be divided by a comma and there should be no empty space between them.", THEMENAME ),
	"id"          => "g_fonts_subset",
	"std"         => '',
	"type"        => "text"
);

// GET THE FONTS

/*	Load Google Fonts if they are needed */
$normal_faces = array ( 'arial', 'verdana', 'trebuchet', 'georgia', 'times', 'tahoma', 'palatino', 'helvetica' );

if ( is_array( $data['fonts'] ) ) {
	$data['fonts'] = array_diff( array_unique( $data['fonts'] ), $normal_faces );
}
else {
	$data['fonts'] = array ();
}

$zn_options[] = array (
	"name"        => __( "Google fonts set-up", THEMENAME ),
	"description" => __( "DESC.", THEMENAME ),
	"id"          => "g_fonts_setup",
	"std"         => $data['fonts'],
	"fonts"       => $data['fonts'],
	"type"        => "zn_g_fonts"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start FONT HEADINGS OPTIONS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'font_heading_options'
);

$zn_options[] = array (
	"name"        => __( "H1 Typography", THEMENAME ),
	"description" => __( "Specify the typography properties for headings.", THEMENAME ),
	"id"          => "h1_typo",
	"std"         => array (
		'size'   => '36px',
		'face'   => 'Open Sans',
		'height' => '40px'
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"name"        => __( "H2 Typography", THEMENAME ),
	"description" => __( "Specify the typography properties for headings.", THEMENAME ),
	"id"          => "h2_typo",
	"std"         => array (
		'size'   => '30px',
		'face'   => 'Open Sans',
		'height' => '40px'
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"name"        => __( "H3 Typography", THEMENAME ),
	"description" => __( "Specify the typography properties for headings.", THEMENAME ),
	"id"          => "h3_typo",
	"std"         => array (
		'size'   => '24px',
		'face'   => 'Open Sans',
		'height' => '40px'
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"name"        => __( "H4 Typography", THEMENAME ),
	"description" => __( "Specify the typography properties for headings.", THEMENAME ),
	"id"          => "h4_typo",
	"std"         => array (
		'size'   => '14px',
		'face'   => 'Open Sans',
		'height' => '20px'
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"name"        => __( "H5 Typography", THEMENAME ),
	"description" => __( "Specify the typography properties for headings.", THEMENAME ),
	"id"          => "h5_typo",
	"std"         => array (
		'size'   => '12px',
		'face'   => 'Open Sans',
		'height' => '20px'
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"name"        => __( "H6 Typography", THEMENAME ),
	"description" => __( "Specify the typography properties for headings.", THEMENAME ),
	"id"          => "h6_typo",
	"std"         => array (
		'size'   => '12px',
		'face'   => 'Open Sans',
		'height' => '20px'
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start FONT BODY OPTIONS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'font_body_options'
);

// Body font options

$zn_options[] = array (
	"name"        => __( "Body Font Options", THEMENAME ),
	"description" => __( "Specify the typography properties for the body section ( this will apply to all the
		content on the page ).", THEMENAME ),
	"id"          => "body_font",
	"std"         => array (
		'size'   => '13px',
		'face'   => 'Open Sans',
		'height' => '19px',
		'color'  => ''
	),
	"type"        => "typography"
);

// Grey area font options

$zn_options[] = array (
	"name"        => __( "Grey Area Font Options", THEMENAME ),
	"description" => __( "Specify the typography properties for the grey area section.", THEMENAME ),
	"id"          => "ga_font",
	"std"         => array (
		'size'   => '13px',
		'face'   => 'Open Sans',
		'height' => '19px',
		'color'  => ''
	),
	"type"        => "typography"
);

// Footer font options
$zn_options[] = array (
	"name"        => __( "Footer Font Options", THEMENAME ),
	"description" => __( "Specify the typography properties for the Footer.", THEMENAME ),
	"id"          => "footer_font",
	"std"         => array (
		'size'   => '13px',
		'face'   => 'Open Sans',
		'height' => '19px',
		'color'  => ''
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start FONT MENU OPTIONS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'font_menu_options'
);

$menu_color = '#fff';
if ( ! empty ( $data['zn_mainmenu_color'] ) ) {
	$menu_color = $data['zn_mainmenu_color'];
}

// Menu TYPOGRAPHY
$zn_options[] = array (
	"name"        => __( "Menu Font Options", THEMENAME ),
	"description" => __( "Specify the typography properties for the Main Menu.", THEMENAME ),
	"id"          => "menu_font",
	"std"         => array (
		'size'   => '14px',
		'face'   => 'Lato',
		'height' => '14px',
		'color'  => $menu_color,
		'style'  => 'bold'
	),
	"type"        => "typography"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start WPML
	------------------------------------------------------------*/

$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'wpml_options'
);

// Show LINK to LOGIN

$zn_options[] = array (
	"name"        => __( "Show WPML languages ?", THEMENAME ),
	"description" => __( "Choose yes if you want to show WPML languages in header. Please note that you will
		need WPML installed.", THEMENAME ),
	"id"          => "head_show_flags",
	"std"         => "1",
	"type"        => "zn_radio",
	"options"     => array (
		"1" => __( "Show", THEMENAME ),
		"0" => __( "Hide", THEMENAME )
	)
);
$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start TOP HEADER OPTIONS
	------------------------------------------------------------*/

$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'theader_options'
);

$zn_options[] = array (
	"name"        => __( "Header Layout", THEMENAME ),
	"description" => __( "Please choose the desired header layout.", THEMENAME ),
	"id"          => "zn_header_layout",
	"std"         => "style2",
	"options"     => array (
		'style1' => __( 'Style 1', THEMENAME ),
		'style2' => __( 'Style 2 (default)', THEMENAME ),
		'style3' => __( 'Style 3', THEMENAME ),
		'style4' => __( 'Style 4', THEMENAME ),
		'style5' => __( 'Style 5', THEMENAME ),
		'style6' => __( 'Style 6', THEMENAME )
	),
	"type"        => "select"
);

// HEADER STYLE
$zn_options[] = array (
	"name"        => __( "Header Style", THEMENAME ),
	"description" => __( "Select the desired style for the header", THEMENAME ),
	"id"          => "header_style",
	"std"         => "default",
	"type"        => "zn_radio",
	"options"     => array (
		'default'     => __( "Default", THEMENAME ),
		'image_color' => __( 'Background Image & color', THEMENAME ),
	),
);

// HEADER IMAGE
$zn_options[] = array (
	"name"        => __( "Header Background Image", THEMENAME ),
	"description" => __( "Please choose your desired image to be used as a background", THEMENAME ),
	"id"          => "header_style_image",
	"std"         => '',
	"options"     => array ( "repeat" => true, "position" => true, "attachment" => true ),
	"type"        => "background",
	'dependency'  => array ( 'element' => 'header_style', 'value' => array ( 'image_color' ) ),
);

// HEADER Color
$zn_options[] = array (
	"name"        => __( "Background Color", THEMENAME ),
	"description" => __( "Please choose your desired background color for the header", THEMENAME ),
	"id"          => "header_style_color",
	"std"         => '#000',
	"type"        => "color",
	"class"       => "header_style-image_color"
);

// Show LINK to LOGIN
$zn_options[] = array (
	"name"        => __( "Show Login in header", THEMENAME ),
	"description" => __( "Choose yes if you want to show a link that will let users login/register or retrieve their lost password. Please note that in order to show the registration page, you need to allow user registration from General settings.", THEMENAME ),
	"id"          => "head_show_login",
	"std"         => "1",
	"type"        => "zn_radio",
	"options"     => array (
		"1" => __( "Show", THEMENAME ),
		"0" => __( "Hide", THEMENAME )
	)
);

// Show LOGO In header
$zn_options[] = array (
	"name"        => __( "Show LOGO in header", THEMENAME ),
	"description" => __( "Please choose if you want to display the logo or not.", THEMENAME ),
	"id"          => "head_show_logo",
	"std"         => "yes",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);

// Show SEARCH In header
$zn_options[] = array (
	"name"        => __( "Show SEARCH in header", THEMENAME ),
	"description" => __( "Please choose if you want to display the search button or not.", THEMENAME ),
	"id"          => "head_show_search",
	"std"         => "yes",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);

// Show Call to Action Button In header
$zn_options[] = array (
	"name"        => __( "Show Call to Action button in header", THEMENAME ),
	"description" => __( "Please choose if you want to display the call to action button or not.", THEMENAME ),
	"id"          => "head_show_cta",
	"std"         => "no",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);
	// BG Color
	$zn_options[] = array (
		"name"        => __( "Select background color", THEMENAME ),
		"description" => __( "Select page background color.", THEMENAME ),
		"id"          => "wpk_cs_bg_color",
		"std"         => '#cd2122',
		"type"        => "color",
		'dependency'  => array ( 'element' => 'head_show_cta', 'value' => array ( 'yes' ) ),
	);

// Set text for Call to Action Button In header
$zn_options[] = array (
	"name"        => __( "Set the text for the Call to Action button", THEMENAME ),
	"description" => __( "Select the text you want to display int the call to action button.", THEMENAME ),
	"id"          => "head_set_text_cta",
	"type"        => "text",
	"std"         => __( "<strong>FREE</strong>QUOTE", THEMENAME ),
	'dependency'  => array ( 'element' => 'head_show_cta', 'value' => array ( 'yes' ) ),
);

	// FG Color
	$zn_options[] = array (
		"name"        => __( "Select text color", THEMENAME ),
		"description" => __( "Select text color.", THEMENAME ),
		"id"          => "wpk_cs_fg_color",
		"std"         => '#fff',
		"type"        => "color",
		'dependency'  => array ( 'element' => 'head_show_cta', 'value' => array ( 'yes' ) ),
	);


	// Add link to Call to Action Button
$zn_options[] = array (
	"name"        => __( "Set the link for the Call to Action button in header", THEMENAME ),
	"description" => __( "Set the URL to link the Call to Action button to.", THEMENAME ),
	"id"          => "head_add_cta_link",
	"std"         => "",
	"type"        => "link_new",
	'dependency'  => array ( 'element' => 'head_show_cta', 'value' => array ( 'yes' ) ),
);





// Show Info Card on Logo Hover
$zn_options[] = array (
	"name"        => __( "Show Info Card when you hover over the logo", THEMENAME ),
	"description" => __( "Please choose if you want to display the info card or not.", THEMENAME ),
	"id"          => "infocard_display_status",
	"std"         => "no",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);

$saved_main_color = ! empty( $data['zn_main_color'] ) ? $data['zn_main_color'] : '#cd2122';
// Background for the Info Card
$zn_options[] = array (
	"name"        => __( "Set a background for the Info Card", THEMENAME ),
	"description" => __( "Choose the background color for the Info Card", THEMENAME ),
	"id"          => "infocard_bg_color",
	"std"         => $saved_main_color,
	"type"        => "color",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

// Info Card company logo
$zn_options[] = array (
	"name"        => __( "Choose company logo", THEMENAME ),
	"description" => __( "Choose your company logo which will appear in info card", THEMENAME ),
	"id"          => "infocard_logo_url",
	"std"         => "",
	"type"        => "media",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

// Info Card company description
$zn_options[] = array (
	"name"        => __( "Company Description", THEMENAME ),
	"description" => __( "Please type a small description of your company", THEMENAME ),
	"id"          => "infocard_company_description",
	"std"         => "Kallyas is an ultra-premium, responsive theme built for today websites.",
	"type"        => "text",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

// Info Card company description
$zn_options[] = array (
	"name"        => __( "Company phone", THEMENAME ),
	"description" => __( "Please type your company phone number", THEMENAME ),
	"id"          => "infocard_company_phone",
	"std"         => __( "T (212) 555 55 00", THEMENAME ),
	"type"        => "text",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

// Info Card company description
$zn_options[] = array (
	"name"        => __( "Company email", THEMENAME ),
	"description" => __( "Please type your company email", THEMENAME ),
	"id"          => "infocard_company_email",
	"std"         => __( "sales@yourwebsite.com", THEMENAME ),
	"type"        => "text",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

// Info Card company name
$zn_options[] = array (
	"name"        => __( "Company name", THEMENAME ),
	"description" => __( "Type your company name here", THEMENAME ),
	"id"          => "infocard_company_name",
	"std"         => __( "Your Company LTD", THEMENAME ),
	"type"        => "text",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

// Info Card company address
$zn_options[] = array (
	"name"        => __( "Company address", THEMENAME ),
	"description" => __( "Type your company address here", THEMENAME ),
	"id"          => "infocard_company_address",
	"std"         => __( "Street nr 100, 4536534, Chicago, US", THEMENAME ),
	"type"        => "text",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

// Info Card company name
$zn_options[] = array (
	"name"        => __( "Company name", THEMENAME ),
	"description" => __( "Please type your company name here", THEMENAME ),
	"id"          => "infocard_gmap_link",
	"std"         => "http://goo.gl/maps/1OhOu",
	"type"        => "text",
	'dependency'  => array ( 'element' => 'infocard_display_status', 'value' => array ( 'yes' ) ),
);

$zn_options[]         = array (
	"name"        => __( "Social Icons", THEMENAME ),
	"description" => __( "Here you can configure what social icons to appear on the right side of the header.", THEMENAME ),
	"id"          => "header_social_icons",
	"std"         => "",
	"type"        => "group",
	"use_name"    => "header_social_title",
	"add_text"    => __( "Social Icon", THEMENAME ),
	"remove_text" => __( "Social Icon", THEMENAME ),
	"subelements" => array (
		array (
			"name"        => __( "Icon title", THEMENAME ),
			"description" => __( "Here you can enter a title for this social icon.Please note that this is just
				for your information as this text will not be visible on the site.", THEMENAME ),
			"id"          => "header_social_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Social icon link", THEMENAME ),
			"description" => __( "Please enter your desired link for the social icon. If this field is left
				blank, the icon will not be linked.", THEMENAME ),
			"id"          => "header_social_link",
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
			"id"          => "header_social_icon",
			"std"         => "",
			"options"     => $all_icon_sets,
			"type"        => "zn_icon_font"
		)
	),
	"class"       => ""
);
$footer_colored_icons = array (
	'normal'  => __( 'Normal Icons', THEMENAME ),
	'colored' => __( 'Colored icons', THEMENAME )
);
$zn_options[]         = array (
	"name"        => __( "Use normal or colored social icons?", THEMENAME ),
	"description" => __( "Here you can choose to use the normal social icons or the colored version of each
		icon.", THEMENAME ),
	"id"          => "header_which_icons_set",
	"std"         => "",
	"type"        => "select",
	"options"     => $footer_colored_icons,
	"class"       => ""
);

// Show/Hide Social Icons in header
$zn_options[] = array (
	"name"        => __( "Show or hide the Social icons in the header.", THEMENAME ),
	"description" => __( "Please select the visibility status of the Social Icons(this setting will not affect
		the visibility of Social Icons from the info Card)", THEMENAME ),
	"id"          => "social_icons_visibility_status",
	"std"         => "yes",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
*			Start COPYRIGHT OPTIONS
------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'copyright_options'
);

// Show Footer
$zn_options[] = array (
	"name"        => __( "Show Footer", THEMENAME ),
	"description" => __( "Using this option you can choose to display the footer or not.", THEMENAME ),
	"id"          => "footer_show",
	"std"         => "yes",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);

$zn_options[] = array (
	"name"        => __( "Copyright text", THEMENAME ),
	"description" => __( "Enter your desired copyright text. Please note that you can copy ' &copy; ' and place
		it in the text.", THEMENAME ),
	"id"          => "copyright_text",
	"std"         => __( "&copy; 2013 Copyright by ZnThemes. All rights reserved.", THEMENAME ),
	"type"        => "textarea"
);

// Show Footer ROW 1
$zn_options[] = array (
	"name"        => __( "Show Row 1 widgets ?", THEMENAME ),
	"description" => __( "Select yes if you want to show the first row of widgets.", THEMENAME ),
	"id"          => "footer_row1_show",
	"std"         => "yes",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);

$zn_options[] = array (
	"name"              => __( "Footer Row 1 Widget positions", THEMENAME ),
	"description"       => __( "Here you can select how your footer row 1 widgets will be displayed. You can select to
		 use up to 4 widgets positions in various sizes.", THEMENAME ),
	"id"                => "footer_row1_widget_positions",
	"std"               => '{"3":[["4","4","4"]]}',
	"type"              => "widget_positions",
	"number_of_columns" => "4",
	"columns_positions" => array (
		"1" => array (
			array (
				"12"
			)
		),
		"2" => array (
			array (
				"6",
				"6"
			)
		),
		"3" => array (
			array (
				"4",
				"4",
				"4"
			),
			array (
				"5",
				"4",
				"3"
			),
			array (
				"5",
				"3",
				"4"
			),
			array (
				"4",
				"5",
				"3"
			),
			array (
				"4",
				"3",
				"5"
			),
			array (
				"3",
				"4",
				"5"
			),
			array (
				"3",
				"5",
				"4"
			)
		),
		"4" => array (
			array (
				"3",
				"3",
				"3",
				"3"
			),
			array (
				"5",
				"4",
				"2",
				"1"
			)
		)
	)
);

// Show Footer ROW 2
$zn_options[] = array (
	"name"        => __( "Show Row 2 widgets ?", THEMENAME ),
	"description" => __( "Select yes if you want to show the second row of widgets.", THEMENAME ),
	"id"          => "footer_row2_show",
	"std"         => "yes",
	"type"        => "zn_radio",
	"options"     => array (
		"yes" => __( "Show", THEMENAME ),
		"no"  => __( "Hide", THEMENAME )
	)
);

$zn_options[] = array (
	"name"              => __( "Footer Row 2 Widget positions", THEMENAME ),
	"description"       => __( "Here you can select how your footer row 2 widgets will be displayed. You can select to
		 use up to 4 widgets positions in various sizes.", THEMENAME ),
	"id"                => "footer_row2_widget_positions",
	"std"               => '{"2":[["6","6"]]}',
	"type"              => "widget_positions",
	"number_of_columns" => "4",
	"columns_positions" => array (
		"1" => array (
			array (
				"12"
			)
		),
		"2" => array (
			array (
				"6",
				"6"
			)
		),
		"3" => array (
			array (
				"4",
				"4",
				"4"
			),
			array (
				"5",
				"4",
				"3"
			),
			array (
				"5",
				"3",
				"4"
			),
			array (
				"4",
				"5",
				"3"
			),
			array (
				"4",
				"3",
				"5"
			),
			array (
				"3",
				"4",
				"5"
			),
			array (
				"3",
				"5",
				"4"
			)
		),
		"4" => array (
			array (
				"3",
				"3",
				"3",
				"3"
			),
			array (
				"5",
				"4",
				"2",
				"1"
			)
		)
	)
);
$zn_options[] = array (
	"name"        => __( "Copyright Logo image", THEMENAME ),
	"description" => __( "Upload your desired logo image that will appear on the left side of the copyright
		text.", THEMENAME ),
	"id"          => "footer_logo",
	"std"         => '',
	"type"        => "media"
);

// FOOTER STYLE
$zn_options[] = array (
	"name"        => __( "Style", THEMENAME ),
	"description" => __( "Select the desired style for the footer", THEMENAME ),
	"id"          => "footer_style",
	"std"         => "default",
	"type"        => "zn_radio",
	"options"     => array (
		'default'     => __( "Default", THEMENAME ),
		'image_color' => __( 'Background Image & color', THEMENAME ),
	),
);

// FOOTER IMAGE
$zn_options[] = array (
	"name"        => __( "Background Image", THEMENAME ),
	"description" => __( "Please choose your desired image to be used as a background", THEMENAME ),
	"id"          => "footer_style_image",
	"std"         => '',
	"options"     => array ( "repeat" => true, "position" => true, "attachment" => true ),
	"type"        => "background",
	'dependency'  => array ( 'element' => 'footer_style', 'value' => array ( 'image_color' ) ),
);

// FOOTER Color
$zn_options[] = array (
	"name"        => __( "Background Color", THEMENAME ),
	"description" => __( "Please choose your desired background color for the footer", THEMENAME ),
	"id"          => "footer_style_color",
	"std"         => '#000',
	"type"        => "color",
	'dependency'  => array ( 'element' => 'footer_style', 'value' => array ( 'image_color' ) ),
);

// FOOTER Color
$zn_options[] = array (
	"name"        => __( "Border Color", THEMENAME ),
	"description" => __( "Please choose your desired color for the footer border", THEMENAME ),
	"id"          => "footer_border_color",
	"std"         => '#484848',
	"type"        => "color"
);

$zn_options[]         = array (
	"name"        => __( "Social Icons", THEMENAME ),
	"description" => __( "Here you can configure what social icons to appear on the right side of the copyright
		text.", THEMENAME ),
	"id"          => "footer_social_icons",
	"std"         => "",
	"type"        => "group",
	"use_name"    => "footer_social_title",
	"add_text"    => __( "Social Icon", THEMENAME ),
	"remove_text" => __( "Social Icon", THEMENAME ),
	"subelements" => array (
		array (
			"name"        => __( "Icon title", THEMENAME ),
			"description" => __( "Here you can enter a title for this social icon.Please note that this is just
				for your information as this text will not be visible on the site.", THEMENAME ),
			"id"          => "footer_social_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Social icon link", THEMENAME ),
			"description" => __( "Please enter your desired link for the social icon. If this field is left
				blank, the icon will not be linked.", THEMENAME ),
			"id"          => "footer_social_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME ),
			)
		),
		array (
			"name"        => __( "Social icon", THEMENAME ),
			"description" => __( "Select your desired social icon.", THEMENAME ),
			"id"          => "footer_social_icon",
			"std"         => "",
			"options"     => $all_icon_sets,
			"type"        => "zn_icon_font"
		)
	),
	"class"       => ""
);
$footer_colored_icons = array (
	'normal'  => __( 'Normal Icons', THEMENAME ),
	'colored' => __( 'Colored icons', THEMENAME ),
);
$zn_options[]         = array (
	"name"        => __( "Use normal or colored social icons?", THEMENAME ),
	"description" => __( "Here you can choose to use the normal social icons or the colored version of each
		icon.", THEMENAME ),
	"id"          => "footer_which_icons_set",
	"std"         => "",
	"type"        => "select",
	"options"     => $footer_colored_icons,
	"class"       => ""
);
$zn_options[]         = array (
	"type" => 'option_page_end'
);
/*
	*			Start DEFAULT HEADER
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'def_header'
);

// Header background image

$zn_options[] = array (
	"name"        => __( "Header Background image", THEMENAME ),
	"description" => __( "Upload your desired background image for the header.", THEMENAME ),
	"id"          => "def_header_background",
	"std"         => '',
	"type"        => "media"
);

// Header background color

$zn_options[] = array (
	"name"        => __( "Header Background Color", THEMENAME ),
	"description" => __( "Here you can choose a default color for your header.If you do not select a background
		image, this color will be used as background.", THEMENAME ),
	"id"          => "def_header_color",
	"std"         => '#AAAAAA',
	"type"        => "color"
);

$zn_options[] = array (
	"name"        => __( "Add gradient over color?", THEMENAME ),
	"description" => __( "Select yes if you want add a gradient over the selected color", THEMENAME ),
	"id"          => "def_grad_bg",
	"std"         => "1",
	"type"        => "select",
	"options"     => array (
		"1" => __( "Yes", THEMENAME ),
		"0" => __( "No", THEMENAME ),
	),
	"class"       => ""
);

// HEADER - Animate

$def_header_anim = array (
	'1' => __('Yes', THEMENAME),
	'0' => __('No', THEMENAME),
);
$zn_options[]    = array (
	"name"        => __( "Use animated header", THEMENAME ),
	"description" => __( "Select if you want to add an animation on top of your image/color.", THEMENAME ),
	"id"          => "def_header_animate",
	"std"         => "0",
	"type"        => "select",
	"options"     => $def_header_anim,
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Add Glare effect?", THEMENAME ),
	"description" => __( "Select yes if you want to add a glare effect over the background", THEMENAME ),
	"id"          => "def_glare",
	"std"         => "0",
	"type"        => "select",
	"options"     => array (
		"1" => __( "Yes", THEMENAME ),
		"0" => __( "No", THEMENAME )
	),
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Bottom style?", THEMENAME ),
	"description" => __( "Select the header bottom style you want to use", THEMENAME ),
	"id"          => "def_bottom_style",
	"std"         => "0",
	"type"        => "select",
	"options"     => array (
		"none"      => __( "None", THEMENAME ),
		"shadow"    => __( "Shadow Up", THEMENAME ),
		"shadow_ud" => __( "Shadow Up and down", THEMENAME ),
		"mask1"     => __( "Bottom mask 1", THEMENAME ),
		"mask2"     => __( "Bottom mask 2", THEMENAME )
	)
);

// HEADER show breadcrumbs

$def_header_bread = array (
	'1' => __( 'Show', THEMENAME ),
	'0' => __( 'Hide', THEMENAME ),
);
$zn_options[]     = array (
	"name"        => __( "Show Breadcrumbs", THEMENAME ),
	"description" => __( "Select if you want to show the breadcrumbs or not.", THEMENAME ),
	"id"          => "def_header_bread",
	"std"         => "",
	"type"        => "select",
	"options"     => $def_header_bread,
	"class"       => ""
);

// HEADER show date

$def_header_date = array (
	'1' => 'Show',
	'0' => 'Hide'
);
$zn_options[]    = array (
	"name"        => __( "Show Date", THEMENAME ),
	"description" => __( "Select if you want to show the current date under breadcrumbs or not.", THEMENAME ),
	"id"          => "def_header_date",
	"std"         => "",
	"type"        => "select",
	"options"     => $def_header_date,
	"class"       => ""
);

// HEADER show title

$def_header_title = array (
	'1' => __( 'Show', THEMENAME ),
	'0' => __( 'Hide', THEMENAME ),
);
$zn_options[]     = array (
	"name"        => __( "Show Page Title", THEMENAME ),
	"description" => __( "Select if you want to show the page title or not.", THEMENAME ),
	"id"          => "def_header_title",
	"std"         => "",
	"type"        => "select",
	"options"     => $def_header_title,
	"class"       => ""
);

// HEADER show subtitle

$def_header_subtitle = array (
	'1' => __( 'Show', THEMENAME ),
	'0' => __( 'Hide', THEMENAME ),
);
$zn_options[]        = array (
	"name"        => __( "Show Page Subtitle", THEMENAME ),
	"description" => __( "Select if you want to show the page subtitle or not.", THEMENAME ),
	"id"          => "def_header_subtitle",
	"std"         => "",
	"type"        => "select",
	"options"     => $def_header_subtitle,
	"class"       => ""
);

// HEADER Custom height
//@since 3.6.9
//@k
$zn_options[]        = array (
	"name"        => __( "Custom height", THEMENAME ),
	"description" => __( "Set the custom header height, in pixels. Leave empty to use the default value.", THEMENAME ),
	"id"          => "def_header_custom_height",
	"std"         => "",
	"type"        => "text",
	"class"       => ""
);

$zn_options[] = array (
	"type" => 'option_page_end'
);


	/*
		*			Start HIDDEN PANEL
		------------------------------------------------------------*/

	$zn_options[] = array (
		"type" => 'option_page_start',
		"id"   => 'hidden_panel'
	);
	$zn_options[] = array (
		"name"        => __( "Select background color", THEMENAME ),
		"description" => __( "Select background color for the hidden panel.", THEMENAME ),
		"id"          => "hidden_panel_bg",
		"std"         => '#F0F0F0',
		"type"        => "color"
	);
	$zn_options[] = array (
		"name"        => __( "Select font color", THEMENAME ),
		"description" => __( "Select font color for the hidden panel.", THEMENAME ),
		"id"          => "hidden_panel_fg",
		"std"         => '#000000',
		"type"        => "color"
	);
	$zn_options[] = array (
		"type" => 'option_page_end'
	);



/*
	*			Start GOOGLE ANALYTICS
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'google_analytics'
);
$zn_options[] = array (
	"name"        => __( "Google Analytics Code", THEMENAME ),
	"description" => __( "Paste your google analytics code bellow.", THEMENAME ),
	"id"          => "google_analytics",
	"std"         => '',
	"type"        => "textarea"
);
$zn_options[] = array (
	"type" => 'option_page_end'
);
/*
	*			Start MAILCHIMP API
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'mailchimp_api'
);
$zn_options[] = array (
	"name"        => __( "Mailchimp API KEY", THEMENAME ),
	"description" => __( "Paste your mailchimp api key that will be used by the mailchimp widget.", THEMENAME ),
	"id"          => "mailchimp_api",
	"std"         => '',
	"type"        => "text"
);
$zn_options[] = array (
	"type" => 'option_page_end'
);
/*
	*			Start General Blog options
	------------------------------------------------------------*/
$sidebar_option                   = array ();
$sidebar_option['defaultsidebar'] = __( 'Default Sidebar', THEMENAME );
if ( isset( $data['sidebar_generator'] ) && is_array( $data['sidebar_generator'] ) ) {
	$sidebars = $data['sidebar_generator'];
	foreach ( $data['sidebar_generator'] as $sidebar ) {
		if ( $sidebar['sidebar_name'] ) {
			$sidebar_option[ $sidebar['sidebar_name'] ] = $sidebar['sidebar_name'];
		}
	}
}

// Add default sidebar

/*
	*			Start Archive Blog options
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'archive_blog_options'
);

$zn_options[] = array (
	"name"        => __( "Blog Columns", THEMENAME ),
	"description" => __( "Select the number of columns you want to use.", THEMENAME ),
	"id"          => "blog_style_layout",
	"std"         => "1",
	"type"        => "select",
	"options"     => array (
		'1' => __( "1", THEMENAME ),
		'2' => __( "2", THEMENAME ),
		'3' => __( "3", THEMENAME ),
		'4' => __( "4", THEMENAME ),
	),
	"class"       => ""
);

$zn_options[] = array (
	"name"           => __( "Archive Page Title", THEMENAME ),
	"description"    => __( "Enter the desired page title for the blog archive page.", THEMENAME ),
	"id"             => "archive_page_title",
	"type"           => "text",
	"std"            => __( "BLOG & Gossip", THEMENAME ),
	"translate_name" => __( "Archive Page Title", THEMENAME ),
	"class"          => ""
);
$zn_options[] = array (
	"name"           => __( "Archive Page Subitle", THEMENAME ),
	"description"    => __( "Enter the desired page subtitle for the blog archive page.", THEMENAME ),
	"id"             => "archive_page_subtitle",
	"type"           => "text",
	"std"            => __( "This would be the blog category page", THEMENAME ),
	"translate_name" => __( "Archive Page Subtitle", THEMENAME ),
	"class"          => ""
);

$zn_options[] = array (
	"name"        => __( "Use full width image", THEMENAME ),
	"description" => __( "Choose Use full width image option if you want the images to be full width rather then
		the default layout", THEMENAME ),
	"id"          => "sb_archive_use_full_image",
	"std"         => "no",
	"type"        => "select",
	"options"     => array (
		'yes' => __( 'Use full width image', THEMENAME ),
		'no'  => __( 'Use default layout', THEMENAME ),
	)
);

$zn_options[] = array (
	"name"        => __( "Archive Sidebar Position", THEMENAME ),
	"description" => __( "Select the position of the sidebar on archive pages.", THEMENAME ),
	"id"          => "archive_sidebar_position",
	"std"         => "right_sidebar",
	"type"        => "select",
	"options"     => array (
		'left_sidebar'  => __( "Left Sidebar", THEMENAME ),
		'right_sidebar' => __( "Right sidebar", THEMENAME ),
		"no_sidebar"    => __( "No sidebar", THEMENAME ),
	),
	"class"       => ""
);
$zn_options[] = array (
	"name"        => __( "Archive Default Sidebar", THEMENAME ),
	"description" => __( "Select the default sidebar that will be used on archive pages.", THEMENAME ),
	"id"          => "archive_sidebar",
	"std"         => "",
	"type"        => "select",
	"options"     => $sidebar_option,
	"class"       => ""
);
$zn_options[] = array (
	"type" => 'option_page_end'
);
/*
	*			Start Single Blog options
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'single_blog_option'
);

$zn_options[] = array (
	"name"        => __( "Use full width image", THEMENAME ),
	"description" => __( "Choose Use full width image option if you want the images to be full widht rather then
		 the default layout", THEMENAME ),
	"id"          => "sb_use_full_image",
	"std"         => __( "no", THEMENAME ),
	"type"        => "select",
	"options"     => array (
		'yes' => __( 'Use full width image', THEMENAME ),
		'no'  => __( 'Use default layout', THEMENAME ),
	)
);

$zn_options[] = array (
	"name"        => __( "Default Sidebar Position", THEMENAME ),
	"description" => __( "Select the default position of the sidebars throughout the site.", THEMENAME ),
	"id"          => "default_sidebar_position",
	"std"         => "right_sidebar",
	"type"        => "select",
	"options"     => array (
		'left_sidebar'  => __( "Left Sidebar", THEMENAME ),
		'right_sidebar' => __( "Right sidebar", THEMENAME ),
		"no_sidebar"    => __( "No sidebar", THEMENAME ),
	),
	"class"       => ""
);
$zn_options[] = array (
	"name"        => __( "Single Post Default Sidebar", THEMENAME ),
	"description" => __( "Select the default sidebar that will be used on single post pages. Please note you can
		 select a different sidebar from the post edit page.", THEMENAME ),
	"id"          => "single_sidebar",
	"std"         => "defaultsidebar",
	"type"        => "select",
	"options"     => $sidebar_option,
	"class"       => ""
);
$zn_options[] = array (
	"name"        => __( "Show Social Share Buttons?", THEMENAME ),
	"description" => __( "Choose if you want to show the social share buttons bellow the post's content.", THEMENAME ),
	"id"          => "show_social",
	"std"         => __( "show", THEMENAME ),
	"type"        => "select",
	"options"     => array (
		'show' => __( 'Show social buttons', THEMENAME ),
		'hide' => __( 'Do not show social buttons', THEMENAME ),
	)
);
$zn_options[] = array (
	"type" => 'option_page_end'
);
/*
	*			Start PAGE DEFAULT options
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'page_default_options'
);
$zn_options[] = array (
	"name"        => __( "Page Sidebar Position", THEMENAME ),
	"description" => __( "Select the position of the sidebar on archive pages.", THEMENAME ),
	"id"          => "page_sidebar_position",
	"std"         => "no_sidebar",
	"type"        => "select",
	"options"     => array (
		'left_sidebar'  => __( "Left Sidebar", THEMENAME ),
		'right_sidebar' => __( "Right sidebar", THEMENAME ),
		"no_sidebar"    => __( "No sidebar", THEMENAME ),
	),
	"class"       => ""
);
$zn_options[] = array (
	"name"        => __( "Page Default Sidebar", THEMENAME ),
	"description" => __( "Select the default sidebar that will be used on archive pages.", THEMENAME ),
	"id"          => "page_sidebar",
	"std"         => "",
	"type"        => "select",
	"options"     => $sidebar_option,
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Enable Page Comments", THEMENAME ),
	"description" => __( "Please select if you want to enable the page comments. Please note that you can
		override this setting from each page.", THEMENAME ),
	"id"          => "zn_enable_page_comments",
	"std"         => __( "no", THEMENAME ),
	"options"     => array ( 'yes' => __( 'Yes', THEMENAME ), 'no' => __( 'No', THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start PORTFOLIO options
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'portfolio_options'
);

$zn_options[] = array (
	"name"        => __( "Portfolio Archive style", THEMENAME ),
	"description" => __( "Select the desired style for the portfolio archive pages.", THEMENAME ),
	"id"          => "portfolio_style",
	"std"         => "portfolio_sortable",
	"type"        => "select",
	"options"     => array (
		'portfolio_category' => __( 'Portfolio Category', THEMENAME ),
		'portfolio_sortable' => __( 'Portfolio Sortable', THEMENAME ),
		'portfolio_carousel' => __( 'Portfolio Carousel Layout', THEMENAME ),
	),
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Portfolio items to show", THEMENAME ),
	"description" => __( "Please enter the desired number of portfolio items that will be loaded.(-1 will
		display all posts. Default is -1).", THEMENAME ),
	"id"          => "portfolio_per_page",
	"std"         => "-1",
	"type"        => "text",
);

$zn_options[] = array (
	"name"        => __( "Portfolio items per page", THEMENAME ),
	"description" => __( "Please enter the desired number of portfolio items that will be displayed on a page.", THEMENAME ),
	"id"          => "portfolio_per_page_show",
	"std"         => __( "4", THEMENAME ),
	"type"        => "text",
);

$zn_options[] = array (
	"name"        => __( "Number of columns", THEMENAME ),
	"description" => __( "Please enter how many portfolio items you want to load on a page if you choose to use
		the portfolio category style.", THEMENAME ),
	"id"          => "ports_num_columns",
	"std"         => "4",
	"options"     => array (
		'1' => __( '1', THEMENAME ),
		'2' => __( '2', THEMENAME ),
		'3' => __( '3', THEMENAME ),
		'4' => __( '4', THEMENAME ),
	),
	"type"        => "select"
);

$zn_options[] = array (
	"name"        => __( "Link Portfolio Media", THEMENAME ),
	"description" => __( "Select Yes if you want your portfolio images to be linked to the portfolio item as
		opposed to open the image in lightbox. ( only works with portfolio sortable )", THEMENAME ),
	"id"          => "zn_link_portfolio",
	"std"         => "no",
	"options"     => array ( 'yes' => __( 'Yes', THEMENAME ), 'no' => __( 'No', THEMENAME ) ),
	"type"        => "select"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start DOCUMENTATION options
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'documentation_options'
);

$zn_options[] = array (
	"name"        => __( "Header Style", THEMENAME ),
	"description" => __( "Select the header style you want to use for this page. Please note that
					header styles can be created from the theme's admin page.", THEMENAME ),
	"id"          => "zn_doc_header_style",
	"std"         => "",
	"type"        => "select",
	"options"     => $header_option,
	"class"       => ""
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start LAYOUT options
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'layout_options'
);

$zn_options[] = array (
	"name"        => __( "Responsive options", THEMENAME ),
	"description" => __( "Please choose if you want to enable or not the responsive styles of the theme.", THEMENAME ),
	"id"          => "zn_responsive",
	"std"         => "yes",
	"options"     => array (
		'yes' => __( 'Enable Responsive Style', THEMENAME ),
		'no'  => __( 'Disable Responsive
		Style', THEMENAME )
	),
	"type"        => "select"
);

// BOXED LAYOUT
$zn_options[] = array (
	"name"        => __( "Use Boxed Layout", THEMENAME ),
	"description" => __( "Choose yes if you want to use the boxed layout instead of the full width.", THEMENAME ),
	"id"          => "zn_boxed_layout",
	"std"         => "no",
	"type"        => "zn_radio",
	"options"     => array ( 'no' => __( 'No', THEMENAME ), 'yes' => __( 'Yes', THEMENAME ) ),
);

// BACKGROUND IMAGE
$zn_options[] = array (
	"name"        => __( "Background Image", THEMENAME ),
	"description" => __( "Please choose your desired image to be used as a background", THEMENAME ),
	"id"          => "boxed_style_image",
	"std"         => '',
	"options"     => array ( "repeat" => true, "position" => true, "attachment" => true ),
	"type"        => "background",
	'dependency'  => array ( 'element' => 'zn_boxed_layout', 'value' => array ( 'yes' ) ),
);

// BACKGROUND COLOR
$zn_options[] = array (
	"name"        => __( "Background Color", THEMENAME ),
	"description" => __( "Please choose your desired background color", THEMENAME ),
	"id"          => "boxed_style_color",
	"std"         => '#fff',
	"type"        => "color",
	'dependency'  => array ( 'element' => 'zn_boxed_layout', 'value' => array ( 'yes' ) ),
);

// BOXED LAYOUT FOR HOMEPAGE
$zn_options[] = array (
	"name"        => __( "Homepage Boxed Layout", THEMENAME ),
	"description" => __( "Here you can choose a specific layout setting for the homepage that will override the
		setting from above.", THEMENAME ),
	"id"          => "zn_home_boxed_layout",
	"std"         => "def",
	"type"        => "zn_radio",
	"options"     => array (
		'def' => __( 'Default', THEMENAME ),
		'no'  => __( 'No', THEMENAME ),
		'yes' => __( 'Yes', THEMENAME )
	),
);

$zn_options[] = array (
	"name"        => __( "Content size", THEMENAME ),
	"description" => __( "Please choose the desired default size for the content.", THEMENAME ),
	"id"          => "zn_width",
	"std"         => "1170",
	"options"     => array ( '1170' => '1170px', '960' => '960px' ),
	"type"        => "select"
);

// START SLIDER AFTER HEADER
$zn_options[] = array (
	"name"        => __( "Start Slider/header area after header?", THEMENAME ),
	"description" => __( "If set to yes, the slider/subheader area will start bellow the header.", THEMENAME ),
	"id"          => "zn_slider_header",
	"std"         => "no",
	"type"        => "zn_radio",
	"options"     => array ( 'no' => __( 'No', THEMENAME ), 'yes' => __( 'Yes', THEMENAME ) ),
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*
	*			Start COLOR options
	------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'color_options'
);

$zn_options[] = array (
	"name"        => __( "Main Color", THEMENAME ),
	"description" => __( "Please choose a main color for your site.", THEMENAME ),
	"id"          => "zn_main_color",
	"std"         => "#cd2122",
	"type"        => "color"
);

$zn_options[] = array (
	"name"        => __( "Top Nav default Color", THEMENAME ),
	"description" => __( "Please choose a color for the top nav links in header.", THEMENAME ),
	"id"          => "zn_top_nav_color",
	"std"         => "",
	"type"        => "color"
);

$zn_options[] = array (
	"name"        => __( "Top Nav Hover Color", THEMENAME ),
	"description" => __( "Please choose a color for the top nav links in header when hovering over them.", THEMENAME ),
	"id"          => "zn_top_nav_h_color",
	"std"         => "",
	"type"        => "color"
);

$zn_options[] = array (
	"name"        => __( "Content background Color", THEMENAME ),
	"description" => __( "Please choose a default color for the site's body.", THEMENAME ),
	"id"          => "zn_body_def_color",
	"std"         => "",
	"type"        => "color"
);

// BACKGROUND IMAGE
$zn_options[] = array (
	"name"        => __( "Content Background Image", THEMENAME ),
	"description" => __( "Please choose your desired image to be used as as body background", THEMENAME ),
	"id"          => "body_back_image",
	"std"         => '',
	"options"     => array ( "repeat" => true, "position" => true, "attachment" => true ),
	"type"        => "background"
);

$zn_options[] = array (
	"name"        => __( "Grey area background Color", THEMENAME ),
	"description" => __( "Please choose a background color for the grey area.", THEMENAME ),
	"id"          => "zn_gr_area_def_color",
	"std"         => "",
	"type"        => "color"
);

// BACKGROUND IMAGE
$zn_options[] = array (
	"name"        => __( "Grey Area Background Image", THEMENAME ),
	"description" => __( "Please choose your desired image to be used as as grey area background", THEMENAME ),
	"id"          => "gr_arr_back_image",
	"std"         => '',
	"options"     => array ( "repeat" => true, "position" => true, "attachment" => true ),
	"type"        => "background"
);

$zn_options[] = array (
	"name"        => __( "Color Style", THEMENAME ),
	"description" => __( "Please choose the desired default size for the content.", THEMENAME ),
	"id"          => "zn_main_style",
	"std"         => "1170",
	"options"     => array (
		'light' => __( 'Light Style ( default )', THEMENAME ),
		'dark'  => __( 'Dark Style', THEMENAME )
	),
	"type"        => "select"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*--------------------------------------------------------------------------------------------------
	Unlimited headers
	--------------------------------------------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'uh_headers'
);
$zn_options[] = array (
	"name"           => __( "Header Styles Generator", THEMENAME ),
	"description"    => __( "Here you can create unlimited header styles to be used on different pages.", THEMENAME ),
	"id"             => "header_generator",
	"std"            => "",
	"type"           => "group",
	"add_text"       => __( "Header Style", THEMENAME ),
	"remove_text"    => __( "Header Style", THEMENAME ),
	"use_name"       => "uh_style_name",
	"group_sortable" => false,
	"subelements"    => array (
		array (
			"name"        => __( "Header Style Name", THEMENAME ),
			"description" => __( "The name of this header style.Please note that all names must be unique.", THEMENAME ),
			"id"          => "uh_style_name",
			"std"         => '',
			"type"        => "text",
			"mod"         => 'disabled'
		),
		array (
			"name"        => __( "Background image", THEMENAME ),
			"description" => __( "Select a background image for your header.", THEMENAME ),
			"id"          => "uh_background_image",
			"std"         => "",
			"type"        => "media",
			"class"       => ''
		),
		array (
			"name"        => __( "Header Background Color", THEMENAME ),
			"description" => __( "Here you can choose a default color for your header.If you do not select a
				background image, this color will be used as background.", THEMENAME ),
			"id"          => "uh_header_color",
			"std"         => '#AAAAAA',
			"type"        => "color"
		),
		array (
			"name"        => __( "Add gradient over color?", THEMENAME ),
			"description" => __( "Select yes if you want add a gradient over the selected color", THEMENAME ),
			"id"          => "uh_grad_bg",
			"std"         => "1",
			"type"        => "select",
			"options"     => array (
				"1" => __( "Yes", THEMENAME ),
				"0" => __( "No", THEMENAME ),
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Animate Background?", THEMENAME ),
			"description" => __( "Select yes if you want to make your background animated", THEMENAME ),
			"id"          => "uh_anim_bg",
			"std"         => "0",
			"type"        => "select",
			"options"     => array (
				"1" => __( "Yes", THEMENAME ),
				"0" => __( "No", THEMENAME ),
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Add Glare effect?", THEMENAME ),
			"description" => __( "Select yes if you want to add a glare effect over the background", THEMENAME ),
			"id"          => "uh_glare",
			"std"         => "0",
			"type"        => "select",
			"options"     => array (
				"1" => __( "Yes", THEMENAME ),
				"0" => __( "No", THEMENAME ),
			),
			"class"       => ""
		),
		array (
			"name"        => __( "Bottom style?", THEMENAME ),
			"description" => __( "Select the header bottom style you want to use", THEMENAME ),
			"id"          => "uh_bottom_style",
			"std"         => "0",
			"type"        => "select",
			"options"     => array (
				"none"      => __( "None", THEMENAME ),
				"shadow"    => __( "Shadow Up", THEMENAME ),
				"shadow_ud" => __( "Shadow Up and down", THEMENAME ),
				"mask1"     => __( "Bottom mask 1", THEMENAME ),
				"mask2"     => __( "Bottom mask 2", THEMENAME ),
			),
			"class"       => ""
		)
	),
	"class"          => ""
);
$zn_options[] = array (
	"type" => 'option_page_end'
);
/*--------------------------------------------------------------------------------------------------
	Sidebar Generator
	--------------------------------------------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'sidebar_options'
);
$zn_options[] = array (
	"name"        => __( "Sidebar Generator", THEMENAME ),
	"description" => __( "Here you can create unlimited sidebars to be used on different pages.", THEMENAME ),
	"id"          => "sidebar_generator",
	"std"         => "",
	"type"        => "group",
	"add_text"    => __( "Sidebar", THEMENAME ),
	"remove_text" => __( "Sidebar", THEMENAME ),
	"use_name"    => "sidebar_name",
	"subelements" => array (
		array (
			"name"        => __( "Sidebar name", THEMENAME ),
			"description" => __( "Enter your desired name for this sidebar. Please note that this name must be unique and if multiple sidebars are registered with the same name , only the first sidebar will be shown", THEMENAME ),
			"id"          => "sidebar_name",
			"std"         => "",
			"type"        => "text"
		)
	),
	"class"       => ""
);
$zn_options[] = array (
	"type" => 'option_page_end'
);
/*--------------------------------------------------------------------------------------------------
	Coming Soon Options
	--------------------------------------------------------------------------------------------------*/
$mail_lists = array ();
if ( ! empty( $data['mailchimp_api'] ) ) {
	if ( ! class_exists( 'MCAPI' ) ) {
		include_once( TEMPLATEPATH . '/widgets/mailchimp/MCAPI.class.php' );
	}

	$api_key = $data['mailchimp_api'];
	$mcapi   = new MCAPI( $api_key );
	$lists   = $mcapi->lists();
	if ( ! empty( $lists['data'] ) ) {
		foreach ( $lists['data'] as $key => $value ) {
			$mail_lists[ $value['id'] ] = $value['name'];
		}
	}
}

$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'cs_options'
);

// ENABLE COMING SOON PAGE

$zn_options[] = array (
	"name"        => __( "Enable Coming Soon?", THEMENAME ),
	"description" => __( "If enabled, the visitors will be displayed the coming soon page. Please note that
		all logged in users will still be able to see your site.", THEMENAME ),
	"id"          => "cs_enable",
	"std"         => "no",
	"type"        => "zn_radio",
	"options"     => array (
		'yes' => 'Enable',
		'no'  => 'Disable'
	),
);

// ENABLE COMING SOON PAGE

$zn_options[] = array (
	"name"           => __( "Description", THEMENAME ),
	"description"    => __( "Enter a description that will appear above the countdown clock.", THEMENAME ),
	"id"             => "cs_desc",
	"std"            => __( "We are currently working on a new website and won't take long. Please don't forget to check
		out our tweets and to subscribe to be notified!", THEMENAME ),
	"type"           => "textarea",
	"translate_name" => __( "Coming Soon Page Description", THEMENAME ),
	'dependency'     => array ( 'element' => 'cs_enable', 'value' => array ( 'yes' ) ),
);

// ENABLE COMING SOON PAGE

$zn_options[] = array (
	"name"        => __( "Launch date", THEMENAME ),
	"description" => __( "Please select the date when your site will be available.", THEMENAME ),
	"id"          => "cs_date",
	"std"         => "",
	"type"        => "date_picker",
	'dependency'  => array ( 'element' => 'cs_enable', 'value' => array ( 'yes' ) ),
);

// MAILCHIMP LIST ID

$zn_options[] = array (
	"name"        => __( "Mailchimp List ID", THEMENAME ),
	"description" => __( "Please select the mailchimp list ID you want to use. Please note that in order for the theme to display your list id's ,you will need to enter your Mailchimp API id in the General options > Mailchimp API option", THEMENAME ),
	"id"          => "cs_lsit_id",
	"std"         => "",
	"type"        => "select",
	"options"     => $mail_lists,
	'dependency'  => array ( 'element' => 'cs_enable', 'value' => array ( 'yes' ) ),
);
$zn_options[] = array (
	"name"        => __( "Social Icons", THEMENAME ),
	"description" => __( "Here you can configure what social icons to appear on the right side of the MailChimp
		form.", THEMENAME ),
	"id"          => "cs_social_icons",
	"std"         => "",
	"type"        => "group",
	"use_name"    => "cs_social_title",
	"add_text"    => __( "Social Icon", THEMENAME ),
	"remove_text" => __( "Social Icon", THEMENAME ),
	"subelements" => array (
		array (
			"name"        => __( "Icon title", THEMENAME ),
			"description" => __( "Here you can enter a title for this social icon.Please note that this is just
				for your information as this text will not be visible on the site.", THEMENAME ),
			"id"          => "cs_social_title",
			"std"         => "",
			"type"        => "text"
		),
		array (
			"name"        => __( "Social icon link", THEMENAME ),
			"description" => __( "Please enter your desired link for the social icon. If this field is left
				blank, the icon will not be linked.", THEMENAME ),
			"id"          => "cs_social_link",
			"std"         => "",
			"type"        => "link",
			"options"     => array (
				'_blank' => __( "New window", THEMENAME ),
				'_self'  => __( "Same window", THEMENAME ),
			)
		),
		array (
			"name"        => __( "Social icon", THEMENAME ),
			"description" => __( "Select your desired social icon.", THEMENAME ),
			"id"          => "cs_social_icon",
			"std"         => "",
			"options"     => $all_icon_sets,
			"type"        => "zn_icon_font"
		)
	),
	'dependency'  => array ( 'element' => 'cs_enable', 'value' => array ( 'yes' ) ),
);
$zn_options[] = array (
	"type" => 'option_page_end'
);


/*--------------------------------------------------------------------------------------------------
	Get all dynamic headers
	--------------------------------------------------------------------------------------------------*/
$header_option                        = array ();
$header_option['zn_def_header_style'] = 'Default style';
if ( isset( $data['header_generator'] ) && is_array( $data['header_generator'] ) ) {

	// $sidebars = $data['sidebar_generator'];

	foreach ( $data['header_generator'] as $header ) {
		if ( isset( $header['uh_style_name'] ) && ! empty( $header['uh_style_name'] ) ) {
			$header_name                   = strtolower( str_replace( ' ', '_', $header['uh_style_name'] ) );
			$header_option[ $header_name ] = $header['uh_style_name'];
		}
	}
}

/*--------------------------------------------------------------------------------------------------
	404 PAGE OPTIONS
	--------------------------------------------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => '404_options'
);
$zn_options[] = array (
	"name"        => __( "Header Style", THEMENAME ),
	"description" => __( 'Select the background style you want to use.Please note that the styles can be created
		 from the "Unlimited Headers" options in the theme admin\'s page.', THEMENAME ),
	"id"          => "404_header_style",
	"std"         => "",
	"type"        => "select",
	"options"     => $header_option,
	"class"       => ""
);
$zn_options[] = array (
	"type" => 'option_page_end'
);

/*--------------------------------------------------------------------------------------------------
	ADVANCED OPTIONS
	--------------------------------------------------------------------------------------------------*/
$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'advanced_options'
);

$zn_options[] = array (
	"name"        => __( "Themeforest Username", THEMENAME ),
	"description" => __( "Please fill in your Themeforest username.", THEMENAME ),
	"id"          => "zn_theme_username",
	"std"         => "",
	"type"        => "text",
);

$zn_options[] = array (
	"name"        => __( "Themeforest API key", THEMENAME ),
	"description" => __( "Please fill in your Themeforest API key.", THEMENAME ),
	"id"          => "zn_theme_api",
	"std"         => "",
	"type"        => "text",
);

$zn_options[] = array (
	"name"        => __( "Enable Menu Caching?", THEMENAME ),
	"description" => __( "By selecting yes, the menus added by Kallyas theme will be chached. This will grately improve the page loading speed when you have a big menu structure. Please note that this option may not work properly with multiple plugins and server configurations.", THEMENAME ),
	"id"          => "cache_menu",
	"std"         => "no",
	"type"        => "select",
	"options"     => array (
		"yes" => __( "Yes", THEMENAME ),
		"no"  => __( "No", THEMENAME ),
	),
	"class"       => ""
);

$zn_options[] = array (
	"name"        => __( "Custom CSS", THEMENAME ),
	"description" => __( "Here you can add your own custom css.", THEMENAME ),
	"id"          => "zn_custom_css",
	"std"         => "",
	"type"        => "textarea",
);

$zn_options[] = array (
	"name"        => __( "Install Dummy Data", THEMENAME ),
	"description" => __( "Press this button if you want your blog filled with demo data as seen on the demo site
		. Please note that the images will not be imported.", THEMENAME ),
	"id"          => "install_dummy",
	"type"        => "one_click_install",
);

$zn_options[] = array (
	"name"        => __( "Backup/Restore options", THEMENAME ),
	"description" => __( "Using this feature you can backup or restore your theme options. If you want to restore a backup, please click on the backup name. If you want to delete a backup , press the red x next to the backup", THEMENAME ),
	"id"          => "backup_restore",
	"type"        => "zn_backup_restore",
);

$zn_options[] = array(
    'name'        => __('Debug info', THEMENAME),
    'description' => __('Send us this information so we can help you with debugging any issues you might experience with Kallyas.', THEMENAME),
    'id'          => 'zn_get_debug_info',
    'type'        => 'zn_debug_info',
);

$zn_options[] = array (
	"type" => 'option_page_end'
);


/*--------------------------------------------------------------------------------------------------
Facebook Options
--------------------------------------------------------------------------------------------------*/

$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'facebook_options'
);

$zn_options[] = array (
	"name"        => __( "Add Facebook OpenGraph Tags?", THEMENAME ),
	"description" => __( "Choose yes if you want to enable the facebook OpenGraph for your site.", THEMENAME ),
	"id"          => "face_og",
	"std"         => "1",
	"type"        => "zn_radio",
	"options"     => array (
		"1" => __( "Show", THEMENAME ),
		"0" => __( "Hide", THEMENAME )
	)
);

$zn_options[] = array (
	"name"        => __( "Facebook Application ID", THEMENAME ),
	"description" => __( "Please enter your facebook application ID. The share buttons will not work correctly
		if you don't fill this in.", THEMENAME ),
	"id"          => "face_AP_ID",
	"std"         => "",
	"type"        => "text"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);

/*--------------------------------------------------------------------------------------------------
reCaptcha Options
--------------------------------------------------------------------------------------------------*/

$zn_options[] = array (
	"type" => 'option_page_start',
	"id"   => 'recaptcha_options'
);

$zn_options[] = array (
	"name"        => __( "Add Facebook OpenGraph Tags?", THEMENAME ),
	"description" => __( "Choose yes if you want to enable the facebook OpenGraph for your site.", THEMENAME ),
	"id"          => "rec_theme",
	"std"         => "red",
	"type"        => "select",
	"options"     => array (
		"red"        => __( "Red", THEMENAME ),
		"white"      => __( "White", THEMENAME ),
		"blackglass" => __( "Blackglass", THEMENAME ),
		"clean"      => __( "Clean", THEMENAME ),
	)
);

$zn_options[] = array (
	"name"        => __( "reCaptcha Public Key", THEMENAME ),
	"description" => __( "Please enter the Public key got from http://www.google.com/recaptcha.", THEMENAME ),
	"id"          => "rec_pub_key",
	"std"         => "",
	"type"        => "text"
);

$zn_options[] = array (
	"name"        => __( "reCaptcha Private Key", THEMENAME ),
	"description" => __( "Please enter the Private key got from http://www.google.com/recaptcha", THEMENAME ),
	"id"          => "rec_priv_key",
	"std"         => "",
	"type"        => "text"
);

$zn_options[] = array (
	"type" => 'option_page_end'
);
