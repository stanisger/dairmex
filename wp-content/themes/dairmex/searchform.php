<?php
/**
 * The main template file.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

$translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder','Enter your search') : __('Enter your search','tisson');
?>


<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" class="field" name="s" id="s" placeholder="<?php echo $translate['search-placeholder']; ?>" />
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="Search" />
</form>