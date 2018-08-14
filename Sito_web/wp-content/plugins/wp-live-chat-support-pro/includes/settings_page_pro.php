<style>
    input[type=button]{
        cursor: pointer;
    }
</style>
<?php
wplc_pro_version_check();
$wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");

if (isset($wplc_pro_settings['wplc_pro_chat_notification']) && $wplc_pro_settings['wplc_pro_chat_notification'] == "yes") {
    $wplc_pro_chat_notification = "CHECKED";
} else {
    
};

if (get_option("WPLC_HIDE_CHAT") == true) {
    $wplc_hide_chat = "checked";
} else {
    $wplc_hide_chat = "";
};

$wplc_mail_type = get_option("wplc_mail_type");

$url = 'https://ccplugins.co/wplc-api/functions.php';

$response = wp_remote_post($url, array(
    'method' => 'POST',
    'body' => array(
        'action' => 'api_validation',
        'domain' => get_option('siteurl'),
        'api_key' => get_option('wplc_api_key')
    ),
));

if ( is_wp_error( $response ) ) {
   $error_message = $response->get_error_message();
   $data->status = 0;
} else {
    $data = $response['body'];
    $data = json_decode($data);
}

?>
<div class="wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post">
        <br>
    </div>
    <h2><?php _e("WP Live Chat Support Settings", "wplivechat") ?></h2>
<?php
$wplc_settings = get_option("WPLC_SETTINGS");
if ($wplc_settings["wplc_settings_align"]) {
    $wplc_settings_align[intval($wplc_settings["wplc_settings_align"])] = "SELECTED";
}
if ($wplc_settings["wplc_settings_enabled"]) {
    $wplc_settings_enabled[intval($wplc_settings["wplc_settings_enabled"])] = "SELECTED";
}
if ($wplc_settings["wplc_settings_fill"]) {
    $wplc_settings_fill = $wplc_settings["wplc_settings_fill"];
} else {
    $wplc_settings_fill = "ed832f";
}
if ($wplc_settings["wplc_settings_font"]) {
    $wplc_settings_font = $wplc_settings["wplc_settings_font"];
} else {
    $wplc_settings_font = "FFFFFF";
}

if(!get_option('wplc_api_key_valid') || get_option('wplc_api_key_valid') == '' || get_option('wplc_api_key_valid') == false){
    echo "
    <div class='error below-h1'>
        <p>" . __("Dear Pro User", "wplivechat") . "<br /></p>
        <p>" . __("Please enter a valid API key on the 'Live Chat' -> 'Settings' page. Failing to do this will result in you no longer receiving updates for this plugin.", "wplivechat")."</p>
        <p>" . __("You can obtain a copy of your API key ", "wplivechat")."<a href='http://wp-livechat.com/my-account' target='_BLANK'>".__('here', 'wplivechat')."</a>. ".__('An account has been created for you while purchasing the plugin. If you have lost your password, please reset it ', 'wplivechat')."<a href='http://wp-livechat.com/wp-login.php?action=lostpassword' target='_BLANK'>".__('here', 'wplivechat')."</a>.</p>
        <p>" . __("If you feel you are getting this message in error, please try refreshing the page.", "wplivechat")."</p>
    </div>";
}

?>
    
    <form action='admin.php?page=wplivechat-menu-settings' name='wplc_settings' method='POST' id='wplc_settings'>
        <div id="wplc_tabs">
            <ul>
                <li><a href="#tabs-1"><i class="fa fa-gear"></i> <?php _e("General Settings", "wplivechat") ?></a></li>
                <li><a href="#tabs-2"><i class="fa fa-envelope"></i> <?php _e("Chat Box", "wplivechat") ?></a></li>
                <li><a href="#tabs-3"><i class="fa fa-book"></i> <?php _e("Offline Messages", "wplivechat") ?></a></li>
                <li><a href="#tabs-4"><i class="fa fa-pencil"></i> <?php _e("Styling", "wplivechat") ?></a></li>
                <li><a href="#tabs-5"><i class="fa fa-users"></i> <?php _e("Chat Agents", "wplivechat") ?></a></li>
                <li><a href="#tabs-7"><i class="fa fa-gavel"></i> <?php _e("Blocked Visitors", "wplivechat") ?></a></li>
                <li><a href="#tabs-8"><i class="fa fa-star"></i> <?php _e("Chat Experience Ratings", "wplivechat") ?></a></li>
                <li><a href="#tabs-9"><i class="fa fa-lock"></i> <?php _e("Encryption", "wplivechat") ?></a></li>
            </ul>
            <div id="tabs-1">
                <h3><?php _e("Main Settings", 'wplivechat') ?></h3>
                <table class='form-table' width='700'>
                    <tr>
                        <?php $whatsthis = "<a href='http://www.wp-livechat.com/purchase-pro-cloud/?utm_source=plugin&utm_medium=link&utm_campaign=external_server' target='_BLANK'>".__('Find out more.', 'wplivechat')."</a>"; ?>
                        <td width='400' valign='top'>
                            <?php _e("Cloud Server", "wplivechat"); ?>: 
                            
                        </td> 
                        <td>
                            <input type="checkbox" name="wplc_use_external_server" id="wplc_use_external_server" value="1" <?php if (get_option('wplc_use_external_server')) { echo 'checked'; } ?> <?php if($data->status == 0 || $data->external == 0){ echo 'disabled readonly'; } ?> />
                            <?php _e("Use our server to host your chat server.","wplivechat"); ?> <?php echo $whatsthis;  ?><div id="external_server_message"></div>
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'><?php _e("API Key", "wplivechat") ?>:</td> 
                        <td>
                            <input type="text" name="wplc_api_key" id="wplc_api_key" value="<?php echo get_option('wplc_api_key'); ?>" style="width: 300px;"/>
                            <p class="description"> 
                            <?php
                            _e('This API key is ', 'wplivechat');
                            if ($data->status == 1) {
                                update_option('wplc_api_key_valid', 1);
                                echo '<span style="color: green; font-weight: bold;">' . __('valid', 'wplivechat') . '</span>';
                            } else {
                                update_option('wplc_api_key_valid', 0);
                                echo '<span style="color: red; font-weight: bold;">' . __('invalid', 'wplivechat') . '</span>';
                            }
                            ?>
                            </p>
                            <p class='description'><?php _e("A valid API key means that you will be able to get the latest version of the plugin as and when it is released, as well as get access to support should you require it.","wplivechat"); ?>
                        </td>
                    </tr>   
                    </table>
                    <hr />
                    <table class='form-table' width='700'>
                    <tr>
                        
                        <td width='400' valign='top'><?php _e("Chat enabled", "wplivechat") ?>:</td> 
                        <td>
                            <select id='wplc_settings_enabled' name='wplc_settings_enabled'>
                                <option value="1" <?php if (isset($wplc_settings_enabled[1])) {
                                echo $wplc_settings_enabled[1];
                            } ?>><?php _e("Yes", "wplivechat") ?></option>
                                <option value="2" <?php if (isset($wplc_settings_enabled[2])) {
                                echo $wplc_settings_enabled[2];
                            } ?>><?php _e("No", "wplivechat") ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Choose when I want to be online", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Checking this will allow you to change your status to Online or Offline on the Live Chat page.', 'wplivechat'); ?>"></i>                     
                        </td>  
                        <td>
                            <input type="checkbox" value="1" name="wplc_auto_online" <?php if (isset($wplc_pro_settings['wplc_auto_online']) && $wplc_pro_settings['wplc_auto_online'] == 1) {
    echo "checked";
} ?> />                    
                        </td>
                    </tr>
                    <tr>
                        <td width='400' valign='top'>
<?php _e("Hide Chat", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Hides chat for 24hrs when user clicks X", "wplivechat") ?>"></i>
                        </td>
                        <td valign='top'>
                            <input type="checkbox" name="wplc_hide_chat" value="true" <?php echo $wplc_hide_chat ?>/>
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Required Chat Box Fields", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Set default fields that will be displayed when users starting a chat", "wplivechat") ?>"></i>
                        </td>
                        <td valign='top'>
                            <div class="wplc-require-user-info__item">
                                <input type="radio" value="1" name="wplc_require_user_info" id="wplc_require_user_info_both" <?php if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == '1') { echo "checked"; } ?> />
                                <label for="wplc_require_user_info_both"><?php _e( 'Show name and email', 'wplivechat' ); ?></label>
                            </div>
                            <div class="wplc-require-user-info__item">
                                <input type="radio" value="email" name="wplc_require_user_info" id="wplc_require_user_info_email" <?php if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 'email') { echo "checked"; } ?> />
                                <label for="wplc_require_user_info_email"><?php _e( 'Show email', 'wplivechat' ); ?></label>
                            </div>
                            <div class="wplc-require-user-info__item">
                                <input type="radio" value="name" name="wplc_require_user_info" id="wplc_require_user_info_name" <?php if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 'name') { echo "checked"; } ?> />
                                <label for="wplc_require_user_info_name"><?php _e( 'Show name', 'wplivechat' ); ?></label>
                            </div>
                            <div class="wplc-require-user-info__item">
                                <input type="radio" value="0" name="wplc_require_user_info" id="wplc_require_user_info_none" <?php if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == '0') { echo "checked"; } ?> />
                                <label for="wplc_require_user_info_none"><?php _e( 'No fields', 'wplivechat' ); ?></label>
                            </div>
                        </td>
                    </tr>
                    <tr class="wplc-user-default-visitor-name__row">
                        <td width='300' valign='top'>
                            <?php _e("Default visitor name","wplivechat"); ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("This name will be displayed for all not logged in visitors", "wplivechat") ?>"></i>
                        </td>
                        <td valign='top'>
                            <input type="text" name="wplc_user_default_visitor_name" id="wplc_user_default_visitor_name" value="<?php if ( isset( $wplc_settings['wplc_user_default_visitor_name'] ) ) { echo stripslashes( $wplc_settings['wplc_user_default_visitor_name'] ); } else { echo __( "Guest", "wplivechat" ); } ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Input Field Replacement Text", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("This is the text that will show in place of the Name And Email fields", "wplivechat") ?>"></i>                      
                        </td>
                        <td valign='top'>
                            <textarea cols="45" rows="5" name="wplc_user_alternative_text" ><?php if (isset($wplc_settings['wplc_user_alternative_text'])) {
    echo stripslashes($wplc_settings['wplc_user_alternative_text']);
} ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
                            <?php _e("Use Logged In User Details", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("A user's Name and Email Address will be used by default if they are logged in.", "wplivechat") ?>"></i>
                            <p class="description"></p>
                        </td>
                        <td valign='top'>
                            <input type="checkbox" value="1" name="wplc_loggedin_user_info" <?php if (isset($wplc_settings['wplc_loggedin_user_info']) && $wplc_settings['wplc_loggedin_user_info'] == 1) {
                                echo "checked";
                            } ?> />                      
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Enable On Mobile Devices", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Disabling this will mean that the Chat Box will not be displayed on mobile devices. (Smartphones and Tablets)", "wplivechat") ?>"></i>
                        </td>
                        <td valign='top'>
                            <input type="checkbox" value="1" name="wplc_enabled_on_mobile" <?php if (isset($wplc_settings['wplc_enabled_on_mobile']) && $wplc_settings['wplc_enabled_on_mobile'] == 1) {
    echo "checked";
} ?> />                      
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Record a visitor's IP Address", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Disable this to enable anonymity for your visitors", "wplivechat") ?>"></i>                      
                        </td>
                        <td valign='top'>
                            <input type="checkbox" value="1" name="wplc_record_ip_address" <?php if (isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1) {
    echo "checked";
} ?> />                      
                        </td>
                    </tr>
              <tr>
                  <td width='200' valign='top'>
                      <?php _e("Play a sound when a new message is received","wplivechat"); ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Disable this to mute the sound that is played when a new chat message is received", "wplivechat") ?>"></i>
                  </td>
                  <td valign='top'>
                      <input type="checkbox" value="1" name="wplc_enable_msg_sound" <?php if(isset($wplc_settings['wplc_enable_msg_sound'])  && $wplc_settings['wplc_enable_msg_sound'] == 1 ) { echo "checked"; } ?> />                      
                  </td>
              </tr>
                    
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Include chat window on the following pages:", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Show the chat window on the following pages. Leave blank to show on all. (Use comma-separated Page ID's)", "wplivechat") ?>"></i>
                        </td>
                        <td valign='top'>
                            <input type="text" name="wplc_include_on_pages" value="<?php if (isset($wplc_pro_settings['wplc_include_on_pages'])) {
    echo $wplc_pro_settings['wplc_include_on_pages'];
} ?>" />                      
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Exclude chat window on the following pages:", "wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Do not show the chat window on the following pages. Leave blank to show on all. (Use comma-separated Page ID's)", "wplivechat") ?>"></i>                      
                        </td>
                        <td valign='top'>
                            <input type="text" name="wplc_exclude_from_pages" value="<?php if (isset($wplc_pro_settings['wplc_exclude_from_pages'])) {
    echo $wplc_pro_settings['wplc_exclude_from_pages'];
} ?>" />                      
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
                        <td width='200' valign='top'>
                    <?php _e("Allow any user to make themselves a chat agent", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('Checking this will allow any of your users to make themselves a chat agent when editing their profile.', 'wplivechat'); ?>"></i>
                        </td>
                        <td>
                            <input type="checkbox" value="1" name="wplc_make_agent" <?php if (isset($wplc_pro_settings['wplc_make_agent']) && $wplc_pro_settings['wplc_make_agent'] == 1) {
                        echo "checked";
                    } ?> />                                          
                        </td>
                    </tr>
                </table>
              <?php do_action('wplc_hook_admin_settings_main_settings_after'); ?>

            </div>
            <div id="tabs-2">
                <h3><?php _e("Chat Window Settings", 'wplivechat') ?></h3>
                <table class='form-table' width='700'>
                    <tr>
                        <td width='200' valign='top'><?php _e("Chat box alignment", "wplivechat") ?>:</td>
                        <td>
                            <select id='wplc_settings_align' name='wplc_settings_align'>
                                <option value="1" <?php if (isset($wplc_settings_align[1])) {
                        echo $wplc_settings_align[1];
                    } ?>><?php _e("Bottom left", "wplivechat") ?></option>
                                <option value="2" <?php if (isset($wplc_settings_align[2])) {
                        echo $wplc_settings_align[2];
                    } ?>><?php _e("Bottom right", "wplivechat") ?></option>
                                <option value="3" <?php if (isset($wplc_settings_align[3])) {
                                echo $wplc_settings_align[3];
                            } ?>><?php _e("Left", "wplivechat") ?></option>
                                <option value="4" <?php if (isset($wplc_settings_align[4])) {
                                echo $wplc_settings_align[4];
                            } ?>><?php _e("Right", "wplivechat") ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
<?php _e("Auto Pop-up", "wplivechat") ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Expand the chat box automatically (prompts the user to enter their name and email address).", "wplivechat") ?>"></i>
                        </td>
                        <td>
                            <input type="checkbox" name="wplc_auto_pop_up" value="1" <?php if (isset($wplc_settings['wplc_auto_pop_up']) && $wplc_settings['wplc_auto_pop_up'] == 1) {
    echo "checked";
} ?>/>                      
                        </td>
                    </tr>
                    <!-- Chat Name-->
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Name ", "wplivechat") ?>:
                        </td>
                        <td>
                            <input id='wplc_pro_name' name='wplc_pro_name' type='text' size='50' maxlength='50' class='regular-text' value='<?php if (isset($wplc_pro_settings['wplc_chat_name'])) { echo stripslashes($wplc_pro_settings['wplc_chat_name']); } ?>' />
                        </td>
                    </tr>
                    <!-- Chat Pic-->
<?php
$wplc_current_user = wp_get_current_user();
$wplc_current_picture = urldecode($wplc_pro_settings['wplc_chat_pic']);
$wplc_current_logo = urldecode($wplc_pro_settings['wplc_chat_logo']);
$wplc_current_icon = urldecode($wplc_pro_settings['wplc_chat_icon']);
?>
                    <!-- Chat Icon-->
                    <tr>
                        <td width='200' valign='top'>
			                <?php _e("Icon", "wplivechat") ?>:
                        </td>
                        <td>
                            <span id="wplc_icon_area">
                                <img src="<?php echo $wplc_current_icon; ?>" width="50px"/>
                            </span>
                            <input id="wplc_upload_icon" name="wplc_upload_icon" type="hidden" size="35" class="regular-text" maxlength="700" value="<?php echo base64_encode($wplc_current_icon) ?>"/>
                            <br/>
                            <input id="wplc_btn_upload_icon" name="wplc_btn_upload_icon" type="button" value="<?php _e("Upload Icon", "wplivechat") ?>" />
                            <br/>
                            <input id="wplc_btn_remove_icon" name="wplc_btn_remove_icon" type="button" value="<?php _e("Remove Icon", "wplivechat") ?>" />
			                <?php _e("Recommended Size 50px x 50px", "wplivechat") ?>
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
                            <?php _e("Picture", "wplivechat") ?>:
                        </td>
                        <td>
                            <span id="wplc_pic_area">
                                <img src="<?php echo $wplc_current_picture ?>" width="100px"/>
                            </span>
                            <input id="wplc_upload_pic" name="wplc_upload_pic" type="hidden" size="35" class="regular-text" maxlength="700" value="<?php echo base64_encode($wplc_current_picture) ?>"/> 
                            <br/>
                            <input id="wplc_btn_upload_pic" name="wplc_btn_upload_pic" type="button" value="<?php _e("Upload Image", "wplivechat") ?>" />
                            <br/>
                            <input id="wplc_btn_remove_pic" name="wplc_btn_remove_pic" type="button" value="<?php _e("Remove Image", "wplivechat") ?>" />
                            <?php _e("Recommended Size 40px x 40px", "wplivechat") ?>
                        </td>
                    </tr>
                    <!-- Chat Logo-->
                    <tr>
                        <td width='200' valign='top'>
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
<?php _e("Recommended Size 250px x 40px", "wplivechat") ?>
                        </td>
                    </tr>
                    <!-- Chat Delay-->
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Chat delay (seconds)", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("How long it takes for your chat window to pop up", "wplivechat") ?>"></i>
                        </td>
                        <td>
                            <input id="wplc_pro_delay" name="wplc_pro_delay" type="text" size="6" maxlength="4" value="<?php echo stripslashes($wplc_pro_settings['wplc_chat_delay']) ?>" />
                        </td>
                    </tr>
                    <!-- Chat Notification if want to chat -->
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Chat notifications", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Alert me via email as soon as someone wants to chat (while online only)", "wplivechat"); ?>"></i>
                        </td>
                        <td>
                            <input id="wplc_pro_chat_notification" name="wplc_pro_chat_notification" type="checkbox" value="yes" <?php if (isset($wplc_pro_chat_notification)) {
    echo $wplc_pro_chat_notification;
} ?>/>                    
                        </td>
                    </tr>
                    <tr>
                        <td>
<?php _e("Display name and avatar in chat", "wplivechat") ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Display the agent and user name above each message in the chat window.", "wplivechat") ?>"></i>
                        </td>
                        <td>
                            <input type="checkbox" name="wplc_display_name" value="1" <?php
if (isset($wplc_settings['wplc_display_name']) && $wplc_settings['wplc_display_name'] == 1) {
    echo "checked";
}
?>/>                      
                        </td>
                    </tr>
                    <tr>
                        <td>
<?php _e("Only show the chat window to users that are logged in", "wplivechat") ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("By checking this, only users that are logged in will be able to chat with you.", "wplivechat") ?>"></i>
                        </td>
                        <td>
                            <input type="checkbox" name="wplc_display_to_loggedin_only" value="1" <?php
if (isset($wplc_settings['wplc_display_to_loggedin_only']) && $wplc_settings['wplc_display_to_loggedin_only'] == 1) {
    echo "checked";
}
?>/>                      
                        </td>
                    </tr>

                </table>

            </div>
            <div id="tabs-3">
                <h3><?php _e("Offline Messages", 'wplivechat') ?></h3> 
                <table class='form-table' width='700'>
                    <tr>
                        <td>
<?php _e("Do not allow users to send offline messages", "wplivechat") ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("The chat window will be hidden when it is offline. Users will not be able to send offline messages to you", "wplivechat") ?>"></i>
                        </td>
                        <td>
                            <input type="checkbox" name="wplc_hide_when_offline" value="1" <?php
if (isset($wplc_settings['wplc_hide_when_offline']) && $wplc_settings['wplc_hide_when_offline'] == 1) {
    echo "checked";
}
?>/>
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'>
<?php _e("Email Address", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Email address where offline messages are delivered to. Use comma separated email addresses to send to more than one email address", "wplivechat") ?>"></i>
                        </td>
                        <td>
                            <input id="wplc_pro_chat_email_address" name="wplc_pro_chat_email_address" class="regular-text" type="text" value="<?php if (isset($wplc_settings['wplc_pro_chat_email_address'])) {
    echo $wplc_settings['wplc_pro_chat_email_address'];
} ?>" />
                        </td>
                    </tr>

                </table>
                <hr/>
                <table >
                    <tr>
                        <td width="200px"><?php _e("Sending Method", "wplivechat") ?></td>
                        <td width="200px" style="text-align: center;"><?php _e("WP Mail", "wplivechat") ?></td>
                        <td width="200px" style="text-align: center;"><?php _e("PHP Mailer", "wplivechat") ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;"><input class="wplc_mail_type_radio" type="radio" value="wp_mail" name="wplc_mail_type" <?php if ($wplc_mail_type == "wp_mail") {
    echo "checked";
} ?>></td>
                        <td style="text-align: center;"><input id="wpcl_mail_type_php" class="wplc_mail_type_radio" type="radio" value="php_mailer" name="wplc_mail_type" <?php if ($wplc_mail_type == "php_mailer") {
    echo "checked";
} ?>></td>
                    </tr>
                </table>
                <hr/>
                <table id="wplc_smtp_details" class='form-table' width='700'>
                    <tr>
                        <td width="200" valign="top">
<?php _e("Host", "wplivechat") ?>: 
                        </td>
                        <td>
                            <input id="wplc_mail_host" name="wplc_mail_host" type="text" class="regular-text" value="<?php echo get_option("wplc_mail_host") ?>" placeholder="smtp.example.com" />
                        </td>
                    </tr>
                    <tr>
                        <td>
<?php _e("Port", "wplivechat") ?>: 
                        </td>
                        <td>
                            <input id="wplc_mail_port" name="wplc_mail_port" type="text" class="regular-text" value="<?php echo get_option("wplc_mail_port") ?>" placeholder="25" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                                        <?php _e("Username", "wplivechat") ?>: 
                        </td>
                        <td>
                            <input id="wplc_mail_username" name="wplc_mail_username" type="text" class="regular-text" value="<?php echo get_option("wplc_mail_username") ?>" placeholder="me@example.com" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                                        <?php _e("Password", "wplivechat") ?>: 
                        </td>
                        <td>
                            <input id="wplc_mail_password" name="wplc_mail_password" type="password" class="regular-text" value="<?php echo get_option("wplc_mail_password") ?>" placeholder="Password" />
                        </td>
                    </tr>
                </table>
                <table class='form-table' width='700'>
                    <tr>
                        <td width="200" valign="top"><?php _e("Offline Chat Box Title", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_na" name="wplc_pro_na" type="text" size="50" maxlength="50" class="regular-text" value="<?php  if (isset($wplc_pro_settings['wplc_pro_na'])) { echo stripslashes($wplc_pro_settings['wplc_pro_na']); } ?>" /> <br />


                        </td>
                    </tr>
                    <tr>
                        <td width="200" valign="top"><?php _e("Offline Text Fields", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_offline1" name="wplc_pro_offline1" type="text" size="50" maxlength="150" class="regular-text" value="<?php if (isset($wplc_pro_settings['wplc_pro_offline1'])) { echo stripslashes($wplc_pro_settings['wplc_pro_offline1']); } ?>" /> <br />
                            <input id="wplc_pro_offline2" name="wplc_pro_offline2" type="text" size="50" maxlength="50" class="regular-text" value="<?php if (isset($wplc_pro_settings['wplc_pro_offline1'])) { echo stripslashes($wplc_pro_settings['wplc_pro_offline2']); } ?>" /> <br />
                            <input id="wplc_pro_offline3" name="wplc_pro_offline3" type="text" size="50" maxlength="150" class="regular-text" value="<?php if (isset($wplc_pro_settings['wplc_pro_offline1'])) { echo stripslashes($wplc_pro_settings['wplc_pro_offline3']); } ?>" /> <br />


                        </td>
                    </tr>
                    <tr>
                        <td width="200" valign="top"><?php _e("Offline Button Text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_offline_btn" name="wplc_pro_offline_btn" type="text" size="50" maxlength="50" class="regular-text" value="<?php  if (isset($wplc_pro_settings['wplc_pro_offline_btn'])) { echo stripslashes($wplc_pro_settings['wplc_pro_offline_btn']); } ?>" /> <br />
                        </td>
                    </tr>
                    <tr>
                        <td width="200" valign="top"><?php _e("Offline Send Button Text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_offline_btn_send" name="wplc_pro_offline_btn_send" type="text" size="50" maxlength="50" class="regular-text" value="<?php  if (isset($wplc_pro_settings['wplc_pro_offline_btn_send'])) { echo stripslashes($wplc_pro_settings['wplc_pro_offline_btn_send']); } ?>" /> <br />
                        </td>
                    </tr>
                </table>

            </div>

            <div id="tabs-4">
                <h3><?php _e("Styling", 'wplivechat') ?></h3>
                <style>
                    .wplc_theme_block img{
                        border: 1px solid #CCC;
                        border-radius: 5px;
                        padding: 5px;
                        margin: 5px;
                    }         
                    .wplc_theme_single{
                        width: 162px;
                        height: 162px;
                        text-align: center;
                        display: inline-block;
                        vertical-align: top;
                        margin: 5px;
                    }
                </style>
                <table class='form-table' width='700'>
                    <tr style='margin-bottom: 10px;'>
                        <td><label for=""><?php _e('Choose a theme', 'sola_t'); ?></label></td>
                        <td>    
                            <div class='wplc_theme_block'>
                                <div class='wplc_theme_image' id=''>
                                    <div class='wplc_theme_single'>
                                        <img src='<?php echo plugins_url() . "/wp-live-chat-support-pro/images/themes/theme-1.png"; ?>' title="<?php _e('Theme 1', 'wplivechat'); ?>" alt="<?php _e('Theme 1', 'wplivechat'); ?>" class='<?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-1') {
                                            echo 'wplc_theme_active';
                                        } ?>' id='wplc_theme_1'/>
<?php _e('Theme 1', 'wplivechat'); ?>
                                    </div>
                                    <div class='wplc_theme_single'>
                                        <img src='<?php echo plugins_url() . "/wp-live-chat-support-pro/images/themes/theme-2.png"; ?>' title="<?php _e('Theme 2', 'wplivechat'); ?>" alt="<?php _e('Theme 2', 'wplivechat'); ?>" class='<?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-2') {
    echo 'wplc_theme_active';
} ?>' id='wplc_theme_2'/>
<?php _e('Theme 2', 'wplivechat'); ?>
                                    </div>
                                    <div class='wplc_theme_single'>
                                        <img src='<?php echo plugins_url() . "/wp-live-chat-support-pro/images/themes/theme-3.png"; ?>' title="<?php _e('Theme 3', 'wplivechat'); ?>" alt="<?php _e('Theme 3', 'wplivechat'); ?>" class='<?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-3') {
    echo 'wplc_theme_active';
} ?>' id='wplc_theme_3'/>
<?php _e('Theme 3', 'wplivechat'); ?>
                                    </div>
                                    <div class='wplc_theme_single'>
                                        <img src='<?php echo plugins_url() . "/wp-live-chat-support-pro/images/themes/theme-4.png"; ?>' title="<?php _e('Theme 4', 'wplivechat'); ?>" alt="<?php _e('Theme 4', 'wplivechat'); ?>" class='<?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-4') {
    echo 'wplc_theme_active';
} ?>' id='wplc_theme_4'/>
<?php _e('Theme 4', 'wplivechat'); ?>
                                    </div>
                                    <div class='wplc_theme_single'>
                                        <img src='<?php echo plugins_url() . "/wp-live-chat-support-pro/images/themes/theme-5.png"; ?>' title="<?php _e('Theme 5', 'wplivechat'); ?>" alt="<?php _e('Theme 5', 'wplivechat'); ?>" class='<?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-5') {
    echo 'wplc_theme_active';
} ?>' id='wplc_theme_5'/>
<?php _e('Theme 5', 'wplivechat'); ?>
                                    </div>
                                    <div class='wplc_theme_single'>
                                        <img src='<?php echo plugins_url() . "/wp-live-chat-support-pro/images/themes/theme-6.png"; ?>' title="<?php _e('Theme 6', 'wplivechat'); ?>" alt="<?php _e('Theme 6', 'wplivechat'); ?>" class='<?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-6') {
    echo 'wplc_theme_active';
} ?>' id='wplc_theme_6'/>
<?php _e('Custom. Enter Colour Values Below', 'wplivechat'); ?>
                                    </div>
                                </div>
                            </div>
                            <input type="radio" name="wplc_theme" value="theme-1" class="wplc_hide_input" id="wplc_rb_theme_1" <?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-1') {
    echo 'checked';
} ?>/>
                            <input type="radio" name="wplc_theme" value="theme-2" class="wplc_hide_input" id="wplc_rb_theme_2" <?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-2') {
    echo 'checked';
} ?>/>
                            <input type="radio" name="wplc_theme" value="theme-3" class="wplc_hide_input" id="wplc_rb_theme_3" <?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-3') {
    echo 'checked';
} ?>/>
                            <input type="radio" name="wplc_theme" value="theme-4" class="wplc_hide_input" id="wplc_rb_theme_4" <?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-4') {
    echo 'checked';
} ?>/>
                            <input type="radio" name="wplc_theme" value="theme-5" class="wplc_hide_input" id="wplc_rb_theme_5" <?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-5') {
    echo 'checked';
} ?>/>
                            <input type="radio" name="wplc_theme" value="theme-6" class="wplc_hide_input" id="wplc_rb_theme_6" <?php if (isset($wplc_pro_settings['wplc_theme']) && $wplc_pro_settings['wplc_theme'] == 'theme-6') {
    echo 'checked';
} ?>/>
                        </td>
                    </tr>

                    <tr>
                        <td width='200' valign='top'><?php _e("Chat box fill color", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_settings_fill" name="wplc_settings_fill" type="text" class="color" value="<?php echo $wplc_settings_fill ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td width='200' valign='top'><?php _e("Chat box font color", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_settings_font" name="wplc_settings_font" type="text" class="color" value="<?php echo $wplc_settings_font ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td width="200" valign="top"><?php _e("I'm using a localization plugin", "wplivechat") ?></td>
                        <td>
<?php
$documentation_link = "<a href='http://wp-livechat.com/documentation/changing-strings-in-the-chat-window-when-using-a-localization-plugin/' target='_BLANK'>" . __('documentation', 'wplivechat') . "</a>";
?>
                            <input type="checkbox" name="wplc_using_localization_plugin" id="wplc_using_localization_plugin" value="1" <?php if (isset($wplc_pro_settings['wplc_using_localization_plugin']) && $wplc_pro_settings['wplc_using_localization_plugin'] == 1) {
    echo 'checked';
} ?>/>
                            <small id="wplc_localization_warning"><p class="description"><?php _e('You will only be able to edit the strings shown in the chat window of the code now. <br/> This has been done to accommodate as many localization plugins as possible. <br/> For more information on how to change these strings, please consult the ', 'wplivechat');
echo $documentation_link; ?></p></small>
                        </td>
                    </tr>
                    <tr class="wplc_localization_strings">
                        <td width="200" valign="top"><?php _e("First Section Text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_fst1" name="wplc_pro_fst1" type="text" size="50" maxlength="50" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_pro_fst1']) ?>" /> <br />
                            <input id="wplc_pro_fst2" name="wplc_pro_fst2" type="text" size="50" maxlength="50" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_pro_fst2']) ?>" /> <br />
                        </td>
                    </tr>
                    <tr class="wplc_localization_strings">
                        <td width="200" valign="top"><?php _e("Intro Text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_intro" name="wplc_pro_intro" type="text" size="50" maxlength="150" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_pro_intro']) ?>" /> <br />
                        </td>
                    </tr>
                    <tr class="wplc_localization_strings">
                        <td width="200" valign="top"><?php _e("Second Section Text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_sst1" name="wplc_pro_sst1" type="text" size="50" maxlength="30" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_pro_sst1']) ?>" /> <br />
                            <input id="wplc_pro_sst2" name="wplc_pro_sst2" type="text" size="50" maxlength="70" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_pro_sst2']) ?>" /> <br />
                        </td>
                    </tr>
                    <tr class="wplc_localization_strings">
                        <td width="200" valign="top"><?php _e("Reactivate Chat Section Text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_pro_tst1" name="wplc_pro_tst1" type="text" size="50" maxlength="50" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_pro_tst1']) ?>" /> <br />


                        </td>
                    </tr>
                    <tr class="wplc_localization_strings">
                        <td width="200" valign="top"><?php _e("User chat welcome", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_user_welcome_chat" name="wplc_user_welcome_chat" type="text" size="50" maxlength="150" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_user_welcome_chat']) ?>" /> <br />
                        </td>
                    </tr>
                    <tr class="wplc_localization_strings">
                        <td width="200" valign="top"><?php _e("Other text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_user_enter" name="wplc_user_enter" type="text" size="50" maxlength="150" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_user_enter']) ?>" /><?php _e('This text is shown above the user chat input field', 'wplivechat'); ?><br />
                        </td>
                    </tr>
                    <tr class="wplc_localization_strings">
                        <td width="200" valign="top"><?php _e("Close Button Text", "wplivechat") ?>:</td>
                        <td>
                            <input id="wplc_close_btn_text" name="wplc_close_btn_text" type="text" size="50" maxlength="150" class="regular-text" value="<?php echo stripslashes($wplc_pro_settings['wplc_close_btn_text']) ?>" /><br />
                        </td>
                    </tr>
                    <style>
                        .wplc_animation_block div{
                            display: inline-block;
                            width: 150px;
                            height: 150px;
                            border: 1px solid #CCC;
                            border-radius: 5px;
                            text-align: center;  
                            margin: 10px;
                        }
                        .wplc_animation_block i{
                            font-size: 3em;
                            line-height: 150px;
                        }
                        .wplc_animation_block .wplc_red{
                            color: #E31230;
                        }
                        .wplc_animation_block .wplc_orange{
                            color: #EB832C;
                        }
                        .wplc_animation_active, .wplc_theme_active{
                            box-shadow: 2px 2px 2px #CCC;
                        }
                    </style>
                <?php
                global $wplc_version;
                $ver = str_replace('.', '', $wplc_version);
                $ver = intval($ver);
                if ($ver <= '427') {
                    echo "<div class='error'><p>" . __("You are using an outdated version of WP Live Chat Support Basic. Please update your plugin to allow for animations to function", "wplivechat") . "</p></div>";
                }
                ?>
                    <tr>
                        <th><label for=""><?php _e('Choose an animation', 'sola_t'); ?></label></th>

                        <td>    
                            <div class='wplc_animation_block'>
                                <div class='wplc_animation_image <?php if (isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-1') {
                    echo 'wplc_animation_active';
                } ?>' id='wplc_animation_1'>
                                    <i class="fa fa-arrow-circle-up wplc_orange"></i>
                                    <p><?php _e('Slide Up', 'wplivechat'); ?></p>
                                </div>
                                <div class='wplc_animation_image <?php if (isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-2') {
                    echo 'wplc_animation_active';
                } ?>' id='wplc_animation_2'>
                                    <i class="fa fa-arrows-h wplc_red"></i>
                                    <p><?php _e('Slide From The Side', 'wplivechat'); ?></p>
                                </div>
                                <div class='wplc_animation_image <?php if (isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-3') {
                    echo 'wplc_animation_active';
                } ?>' id='wplc_animation_3'>
                                    <i class="fa fa-arrows-alt wplc_orange"></i>
                                    <p><?php _e('Fade In', 'wplivechat'); ?></p>
                                </div>
                                <div class='wplc_animation_image <?php if ((isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-4') || !isset($wplc_pro_settings['wplc_animation'])) {
                    echo 'wplc_animation_active';
                } ?>' id='wplc_animation_4'>
                                    <i class="fa fa-thumb-tack wplc_red"></i>
                                    <p><?php _e('No Animation', 'wplivechat'); ?></p>
                                </div>
                            </div>
                            <input type="radio" name="wplc_animation" value="animation-1" class="wplc_hide_input" id="wplc_rb_animation_1" class='wplc_hide_input' <?php if (isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-1') {
                    echo 'checked';
                } ?>/>
                            <input type="radio" name="wplc_animation" value="animation-2" class="wplc_hide_input" id="wplc_rb_animation_2" class='wplc_hide_input' <?php if (isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-2') {
                    echo 'checked';
                } ?>/>
                            <input type="radio" name="wplc_animation" value="animation-3" class="wplc_hide_input" id="wplc_rb_animation_3" class='wplc_hide_input' <?php if (isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-3') {
                    echo 'checked';
                } ?>/>
                            <input type="radio" name="wplc_animation" value="animation-4" class="wplc_hide_input" id="wplc_rb_animation_4" class='wplc_hide_input' <?php if (isset($wplc_pro_settings['wplc_animation']) && $wplc_pro_settings['wplc_animation'] == 'animation-4') {
                    echo 'checked';
                } ?>/>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="tabs-5">
                <style>
                    .wplc_agent_container ul { 
                        display:block;
                        overflow:auto;
                    }
                    .wplc_agent_container li{
                        display: block;
                        float: left;
                        text-align: center;
                        border: 1px solid #CCC;
                        width:150px;
                        height:310px;
                        padding: 10px;
                        border-radius: 5px;
                        margin: 10px;
                        box-shadow: 2px 2px 2px #CCC;
                        overflow: auto;

                    }
                    .wplc_agent_container img{
                        border-radius: 100px;
                    }
                    .wplc_agent_container h3 {
                        font: bold 12px/16px Arial;
                        padding: 0 0 0 0px;
                        color: #C2BBBE;
                        display: block;
                        height:40px;
                        text-transform: uppercase;
                    }
                    .wplc_agent_container small {  word-wrap: break-word; display:block; height:50px; }
                    .wplc_agent_container select { width: 120px; }
                </style>
<?php
$user_array = get_users(array(
    'meta_key' => 'wplc_ma_agent',
        ));
?>
                <h3><?php _e('Current Users that are Chat Agents', 'wplivechat'); ?></h3> 
<?php
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

            </div> 
            <div id="tabs-7">            
                <h3><?php _e("Blocked Visitors - Based on IP Address", "wplivechat") ?></h3>
                <textarea name="wplc_ban_users_ip" style="width: 50%; min-height: 200px;" placeholder="<?php _e('Enter each IP Address you would like to block on a new line', 'wplivechat'); ?>" autocomplete="false"><?php
                $ip_addresses = get_option('WPLC_BANNED_IP_ADDRESSES');
                if ($ip_addresses) {
                    $ip_addresses = maybe_unserialize($ip_addresses);
                    if (is_array($ip_addresses)) {
                        foreach ($ip_addresses as $ip) {
                            echo $ip . "\n";
                        }
                    }
                }
                ?></textarea>  
                <p class="description"><?php _e('Blocking a user\'s IP Address here will hide the chat window from them, preventing them from chatting with you. Each IP Address must be on a new line', 'wplivechat'); ?></p>
            </div>
            <div id="tabs-8">            
                <h3><?php _e("Chat Experience Ratings", "wplivechat") ?></h3>
                <?php
                if (function_exists('wplc_ce_activate')) {
                    wplc_ce_settings_tab();
                } else {
                    ?>
                    <p><a href="http://wp-livechat.com/chat-experience-ratings/?utm_source=plugin&utm_medium=link&utm_campaign=chat_experience" target="_BLANK"><?php _e("Chat Experience Ratings", "wplivechat") ?></a> <?php _e('are only available in the WP Live Chat Support Chat Experience Ratings add-on', 'wplivechat'); ?></p>
                <?php } ?>
            </div>
            <div id="tabs-9">            
                <h3><?php _e("Chat Encryption", "wplivechat") ?></h3>
                <table class='form-table' width='700'>
                    <tr>
                        <td width='200' valign='top'><?php _e("Enable Encryption", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e('All messages will be encrypted when being sent to and from the user and agent.', 'wplivechat'); ?>"></i></td> 
                        <td>
                            <input type="checkbox" name="wplc_enable_encryption" id="wplc_enable_encryption" value="1" <?php if(isset($wplc_pro_settings['wplc_enable_encryption']) && $wplc_pro_settings['wplc_enable_encryption'] == 1){ echo 'checked'; } ?>/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <p style='background-color: red; color: white; border-radius: 5px; padding: 10px; margin: 5px 5px 5px 0;'><?php _e('Once enabled, all messages sent will be encrypted. This cannot be undone.', 'wplivechat'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <p class='submit'><input type='submit' name='wplc_save_settings' class='button-primary' value='<?php _e("Save Settings", "wplivechat") ?>' /></p>
    </form>
</div>
