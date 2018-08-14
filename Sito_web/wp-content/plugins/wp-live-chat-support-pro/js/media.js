jQuery(document).ready(function($){
    var tgm_media_frame_default;
    var tgm_media_frame_logo;

    $(document.body).on('click.tgmOpenMediaManager', '#wplc_btn_upload_pic', function(e){
        e.preventDefault();

        if ( tgm_media_frame_default ) {
            tgm_media_frame_default.open();
            return;
        }

        tgm_media_frame_default = wp.media.frames.tgm_media_frame = wp.media({
            className: 'media-frame tgm-media-frame',
            frame: 'select',
            multiple: false,
            title: 'Upload your profile pic',
            library: {
                type: 'image'
            },
            button: {
                text:  'Use as Profile Pic'
            }
        });

        tgm_media_frame_default.on('select', function(){
            var media_attachment = tgm_media_frame_default.state().get('selection').first().toJSON();
            jQuery('#wplc_upload_pic').val(btoa(media_attachment.url));
            jQuery("#wplc_pic_area").html("<img src=\""+media_attachment.url+"\" width='100px'/>");
        });
        tgm_media_frame_default.open();
    });

    $(document.body).on('click.tgmOpenMediaManager', '#wplc_btn_upload_logo', function(e){
        e.preventDefault();

        if ( tgm_media_frame_logo ) {
            tgm_media_frame_logo.open();
            return;
        }

        tgm_media_frame_logo = wp.media.frames.tgm_media_frame = wp.media({
            className: 'media-frame tgm-media-frame',
            frame: 'select',
            multiple: false,
            title: 'Upload your Logo',
            library: {
                type: 'image'
            },
            button: {
                text:  'Use as Logo'
            }
        });

        tgm_media_frame_logo.on('select', function(){
            var media_attachment = tgm_media_frame_logo.state().get('selection').first().toJSON();
            jQuery('#wplc_upload_logo').val(btoa(media_attachment.url));
            jQuery("#wplc_logo_area").html("<img src=\""+media_attachment.url+"\" width='100px'/>");
        });
        tgm_media_frame_logo.open();
    });

    $(document.body).on('click.tgmOpenMediaManager', '#wplc_btn_upload_icon', function(e){
        e.preventDefault();

        if ( tgm_media_frame_default ) {
            tgm_media_frame_default.open();
            return;
        }

        tgm_media_frame_default = wp.media.frames.tgm_media_frame = wp.media({
            className: 'media-frame tgm-media-frame',
            frame: 'select',
            multiple: false,
            title: 'Upload your chat icon',
            library: {
                type: 'image'
            },
            button: {
                text:  'Use as Chat Icon'
            }
        });

        tgm_media_frame_default.on('select', function(){
            var media_attachment = tgm_media_frame_default.state().get('selection').first().toJSON();
            jQuery('#wplc_upload_icon').val(btoa(media_attachment.url));
            jQuery("#wplc_icon_area").html("<img src=\""+media_attachment.url+"\" width='100px'/>");
        });
        tgm_media_frame_default.open();
    });

    $("#wplc_btn_remove_pic").click(function() {
        $("#wplc_pic_area").empty();
        $("#wplc_upload_pic").val("");
    });
    $("#wplc_btn_remove_logo").click(function() {
        $("#wplc_logo_area").empty();
        $("#wplc_upload_logo").val("");
    });
    $("#wplc_btn_remove_icon").click(function() {
        $("#wplc_icon_area").empty();
        $("#wplc_upload_icon").val("");
    });

});