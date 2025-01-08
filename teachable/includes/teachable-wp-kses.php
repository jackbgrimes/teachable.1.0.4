<?php
/**
 * Core file.
 * Resist deletion.
 *
 * Encryption.
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
 * Custom WP KSES.
 *
 * @version 1.0.0
 */
function teachable_wp_kses() {
	$allowed_post_html = wp_kses_allowed_html( 'post' );

	$custom_allowed_html = array(
		'svg'      => array(
			'class'       => true,
			'style'       => true,
			'aria-hidden' => true,
			'role'        => true,
			'width'       => true,
			'height'      => true,
			'viewBox'     => true,
			'fill'        => true,
			'xmlns'       => true,
			'clip-path'   => true,
		),
		'path'     => array(
			'd'    => true,
			'fill' => true,
		),
		'rect'     => array(
			'width'  => true,
			'height' => true,
			'rx'     => true,
			'fill'   => true,
		),
		'circle'   => array(
			'cx'     => true,
			'cy'     => true,
			'r'      => true,
			'stroke' => true,
			'fill'   => true,
		),
		'g'        => array(
			'clip-path' => true,
		),
		'mask'     => array(
			'id'        => true,
			'style'     => true,
			'mask-type' => true,
			'maskUnits' => true,
			'x'         => true,
			'y'         => true,
			'width'     => true,
			'height'    => true,
		),
		'defs'     => array(),
		'clipPath' => array(
			'id' => true,
		),
		'input'    => array(
			'type'              => true,
			'id'                => true,
			'name'              => true,
			'value'             => true,
			'class'             => true,
			'style'             => true,
			'placeholder'       => true,
			'checked'           => true,
			'data-checkout-url' => true,
		),
	);

	return array_merge( $allowed_post_html, $custom_allowed_html );
}
