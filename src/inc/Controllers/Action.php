<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Controllers;

use tfrommen\ThatWasHelpful\Models\Post as PostModel;

/**
 * Action controller.
 *
 * @package tfrommen\ThatWasHelpful\Controllers
 */
class Action {

	/**
	 * @var PostModel
	 */
	private $post;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param PostModel $post Post model.
	 */
	public function __construct( PostModel $post ) {

		$this->post = $post;
	}

	/**
	 * Wires up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'template_redirect', array( $this->post, 'update_http' ) );
	}

}
