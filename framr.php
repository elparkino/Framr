<?php
/*
 * Plugin Name: Framr
 * Version: 1.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: framr
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-framr.php' );
require_once( 'includes/class-framr-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-framr-admin-api.php' );
require_once( 'includes/lib/class-framr-post-type.php' );
require_once( 'includes/lib/class-framr-taxonomy.php' );

/**
 * Returns the main instance of Framr to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Framr
 */
function Framr () {
	$instance = Framr::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Framr_Settings::instance( $instance );
	}

	return $instance;
}

Framr();