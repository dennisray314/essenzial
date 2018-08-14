<?php

$wplc_basic_plugin_url = get_option('siteurl')."/wp-content/plugins/wp-live-chat-support/";


if (class_exists("AES")) {} else { require( 'includes/aes_fast.php'); }
if (class_exists("cryptoHelpers")) { } else { require( 'includes/cryptoHelpers.php'); }


function wplc_list_chats_pro_new($agent_id) {

    global $wpdb;
    global $wplc_tblname_chats;
    $status = 3;
    $wplc_c = 0;    
    $results = $wpdb->get_results(
        "
    SELECT *
    FROM $wplc_tblname_chats
        WHERE `status` = 3 OR `status` = 2 OR `status` = 10 OR `status` = 5 or `status` = 8 or `status` = 9
        ORDER BY `timestamp` ASC

    "
    );
    $data_array = array();
    $id_list = array();
    
            
    if (!$results) {
        $data_array = false;
    } else {
        
        
        foreach ($results as $result) {
            unset($trstyle);
            unset($actions);
            $wplc_c++;
            

            
            $aid = "";
            
            if(is_numeric($agent_id)){
                $aid = "&aid=".$agent_id;
            }
            
            global $wplc_basic_plugin_url;
            $user_data = maybe_unserialize($result->ip);
            $user_ip = $user_data['ip'];
            $browser = wplc_return_browser_string($user_data['user_agent']);
            $browser_image = wplc_return_browser_image($browser,"16");
            
            if($user_ip == ""){
                $user_ip = __('IP Address not recorded', 'wplivechat');
            } else {
                $user_ip = "<a href='http://www.ip-adress.com/ip_tracer/" . $user_ip . "' title='".__('Whois for' ,'wplivechat')." ".$user_ip."'>".$user_ip."</a>";
            } 
            
            if (intval($result->status) == 2) {
                $url = admin_url( 'admin.php?page=wplivechat-menu&action=ac&cid='.$result->id.$aid);
                $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Accept Chat","wplivechat")."</a>";
                $trstyle = "style='background-color:#FFFBE4; height:30px;'";
                $icon = "<i class=\"fa fa-phone wplc_pending\" title='".__('Incoming Chat', 'wplivechat')."' alt='".__('Incoming Chat', 'wplivechat')."'></i><div class='wplc_icon_message'>".__('You have an incoming chat.', 'wplivechat')."</div>";
            }
            else if (intval($result->status) == 3) {
                $url = admin_url( 'admin.php?page=wplivechat-menu&action=ac&cid='.$result->id.$aid);
                $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Open Chat","wplivechat")."</a>";
                $trstyle = "style='background-color:#F7FCFE; height:30px;'";
                $icon = "<i class=\"fa fa-check-circle wplc_active\" title='".__('Chat Active', 'wplivechat')."' alt='".__('Chat Active', 'wplivechat')."'></i><div class='wplc_icon_message'>".__('This chat is active', 'wplivechat')."</div>";                        
            }
            else if(intval($result->status) == 5 ){
                $url = admin_url( 'admin.php?page=wplivechat-menu&action=rc&cid='.$result->id.$aid);
                if(is_numeric($agent_id) or $agent_id === true){
                    $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button wplc_initiate_chat button-secondary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Initiate Chat","wplivechat")."</a>";
                } else {
                    $actions = "<a  class=\"wplc_open_chat\" window-title=\"WP_Live_Chat_".$result->id."\">".__("You must be a chat agent to initiate chats","wplivechat")."</a>";
                }

            } 
            else {
                $actions = "";
            }
            
            
           /* if ($wplc_c>1) { $actions = wplc_get_msg(); } */
            
           $trstyle = "";
            
           $id_list[intval($result->id)] = true;
           
           $data_array[$result->id]['name'] = $result->name;
           $data_array[$result->id]['email'] = $result->email;
           
           $data_array[$result->id]['status'] = $result->status;
           $data_array[$result->id]['action'] = $actions;
           if (function_exists("wplc_time_ago")) { $data_array[$result->id]['timestamp'] = wplc_time_ago($result->timestamp); } else { $data_array[$result->id]['timestamp'] = "-"; }

           if ((current_time('timestamp') - strtotime($result->timestamp)) < 3600) {
               $data_array[$result->id]['type'] = __("New","wplivechat");
           } else {
               $data_array[$result->id]['type'] = __("Returning","wplivechat");
           }
           
           $data_array[$result->id]['image'] = "<img src=\"//www.gravatar.com/avatar/".md5($result->email)."?s=20&d=mm\" />";
           $data_array[$result->id]['data']['browsing'] = $result->url;
           $path = parse_url($result->url, PHP_URL_PATH);
           
           if (strlen($path) > 20) {
                $data_array[$result->id]['data']['browsing_nice_url'] = substr($path,0,20).'...';
           } else { 
               $data_array[$result->id]['data']['browsing_nice_url'] = $path;
           }
           
           $data_array[$result->id]['data']['browser'] = "<img src='" . $wplc_basic_plugin_url . "/images/$browser_image' alt='$browser' title='$browser' /> ";
           $data_array[$result->id]['data']['ip'] = $user_ip;
        }
        $data_array['ids'] = $id_list;
    }
    
    return json_encode($data_array);
}



function wplc_list_visitors($agent_id) {

    global $wpdb;
    global $wplc_tblname_chats;
    
    $wplc_c = 0;
    
    $results = $wpdb->get_results(
        "
	SELECT *
	FROM $wplc_tblname_chats
        WHERE `status` = 5 or `status` = 9
        ORDER BY `timestamp` DESC
	"
    );    
    /* come here */
        
    if($results ){
        $table = "<h2>".__('Visitors on site', 'wplivechat')."</h2>";
        $table .= "<div id=\"wplc_visitor_accordion\">";        
        foreach ($results as $result) {
            unset($trstyle);
            unset($actions);
            $wplc_c++;
            $aid = "";
            
            if(is_numeric($agent_id)){
                $aid = "&aid=".$agent_id;
            }

            $url = admin_url( 'admin.php?page=wplivechat-menu&action=rc&cid='.$result->id.$aid);
//            $agent_id = 'x';
            
            if($result->status == 5 ){
                if(is_numeric($agent_id) or $agent_id === true){
                    $actions = "<a href=\"".$url."\" class=\"wplc_open_chat button\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Initiate Chat","wplivechat")."</a>";
                } else {
                    $actions = "<a  class=\"wplc_open_chat\" window-title=\"WP_Live_Chat_".$result->id."\">".__("You must be a chat agent to initiate chats","wplivechat")."</a>";
                }
            } else {
                $actions = "";
            }
           
            $trstyle = "style='background-color:#FFFBE4; height:30px;'";
            $user_data = maybe_unserialize($result->ip);
            $user_ip = $user_data['ip'];
            
            if($user_ip == ""){
                $user_ip = __('IP Address not recorded', 'wplivechat');
            } else {
                $user_ip = "<a href='http://www.ip-adress.com/ip_tracer/" . $user_ip . "' title='".__('Whois for' ,'wplivechat')." ".$user_ip."'>".$user_ip."</a>";
            }                

            if (function_exists("wplc_return_browser_string")) { $browser = wplc_return_browser_string($user_data['user_agent']); } else { $browser = ""; $user_ip = "<em>Please <a href='./update-core.php'>udpate your pro version</a></em>"; }
            if (function_exists("wplc_return_browser_image")) { $browser_image = wplc_return_browser_image($browser,"16"); } else { $browser_image = ""; }
            
            global $wplc_basic_plugin_url;
            
            $trstyle = "";
            
            
            $table .= "
                <h3><i class=\"fa fa-user wplc_visitor_icon wplc_active\"></i>".$result->name."</h3>
                <div class='wplc_single_visitor' id='record_".$result->id."' $trstyle> 
                    <div class='wplc_chat_section section_1'>
                        <div class='wplc_user_image' id='chat_image_".$result->id."'>
                            <img src=\"//www.gravatar.com/avatar/".md5($result->email)."?s=100&d=mm\" />
                        </div>
                        <div class='wplc_user_meta_data'>
                            <div class='wplc_user_name' id='chat_name_".$result->id."'>
                                <h3>".$result->name."</h3>
                                ".$result->email."
                                <div class='wplc_chat_section'>
                                    <div class='wplc_agent_actions'>
                                        $actions
                                    </div>
                                </div>
                            </div>                                
                        </div>    
                    </div>
                    <div class='wplc_chat_section'>
                        <div class='admin_visitor_advanced_info'>
                            <strong>" . __("Site Info", "wplivechat") . "</strong>
                            <hr />
                            <span class='part1'>" . __("Chat initiated on:", "wplivechat") . "</span> <span class='part2'><a href='".$result->url."' target='_BLANK'>" . $result->url . "</a></span>
                        </div>

                        <div class='admin_visitor_advanced_info'>
                            <strong>" . __("Advanced Info", "wplivechat") . "</strong>
                            <hr />
                            <span class='part1'>" . __("Browser:", "wplivechat") . "</span><span class='part2'> $browser <img src='" . $wplc_basic_plugin_url . "/images/$browser_image' alt='$browser' title='$browser' /><br />
                            <span class='part1'>" . __("IP Address:", "wplivechat") . "</span><span class='part2'> ".$user_ip." 
                        </div>
                    </div>                    
                </div>
                    ";
            
            
//            $table .= "
//           
//            <div class='wplc_single_visitor' id='record_'".$result->id." $trstyle>                    
//                <div class='wplc_user_image' id='chat_image_".$result->id."'>
//                    <img src=\"//www.gravatar.com/avatar/".md5($result->email)."?s=120&d=mm\" />
//                </div>
//                <div class='wplc_user_meta_data'>
//                    <div class='wplc_user_name' id='chat_name_".$result->id."'>
//                        <h3>".$result->name."</h3>
//                    </div>
//                    <div class='wplc_user_email' id='chat_email_".$result->id."'>
//                        <p><a href='mailto:".$result->email."'>".$result->email."</a></p>
//                    </div>                                       
//                    <div class='wplc_actions' id='chat_action_".$result->id."'>
//                        $actions
//                    </div>
//                </div>    
//                <hr>
//                <div class='wplc_user_meta'>
//                    <h4>".__('Visitor Details:', 'wplivechat')."</h4>
//                    <div class='wplc_user_ip'>
//                        <img src='".$wplc_basic_plugin_url."/images/$browser_image' alt='$browser' title='$browser' /><a href='http://www.ip-adress.com/ip_tracer/".$user_ip."' target='_BLANK'>".$user_ip."</a>
//                    </div> 
//                </div>
//                <hr>
//                <div class='wplc_page_meta'>
//                    <h4>".__('Browsing the following page:', 'wplivechat')."</h4>
//                    <div class='wplc_current_page' id='chat_url_".$result->id."'>
//                        <a href='".$result->url."' target='_BLANK'>".$result->url."</a>
//                    </div>
//                </div>
//            </div>";

        }
        $table.= "</div>";
    } else {
        $table= "<p>".__("No visitors on-line at the moment","wplivechat")."</p>";
        
    }
    
    
    return $table;

}




// pro

function wplc_list_chats_pro($agent_id) {

    global $wpdb;
    global $wplc_tblname_chats;
    $wplc_c = 0;
    $results = $wpdb->get_results(
        "
	SELECT *
	FROM $wplc_tblname_chats
        WHERE `status` = 3 OR `status` = 2 OR `status` = 10
        ORDER BY `timestamp` ASC

	"
    );
    
//    $results = $wpdb->get_results(
//        "
//	SELECT *
//	FROM $wplc_tblname_chats
//        WHERE `status` = 7
//        ORDER BY `timestamp` ASC
//
//	"
//    );
    
    
    $table = "<div class='wplc_chats_container'>";    
            
    if (!$results) {
        $table.= "<p>".__("No chat sessions available at the moment","wplivechat")."</p>";
    } else {
        $table .= "<h2>".__('Active Chats', 'wplivechat')."</h2>";
        foreach ($results as $result) {
            // youre working here
            unset($trstyle);
            unset($actions);
            unset($icon);
            
            global $wplc_basic_plugin_url;
            $user_data = maybe_unserialize($result->ip);
            $user_ip = $user_data['ip'];
            if (function_exists("wplc_return_browser_string")) { $browser = wplc_return_browser_string($user_data['user_agent']); } else { $browser = ""; $user_ip = "<em>Please <a href='./update-core.php'>udpate your pro version</a></em>"; }
            if (function_exists("wplc_return_browser_image")) { $browser_image = wplc_return_browser_image($browser,"16"); } else { $browser_image = ""; }
            
            $wplc_c++;
            $aid = "";
            
            if(is_numeric($agent_id)){
                $aid = "&aid=".$agent_id;
            }
            
            if($user_ip == ""){
                $user_ip = __('IP Address not recorded', 'wplivechat');
            } else {
                $user_ip = "<a href='http://www.ip-adress.com/ip_tracer/" . $user_ip . "' title='".__('Whois for' ,'wplivechat')." ".$user_ip."'>".$user_ip."</a>";
            }
            
            if ($result->status == 2) {
                if(is_numeric($agent_id) or $agent_id === true){
                    $url = admin_url( 'admin.php?page=wplivechat-menu&action=ac&cid='.$result->id.$aid);
                    $actions = "<p><a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Accept Chat", "wplivechat")."</a></p>";
                    $trstyle = "style='background-color:#FFFBE4; height:30px;'";
                    $icon = "<i class=\"fa fa-phone wplc_pending\" title='".__('Incoming Chat', 'wplivechat')."' alt='".__('Incoming Chat', 'wplivechat')."'></i><div class='wplc_icon_message'>".__('You have an incoming chat.', 'wplivechat')."</div>";
                } else {
                    $actions = "<p></p>";
                    $trstyle = "style='background-color:#FFFBE4; height:30px;'";
                    $icon = "<i class=\"fa fa-times-circle wplc_closed\" title='".__('You must be a chat agent to answer chats', 'wplivechat')."' alt='".__('You must be a chat agent to answer chats', 'wplivechat')."'></i><div class='wplc_icon_message'>".__('You must be a chat agent to answer chats', 'wplivechat')."</div>";
                }
            }
            if ($result->status == 3) {
                if(is_numeric($agent_id) or $agent_id === true){
                    $url = admin_url( 'admin.php?page=wplivechat-menu&action=ac&cid='.$result->id.$aid);
                    $actions = "<p><a href=\"".$url."\" class=\"wplc_open_chat button button-primary\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Open Chat Window", "wplivechat")."</a></p>";
                    $trstyle = "style='background-color:#F7FCFE; height:30px;'";
                    $icon = "<i class=\"fa fa-check-circle wplc_active\" title='".__('Chat Active', 'wplivechat')."' alt='".__('Chat Active', 'wplivechat')."'></i><div class='wplc_icon_message'>".__('This chat is active', 'wplivechat')."</div>";                        
                    if(isset($result->agent_id) && is_numeric($agent_id) && $result->agent_id != $agent_id && $result->agent_id != 0){
                        $actions = "<p>".__("Chat has been answered by another agent", "wplivechat")."</p>";
                        $icon = "<i class=\"fa fa-times-circle wplc_closed\" title='".__('Chat answered by another agent', 'wplivechat')."' alt='".__('Chat answered by another agent', 'wplivechat')."'></i>";                        
                    }
                } else {
//                    $actions = "<a class=\"wplc_open_chat\" window-title=\"WP_Live_Chat_".$result->id."\">".__("Chat has been Accepted By Chat Agent ", "wplivechat")."</a>";
                    $actions = "";
                    $agent_details = "There is a chat agent (Another guy)";
                    $trstyle = "style='background-color:#F7FCFE; height:30px;'";     
                }
            }
            
            $trstyle = "";
            
            $table .= "
                <div class='wplc_single_chat' id='record_'".$result->id." $trstyle> 
                    <div class='wplc_chat_section section_1'>
                        <div class='wplc_user_image' id='chat_image_".$result->id."'>
                            <img src=\"//www.gravatar.com/avatar/".md5($result->email)."?s=60&d=mm\" />
                        </div>
                        <div class='wplc_user_meta_data'>
                            <div class='wplc_user_name' id='chat_name_".$result->id."'>
                                <h3>".$result->name.$icon."</h3>
                                <a href='mailto:".$result->email."' target='_BLANK'>".$result->email."</a>
                            </div>                                
                        </div>    
                    </div>
                    <div class='wplc_chat_section section_2'>
                        <div class='admin_visitor_advanced_info'>
                            <strong>" . __("Site Info", "wplivechat") . "</strong>
                            <hr />
                            <span class='part1'>" . __("Chat initiated on:", "wplivechat") . "</span> <span class='part2'> <a href='".$result->url."' target='_BLANK'>" . $result->url . "</a></span>
                        </div>

                        <div class='admin_visitor_advanced_info'>
                            <strong>" . __("Advanced Info", "wplivechat") . "</strong>
                            <hr />
                            <span class='part1'>" . __("Browser:", "wplivechat") . "</span><span class='part2'> $browser <img src='" . $wplc_basic_plugin_url . "/images/$browser_image' alt='$browser' title='$browser' /><br />
                            <span class='part1'>" . __("IP Address:", "wplivechat") . "</span><span class='part2'> ".$user_ip." 
                        </div>
                    </div>
                    <div class='wplc_chat_section section_3'>
                        <div class='wplc_agent_actions'>
                            $actions
                        </div>
                    </div>
                </div>
                    ";
        }
    }
    $table .= "</div>";

    return $table;
}

function wplc_send_offline_message($name,$email,$msg,$cid) {


    $subject = __("WP Live Chat Support - Offline Message from ", "wplivechat")."$name";
    $msg = __("Name", "wplivechat").": $name \n".__("Email", "wplivechat").": $email\n".__("Message", "wplivechat").": $msg\n\n".__("Via WP Live Chat Support", "wplivechat");

    wplc_mail($email,$name, $subject, $msg);    

}

function wplc_record_chat_msg_pro($from,$cid,$msg) {
    global $wpdb;
    global $wplc_tblname_msgs;

    if ($from == "1") {
        $fromname = wplc_return_chat_name($cid);
        $orig = '2';
    }
    else {
        $fromname = $_POST['admin_name'];
        $orig = '1';
    }

    if(function_exists('wplc_encrypt_msg')){
        $msg = wplc_encrypt_msg($msg);
    }

    global $wplc_version;
    $v_check = str_replace(".","",$wplc_version);
    if (intval($v_check) < 5014) { 
        $ins_array = array(
            'chat_sess_id' => $cid,
            'timestamp' => date("Y-m-d H:i:s"),
            'from' => $fromname,
            'msg' => $msg,
            'status' => 0,
            'originates' => $orig
        );
    } else {
        $ins_array = array(
            'chat_sess_id' => $cid,
            'timestamp' => date("Y-m-d H:i:s"),
            'msgfrom' => $fromname,
            'msg' => $msg,
            'status' => 0,
            'originates' => $orig
        );
    }

    $rows_affected = $wpdb->insert( $wplc_tblname_msgs, $ins_array );

    wplc_update_active_timestamp($cid);
    wplc_change_chat_status($cid,3);
    return true;
}


function wplc_return_from_name($user_id) {
        $user = get_user_by('id', $user_id);
        $pro_options = get_option("WPLC_PRO_SETTINGS");
            if (isset($pro_options['wplc_chat_name'])) {
                $user->display_name = $pro_options['wplc_chat_name'];
            }
        return $user->display_name;
}


function wplc_pro_notify_via_email() {
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    if (isset($wplc_pro_settings['wplc_pro_chat_email_address'])) { $email_address = $wplc_pro_settings['wplc_pro_chat_email_address']; } else { $email_address = ""; }
    if (!$email_address || $email_address == "") { $email_address = get_option('admin_email'); }
//    $chat_noti = $wplc_pro_settings['wplc_pro_chat_notification'];
    if (isset($wplc_pro_settings['wplc_pro_chat_notification']) && $wplc_pro_settings['wplc_pro_chat_notification'] == "yes") {
        $subject = __("Alert: Someone wants to chat with you on ", "wplivechat").get_option('blogname')."";
        $msg = __("Someone wants to chat with you on your website", "wplivechat")." ".get_option('blogname').") \n\n".__("Log in", "wplivechat").": ".get_option('home')."/wp-login.php";
        //$headers = 'From: '.$email_address.' <'.$email_address.'>';
        //mail($email_address, $subject, $msg);
        wplcmail_pro($email_address,"WP Live Chat Support", $subject, $msg);
    }
    return true;
}



function wplcmail_pro($reply_to,$reply_to_name,$subject,$msg) {
    
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    
    if(isset($wplc_pro_settings['wplc_pro_chat_email_address'])){
        $email_address = $wplc_pro_settings['wplc_pro_chat_email_address'];
    } else {
        $email_address = get_option('admin_email');
    }
    
    $email_address = explode(',', $email_address);  
    
    if(get_option("wplc_mail_type") == "wp_mail" || !get_option('wplc_mail_type')){
        $headers[] = 'Content-type: text/html';
        $headers[] = 'Reply-To: '.$reply_to_name.'<'.$reply_to.'>';
        if($email_address){
            foreach($email_address as $email){
                /* Send offline message to each email address */
                $overbody = apply_filters("wplc_filter_mail_body",$subject,$msg);
                if (!wp_mail($email, $subject, $overbody, $headers)) {
                    $handle = fopen("wp_livechat_error_log.txt", 'a');
                    $error = date("Y-m-d H:i:s") . " WP-Mail Failed to send \n";
                    @fwrite($handle, $error);
                }
            }
        }
//        $to = $wplc_pro_settings['wplc_pro_chat_email_address'];
        return;
    } else {
    
        global $phpmailer;
     
        // (Re)create it, if it's gone missing
        if ( ! ( $phpmailer instanceof PHPMailer ) ) {
            require_once ABSPATH . WPINC . '/class-phpmailer.php';
            require_once ABSPATH . WPINC . '/class-smtp.php';
            $mail = new PHPMailer( true );
        }


        $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
        $host = get_option('wplc_mail_host');
        $port = get_option('wplc_mail_port');
        $username = get_option("wplc_mail_username");
        $password = get_option("wplc_mail_password");
        if($host && $port && $username && $password){

            //Tell PHPMailer to use SMTP
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
            $mail->setFrom($reply_to, $reply_to_name);
            //Set who the message is to be sent to
            $mail->addAddress($wplc_pro_settings['wplc_pro_chat_email_address']);
            //Set the subject line
            $mail->Subject = $subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $body = apply_filters("wplc_filter_mail_body",$subject,$msg);
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

function wplc_mail_body($msg){
    $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    $body .= '<html xmlns="http://www.w3.org/1999/xhtml">';
    $body .= '<head>';
    $body .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
    $body .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $body .= '</head>';
    $body .= '<body>';
    $body .= '<p>';
    $body .= $msg;
    $body .= '</p>';
    $body .= '</body>';
    $body .= '</html>';
    return $body;
}
/* fuunction wplc_mail() deprecated in pro version 5.1.00 - added to basic version 5.1.00 */
function wplc_mail($reply_to,$reply_to_name,$subject,$msg) {
    
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    $wplc_settings = get_option("WPLC_SETTINGS");
    
    if(isset($wplc_settings['wplc_pro_chat_email_address'])){
        $email_address = $wplc_settings['wplc_pro_chat_email_address'];
    } else {
        $email_address = get_option('admin_email');
    }
    
    $email_address = explode(',', $email_address);  
    
    if(get_option("wplc_mail_type") == "wp_mail"){
        $headers[] = 'Content-type: text/html';
        $headers[] = 'Reply-To: '.$reply_to_name.'<'.$reply_to.'>';
        if($email_address){
            foreach($email_address as $email){
                /* Send offline message to each email address */
                if (!wp_mail($email, $subject, $msg, $headers)) {
                    $handle = fopen("wp_livechat_error_log.txt", 'a');
                    $error = date("Y-m-d H:i:s") . " WP-Mail Failed to send \n";
                    @fwrite($handle, $error);
                }
            }
        }
//        $to = $wplc_pro_settings['wplc_pro_chat_email_address'];
        return;
    } else {
    

        global $phpmailer;
 
        // (Re)create it, if it's gone missing
        if ( ! ( $phpmailer instanceof PHPMailer ) ) {
            require_once ABSPATH . WPINC . '/class-phpmailer.php';
            require_once ABSPATH . WPINC . '/class-smtp.php';
            $mail = new PHPMailer( true );
        }


        $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
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
            $mail->setFrom($reply_to, $reply_to_name);
            //Set who the message is to be sent to
            $mail->addAddress($wplc_settings['wplc_pro_chat_email_address']);
            //Set the subject line
            $mail->Subject = $subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $body = wplc_mail_body($msg);
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
function wplc_delete_history(){
    global $wpdb;
    global $wplc_tblname_chats;
    $wpdb->query("TRUNCATE TABLE $wplc_tblname_chats");
}
function wplc_pro_get_admin_picture(){
    $pro_settings = get_option("WPLC_PRO_SETTINGS");
    if($pro_settings['wplc_chat_pic']){
        return urldecode($pro_settings['wplc_chat_pic']);
    }
}
function wplc_get_visitors_ids(){
    global $wpdb;
    global $wplc_tblname_chats;
    $sql = "SELECT `id` FROM `$wplc_tblname_chats` WHERE `status` = 5 ORDER BY `timestamp` DESC";
    $results = $wpdb->get_results($sql);
    if($results){
        return $results;
    } else {
        return false;
    }
}


///// Multi Agents functions

function wplc_ma_action_callback(){
    $check = check_ajax_referer( 'wplc', 'security' );
    
    if($check == 1){
        
    }
    die();
}

function wplc_ma_set_user_as_agent( $user_id ) {
    
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
}


function wplc_ma_custom_user_profile_fields($user) {
    $wplc_pro_settings = get_option('WPLC_PRO_SETTINGS');
    if(isset($wplc_pro_settings['wplc_make_agent']) && $wplc_pro_settings['wplc_make_agent'] == 1){
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
}


function wplc_set_admin_to_access_chat() {

    
    $admins = get_role( 'administrator' );
    //$admins->add_cap( 'wplc_chat_agent' ); 

}
function wplc_ma_set_agents_online($user_id){
    
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

function wplc_ma_remove_agents_online($user_id){
    delete_user_meta($user_id, "wplc_chat_agent_online");
}

function wplc_ma_agent_logout(){
    $user_id = get_current_user_id();
//    $user_array = unserialize(get_transient('wplc_online_agents'));
//    $key = array_search($user_id, $user_array);
//    unset($user_array[$key]);
//    set_transient('wplc_online_agents', serialize($user_array), 20);
    delete_user_meta($user_id, "wplc_chat_agent_online");
}
function wplc_ma_is_agent_online(){
    $check = get_users(array(
        'meta_key'=> 'wplc_chat_agent_online',
    ));
    if($check){
        return true;
    } else {
        return false;
    }
}
function wplc_ma_total_agents_online(){
    $users = get_users(array(
        'meta_key'=> 'wplc_chat_agent_online',
    ));
    return count($users);
}
function wplc_ma_online_agents(){ ?>
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
    if(wplc_ma_is_agent_online()){
        $online_now = wplc_ma_total_agents_online();
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
    if($online_now > 0){
        $user_array =  get_users(array(
            'meta_key'=> 'wplc_chat_agent_online',
        ));
        foreach($user_array as $user){
            
            $wp_admin_bar->add_menu( array(
                'id' => 'wplc_user_online_'.$user->ID,
                'parent' => 'wplc_ma_online_agents',
                'title' => $user->display_name,
                'href' => false,
            ) );
        }
    }
}
function wplc_ma_head(){
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");

    if(!isset($wplc_pro_settings['wplc_auto_online'])) {
    ?>
    <script>
        jQuery(document).ready(function() {
            /* Going online functionality used to be here */
            var wplc_ma_set_transient = null;

            wplc_ma_set_transient = setInterval(function (){wplc_ma_update_agent_transient();}, 60000);
            wplc_ma_update_agent_transient();

            function wplc_ma_update_agent_transient() {
                var data = {
                    action: 'wplc_ma_set_transient',
                    security: wplc_admin_strings.nonce,
                    user_id:  wplc_admin_strings.user_id
                };
                jQuery.post(ajaxurl, data, function(response) {
                });
            }
        });
    </script>
    <?php
    }
}
function wplc_ma_update_agent_id($cid, $aid){
    global $wpdb;
    global $wplc_tblname_chats;
    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `id` = '$cid'";
    $result = $wpdb->get_row($sql); 
    if($result->status != 3){
        $update = "UPDATE `$wplc_tblname_chats` SET `agent_id` = '$aid' WHERE `id` = '$cid'";
        $wpdb->query($update);
    }
}

function wplc_ma_check_if_user_is_agent(){
    $user_id = get_current_user_id();
    if (esc_attr(get_the_author_meta('wplc_ma_agent', $user_id ) ) == "1"){
        return $user_id;
    } else {
        return "not_user_agent";
    }
}
function wplc_ma_check_if_chat_answered_by_other_agent($cid, $aid){
    global $wpdb;
    global $wplc_tblname_chats;
    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `id` = '$cid'";
    $result = $wpdb->get_row($sql); 
    if(intval($result->agent_id) == intval($aid)){
        return false;
    } else {
        return true;
    }
}

/* deprecated in 5.1.00 - moved to basic version 5.1.00 */
function wplc_pro_admin_display_offline_messages() {

    global $wpdb;
    global $wplc_tblname_offline_msgs;

    echo "<form method='POST'>
        <table class=\"wp-list-table widefat fixed \" cellspacing=\"0\">
            <thead>
                <tr>
                    <th class='manage-column column-id'><span>" . __("Date", "wplivechat") . "</span></th>
                    <th scope='col' id='wplc_name_colum' class='manage-column column-id'><span>" . __("Name", "wplivechat") . "</span></th>
                    <th scope='col' id='wplc_email_colum' class='manage-column column-id'>" . __("Email", "wplivechat") . "</th>
                    <th scope='col' id='wplc_message_colum' class='manage-column column-id'>" . __("Message", "wplivechat") . "</th>                    
                </tr>
            </thead>
            <tbody id=\"the-list\" class='list:wp_list_text_link'>";

    $sql = "
            SELECT *
            FROM $wplc_tblname_offline_msgs                    
            ORDER BY `timestamp` DESC
                ";

    $results = $wpdb->get_results($sql);

    if (!$results) {
        echo "<tr><td></td><td>" . __("You have not received any offline messages.", "wplivechat") . "</td></tr>";
    } else {
        foreach ($results as $result) {
            echo "<tr id=\"record_" . $result->id . "\">";
            echo "<td class='chat_id column-chat_d'>" . $result->timestamp . "</td>";
            echo "<td class='chat_name column_chat_name' id='chat_name_" . $result->id . "'><img src=\"//www.gravatar.com/avatar/" . md5($result->email) . "?s=30\" /> " . $result->name . "</td>";
            echo "<td class='chat_email column_chat_email' id='chat_email_" . $result->id . "'><a href='mailto:" . $result->email . "' title='Email " . ".$result->email." . "'>" . $result->email . "</a></td>";
            echo "<td class='chat_name column_chat_url' id='chat_url_" . $result->id . "'>" . $result->message . "</td>";            
            echo "</tr>";
        }
    }

    echo "
            </tbody>
        </table></form>";
}

/* deprecated from 5.1.00 - moved to basic version */
function wplc_pro_store_offline_message($name, $email, $message){
    global $wpdb;
    global $wplc_tblname_offline_msgs;
    
    $wplc_settings = get_option('WPLC_SETTINGS');
        
    if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1){
        $offline_ip_address = $_SERVER['REMOTE_ADDR'];
    } else {
        $offline_ip_address = "";
    }
    $ins_array = array(
        'timestamp' => current_time('mysql'),
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'ip' => $offline_ip_address,
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
    );
    
    $rows_affected = $wpdb->insert( $wplc_tblname_offline_msgs, $ins_array );
}

/**
 * Initiate a chat with a user
 * @param  string $name    Name of the user
 * @param  string $email   Email of the user
 * @param  int    $cid     Chat ID
 * @param  string $session Session variable
 * @return int             Returns the CHAT ID
 */
function wplc_initiate_chat($name,$email,$cid = null,$session) {

    global $wpdb;
    global $wplc_tblname_chats;

    do_action("wplc_hook_initiate_chat",array("cid" => $cid, "name" => $name, "email" => $email));
  
    if (function_exists("wplc_list_chats_pro")) { /* check if functions-pro is around */
        wplc_pro_notify_via_email();
    }

    $wplc_settings = get_option('WPLC_SETTINGS');
        
    if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1){
        $user_data = array(
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        );
        $wplc_ce_ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $user_data = array(
            'ip' => "",
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        );
        $wplc_ce_ip = null;
    }

    /* TO DO
    * Put hooks here for the CE add-on
    */
    
    if(function_exists('wplc_ce_activate')){
        /* Log the chat for statistical purposes as well */
        if(function_exists('wplc_ce_record_initial_chat')){
            wplc_ce_record_initial_chat($name, $email, $cid, $wplc_ce_ip, $_SERVER['HTTP_REFERER']);
        }                    
    }
    
    if ($cid != null) { /* change from a visitor to a chat */                
        
        
        $wpdb->update( 
            $wplc_tblname_chats, 
            array( 
                'status' => 2,
                'timestamp' => current_time('mysql'),
                'name' => $name,
                'email' => $email,
                'session' => $session,
                'ip' => maybe_serialize($user_data),
                'url' => $_SERVER['HTTP_REFERER'],
                'last_active_timestamp' => current_time('mysql')
            ), 
            array('id' => $cid), 
            array( 
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ), 
            array('%d') 
        );
        
        return $cid;
    }
    else { 
        
        
        $wpdb->insert( 
            $wplc_tblname_chats, 
            array( 
                'status' => '2', 
                'timestamp' => current_time('mysql'),
                'name' => $name,
                'email' => $email,
                'session' => $session,
                'ip' => maybe_serialize($user_data),
                'url' => $_SERVER['HTTP_REFERER'],
                'last_active_timestamp' => current_time('mysql')
            ), 
            array( 
                '%s', 
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ) 
        );
        
        
        $lastid = $wpdb->insert_id;
        return $lastid;
    }

}

function wplc_return_animations(){
    
    $wplc_pro_options = get_option('WPLC_PRO_SETTINGS');
    
    $wplc_settings = get_option("WPLC_SETTINGS");
    
    if ($wplc_settings["wplc_settings_align"] == 1) {
        $original_pos = "bottom_left";
        //$wplc_box_align = "left:100px; bottom:0px;";
        $wplc_box_align = "bottom:0px;";
    } else if ($wplc_settings["wplc_settings_align"] == 2) {
        $original_pos = "bottom_right";
        //$wplc_box_align = "right:100px; bottom:0px;";
        $wplc_box_align = "bottom:0px;";
    } else if ($wplc_settings["wplc_settings_align"] == 3) {
        $original_pos = "left";
//        $wplc_box_align = "left:0; bottom:100px;";
        $wplc_box_align = " bottom:100px;";
        $wplc_class = "wplc_left";
    } else if ($wplc_settings["wplc_settings_align"] == 4) {
        $original_pos = "right";
//        $wplc_box_align = "right:0; bottom:100px;";
        $wplc_box_align = "bottom:100px;";
        $wplc_class = "wplc_right";
    }

    $animation_data = array();

    if(isset($wplc_pro_options['wplc_animation']) && $wplc_pro_options['wplc_animation'] == 'animation-1'){

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: -350px; right: 100px;';
            $wplc_animation = 'animation-1';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: -350px; left: 100px;';
            $wplc_animation = 'animation-1';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: -350px; left: 0px;';
            $wplc_box_align = "left:0; bottom:100px;";
            $wplc_animation = 'animation-1';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: -350px; right: 0px;';
            $wplc_animation = 'animation-1';
            $wplc_box_align = "right:0; bottom:100px;";
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else if (isset($wplc_pro_options['wplc_animation']) && $wplc_pro_options['wplc_animation'] == 'animation-2'){

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0px; right: -300px;';
            $wplc_animation = 'animation-2-br';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: -300px;';
            $wplc_animation = 'animation-2-bl';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: -999px;';
            $wplc_animation = 'animation-2-l';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 0px; right: -999px;';               
            $wplc_animation = 'animation-2-r';
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else if (isset($wplc_pro_options['wplc_animation']) && $wplc_pro_options['wplc_animation'] == 'animation-3'){

        $wplc_animation = 'animation-3';

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0; right: 100px; display: none;';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: 100px; display: none;';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 100px; left: 0px; display: none;';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 100px; right: 0px; display: none;';
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else if (isset($wplc_pro_options['wplc_animation']) && $wplc_pro_options['wplc_animation'] == 'animation-4'){
        // Dont use an animation

        $wplc_animation = "animation-4";

        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0; right: 100px; display: none;';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: 100px; display: none;';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 100px; left: 0px; display: none;';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 100px; right: 0px; display: none;';
        }

        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;

    } else {
        
        if($original_pos == 'bottom_right'){
            $wplc_starting_point = 'margin-bottom: 0; right: 100px; display: none;';
        } else if ($original_pos == 'bottom_left'){
            $wplc_starting_point = 'margin-bottom: 0px; left: 100px; display: none;';
        } else if ($original_pos == 'left'){
            $wplc_starting_point = 'margin-bottom: 100px; left: 0px; display: none;';
        } else if ($original_pos == 'right'){
            $wplc_starting_point = 'margin-bottom: 100px; right: 0px; display: none;';
        }
        
        $wplc_animation = 'none';
        
        $animation_data['animation'] = $wplc_animation;
        $animation_data['starting_point'] = $wplc_starting_point;
        $animation_data['box_align'] =  $wplc_box_align;
    }

    return $animation_data;
}


/**
 * Decides whether or not to show the chat box based on the include/exlcude pages in the settings page
 * @return [type] [description]
 */
function wplc_display_chat_contents(){

    if (in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
         return false;
    }
    $post_id = get_the_ID();
    if (!$post_id || $post_id === NULL) { 
        $url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $post_id = url_to_postid($url); 
    }
    $show_chat_contents = 0;
    if (!$post_id) { 
        return true; 
        $show_chat_contents = 1; 
        /* we cant get the page ID so just allow it - the JS should handle it from now */
    }

    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    
    if (isset($wplc_pro_settings['wplc_include_on_pages'])) {
        $include_on_pages = $wplc_pro_settings['wplc_include_on_pages'];

    } else {
        $include_on_pages = "";
    }
    if (isset($wplc_pro_settings['wplc_exclude_from_pages'])) {
        $exclude_from_pages = $wplc_pro_settings['wplc_exclude_from_pages'];
    } else {
        $exclude_from_pages = "";
    }

    if($include_on_pages == "" && $exclude_from_pages == ""){

        $show_chat_contents = 1;

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
                $show_chat_contents = true;
            } else {
                /* Do not show here */
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
                $show_chat_contents = true;
            } else {
                
            }
            
        }


        
    }

    return $show_chat_contents;
}

function wplc_hide_chat_when_offline(){
    $wplc_settings = get_option("WPLC_SETTINGS");

    $hide_chat = 0;
    if (isset($wplc_settings['wplc_hide_when_offline']) && $wplc_settings['wplc_hide_when_offline'] == 1) {
        /* Hide the window when its offline */
        $wplc_is_chat_online = wplc_ma_is_agent_online();
        if (!$wplc_is_chat_online) {
            $hide_chat++;
        }
    } else {
        $hide_chat = 0;
    }
    return $hide_chat;
}

function wplc_does_ce_exist(){
    $exists = false;
    if(function_exists('wplc_ce_activate')){
        $exists = true;
    }
    return $exists;
}

function wplc_use_external_server($api_key, $status){
    
    $url = 'https://ccplugins.co/wplc-api/v2/functions.php';

    $response = wp_remote_post($url, array(
        'method' => 'POST',
        'body' => array(
            'action' => 'api_validation',
            'domain' => get_option('siteurl'),
            'api_key' => get_option('wplc_api_key'),
            'subscriber' => true
        ),
    ));

    $data = json_decode($response['body']);
    if($data->status == 1){
        if($status == '1'){
            update_option('wplc_use_external_server', 1);
            echo 1;
        } else {
            update_option('wplc_use_external_server', 0);
            echo 0;
        }
    } else {
        update_option('wplc_use_external_server', 0);
        echo 0;
    }
}

function wplc_return_user_permissions_dropdown($name){
    $ret = "";
    $ret .= "<select name='$name'>";
    $ret .= "<option value='manage_options'>".__('Administrator', 'wplivechat')."</option>";
    $ret .= "<option value='edit_pages'>".__('Editor', 'wplivechat')."</option>";
    $ret .= "<option value='publish_posts'>".__('Author', 'wplivechat')."</option>";
    $ret .= "<option value='edit_posts'>".__('Contributor', 'wplivechat')."</option>";
    $ret .= "<option value='read'>".__('Subscriber', 'wplivechat')."</option>";
    $ret .= "</select>";
    
    return $ret;
}

function wplc_encrypt_msg($plaintext){
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    if(isset($wplc_pro_settings['wplc_enable_encryption']) && $wplc_pro_settings['wplc_enable_encryption'] == 1){
        $api_key = get_option('wplc_api_key');
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
function wplc_decrypt_msg($input){
    
        $messages = maybe_unserialize($input);


        if(is_array($messages)){
            if($messages['e'] == 1){
                /* This message was encrypted */
                $api_key = get_option('wplc_api_key');
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

function wplc_convert_to_csv($in, $out, $del){
    
    $f = fopen('php://memory', 'w');

    foreach ($in as $line) {
        wplc_fputcsv_eol($f, $line, $del, "\r\n");
    }

    fseek($f, 0);

    header('Content-Type: application/csv');
    
    header('Content-Disposition: attachement; filename="' . $out . '";');

    fpassthru($f);
}
function wplc_fputcsv_eol($fp, $array, $del, $eol) {
  fputcsv($fp, $array,$del);
  if("\n\r" != $eol && 0 === fseek($fp, -1, SEEK_CUR)) {
    fwrite($fp, $eol);
  }
}

function wplc_admin_pro_download_history($type, $cid){
  
    global $wpdb;
    global $wplc_tblname_msgs;
    
    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_msgs
        WHERE `chat_sess_id` = '$cid'
        ORDER BY `timestamp` ASC
        LIMIT 0, 100
        "
    );

    $fields[] = array(
        'id' => __('Chat ID', 'wplivechat'),
        'from' => __('From', 'wplivechat'),
        'msg' => __('Message', 'wplivechat'),
        'time' => __('Timestamp', 'wplivechat'),
        'orig' => __('Origin', 'wplivechat'),
    );

    foreach ($results as $result => $key) {

        global $wplc_version;
        $v_check = str_replace(".","",$wplc_version);
        if (intval($v_check) < 5014) { $from = $key->from; } else { $from = $key->msgfrom; }



        if($key->originates == 2){
            $user = __('user', 'wplivechat');
        } else {
            $user = __('agent', 'wplivechat');
        }
        
        $fields[] = array(
            'id' => $key->chat_sess_id,
            'from' => $from,
            'msg' => wplc_decrypt_msg($key->msg),
            'time' => $key->timestamp,
            'orig' => $user,
        );
    }      
    
    ob_end_clean();
    
    wplc_convert_to_csv($fields, 'live_chat_history_'.$cid.'.csv', ',');
    
    exit();
}
