<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
  /********************************************************************
  Version 2.0
    Front Page Dialog for Beslist
	  Copyright 2014 Purple Turtle Productions. All rights reserved.
		license	GNU General Public License version 3 or later; see GPLv3.txt
	By: Calvin 2014-09-09

  ********************************************************************/

class eBaySellerDlg extends PBaseFeedDialog 
{

	function __construct() 
	{
		parent::__construct();
		$this->service_name = 'eBaySeller';
		$this->service_name_long = 'eBay Seller';
		$this->plugin_link = "https://wordpress.org/plugins/exportfeed-list-woocommerce-products-on-ebay-store/";
		$this->options = array(
			'Category',
			'Title',
			'Description',
			'ConditionID',
			'picURL',
			'Quantity',
			'Format',
			'Duration',
			'Location',
			'StartPrice',
			'BuyItNowPrice',
			'Location',
			'ReturnsAcceptedOption',
			'ShippingType'
			);
		$this->doc_link = "https://www.exportfeed.com/documentation/ebay-seller-guide-2/";
	}

	// function convert_option($option) 
	// {
	// 	return strtolower(str_replace(" ", "_", $option));
	// }
}
