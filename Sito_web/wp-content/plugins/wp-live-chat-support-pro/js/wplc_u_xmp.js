jQuery(document).ready(function() {
    wplc_cid = jQuery.cookie('wplc_cid');
    
    wplc_check_hide_cookie = jQuery.cookie('wplc_hide');
    wplc_check_minimize_cookie = jQuery.cookie('wplc_minimize');
    wplc_chat_status = jQuery.cookie('wplc_chat_status');
    wplc_cookie_name = jQuery.cookie('wplc_name');
    wplc_cookie_email = jQuery.cookie('wplc_email');
    
    var data = {
        action: 'wplc_call_to_xmp_server_visitor',
        security: wplc_nonce,
        cid:wplc_cid,
        wplc_name: wplc_cookie_name,
        wplc_email: wplc_cookie_email,
        status:wplc_chat_status,
        wplcsession:wplc_session_variable
    };
    // ajax long polling function
    wplc_call_to_xmp_server_chat(data);

 
    var wplc_run = true;
    function wplc_call_to_xmp_server_chat(data) {
        jQuery.ajax({
            url: wplc_ajaxurl_xmp,
            data:data,
            type:"POST",
            success: function(response) {
                if(response){
                    console.log(response);
                    response = JSON.parse(response);
                    
                }
            },
            error: function(jqXHR, exception) {
                    if (jqXHR.status == 404) {
                        console.log('Requested page not found. [404]');
			wplc_run = false;
                    } else if (jqXHR.status == 500) {
                        console.log('Internal Server Error [500].');
			wplc_run = false;
                    } else if (exception === 'parsererror') {
                        console.log('Requested JSON parse failed.');
			wplc_run = false;
                    } else if (exception === 'abort') {
                        console.log('Ajax request aborted.');
			wplc_run = false;
                    } else {
                        console.log('Uncaught Error.\n' + jqXHR.responseText);
			wplc_run = false;
                    }
                },
                complete: function(response){
                    //console.log(wplc_run);
                    if (wplc_run) { 
                        setTimeout(wplc_call_to_xmp_server_chat(data), 1500);
                    }
            },
            timeout: 120000
        });
    };  
    
    
    

    jQuery("#wplc_send_msg").on("click", function() {
        var wplc_cid = jQuery("#wplc_cid").val();
        var wplc_chat = wplc_strip(document.getElementById('wplc_chatmsg').value);
        var wplc_name = jQuery("#wplc_name").val();
        if (typeof wplc_name == "undefined" || wplc_name == null || wplc_name == "") {
            wplc_name = jQuery.cookie('wplc_name');
        }
        var data = {
                action: 'wplc_user_send_xmp',
                security: wplc_nonce,
                cid: wplc_cid,
                msg: wplc_chat
        };
        jQuery.post(wplc_ajaxurl_xmp, data, function(response) {
                console.log('XMP response: '+response);
        });


    });

    
    });