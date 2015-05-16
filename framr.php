<?php
/*
 * Plugin Name: Framr
 * Version: 1.0
 * Plugin URI: http://www.hectorframing.com/
 * Description: This is a frame size calculator for Hector
 * Author: Parker Jones
 * Author URI: http://www.hectorframing.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: framr
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Parker Jones
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
require_once( 'includes/class-framr-metaboxes.php' );
require_once( 'includes/class-framr-widget.php' );
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

$framr = Framr();
Framr()->register_post_type( 'frame', __( 'Frames', 'framr' ), __( 'Frame', 'framr' ) );

$post_type_metaboxes = new Frame_Post_Type_Metaboxes;
$post_type_metaboxes->init();
add_action( 'widgets_init', create_function( '', 'register_widget("Framr_Widget");' ) );

