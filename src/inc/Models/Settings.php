<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Models;

/**
 * Settings model.
 *
 * @package tfrommen\ThatWasHelpful\Models
 */
class Settings {

	/**
	 * Registers the settings.
	 *
	 * @wp-hook admin_init
	 *
	 * @return void
	 */
	public function register() {

		$option_name = Option::get_name();
		register_setting(
			$option_name,
			$option_name,
			array( $this, 'sanitize' )
		);
	}

	/**
	 * Sanitizes the settings data.
	 *
	 * @param array $data Settings data.
	 *
	 * @return array
	 */
	public function sanitize( $data ) {

		$sanitized_data = array();

		foreach ( array( 'content', 'excerpt' ) as $element ) {
			$key = "append_to_$element";
			if ( isset( $data[ $key ] ) ) {
				$sanitized_data[ $key ] = TRUE;
			}

			$key .= '_priority';
			if (
				isset( $data[ $key ] )
				&& is_numeric( $data[ $key ] )
			) {
				$sanitized_data[ $key ] = (int) $data[ $key ];
			}
		}

		return $sanitized_data;
	}

}
