<?php 
// add skeleton
function nk_skeleton_animation_html( $count_li = 3, $width = 'random', $styleli = '', $styleul = '' ) {
	?>
	<ul class="search-nk-skeleton-animation" style="<?php echo ! empty( $styleul ) ? $styleul : ''; ?>">
		<?php for ( $i = 0; $i < absint( $count_li ); $i ++ ) : ?>
			<li style="width: <?php echo $width === 'random' ? wp_rand( 60, 100 ) . '%' : $width; ?>; <?php echo ! empty( $styleli ) ? $styleli : ''; ?>"></li>
		<?php endfor; ?>
	</ul>

	<?php
}
/**
 * Get other templates passing attributes and including the file.
 *
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 *
 * @return void
 */
if ( ! function_exists( 'hb_get_template' ) ) {

	function hb_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) ) {
			extract( $args );
		}

		$located = hb_locate_template( $template_name, $template_path, $default_path );

		if ( ! file_exists( $located ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );

			return;
		}
		// Allow 3rd party plugin filter template file from their plugin
		$located = apply_filters( 'hb_get_template', $located, $template_name, $args, $template_path, $default_path );

		do_action( 'hb_before_template_part', $template_name, $template_path, $located, $args );

		if ( $located && file_exists( $located ) ) {
			include $located;
		}

		do_action( 'hb_after_template_part', $template_name, $template_path, $located, $args );
	}
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *        yourtheme        /    $template_path    /    $template_name
 *        yourtheme        /    $template_name
 *        $default_path    /    $template_name
 *
 * @access public
 *
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 *
 * @return string
 */
if ( ! function_exists( 'hb_locate_template' ) ) {

	function hb_locate_template( $template_name, $template_path = '', $default_path = '' ) {

		if ( ! $template_path ) {
			$template_path = hb_template_path();
		}

		if ( ! $default_path ) {
			$default_path = TRAVEL_CORE_PATH . '/templates/';
		}

		$template = null;
		// Look within passed path within the theme - this is priority
		// if( hb_enable_overwrite_template() ) {
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);

		// }
		// Get default template
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		// Return what we found
		return apply_filters( 'hb_locate_template', $template, $template_name, $template_path );
	}
}

if ( ! function_exists( 'hb_get_template_content' ) ) {

	function hb_get_template_content( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		ob_start();
		hb_get_template( $template_name, $args, $template_path, $default_path );

		return ob_get_clean();
	}
}


if ( ! function_exists( 'hb_template_path' ) ) {
	function hb_template_path() {
		return apply_filters( 'hb_template_path', 'travel-core' );
	}
}

add_action( 'init', 'woocommerce_clear_cart_url', 9999 );
function woocommerce_clear_cart_url() {
  	global $woocommerce;
    if ( isset( $_GET['room_order_id'] ) ) {
        WC()->cart->empty_cart(); 
    }
}



