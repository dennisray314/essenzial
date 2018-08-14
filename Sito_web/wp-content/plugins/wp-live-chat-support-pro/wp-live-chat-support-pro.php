<?php
/*
  Plugin Name: WP Live Chat Support Pro
  Plugin URI: http://wp-livechat.com
  Description: The Pro version of the easiest to use website live chat plugin. Let your visitors chat with you and increase sales conversion rates with WP Live Chat. No third party connection required!
  Version: 7.0.05
  Author: WP Live Chat
  Author URI: http://wp-livechat.com
 */
 

/**
 * 7.0.05 - 2017-05-16 - Medium priority
 * Fixed a bug that caused the offline message box to not show up when outside of "business hours"
 * Added ability to exclude pages with custom post types
 * 
 * 7.0.04 - 2017-03-13 - Medium Priority
 * Bug Fix: Bad function call to decrypting messages has been fixed
 * 
 * 7.0.03 - 2017-02-15
 * Better handling of the agent name in the 'is typing' functionality
 * 
 * 7.0.02 - 2017-02-03
 * Fixed a styling issue that affexted images being sent via the chat
 * 
 * 7.0.01 - 2017-01-26 - High priority
 * Removed our copy of PHPMailer (contained a vulnerability). The plugin now uses WP's built-in version of PHPMailer which includes the vulnerability patch
 * 
 * 7.0.00 - 2016-12-14
 * Changed the `msg` column to LONGTEXT to accommodate longer system notifications
 * Changed the way we display when an agent or user is typing
 * Added documentation suggestions
 * Added system notifications for both agents and users
 * Ability to add custom fields to the chat box
 * Ability to create departments 
 * Ability to transfer chats between agents and departments
 * Ability to send an auto responder when a new offline message has been received
 * Ability to set business hours for that
 * Performance improvements made to the typing indicator 
 * 
 * 6.3.01 - 2016-10-27
 * Fixed a bug that caused the settings page to return a 403 error on some sites 
 * Fixed a bug that prevented some messages from not being encrypted
 * 
 * 6.3.00 - 2016-09-15
 * Added ROI Functionality
 * Added ROI Reporting
 *
 * 6.2.03 - 2016-08-29
 * Fixed a bug where time triggers would start when page loads. Time triggers now only run after the initial 'chat delay'
 *
 * 6.2.02 - 2016-08-23 
 * Fixed a compatibility issue when using data triggers and PHP 5.3.x or under 
 *
 * 6.2.01 - 2016-08-22
 * Fixed a bug in teh data triggers module
 *
 * 6.2.00 - 2016-08-22
 * Added Data Triggers
 * Added User Experience Ratings to Reporting Area
 * Added ability to switch to using WordPress Display name for agents
 * Fixed a bug where the admin name was showing incorreclty in the admin chat area
 * Fixed a bug where inlcude/exclude functionality would not work on SSL sites
 *
 * 6.1.02 - 2016-07-19
 * Selectionstart bug fixed
 * Agent online count bug fixed
 * Fixed a bug that stopped the quick responses from working when using the cloud extension
 * Added support for cloud server chat ratings
 *
 * 6.1.01 - 2016-06-13
 * Fixed a bug that caused the number of agents online to display as zero
 * 
 * 6.1.00 - 2016-06-10 - High priority
 * Display a typing indicator when the agent or visitor starts typing
 * Long poll does not run when offline or when you have selected to not accept chats
 * You can now add social media icons to your chat box (visitor side)
 * New text editor feature - add bold, italic, strikethrough, subscript and more
 * New file sharing feature - share images, videos, pdfs any other type of file except for executable files
 * Bug fix - Length of undefined in Edge Browser - When opening chat box
 * The plugin does not call on the server to check a blank API key
 * Fixed the bug that stopped email addresses such as "name@domain.tld" from validating
 * You can now change the ring tone of incoming chats
 * Advanced options to control the long poll variables
 * You can now disable the initiate chat feature which will substantially improve performance
 * New chat experience rating feature - get real time feedback from your visitors
 * New reporting feature - view reports for chats, agents and top pages
 * Many other smaller bug fixes
 * 
 * 6.0.02 - 2016-04-07 - Low Priority
 * Fixed a bug that caused a warning when deactivating in the 'Choose When Online' deactivation hook
 * The plugin does not call on the server to check a blank API key
 * Long poll does not run when offline or when you have selected to not accept chats
 * Bug fix - Length of undefined in Edge Browser - When opening chat box
 * Fixed the bug that stopped email addresses such as "name@domain.tld" from validating
 * 
 * 6.0.01 - 2016-04-07 - Low Priority
 * You can now exclude the chat window from the home page or archive pages 
 * Fixed a bug that caused the chat window to display on the home page when being excluded
 * Fixed a bug that prevented you from choosing to allow users to make themselves agents
 * 
 * 6.0.00 - 2016-03-16 - High priority
 * Major update - merged all extensions into the pro bundle
 * New chat box theme
 * Bug fixes
 * SSL bug fixes
 * Quick responses added back into the plugin
 * 
 * 5.1.04 - 2016-03-01 - Medium priority
 * SSL bug fix for the cloud server
 * 
 * 5.1.03 - 2016-02-02 - High priority
 * jQuery Cookie updated
 * 
 * 5.1.02 - 2016-01-20 - High priority
 * Further bug fixes to the offline message functionality
 * 
 * 5.1.01 - 2016-01-20 - High priority
 * Offline message bug fix - both sending and storing
 * 
 * 5.1.00 - 2016-01-13 - Low priority
 * New hooks:
 *  wplc_hook_missed_chat - Hook for when a live chat is missed - fires in the live chat ajax call so be careful not to output anything as it will break the JSON return
 *  wplc_hook_offline_message - Hook for when an offline message is triggered
 * Bug fixes
 *  Initiate chat now works with cloud server users
 *  Fixed a bug that caused the column name 'from' to cause issues on some servers
 * 
 * 5.0.7 - 2015-10-12 - Low priority
 * Added the extensions page
 * 
 * 5.0.6 - 2015-10-12 - Low priority
 * Introduced new hooks:
 *  wplc_hook_admin_visitor_info_display_before - Allows your to add HTML at the beginning of the vistior details DIV in the live chat window
 *  wplc_hook_admin_visitor_info_display_after - Allows your to add HTML at the end of the vistior details DIV in the live chat window
 *  wplc_hook_admin_javascript_chat - Allows your to add Javascript enqueues at the end of the javascript section of the live chat window
 *  wplc_hook_admin_settings_main_settings_after - Allows your to add more options to the main chat settings table in the settings page, after the first main table
 *  wplc_hook_admin_settings_save - Hook into the save settings head section. i.e. where we handle POST data from the live chat settings page 
 * 
 * 5.0.5 - 2015-09-17 - Low priority
 * You can now choose to disable the sound that is played when a new live chat message is received
 * Fixed a bug that caused some live chat settings to revert back to default when updating the plugin
 * 
 * 5.0.4 - 2015-09-09 - Low Priority
 * Fixed a bug that displayed an error message to update plugin while using the latest version (Pro)
 * Alert message removed when a user was made an agent on the settings page (Pro)
 * Fixed a bug that would prevent the user from typing if they had a previous chat session (Pro)
 *  
 * 5.0.3 - 2015-08-20 - Low priority
 * Fixed a bug that caused a long delay for the user after the agent accepted the chat
 * Fixed a bug that stopped showing the chat box when using the cloud server on the new pro version
 * 
 * 5.0.2 - 2015-08-20 - Medium priority
 * Major performance improvements (300% reduction on local resource usage)
 * The plugin is now compatible with caching plugins
 * Fixed a bug that caused the chat window to not show when you opted to show the chat box on certain pages only
 * 
 * 5.0.1 - 2015-08-03 - Medium priority
 * Refactored the code so that the live chat box will show up even if there is a JS error from another plugin or theme
 * Fixed a bug that caused a WP_Error fatal error on the settings page when the server was down
 * Fixed a bug that stopped you from adding an agent
 * Fixed a bug that forced chat agents other than admins to refresh the page to see their chats
 * Live chat box styling fixes: top image padding; centered the "conneting, please be patient" message and added padding
 * The live chat long poll connection will not automatically reinitialize if the connection times out or returns a 5xx error.
 * Hardened the security of the connection to the Cloud API
 * 
 * 5.0.0 - 2015-07-29 - Medium priority
 * New, modern chat dashboard
 * Better user handling (chat long polling)
 * Added a welcome page to the live chat dashboard
 * The live chat dashboard is now fully responsive
 * You are now able to see who is a new visitor and who is a returning visitor
 * Bug fixes in the javascript that handles the live chat controls
 * Fixed the bug that stopped the chats from timing out after a certain amount of time
 * 
 * 4.5.6 - 2015-07-15 - Low Priority
 * Improvements: Improvements made to Ajax file
 * 
 * 4.5.5 - 2015-07-13 - Low Priority
 * Improvement: Styling improvements on the live chat dashboard
 * 
 * 4.5.4 Espresso - 2015-07-03 - Low Priority
 * New Feature: You can now encrypt all of your live chat conversations
 * Improvement: Checks put in place for certain elements in admin JS file
 * 
 * 4.5.3 Ristretto - 2015-06-26 - Low Priority
 * Security Enhancements
 * API key functionality introduced
 * External server capability introduced
 * 
 * 4.5.2 2015-05-28 Low Priority
 * Bug Fix: Exclude Functionality (Pro)
 * 
 * 4.5.1 
 * Bug Fix: Error fixed on Settings page
 * Bug Fix: Warning fixed on settings page
 * 
 * 4.5.0 2015-04-10 Low Priority
 * Enhancement: Animations settings have been moved to the 'Styling' tab.
 * New Feature: Blocked User functionality has been moved to the Free version
 * Enhancement: All descriptions have been put into tooltips for a cleaner page
 * New Feature: Functionality added in to handle Chat Experience Ratings (Premium Add-on)
 * 
 * 4.4.10 2015-03-23 Low Priority
 * Bug Fix: Bug in the banned user functionality
 * Enhancement: Stying improvement on the Live Chat dashboard
 * Enhancement: Strings are handled better for localization plugins (Pro)
 * Updated Translation Files:
 *  Spanish (Thank you Ana Ayelen Martinez)
 * 
 * 4.4.9 2015-03-17 - Low Priority
 * Bug Fix: Warnings for animations showing erroneously 
 * Bug Fix: Including and Excluding pages intermittent when using more than one page
 * 
 * 4.4.8 2015-03-16 - Low Priority
 * Bug Fix: Mobile Detect class caused Fatal error on some websites
 * Bug Fix: PHP Errors when editing user page
 * Bug Fix: Including and Excluding the chat window caused issues on some websites
 * Bug Fix: Online/Offline Toggle Switch did not work in some browsers (Pro)
 * New Feature: You can now Ban visitors from chatting with you based on IP Address (Pro)
 * New Feature: You can now choose if you want users to make themselves an agent (Pro) 
 * Bug Fix: Chat window would not hide when selecting the option to not accept offline messages (Pro) 
 * Enhancement: Support page added 
 * Updated Translations:
 *  French (Thank you Marcello Cavallucci)
 * New Translation added:
 *  Norwegian (Thank you Robert Nilsen)
 *  Hungarian (Thank you GInception)
 *  Indonesian (Thank you Andrie Willyanta)
 * 
 * 4.4.7 2015-02-18 - Low Priority
 * New Feature: You can now send an offline message to more than one email address (Pro)
 * New Feature: You can now specify if you want to be online or not (Pro)
 * New Feature: You can now choose to record your visitors IP address or not
 * 
 * 
 * 4.4.6 2015-02-13 - Medium Priority
 * Bug Fix: Styling Issues Related to Animations/Transitions
 * 
 * 4.4.5 2015-02-12 - Low Priority
 * New Feature: You can now apply an animation to the chat window on page load
 * New Feature: You can now choose from 5 colour schemes for the chat window
 * Enhancement: Aesthetic Improvement to list of agents (Pro)
 * Code Improvement: PHP error fixed
 * Updated Translations:
 *  German (Thank you Dennis Klinger)  
 * 
 * 4.4.4 2015-01-29 - Low Priority
 * New feature: Live Chat dashboard has a new layout and design
 * Code Improvement: jQuery Cookie updated to the latest version
 * Code Improvement: More Live Chat strings are now translatable 
 * New Live Chat Translation added:
 *  Spanish (Thank you Ana Ayelï¿½n Martï¿½nez)
 * 
 * 4.4.3 2015-01-21 - Low Priority
 * New Basic Feature: You can now view any live chats you have missed
 * New Pro Feature: You can record offline messages when live chat is not online
 * Code Improvements: Labels added to buttons
 * Code Improvements: PHP Errors fixed
 * 
 * Updated Translations:
 *  Italian (Thank You Angelo Giammarresi)
 * 
 * 4.4.2 2014-12-17 - Low Priority
 * New feature: The chat window can be hidden when offline (Pro only)
 * New feature: Desktop notifications added
 * Bug fix: Email address gave false validation error when not required.
 * 
 * Translations Added:
 *  Dutch (Thank you Elsy Aelvoet)
 * 
 * 
 * 4.4.1 2014-12-10 - Low Priority
 * New feature: You can now toggle between displaying or hiding the users name in your Live Chat messages
 * New feature: You can now choose to display the Live Chat window to all or only registered users
 * New feature: A user image will now display in the Live Chat message
 * Code Improvement: jQuery UI CSS is loaded from a local source as using an external source caused issues on some sites using SSL
 * Bug Fix: Only Admin users can make users Live Chat agents
 * 
 * New WP Live Chat Support Translations added:
 * Mongolian (Thank you Monica Batuskh)
 * Romanian (Thank you Sergiu Balaes)
 * Czech (Thank you Pavel Cvejn)
 * Danish (Thank you Mikkel Jeppesen Juhl)
 * 
 * WP Live Chat Support Translations that have been updated:
 * German (Thank you Dennis Klinger)
 * 
 * 4.4.0 2014-11-20
 * Chat UI Improvements
 * Small bug fixes
 * 
 * 4.3.3
 * New Feature: You can now include or exclude the chat window on certain pages
 * Code Improvements: (Checks for DONOTCACHE)
 * 
 * 4.3.2
 * It is not required to enter your name and email address anymore. 
 * Logged In users wont have to enter their details in.
 * Turn the chat on/off on a mobile device.
 * 
 * 4.3.1
 * Bug fix: sound was not played when user received a message from the admin
 *   
 * 4.3.0
 * Added "Quick Response" functionality
 * Small bug fixes
 * Internationalization update
 * New WP Live Chat Support Translation added:
 *  * Swedish (Thank You Tobias Sernhede)
 *  * French (Thank You Marcello Cavallucci)
 * 
 * 4.2.1
 * Code improvements (Errors fixed in IE)
 * Chat performance improvements
 * 
 * 4.2.0
 * High priority update
 * Significant performance improvements
 * Small bug fixes
 * 
 * 4.1.3
 * Code improvements (PHP warnings)
 * 
 * 4.1.2
 * Performance improvements:
 *  - Significant performence improvements
 *  - Visitor list is only updated once every 3 seconds
 *  - Introduced new constants to control the delay between long polling requests and requests within the long poll call
 *  - Chat window will now only show in one window (if user has multiple tabs open on your site)
 * Various bug fixes
 *  - Minor bugs fixed
 *  - Image bug (front end) fixed
 * 
 * 4.1.1
 * Major bug fix - in some instances admin couldnt chat (answered by other agent message)
 * Backend UI Improvements
 * 
 * 4.1.0
 * Vulnerability fix (JS injections). Thank you Patrik @ www.it-securityguard.com
 * New feature: You can now show the chat box on the left or right
 * Fixed bug in menu where mutli agent user could not access it
 * Fixed 403 bug when saving settings
 * Fixed Ajax Time out error (Lowered From 90 to 28)
 * Multi Agents is now standard in pro
 * Fixed PHP Notices (settings page)
 * Added option to auto pop up chat window
 * Added Italian language files. Thanks to Davide PantÃ¨
 * 
 * 4.0.3
 * Initiate chat bug fix
 * 
 * 4.0.2
 * Backwards compatibility checks
 * 
 * 4.0.1
 * Small bug fix
 * 
 * 4.0.0
 * Overhauled all ajax requests to server to to be less resource intensive
 * Added more localization to strings that weren't been localized
 * Added Feedback Menu
 * Added Welcome Page
 * Added Support For Multiple Agents (Add On)
 * Fixed "Chat Pending" Forever showing to user - Chat now displays admin is away message
 * Completed chats - Vistors are returned to browsing
 * Fixed Many Bugs
 * 
 * 
 * 3.08
 * 
 * Added more strings to po file
 * Fixed select boxes in settings to show selected option
 * Fixed table headers changing back to english on alternative launguage installs
 * 
 * 3.07
 * 
 * Fixed bug showing all errors
 * Fixed bug of function not found - wplc_get_home_path
 * 
 * 3.06
 * 
 * Fixed no validation on offline email send bug
 * Fixed Languages Bug
 * Fixed 500 error from ajax when wp-content had different name
 * 
 * 3.05
 * 
 * Fixed input height issues
 * Fixed input overlapping bottom of chat
 * Fixed Endless Connecting
 * Testing chat is now easier (No Crossing over to other browser) 
 * 
 * 3.04
 * 
 * Fixed Bug SHowing undefined variables
 * Fixed minimmize bug that starts ringing again
 * 
 * 3.03
 * 
 * Fixed Placeholder text not displaying in IE 
 * 
 * 3.02
 * 
 * Email bug fix
 * 
 * 3.01
 * 
 * Fixed Close & Minimixe Button Styling Issues
 * Fixed bug where text was not hidden when offline message was sent
 * Fixed bug that would hide text behind image if text was 2 lines
 * Fixed bug that continuesly scrolled chat down
 * Fixed styling of inputs on some themes (overlaps chat box)
 * Set CSS color for inputs
 * Fixed bug that wasn't alerting admin in wp-admin to chat if Alert via email was set (Pro)
 * Fixed Double opening bug if chat was moved
 * Fixed Bug to inform admin and user either or has ended the chat
 * Fixed other small bugs
 * 
 * 3.0
 * 
 * Updated Styling of plugin
 * Chat window is now draggable
 * fixed bug generating characters on activation
 * 
 * 2.9
 * 
 * Fix Update Plugin Bug
 * 
 * 2.8
 * 
 * Added Support For WP-Mail Now
 * Fixed bug not saving Alignment 
 * Fixed bug not saving if Enabled or not
 * 
 * 2.7
 * 
 * Chat Delay Value Shows Up Now
 * Added remove image button
 * Fixed image not showing on fresh install
 * Fixed image been lost on settings save
 * 
 * 2.6
 * 
 * Added support to email for proper smtp (phpMailer)
 * changed .live to .on
 * Fixed cookie bugs
 * Add delete history option
 * Set minimize bar to correct color
 * fixed bug where refresh page would make chat dissapear
 * Chat Initiation Bug fix
 * Set Datbase charset from Latin to UTF-8
 * Added error reporting
 * 
 * 2.5
 * Fixed a bug that was causing "page not found error"
 * Better UI for the settings page
 * Added the ability to end live chats 
 * 
 * 2.4
 * Fixed offline message email bug
 * 
 * 2.3
 * Major performance improvements
 * Plugin now uses the new media manager to upload your profile pic and logo
 * A sound now plays every time a visitor replies to one of your chat sessions
 *
 *
 * 2.2
 * You now have full control of the fill and font color of your live chat box
 * Enabled the ability to turn live chat on or off
 * Better notification of incoming live chats.
 * Added more localization support
 * Plugin should now be compatible with caching plugins.
 * Plugin now uses the normal WordPress update functionality
 *
 * 2.1
 * More precise functionality to handle if you are online or offline
 * Fixed a bug that recorded visitors when offline
 * Neatened up some code
 * Fixed some small bugs
 * 
 * 2.0
 * Added "not available" functionality. Allows the visitor to leave a message when the admin is offline.
 * You can now get notified via email if someone is trying to start a chat with you.
 * Better front-end UI.
 *
 *
 */

global $wpdb;
global $wplc_pro_version;
global $current_chat_id;
global $wplc_tblname_chat_ratings;
global $wplc_tblname_chat_triggers;

$wplc_tblname_chat_ratings = $wpdb->prefix . "wplc_chat_ratings";
$wplc_tblname_chat_triggers = $wpdb->prefix . "wplc_chat_triggers";

$wplc_pro_version = "7.0.04";

register_activation_hook(__FILE__, 'wplc_pro_activate');


if (class_exists("AES")) { } else { require( 'includes/aes_fast.php'); }
if (class_exists("cryptoHelpers")) { } else { require( 'includes/cryptoHelpers.php'); }

require_once (plugin_dir_path(__FILE__) . "includes/wplc_data_triggers.php");
require_once (plugin_dir_path(__FILE__) . "includes/wplc_roi.php");
require_once (plugin_dir_path(__FILE__) . "includes/wplc_departments.php");
require_once (plugin_dir_path(__FILE__) . "includes/wplc_transfer_chats.php");
require_once (plugin_dir_path(__FILE__) . "modules/documentation_suggestions.php");
require_once (plugin_dir_path(__FILE__) . "modules/api/wplc-api.php");
require_once (plugin_dir_path(__FILE__) . "includes/wplc_custom_fields.php");

add_action('init', 'wplc_pro_create_macro_post_type',100);


add_action('wp_ajax_wplc_choose_accepting','wplc_action_callback');
add_action('wp_ajax_wplc_choose_not_accepting','wplc_action_callback');
add_action('wplc_hook_action_callback','wplc_choose_hook_control_action_callback');
add_action('wplc_hook_admin_menu_layout_display_top','wplc_ma_hook_control_admin_meny_layout_display_top');
add_action('edit_user_profile_update', 'wplc_maa_set_user_as_agent'); 
add_action('personal_options_update', 'wplc_maa_set_user_as_agent');
add_action('edit_user_profile', 'wplc_maa_custom_user_profile_fields');
add_action('show_user_profile', 'wplc_maa_custom_user_profile_fields');
add_action('admin_enqueue_scripts', 'wplc_control_admin_javascript');
add_action('wp_ajax_wplc_add_agent', 'wplc_action_callback');
add_action('wp_ajax_wplc_remove_agent', 'wplc_action_callback');
add_action('wp_ajax_wplc_macro', 'wplc_action_callback');

add_action('wp_ajax_wplc_typing', 'wplc_action_callback');
add_action('wp_ajax_nopriv_wplc_typing', 'wplc_action_callback');

add_action('wp_ajax_wplc_upload_file', 'wplc_action_callback');
add_action('wp_ajax_nopriv_wplc_upload_file', 'wplc_action_callback');

add_action('wp_ajax_wplc_wplc_record_chat_rating', 'wplc_action_callback');
add_action('wp_ajax_nopriv_wplc_record_chat_rating', 'wplc_action_callback');


add_action('admin_head', 'wplc_pro_warnings');
function wplc_pro_warnings() {
	if (is_admin()) {
		global $wplc_version;
        $checker = (intval(str_replace(".","",$wplc_version)));
        if ($checker < 6100) {

        	$wplc_error_string = sprintf( __( 'WP Live Chat Support Pro <strong>requires WP Live Chat Support version 6+</strong> (basic version). Please <strong><a href="%1$s">update the plugin</a></strong> in order for the plugin to continue working correctly.', 'wplivechat' ),
            './update-core.php'
            
       		 );
        	?>
			<div class="updated notice">
			    <p><?php echo $wplc_error_string; ?></p>
			</div>

        	<?php
        }

	}
}


function wplc_pro_activate() {

    /* add caps to admin */
    if (current_user_can('manage_options')) {
        global $user_ID;
        $user = new WP_User($user_ID);
        foreach ($user->roles as $urole) {
            if ($urole == "administrator") {
                $admins = get_role('administrator');
                $admins->add_cap('edit_wplc_quick_response');
                $admins->add_cap('edit_wplc_quick_response');
                $admins->add_cap('edit_other_wplc_quick_response');
                $admins->add_cap('publish_wplc_quick_response');
                $admins->add_cap('read_wplc_quick_response');
                $admins->add_cap('read_private_wplc_quick_response');
                $admins->add_cap('delete_wplc_quick_response');
            }
        }
    }

}


add_action("admin_init","wplc_control_logged_in");
function wplc_control_logged_in() {
	$userid = get_current_user_id();
	$checker = wplc_maa_check_if_user_is_agent($userid);
	if ($checker !== "not_user_agent" && $checker > 0) {
		update_user_meta($userid, "wplc_chat_agent_online", time());
	}

}

add_action("init","wplc_control_logged_out");
function wplc_control_logged_out() {
    $check = get_users(array(
        'meta_key'=> 'wplc_chat_agent_online',
    ));
    if($check){
        foreach ($check as $wplcuser) {
        	$check = get_user_meta($wplcuser->ID,"wplc_chat_agent_online");
        	if (isset($check[0])) {
		    	$last_logged_in_time = $check[0];
		    	if ($last_logged_in_time > 0) {
		    		if ((time() - $last_logged_in_time) < 120) {
		    			/* do nothing, they are online */
		    		} else {
		    			/* this user has not sent a heartbeat in over 120 seconds */
			        	delete_user_meta($wplcuser->ID, "wplc_chat_agent_online");

		    		}
		    	}
		    }
        }
    } else {
        return false;
    }	
}


add_action("init","wplc_pro_load_updates");
function wplc_pro_load_updates() {
    if (function_exists("wplc_version_control")) {
        if (!class_exists("wplc_update_control")) { 
        	if (file_exists(WPLC_BASIC_PLUGIN_DIR."/includes/update_control.class.php")) { @require_once(WPLC_BASIC_PLUGIN_DIR."/includes/update_control.class.php"); } 
        }
        if (class_exists("wplc_update_control")) {
	        $check_init = new wplc_update_control();
	        $check_init->set_slug(basename(dirname(__FILE__)));
	        $check_init->set_path(plugin_basename( __FILE__ ));
	        $check_init->set_title(__("WP Live Chat Support Pro","wplivechat"));
	        $check_init->activate();
	    }
    }
}

add_action('init', 'wplc_pro_version_control');


function wplc_pro_version_control() {
    global $wplc_pro_version;

    $current_version = get_option("wplc_pro_current_version");
    if (!isset($current_version) || $current_version != $wplc_pro_version) {
        wplc_pro_update_db();

        /* add caps to admin */
	    if (current_user_can('manage_options')) {
	        global $user_ID;
	        $user = new WP_User($user_ID);
	        foreach ($user->roles as $urole) {
	            if ($urole == "administrator") {
	                $admins = get_role('administrator');
	                $admins->add_cap('edit_wplc_quick_response');
	                $admins->add_cap('edit_wplc_quick_response');
	                $admins->add_cap('edit_other_wplc_quick_response');
	                $admins->add_cap('publish_wplc_quick_response');
	                $admins->add_cap('read_wplc_quick_response');
	                $admins->add_cap('read_private_wplc_quick_response');
	                $admins->add_cap('delete_wplc_quick_response');
	            }
	        }
	    }

        update_option("wplc_pro_current_version", $wplc_pro_version);
        $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
        if (isset($wplc_pro_settings['wplc_pro_chat_email_address'])) { } else { $wplc_pro_settings['wplc_pro_chat_email_address'] = get_option('admin_email'); }
        if (isset($wplc_pro_settings['wplc_typing_enabled'])) { } else { $wplc_pro_settings['wplc_typing_enabled'] = 1; }

        if (!isset($wplc_pro_settings['wplc_ux_editor'])) { $wplc_pro_settings['wplc_ux_editor'] = 1; }
        if (!isset($wplc_pro_settings['wplc_ux_file_share'])) { $wplc_pro_settings['wplc_ux_file_share'] = 1; }
        if (!isset($wplc_pro_settings['wplc_ux_exp_rating'])) { $wplc_pro_settings['wplc_ux_exp_rating'] = 1; }



        update_option("WPLC_PRO_SETTINGS", $wplc_pro_settings);
    }    
    
}



function wplc_pro_update_db( $networkwide = false ) {
    global $wpdb;
    global $wplc_tblname_chats;

    global $wplc_tblname_chat_ratings;
    global $wplc_tblname_chat_triggers;


	if ( function_exists( 'is_multisite' ) && is_multisite() ) {
		if ( $networkwide ) {
			$old_blog = $wpdb->blogid;
			$blog_ids =  $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ( $blog_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$sql = " SHOW COLUMNS FROM {$wpdb->prefix}wplc_chat_sessions WHERE `Field` = 'agent_id'";
				$results = $wpdb->get_results($sql);
				if (!$results) {
					$sql = "ALTER TABLE {$wpdb->prefix}wplc_chat_sessions ADD `agent_id` INT(11) NOT NULL ;";
					$wpdb->query($sql);
				}

				$department_field_sql = " SHOW COLUMNS FROM {$wpdb->prefix}wplc_chat_sessions WHERE `Field` = 'department_id'";
				$results = $wpdb->get_results($department_field_sql);
				if (!$results) {
					$department_field_sql = "ALTER TABLE {$wpdb->prefix}wplc_chat_sessions ADD `department_id` INT(11) NOT NULL ;";
					$wpdb->query($department_field_sql);
				}
			}
			switch_to_blog( $old_blog );
		}
	} else {
		$sql = " SHOW COLUMNS FROM $wplc_tblname_chats WHERE `Field` = 'agent_id'";
		$results = $wpdb->get_results($sql);
		if (!$results) {
			$sql = "ALTER TABLE `$wplc_tblname_chats` ADD `agent_id` INT(11) NOT NULL ;";
			$wpdb->query($sql);
		}

		$department_field_sql = " SHOW COLUMNS FROM $wplc_tblname_chats WHERE `Field` = 'department_id'";
		$results = $wpdb->get_results($department_field_sql);
		if (!$results) {
			$department_field_sql = "ALTER TABLE `$wplc_tblname_chats` ADD `department_id` INT(11) NOT NULL ;";
			$wpdb->query($department_field_sql);
		}
	}

    $sql2 = "
        CREATE TABLE " . $wplc_tblname_chat_ratings . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          timestamp datetime NOT NULL,
          cid int(11) NOT NULL,
          aid int(11) NOT NULL,
          rating int(11) NOT NULL,
          comment varchar(700) NOT NULL,
          notified tinyint(1) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

     $sql3 = "
        CREATE TABLE " . $wplc_tblname_chat_triggers . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          name varchar(700) NOT NULL,
          type int(11) NOT NULL,
          content longtext NOT NULL,
          show_content tinyint(1) NOT NULL,
          status tinyint(1) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql2);
    dbDelta($sql3);

    do_action("wplc_pro_update_db_hook");

    $admins = get_role('administrator');
    $admins->add_cap('wplc_ma_agent');
    $uid = get_current_user_id();
    update_user_meta($uid, 'wplc_ma_agent', 1);
    update_user_meta($uid, "wplc_chat_agent_online", time());
}





function wplc_pro_create_macro_post_type() {
    $labels = array(
        'name' => __('Quick Responses', 'wplivechat'),
        'singular_name' => __('Quick Response', 'wplivechat'),
        'add_new' => __('New Quick Response', 'wplivechat'),
        'add_new_item' => __('Add New Quick Response', 'wplivechat'),
        'edit_item' => __('Edit Quick Response', 'wplivechat'),
        'new_item' => __('New Quick Response', 'wplivechat'),
        'all_items' => __('All Quick Responses', 'wplivechat'),
        'view_item' => __('View Quick Responses', 'wplivechat'),
        'search_items' => __('Search Quick Responses', 'wplivechat'),
        'not_found' => __('No Quick Responses found', 'wplivechat'),
        'not_found_in_trash' => __('No Quick Responses found in the Trash', 'wplivechat'),
        'menu_name' => __('Quick Responses', 'wplivechat')
    );
    $args = array(
        'labels' => $labels,
        'description' => __('Quick Responses for WP Live Chat Support Pro', 'wplivechat'),
        'public' => false,
        'menu_position' => 80,
        'show_in_nav_menus' => true,
        'show_in_menu' => 'wplivechat-menu', 
        'hierarchical' => false,
        'rewrite' => array('slug' => 'wplc_quick_response'),
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'supports' => array('title', 'editor', 'revisions', 'author'),
        'has_archive' => true,
        'capabilities' => array(
            'edit_post' => 'edit_wplc_quick_response',
            'edit_posts' => 'edit_wplc_quick_response',
            'edit_others_posts' => 'edit_other_wplc_quick_response',
            'publish_posts' => 'publish_wplc_quick_response',
            'read_post' => 'read_wplc_quick_response',
            'read_private_posts' => 'read_private_wplc_quick_response',
            'delete_post' => 'delete_wplc_quick_response',
            'delete_posts' => 'delete_wplc_quick_response'
        ),
        'register_meta_box_cb' => 'wplc_add_quick_response_metaboxes'
    );

    register_post_type('wplc_quick_response', $args);
}

add_action( 'add_meta_boxes', 'wplc_add_quick_response_metaboxes' );
function wplc_add_quick_response_metaboxes() {
	add_meta_box( 'wplc_quick_response_number', __( 'Sort Order', 'wplivechat' ), 'wplc_quick_response_number_cb', 'wplc_quick_response', 'side', 'default' );
}

function wplc_quick_response_number_cb() {
	global $post;

	echo '<input type="hidden" id="wplc_quick_response_number_noncename" name="wplc_quick_response_number_noncename" value="' . wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';

	$wplc_quick_response_number = get_post_meta( $post->ID, 'wplc_quick_response_number', true );
	$wplc_quick_response_number = isset( $wplc_quick_response_number ) && '' !== $wplc_quick_response_number ? esc_attr( $wplc_quick_response_number ) : '1';
	echo '<input type="number" id="wplc_quick_response_number" name="wplc_quick_response_number" min="1" value="' . esc_attr( $wplc_quick_response_number ) . '" />';
}

add_action( 'save_post', 'wplc_quick_response_number_save', 1, 2 );
function wplc_quick_response_number_save( $post_id, $post ) {
	if ( ! isset( $_POST['wplc_quick_response_number_noncename'] ) || ! wp_verify_nonce( $_POST['wplc_quick_response_number_noncename'], plugin_basename( __FILE__ ) ) ) {
		return $post->ID;
	}

	if ( ! current_user_can( 'edit_wplc_quick_response' ) ) {
        return $post->ID;
	}

	if ( $post->post_type == 'revision' ) {
		return;
	}

	update_post_meta( $post->ID, 'wplc_quick_response_number', esc_attr( $_POST['wplc_quick_response_number'] ) );

	return $post->ID;
}

add_filter( 'manage_edit-wplc_quick_response_columns', 'wplc_quick_response_number_column' );
function wplc_quick_response_number_column( $columns ) {
	$columns = array(
		'cb'     => '<input type="number" />',
		'title'  => __( 'Title', 'wplivechat' ),
		'number' => __( 'Order', 'wplivechat' ),
		'author' => __( 'Author', 'wplivechat' ),
		'date'   => __( 'Date', 'wplivechat' ),
	);

	return $columns;
}

add_action( 'manage_wplc_quick_response_posts_custom_column', 'wplc_quick_response_manage_number_column', 10, 2 );
function wplc_quick_response_manage_number_column( $column, $post_id ) {
	global $post;

	switch ( $column ) {
		case 'number':
			$wplc_quick_response_number = get_post_meta( $post_id, 'wplc_quick_response_number', true );
			echo ( empty( $wplc_quick_response_number ) ) ? '1' : esc_attr( $wplc_quick_response_number );
			break;
		default:
			break;
	}
}

function wplc_quick_response_add_agent_caps() {
	if ( 'not_user_agent' !== wplc_ic_check_if_user_is_agent() ) {
		$user_id = get_current_user_id();
		$user = new WP_User($user_id);
		$user->add_cap('edit_wplc_quick_response');
		$user->add_cap('edit_wplc_quick_response');
		$user->add_cap('edit_other_wplc_quick_response');
		$user->add_cap('publish_wplc_quick_response');
		$user->add_cap('read_wplc_quick_response');
		$user->add_cap('read_private_wplc_quick_response');
		$user->add_cap('delete_wplc_quick_response');
	}
}
add_action( 'admin_init', 'wplc_quick_response_add_agent_caps' );

add_action("wplc_hook_admin_below_chat_box","wplc_pro_hook_control_admin_below_chat_box",1,1);
function wplc_pro_hook_control_admin_below_chat_box($result) {
	remove_action("wplc_hook_admin_below_chat_box","wplc_hook_control_admin_below_chat_box");
	if ($result->status == 3) {
		$wplc_pro_settings = get_option( 'WPLC_PRO_SETTINGS' );
		$wplc_quick_response_order_by = isset( $wplc_pro_settings['wplc_quick_response_orderby'] ) ? esc_attr( $wplc_pro_settings['wplc_quick_response_orderby'] ) : 'title';
		$wplc_quick_response_order = isset( $wplc_pro_settings['wplc_quick_response_order'] ) ? esc_attr( $wplc_pro_settings['wplc_quick_response_order'] ) : 'DESC';
		echo "<div class='admin_chat_quick_controls'>";
		echo "  <p style=\"text-align:left; font-size:11px;\">Press ENTER to send your message</p>";
		echo wplc_return_macros( 0, $wplc_quick_response_order_by, $wplc_quick_response_order  );
		echo "  </div>";
		echo "</div>";
	}

}



function wplc_return_macros( $firsttd = 0, $orderby = 'post_title', $order = 'DESC' ) {

    $args = array(
        'posts_per_page' => -1,
        'offset' => 0,
        'category' => '',
        'order' => $order,
        'orderby' => $orderby,
        'include' => '',
        'exclude' => '',
        'meta_key' => '',
        'meta_value' => '',
        'post_type' => 'wplc_quick_response',
        'post_mime_type' => '',
        'post_parent' => '',
        'post_status' => 'publish',
        'suppress_filters' => true);

	if ( 'number' === $orderby ) {
		$args['orderby'] = 'wplc_quick_response_number';
        $args['meta_key'] = 'wplc_quick_response_number';
    }

	$posts_array = get_posts($args);

	$msg = "<table><tr>";
    if ($firsttd == 0) {
        $msg .= "  <td>" . __("Assign Quick Response", "wplivechat") . "</td>";
    }
    $msg .= "  <td>";
    if ($firsttd == 1) {
        $msg .= __("Assign Quick Response", "wplivechat");
    }
    $msg .= "      <select name='wplc_macros_select' class='wplc_macros_select'>";
    $msg .= "          <option value='0'>" . __("Select", "wplivechat") . "</option>";

    foreach ($posts_array as $post) {

        $msg .= "          <option value='" . $post->ID . "'>" . $post->post_title . "</option>";
    }
    $msg .= "      </select> <small><a href='http://wp-livechat.com/documentation/what-are-quick-responses/?utm_source=plugin&utm_medium=link&utm_campaign=what_are_quick_resposnes' title='What are quick responses?' target='_BLANK'>" . __("What is this?", "wplivechat") . "</a></small>";
    $msg .= "  </td>";
    $msg .= "</tr></table>";
    return $msg;
}



add_filter("wplc_filter_typing_control_div","wplc_pro_filter_control_return_chat_response_box_before",10,1);
function wplc_pro_filter_control_return_chat_response_box_before($string) {
	$string = $string. "<div class='typing_indicator wplc-color-bg-1 wplc-color-4'></div>";

	return $string;
}
add_filter("wplc_filter_typing_control_div_theme_2","wplc_pro_filter_control_return_chat_response_box_before_theme2",10,1);
function wplc_pro_filter_control_return_chat_response_box_before_theme2($string) {
	$string = $string. "<div class='typing_indicator'></div>";

	return $string;
}


if (!function_exists("wplc_acbc_filter_control_microicon")) { 
	add_filter("wplc_filter_microicon","wplc_acbc_filter_control_microicon",10,1);
	function wplc_acbc_filter_control_microicon($ret_msg) {
	    $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");

	    if ($wplc_acbc_data['wplc_chat_pic']) {
	        /* overwrite the $ret_msg variable */
	        $ret_msg = "<div class='wplc_left_logo' style='background:url(".urldecode($wplc_acbc_data['wplc_chat_pic']).") no-repeat; background-size: cover;'></div>";
	    }
	    return $ret_msg;

	}
}

if (!function_exists("wplc_acbc_filter_control_chaticon")) {
	add_filter("wplc_filter_chaticon","wplc_acbc_filter_control_chaticon",10,1);
	function wplc_acbc_filter_control_chaticon($icon) {
		$wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");

		if ($wplc_acbc_data['wplc_chat_icon']) {
			$icon = urldecode($wplc_acbc_data['wplc_chat_icon']);
		}
		return $icon;

	}
}
/**
 * Notify the admin that someone wants to chat
 * @param  array   $array CID, Name, Email
 * @return bool
 */
if (!function_exists("wplc_acbc_hook_control_initiate_chat")) { 
	add_action("wplc_hook_initiate_chat","wplc_acbc_hook_control_initiate_chat",10,1);
	function wplc_acbc_hook_control_initiate_chat($data) {
	    $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");
	    if (isset($wplc_acbc_data['wplc_pro_chat_email_address'])) { $email_address = $wplc_acbc_data['wplc_pro_chat_email_address']; } else { $email_address = ""; }
	    if (!$email_address || $email_address == "") { $email_address = get_option('admin_email'); }
	    //    $chat_noti = $wplc_pro_settings['wplc_pro_chat_notification'];
	    if (isset($wplc_acbc_data['wplc_pro_chat_notification']) && $wplc_acbc_data['wplc_pro_chat_notification'] == "yes") {
	        $subject = sprintf( __( 'Incoming chat from %s (%s) on %s', 'wplivechat' ),
	                $data['name'],
	                $data['email'],
	                get_option('blogname')
	        );

	        $msg = sprintf( __( '%s (%s) wants to chat with you. <br /><br />Log in: %s', 'wplivechat' ),
	                $data['name'],
	                $data['email'],
	                get_option('home')."/wp-login.php"
	        );

	        wplcmail($email_address,"WP Live Chat Support", $subject, $msg);
	    }
	    return true;
	}
}


if (!function_exists("wplc_acbc_admin_scripts")) { 
	add_action('admin_print_scripts', 'wplc_acbc_admin_scripts');
	function wplc_acbc_admin_scripts() {
	    global $wplc_acbc_version;
	    if (isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu-settings') {

	        wp_enqueue_media();
	        wp_register_script('my-wplc-upload', plugins_url('js/media.js', __FILE__), array('jquery'), $wplc_acbc_version, true);
	        wp_enqueue_script('my-wplc-upload');
	    }
	}
}



/**
 * Add to the settings page
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_acbc_hook_control_settings_page")) { 
	add_action('wplc_hook_admin_settings_chat_box_settings_after','wplc_acbc_hook_control_settings_page',1);
	function wplc_acbc_hook_control_settings_page() {
	    if (function_exists("wplc_hook_control_settings_page_relevant_extensions_acbc")) { remove_action("wplc_hook_admin_settings_chat_box_settings_after","wplc_hook_control_settings_page_relevant_extensions_acbc"); }


	    $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");
	    if (isset($wplc_acbc_data['wplc_pro_chat_notification']) && $wplc_acbc_data['wplc_pro_chat_notification'] == "yes") { $wplc_pro_chat_notification = "CHECKED"; } else { }

	    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	    
	    echo "<table class='form-table wp-list-table widefat fixed striped pages' width='700'>";
		echo "	<tr>";
		echo "  	<td width='300'>";
		echo "      	".__("Display typing indicator", "wplivechat")." <i class='fa fa-question-circle wplc_light_grey wplc_settings_tooltip' title='".__("Display the \"typing...\" animation in the chat window as soon as an agent or visitor is typing.", "wplivechat")."'></i>";
		echo "  	</td>";
		echo "  	<td>";
        global $wplc_version;
        if (isset($wplc_version)) {
            $float_version = intval(str_replace(".","",$wplc_version));
            if ($float_version < 6200) {
                echo "<span class='update-nag'>".sprintf(__("Please update your <a href='%s'>basic version</a> to make use of this feature.","wplivechat"),"./update-core.php")."</span><br /><br />";
            }
        }
        

		echo "      	<input type=\"checkbox\" name=\"wplc_typing_enabled\" value=\"1\"";
		if (isset($wplc_pro_settings['wplc_typing_enabled']) && $wplc_pro_settings['wplc_typing_enabled'] == 1) { echo "checked"; }
		echo "/>";
		echo " 			<small><em>".__("For non-cloud server users, please note that this will increase the amount of server resources required.", "wplivechat")." </em></small>";
		echo "  	</td>";
		echo "</tr>";


	  ?>
	                    
	        <tr>
	            <td width='420' valign='top'>
	                <?php _e("Name ", "wplivechat") ?>:
	            </td>
	            <td>
	                <input id='wplc_pro_name' name='wplc_pro_name' type='text' size='50' maxlength='50' class='regular-text' value='<?php echo isset( $wplc_acbc_data['wplc_chat_name'] ) ? stripslashes($wplc_acbc_data['wplc_chat_name']) : ''; ?>' />
	            </td>
	        </tr>
	        <tr>
	            <td width='420' valign='top'>
	                - <?php _e("Use WordPress name instead", "wplivechat") ?>:
	            </td>
	            <td>
	                <input id='wplc_use_wp_name' name='wplc_use_wp_name' value='1' type='checkbox' <?php echo (isset($wplc_acbc_data['wplc_use_wp_name']) && intval($wplc_acbc_data['wplc_use_wp_name']) == 1 ? "checked" : "")  ?>/> <small><em><?php _e("Note: 'Name' field will be ignored", "wplivechat")?></em></small>
	            </td>
	        </tr>

	        <?php 

	        	if (isset($wplc_pro_settings['wplc_ringtone'])) {
	        		$wplc_ringtone_selected =  str_replace("http:", "", $wplc_pro_settings['wplc_ringtone'] );
	        	} else {
	        		$wplc_ringtone_selected = WPLC_BASIC_PLUGIN_URL.'ring.wav';
	        	}


	        ?>


	        <tr>
	            <td width='420' valign='top'>
	                <?php _e("Incoming chat ring tone", "wplivechat") ?>:
	            </td>
	            <td>
	            	<select name='wplc_ringtone' id='wplc_ringtone'>
	            	<?php $wplc_ringtone = str_replace("http:", "", WPLC_BASIC_PLUGIN_URL.'ring.wav' ); ?>
	            		<option <?php if ($wplc_ringtone_selected == WPLC_BASIC_PLUGIN_URL.'ring.wav') { echo "selected"; } ?> value='<?php echo $wplc_ringtone; ?>'><?php _e("Default","wplivechat"); ?></option>
	                <?php

	                	/* Thank you to the following authors of the sound files used in WP Live Chat Support Pro

						(1) Mike Koenig Sound - Store door chime, Mario jump, ringing phone, Rooster, ship bell
						(2) Freesfx.com
						(3) Corsica - Elevator ding sound, Air plane ding
						(4) Brian Rocca - Pin dropping
						(5) Marianne Gagnon - Robot blip
						(6) Caroline Ford - Drop metal thing
						(7) bennstir - Doorbell

	                	 */
	                	$path = plugin_dir_path(__FILE__)."/includes/sounds/";
						$files = scandir($path);

						foreach ($files as &$value) {							
							
							$available_tones = plugin_dir_url( $path.$value ).$value;							
							$http_stripped_tone = str_replace( "http:", "", $available_tones );
							$wplc_new_sanitized_tone = str_replace( "https:", "", $http_stripped_tone );
							
							if ($value == "." || $value == "..") { } else {
								$fname = $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
								$fname = str_replace("_"," ",$fname);
								if ($wplc_ringtone_selected == $wplc_new_sanitized_tone) { $sel = "selected"; } else { $sel = ""; }
								$new_ringtone = str_replace("http:", "", plugin_dir_url( $path.$value ).$value );
						    	echo "<option value='".$new_ringtone."' $sel>".$fname."</option>";
						    }
						}
	                ?>
	            </select>
	            <button type='button' id='wplc_sample_ring_tone'><i class='fa fa-play'></i></button>
	            </td>
            </tr>

	                    
	        <?php
	        $wplc_current_user = wp_get_current_user();
	        $wplc_current_picture = isset( $wplc_acbc_data['wplc_chat_pic'] ) ? urldecode($wplc_acbc_data['wplc_chat_pic']) : '';
	        $wplc_current_logo = isset( $wplc_acbc_data['wplc_chat_logo'] ) ? urldecode($wplc_acbc_data['wplc_chat_logo']) : '';
	        $wplc_current_icon = isset( $wplc_acbc_data['wplc_chat_icon'] ) ? urldecode($wplc_acbc_data['wplc_chat_icon']) : '';
	        ?>


        <!-- Chat Icon-->
        <tr>
            <td width='300' valign='top'>
				<?php _e("Icon", "wplivechat") ?>:
            </td>
            <td>
                    <span id="wplc_icon_area">
                        <img src="<?php echo trim($wplc_current_icon); ?>" width="50px"/>
                    </span>
                <input id="wplc_upload_icon" name="wplc_upload_icon" type="hidden" size="35" class="regular-text" maxlength="700" value=" <?php echo base64_encode($wplc_current_icon) ?>"/>
                <br/>
                <input id="wplc_btn_upload_icon" name="wplc_btn_upload_icon" type="button" value="<?php _e("Upload Icon", "wplivechat") ?>" />
                <br/>
                <input id="wplc_btn_remove_icon" name="wplc_btn_remove_icon" type="button" value="<?php _e("Remove Icon", "wplivechat") ?>" />
				<?php _e("Recomended Size 50px x 50px", "wplivechat") ?>
            </td>
        </tr>

	        <tr>
	            <td width='300' valign='top'>
	                <?php _e("Picture", "wplivechat") ?>:
	            </td>
	            <td>
	                <span id="wplc_pic_area">
	                    <img src="<?php echo $wplc_current_picture ?>" width="60px"/>
	                </span>
	                <input id="wplc_upload_pic" name="wplc_upload_pic" type="hidden" size="35" class="regular-text" maxlength="700" value="<?php echo base64_encode($wplc_current_picture) ?>"/> 
	                <br/>
	                <input id="wplc_btn_upload_pic" name="wplc_btn_upload_pic" type="button" value="<?php _e("Upload Image", "wplivechat") ?>" />
	                <br/>
	                <input id="wplc_btn_remove_pic" name="wplc_btn_remove_pic" type="button" value="<?php _e("Remove Image", "wplivechat") ?>" />
	                <?php _e("Recomended Size 60px x 60px", "wplivechat") ?>
	            </td>
            </tr>

            <!-- Chat Logo-->
            <tr>
                <td width='300' valign='top'>
                    <?php _e("Logo", "wplivechat") ?>:
                </td>
                <td>
                    <span id="wplc_logo_area">
                        <img src="<?php echo trim($wplc_current_logo); ?>" width="100px"/>
                    </span> 
                    <input id="wplc_upload_logo" name="wplc_upload_logo" type="hidden" size="35" class="regular-text" maxlength="700" value=" <?php echo base64_encode($wplc_current_logo) ?>"/> 
                    <br/>
                    <input id="wplc_btn_upload_logo" name="wplc_btn_upload_logo" type="button" value="<?php _e("Upload Logo", "wplivechat") ?>" />
                    <br/>
                    <input id="wplc_btn_remove_logo" name="wplc_btn_remove_logo" type="button" value="<?php _e("Remove Logo", "wplivechat") ?>" />
                    <?php _e("Recomended Size 250px x 40px", "wplivechat") ?>
                </td>
            </tr>
	                    
            <tr>
                <td width='300' valign='top'>
                    <?php _e("Chat delay (seconds)", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("How long it takes for your chat window to pop up", "wplivechat") ?>"></i>
                </td>
                <td>
                    <input id="wplc_pro_delay" name="wplc_pro_delay" type="text" size="6" maxlength="4" value="<?php echo isset( $wplc_acbc_data['wplc_chat_delay'] ) ? stripslashes($wplc_acbc_data['wplc_chat_delay']) : ''; ?>" />
                </td>
            </tr>
            <!-- Chat Notification if want to chat -->
            <tr>
                <td width='300' valign='top'>
                    <?php _e("Chat notifications", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Alert me via email as soon as someone wants to chat (while online only)", "wplivechat"); ?>"></i>
                </td>
                <td>
                    <input id="wplc_pro_chat_notification" name="wplc_pro_chat_notification" type="checkbox" value="yes" <?php if (isset($wplc_pro_chat_notification)) { echo $wplc_pro_chat_notification; } ?>/>                    
                </td>
            </tr>

        </table>

        <h3><?php _e("User Experience", 'wplivechat') ?></h3>
        <hr>


        <?php
        global $wplc_version;
        if (isset($wplc_version)) {
            $float_version = intval(str_replace(".","",$wplc_version));
            if ($float_version < 6200) {
                echo "<span class='update-nag'>".sprintf(__("Please update your <a href='%s'>basic version</a> to make use of these features.","wplivechat"),"./update-core.php")."</span>";
            }
        }
        ?>
        <table class='form-table wp-list-table widefat fixed striped pages' width='100%'>
            <tbody>
                <tr>
                    <td width='300' valign='top'><?php _e("Enable Text Editor", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Adds advanced text editor features, such as links, text styling, and more!", "wplivechat") ?>"></i></td> 
                    <td><input id='wplc_ux_editor' name='wplc_ux_editor' type='checkbox' <?php echo((isset($wplc_pro_settings['wplc_ux_editor']) && $wplc_pro_settings['wplc_ux_editor'] != "0") ? "checked" : "") ?> /> </td>    
                </tr>
                <tr>
                    <td width='300' valign='top'><?php _e("Enable File Sharing", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Adds file sharing to your chat box!", "wplivechat") ?>"></i></td> 
                    <td><input id='wplc_ux_file_share' name='wplc_ux_file_share' type='checkbox' <?php echo((isset($wplc_pro_settings['wplc_ux_file_share']) && $wplc_pro_settings['wplc_ux_file_share'] != "0") ? "checked" : "") ?> />  </td>   
                </tr>
                <tr>
                    <td width='300' valign='top'><?php _e("Enable Experience Ratings", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Allows users to rate the chat experience with an agent.", "wplivechat") ?>"></i></td> 
                    <td><input id='wplc_ux_exp_rating' name='wplc_ux_exp_rating' type='checkbox' <?php echo((isset($wplc_pro_settings['wplc_ux_exp_rating']) && $wplc_pro_settings['wplc_ux_exp_rating'] != "0") ? "checked" : "") ?> />  </td>   
                </tr>
            </tbody>
        </table>

	        <h3><?php _e("Social", 'wplivechat') ?></h3>
	        <hr>


        <?php
        global $wplc_version;
        if (isset($wplc_version)) {
            $float_version = intval(str_replace(".","",$wplc_version));
            if ($float_version < 6200) {
                echo "<span class='update-nag'>".sprintf(__("Please update your <a href='%s'>basic version</a> to make use of these features.","wplivechat"),"./update-core.php")."</span>";
            }
        }
        ?>

	        <table class='form-table wp-list-table widefat fixed striped pages' width='100%'>
	            <tbody>
	                <tr>
	                    <td width='300' valign='top'><?php _e("Facebook URL", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Link your Facebook page here. Leave blank to hide", "wplivechat") ?>"></i></td> 
	                    <td><input id='wplc_social_fb' name='wplc_social_fb' placeholder="<?php _e("Facebook URL...", "wplivechat") ?>" type='text' value="<?php echo (isset($wplc_acbc_data['wplc_social_fb']) ? urldecode($wplc_acbc_data['wplc_social_fb']) : "") ?>" /> </td>    
	                </tr>
	                <tr>
	                    <td width='300' valign='top'><?php _e("Twitter URL", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Link your Twitter page here. Leave blank to hide", "wplivechat") ?>"></i></td> 
	                    <td><input id='wplc_social_tw' name='wplc_social_tw' placeholder="<?php _e("Twitter URL...", "wplivechat") ?>" type='text' value="<?php echo (isset($wplc_acbc_data['wplc_social_tw']) ? urldecode($wplc_acbc_data['wplc_social_tw']) : "") ?>" />  </td>   
	                </tr>
	            </tbody>
	        </table>

	  <?php
	}
}


/**
* Check if this is the first time the user has run the plugin. If yes, set the default settings
* @since        1.0.0
* @return       void
* @author       Nick Duncan <nick@codecabin.co.za>
*/
if (!function_exists("wplc_acbc_first_run_check")) { 
	add_action("init","wplc_acbc_first_run_check");
	function wplc_acbc_first_run_check() {
	    if (!get_option("WPLC_ACBC_FIRST_RUN")) {
	        /* set the default settings */

	        $wplc_acbc_data = array(
	            "wplc_chat_name" => __("Admin", "wplivechat"),
	            "wplc_chat_pic" => plugin_dir_url(__FILE__) . "images/picture-for-chat-box.jpg",
	            "wplc_chat_logo" => "",
	            "wplc_chat_icon" => plugin_dir_url(__FILE__) . "images/chaticon.png",
	            "wplc_chat_delay" => "2",
	            "wplc_pro_chat_notification" => "no",
	            "wplc_pro_chat_email_address" => get_option('admin_email')    
	        );
	        update_option("WPLC_ACBC_SETTINGS",$wplc_acbc_data);

	        update_option("WPLC_ACBC_FIRST_RUN",true);
	    }
	}
}

if (!function_exists("wplc_acbc_hook_control_push_js_to_front")) { 
	add_action("wplc_hook_push_js_to_front","wplc_acbc_hook_control_push_js_to_front");
	function wplc_acbc_hook_control_push_js_to_front() {
	    $wplc_delay = get_option("WPLC_ACBC_SETTINGS");
	    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	    $del1 = isset( $wplc_delay['wplc_chat_delay'] ) ? $wplc_delay['wplc_chat_delay'] : 0;
	    if (!isset($del1) || !$del1) { $del1 = 0; }
	    $del2 = intval($del1 * 1000);

		if (isset($wplc_pro_settings['wplc_typing_enabled']) && $wplc_pro_settings['wplc_typing_enabled'] == 1) { $typing_enabled = "1"; } else { $typing_enabled = "0"; }
	    
	   

	    if ($typing_enabled) {
	        $wpc_misc_js_strings = array(
	            'typing_enabled' => $typing_enabled,
	            'typingimg' => plugins_url('/images/comment.svg', __FILE__)
	            );
	    } else {
	        $wpc_misc_js_strings = array(
	            'typing_enabled' => $typing_enabled
	            );
	    }
        wp_localize_script('wplc-user-script', 'wplc_misc_strings', $wpc_misc_js_strings);



	    wp_localize_script('wplc-user-script', 'wplc_delay', "".$del2."");

    	wp_register_script('wplc-user-pro-features', plugins_url('/js/wplc_pro_features.js', __FILE__), array('wplc-user-script'),false, false);

    	wp_enqueue_script('wplc-user-pro-features');

    	$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
		if(isset($wplc_pro_settings["wplc_ux_editor"]) && $wplc_pro_settings["wplc_ux_editor"] !== "0"){
    		wp_register_script('wplc-user-pro-editor', plugins_url('/js/wplc_u_editor.js', __FILE__), array('wplc-user-script', 'jquery'),false, false);
    		wp_enqueue_script('wplc-user-pro-editor');
    	}

    	if(isset($wplc_pro_settings["wplc_ux_file_share"]) && $wplc_pro_settings["wplc_ux_file_share"] !== "0"){
    		wp_enqueue_style('wplc-user-pro-styles', plugins_url('/css/wplc_styles_pro.css', __FILE__));
    	}

    	$post_id = get_the_ID();
	    if (!$post_id || $post_id === NULL) { 
	        $url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	        $post_id = url_to_postid($url); 
	    }
    	if(wplc_check_trigger_filters($post_id)){
    		wplc_tirggers_enqueue_user_styles_scritps(wplc_check_trigger_filters($post_id));
    	}

	}
}



/**
* Latch onto the default POST handling when saving live chat settings
* @since        1.0.0
* @param       
* @return       void
*/
if (!function_exists("wplc_acbc_save_settings")) { 
	add_action('wplc_hook_admin_settings_save','wplc_acbc_save_settings');
	function wplc_acbc_save_settings() {
	    if (isset($_POST['wplc_save_settings'])) {




	        if (isset($_POST['wplc_pro_name'])) { $wplc_acbc_data['wplc_chat_name'] = esc_attr($_POST['wplc_pro_name']); }
	        if (isset($_POST['wplc_use_wp_name'])) { $wplc_acbc_data['wplc_use_wp_name'] = esc_attr($_POST['wplc_use_wp_name']); } else { $wplc_acbc_data['wplc_use_wp_name'] = "0"; }
	        if (isset($_POST['wplc_upload_pic'])) { $wplc_acbc_data['wplc_chat_pic'] = esc_attr(urlencode(base64_decode($_POST['wplc_upload_pic']))); }
	        if (isset($_POST['wplc_upload_logo'])) { $wplc_acbc_data['wplc_chat_logo'] = esc_attr(urlencode(base64_decode($_POST['wplc_upload_logo']))); }                
	        if (isset($_POST['wplc_upload_icon'])) { $wplc_acbc_data['wplc_chat_icon'] = esc_attr(urlencode(base64_decode($_POST['wplc_upload_icon']))); }
	        if (isset($_POST['wplc_pro_delay'])) { $wplc_acbc_data['wplc_chat_delay'] = esc_attr($_POST['wplc_pro_delay']); }
	        if (isset($_POST['wplc_pro_chat_notification'])) { $wplc_acbc_data['wplc_pro_chat_notification'] = esc_attr($_POST['wplc_pro_chat_notification']); }
	        if (isset($_POST['wplc_pro_chat_email_address'])) { $wplc_acbc_data['wplc_pro_chat_email_address'] = esc_attr($_POST['wplc_pro_chat_email_address']); }

	        /*Handle Social Icons Here*/
	        if (isset($_POST['wplc_social_fb'])) { $wplc_acbc_data['wplc_social_fb'] = str_replace("https:", "", urlencode($_POST['wplc_social_fb']) ); }
    		if (isset($_POST['wplc_social_tw'])) { $wplc_acbc_data['wplc_social_tw'] = str_replace("https:", "", urlencode($_POST['wplc_social_tw']) ); }
	        
	        $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	        if (isset($_POST['wplc_typing_enabled']) && $_POST['wplc_typing_enabled'] == "1") { $wplc_pro_settings['wplc_typing_enabled'] = esc_attr($_POST['wplc_typing_enabled']); } else { $wplc_pro_settings['wplc_typing_enabled'] = "0"; }
	        if (isset($_POST['wplc_disable_initiate_chat']) && $_POST['wplc_disable_initiate_chat'] == "1") { $wplc_pro_settings['wplc_disable_initiate_chat'] = esc_attr($_POST['wplc_disable_initiate_chat']); } else { $wplc_pro_settings['wplc_disable_initiate_chat'] = "0"; }
	        if (isset($_POST['wplc_ringtone'])) { $wplc_pro_settings['wplc_ringtone'] = str_replace("https:", "", esc_attr($_POST['wplc_ringtone']) ); }

			if (isset($_POST['wplc_ux_editor'])) { $wplc_pro_settings['wplc_ux_editor'] = esc_attr($_POST['wplc_ux_editor']); } else { $wplc_pro_settings['wplc_ux_editor'] = "0"; }
			if (isset($_POST['wplc_ux_file_share'])) { $wplc_pro_settings['wplc_ux_file_share'] = esc_attr($_POST['wplc_ux_file_share']); } else { $wplc_pro_settings['wplc_ux_file_share'] = "0"; }
			if (isset($_POST['wplc_ux_exp_rating'])) { $wplc_pro_settings['wplc_ux_exp_rating'] = esc_attr($_POST['wplc_ux_exp_rating']); } else { $wplc_pro_settings['wplc_ux_exp_rating'] = "0"; }

			$wplc_pro_settings = apply_filters("wplc_pro_setting_save_filter", $wplc_pro_settings);

	        update_option('WPLC_ACBC_SETTINGS', $wplc_acbc_data);
	        update_option('WPLC_PRO_SETTINGS', $wplc_pro_settings);

	    }
	}
}
/**
 * Let the basic know that we are using a premium add-on
 * @param  int $count
 * @return int
 */
if (!function_exists("wplc_acbc_filter_control_menu_api")) { 
	add_filter("wplc_filter_menu_api","wplc_acbc_filter_control_menu_api",1,1);
	function wplc_acbc_filter_control_menu_api($count) {
	    $count++;
	    return $count;
	}
}


if (!function_exists("wplc_acbc_filter_control_live_chat_box_above_main_div")) { 
	add_filter("wplc_filter_live_chat_box_above_main_div","wplc_acbc_filter_control_live_chat_box_above_main_div");
	function wplc_acbc_filter_control_live_chat_box_above_main_div($ret_msg) {
	    $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");
	    
	    if (!empty($wplc_acbc_data['wplc_chat_logo'])) {
	        $ret_msg .= "<div id=\"wplc_logo\">";
	        $ret_msg .= "    <img class=\"wplc_logo_class\" src=\"".urldecode(stripslashes($wplc_acbc_data['wplc_chat_logo']))."\" style=\"display:block; margin-bottom:5px; margin-left:auto; margin-right:auto;\" alt=\"".get_bloginfo('name')."\" title=\"".get_bloginfo('name')."\" />";
	        $ret_msg .= "</div>";
	    }
	    return $ret_msg;
	}
}

if (!function_exists("wplc_acbc_filter_control_chat_header_under")) { 
	add_filter("wplc_filter_chat_header_under","wplc_acbc_filter_control_chat_header_under");
	function wplc_acbc_filter_control_chat_header_under($ret_msg) {
	    $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");

	    if ($wplc_acbc_data['wplc_chat_pic']) {
	        $ret_msg .= "<div id=\"wp-live-chat-image\">";
	            $ret_msg .= "<div id=\"wp-live-chat-inner-image-div\">";
	                $ret_msg .= "<img src=\"".urldecode($wplc_acbc_data['wplc_chat_pic'])."\" width=\"40px\"/>";
	            $ret_msg .= "</div>";
	        $ret_msg .= "</div>";

	    }
	    return $ret_msg;
	}
}

if (!function_exists("wplc_acbc_filter_control_chat_header_under")) {
	add_filter("wplc_filter_chat_header_under","wplc_acbc_filter_control_chat_header_under");
	function wplc_acbc_filter_control_chat_header_under($ret_msg) {
		$wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");

		if ($wplc_acbc_data['wplc_chat_pic']) {
			$ret_msg .= "<div id=\"wp-live-chat-image\">";
			$ret_msg .= "<div id=\"wp-live-chat-inner-image-div\">";
			$ret_msg .= "<img src=\"".urldecode($wplc_acbc_data['wplc_chat_pic'])."\" width=\"40px\"/>";
			$ret_msg .= "</div>";
			$ret_msg .= "</div>";

		}
		return $ret_msg;
	}
}


/**
* Check if this is the first time the user has run the plugin. If yes, set the default settings
* @since        1.0.2
* @return       string
* @author       Nick Duncan <nick@codecabin.co.za>
*/
if (!function_exists("wplc_acbc_filter_admin_name")) { 
	add_filter("wplc_filter_admin_name","wplc_acbc_filter_admin_name");
	function wplc_acbc_filter_admin_name($fromname) {		
	    $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");

    	if (!empty($wplc_acbc_data['wplc_chat_name'])) {
	        $fromname = $wplc_acbc_data['wplc_chat_name'];
	    }

	    
	    return $fromname;
	}
}

























/**
 * Display the switchery button at the top of the chat dashboard
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_choose_hook_control_chat_dashboard_above")) { 
	add_action("wplc_hook_chat_dashboard_above","wplc_choose_hook_control_chat_dashboard_above");
	function wplc_choose_hook_control_chat_dashboard_above() {
	    $wplc_current_user_id = get_current_user_id();
	    $wplc_choose_data = get_option("WPLC_CHOOSE_SETTINGS");

	    $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
	    $user_id = get_current_user_id();
	    /*if( $wplc_choose_data['wplc_auto_online'] == 1 && isset($choose_array[$user_id])  && $choose_array[$user_id] == 1){ */
	    ?>
	    <div style="padding: 10px 0; display: block; margin: 0 auto; text-align: center;">
	        <input type="checkbox" class="wplc_switchery" name="wplc_agent_status" id="wplc_agent_status" <?php if (isset($choose_array[$user_id]) && $choose_array[$user_id])  { echo 'checked'; } ?> />
	        <div id="wplc_agent_status_text" style="display: inline-block; padding-left: 10px;"></div>
	    </div>
	    <?php /* } */
	}
}




/**
 * Latch onto the set transient filter and decide to show the agent online or not.
 * @param  bool    $set_transient  Should we set the transient or not?
 * @return bool
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_choose_filter_control_set_set_transient")) { 
	add_filter("wplc_filter_control_set_transient","wplc_choose_filter_control_set_set_transient",10,1);
	function wplc_choose_filter_control_set_set_transient($set_transient) {

	    $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
	    $user_id = get_current_user_id();

	    if (isset($choose_array[$user_id]) && $choose_array[$user_id]) {
	        return true;
	    } else {
	        return false;
	    }
	}
}



/**
 * Latch onto the loggedin filter and set to true if any agent has selected that they can take chats.
 * @param  bool    $logged_in  Is the agent logged in and available?
 * @return bool
 * @since  1.0.01
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_choose_final_loggedin_control")) { 
	add_filter("wplc_final_loggedin_control","wplc_choose_final_loggedin_control",10,2);
	function wplc_choose_final_loggedin_control($logged_in,$logged_in_via_app) {
		if ($logged_in_via_app) { return true; /* just return true as they are on the app, no need to go through the rest here */ }
	    $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
	    /* get a list of online users */

	    /* get actuall logged in users and create an array to check with below */
	    $users = get_users(array(
	        'meta_key'=> 'wplc_chat_agent_online',
	    ));


	    foreach ($users as $wplc_user) {
	    	$check = get_user_meta($wplc_user->ID,"wplc_chat_agent_online");
	    	$last_logged_in_time = $check[0];
	    	if ($last_logged_in_time > 0) {
	    		if ((time() - $last_logged_in_time) < 70) {
	    			$tmp_logged_in[$wplc_user->ID] = 1;		
	    		}
	    	}
	    	
	    }
	    $counter = 0;
	    foreach ($choose_array as $key => $val) {
	        /* if there is an agent logged in, return true, if none, return false */
	        if ($val == true) { 
	        	$counter++;
	        	/* make sure that they are still logged in - they could have just quit. Update option accordingly and continue with checks */
	        	if (!isset($tmp_logged_in[$key])) {
	        		/* user has said they want to accept chats but they are offline */
	        		$choose_array[$key] = false;
	        		update_option("WPLC_CHOOSE_ACCEPTING",$choose_array);

	        	} else {
	        		return true;
	        	}
	        	
	        }
	    }
	    if ($counter == 0) { return false; }
	    if ($logged_in) { return true; }
	    else { return false; }

	}
}


/**
 * Activation of the plugin - set the accepting chat variable to true
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_choose_activate")) { 
	register_activation_hook(__FILE__, 'wplc_choose_activate');
	function wplc_choose_activate( $networkwide ) {
	    $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
	    $user_id = get_current_user_id();
	    $choose_array[$user_id] = true;
	    wplc_pro_update_db( $networkwide ); //Run update db
	    update_option("WPLC_CHOOSE_ACCEPTING",$choose_array);
	}
}



/**
 * Deactivate of the plugin - set the accepting chat variable to false
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_choose_deactivate")) { 
	register_deactivation_hook(__FILE__, 'wplc_choose_dectivate');
	function wplc_choose_dectivate() {
	    $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
	    $user_id = get_current_user_id();
	    $choose_array[$user_id] = true;    
	    update_option("WPLC_CHOOSE_ACCEPTING",$choose_array);

	}
}

/**
 * Latch onto the original callback for this plugin's ajax requests
 * @return void
 */
if (!function_exists("wplc_choose_hook_control_action_callback")) { 
	function wplc_choose_hook_control_action_callback() {


	    if ($_POST['action'] == 'wplc_choose_accepting') {

	        $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
	        $user_id = get_current_user_id();
	        $choose_array[$user_id] = true;
	        update_option("WPLC_CHOOSE_ACCEPTING",$choose_array);
	        
	        /* mark agent as online */
	        $user_id = get_current_user_id();
	        do_action("wplc_hook_set_transient");
	        
	        echo "done";
	    }

	    if ($_POST['action'] == 'wplc_choose_not_accepting') {
	        $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");

	        $user_id = get_current_user_id();
	        $choose_array[$user_id] = false;
	        update_option("WPLC_CHOOSE_ACCEPTING",$choose_array);

	        $deleted = delete_user_meta($user_id, "wplc_chat_agent_online");

	        delete_transient('wplc_is_admin_logged_in');
	        echo "done";
	    }

        if ($_POST['action'] == "wplc_typing") {
            
            if (isset($_POST['cid']) && isset($_POST['user']) && isset($_POST['type'])) {
                echo wplc_typing($_POST['user'],sanitize_text_field($_POST['cid']),sanitize_text_field($_POST['type']));
            }
        }

        if( $_POST['action'] == 'wplc_upload_file' ){
           $upload_dir = wp_upload_dir();
           $user_dirname = $upload_dir['basedir'];

            if( !file_exists( $user_dirname."/wp_live_chat/" ) ){
           	    @mkdir($user_dirname.'/wp_live_chat/');
            }  

            if( !file_exists( $user_dirname."/wp_live_chat/" . $_POST['cid'] ) ){
				@mkdir($user_dirname.'/wp_live_chat/'.$_POST['cid']);
			}              

           if (isset($_FILES['file']) && isset($_POST['timestamp'])) {
               if( file_exists($user_dirname . "/wp_live_chat/" . $_POST['cid'] . "/" .  $_FILES['file']['name'] ) ){
                   $file_name = rand(0, 10) . "-" . $_FILES['file']['name'];
               } else {
                   $file_name = $_FILES['file']['name'];
               }
               if(move_uploaded_file($_FILES['file']['tmp_name'], $user_dirname."/wp_live_chat/" . $_POST['cid'] . "/" . $file_name)){
                   //$response = $user_dirname."/wp_live_chat/" . $_POST['cid'] . "/" . $file_name;
                   $response = $upload_dir['baseurl']."/wp_live_chat/" . $_POST['cid'] . "/" . $file_name;
                   echo $response;
              } else {
                  echo '1';
              }  
           }
           wp_die();
       }

       if( $_POST['action'] == 'wplc_record_chat_rating' ){
           $rating_id = sanitize_text_field($_POST['cid']);
	       $rating_score = sanitize_text_field($_POST['rating']);
	       $rating_comment = sanitize_text_field($_POST['comment']);
	        
	        
	       $nifty_record_rating = nifty_record_rating($rating_id, $rating_score, $rating_comment);
	       if ($nifty_record_rating) {
	           echo 'rating added';
	           wp_die();
	       } else {
	           echo "There was an error sending your chat message. Please contact support";
	           wp_die();
	       }
           
       }
	}
}




function wplc_typing($user,$cid,$type) {

    $cdata = wplc_get_chat_data($cid,__LINE__);

    $other = maybe_unserialize($cdata->other);
    

    if (isset($other['typing'][$user]) && $other['typing'][$user] == $type) {
        /* same state, ignore */
        return "already";
    } else {
    	global $wpdb;
    	global $wplc_tblname_chats;
        $other['typing'][$user] = $type;

        $wpdb->update( 
            $wplc_tblname_chats, 
            array( 
                'other' => maybe_serialize($other)
            ), 
            array('id' => $cid), 
            array( 
                '%s'
            ), 
            array('%d') 
        );

         $cdata = wplc_get_chat_data($cid,__LINE__);

         $other = maybe_unserialize($cdata->other);
        return $cid;
    }



        

}



/**
 * Add switchery JS & CSS button to the chat dashboard
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 * @return void
 */
if (!function_exists("wplc_choose_admin_scripts")) { 
	add_action('admin_print_scripts', 'wplc_choose_admin_scripts');
	function wplc_choose_admin_scripts() {
	    if(isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu'){
	        global $wplc_choose_version;
	        wp_register_script('wplc_switchery', plugins_url('js/switchery.min.js', __FILE__), array('jquery'),$wplc_choose_version);
	        wp_enqueue_script('wplc_switchery'); 
	        wp_register_style('wplc_switchery_css', plugins_url('css/switchery.min.css', __FILE__),false,$wplc_choose_version);
	        wp_enqueue_style('wplc_switchery_css');
	        wp_register_script('wplc-choose-script', plugins_url('/js/wplc_choose.js', __FILE__),array('jquery'),$wplc_choose_version);
	        wp_enqueue_script('wplc-choose-script');

	        $wpc_admin_js_strings = array(
	            'accepting_chats' => __('You are currently accepting chats', 'wplivechat'),
	            'not_accepting_chats' => __('You are not accepting chats', 'wplivechat')
	            );
	        wp_localize_script('wplc-choose-script', 'wplc_choose_admin_strings', $wpc_admin_js_strings);

		    $wplc_current_user_id = get_current_user_id();
		    $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
			if (isset($choose_array[$wplc_current_user_id]) && $choose_array[$wplc_current_user_id])  { 
				/* user is online */
				wp_localize_script('wplc-choose-script', 'wplc_choose_accept_chats', '1');
				wp_localize_script('wplc-choose-script', 'wplc_localized_offline_string', '');
				wp_localize_script('wplc-choose-script', 'wplc_localized_quote_string', '');

			} else {
	        	wp_localize_script('wplc-choose-script', 'wplc_choose_accept_chats', '0');
	        	$offline_string = "<p><span class='offline-status'>".__("You have set your status to offline. To view visitors and accept chats please set your status to online using the switch above.","wplivechat")."</span></p>";
	        	$quote_string = "<p><span class='offline-quote'>".wplc_random_quote()."</span></p>";
				wp_localize_script('wplc-choose-script', 'wplc_localized_offline_string', $offline_string);
				wp_localize_script('wplc-choose-script', 'wplc_localized_quote_string', $quote_string);

			}



	    }

	    if(isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu' && isset($_GET['action']) && $_GET['action'] == "ac"){
	        global $wplc_pro_version;
	        wp_register_script('wplc-qr-script', plugins_url('/js/quick_responses.js', __FILE__),array('jquery'),$wplc_pro_version);
	        wp_enqueue_script('wplc-qr-script');
	        wp_register_script('wplc-triggers', plugins_url('/js/triggers.js', __FILE__),array('jquery'),$wplc_pro_version);
	        wp_enqueue_script('wplc-triggers');

	        $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
			if(isset($wplc_pro_settings["wplc_ux_editor"]) && $wplc_pro_settings["wplc_ux_editor"] !== "0"){

		        wp_register_script('wplc-admin-editor', plugins_url('/js/wplc_admin_editor.js', __FILE__),array('jquery'),$wplc_pro_version);
		        wp_enqueue_script('wplc-admin-editor');
		    }


	    }


	}
}


/**
 * Remove default transient renewer if option is enabled
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 * @return void
 */
if (!function_exists("wplc_choose_hook_control_head")) { 
	add_action("wplc_maa_hook_head","wplc_choose_hook_control_head",1);
	function wplc_choose_hook_control_head() {
	    $wplc_choose_data = get_option("WPLC_CHOOSE_SETTINGS");
	    if(isset($wplc_choose_data['wplc_auto_online'])) { } else {
	        remove_action("wplc_maa_hook_head","wplc_maa_hook_control_head");
	    }

	}
}


/**
 * Add to the settings page
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_choose_hook_control_settings_page")) { 
	add_action('wplc_hook_admin_settings_main_settings_after','wplc_choose_hook_control_settings_page',1);
	function wplc_choose_hook_control_settings_page() {
	    $wplc_choose_data = get_option("WPLC_CHOOSE_SETTINGS");
	  ?>
	      
	    <table class='form-table wp-list-table widefat fixed striped pages' width='700'>
	        <tr>
	            <td width='300' valign='top'>
	                <?php _e("Choose when I want to be online", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Checking this will allow you to change your status to Online or Offline on the Live Chat page.', 'wplivechat'); ?>"></i>                     
	            </td>  
	            <td>
	                <input type="checkbox" value="1" name="wplc_auto_online" <?php if (isset($wplc_choose_data['wplc_auto_online']) && $wplc_choose_data['wplc_auto_online'] == 1) { echo "checked"; } ?> />                    
	            </td>
	        </tr>
	    </table>
	    <hr>

	  <?php
	}
}


/**
* Check if this is the first time the user has run the plugin. If yes, set the default settings
* @since        1.0.0
* @return       void
* @author       Nick Duncan <nick@codecabin.co.za>
*/
if (!function_exists("wplc_choose_first_run_check")) { 
	add_action("init","wplc_choose_first_run_check");
	function wplc_choose_first_run_check() {
	    if (!get_option("WPLC_CHOOSE_FIRST_RUN")) {
	        /* set the default settings */
	        
	        /* set the default of true for "accepting chats" */
	        $wplc_choose_data['wplc_auto_online'] = true;
	        update_option("WPLC_CHOOSE_SETTINGS",$wplc_choose_data);


	        $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
	        $user_id = get_current_user_id();
	        $choose_array[$user_id] = true;
	        update_option("WPLC_CHOOSE_ACCEPTING",$choose_array);

	        update_option("WPLC_CHOOSE_FIRST_RUN",true);
	    }
	}
}

/**
* Latch onto the default POST handling when saving live chat settings
* @since        1.0.0
* @param       
* @return       void
*/
if (!function_exists("wplc_choose_save_settings")) { 
	add_action('wplc_hook_admin_settings_save','wplc_choose_save_settings');
	function wplc_choose_save_settings() {
	    if (isset($_POST['wplc_save_settings'])) {
	    	$wplc_choose_data = get_option("WPLC_CHOOSE_SETTINGS");
	        if(isset($_POST['wplc_auto_online'])){ $wplc_choose_data['wplc_auto_online'] = esc_attr($_POST['wplc_auto_online']);} else { $wplc_choose_data['wplc_auto_online'] = 0; }
	                
	        update_option('WPLC_CHOOSE_SETTINGS', $wplc_choose_data);

	    }
	}
}
























/**
 * Encrypt the message via the filter
 * @param  string  $msg The message
 * @return string
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_encrypt_filter_control_message_control")) { 
	add_filter("wplc_filter_message_control","wplc_encrypt_filter_control_message_control",10,1);
	function wplc_encrypt_filter_control_message_control($msg) {
	    $msg = wplc_encrypt_encrypt_msg($msg);
	    return $msg;
	}
}




/**
 * Decrypt the message via the filter
 * @param  string  $msg The message
 * @return string
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_encrypt_filter_control_out_message_control")) { 
	add_filter("wplc_filter_message_control_out","wplc_encrypt_filter_control_out_message_control",10,1);
	function wplc_encrypt_filter_control_out_message_control($msg) {
	    $msg = wplc_encrypt_decrypt_msg($msg);
	    return $msg;
	}
}

/**
 * Add to the settings page
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_encrypt_hook_control_settings_page_more_tabs")) { 
	add_action("wplc_hook_settings_page_more_tabs","wplc_encrypt_hook_control_settings_page_more_tabs");
	function wplc_encrypt_hook_control_settings_page_more_tabs() {
	    $wplc_encrypt_data = get_option("WPLC_ENCRYPT_SETTINGS");
	  ?>
	 <div id="tabs-9">            
	    <h3><?php _e("Chat Encryption", "wplivechat") ?></h3>
	    <table class='form-table wp-list-table widefat fixed striped pages' width='700'>
	        <tr>
	            <td width='300' valign='top'><?php _e("Enable Encryption", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('All messages will be encrypted when being sent to and from the user and agent.', 'wplivechat'); ?>"></i></td> 
	            <td>
	                <input type="checkbox" name="wplc_enable_encryption" id="wplc_enable_encryption" value="1" <?php if(isset($wplc_encrypt_data['wplc_enable_encryption']) && $wplc_encrypt_data['wplc_enable_encryption'] == 1){ echo 'checked'; } ?>/>
	            </td>
	        </tr>
	        <tr>
	            <td width='300'></td>
	            <td>
	                <p class='notice notice-error'>
	                    <?php _e('Please note: Chat messages will only be encrypted and decrypted if you have inserted your WP Live Chat Support Pro API Key on the <a href="admin.php?page=wplivechat-menu-api-keys-page">API Keys page</a>.', 'wplivechat'); ?>
	                    <?php _e('Once enabled, all messages sent will be encrypted. This cannot be undone.', 'wplivechat'); ?>
	                </p>
	            </td>
	        </tr>
	    </table>
	</div>
	  <?php
	}
}

/**
 * Add to the tabs filter
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */

if (!function_exists("wplc_encrypt_filter_control_setting_tabs")) { 
	add_filter("wplc_filter_setting_tabs","wplc_encrypt_filter_control_setting_tabs");
	function wplc_encrypt_filter_control_setting_tabs($tab_array) {
	    $tab_array[9] = array(
	      "href" => "#tabs-9",
	      "icon" => 'fa fa-lock',
	      "label" => __("Encryption","wplivechat")
	    );
	    return $tab_array;
	}
}


/**
* Check if this is the first time the user has run the plugin. If yes, set the default settings
* @since        1.0.0
* @return       void
* @author       Nick Duncan <nick@codecabin.co.za>
*/
if (!function_exists("wplc_encrypt_first_run_check")) { 
	add_action("init","wplc_encrypt_first_run_check");
	function wplc_encrypt_first_run_check() {
	    if (!get_option("WPLC_ENCRYPT_FIRST_RUN")) {
	        /* set the default settings */
	        $wplc_encrypt_data['wplc_enable_encryption'] = 0;

	        update_option('WPLC_ENCRYPT_SETTINGS', $wplc_encrypt_data);
	        update_option("WPLC_ENCRYPT_FIRST_RUN",true);
	    }
	}
}


/**
* Latch onto the default POST handling when saving live chat settings
* @since        1.0.0
* @param       
* @return       void
*/
if (!function_exists("wplc_encrypt_save_settings")) { 
	add_action('wplc_hook_admin_settings_save','wplc_encrypt_save_settings');
	function wplc_encrypt_save_settings() {
	    if (isset($_POST['wplc_save_settings'])) {
	        if (isset($_POST['wplc_enable_encryption'])) {
	            $wplc_encrypt_data['wplc_enable_encryption'] = esc_attr($_POST['wplc_enable_encryption']);
	        } else {
	            $wplc_encrypt_data['wplc_enable_encryption'] = 0;
	        }
	        update_option('WPLC_ENCRYPT_SETTINGS', $wplc_encrypt_data);

	    }
	}
}

/**
* Encrypt the message
* @since        1.0.0
* @return       void
* @author       Jarryd Long <jarryd@codecabin.co.za>
*/
if (!function_exists("wplc_encrypt_encrypt_msg")) { 
	function wplc_encrypt_encrypt_msg($plaintext){
	    
	    $wplc_encrypt_data = get_option("WPLC_ENCRYPT_SETTINGS");
	    if(isset($wplc_encrypt_data['wplc_enable_encryption']) && intval($wplc_encrypt_data['wplc_enable_encryption']) == 1){
	    	
	    	$encrypted_salt = get_option( "wp-live-chat-support-pro_key" );	    	
	        $api_key = get_option('wplc_api_key');
	        
	        if( $api_key != '' ){
	        	/**
	        	 * Use the current API key and don't change anything
	        	 */
	        	$api_key = $api_key;
	        } else {
	        	/**
	        	 * It's empty so lets fix this
	        	 */
	        	if( $encrypted_salt != '' ){

	        		$api_key = $encrypted_salt;

	        	} else {

	        		$api_key = '';

	        	}
	        }
	        if($api_key != ''){	        	
	            $api_key = substr($api_key, 0, 10);

	            $plaintext_utf8 = utf8_encode($plaintext);
	            $inputData = cryptoHelpers::convertStringToByteArray($plaintext);
	            $keyAsNumbers = cryptoHelpers::toNumbers(bin2hex($api_key));
	            $keyLength = count($keyAsNumbers);
	            $iv = cryptoHelpers::generateSharedKey(16);

	            $encrypted = AES::encrypt(
	                $inputData,
	                AES::modeOfOperation_CBC,
	                $keyAsNumbers,
	                $keyLength,
	                $iv
	            );

	            $retVal = $encrypted['originalsize'] . " "
	                . cryptoHelpers::toHex($iv) . " "
	                . cryptoHelpers::toHex($encrypted['cipher']);

	            $message = array(
	                'e' => 1,
	                'm' => $retVal
	            );
	            return maybe_serialize($message);
	        } else {
	            $message = array(
	                'e' => 0,
	                'm' => $plaintext
	            );
	            return maybe_serialize($message);
	        }    
	    } else {
	        $message = array(
	            'e' => 0,
	            'm' => $plaintext
	        );
	        return maybe_serialize($message);
	    }
	}
}


/**
* Decrypt the message
* @since        1.0.0
* @return       void
* @author       Jarryd Long <jarryd@codecabin.co.za>
*/
if (!function_exists("wplc_encrypt_decrypt_msg")) { 
	function wplc_encrypt_decrypt_msg($input){

	        $messages = maybe_unserialize($input);


	        if(is_array($messages)){
	            if($messages['e'] == 1){
	                /* This message was encrypted */
	                $encrypted_salt = get_option( "wp-live-chat-support-pro_key" );	    	
			        $api_key = get_option('wplc_api_key');
			        
			        if( $api_key != '' ){
			        	/**
			        	 * Use the current API key and don't change anything
			        	 */
			        	$api_key = $api_key;
			        } else {
			        	/**
			        	 * It's empty so lets fix this
			        	 */
			        	if( $encrypted_salt != '' ){

			        		$api_key = $encrypted_salt;

			        	} else {

			        		$api_key = '';
			        		
			        	}
			        }
	               	// $api_key = get_option('wplc_api_key');
	                $api_key = substr($api_key, 0, 10);
	                $cipherSplit = explode( " ", $messages['m']);
	                $originalSize = intval($cipherSplit[0]);
	                $iv = cryptoHelpers::toNumbers($cipherSplit[1]);
	                $cipherText = $cipherSplit[2];

	                $cipherIn = cryptoHelpers::toNumbers($cipherText);
	                $keyAsNumbers = cryptoHelpers::toNumbers(bin2hex($api_key));
	                $keyLength = count($keyAsNumbers);

	                $decrypted = AES::decrypt(
	                    $cipherIn,
	                    $originalSize,
	                    AES::modeOfOperation_CBC,
	                    $keyAsNumbers,
	                    $keyLength,
	                    $iv
	                );

	                $hexDecrypted = cryptoHelpers::toHex($decrypted);
	                $retVal = pack("H*" , $hexDecrypted);

	                return stripslashes($retVal);
	            } else {
	                return stripslashes($messages['m']);
	            }  
	        } else{
	            return stripslashes($input);
	    }          
	}

}



if (!function_exists("wplc_inex_filter_control_display_contents")) { 
	add_filter("wplc_filter_display_contents","wplc_inex_filter_control_display_contents",1);
	function wplc_inex_filter_control_display_contents($display_contents) {

		$wplc_inex_data = get_option("WPLC_INEX_SETTINGS");

	    $post_id = get_the_ID();
	    if (!$post_id || $post_id === NULL) { 
	        $url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	        $post_id = url_to_postid($url); 
	    }

	    // Removed because of exclude on home/archive pages
	    // if (!$post_id) {  return true;  /* we cant get the page ID so just allow it - the JS should handle it from now */ }
		
	    if (isset($wplc_inex_data['wplc_include_on_pages'])) { $include_on_pages = $wplc_inex_data['wplc_include_on_pages']; } else { $include_on_pages = ""; }
	    if (isset($wplc_inex_data['wplc_exclude_from_pages'])) { $exclude_from_pages = $wplc_inex_data['wplc_exclude_from_pages']; } else { $exclude_from_pages = ""; }


	    if($include_on_pages == "" && $exclude_from_pages == ""){
	        $display_contents = 1;

	    } else {
	        
	        if($include_on_pages != ''){

	            $include_on_pages = explode(',', $include_on_pages);
	            foreach($include_on_pages as $key => $val) {
	                $include_on_pages[$key] = intval($val);
	            }
	            $include_array = array();
	            foreach($include_on_pages as $page){
	                $include_array [intval($page)] = intval($page);
	            }

	            if (isset($include_array[$post_id]) && $include_array[$post_id] > 0) {
	                $display_contents = true;
	            } else {
	                /* Do not show here */
	                $display_contents = false;
	            }

	            
	        } else {
	                
	            /* Exclude from the following pages */
	            $exclude_from_pages = explode(',', $exclude_from_pages);
	            $exclude_array = array();
	            foreach($exclude_from_pages as $page){
	                $exclude_array [$page] = intval($page);
	            }

	            $exclude_from_page = array_search($post_id, $exclude_array);
	            if($exclude_from_page === FALSE){
	                /* Show here */
	                $display_contents = true;
	            } else {
	               $display_contents = false;
	            }
	            
	        }	        
	        
	    }

	    if( isset( $wplc_inex_data['wplc_exclude_home'] ) && $wplc_inex_data['wplc_exclude_home'] == '1' ){

			if( is_home() || is_front_page() || $_SERVER['REQUEST_URI'] == '/' ){

	            $display_contents = false;

	        }
	        
	    }

	    if( isset( $wplc_inex_data['wplc_exclude_archive'] ) && $wplc_inex_data['wplc_exclude_archive'] == '1' ){

	    	if( is_archive() ){

		    	$display_contents = false;

		    }

	    }

		if ( isset( $wplc_inex_data['wplc_exclude_post_types'] ) && ! empty( $wplc_inex_data['wplc_exclude_post_types'] ) && in_array( get_post_type($post_id), $wplc_inex_data['wplc_exclude_post_types'] )  ) {
			$display_contents = false;
		}

		return $display_contents;

	}
}




/**
 * Add to the settings page
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_inex_hook_control_settings_page")) { 
	add_action('wplc_hook_admin_settings_main_settings_after','wplc_inex_hook_control_settings_page',1);
	function wplc_inex_hook_control_settings_page() {
	    $wplc_inex_data = get_option("WPLC_INEX_SETTINGS");
	  ?>
	      
	    <table class='form-table wp-list-table widefat fixed striped pages' width='700'>
	    	<tr>
	            <td width='300' valign='top'>
	                <?php _e("Exclude chat from 'Home' page:", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Leaving this unchecked will allow the chat window to display on your home page.", "wplivechat") ?>"></i>
	            </td>
	            <td valign='top'>
	                <input type="checkbox" name="wplc_exclude_home" <?php if (isset($wplc_inex_data['wplc_exclude_home'])) { echo 'checked'; } ?> value='1' />                      
	            </td>
            </tr>
            <tr>
	            <td width='300' valign='top'>
	                <?php _e("Exclude chat from 'Archive' pages:", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Leaving this unchecked will allow the chat window to display on your archive pages.", "wplivechat") ?>"></i>
	            </td>
	            <td valign='top'>
	                <input type="checkbox" name="wplc_exclude_archive" <?php if (isset($wplc_inex_data['wplc_exclude_archive'])) { echo 'checked'; } ?> value='1' />                      
	            </td>
            </tr>
	        <tr>
	            <td width='300' valign='top'>
	                <?php _e("Include chat window on the following pages:", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Show the chat window on the following pages. Leave blank to show on all. (Use comma-separated Page ID's)", "wplivechat") ?>"></i>
	            </td>
	            <td valign='top'>
	                <input type="text" name="wplc_include_on_pages" value="<?php if (isset($wplc_inex_data['wplc_include_on_pages'])) { echo $wplc_inex_data['wplc_include_on_pages']; } ?>" />                      
	            </td>
            </tr>
            <tr>
	            <td width='300' valign='top'>
	                <?php _e("Exclude chat window on the following pages:", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Do not show the chat window on the following pages. Leave blank to show on all. (Use comma-separated Page ID's)", "wplivechat") ?>"></i>                      
	            </td>
	            <td valign='top'>
	                <input type="text" name="wplc_exclude_from_pages" value="<?php if (isset($wplc_inex_data['wplc_exclude_from_pages'])) { echo $wplc_inex_data['wplc_exclude_from_pages']; } ?>" />                      
	            </td>
	        </tr>
            <tr class="wplc-exclude-post-types__row">
                <td width='200' valign='top'>
				    <?php _e("Exclude chat window on selected post types","wplivechat"); ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Do not show the chat window on the following post types pages.", "wplivechat") ?>"></i>
                </td>
                <td valign='top'><?php
                    $wplc_inex_settings = get_option('WPLC_INEX_SETTINGS');
				    $wplc_posts_types = get_post_types(
					    array(
                            '_builtin' => false,
                            'public' => true
                        ),
                        'objects'
				    );
				    if ( ! empty( $wplc_posts_types ) ) {
					    foreach ( $wplc_posts_types as $posts_type ) { ?>
                            <div class="wplc-exclude-post-types__item">
                                <input type="checkbox" value="<?php echo $posts_type->name; ?>" id="wplc_exclude_post_types_<?php echo $posts_type->name; ?>" name="wplc_exclude_post_types[]" <?php echo ( ! empty( $wplc_inex_settings['wplc_exclude_post_types'] ) && in_array( $posts_type->name, $wplc_inex_settings['wplc_exclude_post_types'] ) ) ? 'checked' : ''; ?> />
                                <label for="wplc_exclude_post_types_<?php echo $posts_type->name; ?>"><?php _e( $posts_type->label, "wplivechat" ) ?></label>
                            </div>
					    <?php
					    }
				    } else {
					    _e( 'No post types found.', 'wplivechat' );
                    } ?>
                </td>
            </tr>
	        <tr>
                <td width='300' valign='top'>
            		<?php _e("Allow any user to make themselves a chat agent", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Checking this will allow any of your users to make themselves a chat agent when editing their profile.', 'wplivechat'); ?>"></i>
                </td>
                <td>
                    <input type="checkbox" value="1" name="wplc_make_agent" <?php if (isset($wplc_inex_data['wplc_make_agent']) && $wplc_inex_data['wplc_make_agent'] == 1) { echo "checked"; } ?> />                                          
                </td>
            </tr>

	    </table>
	    <hr>

	  <?php
	}
}


/**
* Check if this is the first time the user has run the plugin. If yes, set the default settings
* @since        1.0.0
* @return       void
* @author       Nick Duncan <nick@codecabin.co.za>
*/
if (!function_exists("wplc_inex_first_run_check")) { 
	add_action("init","wplc_inex_first_run_check");
	function wplc_inex_first_run_check() {
	    if (!get_option("WPLC_INEX_FIRST_RUN")) {
	        /* set the default settings */
	        $wplc_inex_data['wplc_exclude_from_pages'] = "";
	        $wplc_inex_data['wplc_include_on_pages'] = "";

	        update_option('WPLC_INEX_SETTINGS', $wplc_inex_data);
	        update_option("WPLC_INEX_FIRST_RUN",true);
	    }
	}
}

/**
* Latch onto the default POST handling when saving live chat settings
* @since        1.0.0
* @param       
* @return       void
*/
if (!function_exists("wplc_inex_save_settings")) { 
	add_action('wplc_hook_admin_settings_save','wplc_inex_save_settings');
	function wplc_inex_save_settings() {
	    if (isset($_POST['wplc_save_settings'])) {
	        if (isset($_POST['wplc_include_on_pages'])) { $wplc_inex_data['wplc_include_on_pages'] = esc_attr($_POST['wplc_include_on_pages']); }
	        if (isset($_POST['wplc_exclude_from_pages'])) { $wplc_inex_data['wplc_exclude_from_pages'] = esc_attr($_POST['wplc_exclude_from_pages']); }
	        if (isset($_POST['wplc_exclude_post_types']) && ! empty($_POST['wplc_exclude_post_types'])) {
		        foreach ( $_POST['wplc_exclude_post_types'] as $post_type ) {
			        $wplc_inex_data['wplc_exclude_post_types'][] = esc_attr($post_type);
		        }
	        }

	        if (isset($_POST['wplc_exclude_home'])) { $wplc_inex_data['wplc_exclude_home'] = esc_attr($_POST['wplc_exclude_home']); }
	        if (isset($_POST['wplc_exclude_archive'])) { $wplc_inex_data['wplc_exclude_archive'] = esc_attr($_POST['wplc_exclude_archive']); }

	        if (isset($_POST['wplc_make_agent'])) { $wplc_inex_data['wplc_make_agent'] = esc_attr($_POST['wplc_make_agent']); }

	        update_option('WPLC_INEX_SETTINGS', $wplc_inex_data);

	    }
	}
}




















add_action('wplc_hook_admin_chatbox_javascript','wplc_ic_admin_javascript');
add_action("wplc_hook_admin_chatbox_javascript","wplc_features_admin_javascript");
add_action("init","wplc_ic_first_run_check");
add_action("wplc_hook_chat_dashboard_bottom","wplc_ic_hook_control_chat_dashboard_bottom",1);
add_action( 'wplc_hook_admin_menu_layout_display' , 'wplc_hook_control_admin_menu_layout_display', 1, 3);
add_action( 'wplc_hook_wplc_draw_chat_area', 'wplc_hook_control_wplc_draw_chat_area',1, 1);

add_filter( 'wplc_filter_list_chats_actions', 'wplc_ic_initiate_chat_button', 14, 3);
add_filter( 'wplc_filter_wplc_call_to_server_visitor_new_status_check', 'wplc_filter_control_wplc_call_to_server_visitor_new_status_check', 1, 1);

add_filter( 'wplc_ic_filter_check_plugin', 'wplc_ic_check_plugin');
add_filter("wplc_filter_run_override","wplc_ic_filter_control_run_override");


if (!function_exists("wplc_ic_filter_control_run_override")) { 
	function wplc_ic_filter_control_run_override($ret) {
		$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
		if (isset($wplc_pro_settings['wplc_disable_initiate_chat'])  && $wplc_pro_settings['wplc_disable_initiate_chat'] == 1 ) { return ""; } else { return "1"; /* allow long poll */ }

	    
	}
}

if (!function_exists("wplc_ic_check_plugin")) { 
	function wplc_ic_check_plugin() {
	    return true;
	}
}

/**
 * Decide whether or not to show the upgrade message for the add-on in the open source version
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_ic_hook_control_chat_dashboard_bottom")) { 
	function wplc_ic_hook_control_chat_dashboard_bottom() {
	    if (function_exists("wplc_hook_control_chat_dashboard_bottom")) {
	        remove_action("wplc_hook_chat_dashboard_bottom","wplc_hook_control_chat_dashboard_bottom");
	    }
	}
}



/**
* Add an item to the data_array ajax variable
*
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_ic_filter_control_admin_javascript")) { 
	add_filter("wplc_filter_admin_javascript","wplc_ic_filter_control_admin_javascript");
	function wplc_ic_filter_control_admin_javascript($data_array) {
	    $agent_id = wplc_ic_check_if_user_is_agent();
	    if ($agent_id) {
	        $data_array['agent_id'] = $agent_id;
	    }
	    return $data_array;

	}
}

/**
* Check if the user is an agent
*
* @since        1.0.0
* @param       
* @return       string
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_ic_check_if_user_is_agent")) { 
	function wplc_ic_check_if_user_is_agent(){
	    $user_id = get_current_user_id();
	    if (esc_attr(get_the_author_meta('wplc_ma_agent', $user_id ) ) == "1"){
	        return $user_id;
	    } else {
	        return "not_user_agent";
	    }
	}
}




/**
 * Initiate chat button
 * @param  string $default The default text that gets passed through
 * @param  int    $id2     ID of the chat
 * @return string
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_ic_initiate_chat_button")) { 
	function wplc_ic_initiate_chat_button($actions,$result,$post_data) {

	    /* remove original upselling button */
	    if (function_exists("wplc_initiate_chat_button")) {
	        remove_action("wplc_filter_list_chats_actions","wplc_initiate_chat_button");
	    }
	    if(intval($result->status) == 5 ){
	        $aid = "";
	        if ($post_data['wplc_extra_data']['agent_id']) {
	            if(is_numeric($post_data['wplc_extra_data']['agent_id'])){
	                $aid = "&aid=".$post_data['wplc_extra_data']['agent_id'];
	            }
	        }

	        $url = admin_url( 'admin.php?page=wplivechat-menu&action=rc&cid='.$result->id.$aid);
	        $url_params = apply_filters("wplc_filter_list_chats_url_params","",$result,$post_data);

	        /* have we disabled this? */
			$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
			if (isset($wplc_pro_settings['wplc_disable_initiate_chat']) && $wplc_pro_settings['wplc_disable_initiate_chat'] === '1' ) { 
		        $actions = ""; 
			} else { 

		        $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button wplc_initiate_chat button-secondary\" window-title=\"WP_Live_Chat_".$result->id.$url_params."\">".__("Initiate Chat","wplivechat")."</a>"; 
		    }
	        
	    } 


	    return $actions;
	   
	}
}

/**
 * Load pro features for the admin chat
 * @return void
 */
function wplc_features_admin_javascript() {
	global $wplc_version;
	$float_version = floatval($wplc_version);	

    if ($float_version >= 7) {	
		wp_register_script('wplc-admin-pro-features', plugins_url('/js/wplc_admin_pro_features.js', __FILE__), array('wplc-admin-chat-js'),false, false);
		wp_enqueue_script('wplc-admin-pro-features');
	}
}


/**
 * Localize the action2 variable that is required
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_ic_admin_javascript")) { 
	function wplc_ic_admin_javascript() {

		$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
		if (isset($wplc_pro_settings['wplc_typing_enabled']) && $wplc_pro_settings['wplc_typing_enabled'] == 1) { $typing_enabled = "1"; } else { $typing_enabled = "0"; }
	    
	   

	    if ($typing_enabled) {
	        $wpc_misc_js_strings = array(
	            'typing_enabled' => $typing_enabled,
	            'typingimg' => plugins_url('/images/comment.svg', __FILE__)
	            );
	    } else {
	        $wpc_misc_js_strings = array(
	            'typing_enabled' => $typing_enabled
	            );
	    }

        wp_localize_script('wplc-admin-chat-js', 'wplc_misc_strings', $wpc_misc_js_strings);



	    if (isset($_GET['action']) && $_GET['action'] == 'rc') { 
	        wp_localize_script( 'wplc-admin-chat-js', 'wplc_action2', 'wplc_long_poll_check_user_opened_chat' );
	        wp_localize_script( 'wplc-admin-chat-js', 'wplc_use_node_server', 'false' );
	    } else {
	        return;
	    }
	}
}

if (!function_exists("wplc_hook_control_intiate_check")) { 
	add_action("wplc_hook_initiate_check","wplc_hook_control_intiate_check",10,3);
	function wplc_hook_control_intiate_check($action,$cid,$aid) {
	    
	    wplc_change_chat_status($cid, 6); // 6 = request chat
	    
	    wplc_draw_chat_area($cid);


	}
}

/**
 * Decide what to show when an initialization is happening on the admin side
 * @param  string   $action    The action GET param
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_hook_control_admin_menu_layout_display")) { 
	function wplc_hook_control_admin_menu_layout_display($action, $cid,$aid) {
	    if ($action == 'rc') {
	        do_action("wplc_hook_initiate_check",$action,$cid,$aid);
	    }
	}
}

/**
 * Add the new status code to the JS array
 * @param  array   $array
 * @return array
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_filter_control_wplc_call_to_server_visitor_new_status_check")) { 
	function wplc_filter_control_wplc_call_to_server_visitor_new_status_check($array) {

	    if (intval($array['status']) == 6) {
	        $array['check'] = true;
	        $array['status'] = 3;
	        $array['wplc_name'] = "You";
	        wplc_change_chat_status(sanitize_text_field($array['cid']),3);
	    }
	    return $array;
	}
}

/**
 * Decide what to show when an initialization is happening on the admin side
 * @param  array   $array
 * @return array
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_hook_control_wplc_draw_chat_area")) { 
	function wplc_hook_control_wplc_draw_chat_area($result) {

	    wp_localize_script('wplc-admin-chat-js', 'wplc_chat_name', $result->name);


	    if (intval($result->status) == 6) {
	        echo "<strong>" . __("Attempting to open the chat window... Please be patient.", "wp-live-chat-support-initiate-chats") . "</strong>";
	        $result->continue = false;
	        return $result;
	    }
	    return $result;

	}
}


/**
* Check if this is the first time the user has run the plugin. If yes, set the default settings
* @since       	1.0.0
* @param       
* @return		void
* @author       Nick Duncan <nick@codecabin.co.za> 
*/
if (!function_exists("wplc_ic_first_run_check")) { 
	function wplc_ic_first_run_check() {
		if (!get_option("WPLC_IC_FIRST_RUN")) {
			/* set the default settings */
	        $wplc_freshdesk_data['wplc_ic_enable'] = 1;

	        update_option('WPLC_IC_SETTINGS', $wplc_freshdesk_data);
	        update_option("WPLC_IC_FIRST_RUN",true);
		}
	}
}



















/**
 * Checks if user is an agent while on the chat dashboard page
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_ma_hook_control_admin_meny_layout_display_top")) {
	function wplc_ma_hook_control_admin_meny_layout_display_top() {
	    $wplc_current_user_id = get_current_user_id();
	    $is_agent = get_user_meta($wplc_current_user_id, 'wplc_ma_agent', true);            
	    if(!$is_agent){
	        $warning = "<p style='color: red;'><b>".__('You are not a chat agent. Please make yourself a chat agent before trying to chat to visitors', 'wp-live-chat-support-multiple-agents')."</b></p>";
	        echo $warning;
	    }
	    return;
	}
}

/**
* Check if this is the first time the user has run the plugin. If yes, set the default settings
*
* @since       	1.0.0
* @param       
* @return		void
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_ma_first_run_check")) {
	add_action("init","wplc_ma_first_run_check");
	function wplc_ma_first_run_check() {
		if (!get_option("WPLC_ma_FIRST_RUN")) {
			/* set the default settings */
	        $wplc_freshdesk_data['wplc_ma_enable'] = 1;
	        wplc_ma_first_time_install();
	        update_option('WPLC_ma_SETTINGS', $wplc_freshdesk_data);
	        update_option("WPLC_ma_FIRST_RUN",true);
		}
	}
}




/**
* Assign the chat to the agent
*
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_maa_update_agent_id")) {
	function wplc_maa_update_agent_id($cid, $aid){
	    global $wpdb;
	    global $wplc_tblname_chats;
	    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `id` = '$cid'";
	    $result = $wpdb->get_row($sql); 
	    if(intval($result->status) != 3){
	        $update = "UPDATE `$wplc_tblname_chats` SET `agent_id` = '$aid' WHERE `id` = '$cid'";
	        $wpdb->query($update);
	    }
	}
}



/**
* Check if the user is an agent
*
* @since        1.0.0
* @param       
* @return       string
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_maa_check_if_user_is_agent")) {
	function wplc_maa_check_if_user_is_agent(){
	    $user_id = get_current_user_id();
	    if (esc_attr(get_the_author_meta('wplc_ma_agent', $user_id ) ) == "1"){
	        return $user_id;
	    } else {
	        return "not_user_agent";
	    }
	}
}



/**
* Check if the chat has been answered by another chat agent
* @since        1.0.0
* @param        int   $cid  Chat ID
* @param        int   $aid  Agent ID
* @return       bool
* @author       Nick Duncan (nick@codecabin.co.za) 
*/
if (!function_exists("wplc_maa_check_if_chat_answered_by_other_agent")) {
	function wplc_maa_check_if_chat_answered_by_other_agent($cid, $aid){
	    do_action("wplc_hook_ma_check_if_answered_by_another_agent",$cid,$aid);
	    
	}
}


if (!function_exists("wplc_hook_control_ma_check_if_answered_by_another_agent")) {
	add_action("wplc_hook_ma_check_if_answered_by_another_agent","wplc_hook_control_ma_check_if_answered_by_another_agent",10,2);
	function wplc_hook_control_ma_check_if_answered_by_another_agent($cid,$aid) {
	    global $wpdb;
	    global $wplc_tblname_chats;
	    $cid = intval($cid);
	    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `id` = '".$cid."'";
	    $result = $wpdb->get_row($sql); 
	    if(intval($result->agent_id) == intval($aid)){
	        return false;
	    } else {
	        return true;
	    }
	}
}


/**
 * Hook for updating the agent id
 * @param        int   $cid   Chat ID
 * @param        int   $aid   Agent ID
 * @since        1.0.0
 * @author       Nick Duncan (nick@codecabin.co.za) 
 * @return       void
 */
if (!function_exists("wplc_ma_hook_control_update_agent_id")) {
	add_action("wplc_hook_update_agent_id","wplc_ma_hook_control_update_agent_id",10,2);
	function wplc_ma_hook_control_update_agent_id($cid,$aid) {
	    wplc_maa_update_agent_id(sanitize_text_field($cid), sanitize_text_field($aid));

	}
}


/**
* On first installation activation, set current admin as chat agent
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*/
if (!function_exists("wplc_ma_first_time_install")) {
	function wplc_ma_first_time_install() {
	    global $wpdb;
	    global $wplc_tblname_chats;


	    $sql = " SHOW COLUMNS FROM ".$wplc_tblname_chats." WHERE `Field` = 'agent_id'";
	    $results = $wpdb->get_results($sql);
	    if (!$results) {
	        $sql = "ALTER TABLE `$wplc_tblname_chats` ADD `agent_id` INT(11) NOT NULL;";
	        $wpdb->query($sql);
	    }



	    $admins = get_role('administrator');
	    $admins->add_cap('wplc_ma_agent');
	    $uid = get_current_user_id();
	    update_user_meta($uid, 'wplc_ma_agent', 1);
	    update_user_meta($uid, "wplc_chat_agent_online", time());
	}
}




/**
* Set the user as an agent
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*/
if (!function_exists("wplc_maa_set_user_as_agent")) {
	function wplc_maa_set_user_as_agent( $user_id ) {
	    
	    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	    if(isset($_POST['wplc_ma_agent'])){
	        update_user_meta( $user_id, 'wplc_ma_agent', $_POST['wplc_ma_agent']);
	    } else {
	        delete_user_meta( $user_id, 'wplc_ma_agent');
	    }
	    
	    if ($_POST['wplc_ma_agent'] == '1') {
	        $wplc_ma_user = new WP_User( $user_id );
	        $wplc_ma_user->add_cap( 'wplc_ma_agent' );
	        update_user_meta($user_id, "wplc_chat_agent_online", time());
	    } else {
	        $wplc_ma_user = new WP_User( $user_id );
	        $wplc_ma_user->remove_cap( 'wplc_ma_agent' );
	        delete_user_meta($user_id, "wplc_ma_agent");
	        delete_user_meta($user_id, "wplc_chat_agent_online");
	    }

	    do_action("wplc_pro_set_user_hook", $user_id);
	}
}


/**
* Add the custom fields to the user profile page
*
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_maa_custom_user_profile_fields")) {
	function wplc_maa_custom_user_profile_fields($user) {
	    $wplc_settings = get_option('WPLC_INEX_SETTINGS');
	    if(isset($wplc_settings['wplc_make_agent']) && $wplc_settings['wplc_make_agent'] == 1){
	        ?>
	        <table class="form-table">
	            <tr>
	                <th>
	                    <label for="wplc_ma_agent"><?php _e('Chat Agent', 'wplivechat'); ?></label>
	                </th>
	                <td>
	                    <label for="wplc_ma_agent">
	                    <input name="wplc_ma_agent" type="checkbox" id="wplc_ma_agent" value="1" <?php if (esc_attr( get_the_author_meta( 'wplc_ma_agent', $user->ID ) ) == "1") { echo "checked=\"checked\""; } ?>>
	                    <?php _e("Make this user a chat agent","wplivechat"); ?></label>
	                </td>
	            </tr>
	        </table>
	        <?php
	    } else {
	        if(current_user_can('manage_options', array(null))){
	        ?>
	        <table class="form-table">
	            <tr>
	                <th>
	                    <label for="wplc_ma_agent"><?php _e('Chat Agent', 'wplivechat'); ?></label>
	                </th>
	                <td>
	                    <label for="wplc_ma_agent">
	                    <input name="wplc_ma_agent" type="checkbox" id="wplc_ma_agent" value="1" <?php if (esc_attr( get_the_author_meta( 'wplc_ma_agent', $user->ID ) ) == "1") { echo "checked=\"checked\""; } ?>>
	                    <?php _e("Make this user a chat agent","wplivechat"); ?></label>
	                </td>
	            </tr>
	        </table>
	        <?php
	        } else {
	            ?>
	            <table class="form-table">
	                <tr>
	                    <th>
	                        <label for="wplc_ma_agent"><?php _e('Chat Agent', 'wplivechat'); ?></label>
	                    </th>
	                    <td>
	                        <?php 
	                            echo "<p>".__("Your user role does not allow you to make yourself a chat agent.","wplivechat")."</p>"; 
	                            echo "<p>".__("Please contact the administrator of this website to change this.", "wplivechat")."</p>";
	                        ?>                    
	                    </td>
	                </tr>
	            </table>
	            <?php
	        }
	    }

	    do_action("wplc_pro_custom_user_profile_field_after_content_hook", $user);

	}
}


if (!function_exists("wplc_ma_hook_control_accept_chat")) {
	add_action('wplc_hook_accept_chat','wplc_ma_hook_control_accept_chat',1,2);
	function wplc_ma_hook_control_accept_chat($get_data,$aid) {
	    if (wplc_maa_check_if_chat_answered_by_other_agent(intval($get_data['cid']), intval($aid)) === true) {
	        echo "<p>".__("This chat has already been answered by another agent.", "wplivechat")."</p>";
	        exit();
	        if (function_exists("wplc_hook_control_accept_chat")) {
	            remove_action("wplc_hook_accept_chat","wplc_hook_control_accept_chat");
	        }
	    }
	}
}


function wplc_write_log_file($data) {
	$string = "===============================\n";
	$string .= date("Y-m-d H:i:s")."\n";
	$string .= "===============================\n\n";
	if (is_array($data) || is_object($data)) {
		$string .= json_encode($data, JSON_PRETTY_PRINT);

	} else {
		$string .= $data;
	}


	if (defined('WP_CONTENT_DIR')) {

	$string .= "\n\n";

	$file = WP_CONTENT_DIR.'/uploads/wplc-log-file.txt';
	// Write the contents to the file, 
	// using the FILE_APPEND flag to append the content to the end of the file
	// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
	file_put_contents($file, $string, FILE_APPEND | LOCK_EX);

	}


}

function wplc_is_typing($user,$cid) {
	$cdata = wplc_get_chat_data($cid,__LINE__);
	
	if (isset($cdata->other)) {
	    $other = maybe_unserialize($cdata->other);

	    if (isset($other['typing'][$user]) && $other['typing'][$user] > 0) {
	    	
	    	return true;	
		} else {

			return false;
		}
	} else {
		return false;
	}

}


/**
* Modify the loop iteration
*
* @since        1.0.0
* @param       
* @return       array
* @author       Nick Duncan (nick@codecabin.co.za) 
*/

if (!function_exists("wplc_ma_filter_control_wplc_admin_long_poll_chat_iteration")) {
	add_filter("wplc_filter_admin_long_poll_chat_loop_iteration","wplc_ma_filter_control_wplc_admin_long_poll_chat_iteration", 11, 4);
	function wplc_ma_filter_control_wplc_admin_long_poll_chat_iteration($array,$post_data,$i,$cdata = false) {
		

		if (!$cdata) {
			$cdata = wplc_get_chat_data($post_data['cid'],__LINE__);
		}

		/* check to see if the user is typing and notify the agent */
		$previous_is_typing = get_option("wplc_previous_is_typing");
		
	    /* run checks for old chats and remove them from this variable */
	    if ($previous_is_typing) {
	    	foreach ($previous_is_typing as $cid => $val) {
	    		$cdata = wplc_get_chat_data($cid,__LINE__);
	    		
	    		if ($cdata->status != "3") {
	    			unset($previous_is_typing[$cid]);
	    			update_option("wplc_previous_is_typing",$previous_is_typing);
	    			
	    		}
	    		
	    	}
	    }

		
		if (!isset($previous_is_typing[$post_data['cid']])) { $previous_is_typing[$post_data['cid']] = false; }

		if (!isset($previous_is_typing[$post_data['cid']]['user'])) { $previous_is_typing[$post_data['cid']]['user'] = false; }
		/* 0 = user, 1 = agent */
		$is_typing_check = wplc_is_typing('user',$post_data['cid'],$cdata);

		if ($is_typing_check !== $previous_is_typing[$post_data['cid']]['user']) {
			

			$array['is_typing_check'] = $is_typing_check;
			$array['previous_is_typing'] = $previous_is_typing[$post_data['cid']]['user'];

			if ($is_typing_check) { $checker = "1"; }
			else { $checker = "0"; }

			$array['typing'] = $checker;

			/* 0 = user, 1 = agent */
			$previous_is_typing[$post_data['cid']]['user'] = $is_typing_check;
			update_option("wplc_previous_is_typing",$previous_is_typing);

		} else {
			
		}

		


	    if (isset($post_data['extra_data']['agent_id'])) {
	        if (wplc_maa_check_if_chat_answered_by_other_agent(intval($post_data['cid']), intval($post_data['extra_data']['agent_id'])) === true) {
	            /* chat already answered by another agent */
	            $array['action'] = "wplc_ma_agant_already_answered";
	        }
	    }
		
		//Update Chat Experience Rating*/ 
	   	$rating_checker = nifty_get_rating_data($post_data['cid']);
	   	if( isset( $array['chat_rating'] ) ){
	   		$previous_rating = $array['chat_rating'];	
	   	} else {
	   		$previous_rating = "";
	   	}
	   	
        if ($rating_checker != $previous_rating) {
      		$array['chat_rating'] = $rating_checker;
        }
	    
	    return $array;

	}
}




/**
* Modify the loop iteration
*
* @since        1.0.0
* @param       
* @return       array
* @author       Nick Duncan (nick@codecabin.co.za) 
*/

if (!function_exists("wplc_ma_filter_control_wplc_user_long_poll_chat_iteration")) {
	add_filter("wplc_filter_user_long_poll_chat_loop_iteration","wplc_ma_filter_control_wplc_user_long_poll_chat_iteration", 11, 4);
	function wplc_ma_filter_control_wplc_user_long_poll_chat_iteration($array,$post_data,$i,$cdata = false) {

		if (!$cdata) {
			$cdata = wplc_get_chat_data($post_data['cid'],__LINE__);
		}

		$previous_is_typing = get_option("wplc_previous_is_typing");
		//wplc_write_log_file($previous_is_typing);
		
		/* check to see if the agent is typing and notify the user */
		if (!isset($previous_is_typing[$post_data['cid']])) { $previous_is_typing[$post_data['cid']] = false; }

		if (!isset($previous_is_typing[$post_data['cid']]['admin'])) { $previous_is_typing[$post_data['cid']]['admin'] = false; }
		/* 0 = user, 1 = agent */
		$is_typing_check = wplc_is_typing('admin',$post_data['cid'],$cdata);



		if ($is_typing_check !== $previous_is_typing[$post_data['cid']]['admin']) {
			wplc_write_log_file("is different for admin. Went front ".$is_typing_check. " to ".$previous_is_typing[$post_data['cid']]['admin']);
				
			$array['is_typing_check'] = $is_typing_check;
			$array['previous_is_typing'] = $previous_is_typing[$post_data['cid']]['admin'];

			if ($is_typing_check) { $checker = "1"; }
			else { $checker = "0"; }

			$array['typing'] = $checker;
			$array['check'] = true; /* this forces the array to be returned in the loop */
			$array['status'] = $post_data['status']; /* this is required to carry through the loop */

			/* 0 = user, 1 = agent */
			$previous_is_typing[$post_data['cid']]['admin'] = $is_typing_check;
			update_option("wplc_previous_is_typing",$previous_is_typing);

		} else {
			$array['is_typing_check'] = $is_typing_check;
			$array['previous_is_typing'] = $previous_is_typing[$post_data['cid']]['admin'];
		}

	    return $array;

	}
}




/**
* Hook to accept chat
*
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_ma_hook_control_accept_chat_url")) {
	add_action( 'wplc_hook_accept_chat_url' , 'wplc_ma_hook_control_accept_chat_url', 10, 1);
	function wplc_ma_hook_control_accept_chat_url($get_data) {
	    if (!isset($get_data['agent_id'])) {
	        /* something went wrong :/ */
	    } else {
	        wplc_maa_update_agent_id(sanitize_text_field($get_data['cid']), sanitize_text_field($get_data['agent_id']));    
	    }
	    
	}
}


if (!function_exists("wplc_filter_control_aid_in_action")) {
	add_filter("wplc_filter_aid_in_action","wplc_filter_control_aid_in_action");
	function wplc_filter_control_aid_in_action() {
	    $aid = "";
	    $agent_id = wplc_maa_check_if_user_is_agent();
	    if(is_numeric($agent_id)){
	        $aid = "&aid=".$agent_id;
	    }
	    return $aid;
	}
}


/**
* Modify the menu for agents
*
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/

if (!function_exists("wplc_ma_filter_control_menu_control")) {
	add_filter("wplc_ma_filter_menu_control","wplc_ma_filter_control_menu_control", 10, 3);
	function wplc_ma_filter_control_menu_control() {
	    if (current_user_can('wplc_ma_agent')) {
	        $array = array(
	          0 => 'wplc_ma_agent', /* main menu */
	          1 => 'manage_options', /* settings */
	          2 => 'wplc_ma_agent', /* history */
	          3 => 'wplc_ma_agent', /* missed chats */
	          4 => 'wplc_ma_agent', /* offline messages */
	          5 => 'manage_options' /* feedback */
	          );
	    } else if (current_user_can('manage_options')) {
	        $array = array(
	          0 => 'manage_options', /* main menu */
	          1 => 'manage_options', /* settings */
	          2 => 'manage_options', /* history */
	          3 => 'manage_options', /* missed chats */
	          4 => 'manage_options', /* offline messages */
	          5 => 'manage_options' /* feedback */
	          );
	    } else {
	    	$array = array(
	          0 => 'read', /* main menu */
	          1 => 'read', /* settings */
	          2 => 'read', /* history */
	          3 => 'read', /* missed chats */
	          4 => 'read', /* offline messages */
	          5 => 'read' /* feedback */
	          );
	    }
	    return $array;
	}
}

/**
* 
*
* @since        1.0.0
* @param       
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za) 
*
*/
if (!function_exists("wplc_ma_filter_control_admin_javascript")) {
	add_filter("wplc_filter_admin_javascript","wplc_ma_filter_control_admin_javascript");
	function wplc_ma_filter_control_admin_javascript($data_array) {
	    $agent_id = wplc_maa_check_if_user_is_agent();
	    if ($agent_id) {
	        $data_array['agent_id'] = $agent_id;
	    }
	    return $data_array;

	}
}





/**
 * Control the content below the visitor count
 * @return void
 */
if (!function_exists("wplc_ma_filter_control_chat_dashboard_visitors_online_bottom")) {
	add_action("wplc_filter_chat_dahsboard_visitors_online_bottom","wplc_ma_filter_control_chat_dashboard_visitors_online_bottom",11);
	function wplc_ma_filter_control_chat_dashboard_visitors_online_bottom($text) {
	  $text = "<hr />";
	  $text .= "  <p class='wplc-agent-info2' id='wplc-agent-info'>";
	  $text .= "      <span class='wplc_agents_online'>".wplc_maa_total_agents_online()."</span>";
	  $text .= "      <a href='?page=wplivechat-menu-settings#tabs-5' target='_BLANK'>".__("Agent(s) online","wplivechat")."</a>";
	  $text .= "  </p>";
	  return $text;
	}
}

/**
 * Count how many agents are online
 * @return int 	number of agents
 */
if (!function_exists("wplc_maa_total_agents_online")) {
	
	/*
	
	* removed in 6.1.01 and replaced with code below
	
	function wplc_maa_total_agents_online(){
	    $users = get_users(array(
	        'meta_key'=> 'wplc_chat_agent_online',
	    ));
	    return count($users);
	}
	*/
	function wplc_maa_total_agents_online(){
       $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
       $count_agents = 0;
       if($choose_array){
           foreach($choose_array as $ch){
               if($ch == true){
                   $count_agents++;
               }
           }
       }
       return $count_agents;
   	}
}


if (!function_exists("wplc_maa_online_agents")) {	

   add_action('admin_bar_menu', 'wplc_maa_online_agents', 100);
   function wplc_maa_online_agents(){ 

   	if( !current_user_can( 'wplc_ma_agent', array(null) ) ){
   		return; //if user doesn't have permissions for chat agent, do not show admin bar.
   	}
   	?>
       <style >
           .wplc_circle{
               width: 10px !important;
               height: 10px !important;
               display: inline-block !important;
               border-radius: 100% !important;
               margin-right: 5px !important;
           }
           .wplc_red_circle{
               background: red;
           }
           .wplc_green_circle{
               background:rgb(103, 213, 82);
           }
       </style>
       <?php 
       if(wplc_maa_is_agent_online()){
           $online_now = wplc_maa_total_agents_online();
           $circle_class = "wplc_green_circle";
           if($online_now == 1){
               $chat_agents = __('Chat Agent Online', 'wplivechat');
           } else {
               $chat_agents = __('Chat Agents Online', 'wplivechat');
           }
       } else {
           $online_now = 0;
           $circle_class = "wplc_red_circle";
           $chat_agents = __('Chat Agents Online', 'wplivechat');
       }

       global $wp_admin_bar;
       $wp_admin_bar->add_menu( array(
           'id' => 'wplc_ma_online_agents',
           'title' => '<span class="wplc_circle '.$circle_class.'"></span>'.$online_now.' '.$chat_agents,
           'href' => false
       ) );
       $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");
       if($online_now > 0){
           $user_array =  get_users(array(
               'meta_key'=> 'wplc_chat_agent_online',
           ));
           foreach($user_array as $user){
               $online = get_user_meta($user->ID, 'wplc_chat_agent_online' );

               foreach($choose_array as $key => $val ){
                   if( $key == $user->ID && $val == true ){
                       $wp_admin_bar->add_menu( array(
                           'id' => 'wplc_user_online_'.$user->ID,
                           'parent' => 'wplc_ma_online_agents',
                           'title' => $user->display_name,
                           'href' => false,
                       ) );

                   }
               }
               
           }
       }
   }
}

add_action('admin_menu', 'wplc_pro_remove_menus');

function wplc_pro_remove_menus() {
    //remove_menu_page('edit.php?post_type=wplc_quick_response');
}


/**
 * Allow agent to access the menu
 * @return void
 * @since  6.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
add_action("wplc_hook_menu_mid","wplc_pro_hook_control_menu",10,1);
function wplc_pro_hook_control_menu($cap) {
	//add_submenu_page('wplivechat-menu', __('Quick Responses', 'wplivechat'), __('Quick Responses', 'edit_posts'), $cap[0], 'edit.php?post_type=wplc_quick_response');
	add_submenu_page('wplivechat-menu', __('Reporting', 'wplivechat'), __('Reporting', 'edit_posts'), $cap[0], 'wplc-pro-reporting', 'wplc_pro_reporting_page');
	add_submenu_page('wplivechat-menu', __('Triggers', 'wplivechat'), __('Triggers', 'edit_posts'), $cap[0], 'wplc-pro-triggers', 'wplc_pro_triggers_page');
	add_submenu_page('wplivechat-menu', __('Custom Fields', 'wplivechat'), __('Custom Fields', 'edit_posts'), $cap[0], 'wplc-pro-custom-fields', 'wplc_pro_custom_fields_page');
}

/**
 * Logs the agent out
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */

if (!function_exists("wplc_maa_remove_agents_online")) {
	function wplc_maa_remove_agents_online($user_id){
	    delete_user_meta($user_id, "wplc_chat_agent_online");
	}
}

/**
 * Remove the default transient function from the normal plugin, add our own (just below)
 */
if (!function_exists("wplc_maa_hook_control_superadmin_head")) {
	add_action("wplc_hook_superadmin_head","wplc_maa_hook_control_superadmin_head",1);
	function wplc_maa_hook_control_superadmin_head() {
	    remove_action("wplc_hook_superadmin_head","wplc_hook_control_superadmin_head");
	}
}

/**
 * Transient renewer to refresh the agent's online status
 * @return void
 */
if (!function_exists("wplc_maa_hook_control_head")) {
	add_action("wplc_maa_hook_head","wplc_maa_hook_control_head",10);
	function wplc_maa_hook_control_head() {
	    if (isset($_GET['page']) && $_GET['page'] == "wplivechat-menu" && (!isset($_GET['action']))) {
	        global $wplc_multiple_agents_version;
	        wp_register_script("wplc-ma-transient-js", plugins_url('js/wplc_ma_transient.js', __FILE__), true,$wplc_multiple_agents_version);
	        wp_enqueue_script('wplc-ma-transient-js');
	    }
	}
}


/**
 * Check if an agent is logged into the wp-admin section
 * @param  bool   $logged_in
 * @return array
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_maa_filter_control_check_if_logged_in")) {
	add_filter("wplc_filter_is_admin_logged_in","wplc_maa_filter_control_check_if_logged_in",10,1);
	function wplc_maa_filter_control_check_if_logged_in($logged_in) {
	    $logged_in['site'] = wplc_maa_is_agent_online();
	    return $logged_in;
	}
}


/**
 * Logs the agent out
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_maa_agent_logout")) {
	add_action('wp_logout', 'wplc_maa_agent_logout');
	function wplc_maa_agent_logout(){
	    $user_id = get_current_user_id();
	//    $user_array = unserialize(get_transient('wplc_online_agents'));
	//    $key = array_search($user_id, $user_array);
	//    unset($user_array[$key]);
	//    set_transient('wplc_online_agents', serialize($user_array), 20);
	    delete_user_meta($user_id, "wplc_chat_agent_online");
	}
}

/**
 * Is the agent online?
 * @return bool
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */

if (!function_exists("wplc_maa_is_agent_online")) {
	function wplc_maa_is_agent_online(){

	    $wplc_online = 0;
	    $choose_array = get_option("WPLC_CHOOSE_ACCEPTING");

		if( $choose_array ){
    		foreach($choose_array as $choose ){
	    		if($choose === TRUE){
    				$wplc_online++;
    			}
    		}
		}

	    if($wplc_online > 0){
	        return true;
	    } else {
	        return false;
	    }

	}
}



/**
 * Add the JS file to the admin screen
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_control_admin_javascript")) {
	function wplc_control_admin_javascript() {
	    if (isset($_GET['page']) && ($_GET['page'] == 'wplivechat-menu-settings')) {

	    
	        global $wplc_multiple_agents_version;
	        wp_register_script("wplc-ma-js", plugins_url('js/wplc_ma.js', __FILE__), false,$wplc_multiple_agents_version);
	        wp_enqueue_script('wplc-ma-js');
	        
	        $ajax_url = admin_url('admin-ajax.php');
	        $wplc_ajax_url = apply_filters("wplc_filter_ajax_url",$ajax_url);
	        wp_localize_script('wplc-ma-js', 'wplc_ajaxurl', $wplc_ajax_url);

	        $wpc_ma_js_strings = array(
	        'remove_agent' => __('Remove', 'wplivechat'),
	        'nonce' => wp_create_nonce("wplc"),
	        'user_id' => get_current_user_id()
	        );
	        wp_localize_script('wplc-ma-js', 'wplc_admin_strings', $wpc_ma_js_strings);
	    }
	    do_action("wplc_maa_hook_head");
	}
}

if (!function_exists("wplc_ma_hook_control_action_callback")) {
	add_action("wplc_hook_set_transient","wplc_ma_hook_control_set_transient",9);
	function wplc_ma_hook_control_set_transient() {
	    $should_set_transient = apply_filters("wplc_filter_control_set_transient",true);
	    if ($should_set_transient) {
	        if (isset($_POST['user_id'])) { $user_id = $_POST['user_id']; } else { $user_id = get_current_user_id(); }
	        wplc_maa_set_agents_online($user_id);
	    }
	    remove_action("wplc_hook_set_transient","wplc_hook_control_set_transient");
	    
	}
}


if (!function_exists("wplc_ma_hook_control_remove_transient")) {
	add_action("wplc_hook_remove_transient","wplc_ma_hook_control_remove_transient",9);
	function wplc_ma_hook_control_remove_transient() {
	    wplc_maa_remove_agents_online($_POST['user_id']);
	    remove_action("wplc_hook_remove_transient","wplc_hook_control_remove_transient");
	}
}

/**
 * AJAX callback control
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
if (!function_exists("wplc_ma_hook_control_action_callback")) {
	add_action("wplc_hook_action_callback","wplc_ma_hook_control_action_callback");
	function wplc_ma_hook_control_action_callback() {
	    
	    if ($_POST['action'] == "wplc_add_agent") {
	      if (current_user_can("manage_options")) {
	          $uid = sanitize_text_field(intval($_POST['uid']));
	          if (isset($uid)) {
	              update_user_meta($uid, 'wplc_ma_agent', true);
	              echo "1";
	          } else {
	            echo "0";
	          }
	      }
	    }
	    if ($_POST['action'] == "wplc_remove_agent") {
	      if (current_user_can("manage_options")) {
	            $uid = sanitize_text_field(intval($_POST['uid']));
	            if (isset($uid)) {
	                delete_user_meta($uid, 'wplc_ma_agent');
	                echo "1";
	            } else {
	              echo "0";
	            }
	        }
	    } 

        if ($_POST['action'] == "wplc_macro") {
            if (isset($_POST['postid'])) {
                $post_id = $_POST['postid'];
            } else {
                return false;
            }

            if ($post_id > 0) {
                $post_details = get_post($post_id);
                if ($post_details) {
                    echo json_encode(nl2br($post_details->post_content));
                } else {
                    echo json_encode("No post with that ID");
                    die();
                }
            } else {
                echo json_encode("No macro with that ID");
                die();
            }
        }

	}
}

/**
 * Mark the agent as "online"
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */

if (!function_exists("wplc_maa_set_agents_online")) {
	function wplc_maa_set_agents_online($user_id){
	    
	    if (esc_attr( get_the_author_meta( 'wplc_ma_agent', $user_id ) ) == "1"){
	        
	        update_user_meta($user_id, "wplc_chat_agent_online", time());
	    }
	    $users = get_users(array(
	        'meta_key'=> 'wplc_chat_agent_online',
	    ));
	    foreach($users as $user){
	        $time = get_user_meta($user->ID, "wplc_chat_agent_online", true);
	        $diff = time() - $time;
	        if($diff > 65){
	            delete_user_meta($user->ID, "wplc_chat_agent_online");
	        }
	    }
	}
}

if (!function_exists("wplc_ma_hook_control_agents_settings")) {
	add_action("wplc_hook_agents_settings","wplc_ma_hook_control_agents_settings", 1);
	function wplc_ma_hook_control_agents_settings() {
	    
	    if (function_exists("wplc_hook_control_agents_settings")) { 
	        remove_action("wplc_hook_agents_settings","wplc_hook_control_agents_settings");
	    }




	    $user_array = get_users(array(
	        'meta_key' => 'wplc_ma_agent',
	    ));

	    echo "<h3>".__('Current Users that are Chat Agents', 'wplivechat')."</h3>";

	    $wplc_agents = "<div class='wplc_agent_container'><ul>";

	    if ($user_array) {
	        foreach ($user_array as $user) {

	            $wplc_agents .= "<li id=\"wplc_agent_li_".$user->ID."\">";
	            $wplc_agents .= "<p><img src=\"//www.gravatar.com/avatar/" . md5($user->user_email) . "?s=80&d=mm\" /></p>";
	             $check = get_user_meta($user->ID,"wplc_chat_agent_online");
	            if ($check) {
	                $wplc_agents .= "<span class='wplc_status_box wplc_type_returning'>".__("Online","wplivechat")."</span>";
	            }
	            $wplc_agents .= "<h3>" . $user->display_name . "</h3>";
	           
	            $wplc_agents .= "<small>" . $user->user_email . "</small>";

	            $wplc_agents .= apply_filters("wplc_pro_agent_list_before_button_filter", "", $user);

	            if (get_current_user_id() == $user->ID) {
	            } else { 
	                $wplc_agents .= "<p><button class='button button-secondary' id='wplc_remove_agent' uid='".$user->ID."'>".__("Remove","wplivechat")."</button></p>";
	            }
	            $wplc_agents .= "</li>";
	        }
	    }
	    echo $wplc_agents;
	    ?>
	    <li style='width:150px;' id='wplc_add_new_agent_box'>
	        <p><i class='fa fa-plus-circle fa-4x' style='color:#ccc;' ></i></p>
	        <h3><?php _e("Add New Agent","wplivechat"); ?></h3>
	        <select id='wplc_agent_select'>
	            <option value=''><?php _e("Select","wplivechat"); ?></option>
	        <?php 
	            $blogusers = get_users( array( 'role' => 'administrator', 'fields' => array( 'display_name','ID','user_email' ) ) );
	            // Array of stdClass objects.
	            foreach ( $blogusers as $user ) {
	                $is_agent = get_user_meta(esc_html( $user->ID ), 'wplc_ma_agent', true);            
	                if(!$is_agent){ echo '<option id="wplc_selected_agent_'. esc_html( $user->ID ) .'" em="' . md5(esc_html( $user->user_email )) . '" uid="' . esc_html( $user->ID ) . '" em2="' . esc_html( $user->user_email ) . '"  name="' . esc_html( $user->display_name ) . '" value="' . esc_html( $user->ID ) . '">' . esc_html( $user->display_name ) . ' ('.__('Administrator','wplivechat').')</option>'; }
	            }
	            $blogusers = get_users( array( 'role' => 'editor', 'fields' => array( 'display_name','ID','user_email' ) ) );
	            // Array of stdClass objects.
	            foreach ( $blogusers as $user ) {
	                $is_agent = get_user_meta(esc_html( $user->ID ), 'wplc_ma_agent', true);            
	                if(!$is_agent){ echo '<option id="wplc_selected_agent_'. esc_html( $user->ID ) .'" em="' . md5(esc_html( $user->user_email )) . '" uid="' . esc_html( $user->ID ) . '" em2="' . esc_html( $user->user_email ) . '"  name="' . esc_html( $user->display_name ) . '" value="' . esc_html( $user->ID ) . '">' . esc_html( $user->display_name ) . ' ('.__('Editor','wplivechat').')</option>'; }
	            }
	            $blogusers = get_users( array( 'role' => 'author', 'fields' => array( 'display_name','ID','user_email' ) ) );
	            // Array of stdClass objects.
	            foreach ( $blogusers as $user ) {
	                $is_agent = get_user_meta(esc_html( $user->ID ), 'wplc_ma_agent', true);            
	                if(!$is_agent){ echo '<option id="wplc_selected_agent_'. esc_html( $user->ID ) .'" em="' . md5(esc_html( $user->user_email )) . '" uid="' . esc_html( $user->ID ) . '" em2="' . esc_html( $user->user_email ) . '"  name="' . esc_html( $user->display_name ) . '" value="' . esc_html( $user->ID ) . '">' . esc_html( $user->display_name ) . ' ('.__('Author','wplivechat').')</option>'; }
	            }
	        ?>
	        </select>
	        <p><button class='button button-secondary' id='wplc_add_agent'><?php _e("Add Agent","wplivechat"); ?></button></p>
	    </li>
	</ul>
	</div>
	    
	                <hr/>
	                <p class="description"><?php _e("Should you wish to add a user that has a role less than 'Author', please go to the <a href='./users.php'>Users</a> page, select the relevant user, click Edit and scroll to the bottom of the page and enable the 'Chat Agent' checkbox.", "wplivechat"); ?></p>
	                <p class="description"><?php _e("If there are no chat agents online, the chat will show as offline", "wplivechat"); ?></p>
	<?php
	}

}

/* WPLC Social Icons Filter*/
add_filter("wplc_filter_chat_header_above","wplc_chat_social_div",5,2);
add_filter("wplc_filter_chat_4th_layer_below_input","wplc_chat_social_div",5,2);
function wplc_chat_social_div($msg, $wplc_setting){
	$acbc_settings = get_option("WPLC_ACBC_SETTINGS");
	$current_theme = isset($wplc_setting['wplc_newtheme']) ? $wplc_setting['wplc_newtheme'] : "";

	$top_offset = "";

	$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	if($wplc_pro_settings["wplc_ux_exp_rating"] === "0" && $current_theme === "theme-2"){
		$top_offset = "bottom:-4px !important;";
	}

    $msg .= "<div id='wplc_social_holder' ".($current_theme === "theme-2" ? "class='wplc_modern'" : "" )." style='display:none; $top_offset' >";
    if(isset($acbc_settings['wplc_social_fb']) && $acbc_settings['wplc_social_fb'] != ""){
        $msg .= "<a class='wplc-color-1' href=".urldecode($acbc_settings['wplc_social_fb'])." target='_blank'><i class='wplc_social_icon fa fa-facebook-square' id='wplc_social_fb' ></i></a>";
    }
    if(isset($acbc_settings['wplc_social_tw']) && $acbc_settings['wplc_social_tw'] != ""){
        $msg .= "<a class='wplc-color-1' href=".urldecode($acbc_settings['wplc_social_tw'])." target='_blank'><i class='wplc_social_icon fa fa-twitter-square' id='wplc_social_tw' ></i></a>";
    }
    $msg .= "</div>";
    return $msg;
}

/*Text Editor*/
add_filter("wplc_filter_chat_text_editor","nifty_text_edit_div",1,1);
function nifty_text_edit_div($msg){
	$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	if($wplc_pro_settings["wplc_ux_editor"] !== "0"){
	    $msg .= "<div id='nifty_text_editor_holder'>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-bold' id='nifty_tedit_b'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-italic' id='nifty_tedit_i'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-underline' id='nifty_tedit_u'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-strikethrough' id='nifty_tedit_strike'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-square' id='nifty_tedit_mark'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-subscript' id='nifty_tedit_sub'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-superscript' id='nifty_tedit_sup'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-link' id='nifty_tedit_link'></i>";
	    $msg .= "</div>";
    }
    return $msg;
}

/*Upload Div*/
add_filter("wplc_filter_chat_upload","nifty_file_upload_div",1,1);
function nifty_file_upload_div($msg){
	$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	if($wplc_pro_settings["wplc_ux_file_share"] !== "0"){
		$editor_enabled = $wplc_pro_settings["wplc_ux_exp_rating"] == "0" ? "bottom: 35px !important;" : "";
	    $msg .= "<div id='nifty_file_holder'>";
	    $msg .=   "<label for='nifty_file_input' id='nifty_select_file'><i class='nifty_attach_icon nifty_attach_open_icon fa fa-paperclip' id='nifty_attach' style='$editor_enabled' ></i></label>";
	    $msg .=   "<i class='nifty_attach_icon fa fa-circle-o-notch fa-spin' id='nifty_attach_uploading_icon' style='display:none; $editor_enabled' ></i>";
	    $msg .=   "<i class='nifty_attach_icon fa fa-check-circle' id='nifty_attach_success_icon' style='display:none; $editor_enabled' ></i>";
	    $msg .=   "<i class='nifty_attach_icon fa fa-minus-circle' id='nifty_attach_fail_icon' style='display:none; $editor_enabled'></i>";
	    $msg .=   "<input type='file' id='nifty_file_input' name='nifty_file_input' style='display:none'>";
	    $msg .= "</div>";
    }
    return $msg;
}

add_filter("wplc_filter_chat_header_above","nifty_chat_ratings_div",1,2);
add_filter("wplc_filter_chat_4th_layer_below_input","nifty_chat_ratings_div",1,2);
function nifty_chat_ratings_div($msg, $wplc_setting){ 
	$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	if($wplc_pro_settings["wplc_ux_exp_rating"] !== "0"){
		$msg .= "<div id='nifty_ratings_holder' style='display:none;'>";
		$msg .=   "<i class='nifty_rating_icon fa fa-thumbs-o-up' id='nifty_rating_pos' ></i>";
		$msg .=    " | ";
		$msg .=   "<i class='nifty_rating_icon fa fa-thumbs-o-down' id='nifty_rating_neg' ></i>";
		$msg .=   "<div id='nifty_ratings_form' style='display:none;' class='wplc-color-bg-1 wplc-color-1 wplc-color-border-1'>";
		$msg .=     "<input type='text' id='nifty_ratings_comment' placeholder='Comments...'>";
		$msg .=     "<button nifty-rating='' id='nifty_rating_button' class='wplc-color-bg-2 wplc-color-1'>Rate</button>";
		$msg .=   "</div>";
		$msg .=   "<i class='fa fa-spinner fa-spin' id='nifty_recording' style='display:none;'></i>";
		$msg .=   "<div id='nifty_rating_thanks' style='display:none;'>";
		$msg .=     "<p>Rating Recorded...</p>";
		$msg .=   "</div>";
		$msg .= "</div>";
    }
    return $msg;
    
}

/*Handles adding a rating*/
function nifty_record_rating($cid, $rating, $comment){
    global $wpdb;
    global $wplc_tblname_chat_ratings;
    
    //Cleanup here
    $cid = intval($cid);
    $rating = intval($rating);
    $comment = esc_attr($comment);

    if(nifty_chat_has_rating($cid)){ //Update
        $sql = "UPDATE $wplc_tblname_chat_ratings SET `aid` = '".wplc_get_chat_data($cid)->agent_id."', `rating` = '".$rating."', `comment` = '".$comment."', `timestamp` = '".date("Y-m-d H:i:s")."', `notified` = 0 WHERE `cid` = '$cid' LIMIT 1";
        $wpdb->query($sql);
        if ($wpdb->last_error) { 
            return false;  
        } else {
            return true;
        }
    }else{ //Insert
       $sql = "INSERT INTO $wplc_tblname_chat_ratings SET `cid` = '".$cid."', `aid` = '".wplc_get_chat_data($cid)->agent_id."', `rating` = '".$rating."', `comment` = '".$comment."', `timestamp` = '".date("Y-m-d H:i:s")."', `notified` = 0";
       $wpdb->query($sql);
        if ($wpdb->last_error) { 
            return false;  
        } else {
            return true;
        } 
    }
}

function nifty_chat_has_rating($cid){
    global $wpdb;
    global $wplc_tblname_chat_ratings;
    $sql ="SELECT `id` FROM $wplc_tblname_chat_ratings WHERE `cid` = '$cid'";
    $wpdb->query($sql);
    if($wpdb->num_rows){
        return true;
    } else {
        return false;
    }     
}

function nifty_get_rating_data($cid,$force = false){
    global $wpdb;
    global $wplc_tblname_chat_ratings;
    if ($force) {
    	$results = $wpdb->get_results("SELECT * FROM $wplc_tblname_chat_ratings WHERE `cid` = '$cid' LIMIT 1");
    } else { 
    	$results = $wpdb->get_results("SELECT * FROM $wplc_tblname_chat_ratings WHERE `cid` = '$cid' AND `notified` = 0 LIMIT 1");
    }
    if ($wpdb->num_rows) {
        foreach ($results as $result) {
        	$id = $result->id;
        	$wpdb->Query("UPDATE $wplc_tblname_chat_ratings SET `notified` = 1 WHERE `id` = ".$id." LIMIT 1");
    		return array("rating" => $result->rating, "comment" => $result->comment);
		}
    }else{
        return false;
    }
}

add_filter("wplc_filter_advanced_info","nifty_rating_advanced_info_control",1,3);
function nifty_rating_advanced_info_control($msg, $cid, $name){
	$rating = apply_filters("wplc_rating_data_filter","",$cid,$name);
	if ($rating) {

		$msg .= "<div class='admin_visitor_advanced_info admin_agent_rating'>
                	<strong>" . __("Experience Rating", "wplivechat") . "</strong>
                	<div class='rating " .(isset($rating['rating']) && $rating['rating'] == '1' ? "rating-good" : ($rating['rating'] == '0' ? "rating-bad" : "" ))."'>".(isset($rating['rating']) && $rating['rating'] == '1' ? "Satisfied" : ($rating['rating'] == '0' ? "Unsatisfied" : "No Rating" ))."</div>
                	<hr />
                	<div class='rating-comment'><div id='rating-comment-holder'>\"".(isset($rating['comment']) && $rating['comment'] != "undefined" ? $rating['comment'] : "No Comment...")."\"</div> - ".$name."</div>
            	</div>";
    } else{
    	//No Rating Provided
    	$msg .= "<div class='admin_visitor_advanced_info admin_agent_rating'>
                	<strong>" . __("Experience Rating", "wplivechat") . "</strong>
                	<div class='rating'>No Rating</div>
                	<hr />
                	<div class='rating-comment'><div id='rating-comment-holder'>\"No Comment...\"</div> - ".$name."</div>
            	</div>";
    }
	return $msg;
}


add_filter("wplc_rating_data_filter","wplc_filter_control_get_rating_data",10,3);
function wplc_filter_control_get_rating_data($msg,$cid,$name) {
	return nifty_get_rating_data($cid);
}
/* Gets an agents percentage based on filter
 * Filters:
 *    0 - All
 *    1 - 7 Days
 *    2 - 14 Days
 *    3 - 30 Days
 *    4 - 60 Days
 *    5 - 90 Days
*/
function nifty_get_rating_report($uid, $filter = 0){
    //Some snazzy code here
    global $wpdb;
    global $wplc_tblname_chat_ratings;
    
    $sql = "SELECT * FROM $wplc_tblname_chat_ratings WHERE `aid` = '$uid'"; 
    if($filter == 1){
        $sql = "SELECT * FROM $wplc_tblname_chat_ratings WHERE `aid` = '$uid' AND `timestamp` > DATE_SUB(NOW(), INTERVAL 7 DAY)"; 
    }else if($filter == 2){
        $sql = "SELECT * FROM $wplc_tblname_chat_ratings WHERE `aid` = '$uid' AND `timestamp` > DATE_SUB(NOW(), INTERVAL 14 DAY)"; 
    }else if($filter == 3){
        $sql = "SELECT * FROM $wplc_tblname_chat_ratings WHERE `aid` = '$uid' AND `timestamp` > DATE_SUB(NOW(), INTERVAL 30 DAY)";  
    }else if($filter == 4){
        $sql = "SELECT * FROM $wplc_tblname_chat_ratings WHERE `aid` = '$uid' AND `timestamp` > DATE_SUB(NOW(), INTERVAL 60 DAY)"; 
    }else if($filter == 5){
        $sql = "SELECT * FROM $wplc_tblname_chat_ratings WHERE `aid` = '$uid' AND `timestamp` > DATE_SUB(NOW(), INTERVAL 90 DAY)";  
    }

    $sql .= " ORDER BY `cid` DESC"; //Sort
     
    $total = 0;
    $pos = 0;
    $neg = 0;

    $data_array = array();
    
    $results =  $wpdb->get_results($sql);
    if($wpdb->num_rows){
        foreach ($results as $res) {
        	$data_array[$uid][$res->cid] = array("rating"  =>  $res->rating,
        								   "comment" =>  $res->comment,
        								   "time"    =>  $res->timestamp);
            if($res->rating  == "1"){
               $pos ++; //Count
            }else if($res->rating == "0"){
               $neg ++; //Count
            } 
            $total ++;
        }     

         $total = $total > 0 ? $total : 1; //Cannot devide by 0
		$perc = intval(($pos * 100) / $total);

		$data_array["percentage"]    = $perc;
		$data_array["total_ratings"] = $total;
		$data_array["bad_count"]     = $neg;
		$data_array["good_count"]    = $pos;

		return $data_array;
    } else {
    	return false;
    }
    
}

add_filter('wplc_reporting_tabs', 'wplc_reporting_tabs_filter_experience_ratings_control', 10, 1);
function wplc_reporting_tabs_filter_experience_ratings_control($tabs_array){
	$tabs_array['ux_ratings'] = __("User Experience Ratings", "wplivechat");
	return $tabs_array;
}


add_filter('wplc_reporting_tab_content', 'wplc_reporting_tab_content_filter_experience_ratings_control', 10, 1);
function wplc_reporting_tab_content_filter_experience_ratings_control($tabs_array){
	$ratings = "<h3>".__("Agent Statistics", "wplivechat")."</h3>";
    
    $user_array = get_users(array(
    	'meta_key' => 'wplc_ma_agent',
    ));

    $ratings .= "<style>";
	$ratings .= ".wplc_agent_grav_report { display:inline-block; }";
	$ratings .= ".wplc_agent_card_details { display:inline-block; margin-left: 5px;}";
	$ratings .= ".wplc_agent_card { width:100%; }";
	$ratings .= ".wplc_agent_container {
    				width: 30%;
    				border: 1px solid lightgray;
    				padding: 5px;
    				border-radius: 2px;
    				box-shadow: 1px 1px 2px 0px #999;
    				-webkit-box-shadow: 1px 1px 2px 0px #999;
    				-moz-box-shadow: 1px 1px 2px 0px #999;
    				-o-box-shadow: 1px 1px 2px 0px #999;
    				display: inline-block;
    				margin-right: 5px;
    				vertical-align: top;

				}";
	$ratings .= ".wplc_agent_data {
    				max-height: 200px;
    				overflow-y: auto;
    				padding: 5px;
    				border: 1px lightgrey solid;
				}";
    $ratings .= "</style>";

    

    if ($user_array) {
        foreach ($user_array as $user) {
        	$ratings .= "<div class='wplc_agent_container'>";

        	$rating_stats = nifty_get_rating_report($user->ID);

		    $ratings .= "<div class='wplc_agent_card'>";
		    $ratings .= 	"<img class='wplc_agent_grav_report' src=\"//www.gravatar.com/avatar/" . md5($user->user_email) . "?s=80&d=mm\" />";
		    $ratings .= 	"<div class='wplc_agent_card_details'>";
		    $ratings .= 		"<strong>" . $user->display_name . "</strong><br>";
		    $ratings .= 		"<small>" . $user->user_email . "</small><br>";
		    $ratings .= 		"<hr>";
		    $ratings .= 		"<small><strong>".__("Satisfaction Rating", "wplivechat").":</strong> " . (is_bool($rating_stats) &&  $rating_stats == false ? "--" : $rating_stats['percentage'] ). "%</small><br>";
		    $ratings .= 		"<small><strong>".__("Rating Count", "wplivechat").":</strong> " . (is_bool($rating_stats) &&  $rating_stats == false ? "0" : $rating_stats['total_ratings'])." (".__("Good","wplivechat").": ".(is_bool($rating_stats) &&  $rating_stats == false ? "0" : $rating_stats['good_count']). " || ".__("Bad","wplivechat").": ".(is_bool($rating_stats) &&  $rating_stats == false ? "0" : $rating_stats['bad_count']). ")</small>";
		    $ratings .= 	"</div>";
    		$ratings .= "</div>";
    		
    		$ratings .= "<div class='wplc_agent_data'>";
    		
    		if(is_bool($rating_stats) &&  $rating_stats == false){
				$ratings .= "<div style='width:90%;display: inline-block; min-height: 30px;'>";
				$ratings .= "<i>".__("No Ratings for this agent", "wplivechat")."</i>";
				$ratings .= "</div>"; 
    		}else{
    			$ratings_for_agent = $rating_stats[$user->ID];
	    		foreach ($ratings_for_agent as $cid => $rate) {
	    			$ratings .= "<div style='width:90%;display: inline-block; min-height: 30px;'>";
	    			$ratings .= $cid . " - <strong style='".(intval($rate['rating']) == 1 ? "color:#439134;": "color:#ac1d1d;")."'>".(intval($rate['rating']) == 1 ? __("Good", "wplivechat") : __("Bad", "wplivechat") )."</strong>";
	    			$ratings .= " - <i style='width:auto;'>\"" . $rate['comment'] . "\"</i>";
	    			$ratings .= "</div>"; 
	    			$ratings .= " <a style='float:right' class='button' href='?page=wplivechat-menu&action=history&cid=".$cid."' target='_blank'><i class='fa fa-eye'></i></a>";
	    			   			
	    		}
    		}
    		
    		$ratings .= "</div>";
    		$ratings .= "</div>";
		}
	}
	

	$tabs_array['ux_ratings'] = $ratings;
	return $tabs_array;
}

add_action('admin_enqueue_scripts', 'wplc_reporting_scripts');
function wplc_reporting_scripts(){
    if( isset( $_GET['page'] ) && $_GET['page'] == 'wplc-pro-reporting' ){
        $statistics = json_encode( return_statistics() );
        wp_register_script('wplc-google-charts', '//www.gstatic.com/charts/loader.js', array('jquery'));
        wp_enqueue_script('wplc-google-charts');
        
        wp_register_style('wplc-ui-style-stats', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('wplc-ui-style-stats');
        wp_register_script('wplc-statistics', plugins_url('/js/reporting.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-tabs'));
        wp_localize_script('wplc-statistics', 'wplc_reporting_statistics', $statistics);
        wp_enqueue_script('wplc-statistics');
    }
}
function wplc_pro_reporting_page(){
    $stats = return_statistics();
    $tabs = "";
    $styling_reporting = ".ui-tabs-vertical {  }
						  .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; max-width: 20%; min-width: 190px; }
						  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%;border:none; margin: 0 -1px .2em 0; }
						  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
						  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; }
						  .ui-tabs-vertical .ui-tabs-panel { float: left;  min-width: 67%; max-width: 67%;}
						  textarea, input[type='text'], input[type='email'], input[type='password']{ width: 100% !important; }
						  .ui-tabs-anchor { width: 80%; }
						  .ui-widget-header { border: none; background: none; }
						  .ui-tabs-anchor:focus { box-shadow: none !important; }";

	$tabs .= "<style>" . $styling_reporting . "</style>";

    $tabs .= "<div clas='wrap'><h2>".__('WP Live Chat Support Reporting', 'wp-livechat')."</h2><div id='reporting_tabs'>";
    $tabs .= "<ul>";
    $tab = array(
        'overview' => __('Overview', 'wp-livechat'),
        'popular_pages' => __('Popular Pages', 'wp-livechat')
    );
    $tab = apply_filters('wplc_reporting_tabs', $tab);
    
    foreach( $tab as $key => $val ){
        $tabs .= "<li><a href='#$key'>$val</a></li>";
    }
    $tabs .= "</ul>";
    
    if( isset( $stats['individual_urls_counted'] ) ){
        $popular_pages_list = "<ul>";
        $urls = $stats['individual_urls_counted'];
        foreach( $urls as $key => $val ){
            $popular_pages_list .= "<li>$key ($val)</li>";
        }
        $popular_pages_list .= "</ul>";
    }
    $overview = "";
    $overview .= "<div style='width: 33%; display: inline-block; vertical-align: top; text-align: center;'><h2>".__('Total Agents', 'wp-livechat')."</h2><p>".$stats['total_agents_counted']."</p><small>".__('Total number of agents that used the live chat', 'wp-livechat')."</small></div>";
    $overview .= "<div style='width: 33%; display: inline-block; vertical-align: top; text-align: center;'><h2>".__('Total Chats', 'wp-livechat')."</h2><p>".$stats['total_chats']."</p><small>".__('Total number of chats received', 'wp-livechat')."</small></div>";
    $overview .= "<div style='width: 33%; display: inline-block; vertical-align: top; text-align: center;'><h2>".__('Total URLs', 'wp-livechat')."</h2><p>".$stats['total_urls_counted']."</p><small>".__('Total number of URLs a chat was initiated on', 'wp-livechat')."</small></div>";
    $overview .= '<h2>'.__('Chats per day', 'wp-livechat').'</h2><div id="columnchart_material" style="width: 100%; height: 350px;"></div>';
    $popular_pages = "<h2>".__('Popular pages a chat was initiated on', 'wp-livechat')."</h2>";
    $popular_pages .= "<div style='width: 50%; display: inline-block; vertical-align: top;'><div id='popular_pages_graph' style='width: 100%; height: 300px;'></div></div>";
    $popular_pages .= "<div style='width: 50%; display: inline-block; vertical-align: top;'>$popular_pages_list</div>";
    $tab_content = array(
        'overview' => $overview,
        'popular_pages' => $popular_pages,
    );
    $tab_content = apply_filters('wplc_reporting_tab_content', $tab_content);
    foreach( $tab_content as $key => $val ){
        $tabs .= "<div id='$key'>$val</div>";
    }
    $tabs .= "</div></div>";
    
    echo $tabs;
    
}
function return_statistics(){
    global $wpdb;
    global $wplc_tblname_chats;
    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `agent_id` <> 0 ORDER BY `timestamp` DESC LIMIT 90";
    $results = $wpdb->get_results( $sql );
    $popular_user_agent = array();
    $chats_on_days = array();
    $popular_url = array();
    $chat_durations = array();
    $popular_chat_agent = array();
    $agent_data = array();
    foreach( $results as $result ){
        $ip_data = maybe_unserialize( $result->ip );
        $popular_chat_agent[] = $result->agent_id;
        $popular_user_agent[] = $ip_data['user_agent'];
        $chats_on_days[] = date('Y-m-d', strtotime( $result->timestamp ) );
        $popular_url[] = $result->url;
    }
    /* Agent Data */
    
    $agent_totals = array_count_values($popular_chat_agent );   
    arsort($agent_totals);
    $total_agent_count = count( $agent_totals );
    /* User Agent Data */   
    $user_agent_totals = array_count_values( $popular_user_agent );
    arsort($user_agent_totals);
    $total_user_agent = count( $user_agent_totals );
    /* Daily Chat Totals */
    $daily_chat_totals = array_count_values( $chats_on_days );
    // arsort($daily_chat_totals);
    $total_chats = count( $daily_chat_totals );
    /* URL Data */
    $popular_urls = array_count_values( $popular_url );
    arsort($popular_urls);
    $total_urls = count( $popular_urls );
    if( $agent_totals ){
        foreach( $agent_totals as $key => $val ){
            $user = get_user_by( 'id', intval( $key ) );
            if( $user ){
                $display_name = $user->data->display_name;
            } else {
                $display_name = '';
            }
            $agent_data[intval($key)] = $display_name;
        }
    }
    return array(
        'total_agents_counted' => $total_agent_count,
        'individual_agents_count' => $agent_data,
        'total_user_agents_counted' => $total_user_agent,
        'individual_user_agent_count' => $user_agent_totals,
        'daily_chat_totals' => $daily_chat_totals,
        'total_chats' => $total_chats,
        'total_urls_counted' => $total_urls,
        'individual_urls_counted' => $popular_urls,
        'other_data' => apply_filters('wplc_additional_statistic_data', '')
    );
}
function return_stats_strings(){
    return array(
        'url' => __('URL', 'wp-livechat'),
        'count' => __('Count', 'wp-livechat')
    );
}




add_filter("wplc_filter_wav_file","wplc_pro_filter_control_wav_file",10,1);
function wplc_pro_filter_control_wav_file($wplc_wav_file) {
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    if (isset($wplc_pro_settings['wplc_ringtone'])) { return $wplc_pro_settings['wplc_ringtone']; }
    else { return $wplc_wav_file; }


}

add_action("wplc_advanced_settings_settings","wplc_pro_hook_control_advanced_settings_settings",10);
function wplc_pro_hook_control_advanced_settings_settings() {
	$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
	echo "<tr>";
	echo "	<td>".__("Disable initiate chat feature:","wplivechat")." <i class=\"fa fa-question-circle wplc_light_grey wplc_settings_tooltip\" title=\"".__("This will substantially improve performance. If you are experiencing performance issues on your site, you should disable the initiate chat feature and only enable it when you need it.","wplivechat")."\"></i></td>";
	if (isset($wplc_pro_settings['wplc_disable_initiate_chat'])  && $wplc_pro_settings['wplc_disable_initiate_chat'] == '1' ) { $is_checked = "checked"; } else { $is_checked = ""; }

	echo "	<td><input type='checkbox' name='wplc_disable_initiate_chat' value='1' ".$is_checked."/></td>";
	echo "</tr>";
}






function wplc_random_quote() {
	$rand = rand(0,7);

	$array = array(
		0 => "&ldquo;The true entrepreneur is a doer, not a dreamer.&rdquo; – Unknown",
		1 => "&ldquo;Please think about your legacy, because you’re writing it every day.&rdquo; – Gary Vaynerchuck",
		2 => "&ldquo;A man should never neglect his family for business.&rdquo; – Walt Disney",
		3 => "&ldquo;Every accomplishment starts with a decision to try.&rdquo; – Unknown",
		4 => "&ldquo;There’s no shortage of remarkable ideas, what’s missing is the will to execute them.&rdquo; – Seth Godin",
		5 => "&ldquo;You only have to do a very few things right in your life so long as you don’t do too many things wrong.&rdquo; – Warren Buffett",
		6 => "&ldquo;One finds limits by pushing them.&rdquo; – Herbert Simon",
		7 => "&ldquo;Wishes cost nothing unless you want them to come true&rdquo; - Steve Jobs",
		8 => "&ldquo;Hire character. Train skill.&rdquo; – Peter Schutz",
		9 => "&ldquo;A calm sea does not make a skilled sailor.&rdquo; – Unknown",
		10 => "&ldquo;Leadership is doing what is right when no one is watching.&rdquo; – George Van Valkenburg",
		11 => "&ldquo;Genius is one percent inspiration and ninety–nine percent perspiration.&rdquo; – Thomas A. Edison",
		12 => "&ldquo;Are you a serial idea–starting person? The goal is to be an idea–shipping person.&rdquo; – Seth Godin",
		13 => "&ldquo;To win without risk is to triumph without glory.&rdquo; – Pierre Corneille",
		14 => "&ldquo;The golden rule for every business man is this: Put yourself in your customer’s place.&rdquo; – Orison Swett Marden"

	);
	return $array[$rand];
}

function wplc_enqueue_admin_styles(){
	wp_enqueue_style('wplc-admin-pro-styles', plugins_url('/css/wplc_styles_admin_pro.css', __FILE__));
}

add_filter("wplc_filter_admin_from","wplc_filter_control_admin_from",10,3);
function wplc_filter_control_admin_from($content, $cid, $chat_data = false) {
    $acbc_settings = get_option("WPLC_ACBC_SETTINGS");

    if (!$chat_data) {
    	$chat_data = wplc_get_chat_data($cid,__LINE__);
    }
    if (isset($chat_data->agent_id)) {
	    if(isset($acbc_settings)){
	    	if(isset($acbc_settings['wplc_use_wp_name'])){
	    		if(intval($acbc_settings['wplc_use_wp_name']) == 1){
	    			$content = get_user_by("id", $chat_data->agent_id)->display_name;
	    		}
	    	}
	    }
	}
    return $content;
}

add_action("wplc_add_js_admin_chat_area", "wplc_add_js_admin_chat_area_control", 10, 1);
function wplc_add_js_admin_chat_area_control($cid){
	$acbc_settings = get_option("WPLC_ACBC_SETTINGS");
	$chat_data = wplc_get_chat_data($cid,__LINE__);
	if(isset($acbc_settings)){
    	if(isset($acbc_settings['wplc_use_wp_name']) && intval($acbc_settings['wplc_use_wp_name']) == 1){
				?>
				<script>
					var wplc_name_override = "<?php echo get_user_by('id', $chat_data->agent_id)->display_name; ?>";
				</script>
				<?php
		} else if(isset($acbc_settings['wplc_chat_name'])){
				?>
				<script>
					var wplc_name_override = "<?php echo stripslashes($acbc_settings['wplc_chat_name']) ?>";
				</script>
				<?php
		}
	}
}

register_activation_hook( __FILE__, 'wplc_auto_responder_activate' );
function wplc_auto_responder_activate(){

	$options = get_option( "WPLC_AUTO_RESPONDER_SETTINGS" );

	if( !is_array( $options ) ){

		$wplc_data['wplc_ar_from_name'] = get_bloginfo( 'name' );
	    $wplc_data['wplc_ar_from_email'] = get_bloginfo( 'admin_email' );
	    $wplc_data['wplc_ar_subject'] = __("Thank you for inquiry. We will get back to you shortly", "wplivechat" );
	    $wplc_data['wplc_ar_body'] = "
	    <p>Hi {wplc-user-name}</p>
	    <p>Thank you for getting in touch with us.</p>
	    <p>Your email has been received. We will get back to you shortly.</p>
	    ";

	    update_option( "WPLC_AUTO_RESPONDER_SETTINGS", $wplc_data );

	}
    
}

add_action("wplc_hook_offline_message", "wplc_offline_message_autoresponder");
function wplc_offline_message_autoresponder( $data ){
	
	$wplc_user_name = $data['name'];
	$wplc_user_email = $data['email'];

	$wplc_settings = get_option("WPLC_AUTO_RESPONDER_SETTINGS");	

	if( isset( $wplc_settings['wplc_ar_enable'] ) && $wplc_settings['wplc_ar_enable'] == '1' ) { $wplc_ar_enable = $wplc_settings['wplc_ar_enable']; } else { $wplc_ar_enable = FALSE; }
	if( isset( $wplc_settings['wplc_ar_from_name'] ) ) { $wplc_ar_from_name = $wplc_settings['wplc_ar_from_name']; } else { $wplc_ar_from_name = ""; }
	if( isset( $wplc_settings['wplc_ar_from_email'] ) ) { $wplc_ar_from_email = $wplc_settings['wplc_ar_from_email']; } else { $wplc_ar_from_email = ""; }
	if( isset( $wplc_settings['wplc_ar_subject'] ) ) { $wplc_ar_subject = $wplc_settings['wplc_ar_subject']; } else { $wplc_ar_subject = ""; }
	if( isset( $wplc_settings['wplc_ar_body'] ) ) { $wplc_ar_body = $wplc_settings['wplc_ar_body']; } else { $wplc_ar_body = ""; }
	
	if( $wplc_ar_enable ){
		
		preg_match_all('/{(.*?)}/', $wplc_ar_body, $matches);	

	    if (isset($matches[1])) {
	    	
	        foreach ($matches[1] as $key => $match) {

	            if ($wplc_ar_body) {
	            	
	            	if( $matches[1][$key] == 'wplc-user-name' ){
					
						$wplc_ar_body = str_replace( $matches[0][$key],$wplc_user_name,$wplc_ar_body );
	        		
	        		} else if ( $matches[1][$key] == 'wplc-email-address' ){
	        		
	        			$wplc_ar_body = str_replace( $matches[0][$key],$wplc_user_email,$wplc_ar_body );
	        		
	        		}
	            
	            }
	            
	        }
	                
	    }	    
	    /**
	     * Using contents of wplcmail function as we need additional functionality for this	     
	     */  	   
	    if(get_option("wplc_mail_type") == "wp_mail" || !get_option('wplc_mail_type')){	    	
	        $headers[] = 'Content-type: text/html';
	        $headers[] = 'Reply-To: '.$wplc_ar_from_name.'<'.$wplc_ar_from_email.'>';	                         
            $overbody = apply_filters("wplc_filter_mail_body",$wplc_ar_subject, htmlspecialchars_decode(stripslashes( $wplc_ar_body ) ) );            
            if (!wp_mail($wplc_user_email, $wplc_ar_subject, $overbody, $headers)) {
                $handle = fopen("wp_livechat_error_log.txt", 'a');
                $error = date("Y-m-d H:i:s") . " WP-Mail Failed to send \n";
                @fwrite($handle, $error);
            }
	        return;
	    } else {

            global $phpmailer;
     
            // (Re)create it, if it's gone missing
            if ( ! ( $phpmailer instanceof PHPMailer ) ) {
                require_once ABSPATH . WPINC . '/class-phpmailer.php';
                require_once ABSPATH . WPINC . '/class-smtp.php';
                $mail = new PHPMailer( true );
            }


	        $host = get_option('wplc_mail_host');
	        $port = get_option('wplc_mail_port');
	        $username = get_option("wplc_mail_username");	                
	        $password = get_option("wplc_mail_password");	        
	        if($host && $port && $username && $password){	        	

	            $mail->isSMTP();
	            //Enable SMTP debugging
	            // 0 = off (for production use)
	            // 1 = client messages
	            // 2 = client and server messages
	            $mail->SMTPDebug = 0;
	            //Ask for HTML-friendly debug output
	            $mail->Debugoutput = 'html';
	            //Set the hostname of the mail server
	            $mail->Host = $host;
	            //Set the SMTP port number - likely to be 25, 26, 465 or 587
	            $mail->Port = $port;
	            //Set the encryption system to use - ssl (deprecated) or tls
	            if($port == "587"){
	                $mail->SMTPSecure = 'tls';
	            } else if($port == "465"){
	                $mail->SMTPSecure = 'ssl';
	            }
	            //Whether to use SMTP authentication
	            $mail->SMTPAuth = true;
	            //Username to use for SMTP authentication
	            $mail->Username = $username;
	            //Password to use for SMTP authentication
	            $mail->Password = $password;
	            //Set who the message is to be sent from
	            $mail->setFrom($wplc_ar_from_email, $wplc_ar_from_name);
	            //Set who the message is to be sent to
                $mail->addAddress($wplc_user_email);	            
	            //Set the subject line
	            $mail->Subject = $wplc_ar_subject;
	            //HTML will render
	            $mail->isHTML(true); 
	            //Read an HTML message body from an external file, convert referenced images to embedded,
	            //convert HTML into a basic plain-text alternative body
	            $body = apply_filters("wplc_filter_mail_body",$wplc_ar_subject, htmlspecialchars_decode(stripslashes( $wplc_ar_body ) ) );
	            $mail->msgHTML($body);
	            //Replace the plain text body with one created manually
	            $mail->AltBody = $msg;	            
	            //send the message, check for errors
	            if (!$mail->send()) {
	                $handle = fopen("wp_livechat_error_log.txt", 'a');
	                $error = date("Y-m-d H:i:s")." ".$mail->ErrorInfo." \n";
	                @fwrite($handle, $error); 
	            }
	            return;
	        }
	    }
	}  
    
}

add_action( 'wplc_hook_head', 'wplc_auto_responder_settings' );

function wplc_auto_responder_settings(){

	if (isset($_POST['wplc_save_settings'])) {
		$wplc_data = array();
		if (isset($_POST['wplc_ar_enable'])) { $wplc_data['wplc_ar_enable'] = esc_attr($_POST['wplc_ar_enable']); }
        if (isset($_POST['wplc_ar_from_name'])) { $wplc_data['wplc_ar_from_name'] = esc_attr($_POST['wplc_ar_from_name']); }
        if (isset($_POST['wplc_ar_from_email'])) { $wplc_data['wplc_ar_from_email'] = esc_attr($_POST['wplc_ar_from_email']); }
        if (isset($_POST['wplc_ar_subject'])) { $wplc_data['wplc_ar_subject'] = esc_attr($_POST['wplc_ar_subject']); }
        if (isset($_POST['wplc_ar_body'])) { $wplc_data['wplc_ar_body'] = esc_attr($_POST['wplc_ar_body']); }

        update_option( "WPLC_AUTO_RESPONDER_SETTINGS", $wplc_data );

	}

}

add_action( "wplc_hook_admin_settings_offline_messages_settings_after", "wplc_auto_responder_settings_pro" );

function wplc_auto_responder_settings_pro(){ 
	$wplc_settings = get_option( "WPLC_AUTO_RESPONDER_SETTINGS" );
	?>
	<table class='form-table wp-list-table widefat fixed striped pages'>
	    <tr>
	        <td width="300" valign="top"><?php _e("Enable an Auto Responder", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Send your visitors an email as soon as they send you an offline message", "wplivechat") ?>"></i></td>
	        <td>
	            <input id="wplc_ar_enable" name="wplc_ar_enable" type="checkbox" value="1" <?php if( isset( $wplc_settings['wplc_ar_enable'] ) ) { echo "checked"; } ?> /> <br />
	        </td>
	    </tr>
	    <tr>
	        <td width="300" valign="top"><?php _e("Auto Responder 'From' Name", "wplivechat") ?>: </td>
	        <td>
	            <input type="text" name="wplc_ar_from_name" id="wplc_ar_from_name" class="regular-text" value="<?php if( isset( $wplc_settings['wplc_ar_from_name'] ) ) { echo $wplc_settings['wplc_ar_from_name']; } ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td width="300" valign="top"><?php _e("Auto Responder 'From' Email Address", "wplivechat") ?>: </td>
	        <td>
	            <input type="text" name="wplc_ar_from_email" id="wplc_ar_from_email" class="regular-text" value="<?php if( isset( $wplc_settings['wplc_ar_from_email'] ) ) { echo $wplc_settings['wplc_ar_from_email']; } ?>" /> 
	        </td>
	    </tr>
	    <tr>
	        <td width="300" valign="top"><?php _e("Auto Responder Subject Line", "wplivechat") ?>: </td>
	        <td>
	            <input type="text" name="wplc_ar_subject" id="wplc_ar_subject" class="regular-text" value="<?php if( isset( $wplc_settings['wplc_ar_subject'] ) ) { echo $wplc_settings['wplc_ar_subject']; } ?>" />
	        </td>
	    </tr>
	    <tr>
	        <td width="300" valign="top"><?php _e("Auto Responder Body", "wplivechat") ?>: <br/></td>
	        <td>
	            <textarea name="wplc_ar_body" id="wplc_ar_body" rows="6" style="width:50%;"><?php if( isset( $wplc_settings['wplc_ar_body'] ) ) { echo stripslashes( $wplc_settings['wplc_ar_body'] ); } ?></textarea>
	            <p class="description"><small><?php _e("HTML and the following shortcodes can be used", "wplivechat"); ?>: <?php _e("User's name", "wplivechat"); ?>: {wplc-user-name} <?php _e("User's email address", "wplivechat"); ?>: {wplc-email-address}</small></p>
	        </td>
	    </tr>
    </table>
<?php }

add_filter( "wplc_filter_setting_tabs", "wplc_business_hours_tab" );

function wplc_business_hours_tab( $array ){
	
	$array['business-hours'] = array(
		'href' 	=> '#wplc-business-hours',
		'icon' 	=> 'fa fa-clock-o',
		'label' => __("Business Hours", "wplivechat")
	);

	return $array;
}

add_action( "wplc_hook_settings_page_more_tabs", "wplc_business_hours_tab_content" );

function wplc_business_hours_tab_content(){

	$wplc_bh_settings = get_option( "wplc_bh_settings" );

	$content = "";

	$content .= "<div id='wplc-business-hours'>";

	$content .= "<h2>".__("Business Hours", "wplivechat")."</h2>";
	$content .= "<table class='form-table wp-list-table widefat fixed striped pages' >";

	$content .= "<tr>";
	$content .= "<td width='300'>".__("Enable Business Hours", "wplivechat")."</td>";
	if( isset( $wplc_bh_settings['enabled'] ) && $wplc_bh_settings['enabled'] === true ) { $checked = 'checked'; } else { $checked = ''; }
	$content .= "<td><input type='checkbox' name='wplc_bh_enable' id='wplc_bh_enable' value='1' $checked /></td>";
	$content .= "</tr>";

	$content .= "<tr>";
	$content .= "<td width='300'>".__("Display Interval", "wplivechat")."</td>";
	$content .= "<td>";
	$content .= "<select name='wplc_bh_interval' id='wplc_bh_interval'>";
	$wplc_intervals = array(
		'0' => __("Daily", "wplivechat"),
		'1' => __("Week Days", "wplivechat"),
		'2' => __("Weekends", "wplivechat")
	);
	$wplc_intervals = apply_filters( "wplc_bg_intervals_array", $wplc_intervals );
	if( $wplc_intervals ){

		foreach( $wplc_intervals as $key => $val ){
			if( isset( $wplc_bh_settings['interval'] ) && $wplc_bh_settings['interval'] == $key ){ $sel = 'selected'; } else { $sel = ''; }
			$content .= "<option value='$key' $sel>$val</option>";
		}

	}
	$content .= "</select><br/>";

	$wplc_times_array = wplc_return_times_array();

	$content .= __(" Between ", "wplivechat")."<select name='wplc_bh_hours_start' id='wplc_bh_hours_start'>";
	if( $wplc_times_array ){					
		$hours = $wplc_times_array['hours'];		
		foreach( $hours as $hour ){
			if( (isset( $wplc_bh_settings['start'] ) ) && ( isset( $wplc_bh_settings['start']['h'] ) && $wplc_bh_settings['start']['h'] == $hour ) ){ $sel = 'selected'; } else { $sel = ''; }
			$content .= "<option value='$hour' $sel>$hour</option>";
		}
	}
	$content .= "</select>:";
	$content .= "<select name='wplc_bh_minutes_start' id='wplc_bh_minutes_start'>";
	if( $wplc_times_array ){					
		$minutes = $wplc_times_array['minutes'];		
		foreach( $minutes as $minute ){
			if( (isset( $wplc_bh_settings['start'] ) ) && ( isset( $wplc_bh_settings['start']['m'] ) && $wplc_bh_settings['start']['m'] == $minute ) ){ $sel = 'selected'; } else { $sel = ''; }
			$content .= "<option value='$minute' $sel>$minute</option>";
		}
	}
	$content .= "</select>".__(" and ", "wplivechat");
	$content .= "<select name='wplc_bh_hours_end' id='wplc_bh_hours_end'>";
	if( $wplc_times_array ){					
		$hours = $wplc_times_array['hours'];		
		foreach( $hours as $hour ){
			if( (isset( $wplc_bh_settings['end'] ) ) && ( isset( $wplc_bh_settings['end']['h'] ) && $wplc_bh_settings['end']['h'] == $hour ) ){ $sel = 'selected'; } else { $sel = ''; }
			$content .= "<option value='$hour' $sel>$hour</option>";
		}
	}
	$content .= "</select>";
	$content .= "<select name='wplc_bh_minutes_end' id='wplc_bh_minutes_end'>";
	if( $wplc_times_array ){					
		$minutes = $wplc_times_array['minutes'];		
		foreach( $minutes as $minute ){
			if( (isset( $wplc_bh_settings['end'] ) ) && ( isset( $wplc_bh_settings['end']['m'] ) && $wplc_bh_settings['end']['m'] == $minute ) ){ $sel = 'selected'; } else { $sel = ''; }
			$content .= "<option value='$minute' $sel>$minute</option>";
		}
	}
	$content .= "</select>";
	$content .= "</td>";
	$content .= "</tr>";

	$content .= "<tr>";
	$content .= "<td width='300'>".__("Current Site Time", "wplivechat")."</td>";
	$content .= "<td>";
	$content .= $current_time = current_time('mysql');
	$content .= "</td>";
	$content .= "</tr>";

	$content .= "</table>";
	$content .= "</div>";

	echo $content;

}

if ( ! function_exists( 'wplc_hook_main_settings_quick_response' ) ) {
	add_action( 'wplc_hook_admin_settings_main_settings_after', 'wplc_hook_main_settings_quick_response', 3 );
	function wplc_hook_main_settings_quick_response() {
		$wplc_pro_settings = get_option( 'WPLC_PRO_SETTINGS' );
		$wplc_quick_response_order_by = isset( $wplc_pro_settings['wplc_quick_response_orderby'] ) ? esc_attr( $wplc_pro_settings['wplc_quick_response_orderby'] ) : 'title';
		$wplc_quick_response_order = isset( $wplc_pro_settings['wplc_quick_response_order'] ) ? esc_attr( $wplc_pro_settings['wplc_quick_response_order'] ) : 'DESC'; ?>

        <h4><?php _e( "Quick Response", "wplivechat" ); ?></h4>
        <table class="wp-list-table widefat fixed striped pages">
            <tbody>
            <tr>
                <td width="300" valign="top">
                    <label for="wplc_quick_response_orderby"><?php _e( "Order by", "wplivechat" ); ?></label>
                </td>
                <td valign="top">
                    <select id='wplc_quick_response_orderby' name='wplc_quick_response_orderby'>
                        <option value="title" <?php selected( $wplc_quick_response_order_by, 'title' ) ?>><?php _e( "Title", "wplivechat" ); ?></option>
                        <option value="date" <?php selected( $wplc_quick_response_order_by, 'date' ) ?>><?php _e( "Date", "wplivechat" ); ?></option>
                        <option value="number" <?php selected( $wplc_quick_response_order_by, 'number' ) ?>><?php _e( "Number", "wplivechat" ); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="300" valign="top">
                    <label for="wplc_quick_response_order"><?php _e( "Order", "wplivechat" ); ?></label>
                </td>
                <td valign="top">
                    <select id='wplc_quick_response_order' name='wplc_quick_response_order'>
                        <option value="DESC" <?php selected( $wplc_quick_response_order, 'DESC' ) ?>><?php _e( "Descending", "wplivechat" ); ?></option>
                        <option value="ASC" <?php selected( $wplc_quick_response_order, 'ASC' ) ?>><?php _e( "Ascending", "wplivechat" ); ?></option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
		<?php
	}
}

if ( ! function_exists( 'wplc_quick_response_save_settings' ) ) {
	add_action( 'wplc_hook_admin_settings_save', 'wplc_quick_response_save_settings' );
	function wplc_quick_response_save_settings() {
		if ( isset( $_POST['wplc_save_settings'] ) ) {
			$wplc_pro_settings = get_option( 'WPLC_PRO_SETTINGS' );
			$wplc_pro_settings['wplc_quick_response_orderby'] = isset( $_POST['wplc_quick_response_orderby'] ) ? esc_attr( $_POST['wplc_quick_response_orderby'] ) : 'date';
			$wplc_pro_settings['wplc_quick_response_order'] = isset( $_POST['wplc_quick_response_order'] ) ? esc_attr( $_POST['wplc_quick_response_order'] ) : 'DESC';

			update_option( 'WPLC_PRO_SETTINGS', $wplc_pro_settings );
		}
	}
}

function wplc_return_times_array(){
	$hours = array();
	for( $i = 0; $i <= 23; $i++){
		$hours[] = sprintf('%02d', $i );
	}
	$minutes = array();	
	for( $i = 0; $i <= 59; $i++){
		$minutes[] = sprintf('%02d', $i );
	}
	$time = array(
		'hours' 	=> $hours,
		'minutes' 	=> $minutes
	);
	return $time;
}

add_action( "wplc_hook_head", "wplc_business_hours_settings_save" );

function wplc_business_hours_settings_save(){

	if( isset( $_POST['wplc_save_settings'] ) ){

		if( isset( $_POST['wplc_bh_enable'] ) && $_POST['wplc_bh_enable'] == '1' ){ $wplc_bh_enabled = true; } else { $wplc_bh_enabled = false; }
		if( isset( $_POST['wplc_bh_interval'] ) ){ $wplc_bh_interval = sanitize_text_field( $_POST['wplc_bh_interval'] ); } else { $wplc_bh_interval = '0'; }

		if( isset( $_POST['wplc_bh_hours_start'] ) ){ $wplc_bh_hours_start = sanitize_text_field( $_POST['wplc_bh_hours_start'] ); } else { $wplc_bh_hours_start = ''; }
		if( isset( $_POST['wplc_bh_minutes_start'] ) ){ $wplc_bh_minutes_start = sanitize_text_field( $_POST['wplc_bh_minutes_start'] ); } else { $wplc_bh_minutes_start = ''; }

		if( isset( $_POST['wplc_bh_hours_end'] ) ){ $wplc_bh_hours_end = sanitize_text_field( $_POST['wplc_bh_hours_end'] ); } else { $wplc_bh_hours_end = ''; }
		if( isset( $_POST['wplc_bh_minutes_end'] ) ){ $wplc_bh_minutes_end = sanitize_text_field( $_POST['wplc_bh_minutes_end'] ); } else { $wplc_bh_minutes_end = ''; }


		$wplc_bh_settings = array(
			'enabled' 	=> $wplc_bh_enabled,
			'interval' 	=> $wplc_bh_interval,
			'start'		=> array( 'h' => $wplc_bh_hours_start, 'm' => $wplc_bh_minutes_start ),
			'end'		=> array( 'h' => $wplc_bh_hours_end, 'm' => $wplc_bh_minutes_end ),
		);

		update_option( "wplc_bh_settings", $wplc_bh_settings );

	}

}

function wplc_check_business_hours() {
	$business_hours_enabled = true;
	$wplc_bh_settings = get_option( "wplc_bh_settings" );

	if( isset( $wplc_bh_settings['enabled'] ) && $wplc_bh_settings['enabled'] ){
		/**
		 * Enabled, check if the current day fits in the interval
		 */
		$chat_box_interval = false;

		$current_day = current_time(date("N"));
		$current_day = intval( $current_day );

		if( isset( $wplc_bh_settings['interval'] ) ){
		
			if( $wplc_bh_settings['interval'] == '0' ){
				/**
				 * Show everyday
				 */
				$chat_box_interval = true;
			} else if ( $wplc_bh_settings['interval'] == '1' ){
				/**
				 * Weekdays only
				 */
				if( $current_day <= 5 ){
					$chat_box_interval = true;
				}
			} else if ( $wplc_bh_settings['interval'] == '2' ){
				/**
				 * Weekends only
				 */
				if( $current_day == 6 || $current_day == 7 ){
					$chat_box_interval = true;
				}
			}

		}
		
		if( $chat_box_interval ){
			/**
			 * Lets check if it's the right time to show it now
			 */
			if( isset( $wplc_bh_settings['start'] ) && isset( $wplc_bh_settings['end'] ) ){
				if( isset( $wplc_bh_settings['start']['h'] ) && isset( $wplc_bh_settings['start']['m'] ) ){
					$start_time = $wplc_bh_settings['start']['h'] . ":" . $wplc_bh_settings['start']['m'];
				} else {
					$start_time = "00:00";
				}
				if( isset( $wplc_bh_settings['end']['h'] ) && isset( $wplc_bh_settings['end']['m'] ) ){
					$end_time = $wplc_bh_settings['end']['h'] . ":" . $wplc_bh_settings['end']['m'];	
				} else {
					$end_time = "00:00";
				}
			}

			$current_time = current_time('timestamp');
			$start_time = strtotime( $start_time );
			$end_time = strtotime( $end_time );

			if( ( $current_time >= $start_time ) && ( $current_time <= $end_time ) ){
				$business_hours_enabled = true;
			} else {
				$business_hours_enabled = false;
			}
		} else {
			$business_hours_enabled = false;
		}

	}

	return $business_hours_enabled;
}

//add_action( "wplc_hook_output_box_header","wplc_hook_control_business_hours" );
add_filter("wplc_loggedin_filter","wplc_hook_control_business_hours",99,1);
function wplc_hook_control_business_hours($logged_in) {

	$display_chat_box = wplc_check_business_hours();

	if ( ! $display_chat_box ) {
		return false;
	}

	return $logged_in;

}

if ( ! function_exists( "wplc_active_business_hours_chat_box_notice" ) ) {
	add_filter( "wplc_filter_active_chat_box_notice", "wplc_active_business_hours_chat_box_notice" );
	function wplc_active_business_hours_chat_box_notice( $notice ) {
		$wplc_settings = get_option( "WPLC_SETTINGS" );
		if ( $wplc_settings["wplc_settings_enabled"] == 1 ) {
			$is_chat_enabled = wplc_check_business_hours();
			if ( ! $is_chat_enabled ) {
				$notice = '<div class="wplc-chat-box-notification wplc-chat-box-notification--disabled">';
				$notice .= '<p>' . sprintf( __( 'The Live Chat box is currently disabled on your website due to : <a href="%s">Business Hours Settings</a>', 'wp-livechat' ), admin_url( 'admin.php?page=wplivechat-menu-settings#wplc-business-hours' ) ) . '</p>';
				$notice .= '</div>';
			}
		}

		return $notice;
	}
}


add_filter( 'wplc_filter_new_chat_name', 'wplc_new_admin_filter_name' );

function wplc_new_admin_filter_name( $name ){

}