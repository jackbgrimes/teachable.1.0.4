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
 * Plan options.
 *
 * @param string $id The id for the product.
 * @param mixed  $plan_ids The ids for the pricing_plan.
 * @param string $classes Custom classes.
 * @param string $styles Styles css inline styles.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_product_plan_options',
	function ( $id, $plan_ids = array(), $classes = '', $styles = '' ) {
		if ( ! $id ) {
			do_action( 'teachable_frontend_error' );
			return;
		}

		$product_data = teachable_data( $id );

		if ( null === $product_data ) {
			do_action( 'teachable_frontend_error' );
			return;
		}

		if ( is_string( $plan_ids ) ) {
			$plan_ids = array_map( 'trim', explode( ',', $plan_ids ) );
		} elseif ( $plan_ids instanceof \stdClass ) {
			$temp_pricing = array();

			foreach ( $plan_ids as $price_object ) {
				if ( isset( $price_object->id ) ) {
					$temp_pricing[] = $price_object->id;
				}
			}

			$plan_ids = $temp_pricing;
		}

		$plan_ids = array_unique( $plan_ids );

		$plan_ids = array_map( 'strval', $plan_ids );

		Teachable\teachable_buy_button_assets();

		$classes = apply_filters( 'teachable_product_plan_options_classes', $classes );
		$styles  = apply_filters( 'teachable_product_plan_options_styles', $styles );
		$data    = apply_filters( 'teachable_buy_button_data_' . $id, $product_data );

		$pricing_plans = array();
		$content       = null;

		if ( empty( $plan_ids ) && isset( $data['pricing_plans'] ) && ! empty( $data['pricing_plans'] ) ) {
			$pricing[] = (string) $data['pricing_plans'][0]['id'];
		}

		if ( ! empty( $plan_ids ) && isset( $data['pricing_plans'] ) && ! empty( $data['pricing_plans'] ) ) {
			foreach ( $plan_ids as $pricing_id ) {
				foreach ( $data['pricing_plans'] as $plan ) {
					if ( (string) $plan['id'] === $pricing_id ) {
						$pricing_plans[] = $plan;
						break;
					}
				}
			}
		}

		if ( empty( $pricing_plans ) && ! empty( $data['pricing_plans'] ) ) {
			$pricing_plans[] = $data['pricing_plans'][0];
		}

		if ( ! empty( $pricing_plans ) ) {
			$unique_id = bin2hex( random_bytes( 4 ) );
			$content  .= '<fieldset class="teachable-plan-options-wrap"><legend>Select a Pricing Plan</legend>';

			foreach ( $pricing_plans as $index => $plan ) {
				$checked = 0 === $index ? 'checked' : '';

				$content     .= '<div class="teachable-plan-option">';
				$content     .= '<input type="radio" id="plan-option-' . esc_attr( $plan['id'] ) . '-' . esc_attr( $unique_id ) . '" name="teachable-product-plan-option-' . $unique_id . '" value="' . esc_attr( $plan['id'] ) . '" ' . $checked . ' data-checkout-url="' . esc_url( $plan['checkout_url'] ) . '" />';
				$content     .= '<label for="plan-option-' . esc_attr( $plan['id'] ) . '-' . esc_attr( $unique_id ) . '" class="teachable-plan-option-label">';
					$content .= '<span class="teachable-plan-option-name">' . esc_html( $plan['name'] ) . '</span><span class="teachable-plan-option-price">' . esc_html( $plan['formatted_price'] ) . '</span>';
				$content     .= '</label>';
				$content     .= '</div>';
			}

			$content .= '</fieldset>';
		} else {
			$content .= '<p>No pricing plans selected.</p>';
		}

		ob_start();

		if ( $content ) {
			echo '<div class="teachable-plan-options ' . esc_attr( $classes ) . '" style="' . esc_html( $styles ) . '">' . wp_kses( $content, Teachable\teachable_wp_kses() ) . '</div>';
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
