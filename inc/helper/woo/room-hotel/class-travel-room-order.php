<?php

/**
 * @class WC_Order_Item_Hotel_Room
 */

defined( 'ABSPATH' ) || exit();
if ( class_exists( 'WC_Order_Item_Product' ) ) {
	class WC_Order_Item_Hotel_Room extends WC_Order_Item_Product {
		/**
		 * @throws Exception
		 */
		public function set_product_id( $value ) {
			if ( $value > 0 && 'hotel-room' !== get_post_type( absint( $value ) ) ) {
				$this->error( 'order_item_product_invalid_product_id', __( 'Invalid product ID', 'woocommerce' ) );
			}

			$hotel_room_id = wc_get_order_item_meta( $this->get_id(), '_hotel_room_id' );
			if ( 'hotel-room' == get_post_type( absint( $hotel_room_id ) ) ) {
				$value = $hotel_room_id;
			}

			$this->set_prop( 'product_id', absint( $value ) );
		}
	}
}

