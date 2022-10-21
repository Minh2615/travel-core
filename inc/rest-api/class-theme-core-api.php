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
			'add-to-cart-up-game',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'add_to_cart_up_game' ),
				'permission_callback' => '__return_true',
			),
		);
		register_rest_route(
			$this->namespace,
			'add-to-cart-rank-level',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'add_to_cart_up_rank' ),
				'permission_callback' => '__return_true',
			),
		);
	}	

	public function remove_comment(WP_REST_Request $request ){
		$response = new stdClass();
		$params   = $request->get_params();
		$data     = $params['data'] ?? array();
		$id  = $data['id'] ?? 0;

		try {
			if ( empty($id ) ) {
				throw new Exception( 'Comment Không Hợp Lệ' );
			}

			if ( wp_delete_comment( $id ) ) {
				$response->status  = 'success';
				$response->message = 'Xoá Thành Công';
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

