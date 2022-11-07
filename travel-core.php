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
define( 'TRAVEL_CORE_URL', plugin_dir_url(__FILE__) );

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
//			add_action('template_include', array( $this, 'template_include' ), 10, 1 );

			add_action( 'wp_print_scripts', array( $this, 'global_js' ) );

			//enque admin srcipt
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			//save meta box tour int single ks
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 10 , 1 );
			add_action( 'save_post', array( $this, 'save' ), 10, 1 );
			add_action( 'delete_post', array( $this, 'delete_list_room' ), 10, 1 );
			add_action( 'wp_trash_post', array( $this, 'delete_list_room' ), 10, 1 );
		}
		
		public function delete_list_room($post_id){
			//delete post meta
			$list_rooms = get_post_meta( $post_id, 'travel_list_rooms', true );
			if( !empty($list_rooms)){
				foreach ($list_rooms as $room_id){
					$hotel_id = get_post_meta( $room_id, 'travel_hotel_id', true );
					if ( ! empty( $hotel_id ) ) {
						delete_post_meta( $room_id, 'travel_hotel_id');

					}
				}
			}
			delete_post_meta( $post_id , 'travel_list_rooms');
		}
		
		public function add_meta_box( $post_type ) {
			$post_types = array( 'khach-san' );

			if ( in_array( $post_type, $post_types ) ) {
				add_meta_box(
					'list_hotel_rooms',
					__( 'List Room', 'textdomain' ),
					array( $this, 'render_meta_box_content' ),
					$post_type,
					'advanced',
					'high'
				);
			}
		}

		public function render_meta_box_content($post) { 

			wp_nonce_field( 'myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce' );
			$list_ids = array();
			$args = array(
				'post_type' => 'hotel-room',
				'posts_per_page' => -1,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$hotel_id = get_post_meta( get_the_ID(), 'travel_hotel_id', true );
				if ( empty( $hotel_id ) ) {
					$list_ids[] = get_the_ID();
				}
			endwhile;
			endif;

			// Reset Post Data
			wp_reset_postdata();

			$value = get_post_meta( $post->ID, 'travel_list_rooms', true ) ?: array();
			?>
			<div class="list_room">
				<select name="list_room[]" id="list_room" multiple="multiple">
					<?php if ( ! empty( $value ) );
						foreach( $value as $id ) {
							?>
							<option value="<?php echo $id; ?>" <?php echo in_array( $id, $value ) ? 'selected' : ''; ?> ><?php echo get_the_title($id); ?></option>
							<?php
						}
					?>
					<?php if ( !empty( $list_ids ) );
						foreach( $list_ids as $id ) {
							?>
							<option value="<?php echo $id; ?>" <?php echo in_array( $id, $value ) ? 'selected' : ''; ?> ><?php echo get_the_title($id); ?></option>
							<?php
						}
					?>
				</select>
			</div>
			<script>
				jQuery(document).ready(function($){
					$('#list_room').select2({width:'100%', allowClear: true,height:'50px',placeholder: 'Select Rooms'});

				});
			</script>
			<style>
				#list_hotel_rooms .select2-container--default.select2-container--open .select2-search__field {
					width: 100% !important;
					height: 40px;
					padding: 10px;
				}
			</style>
		<?php }
	
		public function save( $post_id ) {
			
			if ( !isset( $_POST['myplugin_inner_custom_box_nonce'] ) ) {
				return $post_id;
			}

			$nonce = $_POST['myplugin_inner_custom_box_nonce'];

			if ( ! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box' ) ) {
				return $post_id;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			// Check the user's permissions.
			if ( 'khach-san' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
				}
			}
			$room_ids  = $_POST['list_room'];
			$room_olds = get_post_meta( $post_id, 'travel_list_rooms', true );
			if ( ! empty( $room_olds ) ) {
				foreach ( $room_olds as $room_old ) {
					if ( ! in_array( $room_old, $room_ids ) ) {
						update_post_meta( $room_old, 'travel_hotel_id', '' );
					}
				}
			}
			if( ! empty( $room_ids ) ) {
				update_post_meta( $post_id, 'travel_list_rooms', $room_ids );
				foreach( $room_ids as $id ){
					update_post_meta( $id, 'travel_hotel_id', $post_id );
				}
			}else{
				$room_ids = get_post_meta( $post_id, 'travel_list_rooms', true );
				if( ! empty( $room_ids ) ) {
					foreach( $room_ids as $id ){
						update_post_meta( $id, 'travel_hotel_id', '' );
					}
				}
				update_post_meta( $post_id, 'travel_list_rooms', array() );
			}
			
		}

		public function admin_enqueue_scripts(){
			wp_enqueue_script( 'select2', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/js/lib/select2.min.js', array() );
			wp_enqueue_style( 'select2', plugins_url( '/', TRAVEL_CORE_FILE ) . 'assets/select2.min.css', array() );
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

			$labels_tax_dia_diem = array(
				'name'              => 'Thẻ',
				'singular_name'     => 'Thẻ',
				'search_items'      => 'Search Thẻ',
				'all_items'         => 'All Thẻ',
				'edit_item'         => 'Edit Thẻ',
				'update_item'       => 'Update Thẻ',
				'add_new_item'      => 'Add New Thẻ',
				'new_item_name'     => 'Add New Thẻ',
				'menu_name'         => 'Thẻ',
			);

			$args_tax_dia_diem = array(
				'hierarchical'           => false,
				'labels'                 => $labels_tax_dia_diem,
				'show_ui'                => true,
				'show_admin_column'      => true,
				'query_var'              => true,
				'rewrite'                => array( 'slug' => 'ks-tag' ),
				'show_in_quick_editbool' => true,
			);

			register_taxonomy( 'ks-tag', array( 'khach-san' ), $args_tax_dia_diem );

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

			//Room
			$args_hotel_room = array(
				'labels'             => array(
					'name'               => 'Rooms',
					'singular_name'      => 'Rooms',
					'menu_name'          => 'Rooms',
					'parent_item_colon'  => 'Parent Rooms:',
					'all_items'          => 'Rooms',
					'view_item'          => 'View Rooms',
					'add_new_item'       => 'Thêm mới',
					'add_new'            => 'Thêm mới',
					'edit_item'          => 'Edit Rooms',
					'update_item'        => 'Update Rooms',
					'search_items'       => 'Search Rooms',
					'not_found'          => 'No Rooms found',
					'not_found_in_trash' => 'No Rooms found in Trash',
				),
				'public'             => true,
				'query_var'          => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'has_archive'        => true,
				'map_meta_cap'       => true,
				'show_in_admin_bar'  => true,
				'show_in_nav_menus'  => true,
				'rewrite'            => array( 'slug' => 'hotel-room' ),
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'menu_icon'          => 'dashicons-cloud-saved',
				'menu_position'      => 6,
				'hierarchical'       => false,
			);
			register_post_type( 'hotel-room', $args_hotel_room );

			$labels_tax_room_tag = array(
				'name'              => 'Thẻ',
				'singular_name'     => 'Thẻ',
				'search_items'      => 'Search Thẻ',
				'all_items'         => 'All Thẻ',
				'edit_item'         => 'Edit Thẻ',
				'update_item'       => 'Update Thẻ',
				'add_new_item'      => 'Add New Thẻ',
				'new_item_name'     => 'Add New Thẻ',
				'menu_name'         => 'Thẻ',
			);

			$args_tax_room_tag = array(
				'hierarchical'           => false,
				'labels'                 => $labels_tax_room_tag,
				'show_ui'                => true,
				'show_admin_column'      => true,
				'query_var'              => true,
				'rewrite'                => array( 'slug' => 'room-tag' ),
				'show_in_quick_editbool' => true,
			);

			register_taxonomy( 'room-tag', array( 'hotel-room' ), $args_tax_room_tag );

			//Tour
			$args_tour = array(
				'labels'             => array(
					'name'               => 'Tours',
					'singular_name'      => 'Tours',
					'menu_name'          => 'Tours',
					'parent_item_colon'  => 'Parent Tours:',
					'all_items'          => 'Tours',
					'view_item'          => 'View Tours',
					'add_new_item'       => 'Thêm mới',
					'add_new'            => 'Thêm mới',
					'edit_item'          => 'Edit Tours',
					'update_item'        => 'Update Tours',
					'search_items'       => 'Search Tours',
					'not_found'          => 'No Tours found',
					'not_found_in_trash' => 'No Rooms found in Trash',
				),
				'public'             => true,
				'query_var'          => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'has_archive'        => true,
				'map_meta_cap'       => true,
				'show_in_admin_bar'  => true,
				'show_in_nav_menus'  => true,
				'rewrite'            => array( 'slug' => 'travel-tour' ),
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'menu_icon'          => 'dashicons-cloud-saved',
				'menu_position'      => 6,
				'hierarchical'       => false,
			);
			register_post_type( 'travel-tour', $args_tour );

			//tax tour
			$labels_tax_tour = array(
				'name'              => 'Địa Điểm',
				'singular_name'     => 'Địa Điểm',
				'search_items'      => 'Search Địa Điểm',
				'all_items'         => 'All Địa Điểm',
				'parent_item'       => 'Parent Địa Điểm',
				'parent_item_colon' => 'Parent Địa Điểm',
				'edit_item'         => 'Edit Địa Điểm',
				'update_item'       => 'Update Địa Điểm',
				'add_new_item'      => 'Add New Địa Điểm',
				'new_item_name'     => 'Add New Địa Điểm',
				'menu_name'         => 'Địa Điểm',
			);
		
			$args_tax_tour = array(
				'hierarchical'           => true,
				'labels'                 => $labels_tax_tour,
				'show_ui'                => true,
				'show_admin_column'      => true,
				'query_var'              => true,
				'rewrite'                => array( 'slug' => 'map-tour' ),
				'show_in_quick_editbool' => true,
			);

			register_taxonomy( 'map-tour', array( 'travel-tour' ), $args_tax_tour );
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

			//post type room with woo
			include_once TRAVEL_CORE_PATH . '/inc/helper/woo/room-hotel/class-travel-room-woo.php';
			include_once TRAVEL_CORE_PATH . '/inc/helper/woo/room-hotel/class-travel-room-order.php';
			include_once TRAVEL_CORE_PATH . '/inc/helper/woo/room-hotel/class-travel-room-hooks.php';
			Hotel_Room_WC_Hooks::instance();

			//post type tour with woo
			include_once TRAVEL_CORE_PATH . '/inc/helper/woo/tour-hotel/class-travel-tour-woo.php';
			include_once TRAVEL_CORE_PATH . '/inc/helper/woo/tour-hotel/class-travel-tour-order.php';
			include_once TRAVEL_CORE_PATH . '/inc/helper/woo/tour-hotel/class-travel-tour-hooks.php';

			Hotel_Tour_WC_Hooks::instance();
		}
		public function url_api_search(){
			if(is_page('search-hotel')){
				$url_api = 'search-hotel';
			}else if(is_page('search-tour')){
				$url_api = 'search-tour';
			}else{
				$url_api = 'search-hotel';
			}
			return $url_api;
		}
		public function url_page_search(){
			if(is_singular('travel-tour')){
				$url_search = home_url( '/search-tour' );
			}else if(is_home()){
				$url_search = home_url( '/search-hotel' );
			}else{
				$url_search = home_url( '/search-hotel' );
			}
			return $url_search;
		}
		/**
		 * It enqueues the style-ramdom style sheet.
		 */
		public function enqueue_scripts() {
			$v = rand();
			$dependencies = array(
				'jquery',
				'jquery-ui-sortable',
				'jquery-ui-datepicker',
				'wp-util',
				'wp-api-fetch',
			);

			wp_enqueue_script( 'custom-script-travel-nk', plugins_url( '/', TRAVEL_CORE_FILE ) . 'build/js/index.js', $dependencies , $v, true );
			wp_localize_script(
				'custom-script-travel-nk',
				'custom_script_travel',
				array(
					'is_search_ks' => is_page( 'search-hotel' ),
					'is_search_tour' => is_page( 'search-tour' ),
					'is_archive_ks' => is_post_type_archive( 'khach-san' ),
					'url_api' => $this->url_api_search(),
					'url_page_search' => $this->url_page_search(),
				)
			);
			wp_enqueue_style( 'custom-style-travel-nk', plugins_url( '/', TRAVEL_CORE_FILE ) . 'build/css/style.css', array(), '1.0.0', '' );
			//font awesome
			wp_enqueue_style( 'fontawesome', plugins_url( '/', TRAVEL_CORE_FILE ) . 'assets/font-awesome.min.css', array() );

			if( is_singular('khach-san') ){
				wp_enqueue_script( 'fanctybox', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/js/lib/jquery.fancybox-1.3.4.js', array(), '1.3.4', true );
				wp_enqueue_style( 'fanctybox', plugins_url( '/', TRAVEL_CORE_FILE ) . 'assets/jquery.fancybox-1.3.4.css', array() );
			}
			//carousel
			wp_enqueue_style( 'carousel', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/css/lib/owl.carousel.min.css', array() );
			wp_enqueue_style( 'carousel-theme', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/css/lib/owl.theme.default.min.css', array() );
			wp_enqueue_script( 'carousel-js', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/js/lib/owl.carousel.min.js', array('jquery'), '2.3.4', true );

			//bs4
			wp_enqueue_style( 'bs4-css', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/css/lib/bootstrap.min.css', array() );

			//moment
			wp_enqueue_script( 'moment-js', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/js/lib/moment.min.js', array('jquery'), '2.3.4', true );

			//fullcalendar
			wp_enqueue_style( 'calendar-css', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/css/lib/fullcalendar.min.css', array() );
			wp_enqueue_script( 'calendar-js', plugins_url( '/', TRAVEL_CORE_FILE ) . 'src/js/lib/fullcalendar.min.js', array('jquery'), '2.3.4', true );

		}
	}

	new TRAVEL_CORE();
}

// custom shortcode
include __DIR__ . "/shortcodes/mix-search-form.php";

add_action("wp_enqueue_scripts", function () {
	wp_enqueue_style("vietnamairline", "https://www.vietnamaairlines.com/wp-content/themes/vietnamairlines/vinajet.css");
    wp_enqueue_script("vietnamairline", "https://cdn.vinajet.vn/plugins/tim-ve-bay-gia-re.min.js", array(), '1.0.0', true);
});

