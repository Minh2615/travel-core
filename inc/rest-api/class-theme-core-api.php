<?php
defined( 'ABSPATH' ) || exit();

class Travel_Core_Api {

	private static $instance;
	/**
	 * @var string
	 */
	public $namespace = 'travel-core/v1';

	/**
	 * @var string
	 */
	public $rest_base = '';

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'search-tours',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'search_tours' ),
				'permission_callback' => '__return_true',
			),
		);
		register_rest_route(
			$this->namespace,
			'add-to-cart',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'add_to_cart' ),
				'permission_callback' => '__return_true',
			),
		);
	}

	public function add_to_cart( WP_REST_Request $request ) {
		wc_load_cart();
		$response     = new stdClass();
		$params       = $request->get_params();
		$price        = $params['price'] ?? 0;
		$id           = $params['id'] ?? 0;
		$quantity     = $params['quantity'] ?? 1;

		try {
			if ( empty( $id ) ) {
				throw new Exception( 'Phòng không hợp lệ, Vui lòng thử lại' );
			}
			$cart_id = WC()->cart->generate_cart_id(
				$id,
				0,
				array(),
				array(
					'info_rooms' => array(
						'price'    => $price,
						'quantity' => $quantity,
					),
				)
			);

			$cart_item_key = WC()->cart->find_product_in_cart( $cart_id );

			if ( $cart_item_key ) {
				$new_quantity = 1 + WC()->cart->cart_contents[ $cart_item_key ]['quantity'];
				WC()->cart->set_quantity( $cart_item_key, $new_quantity, false );
				WC()->cart->calculate_totals();
			} else {
				$cart_item_key = WC()->cart->add_to_cart(
					$id,
					1,
					0,
					array(),
					array(
						'info_rooms' => array(
							'price'    => $price,
							'quantity' => $quantity,
						),
					),
				);
			}

			if ( $cart_item_key ) {
				$response->status = 'success';
				$response->message = 'Thêm vào giỏ hàng thành công !';
				// if ( ! empty( $redirect ) ) {
				// 	$response->redirect = get_permalink( get_page_by_path( 'cart' ) );
				// } else {
				// 	$response->message = 'Thêm vào giỏ hàng thành công ! Tiếp tục mua hàng';
				// }
			}
		} catch ( Exception $e ) {
			$response->message = $e->getMessage();
		}

		return rest_ensure_response( $response );
		
	}

	public function search_tours(WP_REST_Request $request ){
		$response = new stdClass();
		$response->data = new stdClass();
		$params   = $request->get_params();
		$s = $params['s'] ?? '';
		$dia_diem = $params['dia_diem'] ?? '';
		$min_price = $params['min_price'] ?: 0;
		$max_price = $params['max_price'] ?: 10000000;
		$star = $params['star'] ?? 1;
		$loai_hinh = $params['loai_hinh'] ?? array();
		$tien_ich = $params['tien_ich'] ?? array();
		$paged = $params['paged'] ?? 1;

		try {
			$tax_query = array(
				'relation' => 'AND',
			);
			if( $loai_hinh ){
				$tax_query[] = array(
					'taxonomy'        => 'loai-phong',
					'field'           => 'term_id',
					'terms'           =>  $loai_hinh,
					'operator'        => 'IN',
				);
			}
			if( $tien_ich ){
				$tax_query[] = array(
					'taxonomy'        => 'tien-nghi',
					'field'           => 'term_id',
					'terms'           =>  $tien_ich,
					'operator'        => 'IN',
				);
			}
			if ( ! empty( $dia_diem ) ) {
				$args = array(
					'taxonomy'      => array( 'dia-diem' ), // taxonomy name
					'orderby'       => 'id', 
					'order'         => 'ASC',
					'hide_empty'    => true,
					'fields'        => 'all',
					'name__like'    => $dia_diem
				); 
				
				$terms = get_terms( $args );

				$list_dia_diem = array();

				if ( ! empty( $terms ) ) {
					foreach( $terms as $term){
						$list_dia_diem[] = $term->term_id;
					}
				}

				if ( ! empty( $list_dia_diem ) ) {
					$tax_query[] = array(
						'taxonomy' => 'dia-diem',
						'field'    => 'term_id',
						'terms'    =>  $list_dia_diem,
						'operator' => 'IN',
						);
				}
				$response->address = $dia_diem;
			}

			$meta_query = array(
				'relation' => 'AND',
				array(
					'key'     => 'price_ks',
					'value'   => array( $min_price, $max_price ),
					'compare' => 'BETWEEN',
					'type'    => 'NUMERIC',
				),
			);

			if(!empty($star)){
				$meta_query[] = array(
					'key'       => 'danh_gia',
					'value'     => array($star),
					'compare'   => 'IN',
				);
			}

			// The query
			$products = new WP_Query( array(
				'post_type'      => array('khach-san'),
				'post_status'    => 'publish',
				's'              => $s,
				'posts_per_page' => 6,
				'tax_query'      => $tax_query,
				'meta_query'     => $meta_query,
				'paged'          => $paged
			) );
			$product_ids = array();
			// The Loop
			if ( $products->have_posts() ): while ( $products->have_posts() ):
				$products->the_post();
				$product_ids[] = $products->post->ID;
			endwhile;
				wp_reset_postdata();
			endif;
			if ( !empty($product_ids) ) {
				
				$response->data->pagination = hb_get_template_content(
					'pagination.php',
					array(
						'total' => $products->max_num_pages,
						'paged' => $paged
					)
				);
				$response->data->content = hb_get_template_content(
					'results.php',
					array(
						'product_ids' => $product_ids,
						'atts'        => $params,
					)
				);
				$response->status = 'success';
				$response->message = 'success';
				$response->total = $products->found_posts;
				
			}else{
				$response->data->content = 'Không tìm thấy Khách Sạn phù hợp ! ';
			}

		} catch ( Exception $e ) {
			$response->status  = 'error';
			$response->message = $e->getMessage();
		}

		return rest_ensure_response( $response );
	}


	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Travel_Core_Api::instance();

