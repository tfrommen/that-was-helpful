<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Models;

use tfrommen\ThatWasHelpful\Controllers;
use tfrommen\ThatWasHelpful\Views;

/**
 * Settings page model.
 *
 * @package tfrommen\ThatWasHelpful\Models
 */
class SettingsPage {

	/**
	 * @var string
	 */
	private $capability;

	/**
	 * @var string
	 */
	private $slug = 'that_was_helpful';

	/**
	 * Constructor. Sets up the properties.
	 */
	public function __construct() {

		/**
		 * Filters the capability required to manage the settings.
		 *
		 * @param string $capability Capability required to manage the settings.
		 */
		$this->capability = apply_filters( 'that_was_helpful_capability', 'manage_options' );
	}

	/**
	 * Returns the capability required to manage the settings.
	 *
	 * @return string
	 */
	public function get_capability() {

		return $this->capability;
	}

	/**
	 * Returns the page slug.
	 *
	 * @return string
	 */
	public function get_slug() {

		return $this->slug;
	}

}
