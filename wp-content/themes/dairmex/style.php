<?php
/**
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

header( 'Content-type: text/css;' );
	
$url = dirname( __FILE__ );
$strpos = strpos( $url, 'wp-content' );
$base = substr( $url, 0, $strpos );

require_once( $base .'wp-load.php' );
?>

/******************* Background ********************/

	<?php		
		$aBackground = array();
		$aBackground['color'] = mfn_opts_get( 'background-body', '#dfe3e5' );
		
		if( mfn_opts_get( 'img-page-bg' ) ){
			$aBackground['image'] = mfn_opts_get( 'img-page-bg' ) ? 'url("'. mfn_opts_get( 'img-page-bg' ) .'")' : '' ;
			$aBackground['position'] = mfn_opts_get( 'position-page-bg' );
		}
		
		$background = implode(' ',$aBackground);
	?>
	
	html { 
		background: <?php echo $background; ?>;
	}
	
	<?php if( mfn_opts_get( 'img-subheader-bg' ) ): ?>
	#Subheader { background:url("<?php mfn_opts_show( 'img-subheader-bg' ) ?>") no-repeat center top; }
	<?php endif; ?>


/********************** Fonts **********************/

 	body, button, input[type="submit"], input[type="reset"], input[type="button"],
	input[type="text"], input[type="password"], input[type="email"], textarea, select {
		font-family: <?php mfn_opts_show( 'font-content', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: normal;
	}
	
	#menu > ul > li > a {
		font-family: <?php mfn_opts_show( 'font-menu', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: normal;
	}
	
	h1 {
		font-family: <?php mfn_opts_show( 'font-headings', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h2 {
		font-family: <?php mfn_opts_show( 'font-headings', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h3 {
		font-family: <?php mfn_opts_show( 'font-headings', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h4 {
		font-family: <?php mfn_opts_show( 'font-headings', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h5 {
		font-family: <?php mfn_opts_show( 'font-headings', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: 300;
	}
	
	h6 {
		font-family: <?php mfn_opts_show( 'font-headings', 'Exo' ) ?>, Arial, Tahoma, sans-serif;
		font-weight: 300;
	}


/********************** Font sizes **********************/

/* Body */

	body {
		font-size: <?php mfn_opts_show( 'font-size-content', '14' ) ?>px;
		<?php $line_height = mfn_opts_get( 'font-size-content', '14' ) + 7; ?>
		line-height: <?php echo $line_height; ?>px;		
	}
	
	#menu > ul > li > a {	
		font-size: <?php mfn_opts_show( 'font-size-menu', '15' ) ?>px;
	}
	
/* Headings */

	h1 { 
		font-size: <?php mfn_opts_show( 'font-size-h1', '40' ) ?>px;
		<?php $line_height = mfn_opts_get( 'font-size-h1', '40' ) + 0; ?>
		line-height: <?php echo $line_height; ?>px;
	}
	
	h2 { 
		font-size: <?php mfn_opts_show( 'font-size-h2', '36' ) ?>px;
		<?php $line_height = mfn_opts_get( 'font-size-h2', '36' ) + 0; ?>
		line-height: <?php echo $line_height; ?>px;
	}
	
	h3 {
		font-size: <?php mfn_opts_show( 'font-size-h3', '28' ) ?>px;
		<?php $line_height = mfn_opts_get( 'font-size-h3', '28' ) + 2; ?>
		line-height: <?php echo $line_height; ?>px;
	}
	
	h4 {
		font-size: <?php mfn_opts_show( 'font-size-h4', '19' ) ?>px;
		<?php $line_height = mfn_opts_get( 'font-size-h4', '19' ) + 4; ?>
		line-height: <?php echo $line_height; ?>px;
	}
	
	h5 {
		font-size: <?php mfn_opts_show( 'font-size-h5', '17' ) ?>px;
		<?php $line_height = mfn_opts_get( 'font-size-h5', '17' ) + 5; ?>
		line-height: <?php echo $line_height; ?>px;
	}
	
	h6 {
		font-size: <?php mfn_opts_show( 'font-size-h6', '16' ) ?>px;
		<?php $line_height = mfn_opts_get( 'font-size-h6', '16' ) + 2; ?>
		line-height: <?php echo $line_height; ?>px;
	}
	
	
/******************* Fixed heights ********************/

	/* 1240px */
	<?php $padding_height = mfn_opts_get( 'fixed-height-1240', '330' ) - 40; ?>
	.column-fixed > div { height: <?php mfn_opts_show( 'fixed-height-1240', '330' ) ?>px; }
	.column-fixed div.inner-padding { height: <?php echo $padding_height; ?>px;}
	.column-fixed .call_to_action .inner-padding { height: <?php echo $padding_height; ?>px; line-height: <?php echo $padding_height; ?>px;}
	
	<?php if( mfn_opts_get('responsive') ): ?>
	
	/* 960px */
	@media only screen and (min-width: 960px) and (max-width: 1239px) {
		<?php $padding_height = mfn_opts_get( 'fixed-height-960', '330' ) - 40; ?>
		.column-fixed > div { height: <?php mfn_opts_show( 'fixed-height-960', '330' ) ?>px; }
		.column-fixed div.inner-padding { height: <?php echo $padding_height; ?>px;}
		.column-fixed .call_to_action .inner-padding { height: <?php echo $padding_height; ?>px; line-height: <?php echo $padding_height; ?>px;}	
	}
	
	/* 768px */
	@media only screen and (min-width: 768px) and (max-width: 959px) {
		<?php $padding_height = mfn_opts_get( 'fixed-height-768', '330' ) - 40; ?>
		.column-fixed > div { height: <?php mfn_opts_show( 'fixed-height-768', '330' ) ?>px; }
		.column-fixed div.inner-padding { height: <?php echo $padding_height; ?>px;}
		.column-fixed .call_to_action .inner-padding { height: <?php echo $padding_height; ?>px; line-height: <?php echo $padding_height; ?>px;}	
	}
	
	<?php endif; ?>
