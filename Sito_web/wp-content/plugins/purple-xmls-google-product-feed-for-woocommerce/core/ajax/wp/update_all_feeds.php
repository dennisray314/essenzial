<?php

/********************************************************************
 * Version 2.1
 * Update all the Feeds at once instead of having to wait for a Cron job
 * Copyright 2014 Purple Turtle Productions. All rights reserved.
 * license    GNU General Public License version 3 or later; see GPLv3.txt
 * By: Keneto 2014-05-23
 * 2014-07-09 Edited to add "successful" message -Keneto
 ********************************************************************/
if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!is_admin()) {
    die('Permission Denied!');
}
$feed_id = isset($_POST['feed_id']) ? $_POST['feed_id'] : '';
if(isset($_POST['deleteaction'])&&$_POST['deleteaction']=='true'){
	global $wpdb;
	$table = $wpdb->prefix.'cp_feeds';
   
   foreach ($feed_id as $key => $value) {
   	 $trans = $wpdb->query("DELETE FROM {$table} WHERE id = $value " );
   	 if(!$trans){
   	 	echo "There was problem in deleting product with id ".$value; exit;
   	 }
   }
   $response = array('msg'=>"Selected feed deleted successfully",'result'=>"success");
   echo json_encode($response); exit;

}
else{
	update_all_cart_feeds(false, $feed_id);

	echo 'Update successful';

}