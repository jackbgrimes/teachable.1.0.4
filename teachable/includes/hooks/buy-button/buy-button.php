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
 * Buy button.
 *
 * @param string $id The id for the product.
 * @param mixed  $plan_ids The ids for the pricing_plan.
 * @param string $button_text The text for the button.
 * @param string $url_query The text for the end of the checkout URL.
 * @param string $classes Custom classes.
 * @param string $styles Styles css inline styles.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_buy_button',
	function ( $id, $plan_ids = array(), $button_text = 'Buy now', $url_query = '', $classes = '', $styles = '' ) {
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

		$classes = apply_filters( 'teachable_buy_button_classes', $classes );
		$styles  = apply_filters( 'teachable_buy_button_styles', $styles );
		$data    = apply_filters( 'teachable_buy_button_data_' . $id, $product_data );

		ob_start();

		if ( isset( $data['name'] ) && $data['name'] ) {
			echo '<div class="teachable-buy-button ' . esc_attr( $classes ) . '" style="' . esc_html( $styles ) . '">';

			do_action( 'teachable_product_image', $id );

			echo '<div class="teachable-content">';

				do_action( 'teachable_product_name', $id );

				do_action( 'teachable_product_description', $id );

				echo '<div class="teachable-details">';

					do_action( 'teachable_product_enrollment_count', $id );

					do_action( 'teachable_product_updated_at', $id );

				echo '</div>';

				echo '<div class="teachable-checkout">';

					do_action( 'teachable_product_plan_options', $id, $plan_ids );

					do_action( 'teachable_product_checkout_button', $id, $button_text, $url_query );

				echo '</div>';

			echo '</div>';

			echo '</div>';
		} else {
			do_action( 'teachable_frontend_error' );
			echo 'test';
			return;
		}

		$content = ob_get_clean();

		echo wp_kses( $content, Teachable\teachable_wp_kses() );
	},
	10,
	7
);
