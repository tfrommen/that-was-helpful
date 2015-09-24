<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Controllers;

use tfrommen\ThatWasHelpful\Models;
use tfrommen\ThatWasHelpful\Views\Votes as View;

/**
 * Votes controller.
 *
 * @package tfrommen\ThatWasHelpful\Controllers
 */
class Votes {

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param View $view View.
	 */
	public function __construct( View $view ) {

		$this->view = $view;
	}

	/**
	 * Wires up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		$this->maybe_add_filters();

		add_action( 'that_was_helpful', array( $this->view, 'render' ) );
	}

	/**
	 * According to the stored settings, maybe adds filters for appending the votes HTML to the content and/or excerpt.
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
