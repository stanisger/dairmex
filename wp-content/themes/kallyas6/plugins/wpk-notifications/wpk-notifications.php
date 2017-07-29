<?php if(!defined('ABSPATH')) return; //#!-- Do not allow this file to be loaded unless in WP context
/*
	Plugin Name: WPK Notifications
	Description: Provides an easy way for theme & plugin developers to use admin notifications
	Version: 1.0.0
	Author: wp-kitten
	Author URI: http://wp-kitten.github.io/
	License: GPL v2
*/
/**
 * Class WpkNotifications
 *
 * General singleton
 *
 * @uses const THEMENAME
 */
class WpkNotifications
{
	private static $_instance = null;
	private function __construct(){}
	public static function getInstance(){
		if(is_null(self::$_instance) || !(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	/**
	 * Register hooks
	 */
	public function registerHooks(){
		//#!-- Custom hooks
		add_action('wpk_notice_error', array($this, 'showErrorNotification'), 10, 1);
		add_action('wpk_notice_success', array($this, 'showSuccessNotification'), 10, 1);
		add_action('wpk_dismissible_notice', array($this, 'showDismissibleNotice'), 10, 3);
	}

	public function showDismissibleNotice($class, $message='', $optionName=''){
		// Check option
		if(!empty($optionName) && $this->_canShowNotice($optionName)){ ?>
		<div class="<?php echo $class;?>" id="wpk-notification-wrapper">
			<p>
				<?php echo $message; ?>
				<span style="margin-left: 20px; color: #ff0000;">
					<a href="<?php echo rtrim($_SERVER['REQUEST_URI'], '&');?>&wpk_hide_notice=1"
                       id="wpk-dismiss-notice-link"
                       class="button button-small"><?php _e('Dismiss this notice.', THEMENAME);?></a>
				</span>
			</p>
		</div>
	<?php }
	}

	public function showErrorNotification($message=''){ ?>
		<div class="error">
			<p><?php echo $message; ?></p>
		</div>
	<?php
	}

	public function showSuccessNotification($message=''){ ?>
		<div class="updated" id="wpk-notification-wrapper">
			<p>
				<?php echo $message; ?>
			</p>
		</div>
	<?php }


	private function _canShowNotice($optionName='')
	{
		global $current_user;

		// uncomment to show the notice again
//		delete_user_meta($current_user->ID, $optionName);
		if(! is_admin()){
			return false;
		}
		if(empty($optionName)){
			return true;
		}
		if(! isset($current_user) || !is_object($current_user) || !isset($current_user->ID)){
			return true;
		}
		// Check REQUEST first
		if(isset($_REQUEST['wpk_hide_notice']) && intval($_REQUEST['wpk_hide_notice'])==1){
			$this->_addUserMeta($current_user->ID, $optionName, true);
			return false;
		}
		// Check user meta secondly
		$noticeStatus = get_user_meta($current_user->ID, $optionName, true);
		if(empty($noticeStatus)){
			return true;
		}
		return false;
	}
	private function _addUserMeta($userId, $optionName, $optionValue){
		if(empty($userId) || empty($optionName)){
			return false;
		}
		return add_user_meta($userId, $optionName, $optionValue);
	}
}
add_action('admin_init', array(WpkNotifications::getInstance(), 'registerHooks'));
