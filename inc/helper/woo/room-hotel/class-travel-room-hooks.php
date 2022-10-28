<?php

defined( 'ABSPATH' ) || exit();

class Hotel_Room_WC_Hooks {
	private static $instance;

	protected function __construct() {
		$this->hooks();
	}

	protected function hooks() {
		add_filter( 'woocommerce_get_order_item_classname', array( $this, 'get_classname_up_game_wc_order' ), 10, 3 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'order_item_line' ), 10, 4 );
		add_filter( 'woocommerce_product_class', array( $this, 'product_class' ), 10, 4 );
		add_filter( 'woocommerce_cart_needs_payment', '__return_false' );

		add_filter( 'woocommerce_checkout_order_processed', array( $this, 'order_received_empty_cart_action' ), 99, 1 );
	}

	public function order_received_empty_cart_action( $order_id ){
		WC()->cart->empty_cart();
	}
	/**
	 * Get the product class name.
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param int
	 *
	 * @return string
	 */
	public function product_class( $classname, $product_type, $post_type, $product_id ): string {
		if ( 'hotel-room' == get_post_type( $product_id ) ) {
			$classname = 'WC_Product_Rooms';
		}

		return $classname;
	}

	/**
	 * Add item line meta data contains our up_game_id from product_id in cart.
	 * Since WC 3.x order item line product_id always is 0 if it is not a REAL product.
	 * Need to track up_game_id for creating LP order in WC hook after this action.
	 *
	 * @param $item
	 * @param $cart_item_key
	 * @param $values
	 * @param $order
	 */
	public function order_item_line( $item, $cart_item_key, $values, $order ) {
		if ( 'hotel-room' === get_post_type( $values['product_id'] ) ) {
			$item->add_meta_data( '_hotel_room_id', $values['product_id'], true );
		}
	}

	/**
	 * Get classname WC_Order_Item_Hotel_Room
	 *
	 * @throws Exception
	 */
	public function get_classname_up_game_wc_order( $classname, $item_type, $id ) {
		if ( in_array( $item_type, array( 'line_item', 'product' ) ) ) {
			$hotel_room_id = wc_get_order_item_meta( $id, '_hotel_room_id' );
			if ( $hotel_room_id && 'hotel-room' == get_post_type( $hotel_room_id ) ) {
				$classname = 'WC_Order_Item_Hotel_Room';
			}
		}

		return $classname;
	}

	public static function instance(): Hotel_Room_WC_Hooks {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
