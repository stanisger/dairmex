<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       1.6.4
 */

global $znData;

//++ @kos
// Product (image + text)
$customWidthSpan_1 = 'span5';
// Product description
$customWidthSpan_2 = 'span9';
// Set the number of related products to be displayed by default
$wooShowNumProducts = 3;
// Verify the existence of the sidebars

$meta_fields = get_post_meta( $post->ID, 'zn_meta_elements', true );
$meta_fields = maybe_unserialize( $meta_fields );

$postSidebarPosition = (isset($meta_fields['page_layout']) && !empty($meta_fields['page_layout']) ? $meta_fields['page_layout'] : '');

if('no_sidebar' == $postSidebarPosition){
    $customWidthSpan_1 = 'span8';
    $customWidthSpan_2 = 'span12';
    $wooShowNumProducts = 4;
}
elseif('default' == $postSidebarPosition){
    if ( isset( $znData['woo_single_sidebar_position'] ) &&
         ! in_array( $znData['woo_single_sidebar_position'], array ('left_sidebar','right_sidebar') ) ) {
        $customWidthSpan_1 = 'span8';
        $customWidthSpan_2 = 'span12';
        $wooShowNumProducts = 4;
    }
}
//--
?>
<?php
/**
 * woocommerce_before_single_product hook
 *
 * @hooked woocommerce_show_messages - 10
 */
do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?> >

<div class="row product-page">

	<div class="span4">
		<?php
			/**
			 * woocommerce_show_product_images hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>
	</div>
	<div class="<?php echo $customWidthSpan_1; ?>">
		<div class="main-data">

			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>
		</div>
		<!-- end main data -->
	</div>
	<!-- .summary -->
</div>

    <!-- UPSELLS -->
<div class="row">
	<div class="<?php echo $customWidthSpan_2; ?>">
		<?php
			/*
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_output_related_products - 20
			 */
			// shows tabs: description + reviews, etc...
			woocommerce_output_product_data_tabs();
			// Display the appropriate number of products in rows of 1
			woocommerce_related_products( array (
				'posts_per_page' => $wooShowNumProducts,
				'columns'        => 1,
			) );

			/*
			 * Display upsells if any
			 * - removes duplicated product information
			 */
			global $product;
			$upsells = $product->get_upsells();

			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_output_related_products - 20
			 */
			if (empty($upsells))
			{
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			}
			else
			{
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
			do_action( 'woocommerce_after_single_product_summary' );

		?>
	</div>
</div>
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
