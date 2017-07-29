<?php
/**
 * Plugin Name: M Retina Gravatars
 * Description: Show retina avatars
 * Version: 1.1.1
 * Author: Georgi Popov a.k.a. Magadanski_Uchen
 * Author URI: http://magadanski.com/
 * License: GPLv2
 */

add_action('plugins_loaded', 'mrg_plugins_loaded');

function mrg_plugins_loaded() {
	add_filter('get_avatar', 'mrg_get_avatar', 10, 5);
}

function mrg_get_avatar($avatar, $id_or_email, $size, $default, $alt) {
	$retina_size = absint($size) * 2;
	
	$size_argument = '?s=' . $size;
	$size_retina_argument = '?s=' . $retina_size;
	
	// replace size for avatar
	$avatar = preg_replace('/' . preg_quote($size_argument) . '/', $size_retina_argument, $avatar);
	// replace size for default avatar
	$avatar = preg_replace('/' . preg_quote(urlencode($size_argument)) . '/', urlencode($size_retina_argument), $avatar);
	
	return $avatar;
}

?>