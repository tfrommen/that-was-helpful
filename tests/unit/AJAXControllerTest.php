<?php # -*- coding: utf-8 -*-

use tfrommen\ThatWasHelpful\Controllers\AJAX as Testee;
use WP_Mock\Tools\TestCase;

class AJAXControllerTest extends TestCase {

	/**
	 * @covers tfrommen\ThatWasHelpful\Controllers\AJAX::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		$action = 'action';

		/** @var tfrommen\ThatWasHelpful\Models\Script $script */
		$script = Mockery::mock( 'tfrommen\ThatWasHelpful\Models\Script' )
			->shouldReceive( 'get_action' )
			->andReturn( $action )
			->getMock();

		/** @var tfrommen\ThatWasHelpful\Models\Post $post */
		$post = Mockery::mock( 'tfrommen\ThatWasHelpful\Models\Post' );

		$testee = new Testee( $script, $post );

		WP_Mock::expectActionAdded( "wp_ajax_$action", array( $post, 'update_ajax' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
