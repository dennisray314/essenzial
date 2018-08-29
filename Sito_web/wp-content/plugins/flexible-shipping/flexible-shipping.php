<?php
/*
	Plugin Name: Flexible Shipping
	Plugin URI: https://wordpress.org/plugins/flexible-shipping/
	Description:  Create additional shipment methods in WooCommerce and enable pricing based on cart weight or total.
	Version: 2.1.6
	Author: WP Desk
	Author URI: https://www.wpdesk.net/
	Text Domain: flexible-shipping
	Domain Path: /languages/
	Requires at least: 4.5
    Tested up to: 4.9.6
    WC requires at least: 3.0.0
    WC tested up to: 3.4.3

	Copyright 2017 WP Desk Ltd.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$plugin_version = '2.1.6';

define( 'FLEXIBLE_SHIPPING_VERSION', $plugin_version );

require_once( __DIR__ . '/vendor/autoload.php' );

require_once( 'classes/tracker.php' );

require_once( dirname( __FILE__ ) . '/classes/wpdesk/class-requirement-checker.php' );

$requirements_checker = new WPDesk_Requirement_Checker_1_10(
	__FILE__,
	'5.5',
	'4.5',
	'2.6.14'
);

$requirements_checker
	->add_plugin_require( 'woocommerce/woocommerce.php', 'WooCommerce' );

$requirements_checker->check_requirements_and_load_plugin_deferred();

add_action( 'plugins_loaded', 'flexible_shipping_plugins_loaded', 9 );
if ( ! function_exists( 'flexible_shipping_plugins_loaded' ) ) {
	function flexible_shipping_plugins_loaded() {
		if ( ! function_exists( 'should_enable_wpdesk_tracker' ) ) {
			function should_enable_wpdesk_tracker() {
				$tracker_enabled = true;
				if ( ! empty( $_SERVER['SERVER_ADDR'] ) && $_SERVER['SERVER_ADDR'] === '127.0.0.1' ) {
					$tracker_enabled = false;
				}

				return apply_filters( 'wpdesk_tracker_enabled', $tracker_enabled );
			}
		}

		$tracker_factory = new WPDesk_Tracker_Factory();
		$tracker_factory->create_tracker( basename( dirname( __FILE__ ) ) );
	}
}
