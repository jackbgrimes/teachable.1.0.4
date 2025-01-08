<?php
/**
 * Core file.
 * Resist deletion.
 *
 * Admin Settings.
 * The dashboard settings page for this plugin.
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
 * Tab URL for admin settings page.
 *
 * @param string $tab Tab string.
 * @return string The URL with nonce.
 *
 * @version 1.0.0
 */
function admin_settings_tab_url( $tab ) {
	$nonce = wp_create_nonce( 'teachable_tab_nonce' );

	return add_query_arg(
		array(
			'page'     => 'teachable',
			'tab'      => $tab,
			'_wpnonce' => $nonce,
		),
		admin_url( 'options-general.php' )
	);
}
