<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title>
		<?php bloginfo( 'name' ); ?>
		<?php wp_title( '|', true, '' ); ?>
	</title>

<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="profile" href="http://gmpg.org/xfn/11"/>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

<?php
	global $znData;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}
	zn_favicon();
	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_dequeue_style('css3_panels');
	wp_dequeue_style('icarousel_demo');
	wp_dequeue_style('icarousel');
	wp_dequeue_style('flex_slider');
	wp_dequeue_style('flex_slider_fancy');
	wp_dequeue_style('lslider');
	wp_dequeue_style('cuteslider');
	wp_dequeue_style('rs-plugin-settings');
	wp_dequeue_style('rs-plugin-settings-inline');
	wp_dequeue_style('woocommerce-layout');
	wp_dequeue_style('woocommerce-smallscreen');
	wp_dequeue_style('woocommerce-general');
	wp_dequeue_style('zn-superfish');
	wp_dequeue_style('pretty_photo');
	wp_head();
?>
</head>
<?php
	$style = '';
	if(isset($znData['wpk_cs_bg_color']) && !empty($znData['wpk_cs_bg_color'])){
		$style = 'background: '.$znData['wpk_cs_bg_color'];
	}
?>
<body class="offline-page" style="<?php echo $style;?>">
<?php zn_f_o_g(); ?>
<div class="containerbox">
<?php echo zn_logo(); ?>
<div class="content">
	<p><?php echo stripslashes( $znData['cs_desc'] ); ?></p>
	<?php
		if ( ! empty ( $znData['cs_date']['date'] ) && ! empty ( $znData['cs_date']['time'] ) ) {

			echo '<div class="ud_counter">';
			?>
            <ul id="jq-counter">
                <li><?php _e( '0', THEMENAME );?><span><?php _e( 'day', THEMENAME );?></span></li>
                <li><?php _e( '00', THEMENAME );?><span><?php _e( 'hours', THEMENAME );?></span></li>
                <li><?php _e( '00', THEMENAME );?><span><?php _e( 'min', THEMENAME );?></span></li>
                <li><?php _e( '00', THEMENAME );?><span><?php _e( 'sec', THEMENAME );?></span></li>
            </ul>
            <?php
			echo '<span class="till_lauch"><img src="' . MASTER_THEME_DIR . '/images/rocket.png"></span>';
			echo '</div><!-- end counter -->';
		}

		if ( ! empty ( $znData['cs_lsit_id'] ) && ! empty ( $znData['mailchimp_api'] ) ) {

			echo '<div class="mail_when_ready">';
			echo '		<form method="post" class="newsletter_subscribe newsletter-signup" data-url="' .
				 trailingslashit( home_url() ) . '" name="newsletter_form">';
			echo '			<input type="text" name="zn_mc_email" class="nl-email" value="" placeholder="your.address@email.com" />';
			echo '			<input type="hidden" name="zn_list_class" class="nl-lid" value="' . $znData['cs_lsit_id'] . '" />';
			echo '			<input type="submit" name="submit" class="nl-submit" value="JOIN US" />';
			echo '		</form>';
			echo '<span class="zn_mailchimp_result"></span>';
			echo '</div>';
		}

		if ( isset( $znData['cs_social_icons'] ) && is_array( $znData['cs_social_icons'] ) && ! empty( $znData['cs_social_icons'][0]['cs_social_icon'] ) ) {

			echo '<ul class="social-icons fixclear">';

			foreach ( $znData['cs_social_icons'] as $key => $icon )
			{
				$link   = '';
				$target = '';

				if ( isset ( $icon['cs_social_link'] ) && is_array( $icon['cs_social_link'] ) ) {
					$link   = $icon['cs_social_link']['url'];
					$target = 'target="' . $icon['cs_social_link']['target'] . '"';
				}
				echo '<li class="' . $icon['cs_social_icon'] . '"><a href="' . $link . '" ' . $target . '>' . $icon['cs_social_title'] . '</a></li>';
			}
			echo '</ul>';
		}
	?>
	<div class="clear"></div>
</div>
<!-- end content -->
<div class="clear"></div>
</div>
<?php wp_footer(); ?>

<script type="text/javascript">
    jQuery(function ($) {
        "use strict";

        //#! Start countdown
        var years  = "<?php _e('years', THEMENAME);?>",
            months = "<?php _e('months', THEMENAME);?>",
            weeks  = "<?php _e('weeks', THEMENAME);?>",
            days   = "<?php _e('days', THEMENAME);?>",
            hours  = "<?php _e('hours', THEMENAME);?>",
            min    = "<?php _e('min', THEMENAME);?>",
            sec    = "<?php _e('sec', THEMENAME);?>";

        var counterOptions = {
            layout: function ()
            {
                return '<li>{dn}<span>{dl}</span></li>' +
                    '<li>{hn}<span>{hl}</span></li>' +
                    '<li>{mn}<span>{ml}</span></li>' +
                    '<li>{sn}<span>{sl}</span></li>';
            }
        };
        <?php
            // General Options
            $y = $mo = $d = $h = $mi = '';

            if(isset($znData['cs_date']) && isset($znData['cs_date']['date']) && isset($znData['cs_date']['time'])){
                $str_date = strtotime(trim($znData['cs_date']['date']));
                $y = date('Y', $str_date);
                $mo = date('m', $str_date);
                $d = date('d', $str_date);
                $time = explode(':', $znData['cs_date']['time']);
                $h = $time[0];
                $mi = $time[1];
            }
        ?>
        var y = <?php echo intval($y);?>,
            mo = <?php echo intval($mo)-1;?>,
            d = <?php echo intval($d);?>,
            h = <?php echo intval($h);?>,
            mi = <?php echo intval($mi);?>,
            t = new Date(y, mo, d, h, mi, 0);
        jQuery('#jq-counter').countdown({
            until: t,
            layout: counterOptions.layout(),
            labels: [years, months, weeks, days, hours, min, sec],
            labels1: [years, months, weeks, days, hours, min, sec],
            format: 'DHMS'
        });
        //#!-- End countdown
    });
</script>
</body>
</html>
