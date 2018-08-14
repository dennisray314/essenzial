<?php
/**
 * class-wgd-variations-admin.php
 *
 * Copyright (c) "eggemplo" Antonio Blanco www.eggemplo.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 * 
 * @author Antonio Blanco
 * @package woo-groups-discount
 * @since 2.3
 */
if (! defined ( 'ABSPATH' )) {
	exit ();
}

/**
 * Category product admin handlers.
 */
class WGD_Variations_Admin {
	
	/**
	 * Sets up the init action.
	 */
	public static function init() {

		// filter <del> tags for variable products
//		add_filter('woocommerce_variable_sale_price_html', array ( __CLASS__, 'woocommerce_variable_sale_price_html' ), 10, 2 );
//		add_filter('woocommerce_variable_sale_price', array ( __CLASS__, 'woocommerce_variable_sale_price_html' ), 10, 2 );

		// Variations
		add_filter( 'woocommerce_get_variation_price', array ( __CLASS__, 'woocommerce_get_variation_price' ), 10, 4);

		// Get variation price. Added Woo 2.4
		add_filter( 'woocommerce_variation_prices_price', array ( __CLASS__, 'woocommerce_variation_prices' ), 10, 3);
		add_filter( 'woocommerce_variation_prices_regular_price', array ( __CLASS__, 'woocommerce_variation_prices' ), 10, 3);
		add_filter( 'woocommerce_variation_prices_sale_price', array ( __CLASS__, 'woocommerce_variation_prices' ), 10, 3);

		// Remove cache added in Woocommerce 2.4
		add_filter('woocommerce_get_variation_prices_hash', array ( __CLASS__, 'woocommerce_get_variation_prices_hash' ), 10, 3);

	}

	/**
	 * Remove cache added in Woocommerce 2.4 relating to variation prices.
	 * @param array $cache_key_args
	 * @param unknown $product
	 * @param unknown $display
	 * @return array
	 */
	public static function woocommerce_get_variation_prices_hash ( $hash, $product, $display ) {
		// Delete the cached data, if it exists
		$cache_key = 'wc_var_prices' . substr( md5( json_encode( $hash ) ), 0, 22 ) . WC_Cache_Helper::get_transient_version( 'product' );
		
		delete_transient($cache_key);
		// Woocommerce 2.5
		delete_transient('wc_var_prices_' . $product->get_id());
		return $hash;
	}

	/**
	 * Filter <del> tabs for variable products
	 * @param String $pricehtml
	 * @param Object $product
	 * @return String
	 */
	/*
	public static function woocommerce_variable_sale_price_html ( $pricehtml, $product ) {
		global $post, $woocommerce;

		$string = $pricehtml;

		if ( ($post == null) || !is_admin() ) {
			$commission = WooGroupsDiscount::get_commission( $product );
			if ( $commission ) { // if applying  discount, then remove the original prices.
				$string=preg_replace('/<del[^>]*>.+?<\/del>/i', '', $string);
			}
		}
		return $string;
	}
	*/

	/**
	 * Get woocommerce variation price discounted. Called the show the variation range price (category lists and product page).
	 * @param unknown $price
	 * @param unknown $variation
	 * @param unknown $product
	 * @return float
	 */
	public static function woocommerce_variation_prices ( $price, $variation, $product ) {
		global $post, $woocommerce;

		$result = $price;

		if ( is_user_logged_in() && ( ( $post == null ) || !is_admin() ) ) {
			if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
				$variation_id = $variation->get_id();
			} else {
				$variation_id = $variation->variation_id;
			}
			if ( ! $variation_id ) {
				return false;
			}
			$commission = self::get_commission( $product, $variation_id );

			$method = get_option( "wgd-method", "rate" );
			if ( ( ( $method == "rate" ) && ( $commission < 1 ) ) || ( ( $method !== "rate" ) && ( $commission > 0 ) ) ) {

// 				$price = get_post_meta( $variation_id, '_price', true );
// 				$result = $price;

// 				if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
// 					$variation_get_price = $variation->get_price( 'edit' );
// 				} else {
// 					$variation_get_price = $variation->price;
// 				}
// 				$baseprice = apply_filters( 'woo_groups_discount_variation_baseprice', $variation->get_regular_price(), $product, $variation );
// 				if ( $variation->get_sale_price() != $baseprice && $variation->get_sale_price() == $variation_get_price ) {
// 					if ( get_option( "wgd-baseprice", "regular" )=="sale" ) {
// 						$baseprice = $variation->get_sale_price();
// 					}
// 				}
// 				$product_price = apply_filters( 'woo_groups_discount_variation_product_price', $baseprice, $product, $variation );

				$product_price = apply_filters( 'woo_groups_discount_variation_product_price', $price, $product, $variation );

				$type = get_option( "wgd-method", "rate" );
				$result = 0;
				if ($type == "rate") {
					// if rate and price includes taxes
					if ( $variation->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
						$_tax       = new WC_Tax();
						$tax_rates  = $_tax->get_shop_base_rate( $variation->get_tax_class() );
						$taxes      = $_tax->calc_tax( $price, $tax_rates, true );
						$product_price      = $_tax->round( $price - array_sum( $taxes ) );

						$result = WooGroupsDiscount::bcmul($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);

						$_tax       = new WC_Tax();
						$tax_rates  = $_tax->get_shop_base_rate( $variation->get_tax_class() );
						$taxes      = $_tax->calc_tax( $result, $tax_rates, false ); // important false
						$result      = $_tax->round( $result + array_sum( $taxes ) );
					} else {
						$result = WooGroupsDiscount::bcmul($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);
					}
				} else {
					if ( get_option( "wgd-haveset", "discounts" ) === 'discounts' ) {
						$result = WooGroupsDiscount::bcsub($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);
					} else {
						$result = $commission;
					}
				}
			}
		}
		return $result;
	}

	/**
	 * Get variation price discounted. Used when you change between options.
	 * @param unknown $price
	 * @param unknown $product
	 * @param unknown $min_or_max
	 * @param unknown $display
	 * @return float
	 */
	public static function woocommerce_get_variation_price ( $price, $product, $min_or_max, $include_taxes ) {
		global $post, $woocommerce;

		$result = $price;

		if ( is_user_logged_in() && ( ( $post == null ) || !is_admin() ) ) {
			$variation_id = get_post_meta( $product->get_id(), '_' . $min_or_max . '_price_variation_id', true );

			if ( ! $variation_id ) {
				return false;
			}

			$price = get_post_meta( $variation_id, '_price', true );
			$result = $price;

			$variation = $product->get_child( $variation_id );

			$commission = self::get_commission( $product, $variation_id );

			if ( $commission !== null ) {
				$method = get_option( "wgd-method", "rate" );
				if ( ( ( $method == "rate" ) && ( $commission < 1 ) ) || ( ( $method !== "rate" ) && ( $commission > 0 ) ) ) {

// 					$baseprice = apply_filters( 'woo_groups_discount_get_variation_baseprice', $variation->get_regular_price(), $product, $variation );
// 					if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
// 						$variation_get_price = $variation->get_price( 'edit' );
// 					} else {
// 						$variation_get_price = $variation->price;
// 					}
// 					if ( $variation->get_sale_price() != $variation->get_regular_price() && $variation->get_sale_price() == $variation_get_price ) {
// 						if ( get_option( "wgd-baseprice", "regular" )=="sale" ) {
// 							$baseprice = $variation->get_sale_price();
// 						}
// 					}
// 					$product_price = apply_filters( 'woo_groups_discount_get_variation_product_price', $baseprice, $product, $variation );

					$product_price = $price;

					$type = get_option( "wgd-method", "rate" );
					if ($type == "rate") {
						// if rate and price includes taxes
						if ( $variation->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
							$_tax       = new WC_Tax();
							$tax_rates  = $_tax->get_shop_base_rate( $variation->get_tax_class() );
							$taxes      = $_tax->calc_tax( $price, $tax_rates, true );
							$product_price      = $_tax->round( $price - array_sum( $taxes ) );

							$result = WooGroupsDiscount::bcmul($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);

							$_tax       = new WC_Tax();
							$tax_rates  = $_tax->get_shop_base_rate( $variation->get_tax_class() );
							$taxes      = $_tax->calc_tax( $result, $tax_rates, false ); // important false
							$result      = $_tax->round( $result + array_sum( $taxes ) );
						} else {
							$result = WooGroupsDiscount::bcmul($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);
						}
					} else {
						if ( get_option( "wgd-haveset", "discounts" ) === 'discounts' ) {
							$result = WooGroupsDiscount::bcsub($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);
						} else {
							$result = $commission;
						}
					}
				}
			}
		}
		return $result;
	}

	/**
	 * Calculates the commissions.
	 * Order by priority:
	 * 1.- Variation values
	 * 2.- Product values
	 * 3.- Category values
	 * 4.- Default value
	 * @param unknown $product
	 * @param unknown $variation_id
	 * @return number
	 */
	public static function get_commission ( $product, $variation_id, $group = null ) {
		global $post, $woocommerce;

		$user_id = get_current_user_id();
		$user_groups = WooGroupsDiscount::get_user_groups ( $user_id );
		$discount = 0;
		if ( sizeof( $user_groups ) > 0 ) {
			if ( isset( $group ) ) {
				$first_group = $group;
			} else {
				$first_group = self::get_user_group( $user_groups, $product, $variation_id );
			}

			if ( get_option( "wgd-" . $first_group->group_id, "-1" ) !== "-1" ) {
				$discount = get_option( "wgd-" . $first_group->group_id, "" );
			}
		}

		$method = get_option( "wgd-method", "rate" );
		if ( $method == "rate" ) {
			$discount = WooGroupsDiscount::bcsub ( 1, $discount, WOO_GROUPS_DISCOUNT_DECIMALS );
			// for security reasons, set 0
			if ( $discount < 0 ) {
				$discount = 0;
			}
		}

		return $discount;
	}

	/**
	 * Get the group applied to an user.
	 * @param array $groups
	 * @return group_id or null if an error occurs.
	 */
	public static function get_user_group( $groups = array(), $product, $variation_id ) {
		$result = null;

		if ( sizeof( $groups ) > 0 ) {
			$option = get_option( "wgd-ifseveral", "first" );

			switch ( $option ) {
				case 'higher':
					$result = null;
					$commission = null;
					$method = get_option( "wgd-method", "rate" );
					foreach ( $groups as $group ) {
						$temp_com = self::get_commission( $product, $variation_id, $group );
						if ( ( $temp_com !== null ) && ( $temp_com !== '' ) ) {
							if ( $method == "rate" ) { // if rate: higher discount is lower commission
								if ( ( $commission == null ) || ( $temp_com < $commission ) ) {
									$commission = $temp_com;
									$result = $group;
								}
							} else {
								if ( ( $commission == null ) || ( $temp_com > $commission ) ) {
									$commission = $temp_com;
									$result = $group;
								}
							}
						}
					}
					break;
				case 'lower':
					$result = null;
					$commission = null;
					$method = get_option( "wgd-method", "rate" );
					foreach ( $groups as $group ) {
						$temp_com = self::get_commission( $product, $variation_id, $group );
						if ( ( $temp_com !== null ) && ( $temp_com !== '' ) ) {
							if ( $method == "rate" ) { // if rate: lower discount is higher commission
								if ( ( $commission == null ) || ( $temp_com > $commission ) ) {
									$commission = $temp_com;
									$result = $group;
								}
							} else {
								if ( ( $commission == null ) || ( $temp_com < $commission ) ) {
									$commission = $temp_com;
									$result = $group;
								}
							}
						}
					}
					break;
				case 'last':
					$result = $groups[sizeof($groups)-1];
					break;
				default:
				case 'first':
					$result = $groups[0];
					break;
			}
		}
		return $result;
	}

}
WGD_Variations_Admin::init();