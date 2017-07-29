<?php

/**
 *
 * Default plugin settings
 *
 */
$wprmenu_setup = array(
    'enabled' => 1,
    'menu' => '',
    'menu_symbol_pos' => 'left',
    'bar_title' => 'MENU',
    'nesting_icon' => '',
    'nesting_icon_open' => '',
    'from_width' => 768,
    'position' => 'left',
    'how_wide' => '80',
    'hide' => array(),
    'zooming' => 'no',
    'bar_bgd' => '#0D0D0D',
    'bar_color' => '#F2F2F2',
    'menu_bgd' => '#2E2E2E',
    'menu_color' => '#CFCFCF',
    'menu_color_hover' => '#606060',
    'menu_border_top' => '#474747',
    'menu_border_bottom' => '#131212',
    'menu_border_bottom_show' => 'yes'
);

/**
 *
 * Save the default settings
 *
 */
if(!get_option('wprmenu_options')) {
    add_option('wprmenu_options', $wprmenu_setup);
}

/**
 *
 * Add settings page menu item
 *
 */
if ( is_admin() ){
    /**
     * action name
     * function that will create the menu page link / options page
     */
    add_action( 'admin_menu', 'wprmenu_admin_menu' );
}



/**
 *
 * Add plugin settings page
 *
 */
function wprmenu_admin_menu(){
    /**
     * menu title
     * page title
     * who can acces the settings  - user that can ...
     * the settings page identifier for the url
     * function that will generate the form with th esettings
     */
    add_options_page(__('WP Responsive Menu','wprmenu'),__('WP Responsive Menu','wprmenu'),'manage_options','wprmenu_settings','wprmenu_settings');
}



function wprmenu_add_admin_scripts() {
    if ( 'settings_page_wprmenu_settings' == get_current_screen()->id ) {
        if(function_exists( 'wp_enqueue_media' )){
            wp_enqueue_media();
        }else{
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
        }
    }
}
add_action('admin_enqueue_scripts', 'wprmenu_add_admin_scripts');

/**
 *
 * Create the tabs for the settings page
 * @param  string $current default  tab
 * @return HTML          The tab switcher
 *
 */
function wprmenu_settings_tabs( $current = 'general' ) {
    $tabs = array( 'general' => __('General','wprmenu'), 'appearance' => __('Menu Appearance','wprmenu'));
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=wprmenu_settings&tab=$tab'>$name</a>";
    }
    echo '</h2>';
}

/**
 *
 * The settings wrappers
 * one for 'general' and 'emails' tabs
 * one for subscribers list
 *
 */
function wprmenu_settings() {
    ?>
    <div class="wrap">
        <br>
		<h2> WP Responsive Menu </h2>
        <br>
        <?php if ( isset ( $_GET['tab'] ) ) wprmenu_settings_tabs($_GET['tab']); else wprmenu_settings_tabs('general'); ?>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('wprmenu_options');
            do_settings_sections('wprmenu_plugin');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


/**
 *
 * Initialize the settings
 *
 */
if ( is_admin() ) {
    /**
     * action name
     * function that will do all the initialization
     */
    add_action('admin_init', 'wprmenu_admin_init');
}

/**
 *
 * Settings sections and fields setup
 *
 */
function wprmenu_admin_init(){
    register_setting( 'wprmenu_options', 'wprmenu_options', 'wprmenu_options_validate' );
    //
    if(!isset($_GET['tab']) || $_GET['tab'] == 'general') {
        add_settings_section('wprmenu_general_settings', '<br>'.__('General settings','wprmenu'), 'wprmenu_general_settings_section', 'wprmenu_plugin');
        //
        add_settings_field('wprmenu_enabled', __('Enable mobile navigation','wprmenu'), 'wprmenu_general_settings_enabled', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_menu', __('Choose the wordpress menu','wprmenu'), 'wprmenu_general_settings_menu', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_menu_symbol_pos', __('Menu symbol position (on the top menu bar)','wprmenu'), 'wprmenu_general_settings_menu_symbol_pos', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_bar_title', __('Text on menu bar','wprmenu'), 'wprmenu_general_settings_bar_title', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_bar_logo', __('Logo for menu bar','wprmenu'), 'wprmenu_general_settings_bar_logo', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_from_width', __('Display menu from width (below in pixels)','wprmenu'), 'wprmenu_general_settings_from_width', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_position', __('Menu position','wprmenu'), 'wprmenu_general_settings_position', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_how_wide', __('Menu Width ( % of total page width )','wprmenu'), 'wprmenu_general_settings_how_wide', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_hide', __('Hide elements on mobile','wprmenu'), 'wprmenu_general_settings_hide', 'wprmenu_plugin', 'wprmenu_general_settings');
        //
        add_settings_field('wprmenu_zooming', __('Allow zooming on mobile devices?','wprmenu'), 'wprmenu_general_settings_zooming', 'wprmenu_plugin', 'wprmenu_general_settings');
    }
    //
    if(isset($_GET['tab']) && $_GET['tab'] == 'appearance') {
        add_settings_section('wprmenu_appearance_settings', '<br>'.__('Menu appearance','wprmenu'), 'wprmenu_appearance_settings_section', 'wprmenu_plugin');
        //
        add_settings_field('wprmenu_bar_bgd', __('Menu bar background color','wprmenu'), 'wprmenu_appearance_settings_bar_bgd', 'wprmenu_plugin', 'wprmenu_appearance_settings');
        //
        add_settings_field('wprmenu_bar_color', __('Menu bar text color','wprmenu'), 'wprmenu_appearance_settings_bar_color', 'wprmenu_plugin', 'wprmenu_appearance_settings');
        //
        add_settings_field('wprmenu_menu_bgd', __('Menu background color','wprmenu'), 'wprmenu_appearance_settings_menu_bgd', 'wprmenu_plugin', 'wprmenu_appearance_settings');
        //
        add_settings_field('wprmenu_menu_color', __('Menu text color','wprmenu'), 'wprmenu_appearance_settings_menu_color', 'wprmenu_plugin', 'wprmenu_appearance_settings');
        //
        add_settings_field('wprmenu_menu_color_hover', __('Menu hover text color','wprmenu'), 'wprmenu_appearance_settings_menu_color_hover', 'wprmenu_plugin', 'wprmenu_appearance_settings');
		//
		add_settings_field('wprmenu_menu_icon_color', __('Menu icon color','wprmenu'), 'wprmenu_appearance_settings_menu_icon_color', 'wprmenu_plugin', 'wprmenu_appearance_settings');
        //
        add_settings_field('wprmenu_menu_border_top', __('Menu borders(top & left) color','wprmenu'), 'wprmenu_appearance_settings_menu_border_top', 'wprmenu_plugin', 'wprmenu_appearance_settings');
        //
        add_settings_field('wprmenu_menu_border_bottom', __('Menu borders(bottom) color','wprmenu'), 'wprmenu_appearance_settings_menu_border_bottom', 'wprmenu_plugin', 'wprmenu_appearance_settings');
        //
        add_settings_field('wprmenu_menu_border_bottom_show', __('Borders on menu items','wprmenu'), 'wprmenu_appearance_settings_menu_border_bottom_show', 'wprmenu_plugin', 'wprmenu_appearance_settings');
    }
}


function wprmenu_general_settings_section() {

}


function wprmenu_general_settings_enabled() {
    $options = get_option('wprmenu_options');
    ?>
    <label for="wprmenu_enabled">
        <input name="wprmenu_options[enabled]" type="checkbox" id="wprmenu_enabled" value="1" <?php if($options['enabled']) echo 'checked="checked"' ?>>
        <?php ' '._e('Enabled','wprmenu'); ?>
    </label>
    <?php
}


function wprmenu_general_settings_menu() {
    $options = get_option('wprmenu_options');
    $menus = get_terms('nav_menu',array('hide_empty'=>false));
    ?>
    <select name="wprmenu_options[menu]" >
        <?php foreach( $menus as $m ): ?>
            <option <?php if($m->term_id == $options['menu']) echo 'selected="selected"'; ?>  value="<?php echo $m->term_id ?>"><?php echo $m->name ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}


function wprmenu_general_settings_menu_symbol_pos() {
    $options = get_option('wprmenu_options');
    ?>
    <select id="sdmn_menu_symbol_pos" name="wprmenu_options[menu_symbol_pos]" >
        <option <?php if($options['menu_symbol_pos'] == 'left') echo 'selected="selected"'; ?>  value="left">left</option>
        <option <?php if($options['menu_symbol_pos'] == 'right') echo 'selected="selected"'; ?>  value="right">right</option>
    </select>
    <?php
}

function wprmenu_general_settings_bar_title() {
    $options = get_option('wprmenu_options');
    ?>
    <input id="wprmenu_bar_title" name="wprmenu_options[bar_title]"  size="20" type="text" value="<?php echo $options['bar_title'] ?>" />
    <?php
}

function wprmenu_general_settings_bar_logo() {
    $options = get_option('wprmenu_options');
    ?>
    <input type="hidden" name="wprmenu_options[bar_logo]" class="wprmenu_bar_logo_url" value="<?php echo $options['bar_logo'] ?>">
    <span style="position:relative">
        <img style="<?php if(!$options['bar_logo']) echo 'display:none; ' ?> width:auto; height:20px; margin-bottom:-6px; margin-right:6px;" class="wprmenu_bar_logo_prev" src="<?php echo $options['bar_logo'] ?>" alt="">
    </span>
    <input id="upload_bar_logo_button" type="button" class="button" value="Choose image" />
    <span class="description"><?php if($options['bar_logo']) echo ' <a class="wprmenu_disc_bar_logo" href="#" style="margin-left:10px;"> Discard the image (disable logo)</a>'; ?></span>
    <?php
}


function wprmenu_general_settings_nesting_icon() {
    $options = get_option('wprmenu_options');
    ?>
    <input id="wprmenu_nesting_icon" name="wprmenu_options[nesting_icon]"  size="20" type="text" value="<?php echo $options['nesting_icon'] ?>" />
    <?php
}

function wprmenu_general_settings_nesting_icon_open() {
    $options = get_option('wprmenu_options');
    ?>
    <input id="wprmenu_nesting_icon_open" name="wprmenu_options[nesting_icon_open]"  size="20" type="text" value="<?php echo $options['nesting_icon_open'] ?>" />
    <?php
}


function wprmenu_general_settings_from_width() {
    $options = get_option('wprmenu_options');
    ?>
    <input id="wprmenu_from_width" name="wprmenu_options[from_width]" min="280" max="962" size="20" type="number" value="<?php echo $options['from_width'] ?>" />
    <?php
}



function wprmenu_general_settings_position() {
    $options = get_option('wprmenu_options');
    ?>
    <select id="wpr_menu_pos" name="wprmenu_options[position]" >
        <option <?php if($options['position'] == 'top') echo 'selected="selected"'; ?>  value="top">top</option>
        <option <?php if($options['position'] == 'left') echo 'selected="selected"'; ?>  value="left">left</option>
        <option <?php if($options['position'] == 'right') echo 'selected="selected"'; ?>  value="right">right</option>
    </select>
    <?php
}


function wprmenu_general_settings_how_wide() {
    $options = get_option('wprmenu_options');
    ?>
    <input id="wprmenu_how_wide" name="wprmenu_options[how_wide]" min="30" max="100" size="20" type="number" value="<?php echo $options['how_wide'] ?>" />
    <?php
}


function wprmenu_general_settings_hide() {
    $options = get_option('wprmenu_options');
    ?>
    <input id="wprmenu_hide" name="wprmenu_options[hide]"  size="60" type="text" value="<?php echo implode(', ',$options['hide']) ?>" />
    <br>CSS sellectors (IDs and classes comma separated) <i>Example: #menu, .nav</i>
    <?php
}


function wprmenu_general_settings_zooming() {
    $options = get_option('wprmenu_options');
    ?>
    <select id="sdmn_zooming" name="wprmenu_options[zooming]" >
        <option <?php if($options['zooming'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes</option>
        <option <?php if($options['zooming'] == 'no') echo 'selected="selected"'; ?>  value="no">No</option>
    </select>
    <?php
}











function wprmenu_appearance_settings_section() {

}


function wprmenu_appearance_settings_bar_bgd() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[bar_bgd]" id="wprmenu_bar_bgd_picker"  value="<?php echo $options['bar_bgd']; ?>" />
    <?php
}


function wprmenu_appearance_settings_bar_color() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[bar_color]" id="wprmenu_bar_color_picker"  value="<?php echo $options['bar_color']; ?>" />
    <?php
}


function wprmenu_appearance_settings_menu_bgd() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[menu_bgd]" id="wprmenu_menu_bgd_picker"  value="<?php echo $options['menu_bgd']; ?>" />
    <?php
}


function wprmenu_appearance_settings_menu_color() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[menu_color]" id="wprmenu_menu_color_picker"  value="<?php echo $options['menu_color']; ?>" />
    <?php
}


function wprmenu_appearance_settings_menu_color_hover() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[menu_color_hover]" id="wprmenu_menu_color_hover_picker"  value="<?php echo $options['menu_color_hover']; ?>" />
    <?php
}

function wprmenu_appearance_settings_menu_icon_color() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[menu_icon_color]" id="wprmenu_menu_icon_color_picker"  value="<?php echo $options['menu_icon_color']; ?>" />
    <?php
}


function wprmenu_appearance_settings_menu_border_top() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[menu_border_top]" id="wprmenu_menu_border_top_picker"  value="<?php echo $options['menu_border_top']; ?>" />
    <?php
}


function wprmenu_appearance_settings_menu_border_bottom() {
    $options = get_option('wprmenu_options');
    ?>
    <input maxlength="7" size="5" type="text" name="wprmenu_options[menu_border_bottom]" id="wprmenu_menu_border_bottom_picker"  value="<?php echo $options['menu_border_bottom']; ?>" />
    <?php
}


function wprmenu_appearance_settings_menu_border_bottom_show() {
    $options = get_option('wprmenu_options');
    ?>
    <select id="wprmenu_options_bottom" name="wprmenu_options[menu_border_bottom_show]" >
        <option <?php if($options['menu_border_bottom_show'] == 'yes') echo 'selected="selected"'; ?>  value="yes">Yes</option>
        <option <?php if($options['menu_border_bottom_show'] == 'no') echo 'selected="selected"'; ?>  value="no">No</option>
    </select>
    <?php
}

/**
 *Save settings fields
 *
 */
function wprmenu_options_validate($input) {
    global $wprmenu_setup; //default settings array

    $options = get_option('wprmenu_options');

    //enabled  / dispabled
    if(isset($input['menu'])) {
        $options['enabled'] = $input['enabled'];
    }

    //section "General", option "menu"
    if(isset($input['menu'])) {
        $options['menu'] = $input['menu'];
        if($options['menu'] == false || $options['menu'] == null || $options['menu'] == 0 || $options['menu'] == '') $options['menu'] = '';
    }

    if(isset($input['menu_symbol_pos'])) {
       $options['menu_symbol_pos'] = $input['menu_symbol_pos'];
    }

    //section "General", option "bar_title"
    if(isset($input['bar_title'])) {
        $options['bar_title'] = trim($input['bar_title']);
        if($options['bar_title'] == false || $options['bar_title'] == '') $options['bar_title'] = '';
    }

    //section "General", option "bar_logo"
    if(isset($input['bar_logo'])) {
        $options['bar_logo'] = trim($input['bar_logo']);
        if($options['bar_logo'] == false || $options['bar_logo'] == '') $options['bar_logo'] = '';
    }

    if(isset($input['nesting_icon'])) {
        $options['nesting_icon'] = trim($input['nesting_icon']);
        if($options['nesting_icon'] == false || $options['nesting_icon'] == '') $options['nesting_icon'] = '';
    }

    if(isset($input['nesting_icon_open'])) {
        $options['nesting_icon_open'] = trim($input['nesting_icon_open']);
        if($options['nesting_icon_open'] == false || $options['nesting_icon_open'] == '') $options['nesting_icon_open'] = '';
    }

    //section "General", option "from_width"
    if(isset($input['from_width'])) {
        $options['from_width'] = $input['from_width'];
    }

    //section "General", option "position"
    if(isset($input['position'])) {
        $options['position'] = $input['position'];
    }

    //section "General", option "how_wide"
    if(isset($input['how_wide'])) {
        $options['how_wide'] = $input['how_wide'];
    }

    //section "General", option "hide"
    if(isset($input['hide'])) {
        $sel = explode(',', trim($input['hide']));
        foreach($sel as $s) {
            $selectors[] = trim($s);
        }
        $options['hide'] = $selectors;
    } else {
    }

    //section "General", option "zooming"
    if(isset($input['zooming'])) {
        $options['zooming'] = $input['zooming'];
    }



    //section "appearance", option "bar_bgd"
    if(isset($input['bar_bgd'])) {
        $options['bar_bgd'] = $input['bar_bgd'];
    }

    //section "appearance", option "bar_color"
    if(isset($input['bar_color'])) {
        $options['bar_color'] = $input['bar_color'];
    }

    //section "appearance", option "menu_bgd"
    if(isset($input['menu_bgd'])) {
        $options['menu_bgd'] = $input['menu_bgd'];
    }

    //section "appearance", option "menu_color"
    if(isset($input['menu_color'])) {
        $options['menu_color'] = $input['menu_color'];
    }

    //section "appearance", option "menu_color_hover"
    if(isset($input['menu_color_hover'])) {
        $options['menu_color_hover'] = $input['menu_color_hover'];
    }
	
	 //section "appearance", option "menu_icon_color"
    if(isset($input['menu_icon_color'])) {
        $options['menu_icon_color'] = $input['menu_icon_color'];
    }

    //section "appearance", option "menu_border_top"
    if(isset($input['menu_border_top'])) {
        $options['menu_border_top'] = $input['menu_border_top'];
    }


    //section "appearance", option "menu_border_bottom"
    if(isset($input['menu_border_bottom'])) {
        $options['menu_border_bottom'] = $input['menu_border_bottom'];
    }

    if(isset($input['menu_border_bottom_show'])) {
        $options['menu_border_bottom_show'] = $input['menu_border_bottom_show'];
    }

    //save only the options that were changed
    $options = array_merge(get_option('wprmenu_options'), $options);

    //echo '<pre>'; print_r($options); echo '</pre>';

    return $options;
}