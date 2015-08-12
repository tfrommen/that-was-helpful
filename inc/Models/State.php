<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful\Models;

/**
 * Class State
 *
 * @package tf\ThatWasHelpful\Models
 */
class State {

	/**
	 * @var bool
	 */
	private $is_active = FALSE;

	/**
	 * Set the state to 'active'.
	 *
	 * @return void
	 */
	public function set_active() {

		$this->is_active = TRUE;
	}

	/**
	 * Return whether the state is 'active'.
	 *
	 * @return bool
	 */
	public function is_active() {

		return $this->is_active;
	}

}
