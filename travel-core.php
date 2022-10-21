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
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ));

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

		public function show_note_errors_install_plugin_woo() {
			?>
			<div class="notice notice-error">
				<p><?php echo 'Please active plugin <strong>Woocomerce</strong> before active plugin <strong>Theme-Core</strong>'; ?></p>
			</div>
			<?php
		}

		public function includes() {
			include_once WC_ABSPATH . 'includes/abstracts/abstract-wc-product.php';
			// api
			include_once TRAVEL_CORE_PATH . '/inc/rest-api/class-theme-core-api.php';
		}

		/**
		 * It enqueues the style-ramdom style sheet.
		 */
		public function admin_enqueue_scripts() {
			wp_enqueue_script( 'custom-travel-nk', plugins_url( '/', TRAVEL_CORE_FILE ) . 'build/index.js', array(), '1.0.0', true );
		}
	}

	new TRAVEL_CORE();
}

