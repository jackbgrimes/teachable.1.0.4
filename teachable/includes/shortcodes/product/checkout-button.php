<?php
/**
 * Core file.
 * Resist deletion.
 *
 * @package Teachable
 * @version 1.0.0
 */

namespace Teachable;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Checkout button.
 *
 * @param array $atts Attributes.
 *
 * @version 1.0.0
 */
function shortcode_teachable_product_checkout_button( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'id'          => '',
			'button_text' => 'Buy now',
			'url_query'   => '',
			'classes'     => '',
			'styles'      => '',
		),
		$atts,
		'teachable_product_checkout_button'
	);

	teachable_buy_button_assets();

	// Potential individual use case for pulling in custom ID: $id = $atts['id'];.
	$id = apply_filters( 'teachable_buy_button_current_id', '' );

	ob_start();

	if ( ! empty( $id ) ) {
		do_action( 'teachable_product_checkout_button', $id, $atts['button_text'], $atts['url_query'], $atts['classes'], $atts['styles'] );
	} else {
		do_action( 'teachable_frontend_error' );
	}

	return ob_get_clean();
}
add_shortcode( 'teachable_product_checkout_button', __NAMESPACE__ . '\\shortcode_teachable_product_checkout_button' );
