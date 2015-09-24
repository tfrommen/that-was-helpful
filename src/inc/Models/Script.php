<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Models;

/**
 * Script model.
 *
 * @package tfrommen\ThatWasHelpful\Models
 */
class Script {

	/**
	 * @var string
	 */
	private $action = 'that_was_helpful_update';

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var string
	 */
	private $handle = 'that-was-helpful';

	/**
	 * @var string
	 */
	private $nonce;

	/**
	 * @var State
	 */
	private $state;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $file  Main plugin file.
	 * @param State  $state State model.
	 * @param Nonce  $nonce Nonce object.
	 */
	public function __construct( $file, State $state, Nonce $nonce ) {

		$this->file = $file;

		$this->state = $state;

		$this->nonce = $nonce->get();
	}

	/**
	 * Returns the action.
	 *
	 * @return string
	 */
	public function get_action() {

		return $this->action;
	}

	/**
	 * Enqueues the script file.
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
		$file = 'assets/js/frontend' . $infix . '.js';
		$path = plugin_dir_path( $this->file );
		$version = filemtime( $path . $file );
		wp_enqueue_script(
			$this->handle,
			$url . $file,
			array( 'jquery' ),
			$version,
			TRUE
		);

		$data = array(
			'action' => $this->action,
			'nonce'  => $this->nonce,
			'url'    => admin_url( 'admin-ajax.php', 'relative' ),
		);
		wp_localize_script( $this->handle, 'tfThatWasHelpfulData', $data );
	}

}
