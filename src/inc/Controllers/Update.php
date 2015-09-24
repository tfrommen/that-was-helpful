<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Controllers;

/**
 * Update controller.
 *
 * @package tfrommen\ThatWasHelpful\Controllers
 */
class Update {

	/**
	 * @var string
	 */
	private $version;

	/**
	 * @var string
	 */
	private $version_option_name = 'that_was_helpful_version';

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $version Current plugin version.
	 */
	public function __construct( $version ) {

		$this->version = $version;
	}

	/**
	 * Returns the option name for the plugin version.
	 *
	 * @return string
	 */
	public function get_version_option_name() {

		return $this->version_option_name;
	}

	/**
	 * Updates the plugin.
	 *
	 * @return bool
	 */
	public function update() {

		$old_version = (string) get_option( $this->version_option_name );
		if ( $old_version === $this->version ) {
			return FALSE;
		}

		update_option( $this->version_option_name, $this->version );

		return TRUE;
	}

}
