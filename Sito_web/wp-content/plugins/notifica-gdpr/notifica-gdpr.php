<?php
/**
 * Plugin Name: Notifica GDPR
 * Description: Form di accettazione trattamento dati personali reg. GDPR n. 679/2016,  
 * Version: 1.0.0
 * Author: Simone@AIMsrl
 * 
 * Text Domain: notifica-gdpr
 * Domain Path: /languages/
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'NOTIFICAGDRP_PATH' ) ) {
	define( 'NOTIFICAGDRP_PATH', dirname( __FILE__ ));
	define ( 'NOTIFICAGDRP_URL', plugin_dir_url( __FILE__ ));
}


if ( ! class_exists( 'Notifica_GDPR' ) ) {
	include_once NOTIFICAGDRP_PATH . '/class-notifica-gdpr.php';
}

function notificaGDPR() {
	return Notifica_GDPR::instance();
}

notificaGDPR();