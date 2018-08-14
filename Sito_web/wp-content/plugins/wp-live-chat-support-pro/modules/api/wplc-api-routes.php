<?php 

/* Handles all routes related to the WP Live Chat Support API */


add_action('rest_api_init', 'wplc_pro_rest_routes_init');
function wplc_pro_rest_routes_init() {
	register_rest_route('wp_live_chat_support/v1','/typing', array(
						'methods' => 'GET, POST',
						'callback' => 'wplc_api_is_typing'
	));

	do_action("wplc_api_route_hook");
}