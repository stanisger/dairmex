<?php
/**
 * The template for displaying content in the template-portfolio.php template
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

$layout = mfn_opts_get( 'portfolio-layout', 'one' );

$item_class = '';
$item_cats = get_the_terms($post->ID, 'portfolio-types');
if($item_cats){
	foreach($item_cats as $item_cat) {
		$item_class .= $item_cat->slug . ' ';
	}
}
?>

<li class="portfolio_item column <?php echo $layout.' '.$item_class?>" style="margin:0;">	
	<a href="<?php the_permalink(); ?>">
		<?php  the_post_thumbnail( 'portfolio-list', array('class'=>'scale-with-grid' )); ?>
		<div>
			<span class="ico"></span>
			<h6><?php echo the_title(false, false)?></h6>
		</div>
	</a>
</li>