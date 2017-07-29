<?php
/**
 * class ZnDebug
 *
 * This class provides a simple way of debugging issues that might appear on clients' websites by collecting information
 * about the current theme and plugins(installed && active), some server information might be required such as the OS,
 * server name and PHP info. All this information can be generated in the the theme options page.
 *
 * @final
 *
 * @static
 *
 * @since v3.6.5
 *
 * @wpk
 */
final class ZnDebug
{
    /**
     * Holds the name of the option storing a cache copy of this information
     *
     * @type string
     */
    const OPTION_NAME = 'kzn_debug_info';


    /**
     * Collect all information needed for debugging
     *
     * @return array
     */
    public static function collectInfo()
    {
        return array(
            'phpInfo' => self::collectPhpInfo(),
            'serverInfo' => self::collectServerInfo(),
            'themeInfo' => self::collectThemeInfo(),
            'installedPlugins' => self::collectInstalledPlugins(),
        );
    }

    /**
     * Retrieve information about the PHP modules installed
     *
     * @return array
     */
    public static function collectPhpInfo(){
        $ext = get_loaded_extensions();
        $extensions = array();
        if(! empty($ext)){
            foreach($ext as $extension){
                $extensions[$extension] = 'v'.phpversion($extension);
            }
        }
        return array(
            'version' => phpversion(),
            'extensions' => $extensions
        );
    }

    /**
     * Retrieve various information about the server
     *
     * @return array
     */
    public static function collectServerInfo(){
        return array(
            'OS' => (defined(PHP_OS) ? PHP_OS : 'unknown'),
            'HTTP_HOST' => (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'unknown'),
            'HTTP_CACHE_CONTROL' => (isset($_SERVER['HTTP_CACHE_CONTROL']) ? $_SERVER['HTTP_CACHE_CONTROL'] : 'unknown'),
            'SERVER_SIGNATURE' => (isset($_SERVER['SERVER_SIGNATURE']) ? $_SERVER['SERVER_SIGNATURE'] : 'unknown'),
            'SERVER_SOFTWARE' => (isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'unknown'),
            'SERVER_NAME' => (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'unknown'),
            'SERVER_PROTOCOL' => (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'unknown'),
            'PHP_SAPI' => (defined(PHP_SAPI) ? PHP_SAPI : 'unknown'),
        );
    }

    /**
     * Collect information about the current theme
     *
     * @return array
     */
    public static function collectThemeInfo(){
        $info = wp_get_theme();
        return array(
            'version' => THEME_VERSION,
            'stylesheet'    => (isset($info['stylesheet']) ? $info['stylesheet'] : 'Not Set'),
            'template'    => (isset($info['template']) ? $info['template'] : 'Not Set'),
            'parent'    => (isset($info['parent']) ? $info['parent'] : 'Not Set'),
        );
    }

    /**
     * Collect information about the installed plugins
     *
     * @return array
     */
    public static function collectInstalledPlugins(){
        $tmp = array();
        if( ! is_admin()){
            return $tmp;
        }
        $plugins = get_plugins();
        if(empty($plugins)){
            return $tmp;
        }
        foreach($plugins as $path => $info){
            if(! isset($info['Name']) || !isset($info['Version'])){
                // invalid plugin
                continue;
            }
            $tmp[$info['Name']] = array(
                'version' => $info['Version'],
                'active'  => 'no',
            );
            if(is_plugin_active($path)){
                $tmp[$info['Name']]['active'] = 'yes';
            }
        }
        return $tmp;
    }

    /**
     * Provides a simple way of logging errors in the WP_CONTENT_DIR/debug.log file
     *
     * @param string $message Information regarding $data
     *
     * @param mixed $data Data to be inspected in the error log file
     */
    public static function log($message, $data = null)
    {
        if(! defined('WP_DEBUG') || !WP_DEBUG){
            ini_set('error_log', WP_CONTENT_DIR.'/debug.log');
        }
        if(! empty($data)){
            if(is_object($data) || is_array($data)){
                $message .= ' DATA: '.var_export($data, 1);
            }
			else {
				$message .= ' DATA: '.$data;
			}
        }
        error_log($message);
    }

//<editor-fold desc = "AJAX">
    /**
     * Only POST AJAX requests allowed
     *
     * @see:  admin/zn-init.php
     * @see:  admin/js/get-debug-info.js
     *
     * @return array
     */
    public static function ajax_collect_info()
    {
        $rm = strtoupper($_SERVER['REQUEST_METHOD']);
        if('POST' != $rm) {
            wp_die(__('Invalid Request [1]', THEMENAME));
        }
        if(! isset($_POST['dbg_nonce']) || empty($_POST['dbg_nonce'])){
            wp_die(__('Invalid Request [2]', THEMENAME));
        }
        if(! isset($_POST['dbg_type']) || empty($_POST['dbg_type']) || ($_POST['dbg_type'] != 'get_debug_info')){
            wp_die(__('Invalid Request [3]', THEMENAME));
        }
        if(! wp_verify_nonce($_POST['dbg_nonce'],'zn_ajax_nonce')){
            wp_die(__('Invalid Request [4]', THEMENAME));
        }

        $t = serialize(self::collectInfo());

        update_option(self::OPTION_NAME, $t);

        echo $t;
        wp_die();
    }

    public static function enqueueAjaxScript()
    {
        wp_register_script( 'zn-debug-ajax-js', get_template_directory_uri() . '/admin/js/get-debug-info.js', array( 'jquery' ), '', true );
        wp_localize_script( 'zn-debug-ajax-js', 'ZnDebugInfo', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php'),
            'ajaxAction' => 'ajax_collect_info',
            'nonceMissing' => __('The form is not valid. nonce field is missing.', THEMENAME),
            'failMessage'  => __('An error occurred while retrieving the debug information.', THEMENAME),
        ) );
        wp_enqueue_script( 'zn-debug-ajax-js' );
    }
//</editor-fold desc = "AJAX">

//<editor-fold desc = "PRIVATE">
    private function __construct(){}
    private function __clone(){}
//</editor-fold desc = "PRIVATE">
}

