<?php
/**
 * Theme Options - fields and args
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

require_once( dirname( __FILE__ ) . '/fonts.php' );
require_once( dirname( __FILE__ ) . '/options.php' );


/**
 * Options Page fields and args
 */
function mfn_opts_setup(){
	
	// Navigation elements
	$menu = array(	
	
		// General --------------------------------------------
		'general' => array(
			'title' => __('Getting started', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/general.png',
			'sections' => array( 'general', 'sidebars', 'blog', 'portfolio', 'slider'),
		),
		
		// Layout --------------------------------------------
		'elements' => array(
			'title' => __('Layout', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/elements.png',
			'sections' => array( 'layout-general', 'layout-header', 'social', 'custom-css' ),
		),
		
		// Colors --------------------------------------------
		'colors' => array(
			'title' => __('Colors', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/colors.png',
			'sections' => array( 'colors-general', 'menu', 'colors-header', 'content', 'colors-footer', 'colors-blog', 'headings', 'colors-accordion', 'colors-shortcodes', 'colors-widgets'),
		),
		
		// Fonts --------------------------------------------
		'font' => array(
			'title' => __('Fonts', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/font.png',
			'sections' => array( 'font-family', 'font-size' ),
		),
		
		// Translate --------------------------------------------
		'translate' => array(
			'title' => __('Translate', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/translate.png',
			'sections' => array( 'translate-general', 'translate-blog', 'translate-contact', 'translate-404' ),
		),
		
	);

	$sections = array();

	// General ----------------------------------------------------------------------------------------
	
	// General -------------------------------------------
	$sections['general'] = array(
		'title' => __('General', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
				
			array(
				'id' => 'responsive',
				'type' => 'switch',
				'title' => __('Responsive', 'mfn-opts'), 
				'desc' => __('<b>Notice:</b> Responsive menu is working only with WordPress custom menu, please add one in Appearance > Menus and select it for Theme Locations section. <a href="http://en.support.wordpress.com/menus/" target="_blank">http://en.support.wordpress.com/menus/</a>', 'mfn-opts'), 
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'mfn-seo',
				'type' => 'switch',
				'title' => __('Use built-in SEO fields', 'mfn-opts'), 
				'desc' => __('Turn it off if you want to use external SEO plugin.', 'mfn-opts'), 
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'meta-description',
				'type' => 'text',
				'title' => __('Meta Description', 'mfn-opts'),
				'desc' => __('These setting may be overridden for single posts & pages.', 'mfn-opts'),
				'std' => get_bloginfo( 'description' ),
			),
			
			array(
				'id' => 'meta-keywords',
				'type' => 'text',
				'title' => __('Meta Keywords', 'mfn-opts'),
				'desc' => __('These setting may be overridden for single posts & pages.', 'mfn-opts'),
			),
			
			array(
				'id' => 'google-analytics',
				'type' => 'textarea',
				'title' => __('Google Analytics', 'mfn-opts'), 
				'sub_desc' => __('Paste your Google Analytics code here.', 'mfn-opts'),
			),
			
		),
	);
	
	// Sidebars --------------------------------------------
	$sections['sidebars'] = array(
		'title' => __('Sidebars', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
	
			array(
				'id' => 'sidebar-layout',
				'type' => 'radio_img',
				'title' => __('Default Layout', 'mfn-opts'), 
				'sub_desc' => __('Default post or page sidebar', 'mfn-opts'),
				'options' => array(
					'no-sidebar' => array('title' => 'Full width without sidebar', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
					'left-sidebar' => array('title' => 'Left Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cl.png'),
					'right-sidebar' => array('title' => 'Right Sidebar', 'img' => MFN_OPTIONS_URI.'img/2cr.png')
				),
				'std' => 'no-sidebar'																		
			),
	
			array(
				'id' => 'sidebars',
				'type' => 'multi_text',
				'title' => __('Sidebars', 'mfn-opts'),
				'sub_desc' => __('Manage custom sidebars', 'mfn-opts'),
				'desc' => __('Sidebars can be used on pages, blog and portfolio', 'mfn-opts')
			),
				
		),
	);
	
	// Blog --------------------------------------------
	$sections['blog'] = array(
		'title' => __('Blog', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
	
			array(
				'id' => 'blog-posts',
				'type' => 'text',
				'title' => __('Posts per page', 'mfn-opts'),
				'sub_desc' => __('Number of posts per page.', 'mfn-opts'),
				'class' => 'small-text',
				'std' => '4',
			),
			
			array(
				'id' => 'blog-categories',
				'type' => 'switch',
				'title' => __('Show Categories', 'mfn-opts'), 
				'sub_desc' => __('Show categories on posts list and single post.', 'mfn-opts'), 
				'desc' => __('These setting may be overridden for single posts.', 'mfn-opts'), 
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'blog-comments',
				'type' => 'switch',
				'title' => __('Show Comments', 'mfn-opts'), 
				'sub_desc' => __('Show comments number on posts list and single post.', 'mfn-opts'),
				'desc' => __('These setting may be overridden for single posts.', 'mfn-opts'), 
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'blog-time',
				'type' => 'switch',
				'title' => __('Show Date', 'mfn-opts'), 
				'sub_desc' => __('Show date on posts list and single post.', 'mfn-opts'), 
				'desc' => __('These setting may be overridden for single posts.', 'mfn-opts'), 
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'blog-tags',
				'type' => 'switch',
				'title' => __('Show Tags', 'mfn-opts'), 
				'sub_desc' => __('Show tags list on posts list and single post.', 'mfn-opts'),
				'desc' => __('These setting may be overridden for single posts.', 'mfn-opts'),  
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'blog-social',
				'type' => 'switch',
				'title' => __('Social network sharing', 'mfn-opts'), 
				'sub_desc' => __('Show social network sharing on single post.', 'mfn-opts'),
				'desc' => __('These setting may be overridden for single posts.', 'mfn-opts'),  
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'pagination-show-all',
				'type' => 'switch',
				'title' => __('All pages in pagination', 'mfn-opts'),
				'desc' => __('Show all of the pages instead of a short list of the pages near the current page.', 'mfn-opts'),  
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
				
		),
	);
	
	// Portfolio --------------------------------------------
	$sections['portfolio'] = array(
		'title' => __('Portfolio', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
	
			array(
				'id' => 'portfolio-posts',
				'type' => 'text',
				'title' => __('Posts per page', 'mfn-opts'),
				'sub_desc' => __('Number of portfolio posts per page.', 'mfn-opts'),
				'class' => 'small-text',
				'std' => '8',
			),
			
			array(
				'id' => 'portfolio-layout',
				'type' => 'radio_img',
				'title' => __('Layout', 'mfn-opts'), 
				'sub_desc' => __('Layout for portfolio items list.', 'mfn-opts'),
				'options' => array(
					'one-second' => array('title' => 'Two columns', 'img' => MFN_OPTIONS_URI.'img/one-second.png'),
					'one-third' => array('title' => 'Three columns', 'img' => MFN_OPTIONS_URI.'img/one-third.png'),
					'one-fourth' => array('title' => 'Four columns', 'img' => MFN_OPTIONS_URI.'img/one-fourth.png'),
				),
				'std' => 'one-fourth'																		
			),
			
			array(
				'id' => 'portfolio-page',
				'type' => 'pages_select',
				'title' => __('Portfolio Page', 'mfn-opts'), 
				'sub_desc' => __('Assign page for portfolio.', 'mfn-opts'),
				'args' => array()
			),
			
			array(
				'id' => 'portfolio-slug',
				'type' => 'text',
				'title' => __('Single item slug', 'mfn-opts'),
				'sub_desc' => __('Link to single item.', 'mfn-opts'),
				'desc' => __('<b>Important:</b> Do not use characters not allowed in links. <br /><br />Must be different from the Portfolio site title chosen above, eg. "portfolio-item". After change please go to "Settings > Permalinks" and click "Save changes" button.', 'mfn-opts'),
				'class' => 'small-text',
				'std' => 'portfolio-item',
			),
			
			array(
				'id' => 'portfolio-orderby',
				'type' => 'select',
				'title' => __('Order by', 'mfn-opts'), 
				'sub_desc' => __('Portfolio items order by column.', 'mfn-opts'),
				'options' => array('date'=>'Date', 'menu_order' => 'Menu order', 'title'=>'Title'),
				'std' => 'menu_order'
			),
			
			array(
				'id' => 'portfolio-order',
				'type' => 'select',
				'title' => __('Order', 'mfn-opts'), 
				'sub_desc' => __('Portfolio items order.', 'mfn-opts'),
				'options' => array('ASC' => 'Ascending', 'DESC' => 'Descending'),
				'std' => 'ASC'
			),
			
			array(
				'id' => 'portfolio-isotope',
				'type' => 'switch',
				'title' => __('jQuery filtering', 'mfn-opts'),
				'desc' => __('When this option is enabled, portfolio looks great with all projects on single site, so please set "Posts per page" option to bigger number', 'mfn-opts'),  
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
				
		),
	);
	
	// Slider --------------------------------------------
	$sections['slider'] = array(
		'title' => __('Sliders', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
				
			array(
				'id' => 'slider-posts-auto',
				'type' => 'text',
				'title' => __('Latest Posts - Timeout', 'mfn-opts'),
				'sub_desc' => __('Milliseconds between slide transitions.', 'mfn-opts'),
				'desc' => __('<strong>0 to disable auto</strong> advance.', 'mfn-opts'),
				'class' => 'small-text',
				'std' => '0',
			),
				
			array(
				'id' => 'slider-portfolio-auto',
				'type' => 'text',
				'title' => __('Portfolio - Timeout', 'mfn-opts'),
				'sub_desc' => __('Milliseconds between slide transitions.', 'mfn-opts'),
				'desc' => __('<strong>0 to disable auto</strong> advance.', 'mfn-opts'),
				'class' => 'small-text',
				'std' => '0',
			),
			
			array(
				'id' => 'slider-clients-auto',
				'type' => 'text',
				'title' => __('Clients - Timeout', 'mfn-opts'),
				'sub_desc' => __('Milliseconds between slide transitions.', 'mfn-opts'),
				'desc' => __('<strong>0 to disable auto</strong> advance.', 'mfn-opts'),
				'class' => 'small-text',
				'std' => '0',
			),
			
			array(
				'id' => 'slider-clients-visible',
				'type' => 'text',
				'title' => __('Clients - Visible Items', 'mfn-opts'),
				'sub_desc' => __('Number of visible items.', 'mfn-opts'),
				'desc' => __('Recommended number: 3-6', 'mfn-opts'),
				'class' => 'small-text',
				'std' => '5',
			),
								
		),
	);
	
	// Layout ----------------------------------------------------------------------------------------
	
	// General --------------------------------------------
	$sections['layout-general'] = array(
		'title' => __('General', 'mfn-opts'),
		'fields' => array(
		
			array(
				'id' => 'img-page-bg',
				'type' => 'upload',
				'title' => __('Background Image', 'mfn-opts'),
			),
					
			array(
				'id' => 'position-page-bg',
				'type' => 'select',
				'title' => __('Background Image position', 'mfn-opts'),
				'desc' => __('This option can be used only with your custom image selected above.', 'mfn-opts'),
				'options' => array(
					'center top no-repeat' => 'Center Top No-Repeat',
					'center top repeat' => 'Center Top Repeat',
					'center center no-repeat' => 'Center No-Repeat',
					'center center repeat' => 'Center Repeat',
					'left top no-repeat' => 'Left Top No-Repeat',
					'left top repeat' => 'Left Top Repeat',
					'center top no-repeat fixed' => 'Center No-Repeat Fixed',
					'no-repeat fixed center center / cover' => 'Center No-Repeat Fixed Cover',
				),
				'std' => 'center top no-repeat',
			),
			
			array(
				'id' => 'img-subheader-bg',
				'type' => 'upload',
				'title' => __('Subheader Image', 'mfn-opts'),
			),
			
			array(
				'id' => 'fixed-height-1240',
				'type' => 'text',
				'title' => __('1240px Fixed Box height', 'mfn-opts'),
				'sub_desc' => __('Desktop', 'mfn-opts'),
				'desc' => __('px.', 'mfn-opts'),
				'class' => 'small-text',
			),
			
			array(
				'id' => 'fixed-height-960',
				'type' => 'text',
				'title' => __('960px Fixed Box height', 'mfn-opts'),
				'sub_desc' => __('Desktop Small', 'mfn-opts'),
				'desc' => __('px.', 'mfn-opts'),
				'class' => 'small-text',
			),
			
			array(
				'id' => 'fixed-height-768',
				'type' => 'text',
				'title' => __('768px Fixed Box height', 'mfn-opts'),
				'sub_desc' => __('Tablet', 'mfn-opts'),
				'desc' => __('px.', 'mfn-opts'),
				'class' => 'small-text',
			),

		),
	);
	
	// Header --------------------------------------------
	$sections['layout-header'] = array(
		'title' => __('Header', 'mfn-opts'),
		'fields' => array(
				
			array(
				'id' => 'logo-img',
				'type' => 'upload',
				'title' => __('Custom Logo', 'mfn-opts'),
				'sub_desc' => __('Custom logo image', 'mfn-opts'),
			),
	
			array(
				'id' => 'retina-logo-img',
				'type' => 'upload',
				'title' => __('Retina Logo', 'mfn-opts'),
				'sub_desc' => __('2x larger logo image', 'mfn-opts'),
				'desc' => __('Retina Logo should be 2x larger than Custom Logo (field is optional).', 'mfn-opts'),
			),

			array(
				'id' => 'retina-logo-width',
				'type' => 'text',
				'title' => __('Custom Logo Width', 'mfn-opts'),
				'sub_desc' => __('for Retina Logo', 'mfn-opts'),
				'desc' => __('px. Please type width of Custom Logo image (<strong>not</strong> Retina Logo).', 'mfn-opts'),
				'class' => 'small-text',
			),

			array(
				'id' => 'retina-logo-height',
				'type' => 'text',
				'title' => __('Custom Logo Height', 'mfn-opts'),
				'sub_desc' => __('for Retina Logo', 'mfn-opts'),
				'desc' => __('px. Please type height of Custom Logo image (<strong>not</strong> Retina Logo).', 'mfn-opts'),
				'class' => 'small-text',
			),
	
			array(
				'id' => 'favicon-img',
				'type' => 'upload',
				'title' => __('Custom Favicon', 'mfn-opts'),
				'sub_desc' => __('Site favicon', 'mfn-opts'),
				'desc' => __('Please use ICO format only.', 'mfn-opts')
			),
			
			array(
				'id' => 'telephone-number',
				'type' => 'text',
				'title' => __('Phone number', 'mfn-opts'),
			),
				
		),
	);
	
	// Social Icons --------------------------------------------
	$sections['social'] = array(
		'title' => __('Social Icons', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
				
			array(
				'id' => 'social-facebook',
				'type' => 'text',
				'title' => __('Facebook', 'mfn-opts'),
				'sub_desc' => __('Type your Facebook link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-googleplus',
				'type' => 'text',
				'title' => __('Google +', 'mfn-opts'),
				'sub_desc' => __('Type your Google + link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-twitter',
				'type' => 'text',
				'title' => __('Twitter', 'mfn-opts'),
				'sub_desc' => __('Type your Twitter link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-vimeo',
				'type' => 'text',
				'title' => __('Vimeo', 'mfn-opts'),
				'sub_desc' => __('Type your Vimeo link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-youtube',
				'type' => 'text',
				'title' => __('YouTube', 'mfn-opts'),
				'sub_desc' => __('Type your YouTube link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-flickr',
				'type' => 'text',
				'title' => __('Flickr', 'mfn-opts'),
				'sub_desc' => __('Type your Flickr link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-linkedin',
				'type' => 'text',
				'title' => __('LinkedIn', 'mfn-opts'),
				'sub_desc' => __('Type your LinkedIn link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-pinterest',
				'type' => 'text',
				'title' => __('Pinterest', 'mfn-opts'),
				'sub_desc' => __('Type your Pinterest link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
			
			array(
				'id' => 'social-dribbble',
				'type' => 'text',
				'title' => __('Dribbble', 'mfn-opts'),
				'sub_desc' => __('Type your Dribbble link here', 'mfn-opts'),
				'desc' => __('Icon won`t show if you leave this field blank' , 'mfn-opts'),
			),
				
		),
	);
	
	// Custom CSS --------------------------------------------
	$sections['custom-css'] = array(
		'title' => __('Custom CSS', 'mfn-opts'),
		'fields' => array(

			array(
				'id' => 'custom-css',
				'type' => 'textarea',
				'title' => __('Custom CSS', 'mfn-opts'), 
				'sub_desc' => __('Paste your custom CSS code here.', 'mfn-opts'),
			),
				
		),
	);

	// Colors ----------------------------------------------------------------------------------------
	
	// General --------------------------------------------
	$sections['colors-general'] = array(
		'title' => __('General', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
							
			array(
				'id' => 'skin',
				'type' => 'select',
				'title' => __('Theme Skin', 'mfn-opts'), 
				'sub_desc' => __('Choose one of the predefined styles or set your own colors.', 'mfn-opts'), 
				'desc' => __('<b>Important:</b> Color options can be used only with the Custom Skin.', 'mfn-opts'), 
				'options' => array(
			
					'custom' => 'Custom',
					'blue' => 'Blue',
					'green' => 'Green',
					'orange' => 'Orange',
					'red' => 'Red',
			
				),
				'std' => 'custom',
			),
			
			array(
				'id' => 'background-body',
				'type' => 'color',
				'title' => __('Body background', 'mfn-opts'), 
				'std' => '#dfe3e5',
			),
			
		),
	);
	
	// Main menu --------------------------------------------
	$sections['menu'] = array(
		'title' => __('Main menu', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
			
			array(
				'id' => 'color-menu-a',
				'type' => 'color',
				'title' => __('Menu Link color', 'mfn-opts'), 
				'std' => '#fff'
			),
				
			array(
				'id' => 'background-menu-a-active',
				'type' => 'color',
				'title' => __('Hover  Menu Link background', 'mfn-opts'),
				'desc' => __('This is also Submenu background.', 'mfn-opts'),
				'std' => '#2ecc71'
			),
			
			array(
				'id' => 'color-menu-a-active',
				'type' => 'color',
				'title' => __('Hover Menu Link color', 'mfn-opts'),
				'std' => '#fff'
			),
				
			array(
				'id' => 'color-submenu-a',
				'type' => 'color',
				'title' => __('Submenu Link color', 'mfn-opts'),
				'std' => '#fff'
			),
				
			array(
				'id' => 'border-submenu-a',
				'type' => 'color',
				'title' => __('Submenu Link border', 'mfn-opts'),
				'std' => '#39d67c'
			),
			
			array(
				'id' => 'background-submenu-a-hover',
				'type' => 'color',
				'title' => __('Hover Submenu Link background', 'mfn-opts'),
				'std' => '#27BC66'
			),
			
			array(
				'id' => 'color-submenu-a-hover',
				'type' => 'color',
				'title' => __('Hover Submenu Link color', 'mfn-opts'),
				'std' => '#fff'
			),
				
		),
	);
	
	// Header --------------------------------------------
	$sections['colors-header'] = array(
		'title' => __('Header', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
				
			array(
				'id' => 'background-header',
				'type' => 'color',
				'title' => __('Header background', 'mfn-opts'),
				'std' => '#2c3e50',
			),
				
			array(
				'id' => 'background-logo',
				'type' => 'color',
				'title' => __('Logo background', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-phone-ico',
				'type' => 'color',
				'title' => __('Phone Icon color', 'mfn-opts'),
				'std' => '#bac4c5',
			),
				
			array(
				'id' => 'color-phone-number',
				'type' => 'color',
				'title' => __('Phone Number color', 'mfn-opts'),
				'std' => '#34495e',
			),
				
			array(
				'id' => 'background-social',
				'type' => 'color',
				'title' => __('Social Icon background', 'mfn-opts'),
				'std' => '#bac4c5',
			),
				
			array(
				'id' => 'color-social',
				'type' => 'color',
				'title' => __('Social Icon color', 'mfn-opts'),
				'std' => '#dfe3e5',
			),

			array(
				'id' => 'background-social-hover',
				'type' => 'color',
				'title' => __('Hover Social Icon background', 'mfn-opts'),
				'std' => '#2ecc71',
			),
			
			array(
				'id' => 'color-social-hover',
				'type' => 'color',
				'title' => __('Hover Social Icon color', 'mfn-opts'),
				'std' => '#fff',
			),
	
			array(
				'id' => 'background-subheader-title',
				'type' => 'color',
				'title' => __('Title Area Title background', 'mfn-opts'), 
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-subheader-title',
				'type' => 'color',
				'title' => __('Title Area Title color', 'mfn-opts'), 
				'std' => '#2c3e50',
			),
			
			array(
				'id' => 'color-breadcrumbs',
				'type' => 'color',
				'title' => __('Breadcrumbs color', 'mfn-opts'),
				'desc' => __('To change home icon please edit <strong>images/breadcrumbs_home.png</strong> file.', 'mfn-opts'),
				'std' => '#99AEB0',
			),

		),
	);
	
	// Content --------------------------------------------
	$sections['content'] = array(
		'title' => __('Content', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
	
			array(
				'id' => 'background-content',
				'type' => 'color',
				'title' => __('Content background', 'mfn-opts'), 
				'std' => '#fff'
			),
	
			array(
				'id' => 'color-text',
				'type' => 'color',
				'title' => __('Text color', 'mfn-opts'), 
				'sub_desc' => __('Content text color.', 'mfn-opts'),
				'std' => '#717e8c'
			),
			
			array(
				'id' => 'color-a',
				'type' => 'color',
				'title' => __('Link color', 'mfn-opts'), 
				'std' => '#2c3e50'
			),
			
			array(
				'id' => 'color-a-hover',
				'type' => 'color',
				'title' => __('Hover Link color', 'mfn-opts'), 
				'std' => '#192938'
			),
			
			array(
				'id' => 'color-note',
				'type' => 'color',
				'title' => __('Grey Note text color', 'mfn-opts'),
				'desc' => __('Grey Note, eg. post date, etc.', 'mfn-opts'),
				'std' => '#98a7a8'
			),
				
			array(
				'id' => 'color-bold-note',
				'type' => 'color',
				'title' => __('Bold Note text color', 'mfn-opts'),  
				'std' => '#2ecc71'
			),
			
			array(
				'id' => 'border-borders',
				'type' => 'color',
				'title' => __('Border color', 'mfn-opts'), 
				'std' => '#dfe3e5'
			),

			array(
				'id' => 'background-button',
				'type' => 'color',
				'title' => __('Button background', 'mfn-opts'), 
				'std' => '#1BB852',
			),
			
			array(
				'id' => 'color-button',
				'type' => 'color',
				'title' => __('Button text color', 'mfn-opts'), 
				'std' => '#fff',
			),

			array(
				'id' => 'background-button-hover',
				'type' => 'color',
				'title' => __('Hover Button background', 'mfn-opts'), 
				'std' => '#02AE3F',
			),
			
			array(
				'id' => 'color-button-hover',
				'type' => 'color',
				'title' => __('Hover Button text color', 'mfn-opts'), 
				'std' => '#fff',
			),
	
		),
	);
	
	// Footer --------------------------------------------
	$sections['colors-footer'] = array(
		'title' => __('Footer', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
	
			array(
				'id' => 'background-footer',
				'type' => 'color',
				'title' => __('Footer background', 'mfn-opts'),
				'std' => '#2c3e50',
			),
	
			array(
				'id' => 'color-footer',
				'type' => 'color',
				'title' => __('Footer text color', 'mfn-opts'),
				'std' => '#dfe3e5',
			),
	
			array(
				'id' => 'color-footer-link',
				'type' => 'color',
				'title' => __('Footer Link color', 'mfn-opts'),
				'std' => '#2ecc71',
			),
	
			array(
				'id' => 'color-footer-link-hover',
				'type' => 'color',
				'title' => __('Footer Hover Link color', 'mfn-opts'),
				'std' => '#26ec7a',
			),
	
			array(
				'id' => 'color-footer-heading',
				'type' => 'color',
				'title' => __('Footer Heading color', 'mfn-opts'),
				'std' => '#fff',
			),
	
			array(
				'id' => 'color-footer-widget-title',
				'type' => 'color',
				'title' => __('Footer Widget Title color', 'mfn-opts'),
				'std' => '#2ecc71',
			),
	
			array(
				'id' => 'color-footer-copyrights',
				'type' => 'color',
				'title' => __('Footer Copyrights color', 'mfn-opts'),
				'std' => '#61727b',
			),
			
			array(
				'id' => 'background-footer-social',
				'type' => 'color',
				'title' => __('Footer Social Icon background', 'mfn-opts'),
				'std' => '#61727b',
			),
			
			array(
				'id' => 'color-footer-social',
				'type' => 'color',
				'title' => __('Footer Social Icon color', 'mfn-opts'),
				'std' => '#2c3e50',
			),
			
			array(
				'id' => 'background-footer-social-hover',
				'type' => 'color',
				'title' => __('Footer Hover Social Icon background', 'mfn-opts'),
				'std' => '#2ecc71',
			),
				
			array(
				'id' => 'color-footer-social-hover',
				'type' => 'color',
				'title' => __('Footer Hover Social Icon color', 'mfn-opts'),
				'std' => '#fff',
			),
	
		),
	);
	
	// Colors Blog --------------------------------------------
	$sections['colors-blog'] = array(
		'title' => __('Blog & Portfolio', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(	
				
			array(
				'id' => 'color-pager-link',
				'type' => 'color',
				'title' => __('Pager Link color', 'mfn-opts'),
				'std' => '#b5bfc0'
			),
				
			array(
				'id' => 'color-pager-link-active',
				'type' => 'color',
				'title' => __('Active Pager Link color', 'mfn-opts'),
				'std' => '#04a448'
			),
				
			array(
				'id' => 'color-blog-title',
				'type' => 'color',
				'title' => __('Blog Post Title color', 'mfn-opts'),
				'std' => '#2ecc71'
			),
				
			array(
				'id' => 'background-portfolio-overlay',
				'type' => 'color',
				'title' => __('Portfolio Image overlay', 'mfn-opts'),
				'desc' => __('This is also Image Frames overlay.', 'mfn-opts'),
				'std' => '#2084C6',
			),
				
			array(
				'id' => 'background-portfolio-category-active',
				'type' => 'color',
				'title' => __('Active Portfolio Category link background', 'mfn-opts'),
				'std' => '#31be63',
			),

		),
	);
	
	// Headings --------------------------------------------
	$sections['headings'] = array(
		'title' => __('Headings', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
	
			array(
				'id' => 'color-h1',
				'type' => 'color',
				'title' => __('Heading H1 color', 'mfn-opts'), 
				'std' => '#2c3e50'
			),
			
			array(
				'id' => 'color-h2',
				'type' => 'color',
				'title' => __('Heading H2 color', 'mfn-opts'), 
				'std' => '#2c3e50'
			),
			
			array(
				'id' => 'color-h3',
				'type' => 'color',
				'title' => __('Heading H3 color', 'mfn-opts'), 
				'std' => '#2c3e50'
			),
			
			array(
				'id' => 'color-h4',
				'type' => 'color',
				'title' => __('Heading H4 color', 'mfn-opts'), 
				'std' => '#2c3e50'
			),
			
			array(
				'id' => 'color-h5',
				'type' => 'color',
				'title' => __('Heading H5 color', 'mfn-opts'), 
				'std' => '#2c3e50'
			),
			
			array(
				'id' => 'color-h6',
				'type' => 'color',
				'title' => __('Heading H6 color', 'mfn-opts'), 
				'std' => '#2c3e50'
			),
				
		),
	);
	
	// Accordion & Tabs --------------------------------------------
	$sections['colors-accordion'] = array(
		'title' => __('Accordion & Tabs', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
	
			array(
				'id' => 'background-accordion-title',
				'type' => 'color',
				'title' => __('Accordion Title background', 'mfn-opts'),
				'std' => '#2ecc71',
			),
	
			array(
				'id' => 'color-accordion-title',
				'type' => 'color',
				'title' => __('Accordion Title color', 'mfn-opts'),
				'std' => '#fff',
			),
	
			array(
				'id' => 'background-accordion-text',
				'type' => 'color',
				'title' => __('Accordion Content background', 'mfn-opts'),
				'std' => '#2abd68',
			),
	
			array(
				'id' => 'color-accordion-text',
				'type' => 'color',
				'title' => __('Accordion Content color', 'mfn-opts'),
				'std' => '#fff',
			),
			
			array(
				'id' => 'background-tabs-title',
				'type' => 'color',
				'title' => __('Tabs Title background', 'mfn-opts'),
				'std' => '#bac4c5',
			),
			
			array(
				'id' => 'color-tabs-title',
				'type' => 'color',
				'title' => __('Tabs Title color', 'mfn-opts'),
				'std' => '#2c3e50',
			),
			
			array(
				'id' => 'background-tabs-title-active',
				'type' => 'color',
				'title' => __('Active Tab Title background', 'mfn-opts'),
				'std' => '#fff',
			),
			
			array(
				'id' => 'color-tabs-title-active',
				'type' => 'color',
				'title' => __('Active Tab Title color', 'mfn-opts'),
				'std' => '#2ecc71',
			),
			
			array(
				'id' => 'background-tabs-content',
				'type' => 'color',
				'title' => __('Tabs Content background', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-tabs-content',
				'type' => 'color',
				'title' => __('Tabs Content color', 'mfn-opts'),
				'std' => '#717E8C',
			),
					
		),
	);
	
	// Shortcodes --------------------------------------------
	$sections['colors-shortcodes'] = array(
		'title' => __('Shortcodes', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(
				
			array(
				'id' => 'background-call-to-action',
				'type' => 'color',
				'title' => __('Call To Action overlay', 'mfn-opts'),
				'std' => '#2084C6',
			),
			
			array(
				'id' => 'color-call-to-action',
				'type' => 'color',
				'title' => __('Call To Action color', 'mfn-opts'),
				'std' => '#fff',
			),
			
			array(
				'id' => 'color-call-to-action-highlight',
				'type' => 'color',
				'title' => __('Call To Action Highlight color', 'mfn-opts'),
				'std' => '#BAEFF8',
			),
			
			array(
				'id' => 'color-our-team-title',
				'type' => 'color',
				'title' => __('Our Team Title color', 'mfn-opts'),
				'std' => '#2ecc71',
			),
			
			array(
				'id' => 'background-clients-slider',
				'type' => 'color',
				'title' => __('Clients Slider background', 'mfn-opts'),
				'std' => '#c9d0d2',
			),
	
			array(
				'id' => 'background-contact-box',
				'type' => 'color',
				'title' => __('Contact Box background', 'mfn-opts'),
				'std' => '#DFE3E5',
			),
			
			array(
				'id' => 'background-info-box',
				'type' => 'color',
				'title' => __('Info Box background', 'mfn-opts'),
				'std' => '#2ecc71',
			),
				
			array(
				'id' => 'color-info-box-heading',
				'type' => 'color',
				'title' => __('Info Box Title color', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-info-box',
				'type' => 'color',
				'title' => __('Info Box Text color', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'background-latest-posts',
				'type' => 'color',
				'title' => __('Latest Posts background', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'background-recent-works',
				'type' => 'color',
				'title' => __('Portfolio background', 'mfn-opts'),
				'std' => '#2c3e50',
			),
				
			array(
				'id' => 'color-recent-works-header',
				'type' => 'color',
				'title' => __('Portfolio Title color', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-recent-works',
				'type' => 'color',
				'title' => __('Portfolio Text color', 'mfn-opts'),
				'std' => '#2abd68',
			),
				
			array(
				'id' => 'border-pricing',
				'type' => 'color',
				'title' => __('Pricing Box border', 'mfn-opts'),
				'std' => '#2ecc71',
			),
				
			array(
				'id' => 'background-pricing',
				'type' => 'color',
				'title' => __('Pricing Box background', 'mfn-opts'),
				'std' => '#577899',
			),
				
			array(
				'id' => 'background-pricing-featured',
				'type' => 'color',
				'title' => __('Featured Pricing Box background', 'mfn-opts'),
				'std' => '#24609b',
			),
				
			array(
				'id' => 'color-pricing',
				'type' => 'color',
				'title' => __('Pricing Box Text color', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-pricing-price',
				'type' => 'color',
				'title' => __('Pricing Box Price', 'mfn-opts'),
				'std' => '#2ecc71',
			),
				
			array(
				'id' => 'background-testimonials',
				'type' => 'color',
				'title' => __('Testimonials background', 'mfn-opts'),
				'std' => '#DFE3E5',
			),

		),
	);

	// Widgets --------------------------------------------
	$sections['colors-widgets'] = array(
		'title' => __('Widgets', 'mfn-opts'),
		'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
		'fields' => array(

			array(
				'id' => 'background-widget-archives',
				'type' => 'color',
				'title' => __('Archives background', 'mfn-opts'),
				'std' => '#2ecc71',
			),
				
			array(
				'id' => 'color-widget-archives',
				'type' => 'color',
				'title' => __('Archives text color', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-widget-archives-hover',
				'type' => 'color',
				'title' => __('Archives Hover Link color', 'mfn-opts'),
				'std' => '#2C3E50',
			),
				
			array(
				'id' => 'background-widget-menu',
				'type' => 'color',
				'title' => __('Menu background', 'mfn-opts'),
				'std' => '#2c3e50',
			),
				
			array(
				'id' => 'color-widget-menu',
				'type' => 'color',
				'title' => __('Menu text color', 'mfn-opts'),
				'std' => '#fff',
			),
				
			array(
				'id' => 'color-widget-menu-hover',
				'type' => 'color',
				'title' => __('Menu Hover Link color', 'mfn-opts'),
				'std' => '#2ecc71',
			),
				
		),
	);

	// Font Family --------------------------------------------
	$sections['font-family'] = array(
		'title' => __('Font Family', 'mfn-opts'),
		'fields' => array(
			
			array(
				'id' => 'font-content',
				'type' => 'font_select',
				'title' => __('Content Font', 'mfn-opts'), 
				'sub_desc' => __('This font will be used for all theme texts except headings and menu.', 'mfn-opts'), 
				'std' => 'Exo'
			),
			
			array(
				'id' => 'font-menu',
				'type' => 'font_select',
				'title' => __('Main Menu Font', 'mfn-opts'), 
				'sub_desc' => __('This font will be used for header menu.', 'mfn-opts'), 
				'std' => 'Exo'
			),
			
			array(
				'id' => 'font-headings',
				'type' => 'font_select',
				'title' => __('Headings Font', 'mfn-opts'), 
				'sub_desc' => __('This font will be used for all headings.', 'mfn-opts'), 
				'std' => 'Exo'
			),
			
			array(
				'id' => 'font-subset',
				'type' => 'text',
				'title' => __('Google Font Subset', 'mfn-opts'),				
				'sub_desc' => __('Specify which subsets should be downloaded. Multiple subsets should be separated with coma (,)', 'mfn-opts'),
				'desc' => __('Some of the fonts in the Google Font Directory support multiple scripts (like Latin and Cyrillic for example). In order to specify which subsets should be downloaded the subset parameter should be appended to the URL. For a complete list of available fonts and font subsets please see <a href="http://www.google.com/webfonts" target="_blank">Google Web Fonts</a>.', 'mfn-opts'),
				'class' => 'small-text'
			),
				
		),
	);
	
	// Content Font Size --------------------------------------------
	$sections['font-size'] = array(
		'title' => __('Font Size', 'mfn-opts'),
		'fields' => array(

			array(
				'id' => 'font-size-content',
				'type' => 'sliderbar',
				'title' => __('Content', 'mfn-opts'),
				'sub_desc' => __('This font size will be used for all theme texts.', 'mfn-opts'),
				'std' => '14',
			),
				
			array(
				'id' => 'font-size-menu',
				'type' => 'sliderbar',
				'title' => __('Main menu', 'mfn-opts'),
				'sub_desc' => __('This font size will be used for top level only.', 'mfn-opts'),
				'std' => '15',
			),
			
			array(
				'id' => 'font-size-h1',
				'type' => 'sliderbar',
				'title' => __('Heading H1', 'mfn-opts'),
				'sub_desc' => __('Subpages header title.', 'mfn-opts'),
				'std' => '40',
			),
			
			array(
				'id' => 'font-size-h2',
				'type' => 'sliderbar',
				'title' => __('Heading H2', 'mfn-opts'),
				'std' => '36',
			),
			
			array(
				'id' => 'font-size-h3',
				'type' => 'sliderbar',
				'title' => __('Heading H3', 'mfn-opts'),
				'std' => '26',
			),
			
			array(
				'id' => 'font-size-h4',
				'type' => 'sliderbar',
				'title' => __('Heading H4', 'mfn-opts'),
				'std' => '24',
			),
			
			array(
				'id' => 'font-size-h5',
				'type' => 'sliderbar',
				'title' => __('Heading H5', 'mfn-opts'),
				'std' => '17',
			),
			
			array(
				'id' => 'font-size-h6',
				'type' => 'sliderbar',
				'title' => __('Heading H6', 'mfn-opts'),
				'std' => '16',
			),
	
		),
	);
	
	// Translate / General --------------------------------------------
	$sections['translate-general'] = array(
		'title' => __('General', 'mfn-opts'),
		'fields' => array(
	
			array(
				'id' => 'translate',
				'type' => 'switch',
				'title' => __('Enable Translate', 'mfn-opts'), 
				'desc' => __('Turn it off if you want to use .mo .po files for more complex translation.', 'mfn-opts'),
				'options' => array('1' => 'On','0' => 'Off'),
				'std' => '1'
			),
			
			array(
				'id' => 'translate-search-placeholder',
				'type' => 'text',
				'title' => __('Search Placeholder', 'mfn-opts'),
				'desc' => __('Widget Search', 'mfn-opts'),
				'std' => 'Enter your search',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-home',
				'type' => 'text',
				'title' => __('Home', 'mfn-opts'),
				'desc' => __('Breadcrumbs', 'mfn-opts'),
				'std' => 'Home',
				'class' => 'small-text',
			),

		),
	);
	
	// Translate / Blog & Portfolio --------------------------------------------
	$sections['translate-blog'] = array(
		'title' => __('Blog & Portfolio', 'mfn-opts'),
		'fields' => array(
				
			array(
				'id' => 'translate-comment',
				'type' => 'text',
				'title' => __('Comment', 'mfn-opts'),
				'sub_desc' => __('Text to display when there is one comment', 'mfn-opts'),
				'desc' => __('Blog', 'mfn-opts'),
				'std' => 'Comment',
				'class' => 'small-text',
			),
				
			array(
				'id' => 'translate-comments',
				'type' => 'text',
				'title' => __('Comments', 'mfn-opts'),
				'sub_desc' => __('Text to display when there are more than one comments', 'mfn-opts'),
				'desc' => __('Blog', 'mfn-opts'),
				'std' => 'Comments',
				'class' => 'small-text',
			),
				
			array(
				'id' => 'translate-comments-off',
				'type' => 'text',
				'title' => __('Comments off', 'mfn-opts'),
				'sub_desc' => __('Text to display when comments are disabled', 'mfn-opts'),
				'desc' => __('Blog', 'mfn-opts'),
				'std' => 'Comments off',
				'class' => 'small-text',
			),
	
			array(
				'id' => 'translate-select-category',
				'type' => 'text',
				'title' => __('Select category', 'mfn-opts'),
				'desc' => __('Portfolio', 'mfn-opts'),
				'std' => 'Select category:',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-all',
				'type' => 'text',
				'title' => __('All', 'mfn-opts'),
				'desc' => __('Portfolio', 'mfn-opts'),
				'std' => 'All',
				'class' => 'small-text',
			),

			array(
				'id' => 'translate-project-description',
				'type' => 'text',
				'title' => __('Project Description', 'mfn-opts'),
				'desc' => __('Single Portfolio', 'mfn-opts'),
				'std' => 'Project Description:',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-client',
				'type' => 'text',
				'title' => __('Client', 'mfn-opts'),
				'desc' => __('Single Portfolio', 'mfn-opts'),
				'std' => 'Client:',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-date',
				'type' => 'text',
				'title' => __('Date', 'mfn-opts'),
				'desc' => __('Single Portfolio', 'mfn-opts'),
				'std' => 'Date:',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-category',
				'type' => 'text',
				'title' => __('Category', 'mfn-opts'),
				'desc' => __('Single Portfolio', 'mfn-opts'),
				'std' => 'Category:',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-project-url',
				'type' => 'text',
				'title' => __('Project URL', 'mfn-opts'),
				'desc' => __('Single Portfolio', 'mfn-opts'),
				'std' => 'Project URL:',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-visit-online',
				'type' => 'text',
				'title' => __('Visit online', 'mfn-opts'),
				'desc' => __('Single Portfolio', 'mfn-opts'),
				'std' => 'Visit online &rarr;',
				'class' => 'small-text',
			),
			
			array(
				'id' => 'translate-back',
				'type' => 'text',
				'title' => __('Back to list', 'mfn-opts'),
				'desc' => __('Single Portfolio', 'mfn-opts'),
				'std' => 'Back to list',
				'class' => 'small-text',
			),
			
		),
	);
	
	// Translate Contact --------------------------------------------
	$sections['translate-contact'] = array(
		'title' => __('Contact', 'mfn-opts'),
		'fields' => array(
	
			array(
				'id' => 'translate-contact-name',
				'type' => 'text',
				'title' => __('Your name', 'mfn-opts'),
				'desc' => __('Contact Form', 'mfn-opts'),
				'std' => 'Your name',
				'class' => 'small-text',
			),
	
			array(
				'id' => 'translate-contact-email',
				'type' => 'text',
				'title' => __('Your e-mail', 'mfn-opts'),
				'desc' => __('Contact Form', 'mfn-opts'),
				'std' => 'Your e-mail',
				'class' => 'small-text',
			),
	
			array(
				'id' => 'translate-contact-subject',
				'type' => 'text',
				'title' => __('Subject', 'mfn-opts'),
				'desc' => __('Contact Form', 'mfn-opts'),
				'std' => 'Subject',
				'class' => 'small-text',
			),
				
			array(
				'id' => 'translate-contact-submit',
				'type' => 'text',
				'title' => __('Send message', 'mfn-opts'),
				'desc' => __('Contact Form', 'mfn-opts'),
				'std' => 'Send message',
				'class' => 'small-text',
			),
				
			array(
				'id' => 'translate-contact-message-success',
				'type' => 'text',
				'title' => __('Success message', 'mfn-opts'),
				'desc' => __('Contact Form', 'mfn-opts'),
				'std' => 'Thanks, your email was sent.',
			),
				
			array(
				'id' => 'translate-contact-message-error',
				'type' => 'text',
				'title' => __('Error message', 'mfn-opts'),
				'desc' => __('Contact Form', 'mfn-opts'),
				'std' => 'Error sending email. Please try again later.',
			),
	
		),
	);
	
	// Translate Error 404 --------------------------------------------
	$sections['translate-404'] = array(
		'title' => __('Error 404', 'mfn-opts'),
		'fields' => array(
	
			array(
				'id' => 'translate-404-title',
				'type' => 'text',
				'title' => __('Title', 'mfn-opts'),
				'desc' => __('Ooops... Error 404', 'mfn-opts'),
				'std' => 'Ooops... Error 404',
			),
			
			array(
				'id' => 'translate-404-subtitle',
				'type' => 'text',
				'title' => __('Subtitle', 'mfn-opts'),
				'desc' => __('We`re sorry, but the page you are looking for doesn`t exist.', 'mfn-opts'),
				'std' => 'We`re sorry, but the page you are looking for doesn`t exist.',
			),
			
			array(
				'id' => 'translate-404-text',
				'type' => 'text',
				'title' => __('Text', 'mfn-opts'),
				'desc' => __('Please check entered address and try again or', 'mfn-opts'),
				'std' => 'Please check entered address and try again <em>or</em>',
			),
			
			array(
				'id' => 'translate-404-btn',
				'type' => 'text',
				'title' => __('Button', 'mfn-opts'),
				'sub_desc' => __('Go To Homepage button', 'mfn-opts'),
				'std' => 'go to homepage',
				'class' => 'small-text',
			),
	
		),
	);
								
	global $MFN_Options;
	$MFN_Options = new MFN_Options( $menu, $sections );
}
//add_action('init', 'mfn_opts_setup', 0);
mfn_opts_setup();


/**
 * This is used to return and option value from the options array
 */
function mfn_opts_get($opt_name, $default = null){
	global $MFN_Options;
	return $MFN_Options->get( $opt_name, $default );
}


/**
 * This is used to echo and option value from the options array
 */
function mfn_opts_show($opt_name, $default = null){
	global $MFN_Options;
	$option = $MFN_Options->get( $opt_name, $default );
	if( ! is_array( $option ) ){
		echo $option;
	}	
}

?>