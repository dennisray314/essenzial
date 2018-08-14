<?php
/***********************************************************
 * Plugin Name: ExportFeed - Create Product Feeds For 40+ Merchants
 * Plugin URI: www.exportfeed.com
 * Description: WooCommerce Product Feed Export :: <a target="_blank" href="http://www.exportfeed.com/tos/">How-To Click Here</a>
 * Author: ExportFeed.com
 * Version: 3.1.8.5
 * Author URI: www.exportfeed.com
 * Authors: Haris, Keneto (May2014)
 * Note: The "core" folder is shared to the Joomla component.
 * Changes to the core, especially /core/data, should be considered carefully
 * Note: "purple" term exists from legacy plugin name. Classnames in "P" for the same reason
 * Copyright 2015 WRI HK Ltd. All rights reserved.
 * license GNU General Public License version 3 or later; see GPLv3.txt
 ***********************************************************/
// Create a helper function for easy SDK access.
if (!defined('ABSPATH')) exit; // Exit if accessed directly
function pxgpffw_fs()
{
    global $pxgpffw_fs;

    if (!isset($pxgpffw_fs)) {
        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $pxgpffw_fs = fs_dynamic_init(array(
            'id' => '145',
            'slug' => 'purple-xmls-google-product-feed-for-woocommerce',
            'public_key' => 'pk_273f3403b22ff403ec780f5254e2e',
            'is_premium' => false,
            'has_addons' => false,
            'has_paid_plans' => false,
            'menu' => array(
                'slug' => 'cart-product-feed-admin',
                'account' => false
            ),
        ));
    }

    return $pxgpffw_fs;
}

function pxgpffw_fs_support_url($support_forum_url)
{
    return 'http://www.exportfeed.com/support/';
}

function pxgpffw_fs_support_submenu($support_forum_submenu)
{
    return __fs('support');
}

pxgpffw_fs()->add_filter('support_forum_url', 'pxgpffw_fs_support_url');
pxgpffw_fs()->add_filter('support_forum_submenu', 'pxgpffw_fs_support_submenu');


require_once ABSPATH . 'wp-admin/includes/plugin.php';
$plugin_version_data = get_plugin_data(__FILE__);
//current version: used to show version throughout plugin pages
define('FEED_PLUGIN_VERSION', $plugin_version_data['Version']);
define('CPF_PLUGIN_BASENAME', plugin_basename(__FILE__)); //cart-product-feed/cart-product-feed.php
define('CPF_PATH', realpath(dirname(__FILE__)));
define('CPF_URL', plugins_url() . '/' . basename(dirname(__FILE__)) . '/');
//functions to display cart-product-feed version and checks for updates
include_once('cart-product-information.php');

//action hook for plugin activation
register_activation_hook(__FILE__, 'cart_product_activate_plugin');
register_deactivation_hook(__FILE__, 'cart_product_deactivate_plugin');

global $cp_feed_order, $cp_feed_order_reverse;

require_once 'core/classes/cron.php';
require_once 'core/data/feedfolders.php';

if (get_option('cp_feed_order_reverse') == '')
    add_option('cp_feed_order_reverse', false);

if (get_option('cp_feed_order') == '')
    add_option('cp_feed_order', "id");

if (get_option('cp_feed_delay') == '')
    add_option('cp_feed_delay', "43200");

if (get_option('cp_licensekey') == '')
    add_option('cp_licensekey', "none");

if (get_option('cp_localkey') == '')
    add_option('cp_localkey', "none");

//***********************************************************
// cron schedules for Feed Updates
//***********************************************************

PCPCron::doSetup();
PCPCron::scheduleUpdate();

//***********************************************************
// Update Feeds (Cron)
//   2014-05-09 Changed to now update all feeds... not just Google Feeds
//***********************************************************

add_action('update_cartfeeds_hook', 'update_all_cart_feeds');

function update_all_cart_feeds($doRegCheck = true, $feed_id = array())
{

    require_once 'cart-product-wpincludes.php'; //The rest of the required-files moved here
    require_once 'core/data/savedfeed.php';

    $reg = new PLicense();
    if ($doRegCheck && ($reg->results["status"] != "Active"))
        return;

    do_action('load_cpf_modifiers');
    add_action('get_feed_main_hook', 'update_all_cart_feeds_step_2');
    do_action('get_feed_main_hook', $feed_id);
}

function update_all_cart_feeds_step_2($feed_id)
{
    global $wpdb;
    $feed_table = $wpdb->prefix . 'cp_feeds';
    $where = '';
    if (is_array($feed_id) && !empty($feed_id)) {
        $feed_id = implode(',', $feed_id);
        $where = ' WHERE id IN ' . '(' . $feed_id . ') ';
    }
    $sql = 'SELECT id, type, filename FROM ' . $feed_table . $where;
    $feed_ids = $wpdb->get_results($sql);
    $savedProductList = null;

    //***********************************************************
    //Build stack of aggregate providers
    //***********************************************************
    $aggregateProviders = array();
    foreach ($feed_ids as $this_feed_id) {

        if ($this_feed_id->type == 'AggXml' || $this_feed_id->type == 'AggXmlGoogle' || $this_feed_id->type == 'AggCsv' || $this_feed_id->type == 'AggTxt' || $this_feed_id->type == 'AggTsv') {
            $providerName = $this_feed_id->type;
            $providerFile = 'core/feeds/' . strtolower($providerName) . '/feed.php';
            if (!file_exists(dirname(__FILE__) . '/' . $providerFile))
                continue;
            require_once $providerFile;

            //Initialize provider data
            $providerClass = 'P' . $providerName . 'Feed';
            $x = new $providerClass(null);
            $x->initializeAggregateFeed($this_feed_id->id, $this_feed_id->filename);
            $aggregateProviders[] = $x;
        };
    }

    //***********************************************************
    //Main
    //***********************************************************
    foreach ($feed_ids as $index => $this_feed_id) {

        $saved_feed = new PSavedFeed($this_feed_id->id);

        $providerName = $saved_feed->provider;

        //Skip any Aggregate Types
        if ($providerName == 'AggXml' || $providerName == 'AggXmlGoogle' || $providerName == 'AggCsv' || $providerName == 'AggTxt' || $providerName == 'AggTsv')
            continue;

        //Make sure someone exists in the core who can provide the feed
        $providerFile = 'core/feeds/' . strtolower($providerName) . '/feed.php';
        if (!file_exists(dirname(__FILE__) . '/' . $providerFile))
            continue;
        require_once $providerFile;

        //Initialize provider data
        $providerClass = 'P' . $providerName . 'Feed';
        $x = new $providerClass();
        $x->aggregateProviders = $aggregateProviders;
        $x->savedFeedID = $saved_feed->id;

        $x->productList = $savedProductList;
        $x->getFeedData($saved_feed->category_id, $saved_feed->remote_category, $saved_feed->filename, $saved_feed);

        $savedProductList = $x->productList;
        $x->products = null;

    }

    foreach ($aggregateProviders as $thisAggregateProvider)
        $thisAggregateProvider->finalizeAggregateFeed();

}

//***********************************************************
// Links From the Install Plugins Page (WordPress)
//***********************************************************

if (is_admin()) {

    require_once 'cart-product-feed-admin.php';
    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_" . $plugin, 'cart_product_manage_feeds_link');

}

//***********************************************************
//Function to create feed generation link  in installed plugin page
//***********************************************************
function cart_product_manage_feeds_link($links)
{

    $settings_link = '<a href="admin.php?page=cart-product-feed-manage-page">Manage Feeds</a>';
    array_unshift($links, $settings_link);
    return $links;

}