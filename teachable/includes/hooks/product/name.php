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
 * Name.
 *
 * @param string $id The id for the product.
 * @param string $classes Custom classes.
 * @param string $styles Styles css inline styles.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_product_name',
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

		$classes = apply_filters( 'teachable_product_name_classes', $classes );
		$styles  = apply_filters( 'teachable_product_image_styles', $styles );
		$data    = apply_filters( 'teachable_buy_button_data_' . $id, $product_data );

		ob_start();

		if ( isset( $data['name'] ) && $data['name'] ) {
			echo '<h2 class="teachable-name ' . esc_attr( $classes ) . '" style="' . esc_html( $styles ) . '">' . wp_kses( $data['name'], Teachable\teachable_wp_kses() ) . '</h2>';
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
