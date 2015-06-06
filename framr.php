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
require_once('includes/class-framr-templates.php' );
/**
 * Returns the main instance of Framr to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Framr
 */



function sendFrameInfo(){
  $emailAddress = get_option('wpt_widget_email_field');
  $thankyou = get_option('wpt_text_block');
  $footage = $_POST["footage"];
  $sender = $_POST["sender"];

  $messageString = sprintf("%s has requested a frame with dimensions %s", $footage, $sender);
  
  $subject = "New Frame quote - ". date("Y-m-d H:i:s") ." - frame thing";
  $thankYouSubject = "Thank You For Requesting a Quote From Hector";

  $message = "New Frame quote - ". date("Y-m-d H:i:s") ." - frame thing";
  $message .= "\r\n";
  $message .= $messageString;

  wp_mail($sender, $thankYouSubject, $thankyou, null, null);

  echo wp_mail($emailAddress, $subject, $message, null, null );
  wp_die();
}

function queryFrames() {
    $new = new WP_Query('post_type=frame');
    $response = array();
//    $response["frames_raw"] = $new->posts;
    $response["frames"] = array();
    while ($new->have_posts()) : $new->the_post();
//       var_dump();
    
       $response["frames"][get_the_ID()] = array();
       $response["frames"][get_the_ID()]["title"] = get_the_title();
       $response["frames"][get_the_ID()]["description"] = get_the_content();
       $response["frames"][get_the_ID()]["frame_thumb"] = wp_get_attachment_image_src( get_post_thumbnail_id());
       $response["frames"][get_the_ID()]["frame_meta"] = get_post_meta( get_the_ID());
    endwhile;
    echo json_encode($response);   
    wp_die(); // this is required to terminate immediately and return a proper response
}




function Framr () {
	$instance = Framr::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Framr_Settings::instance( $instance );
	}

	return $instance;
}


function GetPluginOptionsFields(){

  return $optionArray = array(
    'featuredImage' => get_option('wpt_an_image'),
    'checkBox' => get_option('wpt_multiple_checkboxes')
    );

 }

function setScriptData(){

add_action( 'wp_ajax_nopriv_queryFrames', 'queryFrames' );  
add_action( 'wp_ajax_queryFrames', 'queryFrames' ); 

add_action( 'wp_ajax_nopriv_sendFrameInfo', 'sendFrameInfo' );  
add_action( 'wp_ajax_sendFrameInfo', 'sendFrameInfo' ); 


wp_register_script('framr-widget-script', plugins_url( 'Framr/assets/js/widget.js' ));
wp_localize_script( 'framr-widget-script', 'FramerPlugin', GetPluginOptionsFields() );

}

Framr();

$framr = Framr();
Framr()->register_post_type( 'frame', __( 'Frames', 'framr' ), __( 'Frame', 'framr' ) );

$post_type_metaboxes = new Frame_Post_Type_Metaboxes;
$post_type_metaboxes->init();
add_action( 'widgets_init', create_function( '', 'register_widget("Framr_Widget");' ) );
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

setScriptData();



