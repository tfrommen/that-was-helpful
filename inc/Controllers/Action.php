<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Controllers;

use tf\ThatWasHelpful\Models\Post as PostModel;

/**
 * Class Action
 *
 * @package tf\ThatWasHelpful\Controllers
 */
class Action {

	/**
	 * @var PostModel
	 */
	private $post;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param PostModel $post Post model.
	 */
	public function __construct( PostModel $post ) {

		$this->post = $post;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'template_redirect', array( $this->post, 'update_http' ) );
	}

}
