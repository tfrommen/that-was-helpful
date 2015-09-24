<?php # -*- coding: utf-8 -*-

namespace tfrommen\ThatWasHelpful;

/**
 * Main controller.
 *
 * @package tfrommen\ThatWasHelpful
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var string
	 */
	private $plugin_data;

	/**
	 * Constructor. Sets up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;

		$headers = array(
			'version'     => 'Version',
			'text_domain' => 'Text Domain',
			'domain_path' => 'Domain Path',
		);
		$this->plugin_data = get_file_data( $file, $headers );
	}

	/**
	 * Initializes the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$update_controller = new Controllers\Update( $this->plugin_data[ 'version' ] );
		$update_controller->update();

		$text_domain = new Models\TextDomain(
			$this->file,
			$this->plugin_data[ 'text_domain' ],
			$this->plugin_data[ 'domain_path' ]
		);
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
