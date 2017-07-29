<?php 
/*  
	Plugin Name: Woocomerce favicon cart badge
	Plugin URI: http://www.sweethomes.es
	Description: Show woocomerce cart content in favicon badge 
	Version: 0.1 
	Author: Sweet Homes
	Author URI: http://www.sweethomes.es
	License: GPL2 
	
	Copyright 2013  Sweet Homes  (email : info@sweethomes.es)

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
	
	
	if ( !defined('ABSPATH') )
		define('ABSPATH', dirname(__FILE__) . '/');	

	function _no_woo_warning(){
        ?>
        <div class="message error"><p><?php printf(__('Woocomerce Favicon cart badge is enabled but not effective. It requires <a href="%s">WooCommerce</a> in order to work.', 'woocommerce-cart-badge'), 
            'http://www.woothemes.com/woocommerce/'); ?></p></div>
        <?php
    }


	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		add_action( 'init', 'wcb_admin_init' );
		add_action('admin_menu','wcb_admin_page_init');
		
		add_action('wp_enqueue_scripts', 'wcb_enqueue_scripts');
		add_action('admin_enqueue_scripts', 'wbc_admin_enqueue_scripts');
		add_action('admin_print_styles', 'wbc_admin_enqueue_styles');
		
		add_action('wp_footer', 'wcb_footer_script', 100);
		add_action('wp_head', 'wcb_header_icon');
	} else {
		add_action('admin_notices', '_no_woo_warning');
            return false;     
	}

	
	
	function wcb_admin_init() {
		$settings = get_option( "wcb_settings" );
		if ( empty( $settings ) ) {
			$settings = array(
								'wcb_favicon_image'		=> plugins_url('assets/img/favicon.png', __FILE__),
								'wcb_bgColor' 			=> '#d00',
								'wcb_textColor' 		=> '#fff',
								'wcb_fontFamily' 		=> 'sans-serif',
								'wcb_fontStyle' 		=> 'bold',
								'wcb_type' 				=> 'circle',
								'wcb_position' 			=> 'down',
								'wcb_animation' 		=> 'slide'
							);
			add_option( "wcb_settings", $settings, '', 'yes' );
		}	
	}

	
	function wcb_admin_page_init () {
		$settings_page = add_submenu_page( 'woocommerce', __( 'Cart badge settings', 'woocommerce-cart-badge' ),  __( 'Cart badge settings', 'woocommerce-cart-badge' ) , 'read', 'wcb_admin', 'wcb_settings_page');
	
		add_action( 'load-' . $settings_page, 'wcb_load_settings_page' );
	}
	
	
	function wcb_enqueue_scripts() {
		wp_enqueue_script('wcb_favicojs', plugins_url('assets/js/favico-0.3.3.min.js', __FILE__));
	}
	
	
	function wbc_admin_enqueue_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		/*wp_register_script('my-upload', WP_PLUGIN_URL.'/my-script.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('my-upload');*/
	}
	
	function wbc_admin_enqueue_styles() {
		wp_enqueue_style('thickbox');
	}
	
	    
	function wcb_header_icon(){
		$settings = get_option( "wcb_settings" );
		echo '<link rel="shortcut icon" href="'.$settings['wcb_favicon_image'].'" />';
		
	}
    
    
   	function wcb_footer_script(){
   		global $woocommerce;
   		
   		$my_cart_count = $woocommerce->cart->cart_contents_count;
   		
   		$settings = get_option( "wcb_settings" );
   		
   		$bgColor 	= $settings['wcb_bgColor'];
		$textColor 	= $settings['wcb_textColor'];
		$fontFamily = $settings['wcb_fontFamily'];
		$fontStyle 	= $settings['wcb_fontStyle'];
		$type 		= $settings['wcb_type'];
		$position 	= $settings['wcb_position'];
		$animation 	= $settings['wcb_animation'];
   		
   		if ($my_cart_count > 0):
	   		$inline_js = "<!-- WooCommerce cart badge JavaScript-->\n<script type=\"text/javascript\">\njQuery(document).ready(function($) {";
	   		$inline_js .= " \nvar favicon = new Favico({\n
	   			bgColor 	: '".$bgColor."',
	   			textColor	: '".$textColor."',
	   			fontFamily	: '".$fontFamily."',
	   			fontStyle	: '".$fontStyle."',
	   			type 		: '".$type."',
			    position	: '".$position."',
			    animation	: '".$animation."'
			});\n ";
			$inline_js .= 'favicon.badge('.$my_cart_count.');';
			$inline_js .="\n});\n</script>\n";
		else:
			$inline_js = '';
		endif;
   		
		echo $inline_js;
	}


	function wcb_load_settings_page() {
	
		if ( isset($_POST["wcb_settings-submit"]) == 'Y' ) {
			check_admin_referer( "wcb_settings_page" );
			wcb_save_settings();
			$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
			wp_redirect(admin_url('admin.php?page=wcb_admin&'.$url_parameters));
			exit;
		}
	}
	
	
	
	function wcb_admin_tabs( $current = 'settings' ) { 
	    $tabs = array( 'settings' => 'Settings', 'about' => 'About' ); 
	    $links = array();
	    echo '<div id="options-general" class="icon32"><br></div>';
	    echo '<h2 class="nav-tab-wrapper">';
		    foreach( $tabs as $tab => $name ){
		        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
		        echo "<a class='nav-tab$class' href='?page=wcb_admin&tab=$tab'>$name</a>";
		    }
	    echo '</h2>';
	}
	
	
	function wcb_save_settings() {
		global $pagenow;
		$settings = get_option( "wcb_settings" );
		
		if ( $pagenow == 'admin.php' && $_GET['page'] == 'wcb_admin' ){ 
			if ( isset ( $_GET['tab'] ) )
		        $tab = $_GET['tab']; 
		    else
		        $tab = 'settings'; 
	
		    switch ( $tab ){ 
		    	case 'settings' : 
		    		$settings["wcb_favicon_image"] 	= $_POST['wcb_favicon_image'];
		    		$settings["wcb_bgColor"] 		= $_POST["wcb_bgColor"];
					$settings["wcb_textColor"] 		= $_POST["wcb_textColor"];
					$settings["wcb_fontFamily"] 	= $_POST["wcb_fontFamily"];
					$settings["wcb_fontStyle"] 		= $_POST["wcb_fontStyle"];
					$settings["wcb_type"] 			= $_POST["wcb_type"];
					$settings["wcb_position"]		= $_POST["wcb_position"];
					$settings["wcb_animation"]		= $_POST["wcb_animation"];
		    	
				break;
		    }
		}
		
		$updated = update_option( "wcb_settings", $settings );
	}
	
	
	
	function wcb_settings_page() {
		global $pagenow;
		$settings = get_option( "wcb_settings" );
		?>
		
		<div class="wrap">
			<h2>Woocommerce cart badge Settings</h2>
			
			<?php
				if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>'.__('Settings Options updated', 'woocommerce-cart-badge').'.</p></div>';
				
				if ( isset ( $_GET['tab'] ) ) wcb_admin_tabs($_GET['tab']); else wcb_admin_tabs('settings');
			?>
	
			<div id="poststuff">
					<?php
					
					if ( $pagenow == 'admin.php' && $_GET['page'] == 'wcb_admin' ){ 
					
						if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
						else $tab = 'settings'; 
						
						echo '<table class="form-table">';
						switch ( $tab ){
							case 'settings' : 
							/*
								Attribute	Default	
								
								bgColor		#d00			Badge background color
								textColor	#fff			Badge text color
								fontFamily	sans-serif		Text font family (Arial, Verdana, Times New Roman, serif, sans-serif,...)
								fontStyle	bold			Font style (normal, italic, oblique, bold, bolder, lighter, 100, 200, 300, 400, 500, 600, 700, 800, 900)
								type		circle			Badge shape (circle, rectangle)
								position	down			Badge position (up, down)
								animation	slide			Badge animation type (slide, fade, pop, popFade, none )
								elementId	false			Image element ID if there is need to attach badge to regular image*/
								
								?>
								
								<form method="post" action="<?php admin_url( 'admin.php?page=wcb_admin' ); ?>">
									<?php wp_nonce_field( "wcb_settings_page" ); ?>
									
									<tr valign="top">
										<th scope="row">Upload Custom Favicon</th>
										<td><label for="wcb_favicon_image">
												<input id="wcb_favicon_image" type="text" size="36" name="wcb_favicon_image" value="<?php echo esc_html( stripslashes( $settings["wcb_favicon_image"] ) ); ?>" />
												<input id="upload_image_button" type="button" value="Upload Image" class="button-secondary" />
												<br />Enter an URL or upload an image for the favicon.
											</label>
										</td>
									</tr>
									
									<tr>
										<th><label for="wcb_bgColor"><?php _e('Background Color', 'woocommerce-cart-badge') ?></label></th>
										<td>
											<input id="wcb_bgColor" name="wcb_bgColor" type="text" value="<?php echo esc_html( stripslashes( $settings["wcb_bgColor"] ) ); ?>"><br/>
											<span class="description"><?php echo __('default value is #d00 ', 'woocommerce-cart-badge') ?></span>
										</td>
									</tr>
									
									<tr>
										<th><label for="wcb_textColor"><?php _e('Text Color', 'woocommerce-cart-badge') ?></label></th>
										<td>
											<input id="wcb_textColor" name="wcb_textColor" type="text" value="<?php echo esc_html( stripslashes( $settings["wcb_textColor"] ) ); ?>"><br/>
											<span class="description"><?php echo __('default value is #fff ', 'woocommerce-cart-badge') ?></span>
										</td>
									</tr>
									
									<tr>
										<th><label for="wcb_fontFamily"><?php _e('Font Family', 'woocommerce-cart-badge') ?></label></th>
										<td>
											<input id="wcb_fontFamily" name="wcb_fontFamily" type="text" value="<?php echo esc_html( stripslashes( $settings["wcb_fontFamily"] ) ); ?>"><br/>
											<span class="description"><?php echo __('Arial, Verdana, Times New Roman, serif, sans-serif,... ', 'woocommerce-cart-badge') ?></span>
										</td>
									</tr>
									
									<tr>
										<th><label for="wcb_fontStyle"><?php _e('Text Color', 'woocommerce-cart-badge') ?></label></th>
										<td>
											<input id="wcb_fontStyle" name="wcb_fontStyle" type="text" value="<?php echo esc_html( stripslashes( $settings["wcb_fontStyle"] ) ); ?>"><br/>
											<span class="description"><?php echo __('normal, italic, oblique, bold, bolder, lighter, 100, 200, 300, 400, 500, 600, 700, 800, 900 ', 'woocommerce-cart-badge') ?></span>
										</td>
									</tr>
									
									<tr>
										<th><label for="wcb_type"><?php _e('Shape type', 'woocommerce-cart-badge') ?></label></th>
										<td>
											
											<select name="wcb_type">
												<option value="circle" <?php selected(esc_html( stripslashes( $settings["wcb_type"] ) ), 'circle') ?>><?php _e('Circle', ''); ?></option>
												<option value="rectangle" <?php selected(esc_html( stripslashes( $settings["wcb_type"] ) ), 'rectangle') ?>><?php _e('Rectangle', ''); ?></option>
											</select>
											<span class="description"><?php echo __('default value is "circle" ', 'woocommerce-cart-badge') ?></span>
										</td>
									</tr>
									<tr>
										<th><label for="wcb_position"><?php _e('Badge position', 'woocommerce-cart-badge') ?></label></th>
										<td>
											
											<select name="wcb_position">
												<option value="down" <?php selected(esc_html( stripslashes( $settings["wcb_position"] ) ), 'down') ?>><?php _e('Down', 'woocommerce-cart-badge'); ?></option>
												<option value="up" <?php selected(esc_html( stripslashes( $settings["wcb_position"] ) ), 'up') ?>><?php _e('Up', 'woocommerce-cart-badge'); ?></option>
											</select>
											<span class="description"><?php echo __('default value is "down" ', 'woocommerce-cart-badge') ?></span>
										</td>
									</tr>
									<tr>
										<th><label for="wcb_animation"><?php _e('Badge position', 'woocommerce-cart-badge') ?></label></th>
										<td>
											
											<select name="wcb_animation">
												<option value="slide" <?php selected(esc_html( stripslashes( $settings["wcb_animation"] ) ), 'slide') ?>><?php _e('Slide', 'woocommerce-cart-badge'); ?></option>
												<option value="fade" <?php selected(esc_html( stripslashes( $settings["wcb_animation"] ) ), 'fade') ?>><?php _e('Fade', 'woocommerce-cart-badge'); ?></option>
												<option value="pop" <?php selected(esc_html( stripslashes( $settings["wcb_animation"] ) ), 'pop') ?>><?php _e('Pop', 'woocommerce-cart-badge'); ?></option>
												<option value="popFade" <?php selected(esc_html( stripslashes( $settings["wcb_animation"] ) ), 'popFade') ?>><?php _e('PopFade', 'woocommerce-cart-badge'); ?></option>
												<option value="none" <?php selected(esc_html( stripslashes( $settings["wcb_animation"] ) ), 'none') ?>><?php _e('None', 'woocommerce-cart-badge'); ?></option>
											</select>
											<span class="description"><?php echo __('default value is "Slide" ', 'woocommerce-cart-badge') ?></span>
										</td>
									</tr>
									
									<tr>
										<td colspan="2">
											<p class="submit" style="">
												<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
												<input type="hidden" name="wcb_settings-submit" value="Y" />
											</p>
										</td>
									</tr>
								</form>
								<script>
									jQuery(document).ready(function() {
 
										jQuery('#upload_image_button').click(function() {
										 	formfield = jQuery('#upload_image').attr('name');
										 	tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
										 	return false;
										});
									 
										window.send_to_editor = function(html) {
											 imgurl = jQuery('img',html).attr('src');
											 jQuery('#wcb_favicon_image').val(imgurl);
											 tb_remove();
										}
									 
									});
								</script>
								<?php
							break;
							case 'about' :
								?>
								<tr>
									<th>About the Plugin Author</th>
									<td><a href="http://www.sweethomes.es" target="_blank">Sweet Homes</a> is a study of online communication based in Barcelona. We have extensive experience developing projects in wordpress and other CMS's </td>
								</tr>
								<?php
							break; 

							
						}
						
						?>
							<tr>
								<td colspan="2"><hr></td>
							</tr>
							<tr>
								<td colspan="2" align="left"><a href="http://www.sweethomes.es" style="text-decoration:none;"><?php echo '<img src="'. plugins_url('assets/img/sweethomes.png', __FILE__).'" alt="Sweet Homes">'; ?> <span style="color: rgb(0, 0, 0); font: bold 14px/20px Arial,sans-serif; vertical-align: top;">Sweet Homes</span></a></td>
							</tr>
						<?php
						echo '</table>';
					}
					?>
			</div>
	
		</div>
	<?php
	}
?>