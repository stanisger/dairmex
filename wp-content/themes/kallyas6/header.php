<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title>
	<?php
		if ( ! defined( 'WPSEO_VERSION' ) ) {
			echo bloginfo( 'name' ) . wp_title( '|', true, '' );
		}
		else {
			//IF WordPress SEO by Yoast is activated
			wp_title();
		}
	?>
</title>"<meta name="Calefacción  Aire acondicionado Refrigeración" content="suelo radiante precio, precio suelo radiante, calefaccion radiante electrica, precios de aires acondicionados, suelo radiante eléctrico, minisplit carrier, minisplit, instalacion de minisplit, venta de minisplit, precios de minisplit, aires acondicionados minisplit, minisplit york mexico, venta de minisplits. Mantenimiento aire acondicionado, Mantenimiento calefacción, Mantenimiento calefacción Hidrónica, Radiador para calefacción, Zoclo para calefacción, Calefacción, Aire acondicionado, Aire acondicionado para oficina, Aire acondicionado residencial, Aire acondicionado para edificios, Proyectos de aire acondicionado, Proyectos de calefacción, Calefacción Hidrónica, Piso radiante, Suelo radiante, Instalación aire acondicionado, Instalación calefacción, Instalación minisplit, Lavadora de aire, Extracción cocina, Extracción de campana, Calefacción solar, Calefacción a gas, Panel solar, Ductos de Aire, Calefacción central, Calefacción ductos, Ductos de acero inoxidable, Calefacción Malla Capilar, Caldera, Nest, Kickspace, Termostato, Instalación fan and coil"/>



<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>"/>
<link rel="profile" href="http://gmpg.org/xfn/11"/>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
<?php
	global $znData, $post;
	$data = $znData;
	wp_head();
?>
</head>
<body  <?php body_class(); ?>>

<!-- AFTER BODY ACTION -->
<?php do_action( 'zn_after_body' ); ?>
<?php
$page_id = 0;
if ( ! empty( $post ) ) {
	if ( strcasecmp( 'portfolio', get_post_type() ) == 0 ) {
		// if portfolio category
		if(is_archive()){
			global $wp_query;
			$qo = $wp_query->get_queried_object();
			if(isset($qo->term_id)) {
				$page_id     = $qo->term_id;
				$meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
				$meta_fields = maybe_unserialize( $meta_fields );
			}
		}
		else {
			$k_postMeta = get_page_by_title( 'portfolio' );
			$page_id    = $k_postMeta->ID;
		}
	}
	else {
		$page_id = $post->ID;
	}
	$meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
	$meta_fields = maybe_unserialize( $meta_fields );
}

if ( is_home() || ( is_archive() && get_post_type() == 'post' ) ) {
	$page_id = get_option( 'page_for_posts' );
	$meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
	$meta_fields = maybe_unserialize( $meta_fields );
}

if ( is_archive() && get_post_type() == 'product' ) {
	$page_id     = get_option( 'woocommerce_shop_page_id' );
	$meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
	$meta_fields = maybe_unserialize( $meta_fields );
}

$header_css = '';
if ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'yes' ) {
	$header_css = 'no_subheader';
}
elseif ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'no' ) {
	$header_css = '';
}
elseif ( ( ! empty( $data['zn_disable_subheader'] ) && $data['zn_disable_subheader'] == 'yes' ) ) {
	$header_css = 'no_subheader';
}
?>

<div id="page_wrapper">
<?php
	$cta_button_class = '';
	if ( isset( $data['head_show_cta'] ) && ! empty( $data['head_show_cta'] ) ) {
		if ( $data['head_show_cta'] == 'yes' ) {
			$cta_button_class = 'cta_button';
		}
	}
?>
<header id="header" class="<?php echo $data['zn_header_layout'] . ' ' . $cta_button_class . ' ' . $header_css; ?>">
	<div class="container">

		<!-- logo container-->
		<?php
			$hasInfoCard = '';
			if ( isset( $data['infocard_display_status'] ) && ( $data['infocard_display_status'] == 'yes' ) ) {
				$hasInfoCard = 'hasInfoCard';
			}
		?>
		<div class="logo-container <?php echo $hasInfoCard; ?>">
			<!-- Logo -->
			<?php echo zn_logo(); ?>
			<!-- InfoCard -->
			<?php do_action( 'zn_show_infocard' ); ?>
		</div>

		<?php $isSearch = empty( $data['head_show_search'] ) || ( ! empty( $data['head_show_search'] ) && $data['head_show_search'] == 'yes' ); ?>

		<!-- HEADER ACTION -->
		<div class="header-links-container <?php if ( ! $isSearch ) {
			echo 'nomarginright';
		} ?>">
			<?php do_action( 'zn_head_right_area' ); ?>
		</div>

		<?php if ( $isSearch ) { ?>
			<!-- search -->
			<div id="search">
				<a href="#" class="searchBtn"><span class="icon-search icon-white"></span></a>

				<div class="search">
					<form id="searchform" action="<?php echo home_url(); ?>" method="get">
						<input name="s" maxlength="20" class="inputbox" type="text" size="20"
							   value="<?php echo __( 'SEARCH ...', THEMENAME ); ?>"
							   onblur="if (this.value=='') this.value='<?php echo __( 'SEARCH ...', THEMENAME ); ?>';"
							   onfocus="if (this.value=='<?php echo __( 'SEARCH ...', THEMENAME ); ?>') this.value='';"/>
						<input type="submit" id="searchsubmit" value="<?php _e( 'go', THEMENAME ); ?>"
							   class="icon-search"/>
					</form>
				</div>
			</div>
			<!-- end search -->
		<?php } ?>

		<?php if ( empty( $data['head_show_cta'] ) || ( ! empty( $data['head_show_cta'] ) && $data['head_show_cta'] == 'yes' ) ) { ?>
			<?php
			if ( isset( $data['head_add_cta_link'] ) && ! empty( $data['head_add_cta_link'] ) ) {
				$link_extracted = kall_extract_link( $data['head_add_cta_link'], false, 'id="ctabutton"' );
				if ( ! empty( $data['head_set_text_cta'] ) ) {
					if(isset($znData['wpk_cs_bg_color']) && isset($znData['wpk_cs_fg_color'])) {
						echo '<style type="text/css">
							#ctabutton .trisvg path { fill: ' . $znData['wpk_cs_bg_color'] . '; }
							#ctabutton { background-color: ' . $znData['wpk_cs_bg_color'] . '; color: '.$znData['wpk_cs_fg_color'].'; }
						</style>';
					}
					echo $link_extracted['start'];
					echo $data['head_set_text_cta'];
					echo '<svg version="1.1" class="trisvg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" preserveAspectRatio="none" width="14px" height="5px" viewBox="0 0 14.017 5.006" enable-background="new 0 0 14.017 5.006" xml:space="preserve"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.016,0L7.008,5.006L0,0H14.016z"></path></svg>';
					echo $link_extracted['end'];
				}
			}
		} ?>

		<!-- main menu -->
		<nav id="main_menu"
			 class="<?php if ( ! empty ( $data['res_menu_style'] ) && $data['res_menu_style'] == 'smooth' ) {
				 echo 'smooth_menu';
			 } ?>">
			<?php if ( ! empty ( $data['res_menu_style'] ) && $data['res_menu_style'] == 'smooth' ) {
				echo '<div class="zn_menu_trigger"><a href="">' . __( 'Menu', THEMENAME ) . '</a></div>';
			} ?>
			<?php zn_show_nav( 'main_navigation' ); ?>
		</nav>
		<!-- end main_menu -->
	</div>
</header>

<div class="clearfix"></div>

<?php
	/*--------------------------------------------------------------------------------------------------

		HEADER AREA

	--------------------------------------------------------------------------------------------------*/

	if ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'yes') {
		return;
	}
	elseif ( ! empty( $meta_fields['zn_disable_subheader'] ) && $meta_fields['zn_disable_subheader'] == 'no' && isset ( $meta_fields['header_area'] ) && is_array( $meta_fields['header_area'] ) ) {
		zn_get_template_from_area( 'header_area', $post->ID, $meta_fields );
		return;
	}
	elseif ( ( ! empty( $data['zn_disable_subheader'] ) && $data['zn_disable_subheader'] == 'yes' ) ) {
		return;
	}
	elseif ( isset ( $meta_fields['header_area'] ) && is_array( $meta_fields['header_area'] ) ) {
		zn_get_template_from_area( 'header_area', $post->ID, $meta_fields );
		return;
	}
	elseif (is_404())
	{
		$style = 'uh_' . $data['404_header_style'];
?>
	<div id="page_header" class="<?php echo $style; ?> bottom-shadow">
		<div class="bgback"></div>
			<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
			<div class="zn_header_bottom_style"></div>
	</div>
	<?php
		return;
	}
	else{
		// THIS SHOULD BE THE LAST CHECK FOR PAGE HEADER
		if(empty($meta_fields)){
			if(empty($page_id)){
				$page_id = get_the_ID();
			}
			$meta_fields = get_post_meta( $page_id, 'zn_meta_elements', true );
			$meta_fields = maybe_unserialize( $meta_fields );
		}
		WpkZn::displayPageHeader($znData, $page_id, $meta_fields);
	}
