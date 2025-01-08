<?php
/**
 * Renders the `teachable/product-enrollment-count` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 *
 * @package Teachable
 * @version 1.0.0
 */

namespace Teachable;

if ( ! isset( $block->context['teachableBuyButton/productId'] ) ) {
	return;
}

if ( isset( $attributes['productId'] ) ) {
	$product_id = $attributes['productId'];
} elseif ( isset( $block->context['teachableBuyButton/productId'] ) ) {
	$product_id = $block->context['teachableBuyButton/productId'];
}

$class_name = isset( $attributes['className'] ) ? $attributes['className'] : '';

$wp_block_styles  = wp_block_inline_style( $attributes );
$wp_block_classes = wp_block_classes( $attributes );

ob_start();

do_action( 'teachable_product_enrollment_count', $product_id, esc_attr( $class_name . $wp_block_classes ), $wp_block_styles );

$content = ob_get_clean();

echo wp_kses( $content, teachable_wp_kses() );
