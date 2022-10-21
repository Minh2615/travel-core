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
	}	

	public function search_tours(WP_REST_Request $request ){
		$response = new stdClass();
		$response->data = new stdClass();
		$params   = $request->get_params();
		$s = $params['s'] ?? '';
		$nguoi_lon = $params['nguoi_lon'] ?? '';
		$tre_em = $params['tre_em'] ?? '';
		$dia_diem = $params['dia_diem'] ?? '';
		$so_phong = $params['so_phong'] ?? 1;
		$min_price = $params['min_price'] ?? 0;
		$max_price = $params['max_price'] ?? 0;
		$star = $params['star'] ?? 0;
		$loai_hinh = $params['loai_hinh'] ?? '';
		$tien_ich = $params['tien_ich'] ?? '';

		try {
			$tax_query = array(
				'relation' => 'AND',
			);
			if( $loai_hinh ){
				$tax_query[] = array(
					'taxonomy'        => 'pa_loai-hinh-noi-o',
					'field'           => 'term_id',
					'terms'           =>  array( $loai_hinh ),
					'operator'        => 'IN',
				);
			}
			if( $tien_ich ){
				$tax_query[] = array(
					'taxonomy'        => 'pa_tien-ich',
					'field'           => 'term_id',
					'terms'           =>  array( $tien_ich ),
					'operator'        => 'IN',
				);
			}
			// The query
			$products = new WP_Query( array(
				'post_type'      => array('product'),
				'post_status'    => 'publish',
				's'              => $s,
				'posts_per_page' => 5,
				'tax_query'      => $tax_query,
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
				$total_page = ceil( count( $product_ids ) / 5 );
				// $response->data->pagination = hb_get_template_content(
				// 	'search/v2/pagination-v2.php',
				// 	array(
				// 		'total' => $total_page,
				// 		'paged' => $results['page'],
				// 	)
				// );
				$response->data->content = hb_get_template_content(
					'results.php',
					array(
						'product_ids' => $product_ids,
						'atts'        => $params,
					)
				);
				$response->status = 'success';
				$response->message = 'success';
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

