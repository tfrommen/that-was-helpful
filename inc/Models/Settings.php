<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Models;

/**
 * Class Settings
 *
 * @package tf\ThatWasHelpful\Models
 */
class Settings {

	/**
	 * Register the settings.
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
	 * Sanitize the settings data.
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
