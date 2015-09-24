<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Models;

/**
 * Post model.
 *
 * @package tfrommen\ThatWasHelpful\Models
 */
class Post {

	/**
	 * @var string
	 */
	private $meta_key_prefix = '_that_was_helpful';

	/**
	 * @var Nonce
	 */
	private $nonce;

	/**
	 * @var int
	 */
	private $post_id = 0;

	/**
	 * Constructor. Sets up class variables.
	 *
	 * @param Nonce $nonce Nonce model object.
	 */
	public function __construct( Nonce $nonce ) {

		$this->nonce = $nonce;
	}

	/**
	 * Sets the post ID to the given value.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public function set_post_id( $post_id ) {

		$this->post_id = (int) $post_id;
	}

	/**
	 * Updates the post votes via an AJAX request.
	 *
	 * @wp-hook wp_ajax_{$action}
	 *
	 * @return void
	 */
	public function update_ajax() {

		$error = FALSE;

		if ( ! $this->nonce->is_valid() ) {
			$error = TRUE;
		}

		if ( ! $this->update() ) {
			$error = TRUE;
		}

		if ( $error ) {
			wp_send_json_error();
		}

		wp_send_json_success( $this->get_data() );
	}

	/**
	 * Updates the post votes.
	 *
	 * @return bool
	 */
	private function update() {

		$post_id = (int) filter_input( INPUT_POST, 'vote_post' );
		if ( ! $post_id ) {
			return FALSE;
		}

		$this->post_id = $post_id;

		$post = get_post( $post_id );
		if ( ! $post ) {
			return FALSE;
		}

		$current_vote = $this->get_user_vote();

		$this->update_vote( ! $current_vote );

		$meta_key = $this->meta_key_prefix . '_user_' . get_current_user_id();

		if ( $current_vote ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, TRUE );
		}

		return TRUE;
	}

	/**
	 * Returns the current user's vote.
	 *
	 * @return bool
	 */
	private function get_user_vote() {

		if ( ! is_user_logged_in() ) {
			return FALSE;
		}

		$meta_key = $this->meta_key_prefix . '_user_' . get_current_user_id();

		return (bool) get_post_meta( $this->post_id, $meta_key, TRUE );
	}

	/**
	 * Updates (i.e., increases or decreases) a vote.
	 *
	 * @param bool $add Add to this vote instead of removing from it?
	 *
	 * @return void
	 */
	private function update_vote( $add = TRUE ) {

		$updated = FALSE;
		while ( ! $updated ) {
			$meta_key = $this->meta_key_prefix . '_votes';

			$votes = get_post_meta( $this->post_id, $meta_key, TRUE );

			$new_votes = (int) $votes + ( $add ? 1 : -1 );

			$updated = update_post_meta( $this->post_id, $meta_key, $new_votes, $votes );
		}
	}

	/**
	 * Returns the data.
	 *
	 * @return object
	 */
	public function get_data() {

		if ( ! $this->post_id ) {
			$this->post_id = (int) get_the_ID();
		}

		$votes = (int) get_post_meta( $this->post_id, $this->meta_key_prefix . '_votes', TRUE );

		$description = _nx(
			'%d visitor found that helpful.',
			'%d visitors found that helpful.',
			$votes,
			'Vote description',
			'that-was-helpful'
		);
		$description = esc_html( $description );

		return (object) array(
			'description' => sprintf( $description, $votes ),
			'post_id'     => $this->post_id,
			'titles'      => array(
				'vote'   => esc_attr_x( 'That was helpful', 'Vote button title', 'that-was-helpful' ),
				'active' => esc_attr_x( 'Retract vote', 'Vote button title', 'that-was-helpful' ),
			),
			'vote'        => $this->get_user_vote(),
			'votes'       => $votes,
		);
	}

	/**
	 * Updates the post votes via an HTTP request.
	 *
	 * @wp-hook template_redirect
	 *
	 * @return void
	 */
	public function update_http() {

		if ( ! is_user_logged_in() ) {
			return;
		}

		if ( ! $this->nonce->is_valid() ) {
			return;
		}

		if ( ! $this->update() ) {
			return;
		}

		$url = filter_input( INPUT_POST, '_wp_http_referer' );
		$url = urldecode( $url );
		$url = esc_url( $url );
		wp_safe_redirect( $url );
	}

}
