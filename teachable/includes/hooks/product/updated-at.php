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
 * Updated at.
 *
 * @param string $id The id for the product.
 * @param string $classes Custom classes.
 * @param string $styles Styles css inline styles.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_product_updated_at',
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

		$classes = apply_filters( 'teachable_product_updated_at_classes', $classes );
		$styles  = apply_filters( 'teachable_product_updated_at_styles', $styles );
		$data    = apply_filters( 'teachable_buy_button_data_' . $id, $product_data );

		ob_start();

		if ( isset( $data['updated_at'] ) && $data['updated_at'] ) {
			$date           = new DateTime( $data['updated_at'] );
			$formatted_date = $date->format( 'M jS, Y' );

			echo '<p class="teachable-updated-at ' . esc_attr( $classes ) . '" style="' . esc_html( $styles ) . '"> <span class="teachable-updated-at-icon"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block"><path d="M8 5V10L12.25 12.52L13.02 11.24L9.5 9.15V5H8ZM18 7V0L15.36 2.64C13.74 1.01 11.49 0 9 0C4.03 0 0 4.03 0 9C0 13.97 4.03 18 9 18C13.97 18 18 13.97 18 9H16C16 12.86 12.86 16 9 16C5.14 16 2 12.86 2 9C2 5.14 5.14 2 9 2C10.93 2 12.68 2.79 13.95 4.05L11 7H18Z" fill="currentColor" /></svg></span> <span class="teachable-updated-at-details">' . esc_html__( 'Last updated', 'teachable' ) . '</span> <span class="teachable-updated-at-date">' . wp_kses( $formatted_date, Teachable\teachable_wp_kses() ) . '</span></p>';
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
