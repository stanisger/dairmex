<?php
/**
 * 404 page.
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header(); 

$translate['404-title'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-title','Ooops... Error 404') : __('Ooops... Error 404','tisson');
$translate['404-subtitle'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-subtitle','We`re sorry, but the page you are looking for doesn`t exist.') : __('We`re sorry, but the page you are looking for doesn`t exist.','tisson');
$translate['404-text'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-text','Please check entered address and try again <em>or</em>') : __('Please check entered address and try again <em>or</em>','tisson');
$translate['404-btn'] = mfn_opts_get('translate') ? mfn_opts_get('translate-404-btn','go to homepage') : __('go to homepage','tisson');
?>

<!-- Content -->
<div id="Error_404">
	<div class="overlay">
		<div class="container">
		
			<!-- 404 page -->
			<div class="error">
				<h2><?php echo $translate['404-title']; ?></h2>
				<h4><?php echo $translate['404-subtitle']; ?></h4>
				<p><span class="check"><?php echo $translate['404-text']; ?></span> <a class="button" href="<?php echo site_url(); ?>"><?php echo $translate['404-btn']; ?> <span>&rarr;</span></a></p>
			</div>
		
		</div>
	</div>
</div>

<?php get_footer(); ?>