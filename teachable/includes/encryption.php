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
 * Encrypt key.
 *
 * @version 1.0.0
 */
function encryption_key() {
	return defined( 'TEACHABLE_ENCRYPTION_KEY' ) ? \TEACHABLE_ENCRYPTION_KEY : 'twiD*tK6Ynru_7atG9Ly3-D@-UwFENp82k_qrAd_.neAkeHt';
}

/**
 * Encrypt.
 *
 * @param string $unencrypted_string A string for encrypting.
 *
 * @version 1.0.0
 */
function encrypt( $unencrypted_string ) {
	if ( function_exists( 'openssl_encrypt' ) ) {
		return openssl_encrypt( $unencrypted_string, 'aes-256-cbc', encryption_key(), 0, substr( md5( encryption_key() ), 0, 16 ) );
	} else {
		return $unencrypted_string;
	}
}

/**
 * Decrypt.
 *
 * @param string $encrypted_string An encrypted string.
 *
 * @version 1.0.0
 */
function decrypt( $encrypted_string ) {
	if ( function_exists( 'openssl_decrypt' ) ) {
		return openssl_decrypt( $encrypted_string, 'aes-256-cbc', encryption_key(), 0, substr( md5( encryption_key() ), 0, 16 ) );
	} else {
		return $encrypted_string;
	}
}
