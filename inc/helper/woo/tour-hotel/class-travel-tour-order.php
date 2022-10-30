<?php

/**
 * @class WC_Order_Item_Travel_Tour
 */

defined( 'ABSPATH' ) || exit();
if ( class_exists( 'WC_Order_Item_Product' ) ) {
	class WC_Order_Item_Travel_Tour extends WC_Order_Item_Product {
		/**
		 * @throws Exception
		 */
		public function set_product_id( $value ) {
			if ( $value > 0 && 'travel-tour' !== get_post_type( absint( $value ) ) ) {
				$this->error( 'order_item_product_invalid_product_id', __( 'Invalid product ID', 'woocommerce' ) );
			}

			$travel_tour_id = wc_get_order_item_meta( $this->get_id(), '_trave_tour_id' );
			if ( 'travel-tour' == get_post_type( absint( $travel_tour_id ) ) ) {
				$value = $travel_tour_id;
			}

			$this->set_prop( 'product_id', absint( $value ) );
		}
	}
}

