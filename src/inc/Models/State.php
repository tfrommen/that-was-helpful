<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Models;

/**
 * State model.
 *
 * @package tfrommen\ThatWasHelpful\Models
 */
class State {

	/**
	 * @var bool
	 */
	private $is_active = FALSE;

	/**
	 * Sets the state to 'active'.
	 *
	 * @return void
	 */
	public function set_active() {

		$this->is_active = TRUE;
	}

	/**
	 * Returns whether the state is 'active'.
	 *
	 * @return bool
	 */
	public function is_active() {

		return $this->is_active;
	}

}
