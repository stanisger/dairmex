<?php
  /*
   Plugin Name: Carousel of Post images
   Plugin URI: http://chateau-logic.com/content/wordpress-plugin-carousel-post-images
   Description: Provide shortcode to allow display of carousels containing a selection of images from posts.
   Version: 1.07
   Author: Richard Harrison
   Author URI: http://chateau-logic.com/
  */

  /*  Copyright 2011 Richard Harrison (email : rjh@zaretto.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  */

function copi_init() {
    if(get_option('copi_carousel_skin') == ''){
        add_option('copi_carousel_skin', 'tango');
    }
    define('POSTGALLERY_FOLDER', plugin_basename( dirname(__FILE__)) );
    define('POSTGALLERY_URL', get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__)));	
    $skin = get_option('copi_carousel_skin');

	if (!is_admin()) {
        wp_enqueue_style('jcarousel2', POSTGALLERY_URL .'/js/jcarousel/lib/jquery.jcarousel.css', false, '0.2.8', 'screen'); 
        wp_enqueue_style('jquery-plugins-jcarousel-skin-'.$skin.'-css', POSTGALLERY_URL .'/js/jcarousel/skins/'.$skin.'/skin.css"', false, '0.2.8', 'screen'); 
        wp_register_script('jcarousel', POSTGALLERY_URL .'/js/jcarousel/lib/jquery.jcarousel.pack.js', false ,'0.2.8');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jcarousel');
	}
}

function admin_init_copi() {
    register_setting('copi', 'copi_skin');
}

function admin_menu_copi() {
    add_options_page('Carousel of post images', 'Carousel of post images', 8, 'copi', 'options_page_copi');
}

function options_page_copi() {
    include(dirname(__FILE__).'/options.php');  
}

function copi_carousel($div,$args,$skin='tango'){
    echo '<script type="text/javascript">jQuery(document).ready(function() {jQuery(\'#'.$div.'\').jcarousel('.json_encode($args).');});</script>';
}


function copi_carousel_get_images($size = 'medium' , $orderby, $posts, $count, $class = ''){
    global $post;

    $att_array = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'orderby' => $orderby, 
        'numberposts' => $count,
        );

    $postlist = explode(",",$posts);
    $sizes = explode(",", $size);
    $html = '';
    if (count($sizes) == 2)
    {
        $width = $sizes[0];
        $height = $sizes[1];
        $size=$sizes;
    }
    else
    {
        $width = get_option($size.'_size_w');
        $height = get_option($size.'_size_h');
    }
    foreach($postlist as $postid)
    {
        if ($postid != '')
            $att_array['post_parent'] = $postid;

        $attachments = get_posts($att_array);

        if (is_array($attachments)){
            foreach($attachments as $att){
                $image_src_array = wp_get_attachment_image_src($att->ID, $size);
                $url = $image_src_array[0];
                if ($url != "")
                {

                    $prefix = '<li><a href="'.get_permalink($att->post_parent).'">';
                    $suffix = "</a></li>";

                    $caption = $att->post_excerpt;

                    if(function_exists('thumbGen'))
                        $url = thumbGen($url, $width, $height, 'return=1');

                    $image_html = '<img src="%s" height="'.$height.'" alt="%s">';

                    $html .= $prefix.sprintf($image_html,$url,$caption,$class).$suffix;
                }
            }
        }
    }
    return  $html;

}

function show_wp_copi_carousel($atts){
    $skin = 'tango';
    $div='post-carousel';
    $imagesize = 'medium';
    $orderby = 'rand';
    $postid = '';
    $count='10';

    if (isset($atts['skin'])) 
        $skin = $atts['skin'];

    if (isset($atts['imagesize'])) 
        $imagesize = $atts['imagesize'];

    if (isset($atts['orderby'])) 
        $orderby = $atts['orderby'];

    if (isset($atts['postid'])) 
        $postid = $atts['postid'];

    if (isset($atts['count'])) 
    {
        $count = $atts['count'];
        // 
        // size as an argument makes sense in the jcarousel - but is confusing from the WP
        // perspective - so translate count into size. If omitted will default to 10. This must always be
        // known and set - as we could have thousands of images in an install.
        // however we will leave the attributes blank and let the carousel count them again.
        unset($atts['size']);
        unset($atts['count']);
    }

    if (isset($atts['div'])) 
        $div = $atts['div'];

    if ($imagesize == 'small') $imagesize = 'thumbnail';

    $txt = '<ul class="jcarousel-skin-tango" id="'.$div.'" >'.copi_carousel_get_images($imagesize,$orderby,$postid, $count).'</ul>';
    return $txt.copi_carousel($div,$atts,$skin);
}

add_action('init', 'copi_init');

if (is_admin()) {
    add_action('admin_init', 'admin_init_copi');
    add_action('admin_menu', 'admin_menu_copi');
}

add_shortcode( 'carousel-of-post-images', 'show_wp_copi_carousel' );

?>
