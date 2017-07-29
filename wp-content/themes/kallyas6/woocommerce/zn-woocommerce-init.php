<?php
	global $znData;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}
	/*--------------------------------------------------------------------------------------------------
		REMOVE UNWANTED ACTIONS
	--------------------------------------------------------------------------------------------------*/
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

	/* add*/
	//add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);

	/*--------------------------------------------------------------------------------------------------
		SINGLE PRODUCT PAGE - Reorder metas
	--------------------------------------------------------------------------------------------------*/

	// ITEM META
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 10 );

	// ITEM PRICE
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 30 );

	// ITEM PRICE
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );

	if ( ! empty( $znData['woo_catalog_mode'] ) && $znData['woo_catalog_mode'] == 'yes' ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );
	}

	/* PRODUCT THUMBNAIL IN LOOP */
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'zn_woocommerce_template_loop_product_thumbnail', 10 );

	/*--------------------------------------------------------------------------------------------------
		PRODUCTS PAGE - FILTER IMAGE
	--------------------------------------------------------------------------------------------------*/

	if ( ! function_exists( 'zn_woocommerce_template_loop_product_thumbnail' ) ) {

		function zn_woocommerce_template_loop_product_thumbnail()
		{
			echo zn_woocommerce_get_product_thumbnail();
		}
	}

	if ( ! function_exists( 'zn_woocommerce_get_product_thumbnail' ) ) {

		function zn_woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0,
			$placeholder_height = 0 )
		{
			global $post, $woocommerce, $znData;
			if ( ! isset( $znData ) || empty( $znData ) ) {
				$znData = get_option( OPTIONS );
			}

			if ( ! $placeholder_width ) {
				if ( function_exists( 'wc_get_image_size' ) ) {
					$placeholder_width = wc_get_image_size( 'shop_catalog_image_width' );
				}
				else {
					$placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
				}
			}
			if ( ! $placeholder_height ) {
				if ( function_exists( 'wc_get_image_size' ) ) {
					$placeholder_height = wc_get_image_size( 'shop_catalog_image_height' );
				}
				else {
					$placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );
				}
			}
			
			$output = '<div class="image">';

			if ( has_post_thumbnail($post->ID) ) {
				$width  = 0;
				$height = 0;
				if ( ! empty( $znData['woo_cat_image_size'] ) ) {
					$width  = ((isset($znData['woo_cat_image_size']['width']) && !empty($znData['woo_cat_image_size']['width'])) ? $znData['woo_cat_image_size']['width'] : $width);
					$height = ((isset($znData['woo_cat_image_size']['height']) && !empty($znData['woo_cat_image_size']['height'])) ? $znData['woo_cat_image_size']['height'] : $height);
				}

				$image = vt_resize( get_post_thumbnail_id( $post->ID ), '', $width, $height, true );
                $imageUrl = $image['url'];
                if(empty($imageUrl)){
                    $img = get_the_post_thumbnail($post->ID, $width, $height, array(
                        'title' => $post->post_title,
                        'alt' => $post->post_title,
                    ));
                }
                else {
                    $img = '<img src="' . $imageUrl . '" alt="'.$post->post_title.'" title="'.$post->post_title.'">';
                }
			}
			else {
				$img = '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" width="' .
						   $placeholder_width['width'] . '" height="' . $placeholder_height['height'] . '" />';
			}

            //@k Display item in a link, regardless it has an image or not
            $output .= '<a href="' . get_permalink() . '">'.$img.'</a>';

            $output .= '</div>';
			
			return $output;
		}
	}

	/*--------------------------------------------------------------------------------------------------
		FILTER PRODUCT DESCRIPTION
	--------------------------------------------------------------------------------------------------*/
	function woo_short_desc_filter( $content )
	{

		$content = str_replace( '<p>', '<p class="desc">', $content );
		return $content;
	}

	add_filter( 'woocommerce_short_description', 'woo_short_desc_filter' );

	/*--------------------------------------------------------------------------------------------------
		FILTER PRODUCT PRICE
	--------------------------------------------------------------------------------------------------*/
	function zn_woocommerce_price_html( $content )
	{
		$content = str_replace( '<del><span class="amount">', '<small>', $content );
		$content = str_replace( '</span></del>', '</small>[zn_break]', $content );
		$content = str_replace( '<ins><span class="amount">', '<span>', $content );
		$content = str_replace( '</span></ins>', '</span>', $content );
		$content = explode( '[zn_break]', $content );
		$price = '';
		if ( ! empty ( $content[1] ) ) {
			$price .= $content[1];
		}
		if ( ! empty ( $content[0] ) ) {
			$price .= $content[0];
		}
		return $price;
	}

	add_filter( 'woocommerce_get_price_html', 'zn_woocommerce_price_html' );

	function zn_woocommerce_free_price_html( $content )
	{
		$content = '<span>' . $content . '</span>';
		return $content;
	}

	add_filter( 'woocommerce_free_price_html', 'zn_woocommerce_free_price_html' );

	/* UPDATE 3.5 */

	/*--------------------------------------------------------------------------------------------------
		LOOP PRODUCT PAGE - REMOVE THE ADD TO CART BUTTON FROM LOOP
	--------------------------------------------------------------------------------------------------*/
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

	/*--------------------------------------------------------------------------------------------------
	REPLACE THE WOOCOMMERCE PAGINATION
	--------------------------------------------------------------------------------------------------*/
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

	function zn_woocommerce_pagination()
	{
		zn_pagination();
	}

	add_action( 'woocommerce_pagination', 'zn_woocommerce_pagination', 10 );

	/**
	 * Set the number of products to be displayed per page in the shop
	 *
	 * @hooked to add_filter( 'loop_shop_per_page', 'wpkzn_woo_cat_posts_per_page', 100 );
	 * @wpk
	 * @since v3.6.5
	 *
	 * @return int|mixed|void
	 */
	function wpkzn_woo_show_posts_per_page(){
		global $znData;
		if(isset($znData['woo_show_products_per_page']) && ! empty($znData['woo_show_products_per_page'])){
			$znWooCatProductsPerPage = absint($znData['woo_show_products_per_page']);
			if(empty($znWooCatProductsPerPage)){
				$znWooCatProductsPerPage = get_option('posts_per_page');
			}
		}
		else { $znWooCatProductsPerPage = get_option('posts_per_page'); }
		return $znWooCatProductsPerPage;
	}

	add_filter( 'loop_shop_per_page', 'wpkzn_woo_show_posts_per_page', 100 );
