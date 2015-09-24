<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Models;

/**
 * Nonce model.
 *
 * @package tfrommen\ThatWasHelpful\Models
 */
class Nonce {

	/**
	 * @var string
	 */
	private $action;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $action Nonce action.
	 * @param string $name   Optional. Nonce name. Defaults to '{$action}_nonce'.
	 */
	public function __construct( $action, $name = '' ) {

		$this->action = $action;

		$this->name = empty( $name ) ? "{$action}_nonce" : $name;
	}

	/**
	 * Returns the nonce action.
	 *
	 * @return string
	 */
	public function get_action() {

		return $this->action;
	}

	/**
	 * Returns the nonce name.
	 *
	 * @return string
	 */
	public function get_name() {

		return $this->name;
	}

	/**
	 * Returns the nonce value.
	 *
	 * @param string $action Optional. Nonce action. Defaults to the default action.
	 *
	 * @return string
	 */
	public function get( $action = '' ) {

		$action = empty( $action ) ? $this->action : $action;

		return wp_create_nonce( $action );
	}

	/**
	 * Prints the input element for the nonce. Unless $referer is set to FALSE, a referer input is printed, too.
	 *
	 * @param string $action  Optional. Nonce action. Defaults to the default action.
	 * @param bool   $referer Optional. Print the referer field? Defaults to TRUE.
	 *
	 * @return void
	 */
	public function print_field( $action = '', $referer = TRUE ) {

		$this->get_field( $action, $referer, TRUE );
	}

	/**
	 * Returns the input element for the nonce. Unless $referer is set to FALSE, a referer input is returned, too.
	 *
	 * @param string $action  Optional. Nonce action. Defaults to the default action.
	 * @param bool   $referer Optional. Print the referer field? Defaults to TRUE.
	 * @param bool   $echo    Optional. Echo the field? Defaults to FALSE.
	 *
	 * @return string
	 */
	public function get_field( $action = '', $referer = TRUE, $echo = FALSE ) {

		$action = empty( $action ) ? $this->action : $action;

		return wp_nonce_field( $action, $this->name, $referer, $echo );
	}

	/**
	 * Checks if the given nonce is valid. If no nonce is given, the according field of the $_REQUEST superglobal is
	 * checked.
	 *
	 * @param string $nonce  Optional. Nonce value. Defaults to the request value with the key being the nonce name.
	 * @param string $action Optional. Nonce action. Defaults to the default action.
	 *
	 * @return bool
	 */
	public function is_valid( $nonce = '', $action = '' ) {

		if ( empty( $nonce ) ) {
			if ( empty( $_REQUEST[ $this->name ] ) ) {
				return FALSE;
			}

			$nonce = $_REQUEST[ $this->name ];
		}

		$action = $action === '' ? $this->action : $action;

		return wp_verify_nonce( $nonce, $action );
	}

}
