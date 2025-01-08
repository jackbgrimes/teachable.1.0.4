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
 * Frontend error.
 *
 * @version 1.0.0
 */
add_action(
	'teachable_frontend_error',
	function ( $source = 'buy-button' ) {
		if ( 'buy-button' === $source ) {
			echo '<div class="teachable-buy-button"><div class="teachable-error-notice"><svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 0.166504C6.13996 0.166504 0.166626 6.13984 0.166626 13.4998C0.166626 20.8598 6.13996 26.8332 13.5 26.8332C20.86 26.8332 26.8333 20.8598 26.8333 13.4998C26.8333 6.13984 20.86 0.166504 13.5 0.166504ZM14.8333 20.1665H12.1666V17.4998H14.8333V20.1665ZM14.8333 14.8332H12.1666V6.83317H14.8333V14.8332Z" fill="#AE2D2D"/></svg><p class="teachable-error-description">' . esc_html__( 'This block is no longer available. Please contact the site administrator for assistance.', 'teachable' ) . '</p></div></div>';
		}
	},
	10,
	1
);
