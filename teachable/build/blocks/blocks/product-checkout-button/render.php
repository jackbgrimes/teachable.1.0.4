<?php
/**
 * Renders the `teachable/product-button` block on the server.
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

$button_text = 'Buy now';

if ( isset( $attributes['buttonText'] ) ) {
	$button_text = $attributes['buttonText'];
}

$url_query = '';

if ( isset( $attributes['urlQuery'] ) ) {
	$url_query = $attributes['urlQuery'];
}

$class_name = isset( $attributes['className'] ) ? $attributes['className'] : '';

$wp_block_styles  = wp_block_inline_style( $attributes );
$wp_block_classes = wp_block_classes( $attributes );

ob_start();

do_action( 'teachable_product_checkout_button', $product_id, $button_text, $url_query, esc_attr( $class_name . $wp_block_classes ), $wp_block_styles );

$content = ob_get_clean();

echo wp_kses( $content, teachable_wp_kses() );
