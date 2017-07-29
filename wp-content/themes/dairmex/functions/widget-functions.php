<?php
/**
 * Theme widgets and sidebars.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Delete unuseful widgets
 * --------------------------------------------------------------------------- */
function mfn_unregister_widget()
{
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_Recent_Posts');
}
add_action('widgets_init', 'mfn_unregister_widget');


/* ---------------------------------------------------------------------------
 * New widgets
 * --------------------------------------------------------------------------- */
function mfn_register_widget()
{
	register_widget('Mfn_Call_To_Action_Widget');
	register_widget('Mfn_Contact_Box_Widget');
	register_widget('Mfn_Flickr_Widget');
	register_widget('Mfn_Menu_Widget');
	register_widget('Mfn_Recent_Comments_Widget');
	register_widget('Mfn_Recent_Posts_Widget');
	register_widget('Mfn_Tag_Cloud_Widget');
	register_widget('Mfn_Twitter_Widget');
}
add_action('widgets_init','mfn_register_widget');


/* ---------------------------------------------------------------------------
 * Add custom sidebars
 * --------------------------------------------------------------------------- */
function mfn_register_sidebars() {
	
	// footer areas ----------------------------------------------------------
	for ($i = 1; $i <= 4; $i++)
	{
		register_sidebar(array(
			'name' => __('Footer area','mfn-opts') .' #'.$i,
			'id' => 'footer-area-'.$i,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		));
	}
	
	// custom sidebars -------------------------------------------------------
	$sidebars = mfn_opts_get( 'sidebars' );
	if(is_array($sidebars))
	{
		foreach ($sidebars as $sidebar)
		{	
			register_sidebar( array (
				'name' => $sidebar,
				'id' => 'sidebar-'. str_replace("+", "-", urlencode(strtolower($sidebar))) ,
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
		}	
	}

}
add_action( 'widgets_init', 'mfn_register_sidebars' );

?>