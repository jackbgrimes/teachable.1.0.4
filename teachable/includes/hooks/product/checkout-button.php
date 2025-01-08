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
 * Button.
 *
 * @param string $id The id for the product.
 * @param string $button_text The text for the button.
 * @param string $url_query The text for the end of the checkout URL.
 * @param string $classes Custom classes.
 * @param string $styles Styles css inline styles.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_product_checkout_button',
	function ( $id, $button_text = 'Buy now', $url_query = '', $classes = '', $styles = '' ) {
		if ( ! $id ) {
			do_action( 'teachable_frontend_error' );
			return;
		}

		$product_data = teachable_data( $id );

		if ( null === $product_data ) {
			do_action( 'teachable_frontend_error' );
			return;
		}

		Teachable\teachable_buy_button_assets();

		$classes = apply_filters( 'teachable_product_checkout_button_classes', $classes );
		$styles  = apply_filters( 'teachable_product_checkout_button_styles', $styles );

		ob_start();

		if ( $button_text ) {
			echo '<a href="' . esc_url( 'https://teachable.com/' ) . '" data-query="' . esc_html( $url_query ) . '" class="teachable-checkout-button ' . esc_attr( $classes ) . '" style="' . esc_html( $styles ) . '" target="_blank" rel="noopener noreferrer">' . wp_kses( $button_text, Teachable\teachable_wp_kses() ) . '</a>';
		} else {
			do_action( 'teachable_frontend_error' );
			return;
		}

		$content = ob_get_clean();

		echo wp_kses( $content, Teachable\teachable_wp_kses() );
	},
	10,
	7
);
