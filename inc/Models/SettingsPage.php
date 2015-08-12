<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Models;

use tf\ThatWasHelpful\Controllers;
use tf\ThatWasHelpful\Views;

/**
 * Class SettingsPage
 *
 * @package tf\ThatWasHelpful\Models
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
	 * Constructor. Set up the properties.
	 */
	public function __construct() {

		/**
		 * Filter the capability required to manage the settings.
		 *
		 * @param string $capability Capability required to manage the settings.
		 */
		$this->capability = apply_filters( 'that_was_helpful_capability', 'manage_options' );
	}

	/**
	 * Return the capability required to manage the settings.
	 *
	 * @return string
	 */
	public function get_capability() {

		return $this->capability;
	}

	/**
	 * Return the page slug.
	 *
	 * @return string
	 */
	public function get_slug() {

		return $this->slug;
	}

}
