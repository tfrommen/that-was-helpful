<?php # -*- coding: utf-8 -*-

use tfrommen\ThatWasHelpful\Controllers\Asset as Testee;
use WP_Mock\Tools\TestCase;

class AssetControllerTest extends TestCase {

	/**
	 * @covers tfrommen\ThatWasHelpful\Controllers\Asset::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		/** @var tfrommen\ThatWasHelpful\Models\Script $script */
		$script = Mockery::mock( 'tfrommen\ThatWasHelpful\Models\Script' );

		/** @var tfrommen\ThatWasHelpful\Models\Style $style */
		$style = Mockery::mock( 'tfrommen\ThatWasHelpful\Models\Style' );

		$testee = new Testee( $script, $style );

		WP_Mock::expectActionAdded( 'wp_footer', array( $script, 'enqueue' ) );

		WP_Mock::expectActionAdded( 'wp_footer', array( $style, 'enqueue' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
