var wplc_searchTimeout;
var wplc_is_typing = false;


jQuery(document).on("wplc_animation_done", function(e) {
	jQuery("#nifty_file_input").on("change", function(evt){       
        var file = this.files[0]; //Last file in array
        niftyShareFile(file,'#nifty_attach_fail_icon', '#nifty_attach_success_icon', '#nifty_attach_uploading_icon',  "#nifty_select_file");    
        evt.stopImmediatePropagation(); 
    });

  jQuery('.nifty_rating_icon').click(function(evt){
      jQuery('.nifty_rating_icon').removeClass('wplc-color-1');
      jQuery(this).addClass('wplc-color-1');
  });
  jQuery("#nifty_rating_pos").click(function(evt){
      jQuery("#nifty_rating_thanks").hide();
      jQuery("#nifty_ratings_form").fadeIn();
      jQuery("#nifty_rating_button").attr("nifty-rating", "1");

      evt.stopImmediatePropagation(); 
  });
  jQuery("#nifty_rating_neg").click(function(evt){
      jQuery("#nifty_rating_thanks").hide();
      jQuery("#nifty_ratings_form").fadeIn();
      jQuery("#nifty_rating_button").attr("nifty-rating", "0");

      evt.stopImmediatePropagation(); 
  });
  jQuery("#nifty_rating_button").click(function(evt){
      var nifty_rating = jQuery(this).attr("nifty-rating");
      var nifty_comment = jQuery("#nifty_ratings_comment").val() !== "" ? jQuery("#nifty_ratings_comment").val() : "No Comment...";
      jQuery("#nifty_ratings_form").hide();
      jQuery("#nifty_recording").fadeIn();

      var formData = new FormData();

      formData.append('action', 'wplc_record_chat_rating');
      formData.append('cid', Cookies.get('wplc_cid'));
      formData.append('rating', nifty_rating);
      formData.append('comment', nifty_comment);
      formData.append('security', wplc_nonce );
      formData.append('update_chat_rating', "1" );
      formData.append('wplc_extra_data[domain]', wplc_extra_data['domain'] );
      formData.append('wplc_extra_data[api_key]', wplc_extra_data['api_key'] );

      jQuery.ajax({
             url : wplc_ajaxurl,
             type : 'POST',
             data : formData,
             cache: false,
             processData: false, 
             contentType: false, 
             success : function(data) {    
                jQuery("#nifty_recording").fadeOut();
                jQuery("#nifty_rating_thanks").fadeIn();
                // console.log(data);
             },
             error : function (){
                jQuery("#nifty_recording").fadeOut();
                jQuery("#nifty_rating_thanks").fadeIn();
             }
      });

      evt.stopImmediatePropagation(); 
  });
});

jQuery(document).ready(function() { 

  jQuery("body").on("change", "#wplc_user_selected_department", function(){
    if(wplc_extra_data !== "undefined"){
      wplc_extra_data['wplc_user_selected_department'] = jQuery(this).val();
    }
  });

	jQuery("body").on("keydown","#wplc_chatmsg", function(e) {
    if(typeof wplc_node_sockets_ready === "undefined" || wplc_node_sockets_ready === false){
		  if (wplc_misc_strings.typing_enabled === "1") {
  	  		if (e.which <= 90 && e.which >= 48) {
  				if (wplc_is_typing) { 

  					wplc_renew_typing();
  					return; /* user already typing */
  				}
  				wplc_is_typing = true;
  				
  		        wplc_searchTimeout = setTimeout(wplc_clear_typing, 3000);
  		        wplc_cid = Cookies.get('wplc_cid');
  		        wplc_usertyping('user',Math.floor(Date.now() / 1000),wplc_cid);
  		    }
  		}
    }
  });

	jQuery("body").on("click", "#wplc_send_msg", function() {
		if (wplc_misc_strings.typing_enabled === "1") {
			if (wplc_is_typing) { wplc_clear_typing(); }
		}
	});

    function wplc_renew_typing() {
    	clearTimeout(wplc_searchTimeout);
    	wplc_searchTimeout = setTimeout(wplc_clear_typing, 3000);
    }
    function wplc_clear_typing() {
    	wplc_is_typing = false;
    	clearTimeout(wplc_searchTimeout);
	    wplc_cid = Cookies.get('wplc_cid');
        wplc_usertyping('user',0,wplc_cid);
    }
    function wplc_usertyping(wplc_typing_user,wplc_typing_type,wplc_typing_cid) {
	    
      if (typeof wplc_cid !== "undefined" && wplc_cid !== null) { 
        var data = {
                action: 'wplc_typing',
                security: wplc_nonce,
                user: wplc_typing_user,
                type: wplc_typing_type,
                cid: wplc_typing_cid,
                wplc_extra_data:wplc_extra_data
        };

        if (typeof wplc_restapi_enabled !== "undefined" && wplc_restapi_enabled === '1' && typeof wplc_using_cloud === "undefined") {
          data.security = (typeof wplc_restapi_token !== "undefined" ? wplc_restapi_token : false);
          jQuery.post(wplc_restapi_endpoint+"/typing/", data, function(response) {});
        } else {
          jQuery.post(wplc_ajaxurl, data, function(response) {});
        }
        
	    } else {
	       /* no cid? */
	    }
    }




    jQuery(document).on( "wplc_user_chat_loop", function( e ) {
      if(typeof wplc_node_sockets_ready === "undefined" || wplc_node_sockets_ready === false){
          if (wplc_misc_strings.typing_enabled === "1") {
              wplc_cid = Cookies.get('wplc_cid');
              if (typeof e.response['typing'] === "undefined") {
                  jQuery("#wplc_user_typing").fadeOut("slow").remove();
              }
              if (e.response['status'] === 8) {
                  jQuery('#nifty_text_editor_holder').css('display', 'none');
                  jQuery('#nifty_file_holder').css('display', 'none');
              }
              if (e.response['typing'] === "1") {
                  if (jQuery("#wplc_user_typing").length>0) { } else {
                if(typeof wplc_agent_name !== "undefined" && typeof wplc_localized_string_is_typing !== "undefined"){
                  jQuery(".typing_indicator").html("<span id='wplc_user_typing'>"+ wplc_localized_string_is_typing + "</span>");
                  jQuery(".typing_indicator").addClass("typing_indicator_active");
                } else {
                  /* Backwards compat */
  		        	  jQuery("#wplc_chatbox").append("<img id='wplc_user_typing' src='"+wplc_misc_strings.typingimg+"' />");
  		        	  jQuery("#wplc_user_typing").fadeIn("fast");
  			          var height = jQuery('#wplc_chatbox')[0].scrollHeight;
  			          jQuery('#wplc_chatbox').scrollTop(height);
                }
  		    	}
  		        
  		    } else if (e.response['typing'] === "0") {
                  console.log('not typing');
  		    	if (jQuery("#wplc_user_typing").length>0) {
  		        	jQuery("#wplc_user_typing").fadeOut("slow").remove();
                jQuery(".typing_indicator").removeClass("typing_indicator_active");
  		      }
  		    }
		    }
      }
	});

});

function wplc_start_chat_pro_data(data){
  if(typeof wplc_extra_data !== "undefined" && typeof wplc_extra_data['wplc_user_selected_department'] !== "undefined"){
    data['wplc_user_selected_department'] = wplc_extra_data['wplc_user_selected_department'];
  }

  return data;
}

/* Handles Uploading and sharing a file within chat*/
function niftyShareFile(fileToUpload, failedID, successID, uploadingID, originalID){
    var formData = new FormData();

    formData.append('action', 'wplc_upload_file');
	formData.append('cid', Cookies.get('wplc_cid'));
    formData.append('file', fileToUpload);
    formData.append('timestamp', Date.now());
    formData.append('security', wplc_nonce );
    
    /*Handle jQuery Elements*/
    jQuery(uploadingID).show();
    jQuery(originalID).hide();
    jQuery(successID).hide();
    jQuery(failedID).hide();

    if(fileToUpload.name.indexOf(".php") === -1 && fileToUpload.name.indexOf(".html") === -1 && fileToUpload.name.indexOf(".asp") === -1){
        //Files allowed - continue
        if(fileToUpload.size < 4000000){ //Max size of 4MB
            jQuery.ajax({
                   url : wplc_ajaxurl_site,
                   type : 'POST',
                   data : formData,
                   cache: false,
                   processData: false, 
                   contentType: false, 
                   success : function(data) {    
                   		// console.log(data);                    
                       if(parseInt(data) !== 0){
                           jQuery(uploadingID).hide();
                           jQuery(successID).show();
                           setTimeout(function(){
                              jQuery(successID).hide();
                              jQuery(originalID).show(); 
                           }, 2000);

                            //All good post the link to file            
                            var tag = (data.indexOf(".png") !== -1 || data.indexOf(".PNG") !== -1 ||data.indexOf(".jpg") !== -1  || data.indexOf(".JPG") !== -1 || data.indexOf(".jpeg") !== -1 || data.indexOf(".gif") !== -1 || data.indexOf(".bmp")!== -1 ) ? "img" : "link";
                           
                            if(tag !== "img"){
                                tag = (data.indexOf(".mp4") !== -1 || data.indexOf(".mpeg4") !== -1 || data.indexOf(".webm") !== -1 || data.indexOf(".oog") !== -1 ) ? "video" : "link"; //video now
                            }
                            jQuery("#wplc_chatmsg").val(tag + ":" + data + ":" + tag); //Add to input field
                            jQuery("#wplc_send_msg").trigger("click"); //Send message
                       }
                       else{
                           jQuery(uploadingID).hide();
                           jQuery(failedID).show();
                           setTimeout(function(){
                              jQuery(failedID).hide();
                              jQuery(originalID).show(); 
                           }, 2000);

                       }
                   },
                   error : function (){
                        jQuery(uploadingID).hide();
                        jQuery(failedID).show();
                        setTimeout(function(){
                           jQuery(failedID).hide();
                           jQuery(originalID).show(); 
                        }, 2000);
                   }
            });
        }else{
            alert("File limit is 4mb");
            jQuery(uploadingID).hide();
            jQuery(failedID).show();
            setTimeout(function(){
               jQuery(failedID).hide();
               jQuery(originalID).show(); 
            }, 2000);
        }
    } else{
        alert("File type not supported");
        jQuery(uploadingID).hide();
        jQuery(failedID).show();
        setTimeout(function(){
           jQuery(failedID).hide();
           jQuery(originalID).show(); 
        }, 2000);
    }
}

function wplc_start_chat_pro_custom_fields_filter( wplc_extra_data_tmp ) {

    var custom_field_array = {};

    var cnt = 0;
    jQuery('*[name^="wplc_custom_field"]').each(function(key, val) {

      var field_name = jQuery(this).attr( "fname" );
      custom_field_array[cnt] = {};
      custom_field_array[cnt][0] = field_name;
      custom_field_array[cnt][1] = jQuery(this).val();
      cnt++;
    });

    var custom_data = custom_field_array;
    wplc_extra_data_tmp['custom_fields'] = JSON.stringify(custom_data);

    return wplc_extra_data_tmp;

}

