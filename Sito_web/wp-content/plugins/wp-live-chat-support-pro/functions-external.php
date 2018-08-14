<?php
$url = 'https://ccplugins.co/wplc-api/v2/functions.php';

function wplc_change_chat_status_ex($id, $status, $domain = false){
    global $url;
    $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'body' => array( 
                'action' => 'update_chat_status', 
                'domain' => $domain,
                'status' => $status,
                'id' => $id
            ),
        )
    );
    return $response['body'];
}

function wplc_pro_draw_chat_area_ex($cid){
    global $url;
    $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'body' => array( 
                'action' => 'draw_chat_area', 
                'cid' => $cid
            ),
        )
    );
    return $response['body'];
}

function wplc_ma_update_agent_id_ex($cid, $aid){
    global $url;
    $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'body' => array( 
                'action' => 'update_agent_id', 
                'cid' => $cid, 
                'aid' => $aid
            ),
        )
    );
    return $response['body'];
}

function wplc_return_chat_messages_ex($cid){
    global $url;
    $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'body' => array( 
                'action' => 'return_chat_messages', 
                'cid' => $cid
            ),
        )
    );
    return $response['body'];
}

function wplc_pro_admin_display_history_ex(){
    global $url;
    $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'body' => array( 
                'action' => 'admin_display_history',
                'url' => admin_url('admin.php?page=wplivechat-menu&action=history&cid='),
                'domain' => get_option('siteurl'),
                'api' => get_option('wplc_api_key')
            )            
        )
    );
    return $response['body'];

}

function wplc_admin_display_missed_chats_ex(){
    global $url;
    $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'body' => array( 
                'action' => 'display_missed_chats',
                'domain' => get_option('siteurl'),
                'api' => get_option('wplc_api_key')
            )            
        )
    );
    return $response['body'];
}

function wplc_pro_admin_display_offline_messages_ex(){
    global $url;
    $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'body' => array( 
                'action' => 'display_offline_messages',
                'domain' => get_option('siteurl'),
                'api' => get_option('wplc_api_key')
            )            
        )
    );
    return $response['body'];
}