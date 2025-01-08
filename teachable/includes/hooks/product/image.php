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
 * Image.
 *
 * @param string $id The id for the product.
 * @param string $classes Custom classes.
 * @param string $styles Styles css inline styles.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_product_image',
	function ( $id, $classes = '', $styles = '' ) {
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

		$classes = apply_filters( 'teachable_product_image_classes', $classes );
		$styles  = apply_filters( 'teachable_product_image_styles', $styles );
		$data    = apply_filters( 'teachable_buy_button_data_' . $id, $product_data );

		ob_start();

		if ( isset( $data['image_url'] ) && $data['image_url'] ) {
			echo '<div class="teachable-image ' . esc_attr( $classes ) . '" style="' . esc_html( $styles ) . '"><img src="' . esc_url( $data['image_url'] ) . '" alt="' . esc_html__( 'Product image', 'teachable' ) . '" /></div>';
		} else {
			do_action( 'teachable_frontend_error' );
			return;
		}

		$content = ob_get_clean();

		echo wp_kses( $content, Teachable\teachable_wp_kses() );
	},
	10,
	3
);
