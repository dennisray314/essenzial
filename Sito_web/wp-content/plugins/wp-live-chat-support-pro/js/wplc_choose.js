
jQuery( document ).ready(function() {

    var wplc_agent_status = jQuery("#wplc_agent_status").attr('checked');

    if(wplc_agent_status === 'checked'){
        jQuery("#wplc_agent_status_text").html(wplc_choose_admin_strings.accepting_chats);
    } else {
        jQuery("#wplc_agent_status_text").html(wplc_choose_admin_strings.not_accepting_chats);
    }



    function wplc_ma_update_agent_transient(data) {
        jQuery.post(ajaxurl, data, function(response) {
            if(response){
                window.location.reload();
            }
        });
    }

    /* Make sure switchery has been loaded on this page */
    if(typeof Switchery !== 'undefined'){
        var wplc_switchery_element = document.querySelector('.wplc_switchery');
        /* Make sure that the switch is being displayed */
        if(wplc_switchery_element !== null){
        
            var wplc_switchery_init = new Switchery(wplc_switchery_element, { color: '#00B344', secondaryColor: '#D91600' });

            var changeCheckbox = document.querySelector('#wplc_agent_status');

            changeCheckbox.onchange = function () {
            
                var wplc_accepting_chats = jQuery(this).attr('checked');

                if(wplc_accepting_chats === 'checked'){
                    jQuery("#wplc_agent_status_text").html(wplc_choose_admin_strings.accepting_chats);
                    var data = {
                        action: 'wplc_choose_accepting',
                        security: wplc_admin_strings.nonce,
                        user_id:  wplc_admin_strings.user_id
                    };
                    wplc_ma_update_agent_transient(data);
                    
                } else {
                    jQuery("#wplc_agent_status_text").html(wplc_choose_admin_strings.not_accepting_chats);
                    var data = {
                        action: 'wplc_choose_not_accepting',
                        security: wplc_admin_strings.nonce,
                        user_id:  wplc_admin_strings.user_id
                    };
                    wplc_ma_update_agent_transient(data);
                    
                }
            };
        }             
    }

    });