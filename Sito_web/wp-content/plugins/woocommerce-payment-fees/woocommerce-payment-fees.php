<?php
/*
Plugin Name:       WooCommerce Payment Fees Lite
Plugin URI:        https://wordpress.org/plugins/woocommerce-payment-fees/
Description:       A WooCommerce Extension that allows to add extra charges to your payment gateways
Version:           1.5.2
Author:            Pinch Of Code
Author URI:        http://pinchofcode.com
Textdomain:        wc_pf
Domain Path:       /i18n
License:           GPL-2
License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
GitHub Plugin URI: https://github.com/PinchOfCode/woocommerce-payment-fees
*/

/**
 * WooCommerce Payment Fees
 * Copyright (C) 2014 Pinch Of Code. All rights reserved.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Contact the author at info@pinchofcode.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'init', 'wc_pf_init' );
function wc_pf_init() {
    global $woocommerce;

    if( !isset( $woocommerce ) ) { return; }

    require_once( 'classes/class.wc-pf.php' );

    new WooCommerce_Payment_Fees();
}

add_filter( 'plugin_action_links', 'wc_pf_add_donate_link', 10, 4 );
function wc_pf_add_donate_link( $links, $file ) {
    if( $file == plugin_basename( __FILE__ ) ) {
        $donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=paypal@pinchofcode.com&item_name=Donation+for+Pinch+Of+Code" title="' . __( 'Donate', 'wc_pf' ) . '" target="_blank">' . __( 'Donate', 'wc_pf' ) . '</a>';
        array_unshift( $links, $donate_link );
    }

    return $links;
}

function wc_pf_debug() {
    $values = func_get_args();

    for( $i = 0; $i < count( $values ); $i++ ) {
        echo '<pre>Param ' . $i . ': ';
        var_dump( $values[$i] );
        echo '</pre>';
    }
}
