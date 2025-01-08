<?php
/**
 * Core file.
 * Resist deletion.
 *
 * @param  array $atts Attributes.
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
 * Add buy button via shortcode.
 *
 * @param array  $atts Attributes.
 * @param string $content Content within the shortcode.
 *
 * @version 1.0.0
 */
function shortcode_teachable_buy_button( $atts = array(), $content = null ) {
	$atts = shortcode_atts(
		array(
			'id'          => '',
			'plan_ids'    => array(),
			'button_text' => 'Buy now',
			'url_query'   => '',
			'classes'     => '',
			'styles'      => '',
		),
		$atts,
		'teachable_buy_button'
	);

	teachable_buy_button_assets();

	add_filter(
		'teachable_buy_button_current_id',
		function() use ( $atts ) {
			return $atts['id'];
		}
	);

	ob_start();

	if ( $atts['id'] ) {
		if ( null !== $content && ! empty( trim( $content ) ) ) {
			echo '<div class="teachable-buy-button">' . do_shortcode( wp_kses( $content, teachable_wp_kses() ) );
				echo '<div class="teachable-checkout">';
					do_action( 'teachable_product_plan_options', $atts['id'], $atts['plan_ids'], $atts['classes'], $atts['styles'] );
					do_action( 'teachable_product_checkout_button', $atts['id'], $atts['button_text'], $atts['url_query'], $atts['classes'], $atts['styles'] );
				echo '</div>';
			echo '</div>';
		} elseif ( $atts['id'] ) {
			do_action( 'teachable_buy_button', $atts['id'], $atts['plan_ids'], $atts['button_text'], $atts['url_query'], $atts['classes'], $atts['styles'] );
		}
	} else {
		do_action( 'teachable_frontend_error' );
	}

	remove_all_filters( 'teachable_buy_button_current_id' );

	return ob_get_clean();
}
add_shortcode( 'teachable_buy_button', __NAMESPACE__ . '\\shortcode_teachable_buy_button' );
