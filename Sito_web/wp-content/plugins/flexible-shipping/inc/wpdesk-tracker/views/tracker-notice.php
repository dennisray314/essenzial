<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<?php if ( $coupon_avaliable ) : ?>
    <div id="wpdesk_tracker_notice_coupon" class="updated notice wpdesk_tracker_notice is-dismissible">
        <p>
            <?php printf ( __( 'Hey %s,', 'wpdesk-tracker'), $username ); ?><br/>
            <?php
                printf(
                    __( 'We need your help to improve <strong>WP Desk plugins</strong>, so they are more useful for you and the rest of <strong>10,000+ users</strong>. By collecting data on how you use our plugins, you will help us a lot. We will not collect any sensitive data, so you can feel safe. As a thank you for your consent, we will send you a <strong>discount coupon</strong> for %sWP Desk plugins%s, which you can use yourself or share with others. %sFind out more &raquo;%s', 'wpdesk-tracker' ),
                    '<a target="_blank" href="' . $shop_url . '?utm_source=tracker&utm_medium=link&utm_campaign=tracker-coupon-message-v3">',
                    '</a>',
                    '<a target="_blank" href="' . $terms_url . '?utm_source=tracker&utm_medium=link&utm_campaign=tracker-shop-link">',
                    '</a>'
                ); ?>
        </p>
        <p>
            <button id="wpdesk_tracker_allow_coupon_button_notice" class="button button-primary"><?php _e( 'Allow', 'wpdesk-tracker' ); ?></button>
        </p>
    </div>
<?php else : ?>
    <div id="wpdesk_tracker_notice" class="updated notice wpdesk_tracker_notice is-dismissible">
        <p>
            <?php printf ( __( 'Hey %s,', 'wpdesk-tracker'), $username ); ?><br/>
            <?php _e( 'Please help us improve our plugins! If you opt-in, we will collect some non-sensitive data and usage information. If you skip this, that\'s okay! All plugins will work just fine.', 'wpdesk-tracker'); ?>
            <a href="<?php echo $terms_url; ?>" target="_blank"><?php _e( 'Find out more &raquo;', 'wpdesk-tracker' ); ?></a>
        </p>
        <p>
            <button id="wpdesk_tracker_allow_button_notice" class="button button-primary"><?php _e( 'Allow', 'wpdesk-tracker' ); ?></button>
        </p>
    </div>
<?php endif; ?>

<script type="text/javascript">
    jQuery(document).on('click', '#wpdesk_tracker_notice_coupon .notice-dismiss',function(e){
        e.preventDefault();
        console.log('dismiss');
        jQuery.ajax( '<?php echo admin_url('admin-ajax.php'); ?>',
            {
                type: 'POST',
                data: {
                    action: 'wpdesk_tracker_notice_handler',
                    type: 'dismiss_coupon',
                }
            }
        );
    })
    jQuery(document).on('click', '#wpdesk_tracker_allow_coupon_button_notice',function(e){
        e.preventDefault();
        console.log('allow');
        jQuery.ajax( '<?php echo admin_url('admin-ajax.php'); ?>',
            {
                type: 'POST',
                data: {
                    action: 'wpdesk_tracker_notice_handler',
                    type: 'allow_coupon',
                }
            }
        );
        jQuery('#wpdesk_tracker_notice_coupon').hide();
    });
    jQuery(document).on('click', '#wpdesk_tracker_notice .notice-dismiss',function(e){
        e.preventDefault();
        console.log('dismiss');
        jQuery.ajax( '<?php echo admin_url('admin-ajax.php'); ?>',
            {
                type: 'POST',
                data: {
                    action: 'wpdesk_tracker_notice_handler',
                    type: 'dismiss',
                }
            }
        );
    })
    jQuery(document).on('click', '#wpdesk_tracker_allow_button_notice',function(e){
        e.preventDefault();
        console.log('allow');
        jQuery.ajax( '<?php echo admin_url('admin-ajax.php'); ?>',
            {
                type: 'POST',
                data: {
                    action: 'wpdesk_tracker_notice_handler',
                    type: 'allow',
                }
            }
        );
        jQuery('#wpdesk_tracker_notice').hide();
    });
</script>
