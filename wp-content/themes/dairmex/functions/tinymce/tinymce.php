<?php
define('PLUGIN_NAME', 'mfn_mce');
define('PLUGIN_URI', LIBS_URI .'/tinymce/');

function mfn_mce_version( $version ) 
{
	return $version + 100;
}	
add_filter('tiny_mce_version', 'mfn_mce_version' );

function mfn_mce_init() 
{
	global $page_handle;
	if ( ! current_user_can('edit_posts') || ! current_user_can('edit_pages') )  return;
	
	if ( get_user_option('rich_editing') == 'true') 
	{
		add_filter("mce_external_plugins", 'mfn_mce_plugin' );
		add_filter('mce_buttons', 'mfn_mce_buttons' );
		add_filter('mce_external_languages', 'mfn_mce_languages');
	}
}
add_action( 'init', 'mfn_mce_init' );

function mfn_mce_plugin( $array ) 
{
	$path = LIBS_URI .'/tinymce/'; 	
	$array['mfn_mce'] =  PLUGIN_URI .'plugin.js';
	return $array;
}

function mfn_mce_buttons( $buttons ) 
{
	array_push($buttons, 'separator', 'mfn_mce' );
	return $buttons;
}

function mfn_mce_languages( $array ) 
{	
	$array['mfn_mce'] = PLUGIN_URI .'/langs.php';
	return $array;
}
?>