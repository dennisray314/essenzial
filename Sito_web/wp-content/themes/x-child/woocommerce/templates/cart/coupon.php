add_action('woocommerce_before_cart_table', 'discount_when_weight_greater_than_100');
function discount_when_weight_greater_than_100( ) {
    global $woocommerce;
    global $total_weight;
    if( $total_weight > 100 ) {
        $coupon_code = '999';
        if (!$woocommerce->cart->add_discount( sanitize_text_field( $coupon_code ))) {
            $woocommerce->show_messages();
        }
        echo '<div class="woocommerce_message"><strong>Your order is over 100 lbs so a 10% Discount has been Applied!</strong> Your total order weight is <strong>' . $total_weight . '</strong> lbs.</div>';
    }
}
 
/* Mod: Remove 10% Discount for weight less than or equal to 100 lbs */
/* Mod: Remove 10% Discount for weight less than or equal to 100 lbs */
add_action('woocommerce_before_cart_table', 'remove_coupon_if_original_is_present');
function remove_coupon_if_weight_100_or_less( ) {
    global $woocommerce;
    #global $total_weight;
    if(original_is_present())
    {
        
        $woocommerce->cart->get_applied_coupons();

        foreach( $woocommerce->cart->get_applied_coupons() as $coupon) {
		        $woocommerce->cart->remove_coupons( sanitize_text_field( $coupon_code ));
			$woocommerce->show_messages();
		    }

       # if (!$woocommerce->cart->remove_coupons( sanitize_text_field( $coupon_code ))) {
       #     $woocommerce->show_messages();
       # }
        $woocommerce->cart->calculate_totals();
    }

