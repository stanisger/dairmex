<?php
/**
 * Theme Functions
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */


define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'Tisson' );
define( 'THEME_VERSION', '1.0.4' );

define( 'LIBS_DIR', THEME_DIR. '/functions' );
define( 'LIBS_URI', THEME_URI. '/functions' );
define( 'LANG_DIR', THEME_DIR. '/languages' );

add_filter( 'widget_text', 'do_shortcode' );


/* ---------------------------------------------------------------------------
 * Loads Theme Textdomain
 * --------------------------------------------------------------------------- */
load_theme_textdomain( 'tisson', LANG_DIR );
load_theme_textdomain( 'mfn-opts', LANG_DIR );


/* ---------------------------------------------------------------------------
 * Loads the Options Panel
 * --------------------------------------------------------------------------- */
function mfn_sortable() {
	wp_enqueue_script( 'jquery-ui-sortable' );
}    
add_action( 'wp_enqueue_scripts', 'mfn_sortable' );
add_action( 'admin_enqueue_scripts', 'mfn_sortable' );
	
require( THEME_DIR .'/muffin-options/theme-options.php' );


/* ---------------------------------------------------------------------------
 * Loads Theme Functions
 * --------------------------------------------------------------------------- */

// Functions --------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-functions.php' );

// Header -----------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-head.php' );

// Menu -------------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-menu.php' );

// Meta box ---------------------------------------------------------------------
require_once( LIBS_DIR .'/meta-functions.php' );
require_once( LIBS_DIR .'/meta-page.php' );
require_once( LIBS_DIR .'/meta-post.php' );

// Custom post types ------------------------------------------------------------
require_once( LIBS_DIR .'/meta-client.php' );
require_once( LIBS_DIR .'/meta-portfolio.php' );
require_once( LIBS_DIR .'/meta-testimonial.php' );

// Shortcodes -------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-shortcodes.php' );

// Widgets ----------------------------------------------------------------------
require_once( LIBS_DIR .'/widget-call-to-action.php' );
require_once( LIBS_DIR .'/widget-contact-box.php' );
require_once( LIBS_DIR .'/widget-functions.php' );
require_once( LIBS_DIR .'/widget-flickr.php' );
require_once( LIBS_DIR .'/widget-menu.php' );
require_once( LIBS_DIR .'/widget-recent-comments.php' );
require_once( LIBS_DIR .'/widget-recent-posts.php' );
require_once( LIBS_DIR .'/widget-tag-cloud.php' );
require_once( LIBS_DIR .'/widget-twitter.php' );

// TinyMCE ----------------------------------------------------------------------
require_once( LIBS_DIR .'/tinymce/tinymce.php' );

// Plugins ----------------------------------------------------------------------
require_once( LIBS_DIR .'/plugins/twitteroauth.php' );
require_once( LIBS_DIR .'/class-tgm-plugin-activation.php' );

?>