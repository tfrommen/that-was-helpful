<?php # -*- coding: utf-8 -*-

namespace tfrommen\Autoloader;

/**
 * Autoloader class.
 *
 * @package tfrommen\Autoloader
 */
class Autoloader {

	/**
	 * @var Rule[]
	 */
	private $rules = array();

	/**
	 * Constructor. Registers to the spl autoload stack.
	 */
	public function __construct() {

		spl_autoload_register( array( $this, 'autoload' ) );
	}

	/**
	 * Adds an autoloader rule.
	 *
	 * @param Rule $rule Autoloader rule object.
	 *
	 * @return void
	 */
	public function add_rule( Rule $rule ) {

		$this->rules[] = $rule;
	}

	/**
	 * Loads a class or an interface.
	 *
	 * @param string $name Class or interface name.
	 *
	 * @return bool
	 */
	public function autoload( $name ) {

		foreach ( $this->rules as $rule ) {
			if ( $rule->autoload( $name ) ) {
				return TRUE;
			}
		}

		return FALSE;
	}

}
