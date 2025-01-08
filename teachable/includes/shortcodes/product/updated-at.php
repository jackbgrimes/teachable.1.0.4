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
 * Updated at.
 *
 * @param array $atts Attributes.
 *
 * @version 1.0.0
 */
function shortcode_teachable_product_updated_at( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'id'      => '',
			'classes' => '',
			'styles'  => '',
		),
		$atts,
		'teachable_product_updated_at'
	);

	teachable_buy_button_assets();

	// Potential individual use case for pulling in custom ID: $id = $atts['id'];.
	$id = apply_filters( 'teachable_buy_button_current_id', '' );

	ob_start();

	if ( ! empty( $id ) ) {
		do_action( 'teachable_product_updated_at', $id, $atts['classes'], $atts['styles'] );
	} else {
		do_action( 'teachable_frontend_error' );
	}

	return ob_get_clean();
}
add_shortcode( 'teachable_product_updated_at', __NAMESPACE__ . '\\shortcode_teachable_product_updated_at' );
