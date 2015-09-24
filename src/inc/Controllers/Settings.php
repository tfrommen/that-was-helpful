<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful\Controllers;

use tfrommen\ThatWasHelpful\Models\Settings as Model;
use tfrommen\ThatWasHelpful\Views\SettingsPage as View;

/**
 * Settings controller.
 *
 * @package tfrommen\ThatWasHelpful\Controllers
 */
class Settings {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param Model $model Settings model.
	 * @param View  $view  Settings page view.
	 */
	public function __construct( Model $model, View $view ) {

		$this->model = $model;

		$this->view = $view;
	}

	/**
	 * Wires up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'admin_menu', array( $this->view, 'add' ), PHP_INT_MAX );

		add_action( 'admin_init', array( $this->model, 'register' ) );
	}

}
