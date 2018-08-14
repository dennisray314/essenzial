<?php
/**
 * class-woogroupsdiscount.php
 *
 * Copyright (c) Antonio Blanco http://www.blancoleon.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Antonio Blanco
 * @package woogroupsdiscount
 * @since woogroupsdiscount 1.0.0
 */

/**
 * WooGroupsDiscount class
 */
class WooGroupsDiscount {

	const DEFAULT_BOTH_PRICES_TEXT = "Before: [original_price], Now: [discounted_price]";

	public static function init() {
		global $woocommerce;

		if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
			add_filter('woocommerce_product_get_price', array( __CLASS__, 'woocommerce_get_price' ), 10, 2);
		} else {
			add_filter('woocommerce_get_price', array( __CLASS__, 'woocommerce_get_price' ), 10, 2);
		}

		// Cart 3.x
		if ( apply_filters( 'wgp_apply_woocommerce_cart_product_price', false ) ) {
			add_filter('woocommerce_cart_product_price', array( __CLASS__, 'woocommerce_get_price' ), 10, 2);
		}
		add_filter('woocommerce_product_variation_get_price', array( __CLASS__, 'woocommerce_get_price' ), 10, 2);

		add_filter( 'woocommerce_get_price_html', array(__CLASS__,'woocommerce_get_price_html'), 100, 2 );
	}

	public static function woocommerce_get_price ( $price, $product ) {
		global $post, $woocommerce;

		$baseprice = $price;
		$result = $baseprice;

		if ( is_user_logged_in() && ( ( $post == null ) || !is_admin() ) ) {

			if ( $product->is_type( 'variation' ) ) {
				if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
					$commission = WGD_Variations_Admin::get_commission( $product, $product->get_id() );
				} else {
					$commission = WGD_Variations_Admin::get_commission( $product, $product->variation_id );
				}
			} else {
				$commission = self::get_commission( $product );
			}

			$method = get_option( "wgd-method", "rate" );
			if ( ( ( $method == "rate" ) && ( $commission < 1 ) ) || ( ( $method !== "rate" ) && ( $commission > 0 ) ) ) {

				$baseprice = apply_filters( 'woo_groups_discount_baseprice', $product->get_regular_price(), $product );

				// get_price( $context ) We need to set 'edit', so the woocommerce_product_get_price filter is not hooked
				if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
					$product_get_price = $product->get_price( 'edit' );
				} else {
					$product_get_price = $product->price;
				}
				if ( $product->get_sale_price() != $baseprice && $product->get_sale_price() == $product_get_price ) {
					if ( get_option( "wgd-baseprice", "regular" )=="sale" ) {
						$baseprice = $product->get_sale_price();
					}
				}
				$product_price = apply_filters( 'woo_groups_discount_product_price', $baseprice, $product );

				$type = get_option( "wgd-method", "rate" );
				$result = 0;
				if ($type == "rate") {
					// if rate and price includes taxes
					if ( $product->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
						$_tax       = new WC_Tax();
						$tax_rates  = $_tax->get_shop_base_rate( $product->get_tax_class() );
						$taxes      = $_tax->calc_tax( $baseprice, $tax_rates, true );
						$product_price      = $_tax->round( $baseprice - array_sum( $taxes ) );
					}

					$result = self::bcmul($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);

					if ( $product->is_taxable() && get_option('woocommerce_prices_include_tax') == 'yes' ) {
						$_tax       = new WC_Tax();
						$tax_rates  = $_tax->get_shop_base_rate( $product->get_tax_class() );
						$taxes      = $_tax->calc_tax( $result, $tax_rates, false ); // important false
						$result      = $_tax->round( $result + array_sum( $taxes ) );
					}
				} else {
					$result = self::bcsub($product_price, $commission, WOO_GROUPS_DISCOUNT_DECIMALS);
				}
			}
		}

		if ( $result < 0 ) {
			$result = 0;
		}

		return $result;
	}

	public static function get_commission ( $product, $group = null ) {
		global $post, $woocommerce;

		$user_id = get_current_user_id();
		$user_groups = self::get_user_groups ( $user_id );
		$discount = 0;
		if ( sizeof( $user_groups ) > 0 ) {
			if ( isset( $group ) ) {
				$first_group = $group;
			} else {
				$first_group = self::get_user_group( $user_groups, $product );
			}

			if ( get_option( "wgd-" . $first_group->group_id, "-1" ) !== "-1" ) {
				$discount = get_option( "wgd-" . $first_group->group_id, "" );
			}
		}

		$method = get_option( "wgd-method", "rate" );
		if ( $method == "rate" ) {
			$discount = self::bcsub ( 1, $discount, WOO_GROUPS_DISCOUNT_DECIMALS );
			// for security reasons, set 0
			if ( $discount < 0 ) {
				$discount = 0;
			}
		}

		return $discount;
	}

	public static function woocommerce_get_price_html( $price, $product ){
		$result = $price;

		if ( is_user_logged_in() && !is_admin() ) {

			if ( get_option( "wgd-baseprice", "regular" ) == "sale" ) {
				$price_key = '_price';
			} else {
				$price_key = '_regular_price';
			}

			if ( ( $product->get_type() == 'variable' ) || ( $product->get_type() == 'variation' ) ) {

				$commission = null;
				$original_prices = array();

				if ( $product->get_type() == 'variable' ) {

					$children = $product->get_visible_children();
	
					foreach ( $children as $child ) {
						$original_prices[] = get_post_meta( $child, $price_key, true );
						if ( $commission == 0 ) {
							$commission = WGD_Variations_Admin::get_commission( $product, $child );
						}
					}
				} else { // variations
					if ( ( get_option( "wgd-baseprice", "regular" ) == "sale" ) && $product->is_on_sale('edit') ) {
						$original_prices[] = $product->get_sale_price();
						$result = wc_price( self::woocommerce_get_price($product->get_sale_price(), $product) );
					} else {
						$original_prices[] = $product->get_regular_price();
						$result = wc_price( self::woocommerce_get_price($product->get_regular_price(), $product) );
					}
					if ( $commission == null ) {
						$commission = WGD_Variations_Admin::get_commission( $product, $product->get_id() );
					}
					// In woocommerce_get_price_html called from variation (select of variable) the price is not discounted
					//$result = $price;
				}

				$original_price = $price;

				if ( $commission !== null ) {
					$min_price = min( $original_prices );
					$max_price = max( $original_prices );
					if ( is_numeric( $min_price ) && is_numeric( $max_price ) ) {
						$original_price = $min_price !== $max_price ? sprintf( _x( '%1$s–%2$s', 'Price range: from-to', 'woocommerce' ), wc_price( $min_price ), wc_price( $max_price ) ) : wc_price( $min_price );
					}
				}
			} else {
				$original_price = get_post_meta( $product->get_id(), $price_key, true );
				$commission = WooGroupsDiscount::get_commission( $product );
				if ( $commission !== null ) {
					if ( wc_tax_enabled() && ( 'excl' === get_option( 'woocommerce_tax_display_shop' ) ) && ( get_option('woocommerce_prices_include_tax') == 'yes' ) ) {
						$_tax           = new WC_Tax();
						$tax_rates      = $_tax->get_base_tax_rates( $product->get_tax_class() );
						$taxes          = $_tax->calc_tax( get_post_meta( $product->get_id(), $price_key, true ), $tax_rates, true );
						$original_price = $_tax->round( get_post_meta( $product->get_id(), $price_key, true ) - array_sum( $taxes ) );
					}
					$original_price = wc_price(get_post_meta( $product->get_id(), $price_key, true ));
				}
			}

			$method = get_option( "wgd-method", "rate" );
			if ( ( ( $method == "rate" ) && ( $commission < 1 ) ) || ( ( $method !== "rate" ) && ( $commission > 0 ) ) ) {
				$text = get_option( "wgd-bothpricestext", WooGroupsDiscount::DEFAULT_BOTH_PRICES_TEXT );

				// If $price has <del> tag ( on sale ), we remove this.
				$price=preg_replace('/<del[^>]*>.+?<\/del>/i', '', $price);

				$tokens = array();
				$tokens['original_price'] = $original_price;
				$tokens['discounted_price'] = $price;

				$text = self::substitute_tokens( $text, $tokens );

				if ( get_option( "wgd-displayoriginal", 0 ) == 1 ) {
					$result = apply_filters(
						'woo_group_pricing_display_original_prices',
						$text,
						$original_price,
						$price
					);
				}

			}
		}

		return $result;
	}

	private static function substitute_tokens( $s, $tokens ) {
		foreach ( $tokens as $key => $value ) {
			if ( key_exists( $key, $tokens ) ) {
				$substitute = $tokens[$key];
				$s = str_replace( "[" . $key . "]", $substitute, $s );
			}
		}
		return $s;
	}


	/* Function relating to Groups */

	public static function get_all_groups (  ) {
		global $wpdb;

		$groups_table = _groups_get_tablename( 'group' );

		return $wpdb->get_results( "SELECT * FROM $groups_table ORDER BY name" );

	}

	/**
	 * Get all user groups.
	 * @param int $user_id
	 * @return array
	 */
	public static function get_user_groups( $user_id ) {
		global $wpdb;

		$groups_table = _groups_get_tablename( 'group' );
		$result = array();
		if ( $groups = $wpdb->get_results( "SELECT * FROM $groups_table ORDER BY group_id DESC" ) ) {
			foreach( $groups as $group ) {
				$is_member = Groups_User_Group::read( $user_id, $group->group_id ) ? true : false;
				if ( $is_member ) {
					$result[] = $group;
				}
			}
		}
		return  $result;
	}

	/**
	 * Get the group applied to an user.
	 * @param array $groups
	 * @return group_id or null if an error occurs.
	 */
	public static function get_user_group( $groups = array(), $product ) {
		$result = null;

		if ( sizeof( $groups ) > 0 ) {
			$option = get_option( "wgd-ifseveral", "first" );

			switch ( $option ) {
				case 'higher':
					$result = null;
					$commission = null;
					$method = get_option( "wgd-method", "rate" );
					foreach ( $groups as $group ) {
						$temp_com = self::get_commission( $product, $group );
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
					break;
				case 'lower':
					$result = null;
					$commission = null;
					$method = get_option( "wgd-method", "rate" );
					foreach ( $groups as $group ) {
						$temp_com = self::get_commission( $product, $group );
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

	/* Math functions */

	public static function bcmul( $data1, $data2, $prec = 0 ) {
		$result = 0;
		if ( function_exists('bcmul') ) {
			$result = bcmul( $data1, $data2, $prec );
		} else {
			$value = $data1 * $data2;
			if ($prec) {
				$result = round($value, $prec);
			}
		}
		return $result;
	}

	public static function bcsub( $data1, $data2, $prec = 0 ) {
		$result = 0;
		if ( function_exists('bcsub') ) {
			$result = bcsub( $data1, $data2, $prec );
		} else {
			$value = $data1 - $data2;
			if ($prec) {
				$result = round($value, $prec);
			}
		}
		return $result;
	}

	public static function clear_products_cache() {
		global $woocommerce;
		if(version_compare($woocommerce->version, '2.4', '>=')) {
			WC_Cache_Helper::get_transient_version('product', true);
		}
	}

}
WooGroupsDiscount::init();