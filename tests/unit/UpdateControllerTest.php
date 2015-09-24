<?php # -*- coding: utf-8 -*-

use tfrommen\ThatWasHelpful\Controllers\Update as Testee;
use WP_Mock\Tools\TestCase;

class UpdateControllerTest extends TestCase {

	/**
	 * @covers       tfrommen\ThatWasHelpful\Controllers\Update::update
	 * @dataProvider provide_update_data
	 *
	 * @param bool   $expected
	 * @param string $version
	 * @param string $old_version
	 *
	 * @return void
	 */
	public function test_update( $expected, $version, $old_version ) {

		$testee = new Testee( $version );

		WP_Mock::wpFunction(
			'get_option',
			array(
				'times'  => 1,
				'args'   => array(
					Mockery::type( 'string' ),
				),
				'return' => $old_version,
			)
		);

		if ( $old_version !== $version ) {
			WP_Mock::wpFunction(
				'update_option',
				array(
					'times' => 1,
					'args'  => array(
						Mockery::type( 'string' ),
						$version,
					),
				)
			);
		}

		$this->assertSame( $expected, $testee->update() );

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_update_data() {

		$version = '9.9.9';

		return array(
			'no_version'      => array(
				'expected'    => TRUE,
				'version'     => $version,
				'old_version' => '',
			),
			'old_version'     => array(
				'expected'    => TRUE,
				'version'     => $version,
				'old_version' => '0',
			),
			'current_version' => array(
				'expected'    => FALSE,
				'version'     => $version,
				'old_version' => $version,
			),
		);
	}

}
