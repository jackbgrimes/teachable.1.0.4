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
 * Plan options.
 *
 * @param array $atts Attributes.
 *
 * @version 1.0.0
 */
function shortcode_teachable_product_plan_options( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'id'       => '',
			'plan_ids' => array(),
			'classes'  => '',
			'styles'   => '',
		),
		$atts,
		'teachable_product_plan_options'
	);

	teachable_buy_button_assets();

	// Potential individual use case for pulling in custom ID: $id = $atts['id'];.
	$id = apply_filters( 'teachable_buy_button_current_id', '' );

	ob_start();

	if ( ! empty( $id ) ) {
		do_action( 'teachable_product_plan_options', $id, $atts['plan_ids'], $atts['classes'], $atts['styles'] );
	} else {
		do_action( 'teachable_frontend_error' );
	}

	return ob_get_clean();
}
add_shortcode( 'teachable_product_plan_options', __NAMESPACE__ . '\\shortcode_teachable_product_plan_options' );
