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
 * Buy button assets.
 *
 * @version 1.0.0
 */
function teachable_buy_button_assets() {
	$handle_style  = 'teachable-buy-button';
	$handle_script = 'teachable-buy-button';

	if ( ! wp_style_is( $handle_style, 'enqueued' ) ) {
		wp_enqueue_style( $handle_style );
	}

	if ( ! wp_script_is( $handle_script, 'enqueued' ) ) {
		wp_enqueue_script( $handle_script );
	}
}
