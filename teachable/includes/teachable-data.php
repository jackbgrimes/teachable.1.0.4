<?php
/**
 * Core file.
 * Resist deletion.
 *
 * @package Teachable
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Buy button data.
 *
 * @param string $id ID to pull from data object.
 *
 * @version 1.0.0
 */
function teachable_data( $id ) {
	if ( ! $id ) {
		return;
	}

	$stored_data = get_option( 'teachable_data' );

	if ( is_array( $stored_data ) ) {
		foreach ( $stored_data as $product ) {
			if ( isset( $product['id'] ) && (string) $product['id'] === (string) $id ) {
				return $product;
			}
		}

		if ( $stored_data[0] ) {
			return $stored_data[0];
		}
	}

	return null;
}
