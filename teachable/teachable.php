<?php
/**
 * Core file.
 * Resist deletion.
 *
 * @wordpress-plugin
 * Plugin Name:        Teachable
 * Plugin URI:         https://wordpress.org/plugins/teachable/
 * Description:        Effortlessly connect your Teachable products to WordPress with the official Teachable Buy Button Plugin.
 * Version:            1.0.4
 * Author:             Teachable
 * Author URI:         https://teachable.com
 * Text Domain:        teachable
 * License:            GPLv3
 * License URI:        https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:        /languages
 * Requires at least:  WordPress 6.0
 * Requires PHP:       7.4
 * Support Link:       https://support.teachable.com/hc/en-us
 * Documentation Link: https://support.teachable.com/hc/en-us/articles/25418090816781-Teachable-for-Wordpress
 *
 * @package WordPress
 */

namespace Teachable;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * Admin JS/CSS.
 *
 * @version 1.0.0
 */
function admin_scripts() {
	// Admin CSS.
	wp_register_style(
		'teachable-admin',
		trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/css/admin-styles.css',
		array(),
		'1.0.0',
		'all'
	);

	$screen = get_current_screen();

	if ( 'plugins' === $screen->id ) {
		$general_settings = get_option( 'teachable_general_settings' );

		if ( empty( $general_settings ) || ! isset( $general_settings['wp_key'] ) || empty( $general_settings['wp_key'] ) ) {
			wp_enqueue_script(
				'teachable-admin',
				trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/js/admin-scripts.js',
				array(),
				'1.0.0',
				true
			);
		}
	}
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_scripts' );

/**
 * Public JS/CSS.
 *
 * @version 1.0.0
 */
function public_scripts() {
	// Buy button CSS.
	wp_register_style(
		'teachable-buy-button',
		trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/css/buy-button-styles.css',
		array(),
		'1.0.0',
		'all'
	);

	// Buy button JS.
	wp_register_script(
		'teachable-buy-button',
		trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/js/buy-button-scripts.js',
		array( 'wp-blocks' ),
		'1.0.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\public_scripts' );

/**
 * Block Editor Asset JS/CSS.
 *
 * @version 1.0.0
 */
function block_editor_asset_scripts() {
	if ( ! wp_style_is( 'teachable-buy-button', 'enqueued' ) ) {
		wp_enqueue_style(
			'teachable-buy-button',
			trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/css/buy-button-styles.css',
			array(),
			'1.0.0',
			'all'
		);

		wp_enqueue_script(
			'teachable-buy-button',
			trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/js/buy-button-scripts.js',
			array( 'wp-blocks' ),
			'1.0.0',
			true
		);
	}
}
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\block_editor_asset_scripts' );

/**
 * Block Editor JS/CSS.
 *
 * @version 1.0.0
 */
function block_editor_scripts() {
	$data_array = array(
		'buyButtonData'            => get_option( 'teachable_data' ),
		'image_classes'            => apply_filters( 'teachable_product_image_classes', '' ),
		'name_classes'             => apply_filters( 'teachable_product_name_classes', '' ),
		'description_classes'      => apply_filters( 'teachable_product_description_classes', '' ),
		'enrollment_count_classes' => apply_filters( 'teachable_product_enrollment_count_classes', '' ),
		'updated_at_classes'       => apply_filters( 'teachable_product_updated_at_classes', '' ),
		'plan_options_classes'     => apply_filters( 'teachable_product_plan_options_classes', '' ),
		'checkout_button_classes'  => apply_filters( 'teachable_product_checkout_button_classes', '' ),
	);

	$json_data     = wp_json_encode( $data_array );
	$inline_script = 'const teachable_buy_button = ' . $json_data . ';';

	wp_enqueue_script(
		'teachable-buy-button',
		trailingslashit( plugin_dir_url( __FILE__ ) ) . 'build/js/buy-button-scripts.js',
		array( 'wp-blocks' ),
		'1.0.0',
		true
	);

	wp_add_inline_script( 'teachable-buy-button', $inline_script, 'before' );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\block_editor_scripts' );

/**
 * Blocks.
 *
 * @version 1.0.0
 */
function blocks() {
	// Buy button.
	register_block_type( __DIR__ . '/build/blocks/blocks/buy-button' );

	// Product image.
	register_block_type(
		__DIR__ . '/build/blocks/blocks/product-image',
		array(
			'render_callback' => __NAMESPACE__ . '\\block_product_image_callback',
		)
	);

	// Product name.
	register_block_type(
		__DIR__ . '/build/blocks/blocks/product-name',
		array(
			'render_callback' => __NAMESPACE__ . '\\block_product_name_callback',
		)
	);

	// Product description.
	register_block_type(
		__DIR__ . '/build/blocks/blocks/product-description',
		array(
			'render_callback' => __NAMESPACE__ . '\\block_product_description_callback',
		)
	);

	// Product enrollment count.
	register_block_type(
		__DIR__ . '/build/blocks/blocks/product-enrollment-count',
		array(
			'render_callback' => __NAMESPACE__ . '\\block_product_enrollment_count_callback',
		)
	);

	// Product updated at.
	register_block_type(
		__DIR__ . '/build/blocks/blocks/product-updated-at',
		array(
			'render_callback' => __NAMESPACE__ . '\\block_product_updated_at_callback',
		)
	);

	// Product plan options.
	register_block_type(
		__DIR__ . '/build/blocks/blocks/product-plan-options',
		array(
			'render_callback' => __NAMESPACE__ . '\\block_product_plan_options_callback',
		)
	);

	// Product checkout button.
	register_block_type(
		__DIR__ . '/build/blocks/blocks/product-checkout-button',
		array(
			'render_callback' => __NAMESPACE__ . '\\block_product_checkout_button_callback',
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\blocks' );

/**
 * Product image block callback.
 *
 * @param array    $attributes Attributes for the block, including the block's settings defined
 *                             in the block.json file or additional attributes saved with the block.
 * @param string   $content    The content of the block, typically not used for dynamic blocks
 *                             as their content is generated in PHP rather than stored in post content.
 * @param WP_Block $block      Block object containing details about the block's context and more.
 *
 * @version 1.0.0
 */
function block_product_image_callback( $attributes, $content, $block ) {
	ob_start();
	include __DIR__ . '/build/blocks/blocks/product-image/render.php';
	return ob_get_clean();
}

/**
 * Product name block callback.
 *
 * @param array    $attributes Attributes for the block, including the block's settings defined
 *                             in the block.json file or additional attributes saved with the block.
 * @param string   $content    The content of the block, typically not used for dynamic blocks
 *                             as their content is generated in PHP rather than stored in post content.
 * @param WP_Block $block      Block object containing details about the block's context and more.
 *
 * @version 1.0.0
 */
function block_product_name_callback( $attributes, $content, $block ) {
	ob_start();
	include __DIR__ . '/build/blocks/blocks/product-name/render.php';
	return ob_get_clean();
}

/**
 * Product description block callback.
 *
 * @param array    $attributes Attributes for the block, including the block's settings defined
 *                             in the block.json file or additional attributes saved with the block.
 * @param string   $content    The content of the block, typically not used for dynamic blocks
 *                             as their content is generated in PHP rather than stored in post content.
 * @param WP_Block $block      Block object containing details about the block's context and more.
 *
 * @version 1.0.0
 */
function block_product_description_callback( $attributes, $content, $block ) {
	ob_start();
	include __DIR__ . '/build/blocks/blocks/product-description/render.php';
	return ob_get_clean();
}

/**
 * Product enrollment count block callback.
 *
 * @param array    $attributes Attributes for the block, including the block's settings defined
 *                             in the block.json file or additional attributes saved with the block.
 * @param string   $content    The content of the block, typically not used for dynamic blocks
 *                             as their content is generated in PHP rather than stored in post content.
 * @param WP_Block $block      Block object containing details about the block's context and more.
 *
 * @version 1.0.0
 */
function block_product_enrollment_count_callback( $attributes, $content, $block ) {
	ob_start();
	include __DIR__ . '/build/blocks/blocks/product-enrollment-count/render.php';
	return ob_get_clean();
}

/**
 * Product updated at block callback.
 *
 * @param array    $attributes Attributes for the block, including the block's settings defined
 *                             in the block.json file or additional attributes saved with the block.
 * @param string   $content    The content of the block, typically not used for dynamic blocks
 *                             as their content is generated in PHP rather than stored in post content.
 * @param WP_Block $block      Block object containing details about the block's context and more.
 *
 * @version 1.0.0
 */
function block_product_updated_at_callback( $attributes, $content, $block ) {
	ob_start();
	include __DIR__ . '/build/blocks/blocks/product-updated-at/render.php';
	return ob_get_clean();
}

/**
 * Product plan options block callback.
 *
 * @param array    $attributes Attributes for the block, including the block's settings defined
 *                             in the block.json file or additional attributes saved with the block.
 * @param string   $content    The content of the block, typically not used for dynamic blocks
 *                             as their content is generated in PHP rather than stored in post content.
 * @param WP_Block $block      Block object containing details about the block's context and more.
 *
 * @version 1.0.0
 */
function block_product_plan_options_callback( $attributes, $content, $block ) {
	ob_start();
	include __DIR__ . '/build/blocks/blocks/product-plan-options/render.php';
	return ob_get_clean();
}

/**
 * Product checkout button block callback.
 *
 * @param array    $attributes Attributes for the block, including the block's settings defined
 *                             in the block.json file or additional attributes saved with the block.
 * @param string   $content    The content of the block, typically not used for dynamic blocks
 *                             as their content is generated in PHP rather than stored in post content.
 * @param WP_Block $block      Block object containing details about the block's context and more.
 *
 * @version 1.0.0
 */
function block_product_checkout_button_callback( $attributes, $content, $block ) {
	ob_start();
	include __DIR__ . '/build/blocks/blocks/product-checkout-button/render.php';
	return ob_get_clean();
}

/**
 * Add plugin action links.
 *
 * @param array  $links       An array of plugin action links.
 * @param string $plugin_file Path to the plugin file relative to the plugins directory.
 *
 * @version 1.0.0
 */
function plugin_settings_links( $links, $plugin_file ) {
	if ( 'teachable/teachable.php' !== $plugin_file ) {
		return $links;
	}

	$settings_link = array(
		'<a href="' . esc_url( admin_url( 'options-general.php?page=teachable' ) ) . '">' . esc_html__( 'Settings', 'teachable' ) . '</a>',
	);

	return array_merge( $settings_link, $links );
}
add_filter( 'plugin_action_links', __NAMESPACE__ . '\\plugin_settings_links', 10, 2 );

/**
 * Register dashboard pages.
 *
 * @version 1.0.0
 */
function dashboard_pages() {
	add_submenu_page(
		'options-general.php',
		esc_html__( 'Teachable', 'teachable' ),
		esc_html__( 'Teachable', 'teachable' ),
		'manage_options',
		'teachable',
		__NAMESPACE__ . '\\admin_settings',
		99
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\\dashboard_pages' );

/**
 * Admin settings.
 *
 * @version 1.0.0
 */
function admin_settings() {
	include 'includes/admin-settings.php';
}

/**
 * Validate fields.
 *
 * @version 1.0.0
 */
function admin_settings_validate() {
	if ( is_admin() && current_user_can( 'manage_options' ) && isset( $_GET['page'] ) && 'teachable' === $_GET['page'] ) {
		if ( isset( $_POST['teachable_general_settings'] ) ) {
			if ( ! check_admin_referer( 'teachable-general-settings' ) ) {
				wp_die( esc_html__( 'Security check failed.', 'teachable' ) );
			}

			$general_settings = get_option( 'teachable_general_settings', array() );

			if ( isset( $_POST['teachable_general_settings']['wp_key'] ) ) {
				$sanitized_key   = sanitize_text_field( wp_unslash( $_POST['teachable_general_settings']['wp_key'] ) );
				$school_response = school_fetch( $sanitized_key );

				if ( $school_response ) {
					$general_settings['wp_key']      = encrypt( $sanitized_key );
					$general_settings['school_name'] = $school_response;

					update_option(
						'teachable_general_settings',
						$general_settings
					);

					set_transient(
						'transient_teachable_general_settings_wp_key',
						array(
							'message' => __( 'Your updates have been saved and your Teachable school is now connected.', 'teachable' ),
							'class'   => 'field-success',
						),
						30
					);

					$data_fetched = data_fetch( $sanitized_key );

					if ( ! $data_fetched ) {
						wp_clear_scheduled_hook( __NAMESPACE__ . '\\sync_data' );

						set_transient(
							'transient_teachable_general_settings_wp_key',
							array(
								'message' => __( 'We could not get your course data, please reach out to Teachable for help.', 'teachable' ),
								'class'   => 'field-error',
							),
							30
						);
					} else {
						$sync_time = isset( $general_settings['sync_time'] ) ? $general_settings['sync_time'] : '2:00 AM';

						wp_clear_scheduled_hook( __NAMESPACE__ . '\\sync_data' );
						wp_schedule_event( strtotime( $sync_time ), 'daily', __NAMESPACE__ . '\\sync_data' );
					}
				} else {
					unset( $general_settings['wp_key'] );
					unset( $general_settings['school_name'] );
					unset( $general_settings['last_sync'] );

					update_option(
						'teachable_general_settings',
						$general_settings
					);

					set_transient(
						'transient_teachable_general_settings_wp_key',
						array(
							'message' => __( 'Invalid key. Please double-check and ensure it is correct.', 'teachable' ),
							'class'   => 'field-error',
						),
						30
					);

					delete_option( 'teachable_data' );

					wp_clear_scheduled_hook( __NAMESPACE__ . '\\sync_data' );
				}
			}

			if ( isset( $_POST['teachable_general_settings']['sync_now'] ) ) {
				if ( ! isset( $general_settings['wp_key'] ) || isset( $general_settings['wp_key'] ) && '' === $general_settings['wp_key'] ) {
					set_transient(
						'transient_teachable_general_settings_sync_now',
						array(
							'message' => __( 'We could not sync your data because your WordPress key is missing. Please add it in the General tab.', 'teachable' ),
							'class'   => 'field-error',
						),
						30
					);
				} else {
					$data_fetched = data_fetch( decrypt( $general_settings['wp_key'] ) );

					if ( ! $data_fetched ) {
						set_transient(
							'transient_teachable_general_settings_sync_now',
							array(
								'message' => __( 'We could not get your Teachable data, please reach out to Teachable for help.', 'teachable' ),
								'class'   => 'field-error',
							),
							30
						);
					} else {
						set_transient(
							'transient_teachable_general_settings_sync_now',
							array(
								'message' => __( 'Your data has been synced.', 'teachable' ),
								'class'   => 'field-success',
							),
							30
						);
					}
				}
			}

			$sync_time = array();

			if ( isset( $_POST['teachable_general_settings']['sync_time_hour'] ) ) {
				$hour = intval( sanitize_text_field( wp_unslash( $_POST['teachable_general_settings']['sync_time_hour'] ) ) );

				if ( $hour >= 1 && $hour <= 12 ) {
					$sync_time['sync_time_hour'] = $hour;
				} else {
					$sync_time['sync_time_hour'] = 2;
				}
			}

			if ( isset( $_POST['teachable_general_settings']['sync_time_minute'] ) ) {
				$minute = intval( sanitize_text_field( wp_unslash( $_POST['teachable_general_settings']['sync_time_minute'] ) ) );

				if ( $minute >= 0 && $minute <= 59 ) {
					$sync_time['sync_time_minute'] = $minute;
				} else {
					$sync_time['sync_time_minute'] = 0;
				}
			}

			if ( isset( $_POST['teachable_general_settings']['sync_time_ampm'] ) ) {
				$ampm = strtolower( sanitize_text_field( wp_unslash( $_POST['teachable_general_settings']['sync_time_ampm'] ) ) );

				if ( in_array( $ampm, array( 'am', 'pm' ), true ) ) {
					$sync_time['sync_time_ampm'] = strtoupper( $ampm );
				} else {
					$sync_time['sync_time_ampm'] = 'AM';
				}
			}

			if ( isset( $_POST['teachable_general_settings']['sync_time_hour'], $_POST['teachable_general_settings']['sync_time_minute'], $_POST['teachable_general_settings']['sync_time_ampm'] ) ) {
				$general_settings['sync_time'] = sprintf(
					'%d:%02d %s',
					$sync_time['sync_time_hour'],
					$sync_time['sync_time_minute'],
					$sync_time['sync_time_ampm']
				);

				wp_clear_scheduled_hook( __NAMESPACE__ . '\\sync_data' );
				wp_schedule_event( strtotime( esc_html( $general_settings['sync_time'] ) ), 'daily', __NAMESPACE__ . '\\sync_data' );

				update_option( 'teachable_general_settings', $general_settings );
			}

			if ( isset( $_POST['teachable_general_settings']['delete_data'] ) ) {
				if ( sanitize_text_field( wp_unslash( $_POST['teachable_general_settings']['delete_data'] ) ) ) {
					$general_settings['delete_data'] = 1;
				} else {
					$general_settings['delete_data'] = 0;
				}

				update_option( 'teachable_general_settings', $general_settings );
			}

			if ( isset( $_POST['teachable_general_settings']['delete_data'] ) && isset( $_POST['teachable_general_settings']['sync_time_hour'], $_POST['teachable_general_settings']['sync_time_minute'], $_POST['teachable_general_settings']['sync_time_ampm'] ) ) {
				set_transient(
					'transient_teachable_general_settings_sync_data_form',
					array(
						'message' => __( 'Your changes have been saved.', 'teachable' ),
						'class'   => 'field-success',
					),
					30
				);
			}
		}
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\\admin_settings_validate' );

/**
 * Remove admin notices on admin settings page.
 *
 * @version 1.0.0
 */
function hide_admin_settings_notices() {
	if ( is_admin() && isset( $_GET['page'] ) && 'teachable' === $_GET['page'] ) {
		if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'teachable_tab_nonce' ) ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	}
}
add_action( 'admin_head', __NAMESPACE__ . '\\hide_admin_settings_notices' );

/**
 * Fetch data.
 *
 * @param string $key API Key.
 *
 * @version 1.0.0
 */
function data_fetch( $key = null ) {
	$general_settings = get_option( 'teachable_general_settings' );
	if ( ! $key ) {
		$key = isset( $general_settings['wp_key'] ) ? decrypt( $general_settings['wp_key'] ) : '';

		update_option( 'teachable_general_settings', $general_settings );

		if ( '' === $key ) {
			return false;
		}
	}

	$headers = array(
		'apiKey' => $key,
	);

	$args = array(
		'headers' => $headers,
		'timeout' => 300,
	);

	$max_items = 1000;
	$per_page  = 100;

	$courses_url  = 'https://developers.teachable.com/v1/integrations/courses';
	$courses_data = fetch_paginated_data( $courses_url, $args, $max_items, $per_page );

	$bundles_url  = 'https://developers.teachable.com/v1/integrations/bundles';
	$bundles_data = fetch_paginated_data( $bundles_url, $args, $max_items, $per_page );

	$data = array_merge( $courses_data, $bundles_data );

	foreach ( $data as &$item ) {
		if ( $item && isset( $item['description'] ) ) {
			$item['description'] = strip_tags( $item['description'], '<b><strong><i><em>' );
			$item['description'] = preg_replace( '/\s+/', ' ', $item['description'] );
			$item['description'] = trim( $item['description'] );
		}
		if ( $item && isset( $item['title'] ) ) {
			$item['title'] = strip_tags( $item['title'], '<b><strong><i><em>' );
			$item['title'] = preg_replace( '/\s+/', ' ', $item['title'] );
			$item['title'] = trim( $item['title'] );
		}
	}

	unset( $item );

	if ( isset( $data ) && ! empty( $data ) ) {
		update_option( 'teachable_data', $data );

		$timezone_abbreviation = timezone();
		$timezone              = new \DateTimeZone( $timezone_abbreviation );
		$now                   = new \DateTime( 'now', $timezone );

		$general_settings['last_sync'] = $now->format( 'F jS, Y, g:i A T' );

		update_option( 'teachable_general_settings', $general_settings );

		$school_response = school_fetch( $key );

		if ( $school_response ) {
			$general_settings['school_name'] = $school_response;

			update_option(
				'teachable_general_settings',
				$general_settings
			);
		}

		return true;
	} else {
		return false;
	}
}
add_action( __NAMESPACE__ . '\\sync_data', __NAMESPACE__ . '\\data_fetch' );

/**
 * Fetch paginated data.
 * Pulls in the course and bundle data associated with the provided WordPress key.
 *
 * @param string $url API url.
 * @param array  $args API arguments.
 * @param int    $max_items Limit of items.
 * @param int    $per_page Per page max.
 *
 * @version 1.0.0
 */
function fetch_paginated_data( $url, $args, int $max_items, int $per_page ) {
	$data              = array();
	$page              = 1;
	$continue_fetching = true;

	while ( $continue_fetching ) {
		$paged_url = add_query_arg(
			array(
				'page' => $page,
				'per'  => $per_page,
			),
			$url
		);

		$response = wp_remote_get( $paged_url, $args );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! isset( $body['courses'] ) && ! isset( $body['bundles'] ) ) {
			break;
		}

		$items_key = isset( $body['courses'] ) ? 'courses' : 'bundles';

		$data = array_merge( $data, $body[ $items_key ] );

		$total_items     = isset( $body['meta']['total'] ) ? $body['meta']['total'] : count( $data );
		$number_of_pages = isset( $body['meta']['number_of_pages'] ) ? $body['meta']['number_of_pages'] : 1;

		$page++;
		$continue_fetching = ( count( $data ) < min( $max_items, $total_items ) && $page <= $number_of_pages );
	}

	return array_slice( $data, 0, $max_items );
}

/**
 * Fetch school.
 * Pulls in the school data associated with the provided WordPress key.
 *
 * @param string $key An API key.
 *
 * @version 1.0.0
 */
function school_fetch( $key ) {
	$headers = array(
		'apiKey' => $key,
	);

	$args = array(
		'headers' => $headers,
		'timeout' => 300,
	);

	$school_response = wp_remote_get( 'https://developers.teachable.com/v1/integrations/school', $args );

	if ( is_wp_error( $school_response ) ) {
		return false;
	}

	$data = json_decode( wp_remote_retrieve_body( $school_response ), true );

	if ( ! empty( $data['school']['name'] ) ) {
		return $data['school']['name'];
	} else {
		return false;
	}
}

/**
 * Hooks.
 *
 * @version 1.0.0
 */
// Buy button.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/buy-button/buy-button.php';
// Image.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/product/image.php';
// Name.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/product/name.php';
// Description.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/product/description.php';
// Enrollment count.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/product/enrollment-count.php';
// Updated at.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/product/updated-at.php';
// Plan options.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/product/plan-options.php';
// Checkout button.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/product/checkout-button.php';
// Frontend error.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/hooks/frontend-error.php';

/**
 * Shortcodes.
 *
 * @version 1.0.0
 */
// Buy button.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/buy-button/buy-button.php';
// Image.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/product/image.php';
// Mame.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/product/name.php';
// Description.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/product/description.php';
// Enrollment count.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/product/enrollment-count.php';
// Updated at.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/product/updated-at.php';
// Plan options.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/product/plan-options.php';
// Checkout button.
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/shortcodes/product/checkout-button.php';

/**
 * Functions.
 *
 * @version 1.0.0
 */
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/admin-settings-tab-url.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/encryption.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/buy-button-assets.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/teachable-data.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/teachable-wp-kses.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/wp-block-supports.php';
require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/timezone.php';

/**
 * Translation capabilities.
 *
 * @version 1.0.0
 */
function translations() {
	load_plugin_textdomain(
		'teachable',
		false,
		trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) . 'languages'
	);
}
add_action( 'init', __NAMESPACE__ . '\\translations' );

/**
 * Activation.
 *
 * @version 1.0.0
 */
function activate() {
	add_option( 'teachable_activated', '1' );

	$general_settings = get_option( 'teachable_general_settings' );

	if ( ! $general_settings || empty( $general_settings ) ) {
		add_option(
			'teachable_general_settings',
			array(
				'sync_time'   => '2:00 AM',
				'delete_data' => 0,
			)
		);
	} elseif ( isset( $general_settings['wp_key'] ) ) {
		$data_fetched = data_fetch( $general_settings['wp_key'] );

		if ( ! $data_fetched ) {
			wp_clear_scheduled_hook( __NAMESPACE__ . '\\sync_data' );
		} else {
			$sync_time = isset( $general_settings['sync_time'] ) ? $general_settings['sync_time'] : '2:00 AM';

			wp_clear_scheduled_hook( __NAMESPACE__ . '\\sync_data' );
			wp_schedule_event( strtotime( $sync_time ), 'daily', __NAMESPACE__ . '\\sync_data' );
		}
	}
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate' );

/**
 * Activation redirect.
 *
 * @version 1.0.0
 */
function activation_redirect() {
	if ( get_option( 'teachable_activated' ) === '1' ) {
		delete_option( 'teachable_activated' );

		if ( current_user_can( 'manage_options' ) ) {
			wp_safe_redirect( admin_url( 'options-general.php?page=teachable' ) );

			exit;
		}
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\\activation_redirect' );

/**
 * Deactivation.
 *
 * @version 1.0.0
 */
function deactivate() {
	$general_settings = get_option( 'teachable_general_settings' );

	if ( ! empty( $general_settings ) && ! empty( $general_settings['delete_data'] ) ) {
		delete_option( 'teachable_activated' );
		delete_option( 'teachable_general_settings' );
		delete_option( 'teachable_data' );
	}

	wp_clear_scheduled_hook( __NAMESPACE__ . '\\sync_data' );
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate' );
