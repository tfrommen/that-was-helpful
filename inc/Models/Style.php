<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Models;

/**
 * Class Style
 *
 * @package tf\ThatWasHelpful\Models
 */
class Style {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var State
	 */
	private $state;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file  Main plugin file.
	 * @param State  $state State model.
	 */
	public function __construct( $file, State $state ) {

		$this->file = $file;

		$this->state = $state;
	}

	/**
	 * Enqueue the script file.
	 *
	 * @wp-hook wp_footer
	 *
	 * @return void
	 */
	public function enqueue() {

		if ( ! $this->state->is_active() ) {
			return;
		}

		$url = plugin_dir_url( $this->file );
		$infix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$file = 'assets/css/frontend' . $infix . '.css';
		$path = plugin_dir_path( $this->file );
		$version = filemtime( $path . $file );
		wp_enqueue_style(
			'that-was-helpful',
			$url . $file,
			array(),
			$version
		);
	}

}
