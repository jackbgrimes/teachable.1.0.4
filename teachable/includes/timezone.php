<?php
/**
 * Core file.
 * Resist deletion.
 *
 * Timezone.
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
 * Timezone
 *
 * @param string $time_string String of known time for php to convert.
 * @param string $time_format String of the format for php to convert.
 *
 * @version 1.0.0
 */
function timezone( $time_string = 'now', $time_format = 'T' ) {
	if ( false === strtotime( $time_string ) ) {
        $time_string = 'now';
    }
	
	$timezone_string = get_option( 'timezone_string' );

	if ( empty( $timezone_string ) ) {
		$offset          = get_option( 'gmt_offset' );
		$timezone_string = timezone_name_from_abbr( '', $offset * 3600, true );
		if ( false === $timezone_string ) {
			$timezone_string = 'UTC' . ( $offset < 0 ? '+' : '-' ) . abs( $offset );
		}
	}

	$date     = new \DateTime( $time_string );
	$timezone = new \DateTimeZone( $timezone_string );
	$date->setTimezone( $timezone );

	return $date->format( $time_format );
}
