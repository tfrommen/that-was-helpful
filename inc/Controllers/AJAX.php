<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Controllers;

use tf\ThatWasHelpful\Models\Post as PostModel;
use tf\ThatWasHelpful\Models\Script as ScriptModel;

/**
 * Class AJAX
 *
 * @package tf\ThatWasHelpful\Controllers
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
	 * Constructor. Set up the properties.
	 *
	 * @param ScriptModel $script Script model.
	 * @param PostModel   $post   Post model.
	 */
	public function __construct( ScriptModel $script, PostModel $post ) {

		$this->action = $script->get_action();

		$this->post = $post;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'wp_ajax_' . $this->action, array( $this->post, 'update_ajax' ) );
	}

}
