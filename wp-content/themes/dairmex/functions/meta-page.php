<?php
/**
 * Page custom meta fields.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

 
/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$mfn_page_meta_box = array(
	'id' => 'mfn-meta-page',
	'title' => __('Page Options','mfn-opts'),
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(

		array(
			'id' => 'mfn-post-hide-content',
			'type' => 'switch',
			'title' => __('Hide the content', 'mfn-opts'), 
			'sub_desc' => __('Hide the content from the WordPress editor.', 'mfn-opts'),
			'desc' => __('<strong>Turn it ON if you build content using Content Builder</strong>. Use the Content item if you want to display the Content from editor within the Content Builder.', 'mfn-opts'),
			'options' => array('1' => 'On', '0' => 'Off'),
			'std' => '0'
		),

		array(
			'id' => 'mfn-post-layout',
			'type' => 'radio_img',
			'title' => __('Layout', 'mfn-opts'), 
			'sub_desc' => __('Select layout for this page', 'mfn-opts'),
			'options' => array(
				'no-sidebar' => array('title' => 'Full width. No sidebar', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
				'left-sidebar' => array('title' => 'Left Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cl.png'),
				'right-sidebar' => array('title' => 'Right Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cr.png')
			),
			'std' => mfn_opts_get( 'sidebar-layout' ),																		
		),
		
		array(
			'id' => 'mfn-post-sidebar',
			'type' => 'select',
			'title' => __('Sidebar', 'mfn-opts'), 
			'sub_desc' => __('Select sidebar for this page.', 'mfn-opts'),
			'desc' => __('Shows only if layout with sidebar is selected.', 'mfn-opts'),
			'options' => mfn_opts_get( 'sidebars' ),
		),
		
		array(
			'id' => 'mfn-post-slider',
			'type' => 'select',
			'title' => __('Slider', 'mfn-opts'), 
			'sub_desc' => __('Select slider for this page.', 'mfn-opts'),
			'desc' => __('Select Muffin Offer Slider or one from the list of available <a href="admin.php?page=revslider">Revolution Sliders</a>.', 'mfn-opts'),
			'options' => mfn_get_sliders( false ),
		),

		array(
			'id' => 'mfn-meta-seo-title',
			'type' => 'text',
			'title' => __('SEO Title', 'mfn-opts'),
			'desc' => __('These settings overriddes theme options settings.', 'mfn-opts'),
		),
		
		array(
			'id' => 'mfn-meta-seo-description',
			'type' => 'text',
			'title' => __('SEO Description', 'mfn-opts'),
			'desc' => __('These settings overriddes theme options settings.', 'mfn-opts'),
		),
		
		array(
			'id' => 'mfn-meta-seo-keywords',
			'type' => 'text',
			'title' => __('SEO Keywords', 'mfn-opts'),
			'desc' => __('These settings overriddes theme options settings.', 'mfn-opts'),
		),
		
	),
);


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/ 
function mfn_page_meta_add() {
	global $mfn_page_meta_box;
	add_meta_box($mfn_page_meta_box['id'], $mfn_page_meta_box['title'], 'mfn_page_show_box', $mfn_page_meta_box['page'], $mfn_page_meta_box['context'], $mfn_page_meta_box['priority']);
}
add_action('admin_menu', 'mfn_page_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
function mfn_page_show_box() {
	global $MFN_Options, $mfn_page_meta_box, $post;
	$MFN_Options->_enqueue();
 	
	// Use nonce for verification
	echo '<div id="mfn-wrapper">';
		echo '<input type="hidden" name="mfn_page_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		mfn_builder_show();

		echo '<table class="form-table">';
			echo '<tbody>';		
	 
				foreach ($mfn_page_meta_box['fields'] as $field) {
					$meta = get_post_meta($post->ID, $field['id'], true);
					if( ! key_exists('std', $field) ) $field['std'] = false;
					$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES ));
					mfn_meta_field_input( $field, $meta );
				}
	 
			echo '</tbody>';
		echo '</table>';
		
	echo '</div>';
}


/*-----------------------------------------------------------------------------------*/
/*	Save data when page is edited
/*-----------------------------------------------------------------------------------*/
function mfn_page_save_data($post_id) {
	global $mfn_page_meta_box;
 
	// verify nonce
	if( key_exists( 'mfn_page_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['mfn_page_meta_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	mfn_builder_save($post_id);

	// check and save fields ( $mfn_page_meta_box['fields'] )
	foreach ($mfn_page_meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		if( key_exists($field['id'], $_POST) ) {
			$new = $_POST[$field['id']];
		} else {
//			$new = ""; // problem with "quick edit"
			continue;
		}
 
		if ( isset($new) && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
add_action('save_post', 'mfn_page_save_data');


/*-----------------------------------------------------------------------------------*/
/*	Styles & scripts
/*-----------------------------------------------------------------------------------*/
function mfn_page_admin_styles() {
	wp_enqueue_style( 'jquery.confirm', LIBS_URI. '/js/jquery.confirm/jquery.confirm.css', false, time(), 'all');						
	wp_enqueue_style( 'mfn.builder', LIBS_URI. '/css/mfn-builder.css', false, time(), 'all');
}
add_action('admin_print_styles', 'mfn_page_admin_styles');

function mfn_page_admin_scripts() {
	wp_enqueue_script( 'jquery.confirm', LIBS_URI. '/js/jquery.confirm/jquery.confirm.js', false, time(), true );
	wp_enqueue_script( 'jquery.mfn.builder', LIBS_URI. '/js/mfn-builder.js', false, time(), true );						
}
add_action('admin_print_scripts', 'mfn_page_admin_scripts');

?>