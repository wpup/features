<?php

/**
 * Plugin Name: Features
 * Description: WordPress setting page for feature flagging interface/implementation.
 * Author: Fredrik Forsmo
 * Author URI: https://frozzare.com
 * Version: 1.0.0
 * Plugin URI: https://github.com/wpup/features
 * Textdomain: features
 * Domain Path: /languages/
 */

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Bootstrap plugin.
 */
add_action( 'plugins_loaded', function () {
    WPUP\Features\Features::instance();
} );
