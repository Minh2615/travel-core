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

			//enqueue scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));

			//template include
			add_action('template_include', array( $this, 'template_include' ), 10, 1 );

			add_action( 'wp_print_scripts', array( $this, 'global_js' ) );
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
			if ( is_page('search-tours') ){
				return TRAVEL_CORE_PATH . '/templates/page-search-tours.php';
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
			$dependencies = array(
				'jquery',
				'jquery-ui-sortable',
				'jquery-ui-datepicker',
				'wp-util',
				'wp-api-fetch',
			);
			wp_enqueue_script( 'custom-script-travel-nk', plugins_url( '/', TRAVEL_CORE_FILE ) . 'build/js/index.js', $dependencies , '1.0.0', true );
			wp_enqueue_style( 'custom-style-travel-nk', plugins_url( '/', TRAVEL_CORE_FILE ) . 'build/css/style.css', array(), '1.0.0', '' );
		}
	}

	new TRAVEL_CORE();
}

