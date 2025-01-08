<?php
/**
 * Core file.
 * Resist deletion.
 *
 * WP Block Supports.
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
 * Block Inline Styles.
 *
 * @param array $attributes Attributes from block.
 *
 * @version 1.0.0
 */
function wp_block_inline_style( $attributes ) {
	$styles       = $attributes['style'] ?? array();
	$inline_style = '';

	if ( isset( $styles['dimensions']['minHeight'] ) ) {
		$inline_style .= 'min-height: ' . esc_attr( $styles['dimensions']['minHeight'] ) . ';';
	}

	if ( isset( $styles['typography']['lineHeight'] ) ) {
		$inline_style .= 'line-height: ' . esc_attr( $styles['typography']['lineHeight'] ) . ';';
	}

	if ( isset( $styles['typography']['fontSize'] ) ) {
		$inline_style .= 'font-size: ' . esc_attr( $styles['typography']['fontSize'] ) . ';';
	}

	$spacing_types = array( 'padding', 'margin' );

	foreach ( $spacing_types as $spacing_type ) {
		if ( isset( $styles['spacing'][ $spacing_type ] ) && is_array( $styles['spacing'][ $spacing_type ] ) ) {
			foreach ( $styles['spacing'][ $spacing_type ] as $direction => $value ) {
				$css_var = teachable_convert_preset_reference_to_css_variable( $value );

				$inline_style .= "{$spacing_type}-{$direction}: {$css_var};";
			}
		}
	}

	if ( isset( $styles['color']['text'] ) ) {
		$color_text = esc_attr( $styles['color']['text'] );
		$inline_style .= "color: {$color_text};";
	}

	if ( isset( $styles['color']['background'] ) ) {
		$color_background = esc_attr( $styles['color']['background'] );
		$inline_style .= "background-color: {$color_background};";
	}

	if ( isset( $styles['border'] ) ) {
		if ( isset( $styles['border']['width'] ) ) {
			$border_width  = esc_attr( $styles['border']['width'] );
			$inline_style .= "border-width: {$border_width};";
		}

		if ( isset( $styles['border']['style'] ) ) {
			$border_style  = esc_attr( $styles['border']['style'] );
			$inline_style .= "border-style: {$border_style};";
		}

		if ( isset( $styles['border']['color'] ) ) {
			$border_color  = esc_attr( $styles['border']['color'] );
			$inline_style .= "border-color: {$border_color};";
		}


	if ( isset( $styles['border']['radius'] ) ) {
		$border_radius = esc_attr( $styles['border']['radius'] );
		$inline_style .= "border-radius: {$border_radius};";
	}

	}

	return $inline_style;
}

/**
 * Convert styles.
 *
 * @param string $preset Wp preset rules.
 *
 * @version 1.0.0
 */
function teachable_convert_preset_reference_to_css_variable( $preset ) {
	if ( strpos( $preset, 'var:preset|' ) === 0 ) {
		$parts = explode( '|', $preset );

		$css_var_name = isset( $parts[2] ) ? "--wp--preset--{$parts[1]}--{$parts[2]}" : '';

		return "var({$css_var_name})";
	}

	return $preset;
}

/**
 * Block Inline Styles.
 *
 * @param array $attributes Attributes from block.
 *
 * @version 1.0.0
 */
function wp_block_classes( $attributes ) {
	$class_names = array();

	if ( isset( $attributes['backgroundColor'] ) ) {
		$class_names[] = 'has-' . $attributes['backgroundColor'] . '-background-color';
	}

	if ( isset( $attributes['textColor'] ) ) {
		$class_names[] = 'has-' . $attributes['textColor'] . '-color';
	}

	if ( isset( $attributes['fontSize'] ) ) {
		$class_names[] = 'has-' . $attributes['fontSize'] . '-font-size';
	}

	if ( isset( $attributes['borderColor'] ) ) {
		$class_names[] = 'has-' . $attributes['borderColor'] . '-border-color';
		$class_names[] = 'has-border-color';
	}

	$joined_class_names = implode( ' ', $class_names );
	$formatted_class_nammes = ' ' . $joined_class_names;

	return $formatted_class_nammes;
}
