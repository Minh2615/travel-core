<?php
/**
 * The template for displaying search room results api v2.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/search/results-v2.php.
 *
 * @author  ThimPress, leehld
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( empty( $product_ids ) || empty( $atts ) ) {
	return;
}
?>
<ul class="list-tour-search">
	<?php 
	foreach ( $product_ids as $product_id ) { 
		$product = wc_get_product($product_id);
		?>
		<li class="tour-item">
			<div class="left-tour-item">
				<a href="<?php echo get_permalink($product_id); ?>">
					<img src="<?php echo get_the_post_thumbnail_url($product_id); ?>" alt="<?php echo get_the_title(); ?>">
				</a>
			</div>
			<div class="right-tour-item">
				<h2 class="title-toure"><?php echo get_the_title($product_id); ?></h2>
				<div clsss="price-tour">
					<span>Giá : <?php echo wc_price($product->get_price()); ?></span>
				</div>
			</div>
		</li>
	<?php } ?>
</ul>