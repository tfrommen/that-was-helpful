<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Models;

/**
 * Class Option
 *
 * @package tf\ThatWasHelpful\Models
 */
class Option {

	/**
	 * @var string
	 */
	private static $name = 'that_was_helpful';

	/**
	 * Return the option name.
	 *
	 * @return string
	 */
	public static function get_name() {

		return self::$name;
	}

	/**
	 * Return the option value.
	 *
	 * @return array
	 */
	public static function get() {

		return get_option( self::$name, array() );
	}

	/**
	 * Update the option to the given value.
	 *
	 * @param array $value New option value.
	 *
	 * @return bool
	 */
	public static function update( array $value ) {

		return update_option( self::$name, $value );
	}

}
