<?php

/**************************************************
 *    Get default options
 **************************************************/


function zn_get_default_values()
{
	global $zn_options;

	include( locate_template( array( 'admin/options/theme-options.php' ), false ) );

	$defaults = array();

	foreach ( $zn_options as $option ) {
		if ( isset( $option['std'] ) ) {
			// Add default Fonts also
			if ( $option['type'] == 'typography' ) {
				if ( array_key_exists( 'face', $option['std'] ) ) {
					$defaults['fonts'][ $option['id'] ] = $option['std']['face'];
				}
			}
			$defaults[ $option['id'] ] = $option['std'];
		}
	}
	return $defaults;
}


/**************************************************
 *    Set default options on theme activation
 **************************************************/
function zn_admin_init()
{
	if ( ! get_option( OPTIONS ) ) {
		$defaults = zn_get_default_values();
		generate_options_css( $defaults );
		generate_options_js( $defaults );
		update_option( OPTIONS, $defaults );
	}
}

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == "themes.php" )
{
	//Call action that sets the default options
	add_action( 'admin_head', 'zn_admin_init' );
}


/**************************************************
 *    Use new media gallery
 *************************************************/

add_action( 'admin_enqueue_scripts', 'enqueue_media_stuff' );
function enqueue_media_stuff()
{
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
}


/**************************************************
 *    Create the shortcodes button
 *************************************************/

add_action( 'admin_init', 'zn_sc_button' );
function zn_sc_button()
{
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( 'mce_external_plugins', 'add_plugin' );
		add_filter( 'mce_buttons', 'register_button' );
	}
}

function register_button( $buttons )
{
	array_push( $buttons, "|", "zn_button" );
	return $buttons;
}

function add_plugin( $plugin_array )
{
	$plugin_array['zn_button'] = get_template_directory_uri() . '/admin/js/zn_sc_button.js';
	return $plugin_array;
}

function zn_sc_dialog()
{
	$categories = null;
	include( locate_template( array( 'admin/framework/helper-shortcodes.php' ), false ) );

	$page = '';
	$i    = '0';
	?>
	<div class="zn_shortcodes_wrapper zn_hidden">
		<div class="zn_shortcodes_inner">
			<div id="zn_sidebar">
				<div id="zn-nav">
					<ul class="zn_activate_nav">
						<?php
							if ( ! empty( $categories ) ) {
								foreach ( $categories as $name => $shortcodes ) {
									$cls = '';
									if ( $i == '0' ) {
										$cls = 'active';
									}
									echo '<li><a rel="" href="#zn_page_' . $name . '" class="normal ' . $cls . '">' . $name . '</a></li>';

									$page .= '<div id="zn_page_' . $name . '" class="zn_page">';
									$page .= '<h4 class="heading">' . $name . '</h4>';
									foreach ( $shortcodes as $shortcode_name => $shortcode_value ) {
										$page .= '<div class="zn_sc_container"><div class="zn_sc_title">' . $shortcode_name . '</div><div class="zn_shortcode_text">' . $shortcode_value . '</div></div>';
									}
									$page .= '</div>';

									$i ++;
								}
							}
						?>
					</ul>
				</div>
			</div>
			<div id="content">
				<?php echo $page; ?>
			</div>
		</div>
	</div>
<?php
}

/*-----------------------------------------------------------------------------------*/
/* ZN Framework Admin Interface - zn_framework_add_admin */
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_menu', 'zn_framework_add_admin' );
function zn_framework_add_admin()
{
	$zn_page        = add_menu_page( THEMENAME, THEMENAME . ' Options', 'edit_theme_options', THEMENAME, 'zn_framework_options_page', ADMIN_IMAGES_DIR . '/favicon.png' );
	$zn_woo_options = add_submenu_page( THEMENAME, 'Woocommerce Options', 'Woocommerce Options', 'edit_theme_options', 'zn_woo_page', 'zn_woo_options_page' );

	// Add framework functionaily to the head individually
	add_action( "admin_print_scripts-$zn_page", 'of_load_only' );
	add_action( "admin_print_scripts-$zn_woo_options", 'of_load_only' );
	add_action( "admin_print_styles-$zn_page", 'of_style_only' );
	add_action( "admin_print_styles-$zn_woo_options", 'of_style_only' );

	//if ( basename( $_SERVER['PHP_SELF'] ) == "post-new.php" || basename( $_SERVER['PHP_SELF'] ) == "post.php" ) {
	if(WpkZn::canLoadResources('post.php') || WpkZn::canLoadResources('post-new.php')) {
		of_load_only();
		of_style_only();
		add_action( 'admin_footer', 'zn_sc_dialog' );
	}
}


/*-----------------------------------------------------------------------------------*/
/* Build the Options Page  */
/*-----------------------------------------------------------------------------------*/

function zn_framework_options_page()
{
	// Display the warning related to the usage of the 3D Cute Slider plugin
	kallyasShowCuteSliderNotice();

	$html = new zn_html();
	global $zn_options, $zn_admin_menu;
	include( locate_template( array( 'admin/options/theme-options.php' ), false ) );
	echo $html->zn_show_options( $zn_options, $zn_admin_menu );
}

/*-----------------------------------------------------------------------------------*/
/* Build the WooCommerce Options Page  */
/*-----------------------------------------------------------------------------------*/

function zn_woo_options_page()
{
	// Display the warning related to the usage of the 3D Cute Slider plugin
	kallyasShowCuteSliderNotice();

	$html = new zn_html();
	global $zn_options, $zn_admin_menu;
	include( locate_template( array( 'admin/options/woocommerce-options.php' ), false ) );
	echo $html->zn_show_options( $zn_options, $zn_admin_menu );
}


/*-----------------------------------------------------------------------------------*/
/* Load Inline scripts to footer
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_footer', 'add_this_script_footer' );
function add_this_script_footer()
{
	if(WpkZn::canLoadResources('post.php') || WpkZn::canLoadResources('post-new.php')) {
		$str = __( 'Nothing selected...<a class="zn-remove-image" href="#">remove</a>', THEMENAME );
		?>
		<script type="text/javascript">
			"use strict";

		</script>
	<?php
	}
}


/*-----------------------------------------------------------------------------------*/
/* Load required styles for Options Page - of_style_only */
/*-----------------------------------------------------------------------------------*/

function of_style_only()
{
	// Needed for image upload
	wp_enqueue_style( 'zn-admin-style', ADMIN_MASTER_ADMIN_DIR . 'css/zn-admin-style.css', '', THEME_VERSION );
	wp_enqueue_style( 'wp-color-picker' );
}

/*-----------------------------------------------------------------------------------*/
/* Load required javascripts for Options Page - of_load_only */
/*-----------------------------------------------------------------------------------*/

function of_load_only()
{
	wp_enqueue_script( 'jquery-ui-sortable' );

	// Needed for image upload
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'jquery-ui-datepicker' );

	wp_enqueue_script( 'zn-modal', ADMIN_MASTER_ADMIN_DIR . 'js/zn_modal.js', array( 'jquery' ), THEME_VERSION, true );
	wp_enqueue_script( 'zn-admin-scripts', ADMIN_MASTER_ADMIN_DIR . 'js/zn-admin-scripts.js', array(
		'wp-color-picker',
		'jquery'
	), THEME_VERSION, true );

	$localized_data = array(
		'remove_str' => __( 'remove', THEMENAME ),
		'nothing_selected' => __( 'Nothing selected...<a class="zn-remove-image" href="#">remove</a>', THEMENAME ),
		'images_url' => IMAGES_URL
	);

	wp_localize_script( 'zn-admin-scripts', 'ZnAdminLocalize', $localized_data );
	wp_enqueue_script( 'zn-ajax-options', ADMIN_MASTER_ADMIN_DIR . 'js/zn-ajax-options.js', 'jquery', THEME_VERSION, true );
}


/*-----------------------------------------------------------------------------------*/
/* Get element fields from id
/*-----------------------------------------------------------------------------------*/
function zn_get_element_from_id( $id )
{
	// INCLUDE the options files
	global $zn_meta_elements, $extra_options, $zn_options;
	include( locate_template( array( 'admin/options/zn-meta-boxes.php' ), false ) );
	include( locate_template( array( 'admin/options/theme-options.php' ), false ) );

	$options = array_merge( $zn_options, $zn_meta_elements, $extra_options );

	foreach ( $options as $option ) {
		if ( ! isset( $option['id'] ) ) {
			$option['id'] = '';
		}
		if ( $option['id'] == $id ) {
			$option['dynamic'] = true;
			return $option;
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Re-ENABLE THE DUMMY INSTALL BUTTON
/*-----------------------------------------------------------------------------------*/
if ( is_admin() && isset( $_GET['enable_dummy_install'] ) )
{
	//Call action that sets
	update_option( THEMENAME . '_dummy', 0 );
	header( 'Location: ' . get_admin_url() . '?page=' . THEMENAME, true, 302 );
//	exit;
}

/* For use in themes */
global $znData;
if(!isset($znData) || empty($znData)){
    $znData = get_option( OPTIONS );
}
$data = $znData;

/*-----------------------------------------------------------------------------------*/
/* Create Dynamic Css*/
/*-----------------------------------------------------------------------------------*/
function generate_options_css( $newdata )
{
	/** Define some vars **/
	$znData    = $newdata; // maybe used as is($data) in the included file below??
	$uploads = wp_upload_dir();
	$css_dir = get_template_directory() . '/css/'; // Shorten code, save 1 call

	/** Save on different directory if on multisite **/
	if ( is_multisite() ) {
		$zn_uploads_dir = trailingslashit( $uploads['basedir'] );
	} else {
		$zn_uploads_dir = $css_dir;
	}

	/** Capture CSS output **/
	$css = '';
	ob_start();
		$fp = $css_dir . 'styles.php';
		if ( is_file( $fp ) ) {
			require( $fp );
			$css = ob_get_contents();
		}
	ob_end_clean();

	/** Write to options.css file **/
	file_put_contents( $zn_uploads_dir . 'options.css', $css );
}

/*-----------------------------------------------------------------------------------*/
/* Create Dynamic Js*/
/*-----------------------------------------------------------------------------------*/
function generate_options_js( $newdata )
{
	return;
}

/*-----------------------------------------------------------------------------------*/
/* Auto Update the theme
/*-----------------------------------------------------------------------------------*/
if ( ! empty( $data['zn_theme_username'] ) && ! empty( $data['zn_theme_api'] ) )
{
	$username = $data['zn_theme_username'];
	$apikey   = $data['zn_theme_api'];
	$author   = 'Hogash';

	require_once( "class-pixelentity-theme-update.php" );
	PixelentityThemeUpdate::init( $username, $apikey, $author );
}

/*-----------------------------------------------------------------------------------*/
/* CHECK IF REQUIRED FILES ARE WRITEABLE
/*-----------------------------------------------------------------------------------*/

global $zn_has_error;

$zn_has_error = array();

$css_dir = get_template_directory() . '/css/';
$uploads = wp_upload_dir();

if (function_exists('is_multisite') && is_multisite() ) {
	$zn_uploads_dir = trailingslashit( $uploads['basedir'] );
} else {
	$zn_uploads_dir = $css_dir;
}

$css_file = $zn_uploads_dir . 'options.css';

if ( ! is_writable( $css_file ) ) {
	$zn_has_error[] = '<br/>' . __( 'Please make sure that the bellow files exists and have the proper file permissions (
		  644 or 777 ) and belong to the same user group as the rest of the wordpress files. Until you set the proper
		  permissions to those files , you won\'n be able to change any color/bacgrounds', THEMENAME ) . '<br/>';
	$zn_has_error[] = $css_file . ' <b>' . __( "IS NOT WRITABLE OR DOESN'T EXIST", THEMENAME ) . '</b>';

	$zn_has_error[] = '<br/><h3>' . __( 'HOW TO RESOLVE THIS :', THEMENAME ) . '</h3>';
	$zn_has_error[] = __( '+ If this is the first time you use the theme or you\'ve just updated the theme , save the options and refresh the page', THEMENAME ) . '<br/>';
	$zn_has_error[] = __( "+ If the above step didn't removed this message, using a FTP client, please check that the above mentioned files are present in the mentioned directories. If the files are not present, please manually create them and then save the options again and refresh the page.", THEMENAME );
}

/*--------------------------------------------------------------------------------------------------
	Add options for the portfolio and Documentation
--------------------------------------------------------------------------------------------------*/
add_action( 'admin_init', 'zn_permalink_settings_init' );
function zn_permalink_settings_init()
{
	// Add a section to the permalinks page
	add_settings_section( 'zn-portfolio-permalink', 'Portfolio Slugs', '', 'permalink' );
	add_settings_section( 'zn-doc-permalink', 'Documentation Slugs', '', 'permalink' );

	// Add our settings
	add_settings_field(
		'zn_portfolio_item_slug_input', // id
		'Portfolio item slug',    // setting title
		'zn_portfolio_item_slug',  // display callback
		'permalink',               // settings page
		'zn-portfolio-permalink'   // settings section
	);

	// Add our settings
	add_settings_field(
		'zn_portfolio_taxonomy_slug_input', // id
		'Portfolio taxonomy slug',    // setting title
		'zn_portfolio_taxonomy_slug',  // display callback
		'permalink',                   // settings page
		'zn-portfolio-permalink'       // settings section
	);

	// Add our settings
	add_settings_field(
		'zn_doc_item_slug_input',        // id
		'Documentation taxonomy slug',    // setting title
		'zn_doc_item_slug',  // display callback
		'permalink',         // settings page
		'zn-doc-permalink'   // settings section
	);

	// Add our settings
	add_settings_field(
		'zn_doc_taxonomy_slug_input',   // id
		'Documentation taxonomy slug',  // setting title
		'zn_doc_taxonomy_slug',  // display callback
		'permalink',             // settings page
		'zn-doc-permalink'       // settings section
	);
}


/*--------------------------------------------------------------------------------------------------
	Permalinks actual options
--------------------------------------------------------------------------------------------------*/
function zn_portfolio_item_slug()
{
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_portfolio_item_slug_input" type="text" class="regular-text code"
		   value="<?php if ( isset( $permalinks['port_item'] ) ) {
			   echo esc_attr( $permalinks['port_item'] );
		   } ?>" placeholder="portfolio"/>
<?php
}

function zn_portfolio_taxonomy_slug()
{
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_portfolio_taxonomy_slug_input" type="text" class="regular-text code"
		   value="<?php if ( isset( $permalinks['port_tax'] ) ) {
			   echo esc_attr( $permalinks['port_tax'] );
		   } ?>" placeholder="project_category"/>
<?php
}

function zn_doc_item_slug()
{
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_doc_item_slug_input" type="text" class="regular-text code"
		   value="<?php if ( isset( $permalinks['doc_item'] ) ) {
			   echo esc_attr( $permalinks['doc_item'] );
		   } ?>" placeholder="documentation"/>
<?php
}

function zn_doc_taxonomy_slug()
{
	$permalinks = get_option( 'zn_permalinks' );
	?>
	<input name="zn_doc_taxonomy_slug_input" type="text" class="regular-text code"
		   value="<?php if ( isset( $permalinks['doc_tax'] ) ) {
			   echo esc_attr( $permalinks['doc_tax'] );
		   } ?>" placeholder="documentation_category"/>
<?php
}


/*--------------------------------------------------------------------------------------------------
	Save the permalinks options
--------------------------------------------------------------------------------------------------*/
add_action( 'admin_init', 'zn_permalink_settings_save' );
function zn_permalink_settings_save()
{
	if ( ! is_admin() ) {
		return;
	}

	// We need to save the options ourselves; settings api does not trigger save for the permalinks page
	if ( isset( $_POST['permalink_structure'] ) || isset( $_POST['zn_portfolio_item_slug_input'] ) ) {
		// Portfolio items slug
		$zn_portfolio_item_slug_input     = sanitize_text_field( $_POST['zn_portfolio_item_slug_input'] );
		$zn_portfolio_taxonomy_slug_input = sanitize_text_field( $_POST['zn_portfolio_taxonomy_slug_input'] );

		// Documentatin items slug
		$zn_doc_item_slug_input     = sanitize_text_field( $_POST['zn_doc_item_slug_input'] );
		$zn_doc_taxonomy_slug_input = sanitize_text_field( $_POST['zn_doc_taxonomy_slug_input'] );


		$permalinks = get_option( 'zn_permalinks' );
		if ( ! $permalinks ) {
			$permalinks = array();
		}

		$permalinks['port_item'] = untrailingslashit( $zn_portfolio_item_slug_input );
		$permalinks['port_tax']  = untrailingslashit( $zn_portfolio_taxonomy_slug_input );
		$permalinks['doc_item']  = untrailingslashit( $zn_doc_item_slug_input );
		$permalinks['doc_tax']   = untrailingslashit( $zn_doc_taxonomy_slug_input );

		update_option( 'zn_permalinks', $permalinks );
	}
}


/**
 * @param string $postData
 *
 * @return array
 */
function _getSocialIconsStatus( $postData )
{
	return array(
		'removeSocialsComingSoon' => ( false === ( $pos = stripos( $postData, 'cs_social_icons' ) ) ),
		'removeSocialsHeader'     => ( false === ( $pos = stripos( $postData, 'header_social_icons' ) ) ),
		'removeSocialsFooter'     => ( false === ( $pos = stripos( $postData, 'footer_social_icons' ) ) ),
	);
}


/*--------------------------------------------------------------------------------------------------
	AJAX CALLBACK
--------------------------------------------------------------------------------------------------*/
add_action( 'wp_ajax_zn_ajax_post_action', 'zn_ajax_callback' );
function zn_ajax_callback()
{
	$nonce = (isset($_POST['zn_security']) ? trim($_POST['zn_security']) : '');

	if ( ! wp_verify_nonce( $nonce, 'zn_ajax_nonce' ) ) {
		die( '-1' );
	}

	//get options array from db
	$all = get_option( OPTIONS );

	$save_type = $_POST['type'];

	if ( $save_type == 'save' )
	{
		$_POST = array_map( 'stripslashes_deep', $_POST );
		parse_str( $_POST['data'], $data );
		unset( $data['zn_security'] );
		unset( $data['of_save'] );

		$socialsInfo = _getSocialIconsStatus( $_POST['data'] );
		$args        = wp_parse_args( $data, $all );

		if ( $socialsInfo['removeSocialsHeader'] ) {
			$args['header_social_icons'] = array();
		}
		if ( $socialsInfo['removeSocialsFooter'] ) {
			$args['footer_social_icons'] = array();
		}
		if ( $socialsInfo['removeSocialsComingSoon'] ) {
			$args['cs_social_icons'] = array();
		}

		update_option( OPTIONS, $args );
		generate_options_css( $args ); //generate static css file
		generate_options_js( $args ); //generate static js file

		exit( '1' );
	} elseif ( $save_type == 'zn_restore_options' ) {
		$saved_backup = get_option( $_POST['data'] );

		update_option( OPTIONS, $saved_backup );
		generate_options_css( $saved_backup ); //generate static css file
		generate_options_js( $saved_backup ); //generate static js file
		ob_clean();
		exit( '1' );
	} elseif ( $save_type == 'zn_delete_backup' ) {
		$saved_backup = delete_option( $_POST['data'] );
		ob_clean();
		exit( '1' );
	} elseif ( $save_type == 'install_dummy' ) {
		locate_template( array( 'admin/dummy_content/zn_importer.php' ), true, true );
		installDummy();
	} elseif ( $save_type == 'zn_backup_options' ) {
		$_POST = array_map( 'stripslashes_deep', $_POST );
		parse_str( $_POST['data'], $data );
		unset( $data['zn_security'] );
		unset( $data['of_save'] );

		$args = wp_parse_args( $data, $all );
		$date = date( 'Y m d H i s' );
		$option_field = THEMENAME . '_backup_from_' . str_replace( ' ', '_', $date );
		$option_field = strtolower( $option_field );

		add_option( $option_field, $args, '', 'no' );
		ob_clean();
		echo $option_field;
	} elseif ( $save_type == 'add_element' ) {
		$html = new zn_html();
		parse_str( ( $_POST['data'] ), $data );

		// Make a check to see if the element is a subelement
		// All subelements options must be placed in the same array that is passed to zn_get_element_from_id() function in functions-zn-admin.php !!
		$full_id = $data['element_type'];

		if ( preg_match( '/\[(\d+)\]/', $full_id, $matches ) ) {
			$split_element_type   = preg_split( '/\[(\d+)\]/', $full_id );
			$number_of_ids        = count( $split_element_type ) - 1;
			$string               = str_replace( '[', '', $split_element_type[ $number_of_ids ] );
			$string               = str_replace( ']', '', $string );
			$data['element_type'] = $string;
		}
		$option = zn_get_element_from_id( $data['element_type'] );

		if ( isset( $option['link'] ) ) {
			$option['is_dynamic'] = true;
		}

		$option['id'] = $full_id;
		if ( isset( $data['pb_area'] ) && ! empty( $data['pb_area'] ) ) {
			$option['pb_area'] = $data['pb_area'];
		}

		echo $html->zn_render_element( $option );

		unset( $data['zn_security'] );
		unset( $data['of_save'] );
	}
	exit;
}
