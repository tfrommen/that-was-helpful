<?php # -*- coding: utf-8 -*-

namespace tf\ThatWasHelpful;

/**
 * Class Plugin
 *
 * @package tf\ThatWasHelpful
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$text_domain = new Models\TextDomain( $this->file );
		$text_domain->load();

		$state = new Models\State();

		$nonce = new Models\Nonce( 'that_was_helpful_update', '_wpnonce' );

		$script = new Models\Script( $this->file, $state, $nonce );

		$post = new Models\Post( $nonce );

		if ( is_admin() ) {
			$ajax_controller = new Controllers\AJAX( $script, $post );
			$ajax_controller->initialize();

			$settings = new Models\Settings();
			$settings_page = new Models\SettingsPage();
			$settings_page_view = new Views\SettingsPage( $settings_page );
			$settings_controller = new Controllers\Settings( $settings, $settings_page_view );
			$settings_controller->initialize();
		} else {
			$action_controller = new Controllers\Action( $post );
			$action_controller->initialize();

			$votes_view = new Views\Votes( $state, $post, $nonce );
			$votes_controller = new Controllers\Votes( $votes_view );
			$votes_controller->initialize();

			$style = new Models\Style( $this->file, $state );
			$asset_controller = new Controllers\Asset( $script, $style );
			$asset_controller->initialize();
		}
	}

}
