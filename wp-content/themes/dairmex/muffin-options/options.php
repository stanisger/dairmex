<?php
if ( ! class_exists('MFN_Options') ){
	
	if(!defined('MFN_OPTIONS_DIR')){
		define('MFN_OPTIONS_DIR', trailingslashit(dirname(__FILE__)));
	}

	if(!defined('MFN_OPTIONS_URI'))
	{
//		define('MFN_OPTIONS_URI', site_url(str_replace(ABSPATH, '', trailingslashit(dirname(__FILE__)))));
		define('MFN_OPTIONS_URI', THEME_URI ."/muffin-options/");	
	}
	
	
	class MFN_Options{
					
		public $dir = MFN_OPTIONS_DIR;
		public $url = MFN_OPTIONS_URI;
		public $page = '';
		public $args = array();
		public $sections = array();
		public $extra_tabs = array();
		public $errors = array();
		public $warnings = array();
		public $options = array();
		
		public $menu = array();
		
		
		/**
		 * Class Constructor. Defines the args for the theme options class
		*/
		function __construct( $menu = array(), $sections = array() ){
			
			$this->menu = apply_filters('mfn-opts-menu', $menu);
			
			$defaults = array();
			
			$defaults['opt_name'] = 'tisson';
			
			$defaults['menu_icon'] = MFN_OPTIONS_URI.'/img/menu_icon.png';
			$defaults['menu_title'] = __('Theme Options - Tisson', 'mfn-opts');
			$defaults['page_icon'] = 'icon-themes';
			$defaults['page_title'] = __('Tisson Theme Options', 'mfn-opts');
			$defaults['page_slug'] = 'muffin_options';
			$defaults['page_cap'] = 'manage_options';
			$defaults['page_type'] = 'menu';
			$defaults['page_parent'] = '';
			$defaults['page_position'] = 100;
			
			$defaults['show_import_export'] = true;
			$defaults['dev_mode'] = true;
			$defaults['stylesheet_override'] = false;
						
			$defaults['help_tabs'] = array();
			$defaults['help_sidebar'] = '';
			
			//get args
			$this->args = $defaults;
			$this->args = apply_filters('mfn-opts-args', $this->args);
			$this->args = apply_filters('mfn-opts-args-'.$this->args['opt_name'], $this->args);
			
			//get sections
			$this->sections = apply_filters('mfn-opts-sections', $sections);
			$this->sections = apply_filters('mfn-opts-sections-'.$this->args['opt_name'], $this->sections);
			
			//set option with defaults
			add_action('init', array(&$this, '_set_default_options'));
			
			//options page
			add_action('admin_menu', array(&$this, '_options_page'));
			
			//register setting
			add_action('admin_init', array(&$this, '_register_setting'));
			
			//add the js for the error handling before the form
			add_action('mfn-opts-page-before-form', array(&$this, '_errors_js'), 1);
			
			//add the js for the warning handling before the form
			add_action('mfn-opts-page-before-form', array(&$this, '_warnings_js'), 2);
			
			//hook into the wp feeds for downloading the exported settings
			add_action('do_feed_mfn-opts', array(&$this, '_download_options'), 1, 1);
			
			//get the options for use later on
			$this->options = get_option($this->args['opt_name']);

		}
		
		
		/**
		 * This is used to return and option value from the options array
		*/
		function get($opt_name, $default = null){
			
			if( ( ! is_array($this->options) ) || ( ! key_exists($opt_name, $this->options) ) ) return $default;
			
			return ( ( ! empty($this->options[$opt_name])) || ($this->options[$opt_name]==='0') ) ? $this->options[$opt_name] : $default;
//			return (!empty($this->options[$opt_name])) ? $this->options[$opt_name] : $default;

		}
		
		
		/**
		 * This is used to set an arbitrary option in the options array
		 */
		function set($opt_name, $value) {
			$this->options[$opt_name] = $value;
			update_option($this->args['opt_name'], $this->options);
		}
		
		
		/**
		 * This is used to echo and option value from the options array
		*/
		function show($opt_name, $default = null){
			$option = $this->get($opt_name, $default);
			if(!is_array($option)){
				echo $option;
			}
		}
		

		/**
		 * Get default options into an array suitable for the settings API
		*/
		function _default_values(){		
			$defaults = array();
			
			foreach($this->sections as $k => $section){
				
				if(isset($section['fields'])){
					
					foreach($section['fields'] as $fieldk => $field){	
						if(!isset($field['std'])){
							$field['std'] = '';
						}
						$defaults[$field['id']] = $field['std'];
					}
					
				}
				
			}

			$defaults['last_tab'] = 0;
			return $defaults;
		}
		

		/**
		 * Set default options on admin_init if option doesnt exist (theme activation hook caused problems, so admin_init it is)
		*/
		function _set_default_options(){
			if(!get_option($this->args['opt_name'])){
				add_option($this->args['opt_name'], $this->_default_values());
			}
			$this->options = get_option($this->args['opt_name']);
		}
		
		
		/**
		 * Class Theme Options Page Function, creates main options page.
		*/
		function _options_page(){
			
			$this->page = add_theme_page(
				$this->args['page_title'], 
				$this->args['menu_title'], 
				$this->args['page_cap'], 
				$this->args['page_slug'], 
				array(&$this, '_options_page_html')
			);
			
			add_action('admin_print_styles-'.$this->page, array(&$this, '_enqueue'));
		}	
		
	
		/**
		 * enqueue styles/js for theme page
		*/
		function _enqueue(){
			
			wp_register_style( 'mfn-opts-css', $this->url.'css/options.css', array('farbtastic'), time(), 'all');	
			wp_register_style( 'mfn-opts-jquery-ui-css', apply_filters('mfn-opts-ui-theme', $this->url.'css/jquery-ui-aristo/aristo.css'), '', time(), 'all' );
			
			wp_enqueue_style( 'mfn-opts-css' );
			wp_enqueue_script( 'mfn-opts-js', $this->url.'js/options.js', array('jquery'), time(), true );
			
			do_action('mfn-opts-enqueue');
			do_action('mfn-opts-enqueue-'.$this->args['opt_name']);
			
			foreach($this->sections as $k => $section){
				
				if(isset($section['fields'])){
					
					foreach($section['fields'] as $fieldk => $field){
						
						if(isset($field['type'])){
						
							$field_class = 'MFN_Options_'.$field['type'];
							
							if(!class_exists($field_class)){
								require_once($this->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php');
							}
					
							if(class_exists($field_class) && method_exists($field_class, 'enqueue')){
								$enqueue = new $field_class('','',$this);
								$enqueue->enqueue();
							}
							
						}
						
					}
				
				}
				
			}
				
		}
		
		
		/**
		 * Download the options file, or display it
		*/
		function _download_options(){
			if(!isset($_GET['secret']) || $_GET['secret'] != md5(AUTH_KEY.SECURE_AUTH_KEY)){wp_die('Invalid Secret for options use');exit;}
			if(!isset($_GET['option'])){wp_die('No Option Defined');exit;}
			$backup_options = get_option($_GET['option']);
			$backup_options['mfn-opts-backup'] = '1';
			$content = '###'.serialize($backup_options).'###';
			
			
			if(isset($_GET['action']) && $_GET['action'] == 'download_options'){
				header('Content-Description: File Transfer');
				header('Content-type: application/txt');
				header('Content-Disposition: attachment; filename="'.$_GET['option'].'_options_'.date('d-m-Y').'.txt"');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				echo $content;
				exit;
			}else{
				echo $content;
				exit;
			}
		}
			
				
		/**
		 * Register Option for use
		*/
		function _register_setting(){
			
			register_setting($this->args['opt_name'].'_group', $this->args['opt_name'], array(&$this,'_validate_options'));
			
			foreach($this->sections as $k => $section){
				
				add_settings_section($k.'_section', $section['title'], array(&$this, '_section_desc'), $k.'_section_group');
				
				if(isset($section['fields'])){
				
					foreach($section['fields'] as $fieldk => $field){
						
						if(isset($field['title'])){
						
							$th = (isset($field['sub_desc']))?$field['title'].'<span class="description">'.$field['sub_desc'].'</span>':$field['title'];
						}else{
							$th = '';
						}
						
						add_settings_field($fieldk.'_field', $th, array(&$this,'_field_input'), $k.'_section_group', $k.'_section', $field); // checkbox
						
					}
				
				}
				
			}
			
			do_action('mfn-opts-register-settings');
			do_action('mfn-opts-register-settings-'.$this->args['opt_name']);
			
		}
		
		
		/**
		 * Validate the Options options before insertion
		*/
		function _validate_options($plugin_options){
			
			set_transient('mfn-opts-saved', '1', 1000 );
			
			if(!empty($plugin_options['import'])){
				
				if($plugin_options['import_code'] != ''){
					$import = $plugin_options['import_code'];
				}elseif($plugin_options['import_link'] != ''){
					$import = wp_remote_retrieve_body( wp_remote_get($plugin_options['import_link']) );
				}
				
				$imported_options = unserialize(trim($import,'###'));
				if(is_array($imported_options) && isset($imported_options['mfn-opts-backup']) && $imported_options['mfn-opts-backup'] == '1'){
					$imported_options['imported'] = 1;
					return $imported_options;
				}
			}
			
			if(!empty($plugin_options['defaults'])){
				$plugin_options = $this->_default_values();
				return $plugin_options;
			}//if set defaults
		
			//validate fields (if needed)
			$plugin_options = $this->_validate_values($plugin_options, $this->options);
			
			if($this->errors){
				set_transient('mfn-opts-errors', $this->errors, 1000 );		
			}//if errors
			
			if($this->warnings){
				set_transient('mfn-opts-warnings', $this->warnings, 1000 );		
			}//if errors
			
			do_action('mfn-opts-options-validate', $plugin_options, $this->options);
			
			do_action('mfn-opts-options-validate-'.$this->args['opt_name'], $plugin_options, $this->options);
			
			unset($plugin_options['defaults']);
			unset($plugin_options['import']);
			unset($plugin_options['import_code']);
			unset($plugin_options['import_link']);
			
			return $plugin_options;	
		
		}
		

		/**
		 * Validate values from options form (used in settings api validate function)
		 * calls the custom validation class for the field so authors can override with custom classes
		*/
		function _validate_values($plugin_options, $options){
			foreach($this->sections as $k => $section){
				
				if(isset($section['fields'])){
				
					foreach($section['fields'] as $fieldk => $field){
						$field['section_id'] = $k;
						
						if(isset($field['type']) && $field['type'] == 'multi_text'){continue;}//we cant validate this yet
						
						if(!isset($plugin_options[$field['id']]) || $plugin_options[$field['id']] == ''){
							continue;
						}
						
						//force validate of custom filed types
						
						if(isset($field['type']) && !isset($field['validate'])){
							if($field['type'] == 'color' || $field['type'] == 'color_gradient'){
								$field['validate'] = 'color';
							}elseif($field['type'] == 'date'){
								$field['validate'] = 'date';
							}
						}//if
		
						if(isset($field['validate'])){
							$validate = 'MFN_Validation_'.$field['validate'];
							
							if(!class_exists($validate)){
								require_once($this->dir.'validation/'.$field['validate'].'/validation_'.$field['validate'].'.php');
							}//if
							
							if(class_exists($validate)){
								$validation = new $validate($field, $plugin_options[$field['id']], $options[$field['id']]);
								$plugin_options[$field['id']] = $validation->value;
								if(isset($validation->error)){
									$this->errors[] = $validation->error;
								}
								if(isset($validation->warning)){
									$this->warnings[] = $validation->warning;
								}
								continue;
							}
						}
						
						if(isset($field['validate_callback']) && function_exists($field['validate_callback'])){
							
							$callbackvalues = call_user_func($field['validate_callback'], $field, $plugin_options[$field['id']], $options[$field['id']]);
							$plugin_options[$field['id']] = $callbackvalues['value'];
							
							if(isset($callbackvalues['error'])){
								$this->errors[] = $callbackvalues['error'];
							}
							
							if(isset($callbackvalues['warning'])){
								$this->warnings[] = $callbackvalues['warning'];
							}
							
						}
						
						
					}
				
				}
				
			}
			return $plugin_options;
		}
		
		
		/**
		 * HTML OUTPUT.
		*/
		function _options_page_html(){

			echo '<div id="mfn-wrapper">';		
				echo '<form method="post" action="options.php" enctype="multipart/form-data" id="mfn-form-wrapper">';
					settings_fields($this->args['opt_name'].'_group');
					echo '<input type="hidden" id="last_tab" name="'.$this->args['opt_name'].'[last_tab]" value="'.$this->options['last_tab'].'" />';
				
					echo '<div id="mfn-aside">';
						echo '<div class="mfn-logo">Theme Options - Powered by Muffin Group</div>';
						
						// menu items -----------------------------------------------
						echo '<ul class="mfn-menu">';
							foreach($this->menu as $k => $menu_item)
							{
								$icon = ( !isset($menu_item['icon']) ) ? '<img src="'. $this->url .'img/icons/general.png" /> ' : '<img src="'. $menu_item['icon'] .'" /> ';
								echo '<li class="mfn-menu-li">';
									echo '<a href="javascript:void(0);" class="mfn-menu-a">'. $icon .'<span>'. $menu_item['title']. '</span></a>';
									
									if( is_array( $menu_item['sections'] ) )
									{
										echo '<ul class="mfn-submenu">';
										foreach( $menu_item['sections'] as $sub_item ){
											$icon = ( !isset($this->sections[$sub_item]['icon']) ) ? '<img src="'. $this->url .'img/icons/sub.png" /> ' : '<img src="'. $this->sections[$sub_item]['icon'] .'" /> ';
											echo '<li id="'.$sub_item.'-mfn-submenu-li" class="mfn-submenu-li">';
												echo '<a href="javascript:void(0);" class="mfn-submenu-a" data-rel="'.$sub_item.'">'. $icon .'<span>'. $this->sections[$sub_item]['title'] .'</span></a>';
											echo '</li>';
										}
										echo '</ul>';
									}
									
								echo '</li>';
							}
						echo '</ul>';
						// end: menu items -------------------------------------------
				
					echo '</div>';
					
					echo '<div id="mfn-main">';
						echo '<div class="mfn-header">';
							echo '<div class="mfn-buttons">';
								echo '<a class="mfn-btn-preview" href="'. site_url() .'" target="_blank"><span>'. __('Preview theme','mfn-opts') .'</span></a>';
								echo '<a class="mfn-btn-xml" href="http://themes.muffingroup.com/xmls" target="_blank"><span>Get the .xml file with demo content</span></a>';
								echo '<a class="mfn-btn-doc" href="http://themes.muffingroup.com/tisson/documentation.pdf" target="_blank"><span>Documentation</span></a>';
							echo '</div>';
							echo '<div class="mfn-hgroup">';
								echo '<input type="submit" name="submit" value="'.__('Save Changes', 'mfn-opts').'" class="mfn-popup-save" />';
							echo '</div>';
							echo '<div class="mfn-strip"></div>';
						echo '</div>';
			
						// sections -------------------------------------------------
						echo '<div class="mfn-sections">';
							foreach($this->sections as $k => $section){
								echo '<div id="'.$k.'-mfn-section'.'" class="mfn-section">';
									do_settings_sections($k.'_section_group');
									echo '<div class="mfn-sections-footer">';
										echo '<input type="submit" name="submit" value="'.__('Save Changes', 'mfn-opts').'" class="mfn-popup-save" />';
									echo '</div>';
								echo '</div>';
							}
						echo '</div>';
						// end: sections --------------------------------------------
												
					echo '</div>';
					
					echo '<div class="clear">&nbsp;</div>';
				echo '</form>';	
			echo '</div>';
		}

		/**
		 * JS to display the errors on the page
		*/	
		function _errors_js(){
			
			if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('mfn-opts-errors')){
				$errors = get_transient('mfn-opts-errors');
				$section_errors = array();
				foreach($errors as $error){
					$section_errors[$error['section_id']] = (isset($section_errors[$error['section_id']]))?$section_errors[$error['section_id']]:0;
					$section_errors[$error['section_id']]++;
				}
				
				echo '<script type="text/javascript">';
					echo 'jQuery(document).ready(function(){';
						echo 'jQuery("#mfn-opts-field-errors span").html("'.count($errors).'");';
						echo 'jQuery("#mfn-opts-field-errors").show();';
						
						foreach($section_errors as $sectionkey => $section_error){
							echo 'jQuery("#'.$sectionkey.'_section_group_li_a").append("<span class=\"mfn-opts-menu-error\">'.$section_error.'</span>");';
						}
						
						foreach($errors as $error){
							echo 'jQuery("#'.$error['id'].'").addClass("mfn-opts-field-error");';
							echo 'jQuery("#'.$error['id'].'").closest("td").append("<span class=\"mfn-opts-th-error\">'.$error['msg'].'</span>");';
						}
					echo '});';
				echo '</script>';
				delete_transient('mfn-opts-errors');
			}	
		}
		
		
		/**
		 * JS to display the warnings on the page
		*/	
		function _warnings_js(){
			
			if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('mfn-opts-warnings')){
					$warnings = get_transient('mfn-opts-warnings');
					$section_warnings = array();
					foreach($warnings as $warning){
						$section_warnings[$warning['section_id']] = (isset($section_warnings[$warning['section_id']]))?$section_warnings[$warning['section_id']]:0;
						$section_warnings[$warning['section_id']]++;
					}
					
					
					echo '<script type="text/javascript">';
						echo 'jQuery(document).ready(function(){';
							echo 'jQuery("#mfn-opts-field-warnings span").html("'.count($warnings).'");';
							echo 'jQuery("#mfn-opts-field-warnings").show();';
							
							foreach($section_warnings as $sectionkey => $section_warning){
								echo 'jQuery("#'.$sectionkey.'_section_group_li_a").append("<span class=\"mfn-opts-menu-warning\">'.$section_warning.'</span>");';
							}
							
							foreach($warnings as $warning){
								echo 'jQuery("#'.$warning['id'].'").addClass("mfn-opts-field-warning");';
								echo 'jQuery("#'.$warning['id'].'").closest("td").append("<span class=\"mfn-opts-th-warning\">'.$warning['msg'].'</span>");';
							}
						echo '});';
					echo '</script>';
					delete_transient('mfn-opts-warnings');
				}
			
		}
	
		
		/**
		 * Section HTML OUTPUT.
		*/	
		function _section_desc($section){
			
			$id = str_replace('_section', '', $section['id']);
			
			if(isset($this->sections[$id]['desc']) && !empty($this->sections[$id]['desc'])) {
				echo '<div class="mfn-opts-section-desc">'.$this->sections[$id]['desc'].'</div>';
			}
			
		}
		
		
		/**
		 * Field HTML OUTPUT.
		*/
		function _field_input($field){

			if(isset($field['callback']) && function_exists($field['callback'])){
				$value = (isset($this->options[$field['id']]))?$this->options[$field['id']]:'';
				do_action('mfn-opts-before-field', $field, $value);
				do_action('mfn-opts-before-field-'.$this->args['opt_name'], $field, $value);
				call_user_func($field['callback'], $field, $value);
				do_action('mfn-opts-after-field', $field, $value);
				do_action('mfn-opts-after-field-'.$this->args['opt_name'], $field, $value);
				return;
			}
			
			if(isset($field['type'])){
				
				$field_class = 'MFN_Options_'.$field['type'];
				
				if(class_exists($field_class)){
					require_once($this->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php');
				}
				
				if(class_exists($field_class)){
					$value = (isset($this->options[$field['id']]))?$this->options[$field['id']]:'';
					do_action('mfn-opts-before-field', $field, $value);
					do_action('mfn-opts-before-field-'.$this->args['opt_name'], $field, $value);
					$render = '';
					$render = new $field_class($field, $value, $this);
					$render->render();
					do_action('mfn-opts-after-field', $field, $value);
					do_action('mfn-opts-after-field-'.$this->args['opt_name'], $field, $value);
				}
				
			}
			
		}
	
	}//class
}//if
?>