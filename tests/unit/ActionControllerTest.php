<?php # -*- coding: utf-8 -*-

use tfrommen\ThatWasHelpful\Controllers\Action as Testee;
use WP_Mock\Tools\TestCase;

class ActionControllerTest extends TestCase {

	/**
	 * @covers tfrommen\ThatWasHelpful\Controllers\Action::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		/** @var tfrommen\ThatWasHelpful\Models\Post $post */
		$post = Mockery::mock( 'tfrommen\ThatWasHelpful\Models\Post' );

		$testee = new Testee( $post );

		WP_Mock::expectActionAdded( 'template_redirect', array( $post, 'update_http' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
