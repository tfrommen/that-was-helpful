<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Controllers;

use tfrommen\ThatWasHelpful\Models\Post as PostModel;
use tfrommen\ThatWasHelpful\Models\Script as ScriptModel;

/**
 * AJAX controller.
 *
 * @package tfrommen\ThatWasHelpful\Controllers
 */
class AJAX {

	/**
	 * @var string
	 */
	private $action;

	/**
	 * @var PostModel
	 */
	private $post;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param ScriptModel $script Script model.
	 * @param PostModel   $post   Post model.
	 */
	public function __construct( ScriptModel $script, PostModel $post ) {

		$this->action = $script->get_action();

		$this->post = $post;
	}

	/**
	 * Wires up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( "wp_ajax_{$this->action}", array( $this->post, 'update_ajax' ) );
	}

}
