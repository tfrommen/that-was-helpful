<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name: That Was Helpful
 * Plugin URI:  https://wordpress.org/plugins/that-was-helpful/
 * Description: Find out what posts logged-in users found helpful.
 * Author:      Thorsten Frommen
 * Author URI:  http://tfrommen.de
 * Version:     1.1.0
 * Text Domain: that-was-helpful
 * Domain Path: /languages
 * License:     GPLv3
 */

namespace tfrommen\ThatWasHelpful;

use tfrommen\Autoloader;

if ( ! function_exists( 'add_action' ) ) {
	return;
}

require_once __DIR__ . '/inc/Autoloader/bootstrap.php';

add_action( 'plugins_loaded', __NAMESPACE__ . '\initialize' );

/**
 * Initializes the plugin.
 *
 * @wp-hook plugins_loaded
 *
 * @return void
 */
function initialize() {

	$autoloader = new Autoloader\Autoloader();
	$autoloader->add_rule( new Autoloader\NamespaceRule( __DIR__ . '/inc', __NAMESPACE__ ) );

	$plugin = new Plugin( __FILE__ );
	$plugin->initialize();
}
