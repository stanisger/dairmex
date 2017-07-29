<?php
/**
 * Portfolio custom meta fields.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
function mfn_portfolio_post_type() 
{
	$portfolio_item_slug = mfn_opts_get( 'portfolio-slug', 'portfolio-item' );
	
	$labels = array(
		'name' => __('Portfolio','mfn-opts'),
		'singular_name' => __('Portfolio item','mfn-opts'),
		'add_new' => __('Add New','mfn-opts'),
		'add_new_item' => __('Add New Portfolio item','mfn-opts'),
		'edit_item' => __('Edit Portfolio item','mfn-opts'),
		'new_item' => __('New Portfolio item','mfn-opts'),
		'view_item' => __('View Portfolio item','mfn-opts'),
		'search_items' => __('Search Portfolio items','mfn-opts'),
		'not_found' =>  __('No portfolio items found','mfn-opts'),
		'not_found_in_trash' => __('No portfolio items found in Trash','mfn-opts'), 
		'parent_item_colon' => ''
	  );
		
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'rewrite' => array( 'slug' => $portfolio_item_slug, 'with_front'=>true ),
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
	); 
	  
	register_post_type( 'portfolio', $args );
	  
	register_taxonomy('portfolio-types','portfolio',array(
		'hierarchical' => true, 
		'label' =>  __('Portfolio categories','mfn-opts'), 
		'singular_label' =>  __('Portfolio category','mfn-opts'), 
		'rewrite' => true,
		'query_var' => true
	));
}
add_action( 'init', 'mfn_portfolio_post_type' );


/* ---------------------------------------------------------------------------
 * Edit columns
 * --------------------------------------------------------------------------- */
function mfn_portfolio_edit_columns($columns)
{
	$newcolumns = array(
		"cb" => "<input type=\"checkbox\" />",
		"portfolio_thumbnail" => __('Thumbnail','mfn-opts'),
		"title" => 'Title',
		"portfolio_types" => __('Categories','mfn-opts'),
		"portfolio_order" =>  __('Order','mfn-opts'),
	);
	$columns = array_merge($newcolumns, $columns);	
	
	return $columns;
}
add_filter("manage_edit-portfolio_columns", "mfn_portfolio_edit_columns");  


/* ---------------------------------------------------------------------------
 * Custom columns
 * --------------------------------------------------------------------------- */
function mfn_portfolio_custom_columns($column)
{
	global $post;
	switch ($column)
	{
		case "portfolio_thumbnail":
			if ( has_post_thumbnail() ) { the_post_thumbnail('50x50'); }
			break;
		case "portfolio_types":
			echo get_the_term_list($post->ID, 'portfolio-types', '', ', ','');
			break;
		case "portfolio_order":
			echo $post->menu_order;
			break;		
	}
}
add_action("manage_posts_custom_column",  "mfn_portfolio_custom_columns"); 


/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$mfn_portfolio_meta_box = array(
	'id' => 'mfn-meta-portfolio',
	'title' => __('Portfolio Item Options','mfn-opts'),
	'page' => 'portfolio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(

		array(
			'id' => 'mfn-post-layout',
			'type' => 'radio_img',
			'title' => __('Layout', 'mfn-opts'), 
			'sub_desc' => __('Select layout for this portfolio item.', 'mfn-opts'),
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
			'sub_desc' => __('Select sidebar for this portfolio item.', 'mfn-opts'),
			'desc' => __('Shows only if layout with sidebar is selected.', 'mfn-opts'),
			'options' => mfn_opts_get( 'sidebars' ),
		),
		
		array(
			'id' => 'mfn-post-recent-work',
			'type' => 'switch',
			'title' => __('Show Recent Work', 'mfn-opts'), 
			'sub_desc' => __('Show Recent Work at the bottom of the page.', 'mfn-opts'),
			'desc' => __('This setting overriddes theme options settings.', 'mfn-opts'),
			'options' => array('1' => 'On', '0' => 'Off'),
			'std' => mfn_opts_get('recent-work-show'),
		),
		
		array(
			'id' => 'mfn-post-vimeo',
			'type' => 'text',
			'title' => __('Vimeo video ID', 'mfn-opts'),
			'sub_desc' => __('Please also set featured image', 'mfn-opts'),
			'desc' => __('It`s placed in every Vimeo video link after the last /,for example: http://vimeo.com/<b>1084537</b>', 'mfn-opts'),
			'class' => 'small-text'
		),
		
		array(
			'id' => 'mfn-post-youtube',
			'type' => 'text',
			'title' => __('YouTube video ID', 'mfn-opts'),
			'sub_desc' => __('Please also set featured image', 'mfn-opts'),
			'desc' => __('It`s placed in every YouTube video link after <b>v=</b> parameter, for example: http://www.youtube.com/watch?v=<b>YE7VzlLtp-4</b>', 'mfn-opts'),
			'class' => 'small-text'
		),
			
		array(
			'id' => 'mfn-post-slider',
			'type' => 'select',
			'title' => __('Slider', 'mfn-opts'),
			'sub_desc' => __('Select slider for this page.', 'mfn-opts'),
			'desc' => __('Select slider from the list of available <a href="admin.php?page=revslider">Revolution Sliders</a>.', 'mfn-opts'),
			'options' => mfn_get_sliders( false ),
		),
		
		array(
			'id' => 'mfn-post-client',
			'type' => 'text',
			'title' => __('Client', 'mfn-opts'),
			'sub_desc' => __('Project description: Client.', 'mfn-opts'),
		),
		
		array(
			'id' => 'mfn-post-date',
			'type' => 'text',
			'title' => __('Date', 'mfn-opts'),
			'sub_desc' => __('Project description: Date.', 'mfn-opts'),
		),
		
		array(
			'id' => 'mfn-post-categories',
			'type' => 'switch',
			'title' => __('Show categories', 'mfn-opts'),  
			'options' => array('1' => 'On','0' => 'Off'),
			'std' => '1'
		),
		
		array(
			'id' => 'mfn-post-link',
			'type' => 'text',
			'title' => __('Project URL', 'mfn-opts'),
			'sub_desc' => __('Project description: Project URL.', 'mfn-opts'),
		),

	),
);


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/ 
function mfn_portfolio_meta_add() {
	global $mfn_portfolio_meta_box;
	add_meta_box($mfn_portfolio_meta_box['id'], $mfn_portfolio_meta_box['title'], 'mfn_portfolio_show_box', $mfn_portfolio_meta_box['page'], $mfn_portfolio_meta_box['context'], $mfn_portfolio_meta_box['priority']);
}
add_action('admin_menu', 'mfn_portfolio_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
function mfn_portfolio_show_box() {
	global $MFN_Options, $mfn_portfolio_meta_box, $post;
	$MFN_Options->_enqueue();
 	
	// Use nonce for verification
	echo '<div id="mfn-wrapper">';
		echo '<input type="hidden" name="mfn_portfolio_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<table class="form-table">';
			echo '<tbody>';
	 
				foreach ($mfn_portfolio_meta_box['fields'] as $field) {
					$meta = get_post_meta($post->ID, $field['id'], true);
					if( ! key_exists('std', $field) ) $field['std'] = false;
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
function mfn_portfolio_save_data($post_id) {
	global $mfn_portfolio_meta_box;
 
	// verify nonce
	if( key_exists( 'mfn_portfolio_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['mfn_portfolio_meta_nonce'], basename(__FILE__) ) ) {
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
 
	foreach ($mfn_portfolio_meta_box['fields'] as $field) {
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
add_action('save_post', 'mfn_portfolio_save_data');

?>