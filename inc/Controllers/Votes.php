<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Controllers;

use tf\ThatWasHelpful\Models;
use tf\ThatWasHelpful\Views\Votes as View;

/**
 * Class Votes
 *
 * @package tf\ThatWasHelpful\Controllers
 */
class Votes {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param View $view View.
	 */
	public function __construct( View $view ) {

		$this->view = $view;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		$this->maybe_add_filters();

		add_action( 'that_was_helpful', array( $this->view, 'render' ) );
	}

	/**
	 * According to the stored settings, maybe add filters for appending the votes' HTML to the content and/or excerpt.
	 *
	 * @return void
	 */
	private function maybe_add_filters() {

		$option = Models\Option::get();

		if ( ! empty( $option[ 'append_to_content' ] ) ) {
			$key = 'append_to_content_priority';
			$priority = isset( $option[ $key ] ) ? (int) $option[ $key ] : 10;
			add_filter( 'the_content', array( $this->view, 'append' ), $priority );
		}

		if ( ! empty( $option[ 'append_to_excerpt' ] ) ) {
			$key = 'append_to_excerpt_priority';
			$priority = isset( $option[ $key ] ) ? (int) $option[ $key ] : 10;
			add_filter( 'the_excerpt', array( $this->view, 'append' ), $priority );
		}
	}

}
