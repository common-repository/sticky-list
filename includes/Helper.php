<?php
/**
 * Helper Class
 *
 * @package StickyList
 * @since 1.0.0
 */

namespace ultraDevs\SL;

/**
 * Helper Class
 *
 * @package StickyList
 * @since 1.0.0
 */
class Helper {

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Add Option
	 *
	 * @param string $key Option Key.
	 * @param mixed  $value Option Value.
	 */
	public static function add_option( $key, $value ) {
		// Add Option.
		add_option( $key, $value );
	}

	/**
	 * Get Option
	 *
	 * @param string $key Option Key.
	 * @param mixed  $default Option Default.
	 */
	public static function get_option( $key, $default = false ) {
		// Get Option.
		$value = get_option( $key, $default );
		return $value;
	}

	/**
	 * Update Option
	 *
	 * @param string $key Option Key.
	 * @param mixed  $value Option Value.
	 * @param mixed  $autoload Option Autoload.
	 */
	public static function update_option( $key, $value, $autoload = null ) {
		// Update Option.
		update_option( $key, $value, $autoload );
	}

	/**
	 * Delete Option
	 *
	 * @param string $key Option Key.
	 */
	public static function delete_option( $key ) {
		// Delete Option.
		delete_option( $key );
	}

	/**
	 * Multiple in_array
	 *
	 * @param array $needles needles.
	 * @param array $haystack haystack.
	 * @return boolean
	 */
	public function multiple_in_array( $needles, $haystack ) {
		return (bool) array_intersect( $needles, $haystack );
	}

	/**
	 * Time to Day(s) Converter
	 *
	 * @param int $time Time.
	 * @return int
	 */
	public static function time_to_days( $time ) {

		$current_time = current_time( 'timestamp' ); //phpcs:ignore
		return round( ( $current_time - $time ) / 24 / 60 / 60 );
	}

	/**
	 * Recursive sanitation for text or array
	 *
	 * @param (array|string) $array_or_string Array OR String.
	 * @since  0.1
	 * @return mixed
	 */
	public static function sanitize_text_or_array_field( $array_or_string ) {
		if ( is_string( $array_or_string ) ) {
			$array_or_string = sanitize_text_field( $array_or_string );
		} elseif ( is_array( $array_or_string ) ) {
			foreach ( $array_or_string as $key => &$value ) {
				if ( is_array( $value ) ) {
					$value = sanitize_text_or_array_field( $value );
				} else {
					$value = sanitize_text_field( $value );
				}
			}
		}

		return $array_or_string;
	}

	/**
	 * Plugin Icon
	 *
	 * @return string
	 */
	public static function get_icon() {
		return 'data:image/svg+xml;base64,' . base64_encode( '<svg height="20" xmlns="http://www.w3.org/2000/svg" role="img" viewBox="0 0 384 512"><script xmlns=""/><path fill="#ffffff" d="M280 240H168c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zm0 96H168c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h112c4.4 0 8-3.6 8-8v-16c0-4.4-3.6-8-8-8zM112 232c-13.3 0-24 10.7-24 24s10.7 24 24 24 24-10.7 24-24-10.7-24-24-24zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24 24-10.7 24-24-10.7-24-24-24zM336 64h-88.6c.4-2.6.6-5.3.6-8 0-30.9-25.1-56-56-56s-56 25.1-56 56c0 2.7.2 5.4.6 8H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM192 32c13.3 0 24 10.7 24 24s-10.7 24-24 24-24-10.7-24-24 10.7-24 24-24zm160 432c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16h48v20c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12V96h48c8.8 0 16 7.2 16 16v352z"/></svg>' );
	}
}
