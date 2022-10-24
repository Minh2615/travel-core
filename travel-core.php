<?php
/**
 * Plugin Name: Travel Core
 * Description: Use customized functions for your theme.
 * Author: MinhPD
 * Version: 1.0.0
 * Requires at least: 5.6
 * Tested up to: 6.0
 * Requires PHP: 7.0
 * text-domain: travel-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

const TRAVEL_CORE_FILE = __FILE__;
define( 'TRAVEL_CORE_PATH', dirname( __FILE__ ) );

if ( ! class_exists( 'TRAVEL_CORE' ) ) {
	class TRAVEL_CORE {

		public function __construct() {
			// Set Base name plugin.
			define( 'TRAVEL_CORE_BASENAME', plugin_basename( TRAVEL_CORE_FILE ) );
			// Check Woo activated .
			if ( ! $this->check_woo_activated() ) {
				return;
			}
			// Include files .
			add_action( 'init', array( $this, 'includes' ) );

			add_action('init' , array($this, 'tour_register_post_types'));

			//enqueue scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));

			//template include
			add_action('template_include', array( $this, 'template_include' ), 10, 1 );

			add_action( 'wp_print_scripts', array( $this, 'global_js' ) );
		}

		/**
		 * It creates a custom post type called "Khách Sạn" (Hotel) with a custom taxonomy called "Địa danh"
		 * (Location)
		 */
		public function tour_register_post_types( ) {
			$args_khach_san = array(
				'labels'             => array(
					'name'               => 'Khách Sạn',
					'singular_name'      => 'Khách Sạn',
					'menu_name'          => 'Khách Sạn',
					'parent_item_colon'  => 'Parent Item:',
					'all_items'          => 'Khách Sạn',
					'view_item'          => 'View Khách Sạn',
					'add_new_item'       => 'Thêm mới',
					'add_new'            => 'Thêm mới',
					'edit_item'          => 'Edit Khách Sạn',
					'update_item'        => 'Update Khách Sạn',
					'search_items'       => 'Search Khách Sạn',
					'not_found'          => 'No Khách Sạn found',
					'not_found_in_trash' => 'No Khách Sạn found in Trash',
				),
				'public'             => true,
				'query_var'          => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'has_archive'        => true,
				'map_meta_cap'       => true,
				'show_in_admin_bar'  => true,
				'show_in_nav_menus'  => true,
				'rewrite'            => array( 'slug' => 'khach-san' ),
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'menu_icon'          => 'dashicons-cloud-saved',
				'menu_position'      => 5,
				'hierarchical'       => false,
			);
			register_post_type( 'khach-san', $args_khach_san );

			$labels_tax_dia_diem = array(
				'name'              => 'Địa danh',
				'singular_name'     => 'Địa danh',
				'search_items'      => 'Search Địa danh',
				'all_items'         => 'All Địa danh',
				'parent_item'       => 'Parent Địa danh',
				'parent_item_colon' => 'Parent Địa danh:',
				'edit_item'         => 'Edit Địa danh',
				'update_item'       => 'Update Địa danh',
				'add_new_item'      => 'Add New Địa danh',
				'new_item_name'     => 'Add New Địa danh',
				'menu_name'         => 'Địa danh',
			);
		
			$args_tax_dia_diem = array(
				'hierarchical'           => true,
				'labels'                 => $labels_tax_dia_diem,
				'show_ui'                => true,
				'show_admin_column'      => true,
				'query_var'              => true,
				'rewrite'                => array( 'slug' => 'dia-diem' ),
				'show_in_quick_editbool' => true,
			);
		
			register_taxonomy( 'dia-diem', array( 'khach-san' ), $args_tax_dia_diem );

			$labels_tax_tien_nghi= array(
				'name'              => 'Tiện nghi',
				'singular_name'     => 'Tiện nghi',
				'search_items'      => 'Search Tiện nghi',
				'all_items'         => 'All Tiện nghi',
				'parent_item'       => 'Parent Tiện nghi',
				'parent_item_colon' => 'Parent Tiện nghi',
				'edit_item'         => 'Edit Tiện nghi',
				'update_item'       => 'Update Tiện nghi',
				'add_new_item'      => 'Add New Tiện nghi',
				'new_item_name'     => 'Add New Tiện nghi',
				'menu_name'         => 'Tiện nghi',
			);
		
			$args_tax_tien_nghi = array(
				'hierarchical'           => true,
				'labels'                 => $labels_tax_tien_nghi,
				'show_ui'                => true,
				'show_admin_column'      => true,
				'query_var'              => true,
				'rewrite'                => array( 'slug' => 'tien-nghi' ),
				'show_in_quick_editbool' => true,
			);
		
			register_taxonomy( 'tien-nghi', array( 'khach-san' ), $args_tax_tien_nghi );

			$labels_tax_loai_phong = array(
				'name'              => 'Loại phòng',
				'singular_name'     => 'Loại phòng',
				'search_items'      => 'Search Loại phòng',
				'all_items'         => 'All Loại phòng',
				'parent_item'       => 'Parent Loại phòng',
				'parent_item_colon' => 'Parent Loại phòng',
				'edit_item'         => 'Edit Loại phòng',
				'update_item'       => 'Update Loại phòng',
				'add_new_item'      => 'Add New Loại phòng',
				'new_item_name'     => 'Add New Loại phòng',
				'menu_name'         => 'Loại phòng',
			);
		
			$args_tax_loai_phong = array(
				'hierarchical'           => true,
				'labels'                 => $labels_tax_loai_phong,
				'show_ui'                => true,
				'show_admin_column'      => true,
				'query_var'              => true,
				'rewrite'                => array( 'slug' => 'loai-phong' ),
				'show_in_quick_editbool' => true,
			);
		
			register_taxonomy( 'loai-phong', array( 'khach-san' ), $args_tax_loai_phong );
		}

		/**
		 * Output global js settings
		 */
		public function global_js() {
			?>
			<script type="text/javascript">
				var hotel_settings = {
					url_page_search : '<?php echo home_url('/search-tours'); ?>',
					wphb_rest_url : '<?php echo get_rest_url(); ?>',
				}
			</script>
			<?php
		}

		/**
		 * If the current page is the search-tour page, then load the page-search-tour.php template
		 * 
		 * @param template The path to the template file.
		 * 
		 * @return The template file for the search tour page.
		 */
		public function template_include( $template ){
			if ( is_page('search-hotel') ){
				return TRAVEL_CORE_PATH . '/templates/page-search-hotel.php';
			}
			return $template;
		}

		/**
		 * Check plugin Woo activated.
		 */
		public function check_woo_activated(): bool {
			// Include files.
			include_once ABSPATH . 'wp-admin/includes/plugin.php';

			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				add_action( 'admin_notices', array( $this, 'show_note_errors_install_plugin_woo' ) );

				deactivate_plugins( TRAVEL_CORE_BASENAME );

				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}

				return false;
			}

			return true;
		}

		/**
		 * If the WooCommerce plugin is not active, display a notice on the admin dashboard
		 */
		public function show_note_errors_install_plugin_woo() {
			?>
			<div class="notice notice-error">
				<p><?php echo 'Please active plugin <strong>Woocomerce</strong> before active plugin <strong>Theme-Core</strong>'; ?></p>
			</div>
			<?php
		}


		/**
		 * include need files
		 */
		public function includes() {
			include_once WC_ABSPATH . 'includes/abstracts/abstract-wc-product.php';
			// api
			include_once TRAVEL_CORE_PATH . '/inc/rest-api/class-theme-core-api.php';
			//functions
			include_once TRAVEL_CORE_PATH . '/inc/functions.php';
		}

		/**
		 * It enqueues the style-ramdom style sheet.
		 */
		public function enqueue_scripts() {
			if ( is_page('search-hotel' ) ){
				$dependencies = array(
					'jquery',
					'jquery-ui-sortable',
					'jquery-ui-datepicker',
					'wp-util',
					'wp-api-fetch',
				);
				wp_enqueue_script( 'custom-script-travel-nk', plugins_url( '/', TRAVEL_CORE_FILE ) . 'build/js/index.js', $dependencies , '1.0.0', true );
			}
			wp_enqueue_style( 'custom-style-travel-nk', plugins_url( '/', TRAVEL_CORE_FILE ) . 'build/css/style.css', array(), '1.0.0', '' );
			
		}
	}

	new TRAVEL_CORE();
}

