<?php
/*--------------------------------------------------------------------------------------------------
	Products Presentation
--------------------------------------------------------------------------------------------------*/
function _woo_products( $options )
{
	global $woocommerce;
	if ( empty( $woocommerce ) ) {
		return;
	}

	global $znData;
	if ( ! isset( $znData ) || empty( $znData ) ) {
		$znData = get_option( OPTIONS );
	}

	$element_size = zn_get_size( $options['_sizer'] );
	$randId = rand( 1, 10000 );
	?>
	<div class="<?php echo (isset($element_size['sizer']) ? $element_size['sizer'] : '');?>">
		<div class="shop-latest">
			<div class="tabbable">
				<ul class="nav fixclear">
					<?php
						/*
						 * Set the title for each tab
						 */
$featuredProductsTabTitle    = ((isset($options['woo_fp_title']) && !empty($options['woo_fp_title'])) ? $options['woo_fp_title'] :	__("FEATURED PRODUCTS", THEMENAME ));
$latestProductsTabTitle      = ((isset($options['woo_lp_title']) && !empty($options['woo_lp_title'])) ? $options['woo_lp_title'] : __("LATEST PRODUCTS", THEMENAME ));
$bestSellingProductsTabTitle = ((isset($options['woo_bsp_title']) && !empty($options['woo_bsp_title'])) ? $options['woo_bsp_title'] : __( "BEST SELLING PRODUCTS", THEMENAME ));
						/*
						 * Get all product category Ids. They will be used if there are no categories selected in the
						 *  Page Builder element
						 */
						if(isset($options['woo_categories']) && !empty($options['woo_categories'])){
							$productCategoryIds = $options['woo_categories'];
						}
						else { $productCategoryIds = WpkZn::getAllProductCategories(); }

						/*
						 * Set active tab
						 */
						$active1 = $active2 = $active3 = '';
						// Whether or not the active tab has been set
						$set = false;

						//# Featured products
						if($options['woo_fp_prod'] == '1'){
							$active1 = 'active';
							$set = true;
							echo '<li class="active"><a href="#tabpan1_' . $randId . '" data-toggle="tab">' . $featuredProductsTabTitle . '</a></li>';
						}

						//# Latest Products
						if($options['woo_lp_prod'] == '1'){
							if(! $set) {
								$set = true;
								$active2 = 'active';
							}
							echo '<li class="'.$active2.'"><a href="#tabpan2_' . $randId . '" data-toggle="tab">' . $latestProductsTabTitle . '</a></li>';
						}

						//# Best Selling Products
						if($options['woo_bs_prod'] == '1'){
							if(! $set) {
								$set = true;
								$active3 = 'active';
							}
							echo '<li class="'.$active3.'"><a href="#tabpan3_' . $randId . '" data-toggle="tab">' . $bestSellingProductsTabTitle . '</a></li>';
						}
					?>
				</ul>
			<div class="tab-content">
				<?php
					/*
					 * FEATURED PRODUCTS
					 */
					if (isset($options['woo_fp_prod']) && !empty($options['woo_fp_prod'])) {
						?>
						<div class="tab-pane <?php echo $active1;?>" id="tabpan1_<?php echo $randId; ?>">
							<div class="shop-latest-carousel">
								<ul id="featured_products">
									<?php
										$query_args = array (
											'posts_per_page' => (isset($options['prods_per_page']) ?
												$options['prods_per_page'] : get_option('posts_per_page')),
											'no_found_rows'  => 1,
											'post_status'    => 'publish',
											'post_type'      => 'product',
											'meta_key'       => '_featured',
											'meta_value'     => 'yes',
										);

										$r = new WP_Query( $query_args );

										if ( $r->have_posts() ) {
											while ( $r->have_posts() ) {
												$r->the_post();
												global $product;

												// bail
												if ( ! isset( $product ) || empty( $product ) || ! is_object( $product ) ) {
													continue;
												}

												/* CHECK STOCK */
												if ( ! $product->is_in_stock() ) {

													$zlink = '<a href="' . apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ) . '" class="">' . apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', THEMENAME ) ) . '</a>';
												}
												else {
													switch ( $product->product_type ) {
														case "variable" :
															$link  = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
															$label = apply_filters( 'variable_add_to_cart_text', __( 'Select options', THEMENAME ) );
															break;
														case "grouped" :
															$link  = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
															$label = apply_filters( 'grouped_add_to_cart_text', __( 'View options', THEMENAME ) );
															break;
														case "external" :
															$link  = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
															$label = apply_filters( 'external_add_to_cart_text', __( 'Read More', THEMENAME ) );
															break;
														default :
															$link  = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
															$label = apply_filters( 'add_to_cart_text', __( 'ADD TO CART', THEMENAME ) );
															break;
													}

													$zlink = '<a href="' . $link . '" rel="nofollow" data-product_id="' . $product->id . '" class="add_to_cart_button product_type_' . $product->product_type . '">' . $label . '</a>';
												}
												$new_badge = '';

												/* CHECK BADGE */
												if ( $znData['woo_new_badge'] == 1 ) {

													$now  = time();
													$diff = ( get_the_time( 'U' ) > $now ) ? get_the_time( 'U' ) - $now : $now - get_the_time( 'U' );
													$val  = floor( $diff / 86400 );
													$days = floor( get_the_time( 'U' ) / ( 86400 ) );

													if ( $znData['woo_new_badge_days'] >= $val ) {
														$new_badge = '<span class="znew">' . __( 'NEW!', THEMENAME ) . '</span>';
													}
												}
												/* CHECK ON SALE */
												$on_sale = '';
												if ( $product->is_on_sale() && $product->is_in_stock() ) {
													$on_sale = '<span class="zonsale">' . __( 'SALE!', THEMENAME ) . '</span>';
												}
												?>
												<li>
													<div class="product-list-item ">
														<span class="hover"></span>

														<div class="zn_badge_container">
															<?php echo $on_sale; ?>
															<?php echo $new_badge; ?>
														</div>
														<?php
															/**
															 * woocommerce_before_shop_loop_item_title hook
															 *
															 * @hooked woocommerce_template_loop_product_thumbnail - 10
															 */
															do_action( 'woocommerce_before_shop_loop_item_title' );
														?>
														<div class="details fixclear">
															<h3>
																<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
															</h3>

															<?php
																if ( ! isset( $znData['woo_hide_small_desc'] ) || ( isset( $znData['woo_hide_small_desc'] ) && $znData['woo_hide_small_desc'] == 'no' ) ) {
																	echo apply_filters( 'woocommerce_short_description', get_the_excerpt() );
																}
															?>

															<div class="actions">
																<?php if ( empty( $znData['woo_catalog_mode'] ) || ( ! empty( $znData['woo_catalog_mode'] ) && $znData['woo_catalog_mode'] == 'no' ) ) {
																	echo $zlink;
																} ?>
																<a href="<?php echo get_permalink(); ?>"><?php _e( "MORE INFO", THEMENAME ); ?></a>
															</div>

															<?php if ( $price_html = $product->get_price_html() ) : ?>
																<div class="price"><?php echo $price_html; ?></div>
															<?php endif; ?>

														</div>
													</div>
													<!-- end product-item -->
												</li>
											<?php
											}
										}
										// Reset the global $the_post as this query will have stomped on it
										wp_reset_query();
									?>
								</ul>
								<!-- shop product list -->
								<div class="controls">
									<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
									<a href="#" class="next"><span class="icon-chevron-right"></span></a>
								</div>
								<div class="clear"></div>
							</div>
							<!--end shop-featured-carousel -->
						</div>
						<!-- end tab pane -->
					<?php
					}
					/*
					 * LATEST PRODUCTS
					 */
					if (isset($options['woo_lp_prod']) && !empty($options['woo_lp_prod'])) {
				?>
					<div class="tab-pane <?php echo $active2;?>" id="tabpan2_<?php echo $randId; ?>">
						<div class="shop-latest-carousel">
							<ul id="latest_products">
								<?php

									$query_args = array (
										'posts_per_page' => (isset($options['prods_per_page']) ?
											$options['prods_per_page'] : get_option('posts_per_page')),
										'tax_query'      => array (
											array (
												'taxonomy' => 'product_cat',
												'field'    => 'id',
												'terms'    => $productCategoryIds,
											)
										),
										'no_found_rows'  => 1,
										'post_status'    => 'publish',
										'post_type'      => 'product'
									);

									$r = new WP_Query( $query_args );

									if ( $r->have_posts() ) {
										while ( $r->have_posts() ) {
											$r->the_post();
											global $product;

											// bail
											if ( ! isset( $product ) || empty( $product ) || ! is_object( $product ) ) {
												continue;
											}

											/* CHECK STOCK */
											if ( ! $product->is_in_stock() ) {

												$zlink = '<a href="' . apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ) . '" class="">' . apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', THEMENAME ) ) . '</a>';
											}
											else {
												switch ( $product->product_type ) {
													case "variable" :
														$link  = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
														$label = apply_filters( 'variable_add_to_cart_text', __( 'Select options', THEMENAME ) );
														break;
													case "grouped" :
														$link  = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
														$label = apply_filters( 'grouped_add_to_cart_text', __( 'View options', THEMENAME ) );
														break;
													case "external" :
														$link  = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
														$label = apply_filters( 'external_add_to_cart_text', __( 'Read More', THEMENAME ) );
														break;
													default :
														$link  = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
														$label = apply_filters( 'add_to_cart_text', __( 'ADD TO CART', THEMENAME ) );
														break;
												}

												$zlink = '<a href="' . $link . '" rel="nofollow" data-product_id="' . $product->id . '" class="add_to_cart_button product_type_' . $product->product_type . '">' . $label . '</a>';
											}
											$new_badge = '';

											/* CHECK BADGE */
											if ( $znData['woo_new_badge'] == 1 ) {

												$now  = time();
												$diff = ( get_the_time( 'U' ) > $now ) ? get_the_time( 'U' ) - $now : $now - get_the_time( 'U' );
												$val  = floor( $diff / 86400 );
												$days = floor( get_the_time( 'U' ) / ( 86400 ) );

												if ( $znData['woo_new_badge_days'] >= $val ) {
													$new_badge = '<span class="znew">' . __( 'NEW!', THEMENAME ) . '</span>';
												}
											}
											/* CHECK ON SALE */
											$on_sale = '';
											if ( $product->is_on_sale() && $product->is_in_stock() ) {
												$on_sale = '<span class="zonsale">' . __( 'SALE!', THEMENAME ) . '</span>';
											}
											?>
											<li>
												<div class="product-list-item ">
													<span class="hover"></span>

													<div class="zn_badge_container">
														<?php echo $on_sale; ?>
														<?php echo $new_badge; ?>
													</div>
													<?php
														/**
														 * woocommerce_before_shop_loop_item_title hook
														 *
														 * @hooked woocommerce_template_loop_product_thumbnail - 10
														 */
														do_action( 'woocommerce_before_shop_loop_item_title' );
													?>
													<div class="details fixclear">
														<h3>
															<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
														</h3>

														<?php
															if ( ! isset( $znData['woo_hide_small_desc'] ) || ( isset( $znData['woo_hide_small_desc'] ) && $znData['woo_hide_small_desc'] == 'no' ) ) {
																echo apply_filters( 'woocommerce_short_description', get_the_excerpt() );
															}
														?>

														<div class="actions">
															<?php if ( empty( $znData['woo_catalog_mode'] ) || ( ! empty( $znData['woo_catalog_mode'] ) && $znData['woo_catalog_mode'] == 'no' ) ) {
																echo $zlink;
															} ?>
															<a href="<?php echo get_permalink(); ?>"><?php _e( "MORE INFO", THEMENAME ); ?></a>
														</div>

														<?php if ( $price_html = $product->get_price_html() ) : ?>
															<div class="price"><?php echo $price_html; ?></div>
														<?php endif; ?>

													</div>
												</div>
												<!-- end product-item -->
											</li>
										<?php
										}
									}
									// Reset the global $the_post as this query will have stomped on it
									wp_reset_query();
								?>
							</ul>
							<!-- shop product list -->
							<div class="controls">
								<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
								<a href="#" class="next"><span class="icon-chevron-right"></span></a>
							</div>
							<div class="clear"></div>
						</div>
						<!--end shop-latest-carousel -->
					</div>
					<!-- end tab pane -->
				<?php
					}
					/*
					 * BEST SELLING
					 */
					if ( isset($options['woo_bs_prod']) && !empty($options['woo_bs_prod']) ) {
				?>
						<div class="tab-pane <?php echo $active3; ?>" id="tabpan3_<?php echo $randId; ?>">

							<div class="shop-latest-carousel">
								<ul id="bestselling_products">
									<?php

										$query_args = array (
											'posts_per_page' => (isset($options['prods_per_page']) ?
												$options['prods_per_page'] : get_option('posts_per_page')),
											'tax_query'      => array (
												array (
													'taxonomy' => 'product_cat',
													'field'    => 'id',
													'terms'    => $productCategoryIds,
												)
											),
											'no_found_rows'  => 1,
											'post_status'    => 'publish',
											'post_type'      => 'product',
											'meta_key'       => 'total_sales',
											'orderby'        => 'meta_value'
										);


										$r = new WP_Query( $query_args );

										if ( $r->have_posts() ) {

											while ( $r->have_posts() ) {
												$r->the_post();
												global $product, $znData;

												// bail
												if ( ! isset( $product ) || empty( $product ) || ! is_object( $product ) ) {
													continue;
												}

												/* CHECK STOCK */
												if ( ! $product->is_in_stock() ) {

													$zlink = '<a href="' . apply_filters( 'out_of_stock_add_to_cart_url', get_permalink( $product->id ) ) . '" class="">' . apply_filters( 'out_of_stock_add_to_cart_text', __( 'Read More', THEMENAME ) ) . '</a>';
												}
												else { ?>

													<?php

													switch ( $product->product_type ) {
														case "variable" :
															$link  = apply_filters( 'variable_add_to_cart_url', get_permalink( $product->id ) );
															$label = apply_filters( 'variable_add_to_cart_text', __( 'Select options', THEMENAME ) );
															break;
														case "grouped" :
															$link  = apply_filters( 'grouped_add_to_cart_url', get_permalink( $product->id ) );
															$label = apply_filters( 'grouped_add_to_cart_text', __( 'View options', THEMENAME ) );
															break;
														case "external" :
															$link  = apply_filters( 'external_add_to_cart_url', get_permalink( $product->id ) );
															$label = apply_filters( 'external_add_to_cart_text', __( 'Read More', THEMENAME ) );
															break;
														default :
															$link  = apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) );
															$label = apply_filters( 'add_to_cart_text', __( 'ADD TO CART', THEMENAME ) );
															break;
													}

													$zlink = '<a href="' . $link . '" rel="nofollow" data-product_id="' . $product->id . '" class="add_to_cart_button product_type_' . $product->product_type . '">' . $label . '</a>';
												}

												/* CHECK BADGE */
												if ( $znData['woo_new_badge'] ) {

													$now  = time();
													$diff = ( get_the_time( 'U' ) > $now ) ? get_the_time( 'U' ) - $now : $now - get_the_time( 'U' );
													$val  = floor( $diff / 86400 );
													$days = floor( get_the_time( 'U' ) / ( 86400 ) );

													if ( $znData['woo_new_badge_days'] >= $val ) {
														$new_badge = '<span class="znew">' . __( 'NEW!', THEMENAME ) . '</span>';
													}
												}
												/* CHECK ON SALE */
												$on_sale = '';
												if ( $product->is_on_sale() ) {
													$on_sale = '<span class="zonsale">' . __( 'SALE!', THEMENAME ) . '</span>';
												}
												?>
												<li>
													<div class="product-list-item ">
														<span class="hover"></span>

														<div class="zn_badge_container">
															<?php echo( isset( $on_sale ) ? $on_sale : '' ); ?>
															<?php echo( isset( $new_badge ) ? $new_badge : '' ); ?>
														</div>
														<?php
															/**
															 * woocommerce_before_shop_loop_item_title hook
															 *
															 * @hooked woocommerce_template_loop_product_thumbnail - 10
															 */
															do_action( 'woocommerce_before_shop_loop_item_title' );
														?>
														<div class="details fixclear">
															<h3>
																<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
															</h3>
															<?php
																if ( ! isset( $znData['woo_hide_small_desc'] ) || ( isset( $znData['woo_hide_small_desc'] ) && $znData['woo_hide_small_desc'] == 'no' ) ) {
																	echo apply_filters( 'woocommerce_short_description', get_the_excerpt() );
																}
															?>
															<div class="actions">
																<?php if ( empty( $znData['woo_catalog_mode'] ) || ( ! empty( $znData['woo_catalog_mode'] ) && $znData['woo_catalog_mode'] == 'no' ) ) {
																	echo $zlink;
																} ?>
																<a href="<?php echo get_permalink(); ?>"><?php _e( "MORE INFO", THEMENAME ); ?></a>
															</div>

															<?php if ( $price_html = $product->get_price_html() ) : ?>
																<div
																	class="price"><?php echo $price_html; ?></div>
															<?php endif; ?>

														</div>
													</div>
													<!-- end product-item -->
												</li>
											<?php
											}
										}
										// Reset the global $the_post as this query will have stomped on it
										wp_reset_query();
									?>
								</ul>
								<!-- shop product list -->
								<div class="controls">
									<a href="#" class="prev"><span class="icon-chevron-left"></span></a>
									<a href="#" class="next"><span class="icon-chevron-right"></span></a>
								</div>
								<div class="clear"></div>
							</div>
							<!--end shop-latest-carousel -->

						</div><!-- end tab pane -->
				<?php
					}
				?>
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- /.tabbable -->
		</div>
		<!-- end shop latest -->
	</div>
	<?php
}
