<?php # -*- coding: utf-8 -*-

use tfrommen\ThatWasHelpful\Controllers\Settings as Testee;
use WP_Mock\Tools\TestCase;

class SettingsControllerTest extends TestCase {

	/**
	 * @covers tfrommen\ThatWasHelpful\Controllers\Settings::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		/** @var tfrommen\ThatWasHelpful\Models\Settings $model */
		$model = Mockery::mock( 'tfrommen\ThatWasHelpful\Models\Settings' );

		/** @var tfrommen\ThatWasHelpful\Views\SettingsPage $view */
		$view = Mockery::mock( 'tfrommen\ThatWasHelpful\Views\SettingsPage' );

		$testee = new Testee( $model, $view );

		WP_Mock::expectActionAdded( 'admin_menu', array( $view, 'add' ), PHP_INT_MAX );

		WP_Mock::expectActionAdded( 'admin_init', array( $model, 'register' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
