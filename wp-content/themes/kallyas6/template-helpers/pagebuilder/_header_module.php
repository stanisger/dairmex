<?php
/*--------------------------------------------------------------------------------------------------
	Custom Header Layout
--------------------------------------------------------------------------------------------------*/
function _header_module( $options )
{
	global $znData, $post;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}

	$page_id     = 0;
	$meta_fields = null;
	if ( ! empty( $post ) ) {
		if ( strcasecmp( 'portfolio', get_post_type() ) == 0 ) {
			$k_postMeta = get_page_by_title( 'portfolio' );
			$page_id    = $k_postMeta->ID;
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

	if ( empty( $meta_fields ) ) {
		$meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
		$meta_fields = maybe_unserialize( $meta_fields );
	}

	WpkZn::displayPageHeader( $znData, $page_id, $meta_fields );
}
