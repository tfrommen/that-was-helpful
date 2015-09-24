<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Models;

/**
 * Text domain model.
 *
 * @package tfrommen\ThatWasHelpful\Models
 */
class TextDomain {

	/**
	 * @var string
	 */
	private $domain;

	/**
	 * @var string
	 */
	private $path;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $file   Main plugin file.
	 * @param string $domain Text domain name.
	 * @param string $path   Text domain path.
	 */
	public function __construct( $file, $domain, $path ) {

		$this->domain = $domain;

		$this->path = plugin_basename( $file );
		$this->path = dirname( $this->path ) . $path;
	}

	/**
	 * Loads the text domain.
	 *
	 * @return bool
	 */
	public function load() {

		return load_plugin_textdomain( $this->domain, FALSE, $this->path );
	}

}
