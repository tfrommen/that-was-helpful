<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Controllers;

use tfrommen\ThatWasHelpful\Models\Script;
use tfrommen\ThatWasHelpful\Models\Style;

/**
 * Asset controller.
 *
 * @package tfrommen\ThatWasHelpful\Controllers
 */
class Asset {

	/**
	 * @var Script
	 */
	private $script;

	/**
	 * @var Style
	 */
	private $style;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param Script $script Script model.
	 * @param Style  $style  Style model.
	 */
	public function __construct( Script $script, Style $style ) {

		$this->script = $script;

		$this->style = $style;
	}

	/**
	 * Wires up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'wp_footer', array( $this->script, 'enqueue' ) );

		add_action( 'wp_footer', array( $this->style, 'enqueue' ) );
	}

}
