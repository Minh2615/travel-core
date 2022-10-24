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
		?>
		<li class="tour-item">
			<div class="left-tour-item">
				<a href="<?php echo get_permalink($product_id); ?>">
					<img src="<?php echo get_the_post_thumbnail_url($product_id); ?>" alt="<?php echo get_the_title(); ?>">
				</a>
			</div>
			<div class="right-tour-item">
				<h2 class="title-tour">
					<a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title($product_id); ?></a>
				</h2>
				<p class="dia-chi"><?php echo get_field('dia_chi_khach_san'); ?></p>
				<ul class="tien-nghi">
					<?php $terms = get_the_terms( $product_id,'tien-nghi');
						if ( !empty( $terms ) ){
							foreach( $terms as $term ) { ?>
								<li><?php echo $term->name; ?></li>
						<?php }
						}
					?>
				</ul>
				<div class="price-tour">
					Giá:  <span><?php echo number_format( get_field( 'price_ks' ) ); ?> VNĐ</span>
				</div>
			</div>
		</li>
	<?php } ?>
</ul>