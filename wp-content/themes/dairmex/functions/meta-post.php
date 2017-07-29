<?php
/**
 * Post custom meta fields.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

 
/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$mfn_post_meta_box = array(
	'id' => 'mfn-meta-post',
	'title' => __('Post Options','mfn-opts'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(

		array(
			'id' => 'mfn-post-layout',
			'type' => 'radio_img',
			'title' => __('Layout', 'mfn-opts'), 
			'sub_desc' => __('Select layout for this post', 'mfn-opts'),
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
			'sub_desc' => __('Select sidebar for this post', 'mfn-opts'),
			'desc' => __('Shows only if layout with sidebar is selected.', 'mfn-opts'),
			'options' => mfn_opts_get( 'sidebars' ),
		),
		
		array(
			'id' => 'mfn-post-vimeo',
			'type' => 'text',
			'title' => __('Vimeo video ID', 'mfn-opts'),
			'desc' => __('It`s placed in every Vimeo video link after the last /,for example: http://vimeo.com/<b>1084537</b>', 'mfn-opts'),
			'class' => 'small-text'
		),
		
		array(
			'id' => 'mfn-post-youtube',
			'type' => 'text',
			'title' => __('YouTube video ID', 'mfn-opts'),
			'desc' => __('It`s placed in every YouTube video link after <b>v=</b> parameter, for example: http://www.youtube.com/watch?v=<b>YE7VzlLtp-4</b>', 'mfn-opts'),
			'class' => 'small-text'
		),
		
		array(
			'id' => 'mfn-post-slider',
			'type' => 'select',
			'title' => __('Slider', 'mfn-opts'), 
			'sub_desc' => __('Select slider for this page.', 'mfn-opts'),
			'desc' => __('Select slider from the list of available <a href="admin.php?page=revslider">Revolution Sliders</a>.<br/>Please also set a <strong>Featured Image</strong> that will be used in Latest Posts Slider.', 'mfn-opts'),
			'options' => mfn_get_sliders( false ),
		),
		
		array(
			'id' => 'mfn-post-categories',
			'type' => 'switch',
			'title' => __('Show Categories', 'mfn-opts'), 
			'desc' => __('These setting overriddes theme options settings.', 'mfn-opts'), 
			'options' => array('1' => 'On','0' => 'Off'),
			'std' => mfn_opts_get( 'blog-categories' ),
		),
		
		array(
			'id' => 'mfn-post-comments',
			'type' => 'switch',
			'title' => __('Show Comments number', 'mfn-opts'), 
			'desc' => __('These setting overriddes theme options settings.', 'mfn-opts'),
			'options' => array('1' => 'On','0' => 'Off'),
			'std' => mfn_opts_get( 'blog-comments' ),
		),
		
		array(
			'id' => 'mfn-post-time',
			'type' => 'switch',
			'title' => __('Show Date', 'mfn-opts'), 
			'desc' => __('These setting overriddes theme options settings.', 'mfn-opts'),
			'options' => array('1' => 'On','0' => 'Off'),
			'std' => mfn_opts_get( 'blog-time' ),
		),
		
		array(
			'id' => 'mfn-post-tags',
			'type' => 'switch',
			'title' => __('Show Tags', 'mfn-opts'), 
			'desc' => __('These setting overriddes theme options settings.', 'mfn-opts'),  
			'options' => array('1' => 'On','0' => 'Off'),
			'std' => mfn_opts_get( 'blog-tags' ),
		),
		
		array(
			'id' => 'mfn-post-social',
			'type' => 'switch',
			'title' => __('Social network sharing', 'mfn-opts'), 
			'desc' => __('These setting overriddes theme options settings.', 'mfn-opts'),   
			'options' => array('1' => 'On','0' => 'Off'),
			'std' => '1'
		),
		
	),
);


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/ 
function mfn_post_meta_add() {
	global $mfn_post_meta_box;
	add_meta_box($mfn_post_meta_box['id'], $mfn_post_meta_box['title'], 'mfn_post_show_box', $mfn_post_meta_box['page'], $mfn_post_meta_box['context'], $mfn_post_meta_box['priority']);
}
add_action('admin_menu', 'mfn_post_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
function mfn_post_show_box() {
	global $MFN_Options, $mfn_post_meta_box, $post;
	$MFN_Options->_enqueue();
 	
	// Use nonce for verification
	echo '<div id="mfn-wrapper">';
		echo '<input type="hidden" name="mfn_post_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<table class="form-table">';
			echo '<tbody>';
	 
				foreach ($mfn_post_meta_box['fields'] as $field) {
					$meta = get_post_meta($post->ID, $field['id'], true);
					if( ! key_exists( 'std' , $field) ) $field['std'] = false;
					$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
					mfn_meta_field_input( $field, $meta );
				}
	 
			echo '</tbody>';
		echo '</table>';
	echo '</div>';
}


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
function mfn_post_save_data($post_id) {
	global $mfn_post_meta_box;
 
	// verify nonce
	if( key_exists( 'mfn_post_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['mfn_post_meta_nonce'], basename(__FILE__) ) ) {
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
 
	foreach ($mfn_post_meta_box['fields'] as $field) {
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
add_action('save_post', 'mfn_post_save_data');

?>