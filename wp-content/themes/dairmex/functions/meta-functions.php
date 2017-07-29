<?php
/**
 * General custom meta fields.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */


/*-----------------------------------------------------------------------------------*/
/*	Field HTML OUTPUT
/*-----------------------------------------------------------------------------------*/
function mfn_meta_field_input( $field, $meta ){
	global $MFN_Options;

	if( isset( $field['type'] ) ){
		
		echo '<tr valign="top">';
			echo '<th scope="row">';
				if( key_exists('title', $field) ) echo $field['title'];
				if( key_exists('sub_desc', $field) ) echo '<span class="description">'. $field['sub_desc'] .'</span>';
			echo '</th>';
			echo '<td>';

				$field_class = 'MFN_Options_'.$field['type'];
				require_once( $MFN_Options->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php' );
				
				if( class_exists( $field_class ) ){
					$field_object = new $field_class( $field, $meta );
					$field_object->render(1);
				}
		
			echo '</td>';
		echo '</tr>';
		
	}
	
}


/*-----------------------------------------------------------------------------------*/
/*	Retrieve list of category
/*-----------------------------------------------------------------------------------*/
function mfn_get_categories( $category ) {
	$categories = get_categories( array( 'taxonomy' => $category ));
	
	$array = array( '' => __( 'All', 'mfn-opts' ) );	
	foreach( $categories as $cat ){
		$array[$cat->slug] = $cat->name;
	}
		
	return $array;
}


/*-----------------------------------------------------------------------------------*/
/*	Retrieve list of Revolution Sliders
/*-----------------------------------------------------------------------------------*/
function mfn_get_sliders( $all = true ) {
	global $wpdb;

	$sliders = array( 0 => __('-- Select --', 'mfn-opts') );
	if( $all ) $sliders['mfn-offer-slider'] = __('- Muffin Offer Slider -', 'mfn-opts');
		
	$table_name = $wpdb->prefix . "revslider_sliders";
	
	$array = false;
	
	$plugins = get_option('active_plugins');
	if( is_array( $plugins ) && in_array( 'revslider/revslider.php', $plugins ) ){
		$array = $wpdb->get_results("SELECT * FROM $table_name ORDER BY title");
	}
	
	if( is_array( $array ) ){
		foreach( $array as $v ){
			$sliders[$v->alias] = $v->title;
		}
	}
	
	return $sliders;
}


/*-----------------------------------------------------------------------------------*/
/*	Retrieve list of Boxes Backgrounds
/*-----------------------------------------------------------------------------------*/
function mfn_get_boxes_backgrounds() {
	
	$bgs = array();
	for ($i = 1; $i <= 4; $i++) {
		$bgs['mfn-color-'.$i] = __('Color '.$i, 'mfn-opts');
	} 
	return $bgs;
}


/*-----------------------------------------------------------------------------------*/
/*	Muffin builder item
/*-----------------------------------------------------------------------------------*/
function mfn_builder_item( $item_std, $item = false ) {
	
	$item_std['size'] = $item['size'] ? $item['size'] : $item_std['size'];
	$name_type = $item ? 'name="mfn-item-type[]"' : '';
	$name_size = $item ? 'name="mfn-item-size[]"' : '';
	$label = ( $item && key_exists('title', $item['fields']) ) ? $item['fields']['title'] : '';

	$classes = array(
		'1/4' => 'mfn-item-1-4',
		'1/3' => 'mfn-item-1-3',
		'1/2' => 'mfn-item-1-2',
		'2/3' => 'mfn-item-2-3',
		'3/4' => 'mfn-item-3-4',
		'1/1' => 'mfn-item-1-1'
	);
	
	echo '<div class="mfn-item mfn-item-'. $item_std['type'] .' '. $classes[$item_std['size']] .'">';
							
		echo '<div class="mfn-item-content">';
			echo '<input type="hidden" class="mfn-item-type" '. $name_type .' value="'. $item_std['type'] .'">';
			echo '<input type="hidden" class="mfn-item-size" '. $name_size .' value="'. $item_std['size'] .'">';
			echo '<div class="mfn-item-size">';
				echo '<a href="javascript:void(0);" class="mfn-item-btn mfn-item-size-dec">-</a>';
				echo '<a href="javascript:void(0);" class="mfn-item-btn mfn-item-size-inc">+</a>';
				echo '<span class="mfn-item-desc">'. $item_std['size'] .'</span>';
			echo '</div>';
			echo '<span class="mfn-item-label">'. $item_std['title'] .' <small>'. $label .'</small></span>';
			echo '<div class="mfn-item-tool">';
				echo '<a href="javascript:void(0);" class="mfn-item-btn mfn-item-delete">delete</a>';
				echo '<a href="javascript:void(0);" class="mfn-item-btn mfn-item-edit">edit</a>';
			echo '</div>';	
		echo '</div>';
		
		echo '<div class="mfn-item-meta">';
			echo '<table class="form-table">';
				echo '<tbody>';		
		 
					foreach ($item_std['fields'] as $field) {
							
						if( $item && key_exists( $field['id'] , $item['fields'] ) ) {
							$meta = $item['fields'][$field['id']];
						} else {
							$meta = false;
						}
						
						if( ! key_exists('std', $field) ) $field['std'] = false;
						$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
						
						$field['id'] = 'mfn-items['. $item_std['type'] .']['. $field['id'] .']';	
						if( ! in_array( $item_std['type'], array('accordion','faq','tabs') ) ){
							// except accordion & faq & tabs
							$field['id'] .= '[]';					
						}
						
						mfn_meta_field_input( $field, $meta );
						
					}
		 
				echo '</tbody>';
			echo '</table>';
		echo '</div>';
	
	echo '</div>';
						
}


/*-----------------------------------------------------------------------------------*/
/*	Muffin builder show
/*-----------------------------------------------------------------------------------*/
function mfn_builder_show() {
	global $post;
	
	$mfn_std_items = array(
	
		// Accordion  --------------------------------------------
		'accordion' => array(
			'type' => 'accordion',
			'title' => __('Accordion', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'tabs',
					'type' => 'tabs',
					'title' => __('Accordion', 'mfn-opts'),
					'sub_desc' => __('Manage accordion tabs.', 'mfn-opts')
				),
				
			),															
		),
		
		// Blockquote --------------------------------------------
		'blockquote' => array(
			'type' => 'blockquote',
			'title' => __('Blockquote', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mfn-opts'),
					'sub_desc' => __('Blockquote content.', 'mfn-opts'),
					'desc' => __('HTML tags allowed.', 'mfn-opts')
				),
					
				array(
					'id' => 'photo',
					'type' => 'upload',
					'title' => __('Photo', 'mfn-opts'),
					'sub_desc' => __('Author Photo.', 'mfn-opts'),
				),
				
				array(
					'id' => 'author',
					'type' => 'text',
					'title' => __('Author', 'mfn-opts'),
				),
				
				array(
					'id' => 'company',
					'type' => 'text',
					'title' => __('Company', 'mfn-opts'),
				),
				
				array(
					'id' => 'link',
					'type' => 'text',
					'title' => __('Link', 'mfn-opts'),
					'sub_desc' => __('Link to company page.', 'mfn-opts'),
				),
				
				array(
					'id' => 'target',
					'type' => 'select',
					'title' => __('Open in new window', 'mfn-opts'),
					'options' => array( 0 => 'No', 1 => 'Yes' ),
					'sub_desc' => __('Open link in a new window.', 'mfn-opts'),
					'sub' => __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
				
			),															
		),
		
		// Call to action  --------------------------------------------
		'call_to_action' => array(
			'type' => 'call_to_action',
			'title' => __('Call To Action', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
					
				array(
					'id' => 'image',
					'type' => 'upload',
					'title' => __('Image', 'mfn-opts'),
					'sub_desc' => __('Background Image.', 'mfn-opts'),
				),
		
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Text', 'mfn-opts'),
					'desc' => __('Wrap text into "span" tag to highlight it.', 'mfn-opts'),
				),
				
				array(
					'id' => 'btn_title',
					'type' => 'text',
					'title' => __('Button title', 'mfn-opts'),
				),
				
				array(
					'id' => 'btn_link',
					'type' => 'text',
					'title' => __('Button link', 'mfn-opts'),
				),
				
				array(
					'id' => 'class',
					'type' => 'text',
					'title' => __('Class', 'mfn-opts'),
					'desc' => __('This option is useful when you want to use Fancybox (fancybox) or Video Iframe (iframe).', 'mfn-opts'),
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
				
			),															
		),
		
		// Clients  --------------------------------------------
		'clients' => array(
			'type' => 'clients',
			'title' => __('Clients', 'mfn-opts'), 
			'size' => '1/1', 
			'fields' => array(

				array(
					'id' => 'info',
					'type' => 'info',
					'desc' => __('Please don\'t include multiple Clients Items on one page.', 'nhp-opts'),
				),
					
				array(
					'id' => 'pager',
					'type' => 'select',
					'title' => __('Show Pager', 'mfn-opts'),
					'sub_desc' => __('Show slider arrows.', 'mfn-opts'),
					'options' => array( 1 => 'Yes', 0 => 'No', ),
					'std' => 1,
				),
				
			),															
		),
		
		// Code  --------------------------------------------
		'code' => array(
			'type' => 'code',
			'title' => __('Code', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mfn-opts'),
					'class' => 'full-width',
					'validate' => 'html',
				),
				
			),															
		),
		
		// Column  --------------------------------------------
		'column' => array(
			'type' => 'column',
			'title' => __('Column', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'desc' => __('This field is used as an Item Label in admin panel only and shows after page update.', 'mfn-opts'),
				),
					
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Column content', 'mfn-opts'),
					'desc' => __('Shortcodes and HTML tags allowed.', 'mfn-opts'),
					'class' => 'full-width',
					'validate' => 'html',
				),
					
				array(
					'id' => 'inner_padding',
					'type' => 'select',
					'title' => __('Inner padding', 'mfn-opts'),
					'options' => array( 0 => 'No', 1 => 'Yes' ),
					'std' => 1,
				),
					
				array(
					'id' => 'background',
					'type' => 'text',
					'title' => __('Background color', 'mfn-opts'),
					'desc' => __('Background color in HEX format, eg. <strong>#FFFFFF</strong>', 'mfn-opts'),
					'class' => 'small-text',
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),

			),															
		),
		
		// Contact box --------------------------------------------
		'contact_box' => array(
			'type' => 'contact_box',
			'title' => __('Contact Box', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
				),
					
				array(
					'id' => 'address',
					'type' => 'textarea',
					'title' => __('Address', 'mfn-opts'),
					'desc' => __('HTML tags allowed.', 'mfn-opts'),
				),
					
				array(
					'id' => 'telephone',
					'type' => 'text',
					'title' => __('Telephone', 'mfn-opts'),
				),				
					
				array(
					'id' => 'fax',
					'type' => 'text',
					'title' => __('Fax', 'mfn-opts'),
				),				
				
				array(
					'id' => 'email',
					'type' => 'text',
					'title' => __('Email', 'mfn-opts'),
				),
				
				array(
					'id' => 'www',
					'type' => 'text',
					'title' => __('WWW', 'mfn-opts'),
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
				
			),															
		),	
		
		// Contact form --------------------------------------------
		'contact_form' => array(
			'type' => 'contact_form',
			'title' => __('Contact Form', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'info',
					'type' => 'info',
					'desc' => __('Please don\'t include multiple Contact Forms on one page.', 'nhp-opts'),
				),

				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
				),
				
				array(
					'id' => 'email',
					'type' => 'text',
					'title' => __('Email', 'mfn-opts'),
				),
				
			),															
		),
		
		// Content  --------------------------------------------
		'content' => array(
			'type' => 'content',
			'title' => __('Content', 'mfn-opts'), 
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' => 'info',
					'type' => 'info',
					'desc' => __('Adding this Item will show Content from WordPress Editor above Page Options. You can use it only once per page. Please also remember to turn off "Show The Content" option.', 'nhp-opts'),
				),
					
				array(
					'id' => 'inner_padding',
					'type' => 'select',
					'title' => __('Inner padding', 'mfn-opts'),
					'options' => array( 0 => 'No', 1 => 'Yes' ),
					'std' => 1,
				),
				
			),														
		),
	
		// Divider  --------------------------------------------
		'divider' => array(
			'type' => 'divider',
			'title' => __('Divider', 'mfn-opts'), 
			'size' => '1/1',
			'fields' => array(
		
				array(
					'id' => 'height',
					'type' => 'text',
					'title' => __('Divider height', 'mfn-opts'),
					'desc' => __('px', 'mfn-opts'),
					'class' => 'small-text',
				),
				
				array(
					'id' => 'line',
					'type' => 'select',
					'title' => __('Show line', 'mfn-opts'),
					'options' => array( 0 => 'No', 1 => 'Yes' ),
					'sub_desc' => __('Display horizontal line as a divider.', 'mfn-opts'),
				),
				
			),														
		),	
		
		// FAQ  --------------------------------------------
		'faq' => array(
			'type' => 'faq',
			'title' => __('FAQ', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'tabs',
					'type' => 'tabs',
					'title' => __('FAQ', 'mfn-opts'),
					'sub_desc' => __('Manage FAQ tabs.', 'mfn-opts')
				),
				
			),															
		),

		// Feature box  --------------------------------------------
		'feature_box' => array(
			'type' => 'feature_box',
			'title' => __('Feature Box', 'mfn-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' => 'image',
					'type' => 'upload',
					'title' => __('Image', 'mfn-opts'),
					'sub_desc' => __('Featured Image.', 'mfn-opts'),
// 					'desc' => __('Recommended size 380px x 285px.', 'mfn-opts'),
				),
				
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'sub_desc' => __('Will also be used as the image alternative text.', 'mfn-opts'),
				),
					
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mfn-opts'),
					'desc' => __('HTML tags allowed.', 'mfn-opts'),
				),
				
				array(
					'id' => 'link',
					'type' => 'text',
					'title' => __('Link', 'mfn-opts'),
				),
					
				array(
					'id' => 'link_title',
					'type' => 'text',
					'title' => __('Link Title', 'mfn-opts'),
					'std' => 'Read more&nbsp;&rsaquo;',
				),
				
				array(
					'id' => 'target',
					'type' => 'select',
					'title' => __('Open in new window', 'mfn-opts'),
					'options' => array( 0 => 'No', 1 => 'Yes' ),
					'sub_desc' => __('Open link in a new window.', 'mfn-opts'),
					'sub' => __('Adds a target="_blank" attribute to the link.', 'mfn-opts'),
				),
					
				array(
					'id' => 'background',
					'type' => 'text',
					'title' => __('Background color', 'mfn-opts'),
					'desc' => __('Background color in HEX format, eg. <strong>#FFFFFF</strong>', 'mfn-opts'),
					'class' => 'small-text',
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
		
			),
		),
		
		// Image  --------------------------------------------------
		'image' => array(
			'type' => 'image',
			'title' => __('Image', 'mfn-opts'), 
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' => 'src',
					'type' => 'upload',
					'title' => __('Image', 'mfn-opts'),
				),
				
				array(
					'id' => 'alt',
					'type' => 'text',
					'title' => __('Alternate Text', 'mfn-opts'),
				),
				
				array(
					'id' => 'caption',
					'type' => 'text',
					'title' => __('Caption', 'mfn-opts'),
				),
				
				array(
					'id' => 'link_image',
					'type' => 'upload',
					'title' => __('Zoomed image', 'mfn-opts'),
					'desc' => __('This image will be opened in lightbox.', 'mfn-opts'),
				),
				
				array(
					'id' => 'link',
					'type' => 'text',
					'title' => __('Link', 'mfn-opts'),
					'desc' => __('This link will work only if you leave the above "Zoomed image" field empty.', 'mfn-opts'),
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
				
			),														
		),
			
		// Info box --------------------------------------------
		'info_box' => array(
			'type' => 'info_box',
			'title' => __('Info Box', 'mfn-opts'),
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
				),

				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mfn-opts'),
					'desc' => __('HTML tags allowed.', 'mfn-opts'),
					'std' => '<ul><li>List item</li></ul>',
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
						
			),
		),
				
		// Latest posts --------------------------------------------
		'latest_posts' => array(
			'type' => 'latest_posts',
			'title' => __('Latest Posts', 'mfn-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'std' => 'Latest posts',
				),
					
				array(
					'id' => 'category',
					'type' => 'select',
					'title' => __('Category', 'mfn-opts'),
					'options' => mfn_get_categories( 'category' ),
					'sub_desc' => __('Select posts category', 'mfn-opts'),
				),
					
				array(
					'id' => 'count',
					'type' => 'text',
					'title' => __('Count', 'mfn-opts'),
					'desc' => __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
					'std' => 5,
					'class' => 'small-text',
				),
					
				array(
					'id' => 'pager',
					'type' => 'select',
					'title' => __('Show Pager', 'mfn-opts'),
					'sub_desc' => __('Show slider arrows', 'mfn-opts'),
					'options' => array( 1 => 'Yes', 0 => 'No', ),
					'std' => 1,
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
	
			),
		),
		
		// Map ---------------------------------------------
		'map' => array(
			'type' => 'map',
			'title' => __('Map', 'mfn-opts'), 
			'size' => '1/4',
			'fields' => array(

				array(
					'id' => 'lat',
					'type' => 'text',
					'title' => __('Google Maps Lat', 'mfn-opts'),
					'class' => 'small-text',
					'desc' => __('The map will appear only if this field is filled correctly.', 'mfn-opts'), 
				),
				
				array(
					'id' => 'lng',
					'type' => 'text',
					'title' => __('Google Maps Lng', 'mfn-opts'),
					'class' => 'small-text',
					'desc' => __('The map will appear only if this field is filled correctly.', 'mfn-opts'), 
				),
				
				array(
					'id' => 'height',
					'type' => 'text',
					'title' => __('Height', 'mfn-opts'),
					'desc' => 'px',
					'class' => 'small-text',
					'std' => 200,
				),
				
				array(
					'id' => 'zoom',
					'type' => 'text',
					'title' => __('Zoom', 'mfn-opts'),
					'class' => 'small-text',
					'std' => 13,
				),
				
			),														
		),
			
		// Our team --------------------------------------------
		'our_team' => array(
			'type' => 'our_team',
			'title' => __('Our Team', 'mfn-opts'), 
			'size' => '1/4',
			'fields' => array(
				
				array(
					'id' => 'image',
					'type' => 'upload',
					'title' => __('Photo', 'mfn-opts'),
				),
				
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'sub_desc' => __('Will also be used as the image alternative text.', 'mfn-opts'),
				),
				
				array(
					'id' => 'subtitle',
					'type' => 'text',
					'title' => __('Subtitle', 'mfn-opts'),
				),
				
				array(
					'id' => 'email',
					'type' => 'text',
					'title' => __('E-mail', 'mfn-opts'),
				),
				
				array(
					'id' => 'facebook',
					'type' => 'text',
					'title' => __('Facebook', 'mfn-opts'),
				),
				
				array(
					'id' => 'twitter',
					'type' => 'text',
					'title' => __('Twitter', 'mfn-opts'),
				),
				
				array(
					'id' => 'linkedin',
					'type' => 'text',
					'title' => __('LinkedIn', 'mfn-opts'),
				),
				
			),														
		),
				
		// Portfolio --------------------------------------------
		'portfolio' => array(
			'type' => 'portfolio',
			'title' => __('Portfolio', 'mfn-opts'),
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'std' => 'Our recent works',
				),
					
				array(
					'id' => 'count',
					'type' => 'text',
					'title' => __('Count', 'mfn-opts'),
					'desc' => __('We <strong>do not</strong> recommend use more than 10 items, because site will be working slowly.', 'mfn-opts'),
					'std' => '3',
					'class' => 'small-text',
				),

				array(
					'id' => 'category',
					'type' => 'select',
					'title' => __('Category', 'mfn-opts'),
					'options' => mfn_get_categories( 'portfolio-types' ),
					'sub_desc' => __('Select the portfolio post category.', 'mfn-opts'),
				),

				array(
					'id' => 'orderby',
					'type' => 'select',
					'title' => __('Order by', 'mfn-opts'),
					'sub_desc' => __('Portfolio items order by column.', 'mfn-opts'),
					'options' => array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
					'std' => 'menu_order'
				),
		
				array(
					'id' => 'order',
					'type' => 'select',
					'title' => __('Order', 'mfn-opts'),
					'sub_desc' => __('Portfolio items order.', 'mfn-opts'),
					'options' => array('ASC' => 'Ascending', 'DESC' => 'Descending'),
					'std' => 'ASC'
				),
					
				array(
					'id' => 'page',
					'type' => 'pages_select',
					'title' => __('Portfolio Page', 'mfn-opts'),
					'sub_desc' => __('Assign page for Portfolio.', 'mfn-opts'),
					'args' => array()
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
		
			),
		),
		
		// Pricing item --------------------------------------------
		'pricing_item' => array(
			'type' => 'pricing_item',
			'title' => __('Pricing Item', 'mfn-opts'), 
			'size' => '1/4',
			'fields' => array(
		
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'sub_desc' => __('Pricing item title', 'mfn-opts'),
				),
				
				array(
					'id' => 'price',
					'type' => 'text',
					'title' => __('Price', 'mfn-opts'),
					'class' => 'small-text',
				),
				
				array(
					'id' => 'currency',
					'type' => 'text',
					'title' => __('Currency', 'mfn-opts'),
					'class' => 'small-text',
				),
					
				array(
					'id' => 'period',
					'type' => 'text',
					'title' => __('Period', 'mfn-opts'),
					'class' => 'small-text',
				),
				
				array(
					'id' => 'content',
					'type' => 'textarea',
					'title' => __('Content', 'mfn-opts'),
					'desc' => __('HTML tags allowed.', 'mfn-opts'),
					'std' => '<ul><li><strong>List</strong> item</li></ul>',
				),
				
				array(
					'id' => 'link_title',
					'type' => 'text',
					'title' => __('Link title', 'mfn-opts'),
					'desc' => __('Link will appear only if this field will be filled.', 'mfn-opts'),
				),
				
				array(
					'id' => 'link',
					'type' => 'text',
					'title' => __('Link', 'mfn-opts'),
					'desc' => __('Link will appear only if this field will be filled.', 'mfn-opts'),
				),
				
				array(
					'id' => 'featured',
					'type' => 'select',
					'title' => __('Featured', 'mfn-opts'),
					'options' => array( 0 => 'No', 1 => 'Yes' ),
					'sub_desc' => __('This pricing item will be featured.', 'mfn-opts'),
					'desc' => __('Featured item is bigger and has different color.', 'mfn-opts'),
				),
				
			),														
		),
		
		// Tabs  --------------------------------------------
		'tabs' => array(
			'type' => 'tabs',
			'title' => __('Tabs', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'tabs',
					'type' => 'tabs',
					'title' => __('Tabs', 'mfn-opts'),
					'sub_desc' => __('Manage tabs.', 'mfn-opts')
				),
				
			),															
		),
			
		// Testimonials --------------------------------------------
		'testimonials' => array(
			'type' => 'testimonials',
			'title' => __('Testimonials Slider', 'mfn-opts'),
			'size' => '1/4',
			'fields' => array(
	
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'std' => __('Testimonials', 'mfn-opts'),
				),
				
				array(
					'id' => 'category',
					'type' => 'select',
					'title' => __('Category', 'mfn-opts'),
					'options' => mfn_get_categories( 'testimonial-types' ),
					'sub_desc' => __('Select the testimonial post category.', 'mfn-opts'),
				),
				
				array(
					'id' => 'orderby',
					'type' => 'select',
					'title' => __('Order by', 'mfn-opts'),
					'sub_desc' => __('Testimonials order by column.', 'mfn-opts'),
					'options' => array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
					'std' => 'date'
				),
				
				array(
					'id' => 'order',
					'type' => 'select',
					'title' => __('Order', 'mfn-opts'),
					'sub_desc' => __('Testimonials order.', 'mfn-opts'),
					'options' => array('ASC' => 'Ascending', 'DESC' => 'Descending'),
					'std' => 'DESC'
				),
					
				array(
					'id' => 'page',
					'type' => 'pages_select',
					'title' => __('Testimonials Page', 'mfn-opts'), 
					'sub_desc' => __('Assign page for Testimonials.', 'mfn-opts'),
					'args' => array()
				),
					
				array(
					'id' => 'height',
					'type' => 'select',
					'title' => __('Height', 'mfn-opts'),
					'sub_desc' => __('Item height', 'mfn-opts'),
					'desc' => __('Fixed heights for all screen widths can be set up in <strong>Appearance > Theme Options > Layout > Items height</strong> section.', 'mfn-opts'),
					'options' => array( 'auto' => 'Auto', 'fixed' => 'Fixed' ),
					'std' => 'auto',
				),
	
			),
		),
			
		// Testimonials page --------------------------------------------
		'testimonials_page' => array(
			'type' => 'testimonials_page',
			'title' => __('Testimonials Page', 'mfn-opts'),
			'size' => '1/1',
			'fields' => array(
		
				array(
					'id' => 'category',
					'type' => 'select',
					'title' => __('Category', 'mfn-opts'),
					'options' => mfn_get_categories( 'testimonial-types' ),
					'sub_desc' => __('Select the testimonial post category.', 'mfn-opts'),
				),
		
				array(
					'id' => 'orderby',
					'type' => 'select',
					'title' => __('Order by', 'mfn-opts'),
					'sub_desc' => __('Testimonials order by column.', 'mfn-opts'),
					'options' => array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
					'std' => 'date'
				),
		
				array(
					'id' => 'order',
					'type' => 'select',
					'title' => __('Order', 'mfn-opts'),
					'sub_desc' => __('Testimonials order.', 'mfn-opts'),
					'options' => array('ASC' => 'Ascending', 'DESC' => 'Descending'),
					'std' => 'DESC'
				),
		
			),
		),
		
		// Vimeo  --------------------------------------------
		'vimeo' => array(
			'type' => 'vimeo',
			'title' => __('Vimeo', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'video',
					'type' => 'text',
					'title' => __('Vimeo video ID', 'mfn-opts'),
					'desc' => __('It`s placed in every Vimeo video link after the last /,for example: http://vimeo.com/<b>1084537</b>', 'mfn-opts')
				),
				
				array(
					'id' => 'width',
					'type' => 'text',
					'title' => __('Width', 'mfn-opts'),
					'desc' => __('px', 'mfn-opts'),
					'class' => 'small-text',
					'std' => 700,
				),
				
				array(
					'id' => 'height',
					'type' => 'text',
					'title' => __('Height', 'mfn-opts'),
					'desc' => __('px', 'mfn-opts'),
					'class' => 'small-text',
					'std' => 400,
				),
				
			),															
		),
		
		// YouTube  --------------------------------------------
		'youtube' => array(
			'type' => 'youtube',
			'title' => __('YouTube', 'mfn-opts'), 
			'size' => '1/4', 
			'fields' => array(
		
				array(
					'id' => 'video',
					'type' => 'text',
					'title' => __('YouTube video ID', 'mfn-opts'),
					'desc' => __('It`s placed in every YouTube video link after <b>v=</b> parameter, for example: http://www.youtube.com/watch?v=<b>YE7VzlLtp-4</b>', 'mfn-opts')
				),
				
				array(
					'id' => 'width',
					'type' => 'text',
					'title' => __('Width', 'mfn-opts'),
					'desc' => __('px', 'mfn-opts'),
					'class' => 'small-text',
					'std' => 700,
				),
				
				array(
					'id' => 'height',
					'type' => 'text',
					'title' => __('Height', 'mfn-opts'),
					'desc' => __('px', 'mfn-opts'),
					'class' => 'small-text',
					'std' => 420
				),
				
			),															
		),
		
	);
	
	$mfn_items = get_post_meta($post->ID, 'mfn-page-items', true);
	$mfn_tmp_fn = 'base'.'64_decode';
	$mfn_items = unserialize(call_user_func($mfn_tmp_fn, $mfn_items));	
	
	?>
	<div id="mfn-builder">
	
		<div id="mfn-content">
		
			<!-- .mfn-add-item ------------------------------------------------------>
			<div class="mfn-add-item">
				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row">
								Content builder
								<span class="description">Add new item to the content</span>
							</th>
							<td>
								<select id="mfn-add-select">
									<option value="">&mdash; Select &mdash;</option>		
									<?php 
										foreach( $mfn_std_items as $item ){
											echo '<option value="'. $item['type'] .'">'. $item['title'] .'</option>';
										}
									?>
								</select>
								<a class="btn-blue mfn-add-btn" href="javascript:void(0);">Add item</a>
								<span class="description">Choose an element and click the Add Item button</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
				
			
			<!-- #mfn-items ----------------------------------------------------------->
			<div id="mfn-items" class="clearfix">
			
				<?php
					foreach( $mfn_std_items as $item )
					{
						mfn_builder_item( $item );
					}
				?>
								
			</div><!-- #mfn-items ------------------------------------------------------->

			<!-- #mfn-desk -------------------------------------------------------------->
			<div id="mfn-desk" class="clearfix">
			
				<?php
					if( is_array($mfn_items) )
					{
						foreach( $mfn_items as $item )
						{
							mfn_builder_item( $mfn_std_items[$item['type']], $item );
						}
					}
				?>
			
			</div>
	
		</div>
		
		<!-- #mfn-popup -->
		<div id="mfn-popup">
			<a href="javascript:void(0);" class="mfn-btn-close mfn-popup-close"><em>close</em></a>	
			<a href="javascript:void(0);" class="mfn-popup-save">Save changes</a>	
		</div>
		
	</div>
	<?php 

}


/*-----------------------------------------------------------------------------------*/
/*	Muffin builder save
/*-----------------------------------------------------------------------------------*/
function mfn_builder_save($post_id) {
	
//	print_r($_POST);	
	if( key_exists('mfn-item-type', $_POST) && is_array($_POST['mfn-item-type']))
	{
		$items = array();
		$count = array();	
		$tabs_count = array();
		
		foreach($_POST['mfn-item-type'] as $type_k => $type)
		{
			$item = array();
			$item['type'] = $type;
			$item['size'] = $_POST['mfn-item-size'][$type_k];
			
			if( ! key_exists($type, $count) ){
				$count[$type] = 1;
			}
			
			if( ! key_exists($type, $tabs_count) ){
				$tabs_count[$type] = 0;
			}
			
			if( key_exists($type, $_POST['mfn-items']) ){
				foreach( (array) $_POST['mfn-items'][$type] as $attr_k => $attr ){			
					if( in_array($type, array('accordion','faq','tabs')) ){
						// accordion & faq & tabs ----------------------------
						$item['fields']['count'] = $attr['count'][$count[$type]];
						if( $item['fields']['count'] ){
							for ($i = 0; $i < $item['fields']['count']; $i++) {
								$tab = array();
								$tab['title'] = stripslashes($attr['title'][$tabs_count[$type]]);
								$tab['content'] = stripslashes($attr['content'][$tabs_count[$type]]);
								$item['fields']['tabs'][] = $tab;
								$tabs_count[$type]++;
							}
						}
						
					} else {
						$item['fields'][$attr_k] = stripslashes($attr[$count[$type]]);
					}
				} 
			}
			
			$count[$type] ++;
			$items[] = $item;
		}

//		print_r($items);	
		$mfn_tmp_fn = 'base'.'64_encode';
		$new = call_user_func($mfn_tmp_fn, serialize($items));		
	}
	
	if( key_exists('mfn-items', $_POST) ) // "quick edit" fix
	{
		$field['id'] = 'mfn-page-items';
		$old = get_post_meta($post_id, $field['id'], true);
		
		if( isset($new) && $new != $old ) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif( '' == $new && $old ) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}

}


/*-----------------------------------------------------------------------------------*/
/*	Muffin builder print
/*-----------------------------------------------------------------------------------*/
function mfn_print_accordion( $item ) {
	echo sc_accordion( $item['fields'] );
}


function mfn_print_alert( $item ) {
	echo sc_alert( $item['fields'] );
}


function mfn_print_blockquote( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_blockquote( $item['fields'], $item['fields']['content'] );
}


function mfn_print_call_to_action( $item ) {
	echo sc_call_to_action( $item['fields'] );
}


function mfn_print_clients( $item ) {
	echo sc_clients( $item['fields'] );
}


function mfn_print_code( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_code( $item['fields'], $item['fields']['content'] );
}

function mfn_print_column( $item ) {
	if( key_exists('inner_padding', $item['fields']) && $item['fields']['inner_padding'] ) echo '<div class="inner-padding">';
		if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
		echo do_shortcode( $item['fields']['content'] );
	if( key_exists('inner_padding', $item['fields']) && $item['fields']['inner_padding'] ) echo '</div>';
}


function mfn_print_contact_box( $item ) {
	echo sc_contact_box( $item['fields'] );
}


function mfn_print_contact_form( $item ) {
	echo sc_contact_form( $item['fields'] );
}


function mfn_print_content( $item ) {
	echo '<div class="the_content">';
		if( key_exists('inner_padding', $item['fields']) && $item['fields']['inner_padding'] ) echo '<div class="inner-padding">';
			the_content();
		if( key_exists('inner_padding', $item['fields']) && $item['fields']['inner_padding'] ) echo '</div>';
	echo '</div>';
}


function mfn_print_divider( $item ) {
	echo sc_divider( $item['fields'] );
}


function mfn_print_faq( $item ) {
	echo sc_faq( $item['fields'] );
}


function mfn_print_feature_box( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_feature_box( $item['fields'], $item['fields']['content'] );
}


function mfn_print_image( $item ) {
	echo sc_image( $item['fields'] );
}


function mfn_print_info_box( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_info_box( $item['fields'], $item['fields']['content'] );
}


function mfn_print_latest_posts( $item ) {
	echo sc_latest_posts( $item['fields'] );
}


function mfn_print_map( $item ) {
	echo sc_map( $item['fields'] );
}


function mfn_print_offer_page( $item ) {
	echo sc_offer_page( $item['fields'] );
}


function mfn_print_offer( $item ) {
	echo sc_offer( $item['fields'] );
}


function mfn_print_our_team( $item ) {
	echo sc_our_team( $item['fields'] );
}


function mfn_print_portfolio( $item ) {
	echo sc_portfolio( $item['fields'] );
}


function mfn_print_pricing_item( $item ) {
	if( ! key_exists('content', $item['fields']) ) $item['fields']['content'] = '';
	echo sc_pricing_item( $item['fields'], $item['fields']['content'] );
}


function mfn_print_tabs( $item ) {
	echo sc_tabs( $item['fields'] );
}


function mfn_print_testimonials( $item ) {
	echo sc_testimonials( $item['fields'] );
}


function mfn_print_testimonials_page( $item ) {
	echo sc_testimonials_page( $item['fields'] );
}


function mfn_print_vimeo( $item ) {
	echo sc_vimeo( $item['fields'] );
}


function mfn_print_youtube( $item ) {
	echo sc_youtube( $item['fields'] );
}

?>