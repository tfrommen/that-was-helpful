<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Controllers;

use tf\ThatWasHelpful\Models\Script;
use tf\ThatWasHelpful\Models\Style;

/**
 * Class Asset
 *
 * @package tf\ThatWasHelpful\Controllers
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
	 * Constructor. Set up the properties.
	 *
	 * @param Script $script Script model.
	 * @param Style  $style  Style model.
	 */
	public function __construct( Script $script, Style $style ) {

		$this->script = $script;

		$this->style = $style;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'wp_footer', array( $this->script, 'enqueue' ) );

		add_action( 'wp_footer', array( $this->style, 'enqueue' ) );
	}

}
