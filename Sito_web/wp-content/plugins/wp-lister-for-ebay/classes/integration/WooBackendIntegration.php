<?php
/**
 * hooks to alter the WooCommerce backend
 */

class WPL_WooBackendIntegration {

	function __construct() {

		// custom column for products table
		add_filter( 'manage_edit-product_columns', array( &$this, 'wpl_woocommerce_edit_product_columns' ), 11 );
		add_action( 'manage_product_posts_custom_column', array( &$this, 'wplister_woocommerce_custom_product_columns' ), 3 );

		// custom column for orders table
		add_filter( 'manage_edit-shop_order_columns', array( &$this, 'wpl_woocommerce_edit_shop_order_columns' ), 10 );
		add_action( 'manage_shop_order_posts_custom_column', array( &$this, 'wplister_woocommerce_custom_shop_order_columns' ), 10 );

		// hook into save_post to mark listing as changed when a product is updated
		add_action( 'save_post', 							array( &$this, 'wplister_on_woocommerce_product_bulk_edit_save' ), 20, 2 );
		add_action( 'save_post', 							array( &$this, 'wplister_on_woocommerce_product_save' ), 20, 2 );
		add_action( 'woocommerce_product_quick_edit_save',  array( &$this, 'wple_woocommerce_product_quick_edit_save' ), 20, 1 );
		add_action( 'save_post',                            array( $this, 'handle_list_on_ebay_request' ), 20, 2 );
		add_action( 'save_post',                            array( $this, 'handle_switch_profile_request' ), 20, 2 );

        // handle duplicate product action to copy over ebay metadata for WC 3.0
        add_action( 'woocommerce_product_duplicate', array( $this, 'woocommerce_duplicate_product_meta' ), 10, 2 );

        // WC REST API v1
        add_action( 'woocommerce_rest_insert_product', array( $this, 'wple_on_woocommerce_api_product_save' ), 10, 2 );
        add_action( 'woocommerce_rest_insert_product_variation', array( $this, 'wple_on_woocommerce_api_product_save' ), 10, 2 );

        // WC REST API v2
        add_action( 'woocommerce_rest_insert_product_object', array( $this, 'wple_on_woocommerce_api_product_save' ), 10, 2 );
        add_action( 'woocommerce_rest_insert_product_variation_object', array( $this, 'wple_on_woocommerce_api_product_save' ), 10, 2 );

        // Fired on WC_Product::save() and adds support for the built-in WC Products importer in WP
        add_action( 'woocommerce_update_product', array( $this, 'handle_product_update' ) );

		// show messages when listing was updated from edit product page
		add_action( 'post_updated_messages', array( &$this, 'wplister_product_updated_messages' ), 20, 1 );

		// show errors for products and orders
		add_action( 'admin_notices', array( &$this, 'wple_product_admin_notices' ), 20 );
		add_action( 'admin_notices', array( &$this, 'wple_order_admin_notices' ), 20 );

		// custom views for products table
		//add_filter( 'parse_query', array( &$this, 'wplister_woocommerce_admin_product_filter_query' ) ); // switched to using subqueries in wplister_woocommerce_admin_product_query_where()
		add_filter( 'posts_where', array( $this, 'wplister_woocommerce_admin_product_query_where' ) );
		add_filter( 'parse_query', array( $this, 'wplister_woocommerce_admin_product_query_filters' ) );
		add_filter( 'views_edit-product', array( &$this, 'wplister_add_woocommerce_product_views' ) );
		add_filter( 'restrict_manage_posts', array( &$this, 'wplister_add_woocommerce_product_hidden_filter_fields' ) );

		// custom views for orders table
		add_filter( 'parse_query', array( &$this, 'wplister_woocommerce_admin_order_filter_query' ) );
		add_filter( 'views_edit-shop_order', array( &$this, 'wplister_add_woocommerce_order_views' ) );

		// custom filters for order table
		add_action( 'restrict_manage_posts', array( $this, 'add_wc_order_table_filter_options' ) );

		// submitbox actions
		add_action( 'post_submitbox_misc_actions', array( &$this, 'wplister_product_submitbox_misc_actions' ), 100 );
		add_action( 'woocommerce_process_product_meta', array( &$this, 'wplister_product_handle_submitbox_actions' ), 100, 2 );

		// make orders searchable by OrderID at WooCommerce -> Orders
		add_filter( 'woocommerce_shop_order_search_fields', array( &$this, 'woocommerce_shop_order_search_ebay_order_id' ) );

		// hook into WooCommerce orders to create product objects for ebay listings (debug)
		// add_action( 'woocommerce_order_get_items', array( &$this, 'wpl_woocommerce_order_get_items' ), 10, 2 );
		add_filter( 'woocommerce_get_product_from_item', array( &$this, 'wpl_woocommerce_get_product_from_item' ), 10, 3 );

		// add "List on eBay" action link on products table
		// add_filter( 'post_row_actions', array( &$this, 'wpl_post_row_actions' ), 10, 2 );

		// prevent WooCommerce from sending out notification emails when updating order status manually
		if ( get_option( 'wplister_disable_changed_order_emails' ) ) {
			// add_filter( 'woocommerce_email_enabled_new_order', array( $this, 'check_order_email_enabled' ), 10, 2 );  // disabled as this would *always* prevent admin new order emails for eBay orders
			add_filter( 'woocommerce_email_enabled_customer_completed_order', array( $this, 'check_order_email_enabled' ), 10, 2 );
			add_filter( 'woocommerce_email_enabled_customer_processing_order', array( $this, 'check_order_email_enabled' ), 10, 2 );		
			add_filter( 'woocommerce_email_enabled_customer_refunded_order', array( $this, 'check_order_email_enabled' ), 10, 2 );
		}

		// disable order emails in WC3.0
        add_filter( 'woocommerce_email_enabled_new_order', array( $this, 'disable_order_emails' ), 10, 2 );
        add_filter( 'woocommerce_email_enabled_customer_completed_order', array( $this, 'disable_order_emails' ), 10, 2 );
        add_filter( 'woocommerce_email_enabled_customer_processing_order', array( $this, 'disable_order_emails' ), 10, 2 );

		// notify ebay when a product's stock level changes
		// and the order's status is either cancelled or refunded
		add_action( 'woocommerce_restore_order_stock', array( $this, 'order_stock_restored' ) );
		add_action( 'woocommerce_restock_refunded_item', array( $this, 'order_refund_stock_restored' ) );

		// add quick-edit actions
		add_action( 'admin_enqueue_scripts', array( $this, 'quick_edit_script' ) );
		add_action( 'manage_product_posts_custom_column', array( $this, 'render_quick_edit_values' ), 5 );
		add_action( 'quick_edit_custom_box',  array( $this, 'quick_edit' ), 20, 2 );
		add_action( 'woocommerce_product_quick_edit_save', array( $this, 'quick_edit_save' ) );

        // use ebay's order number in the WC orders
        if ( 1 == get_option( 'wplister_use_ebay_order_number', 0 ) ) {
            add_filter( 'woocommerce_order_number', array( $this, 'get_ebay_order_number' ), 20, 2 );

            if ( is_admin() ) {
                add_filter( 'woocommerce_shop_order_search_fields', array( $this, 'custom_search_fields' ) );
            }
        }
	}

	// make orders searchable by OrderID at WooCommerce -> Orders
	function woocommerce_shop_order_search_ebay_order_id( $search_fields ) {
		$search_fields[] = '_ebay_order_id';
		$search_fields[] = '_ebay_user_id';
		return $search_fields;
	}


	function wple_order_admin_notices() {
		global $post, $post_ID;
		if ( ! $post ) return;
		if ( ! $post_ID ) return;
		if ( ! $post->post_type == 'shop_order' ) return;
		$errors_msg = '';

        // show errors and warning on failed items only
        $_ebay_marked_as_shipped = get_post_meta( $post->ID, '_ebay_marked_as_shipped', true );
        if ( $_ebay_marked_as_shipped ) return;

		// parse result
        $last_error = maybe_unserialize( get_post_meta( $post->ID, '_wple_debug_last_error', true ) );
		if ( empty($last_error) || ! is_object($last_error) ) return;
		$ebay_error = $last_error->error;
		$ebay_error = str_replace( 'eBay said:', '', $ebay_error );
		$ebay_error = str_replace( 'Please check API documentation.', '', $ebay_error );

        $errors_msg .= 'eBay returned the following error when this order was marked as shipped.'.'<br>';
        $errors_msg .= '<small style="color:darkred">'.$ebay_error.'</small>';
        self::showMessage( $errors_msg, 1, 1 );

	} // wple_order_admin_notices()


	function wple_product_admin_notices() {
		global $post, $post_ID;
		if ( ! $post ) return;
		if ( ! $post_ID ) return;
		$errors_msg = '';

		// warn about missing details
        // $this->checkForMissingData( $post );
        $this->checkForInvalidData( $post );

		// get listing item
		$listing_id = WPLE_ListingQueryHelper::getListingIDFromPostID( $post_ID );
		$listing    = ListingsModel::getItem( $listing_id );
		if ( ! $listing ) return;


		// parse history
		$history = maybe_unserialize( $listing['last_errors'] );
		if ( empty($history) ) return;
		// echo "<pre>";print_r($history);echo"</pre>";#die();

		// process errors and warnings
        $tips_errors   = array();
        $tips_warnings = array();
        if ( is_array( $history ) ) {
                foreach ($history['errors'] as $result) {
                    $tips_errors[] = '<b>'.$result->SeverityCode.':</b> '.$result->ShortMessage.' ('.$result->ErrorCode.')<br>'.$result->LongMessage;
                }
                foreach ($history['warnings'] as $result) {
                    $tips_warnings[] = '<b>'.$result->SeverityCode.':</b> '.$result->ShortMessage.' ('.$result->ErrorCode.')<br>'.$result->LongMessage;
                }
        }
        if ( ! empty( $tips_errors ) ) {
            $errors_msg .= 'eBay returned the following error(s):'.'<br>';
            $errors_msg .= '<small style="color:darkred">'.join('<br>',$tips_errors).'</small>';
        }

        if ( $errors_msg )
            self::showMessage( $errors_msg, 1, 1 );

	} // wple_product_admin_notices()


    // check if UPC and/or EAN are valid
    function checkForInvalidData( $post ) {
    	global $page;
		if ( 'product' != $post->post_type ) return;
		if ( 'auto-draft' == $post->post_status ) return;
	    // if ( ! get_option( 'wple_enable_missing_details_warning' ) ) return;

		$product      = ProductWrapper::getProduct( $post->ID );
		$product_id   = $post->ID;
		$invalid_eans = array();    	
		$invalid_upcs = array();    	
		$var_no_stock = array();    	

		// UPC
		$ebay_upc = get_post_meta( $product_id, '_ebay_upc', true );
		if ( $ebay_upc && ! WPLE_ValidationHelper::isValidUPC( $ebay_upc ) ) {
			$invalid_upcs[] = $ebay_upc;
		}

		// EAN
		$ebay_ean = get_post_meta( $product_id, '_ebay_ean', true );
		if ( $ebay_ean && ! WPLE_ValidationHelper::isValidEAN( $ebay_ean ) ) {
			// try to prefix 12 digit EAN with '0'
			if ( 12 == strlen($ebay_ean) && WPLE_ValidationHelper::isValidEAN( '0' . $ebay_ean ) ) {
				update_post_meta( $product_id, '_ebay_ean', '0' . $ebay_ean );
			} else {
				$invalid_eans[] = $ebay_ean;
			}
		}

		// variable product
		if ( wple_get_product_meta( $product_id, 'product_type' ) == 'variable' ) {

			// get variations
			$variation_ids = $product->get_children();
			$parent_manage_stock = get_post_meta( $product_id, '_manage_stock', true );

			foreach ( $variation_ids as $variation_id ) {
				//$_product = ProductWrapper::getProduct( $variation_id );
				$var_info = " (#$variation_id)";

				// UPC
				$ebay_upc = get_post_meta( $variation_id, '_ebay_upc', true );
				if ( $ebay_upc && ! WPLE_ValidationHelper::isValidUPC( $ebay_upc ) ) {
					$invalid_upcs[] = $ebay_upc . $var_info;
				}

				// EAN
				$ebay_ean = get_post_meta( $variation_id, '_ebay_ean', true );
				if ( $ebay_ean && ! WPLE_ValidationHelper::isValidEAN( $ebay_ean ) ) {
					// try to prefix 12 digit EAN with '0'
					if ( 12 == strlen($ebay_ean) && WPLE_ValidationHelper::isValidEAN( '0' . $ebay_ean ) ) {
						update_post_meta( $variation_id, '_ebay_ean', '0' . $ebay_ean );
					} else {
						$invalid_eans[] = $ebay_ean . $var_info;
					}
				}

				// check if stock management is enabled on variation level
				$variation_manage_stock = get_post_meta( $variation_id, '_manage_stock', true );
				if ( $parent_manage_stock == 'yes' && $variation_manage_stock == 'no' ) {
					$var_no_stock[] = " #$variation_id";
				}


			} // foreach variation

		} // variable product

		// show warning
		$errors_msg = '';
		if ( ! empty($invalid_upcs) ) {
			$errors_msg .= __('Warning: This number does not seem to be a valid UPC:','wplister') .' <b>'. join($invalid_upcs, ', ') . '</b><br>';
			$errors_msg .= __('Valid UPCs must have 12 digits.','wplister') . '<br>';
		}
		if ( ! empty($invalid_eans) ) {
			$errors_msg .= __('Warning: This number does not seem to be a valid EAN:','wplister') .' <b>'. join($invalid_eans, ', ') . '</b><br>';
			$errors_msg .= __('Valid EANs must have 13 digits.','wplister') . '<br>';
		}
		if ( ! empty($var_no_stock) ) {
			$errors_msg .= __('Warning: Stock management is enabled for this product but is disabled for these variations:','wplister') .' <b>'. join($var_no_stock, ', ') . '</b><br>';
			$errors_msg .= __('eBay requires separate stock levels for each variation. So please enable stock management for each variation and set the stock level on the variation level.','wplister') . '<br>';
			$errors_msg .= __('Disabling stock management for single variations will cause sales not to be synced properly.','wplister') . '<br>';
		}
		if ( ! empty($errors_msg) ) {
            wple_show_message( $errors_msg, 'warn' );
            do_action('wple_admin_notices');
		}

	} // checkForInvalidData()



	/* Generic message display */
	public function showMessage($message, $errormsg = false, $echo = true) {		
		if ( defined('WPLISTER_RESELLER_VERSION') ) $message = apply_filters( 'wplister_tooltip_text', $message );
		$class = ($errormsg) ? 'error' : 'updated';			// error or success
		$class = ($errormsg == 2) ? 'update-nag' : $class; 	// top warning
		$message = '<div id="message" class="'.$class.'" style="display:block !important"><p>'.$message.'</p></div>';
		if ($echo) echo $message;
	}


	/**
	 * prevent WooCommerce from sending out notification emails when updating order status for eBay orders manually
	 **/
	function check_order_email_enabled( $enabled, $order ){
		if ( ! is_object($order) ) return $enabled;

		// check if this order was imported from eBay
		if ( get_post_meta( wple_get_order_meta( $order, 'id' ), '_ebay_order_id', true ) ) {
			return false;
		}

		return $enabled;
	}

    /**
     * Prevent WC3.0 from sending out order emails
     * @param bool $enabled
     * @param WC_Order $order
     * @return bool
     */
    function disable_order_emails( $enabled, $order ) {
        $filter = current_filter();

        // $order is null in the WC Settings page
        if ( !$order ) {
            return $enabled;
        }

        $order_via = is_callable( array( $order, 'get_created_via' ) ) ? $order->get_created_via() :  $order->created_via;

        if ( $order_via != 'ebay' ) {
            return $enabled;
        }

        if ( $filter == 'woocommerce_email_enabled_new_order' && get_option( 'wplister_disable_new_order_emails' ) ) {
            $enabled = false;
        } elseif ( $filter == 'woocommerce_email_enabled_customer_completed_order' && get_option( 'wplister_disable_completed_order_emails' ) ) {
            $enabled = false;
        } elseif ( $filter == 'woocommerce_email_enabled_customer_processing_order' && get_option( 'wplister_disable_processing_order_emails' ) ) {
            $enabled = false;
        }

        return $enabled;
    }

	/**
	 * add Prepare Listing action link on products table (DISABLED and replaced by search icon on ebay column)
	 **/
	// add_filter( 'post_row_actions', array( &$this, 'wpl_post_row_actions' ), 10, 2 );

	function wpl_post_row_actions( $actions, $post ){

		// skip if this is not a WC product
		if ( $post->post_type == 'product' ) {

			// get listing status
			$status = WPLE_ListingQueryHelper::getStatusFromPostID( $post->ID );
			
			// skip if listing exists
			if ( $status ) return $actions;

			// TODO: check if product is in stock and not currently published on eBay!
			// if ( ! get_post_meta( $post->ID, '_ebay_item_id', true ) )
			$actions['wple_prepare_auction'] = "<a title='" . esc_attr( __('Prepare this product to be listed on eBay.','wplister') ) . "' href='" . wp_nonce_url( admin_url( 'admin.php?page=wplister' . '&amp;action=wpl_prepare_single_listing&amp;product_id=' . $post->ID ), 'prepare_listing_' . $post->ID ) . "'>" . __( 'List on eBay', 'wplister' ) . "</a>";

		}

		return $actions;
	}

	/**
	 * fix order line items
	 **/
	// add_filter('woocommerce_get_product_from_item', 'wpl_woocommerce_get_product_from_item', 10, 2 );

	function wpl_woocommerce_get_product_from_item( $_product, $item, $order ){

		// WPLE()->logger->info('wpl_woocommerce_get_product_from_item - item: '.print_r($item,1));
		// WPLE()->logger->info('wpl_woocommerce_get_product_from_item - _product: '.print_r($_product,1));
		// WPLE()->logger->info('wpl_woocommerce_get_product_from_item - order: '.print_r($order,1));

		// if this is not a valid WC product object, post processing or email generation might fail
		if ( ! $_product ) {

			// check if this order was created by WP-Lister
			// if ( isset( $order->order_custom_fields['_ebay_order_id'] ) ) {
			if ( get_post_meta( wple_get_order_meta( $order, 'id' ), '_ebay_order_id', true ) ) {

				// create a new ebay product object to allow email templates or other plugins to do $_product->get_sku() and more...
				$_product = new WC_Product_Ebay( $item['product_id'] );
				// WPLE()->logger->info('wpl_woocommerce_get_product_from_item - NEW _product: '.print_r($_product,1));

			}

		}

		return $_product;
	}

	/**
	 * debug order line items
	 **/
	// add_filter('woocommerce_order_get_items', 'wpl_woocommerce_order_get_items', 10, 2 );

	function wpl_woocommerce_order_get_items( $items, $order ){
		WPLE()->logger->info('wpl_woocommerce_order_get_items - items: '.print_r($items,1));
		// WPLE()->logger->info('wpl_woocommerce_order_get_items - order: '.print_r($order,1));
	}


	/**
	 * Columns for Orders page
	 **/
	// add_filter('manage_edit-shop_order_columns', 'wpl_woocommerce_edit_shop_order_columns', 11 );

	function wpl_woocommerce_edit_shop_order_columns($columns){
		return $columns;
	}


	/**
	 * Custom Columns for Orders page
	 **/
	// add_action('manage_shop_order_posts_custom_column', 'wplister_woocommerce_custom_shop_order_columns', 3 );

	function wplister_woocommerce_custom_shop_order_columns( $column ) {
		global $post, $woocommerce;

		if ( $column != 'wpl_order_src' ) return;

		// check if order was placed on eBay
		$ebay_order_id = get_post_meta( $post->ID, '_ebay_order_id', true );
		if ( ! $ebay_order_id ) return;


		// get order details
		$om      = new EbayOrdersModel();
		$order   = $om->getOrderByOrderID( $ebay_order_id );
		$account = $order ? WPLE_eBayAccount::getAccount( $order['account_id'] ) : false;

		$tooltip = 'This order was placed on eBay.';
		if ( $account ) $tooltip .= '<br>('.$account->title.')';

		// indicate eBay Plus orders with special logo
		$ebay_img_file = 'ebay-42x16.png';
		if ( strpos( $order['details'], 'ContainseBayPlusTransaction' ) ) {
			$ebay_img_file = 'ebayplus-42x36.png';
		}

		echo '<div>';		
		echo '<img src="'.WPLISTER_URL.'img/'.$ebay_img_file.'" style="width:32px;vertical-align:bottom;padding:0;" class="tips" data-tip="'.$tooltip.'" />';		


		// show shipping status - if _ebay_marked_as_shipped is set to yes
        if ( get_post_meta( $post->ID, '_ebay_marked_as_shipped', true ) ) {

            $date_shipped = get_post_meta( $post->ID, '_date_shipped', true );
            $date_shipped = is_numeric($date_shipped) ? date('Y-m-d',$date_shipped) : $date_shipped; // convert timestamp to date - support for Shipment Tracking plugin
			echo '<img src="'.WPLISTER_URL.'img/icon-success-32x32.png" style="width:12px;vertical-align:middle;padding:0;" class="tips" data-tip="This order was completed and marked as shipped on eBay on '.$date_shipped.'" />';		

        } elseif ( get_post_meta( $post->ID, '_wple_debug_last_error', true ) ) {

        	// if not marked as shipped but there is an error result, CompleteSale failed...
			echo '<img src="'.WPLISTER_URL.'img/error.gif" style="vertical-align:middle;padding:0;" class="tips" data-tip="There was a problem completing this order on eBay!" />';		

        }
		echo '</div>';

	} // wplister_woocommerce_custom_shop_order_columns()


	/**
	 * Columns for Products page
	 **/
	// add_filter('manage_edit-product_columns', 'wpl_woocommerce_edit_product_columns', 11 );

	function wpl_woocommerce_edit_product_columns($columns){
		
		$columns['listed_on_ebay'] = '<img src="'.WPLISTER_URL.'/img/hammer-dark-16x16.png" data-tip="'.__('eBay', 'wplister').'" class="tips" />';		
		return $columns;
	}


	/**
	 * Custom Columns for Products page
	 **/
	// add_action('manage_product_posts_custom_column', 'wplister_woocommerce_custom_product_columns', 3 );

	function wplister_woocommerce_custom_product_columns( $column ) {
		global $post, $woocommerce;
		// $product = self::getProduct($post->ID);

		switch ($column) {
			case "listed_on_ebay" :

				// get all listings for product ID - including split variations
				$listings = WPLE_ListingQueryHelper::getAllListingsFromPostOrParentID( $post->ID );
			
				// show select profile button if no listings found
				if ( empty($listings) ) {
					echo '<a href="#" class="wple_btn_select_profile_for_product" data-post_id="'.$post->ID.'" title="'.__('List on eBay','wplister').'"><img src="'.WPLISTER_URL.'/img/search3.png" alt="select profile" /></a>';
					return;					
				}

				// show all found listings
				foreach ( $listings as $listing ) {

					$msg_1   = 'eBay listing is '.$listing->status.'.';
					$msg_2   = '';
					$msg_3   = 'Click to view all listings for this product in WP-Lister.';
					if ( defined('WPLISTER_RESELLER_VERSION') ) $msg_3 = apply_filters( 'wplister_tooltip_text', $msg_3 );
					$linkurl = 'admin.php?page=wplister&amp;s='.$post->ID;

					switch ( $listing->status ) {

						case 'published':
						case 'changed':
							// $msg_1   = 'This product is published on eBay';
							$msg_3   = 'Click to open this listing on eBay in a new tab.';
							$imgfile = 'icon-success-32x32.png';
							$linkurl = $listing->ViewItemURL;
							break;
							
						case 'prepared':
							$imgfile = 'hammer-orange-16x16.png';
							break;
						
						case 'verified':
							$imgfile = 'hammer-green-16x16.png';
							break;
						
						case 'ended':
						case 'sold':
						default:
							$imgfile = 'hammer-16x16.png';
							break;
					}

					// get account
					$accounts = WPLE()->accounts;
					$account  = isset( $accounts[ $listing->account_id ] ) ? $accounts[ $listing->account_id ] : false;
					if ( $account && sizeof($accounts) > 0 ) {
						$msg_2 = '<i>' . $account->title . ' ('.$account->site_code.')</i><br>';
					}

					// output icon
					$msg_html = '<b>'.$msg_1.'</b><br/>'.$msg_2.'<br/>'.$msg_3;
					echo '<a href="'.$linkurl.'" target="_blank">';
					echo '<img src="'.WPLISTER_URL.'/img/'.$imgfile.'" class="tips" data-tip="' . esc_attr( $msg_html ) . '" style="width:16px;height:16px; padding:0; cursor:pointer;" />';
					echo '</a>';

				} // each listing

			break;

		} // switch ($column)

	}


	// hook into save_post to mark listing as changed when a product is updated via quick edit
	function wplister_on_woocommerce_product_save( $post_id, $post ) {

		if ( !$_POST ) return $post_id;
		if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post_id ) ) ) return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		if ( isset( $_POST['woocommerce_quick_edit_nonce'] ) ) return $post_id;
		if ( !current_user_can( 'edit_post', $post_id )) return $post_id;
		if ( $post->post_type != 'product' ) return $post_id;

		// global $woocommerce, $wpdb;
		// $product = self::getProduct( $post_id );

		// don't mark as changed when listing has been revised earlier in this request
		if ( isset( $_POST['wpl_ebay_revise_on_update'] ) ) return;
		if ( isset( $_POST['wpl_ebay_relist_on_update'] ) ) return;

		$lm = new ListingsModel();
		$lm->markItemAsModified( $post_id );

		// auto-revise locked variations to make up for the lack of autorevise checkbox in the page #15922
        $listings = WPLE_ListingQueryHelper::getAllListingsFromParentID( $post_id );
        if ( is_array( $listings ) ) {
            foreach ( $listings as $listing ) {
                if ( $listing->locked ) {
                    do_action( 'wplister_revise_inventory_status', $listing->post_id );
                }
            }
        }

		// // if this a quickedit request, continue and revise inventory status of locked items
		// if ( !isset($_POST['woocommerce_quick_edit_nonce']) || (isset($_POST['woocommerce_quick_edit_nonce']) && !wp_verify_nonce( $_POST['woocommerce_quick_edit_nonce'], 'woocommerce_quick_edit_nonce' ))) return $post_id;
		// do_action( 'wplister_product_has_changed', $post_id );

		// Clear transient
		// $woocommerce->clear_product_transients( $post_id );
	}
	// add_action( 'save_post', 'wplister_on_woocommerce_product_save', 10, 2 );


	// hook into save_post to mark listing as changed when a product is updated via bulk update
	function wplister_on_woocommerce_product_bulk_edit_save( $post_id, $post ) {

		if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post_id ) ) ) return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		if ( ! isset( $_REQUEST['woocommerce_bulk_edit_nonce'] ) || ! wp_verify_nonce( $_REQUEST['woocommerce_bulk_edit_nonce'], 'woocommerce_bulk_edit_nonce' ) ) return $post_id;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
		if ( $post->post_type != 'product' ) return $post_id;

		// $lm = new ListingsModel();
		// $lm->markItemAsModified( $post_id );
		do_action( 'wplister_product_has_changed', $post_id );

	}
	// add_action( 'save_post', 'wplister_on_woocommerce_product_bulk_edit_save', 10, 2 );


	// hook into save_post to mark listing as changed when a product is updated via quick edit
	function wple_woocommerce_product_quick_edit_save( $_product ) {

		if ( ! $_product || ! is_object( $_product ) ) return;
		$post_id = wple_get_product_meta( $_product, 'id' );

		if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post_id ) ) ) return;
		// if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		$lm = new ListingsModel();
		$lm->markItemAsModified( $post_id );

		// since this a quickedit request, continue and revise inventory status of locked items
		do_action( 'wplister_product_has_changed', $post_id );

	}
	// add_action( 'woocommerce_product_quick_edit_save', 'wple_woocommerce_product_quick_edit_save', 10, 2 );

	/**
	 * Handle requests to prepare/list a product from the Edit Product screen's sidebar
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 *
	 * @return int|void
	 */
	public function handle_list_on_ebay_request( $post_id, $post ) {
		// hook into save_post to mark listing as changed when a product is updated via bulk update
		if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post_id ) ) ) return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

		if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
		if ( $post->post_type != 'product' ) return $post_id;

		if ( empty( $_POST['wplister_list_on_ebay'] ) || empty( $_POST['wplister_list_profile'] ) ) {
			return $post_id;
		}

		$lm = new ListingsModel();
		$profile_id = absint( $_POST['wplister_list_profile'] );

		// prepare new listings from products
		$listing_id = $lm->prepareProductForListing( $post_id, $profile_id );
		$item = $lm->getItem( $listing_id );

		// get and apply profile
		$profilesModel = new ProfilesModel();
		$profile = $profilesModel->getItem( $profile_id );
		$lm->applyProfileToItem( $profile, $item );
	}

	/**
	 * Handle requests to switch to another profile
	 *
	 * @param int $post_id
	 * @param WP_Post $post
	 *
	 * @return int|void
	 */
	public function handle_switch_profile_request( $post_id, $post ) {
		// hook into save_post to mark listing as changed when a product is updated via bulk update
		if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
		if ( is_int( wp_is_post_autosave( $post_id ) ) ) return;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

		if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
		if ( $post->post_type != 'product' ) return $post_id;

		if ( empty( $_POST['wplister_switch_profile'] ) || empty( $_POST['wplister_switch_profile_id'] ) ) {
			return $post_id;
		}

		$lm       = new ListingsModel();
		$listings = WPLE_ListingQueryHelper::getAllListingsFromPostOrParentID( $post_id );
		$pm       = new ProfilesModel();
		$profile  = $pm->getItem( $_POST['wplister_switch_profile_id'] );

		foreach ( $listings as $item ) {
			$item = (array) $item;
			$lm->applyProfileToItem( $profile, $item );
		}

	}

    /**
     * handle duplicate product action to copy over ebay metadata for WC 3.0
     * @param WC_Product $duplicate
     * @param WC_Product $product
     */
    function woocommerce_duplicate_product_meta( $duplicate, $product ) {
        $metadata       = get_post_meta( wple_get_product_meta( $product, 'id' ) );
        $excluded_meta  = array('_ebay_upc', '_ebay_ean', '_ebay_mpn', '_ebay_isbn', '_ebay_epid', '_ebay_gallery_image_url', '_ebay_item_id', '_ebay_item_source' );
        $new_product_id = wple_get_product_meta( $duplicate, 'id' );

        foreach ( $metadata as $meta => $value ) {
            if ( substr( $meta, 0, 5 ) != '_ebay' ) {
                continue;
            }

            if ( in_array( $meta, $excluded_meta ) ) {
                continue;
            }

            $value = maybe_unserialize( current( $value ) );
            update_post_meta( $new_product_id, $meta, $value );
        }

    }

    // hook into save_post to mark listing as changed when a product is updated via the REST API
    function wple_on_woocommerce_api_product_save( $post, $request ) {
        WPLE()->logger->info( 'wple_on_woocommerce_api_product_save triggered!' );

        if ( isset( $post->ID ) ) {
            $post_id = $post->ID;
        } else {
            $post_id = $post->get_parent_id();
            WPLE()->logger->info( 'parent: '. $post_id );
            if ( ! $post_id ) {
                $post_id = $post->get_id();
            }
        }
        WPLE()->logger->info( 'post_id: '. $post_id );

        if ( is_int( wp_is_post_revision( $post_id ) ) ) return;
        if ( is_int( wp_is_post_autosave( $post_id ) ) ) return;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        // if ( !isset($_POST['woocommerce_quick_edit_nonce']) || (isset($_POST['woocommerce_quick_edit_nonce']) && !wp_verify_nonce( $_POST['woocommerce_quick_edit_nonce'], 'woocommerce_quick_edit_nonce' ))) return $post_id;
        if ( !current_user_can( 'edit_post', $post_id )) return;

        //$lm = new ListingsModel();
        //$lm->markItemAsModified( $post_id );

        // Triggering wplister_product_has_changed automatically revises locked listings
        do_action( 'wplister_product_has_changed', $post_id );

    }

    /**
     * Hooks into woocommerce_update_product to mark the passed ID as changed.
     * Only run during WC product import process.
     *
     * @param int $product_id
     */
    function handle_product_update( $product_id ) {
        if ( is_int( wp_is_post_revision( $product_id ) ) ) return;
        if ( is_int( wp_is_post_autosave( $product_id ) ) ) return;

        if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'woocommerce_do_ajax_product_import' ) {
            do_action( 'wplister_product_has_changed', $product_id );
        }
    }

	/*
	add_action( 'pre_get_posts', 'wplister_pre_get_posts' ); //hook into the query before it is executed

	function wplister_pre_get_posts( $query )
	{
	    global $custom_where_string;
		$custom_where_string = ''; //used to save the generated where string between filter functions

	    //if the custom parameter is used
	    // if(isset($query->query_vars['_spec'])){
	    if(isset( $_GET['is_on_ebay'] )){

	        //here you can parse the contents of $query->query_vars['_spec'] to modify the query
	        //even the first WHERE starts with AND, because WP adds a "WHERE 1=1" in front of every WHERE section
	        $custom_where_string = 'AND ...';

	        //only if the custom parameter is used, hook into the generation of the query
	        // add_filter('posts_where', 'wplister_posts_where');
	    }
	}

	function wplister_posts_where( $where )
	{
	    global $custom_where_string;

	    echo "<pre>";print_r($where);echo"</pre>";die();

	    //append our custom where expression(s)
	    $where .= $custom_where_string;

	    //clean up to avoid unexpected things on other queries
	    remove_filter('posts_where', 'wplister_posts_where');
	    $custom_where_string = '';

	    return $where;
	}
	*/

	// filter the products in admin based on ebay status
	// deprecated - switched to using subqueries in wplister_woocommerce_admin_product_query_where()
	// add_filter( 'parse_query', 'wplister_woocommerce_admin_product_filter_query' );
	/*
	function wplister_woocommerce_admin_product_filter_query( $query ) {
		global $typenow, $wp_query, $wpdb;

	    if ( $typenow == 'product' ) {

	    	// filter by ebay status
	    	if ( ! empty( $_GET['is_on_ebay'] ) ) {

	        	// find all products that hidden from ebay
	        	$sql = "
	        			SELECT post_id 
	        			FROM {$wpdb->prefix}postmeta 
					    WHERE meta_key   = '_ebay_hide_from_unlisted'
					      AND meta_value = 'yes'
	        	";
	        	$post_ids_hidden_from_ebay = $wpdb->get_col( $sql );
	        	// echo "<pre>";print_r($post_ids_hidden_from_ebay);echo"</pre>";#die();


		    	if ( $_GET['is_on_ebay'] == 'yes' ) {

		        	// find all products that are already on ebay
		        	// (all products which are actually published or changed)
		        	$sql = "
		        			SELECT {$wpdb->prefix}posts.ID 
		        			FROM {$wpdb->prefix}posts 
						    LEFT JOIN {$wpdb->prefix}ebay_auctions
						         ON ( {$wpdb->prefix}posts.ID = {$wpdb->prefix}ebay_auctions.post_id OR
						              {$wpdb->prefix}posts.ID = {$wpdb->prefix}ebay_auctions.parent_id )
						    WHERE {$wpdb->prefix}ebay_auctions.status = 'published'
						       OR {$wpdb->prefix}ebay_auctions.status = 'changed'
		        	";
						    // WHERE {$wpdb->prefix}ebay_auctions.ebay_id != ''
		        	$post_ids_on_ebay = $wpdb->get_col( $sql );
		        	// echo "<pre>";print_r($post_ids_on_ebay);echo"</pre>";#die();

					// combine arrays
					$post_ids = array_diff( $post_ids_on_ebay, $post_ids_hidden_from_ebay );
		        	// echo "<pre>";print_r($post_ids);echo"</pre>";die();

		        	if ( is_array($post_ids) && ( sizeof($post_ids) > 0 ) ) {
			        	if ( ! empty( $query->query_vars['post__in'] ) ) {
				        	$query->query_vars['post__in'] = array_intersect( $query->query_vars['post__in'], $post_ids );
			        	} else {
				        	$query->query_vars['post__in'] = $post_ids;
			        	}
		        	}

		        } elseif ( $_GET['is_on_ebay'] == 'no' ) {

		        	// find all products that are already on ebay
		        	// (all products which exist in WP-Lister, except for archived items)
		        	$sql = "
		        			SELECT {$wpdb->prefix}posts.ID 
		        			FROM {$wpdb->prefix}posts 
						    LEFT JOIN {$wpdb->prefix}ebay_auctions
						         ON ( {$wpdb->prefix}posts.ID = {$wpdb->prefix}ebay_auctions.post_id OR
						              {$wpdb->prefix}posts.ID = {$wpdb->prefix}ebay_auctions.parent_id )
						    WHERE {$wpdb->prefix}ebay_auctions.status != 'archived'
		        	";
						    // WHERE {$wpdb->prefix}ebay_auctions.ebay_id != ''
		        	$post_ids_on_ebay = $wpdb->get_col( $sql );
		        	// echo "<pre>";print_r($post_ids_on_ebay);echo"</pre>";#die();

					// combine arrays
					$post_ids = array_merge( $post_ids_on_ebay, $post_ids_hidden_from_ebay );
		        	// echo "<pre>";print_r($post_ids);echo"</pre>";die();

		        	if ( is_array($post_ids) && ( sizeof($post_ids) > 0 ) ) {
			        	// $query->query_vars['post__not_in'] = $post_ids;
			        	$query->query_vars['post__not_in'] = array_merge( $query->query_vars['post__not_in'], $post_ids );
		        	}

		        	// only show products in stock - out of stock products are not interesting when filtering for "not on eBay"
		        	$query->query_vars['meta_value'] 	= 'instock';
		        	$query->query_vars['meta_key'] 		= '_stock_status';

		        	// $query->query_vars['meta_query'] = array(
					// 	'relation' => 'OR',
					// 	array(
					// 		'key' => '_ebay_item_id',
					// 		'value' => ''
					// 	),
					// 	array(
					// 		'key' => '_ebay_item_id',
					// 		'value' => '',
					// 		'compare' => 'NOT EXISTS'
					// 	)
					// );

		        }
	        }

		}

	} // wplister_woocommerce_admin_product_filter_query()
	*/

	/**
	 * Register the WHERE clause when listing 'On eBay' and 'Not on eBay' products
	 * @param string $where
	 * @return string
	 */
	public function wplister_woocommerce_admin_product_query_where( $where ) {
		global $typenow, $wpdb;

		if ( 'product' == $typenow ) {
			// filter by ebay status
			if ( ! empty( $_GET['is_on_ebay'] ) ) {
				if ( $_GET['is_on_ebay'] == 'yes' ) {
					$where .= " AND ( 
					                {$wpdb->posts}.ID IN (
					                    SELECT {$wpdb->prefix}ebay_auctions.post_id
                                        FROM {$wpdb->prefix}ebay_auctions
                                        WHERE (
                                            {$wpdb->posts}.ID = {$wpdb->prefix}ebay_auctions.post_id
                                            OR {$wpdb->posts}.ID = {$wpdb->prefix}ebay_auctions.parent_id
                                        )
                                        AND {$wpdb->prefix}ebay_auctions.status IN ('published', 'changed')
								    )
								    OR
								    {$wpdb->posts}.ID IN (
								        SELECT {$wpdb->prefix}ebay_auctions.post_id 
                                        FROM {$wpdb->prefix}ebay_auctions, {$wpdb->posts} 
                                        WHERE {$wpdb->prefix}posts.ID = {$wpdb->prefix}ebay_auctions.post_id AND {$wpdb->prefix}ebay_auctions.status = 'ended'
                                        AND {$wpdb->prefix}posts.ID IN (
                                            SELECT parent_id FROM {$wpdb->prefix}ebay_auctions WHERE {$wpdb->prefix}ebay_auctions.status IN ('published', 'changed')
                                        )

								    )
                                )";
				} elseif ( $_GET['is_on_ebay'] == 'no' ) {
					$where .= " AND {$wpdb->posts}.ID NOT IN (
					                SELECT {$wpdb->prefix}ebay_auctions.post_id
					                FROM {$wpdb->prefix}ebay_auctions
									WHERE (
										{$wpdb->posts}.ID = {$wpdb->prefix}ebay_auctions.post_id
										OR {$wpdb->posts}.ID = {$wpdb->prefix}ebay_auctions.parent_id
									)
									AND {$wpdb->prefix}ebay_auctions.status != 'archived'
								)
								AND {$wpdb->posts}.ID NOT IN (
					                SELECT {$wpdb->prefix}ebay_auctions.parent_id
					                FROM {$wpdb->prefix}ebay_auctions
									WHERE (
										{$wpdb->posts}.ID = {$wpdb->prefix}ebay_auctions.post_id
									)
									AND {$wpdb->prefix}ebay_auctions.status != 'archived'
								)";
				}
			}
		}

		return $where;
	}

	/**
	 * Filter the products to be displayed in the 'On eBay' and 'Not on eBay' lists
	 *
	 * Hide out of stock products and those marked as hidden
	 *
	 * @param WP_Query $query
	 */
	public function wplister_woocommerce_admin_product_query_filters( $query ) {
		global $typenow, $wp_query, $wpdb;

		if ( $typenow == 'product' ) {

			// filter by ebay status
			if ( ! empty( $_GET['is_on_ebay'] ) ) {
				// find all products that hidden from ebay
				$sql = "
	        			SELECT post_id
	        			FROM {$wpdb->prefix}postmeta
					    WHERE meta_key   = '_ebay_hide_from_unlisted'
					      AND meta_value = 'yes'
	        	";
				$post_ids_hidden_from_ebay = $wpdb->get_col( $sql );

				$query->query_vars['post__not_in'] = array_merge( $query->query_vars['post__not_in'], $post_ids_hidden_from_ebay );

				// // only show products in stock - out of stock products are not interesting when filtering for "not on eBay"
				// // if the meta_key query var is used (in sorting products), use the meta_query array to filter out out-of-stock listings #18205
				// // disabled - should never have been enabled for "on ebay" but isn't very useful anymore and disabling will improve performance #23228
				// if ( empty( $query->query_vars['meta_key'] ) ) {
				//     $query->query_vars['meta_value'] 	= 'instock';
				//     $query->query_vars['meta_key'] 		= '_stock_status';
				// } else {
				//     $query->query_vars['meta_query']['instock_clause'] = array(
				//         'key' => '_stock_status',
				//         'value' => 'instock',
				//         'compare' => '='
				//     );
				// }

			}
		}
	}

	// filter the orders in admin based on ebay status
	// this version is deprecated - the post__in parameter seems to fail when there are more than 2000 IDs
	// add_filter( 'parse_query', 'wplister_woocommerce_admin_order_filter_query' );
	function wplister_woocommerce_admin_order_filter_query_v1( $query ) {
		global $typenow, $wp_query, $wpdb;

	    if ( $typenow == 'shop_order' ) {

	    	// filter by ebay status
	    	if ( ! empty( $_GET['is_from_ebay'] ) ) {

	        	// find all orders that are imported from ebay
	        	$sql = "
	        			SELECT DISTINCT post_id 
	        			FROM {$wpdb->prefix}postmeta 
					    WHERE meta_key = '_ebay_order_id'
	        	";
	        	$post_ids = $wpdb->get_col( $sql );
	        	// echo "<pre>";print_r($post_ids);echo"</pre>";#die();


		    	if ( $_GET['is_from_ebay'] == 'yes' ) {

		        	if ( is_array($post_ids) && ( sizeof($post_ids) > 0 ) ) {
			        	$query->query_vars['post__in'] = $post_ids;
		        	}

		        } elseif ( $_GET['is_from_ebay'] == 'no' ) {

		        	if ( is_array($post_ids) && ( sizeof($post_ids) > 0 ) ) {
			        	// $query->query_vars['post__not_in'] = $post_ids;
			        	$query->query_vars['post__not_in'] = array_merge( $query->query_vars['post__not_in'], $post_ids );
		        	}


		        }
	        }

		}

	} // wplister_woocommerce_admin_order_filter_query_v1()

	// filter the orders in admin based on ebay status
	// add_filter( 'parse_query', 'wplister_woocommerce_admin_order_filter_query' );
	function wplister_woocommerce_admin_order_filter_query( $query ) {
		global $typenow, $wp_query, $wpdb;

	    if ( $typenow == 'shop_order' ) {

	    	// filter by ebay status
	    	if ( ! empty( $_GET['is_from_ebay'] ) ) {

		    	if ( $_GET['is_from_ebay'] == 'yes' ) {

    		        $account_id = isset($_REQUEST['wple_account_id']) ? $_REQUEST['wple_account_id'] : false;
    		        if ( $account_id ) {

    		        	// find post_ids for all orders for this account
    		        	$post_ids = array();
    		        	$orders = EbayOrdersModel::getWhere( 'account_id', $account_id );
    		        	foreach ($orders as $order) {
    		        		if ( ! $order->post_id ) continue;
    		        		$post_ids[] = $order->post_id;
    		        	}
	    		        if ( empty( $post_ids ) ) $post_ids = array('0');

			        	$query->query_vars['post__in'] = $post_ids;

    		        } else {

			        	$query->query_vars['meta_query'][] = array(
							'key'     => '_ebay_order_id',
							'compare' => 'EXISTS'
						);

    		        }

		        } elseif ( $_GET['is_from_ebay'] == 'no' ) {

		        	$query->query_vars['meta_query'][] = array(
						'key'     => '_ebay_order_id',
						'compare' => 'NOT EXISTS'
					);

		        }

	        }

		}

	} // wplister_woocommerce_admin_order_filter_query()

	// # debug final query
	// add_filter( 'posts_results', 'wplister_woocommerce_admin_product_filter_posts_results' );
	// function wplister_woocommerce_admin_product_filter_posts_results( $posts ) {
	// 	global $wp_query;
	// 	echo "<pre>";print_r($wp_query->request);echo"</pre>";#die();
	// 	return $posts;
	// }

	// add custom view to woocommerce products table
	// add_filter( 'views_edit-product', 'wplister_add_woocommerce_product_views' );
	function wplister_add_woocommerce_product_views( $views ) {
		global $wp_query;

		if ( ! current_user_can('edit_others_pages') ) return $views;

        // Count items on/not on eBay
        $on_ebay_count      = '';
        $not_on_ebay_count  = '';

        if ( get_option( 'wplister_display_product_counts', 1 ) ) {
            $on_ebay_count     = '('. number_format( WPLE_ListingQueryHelper::countProductsOnEbay() ) .')';
            $not_on_ebay_count = '('. number_format( WPLE_ListingQueryHelper::countProductsNotOnEbay() ) .')';
        }

		// On eBay
		// $class = ( isset( $wp_query->query['is_on_ebay'] ) && $wp_query->query['is_on_ebay'] == 'no' ) ? 'current' : '';
		$class = ( isset( $_REQUEST['is_on_ebay'] ) && $_REQUEST['is_on_ebay'] == 'yes' ) ? 'current' : '';
		$query_string = esc_url_raw( remove_query_arg( array( 'is_on_ebay' ) ) );
		$query_string = add_query_arg( 'is_on_ebay', urlencode('yes'), $query_string );
		$views['listed'] = sprintf( '<a href="%s" class="%s">%s %s</a>', $query_string, $class, __('On eBay', 'wplister'), $on_ebay_count );

		// Not on eBay
		$class = ( isset( $_REQUEST['is_on_ebay'] ) && $_REQUEST['is_on_ebay'] == 'no' ) ? 'current' : '';
		$query_string = esc_url_raw( remove_query_arg( array( 'is_on_ebay' ) ) );
		$query_string = add_query_arg( 'is_on_ebay', urlencode('no'), $query_string );
		$views['unlisted'] = sprintf( '<a href="%s" class="%s">%s %s</a>', $query_string, $class, __('Not on eBay', 'wplister'), $not_on_ebay_count );

		// debug query
		// $views['unlisted'] .= "<br>".$wp_query->request."<br>";

		return $views;
	}

	// add hidden field on woocommerce products page - to make search form work with custom filter
	// add_filter( 'restrict_manage_posts', 'wplister_add_woocommerce_product_hidden_filter_fields' );
	function wplister_add_woocommerce_product_hidden_filter_fields( $post_type ) {

		if ( $post_type != 'product' ) return;
		if ( ! isset( $_REQUEST['is_on_ebay'] ) ) return;

	    echo '<input type="hidden" name="is_on_ebay" value="' . $_REQUEST['is_on_ebay'] . '" />';

	}


	// add custom view to woocommerce orders table
	// add_filter( 'views_edit-order', 'wplister_add_woocommerce_order_views' );
	function wplister_add_woocommerce_order_views( $views ) {
		global $wp_query;

		if ( ! current_user_can('edit_others_pages') ) return $views;
		if ( WPLISTER_LIGHT ) return $views;

		// Placed on eBay
		// $class = ( isset( $wp_query->query['is_from_ebay'] ) && $wp_query->query['is_from_ebay'] == 'no' ) ? 'current' : '';
		$class = ( isset( $_REQUEST['is_from_ebay'] ) && $_REQUEST['is_from_ebay'] == 'yes' ) ? 'current' : '';
		$query_string = esc_url_raw( remove_query_arg( array( 'is_from_ebay' ) ) );
		$query_string = add_query_arg( 'is_from_ebay', urlencode('yes'), $query_string );
		$views['listed'] = '<a href="'. $query_string . '" class="' . $class . '">' . __('Placed on eBay', 'wplister') . '</a>';

		// Not placed on eBay
		$class = ( isset( $_REQUEST['is_from_ebay'] ) && $_REQUEST['is_from_ebay'] == 'no' ) ? 'current' : '';
		$query_string = esc_url_raw( remove_query_arg( array( 'is_from_ebay' ) ) );
		$query_string = add_query_arg( 'is_from_ebay', urlencode('no'), $query_string );
		$views['unlisted'] = '<a href="'. $query_string . '" class="' . $class . '">' . __('Not placed on eBay', 'wplister') . '</a>';

		// debug query
		// $views['unlisted'] .= "<br>".$wp_query->request."<br>";

		return $views;
	}




	/**
	 * Output product update options.
	 *
	 * @access public
	 * @return void
	 */
	// add_action( 'post_submitbox_misc_actions', 'wplister_product_submitbox_misc_actions', 100 );
	function wplister_product_submitbox_misc_actions() {
		global $post;
		global $woocommerce;

		if ( $post->post_type != 'product' )
			return;

		// if product has been imported from ebay...
		$this->wplister_product_submitbox_imported_status();

		// check listing status
		// $listingsModel = new ListingsModel();
		// $status = WPLE_ListingQueryHelper::getStatusFromPostID( $post->ID );
		// if ( ! in_array($status, array('published','changed','ended','sold','prepared','verified') ) ) return;

		// get first item
		// $listings = WPLE_ListingQueryHelper::getAllListingsFromPostID( $post->ID );
		// if ( sizeof($listings) == 0 ) return;
		// $item = $listings[0];

		// get all listings for product ID - including check for split variations
		$listings = WPLE_ListingQueryHelper::getAllListingsFromPostOrParentID( $post->ID );
		if ( empty($listings) ) {
			// add action to list this on ebay
			$this->show_add_to_ebay_form( $post );
			return;
		}

		// use different template if there are multiple results
		if ( sizeof($listings) > 1 )
			return $this->wplister_product_submitbox_for_multiple_items( $listings );

		// get status of first listing
		$item   = $listings[0];
		$status = $listings[0]->status;

        // show locked indicator
        if ( @$item->locked ) {
            $tip_msg = 'This listing is currently locked.<br>Only inventory changes and prices will be updated, other changes will be ignored.<br><br>(Except for variable products where not all variations have a unique SKU, or when new variations are added, or for flattened variations. In these cases, the item will be revised in full.)';
            $img_url = WPLISTER_URL . '/img/lock-1.png';
            $locktip = '<img src="'.$img_url.'" style="height:11px; padding:0;" class="tips" data-tip="'.$tip_msg.'"/>&nbsp;';
        } 

		?>
		
		<style type="text/css">
			#wpl_ebay_revise_on_update,
			#wpl_ebay_relist_on_update {
				width: auto;
				/*margin-left: 1em;*/
				float: right;
			}
			.wpl_ebay_revise_on_update_field { margin:0; }
			.wpl_ebay_relist_on_update_field { margin:0; }
		</style>

		<div class="misc-pub-section" id="wplister-submit-options">

			<input type="hidden" name="wpl_ebay_listing_id" value="<?php echo $item->id ?>" />

			<?php _e( 'eBay listing is', 'wplister' ); ?>
			<b><?php echo $item->status; ?></b>

			<?php if ( isset($locktip) ) echo $locktip ?>

			<?php if ( isset($item->ViewItemURL) && $item->ViewItemURL ) : ?>
				<a href="<?php echo $item->ViewItemURL ?>" target="_blank" style="float:right;">
					<?php echo __('View on eBay', 'wplister') ?>
				</a>
			<?php elseif ( $item->status == 'prepared' ) : ?>
				<a href="<?php echo wp_nonce_url( 'admin.php?page=wplister&amp;action=wple_verify&amp;auction='. $item->id, 'bulk-auctions' ); ?>" style="float:right;">
					<?php echo __('Verify', 'wplister') ?>
				</a>
			<?php elseif ( $item->status == 'verified' ) : ?>
				<a href="<?php echo wp_nonce_url( 'admin.php?page=wplister&amp;action=wple_publish2e&amp;auction='. $item->id, 'wplister_publish2e' ); ?>" style="float:right;">
					<?php echo __('Publish', 'wplister') ?>
				</a>
			<?php endif; ?>

			<br>

			<?php 
				// show revise checkbox for published listings
				if ( in_array($status, array('published','changed') ) )
					$this->wplister_product_submitbox_revise_checkbox( $item );
			?>

			<?php 
				// show relist checkbox for ended listings
				if ( in_array($status, array('ended','sold') ) )
					$this->wplister_product_submitbox_relist_checkbox( $item );

				// show switch profile form
				$this->show_switch_profile_form( $item );
			?>

			<?php /* if ( in_array($status, array('ended','sold') ) ) : ?>
				<a href="admin.php?page=wplister&amp;action=relist&amp;auction=<?php echo $item->id ?>" 
					onclick="return confirm('Are you sure you want to relist this product on eBay?');" style="float:right;">
					<?php echo __('Relist', 'wplister') ?>
				</a>
			<?php endif; */ ?>

		</div>
		<?php
	} // wplister_product_submitbox_misc_actions()

	// show list of all found items
	function wplister_product_submitbox_for_multiple_items( $listings ) {
		?>
		<div class="misc-pub-section" id="wplister-submit-options">
		<?php echo sprintf( __( 'This product is linked to %s eBay listings', 'wplister' ), sizeof($listings) ); ?>:<br>
		<?php foreach( $listings as $item ) : ?>

			<b><?php echo $item->ebay_id; ?></b>
			<i><?php echo $item->status; ?></i>

			<?php if ( isset($locktip) ) echo $locktip ?>

			<?php if ( isset($item->ViewItemURL) && $item->ViewItemURL ) : ?>
				<a href="<?php echo $item->ViewItemURL ?>" target="_blank" style="float:right;">
					<?php echo __('View on eBay', 'wplister') ?>
				</a>
			<?php elseif ( $item->status == 'prepared' ) : ?>
				<a href="<?php echo wp_nonce_url( 'admin.php?page=wplister&amp;action=wple_verify&amp;auction='. $item->id, 'bulk-auctions' ); ?>" style="float:right;">
					<?php echo __('Verify', 'wplister') ?>
				</a>
			<?php elseif ( $item->status == 'verified' ) : ?>
				<a href="<?php echo wp_nonce_url( 'admin.php?page=wplister&amp;action=wple_publish2e&amp;auction='. $item->id, 'wplister_publish2e' ); ?>" style="float:right;">
					<?php echo __('Publish', 'wplister') ?>
				</a>
			<?php endif; ?>

			<br>

		<?php
		endforeach;

		$this->show_switch_profile_form_for_multiple_items( $listings );
		?>
		</div>
		<?php

	} // wplister_product_submitbox_for_multiple_items()

	// draw checkbox to revise item
	function wplister_product_submitbox_revise_checkbox( $item ) {
		global $woocommerce;

		// prevent wp_kses_post() from removing the data-tip attribute
		global $allowedposttags;
		$allowedposttags['img']['data-tip'] = true;

		if ( $item->locked ) {

			$tip = __('This listing is locked. When this product is changed, its price and stock level will be updated automatically on eBay.', 'wplister');
			$tip .= '<br>'; 
			$tip .= __('If the product is out of stock, the listing will be ended on eBay.', 'wplister');
			$tip = '<img class="help_tip" data-tip="' . esc_attr( $tip ) . '" src="' . $woocommerce->plugin_url() . '/assets/images/help.png" height="16" width="16" />';

			woocommerce_wp_checkbox( array( 
				'id'    => 'wpl_ebay_revise_on_update', 
				'label' => __('Revise inventory on update', 'wplister') . $tip,
				// 'description' => __('Revise on eBay', 'wplister'),
				'value' => 'yes'
			) );

		} else {

			$tip = __('Revise eBay listing when updating the product', 'wplister') . '. '; 
			$tip .= __('If the product is out of stock, the listing will be ended on eBay.', 'wplister');
			$tip = '<img class="help_tip" data-tip="' . esc_attr( $tip ) . '" src="' . $woocommerce->plugin_url() . '/assets/images/help.png" height="16" width="16" />';

			woocommerce_wp_checkbox( array( 
				'id'    => 'wpl_ebay_revise_on_update', 
				'label' => __('Revise listing on update', 'wplister') . $tip,
				// 'description' => __('Revise on eBay', 'wplister'),
				'value' => get_option( 'wplister_revise_on_update_default', false )
			) );

		}

	} // wplister_product_submitbox_revise_checkbox()


	// draw checkbox to relist item
	function wplister_product_submitbox_relist_checkbox( $item ) {
		global $woocommerce;

		// prevent wp_kses_post() from removing the data-tip attribute
		global $allowedposttags;
		$allowedposttags['img']['data-tip'] = true;


		$tip = __('Relist eBay listing when updating the product', 'wplister') . '. '; 
		$tip .= __('If the product is out of stock, it can not be relisted on eBay.', 'wplister');
		$tip = '<img class="help_tip" data-tip="' . esc_attr( $tip ) . '" src="' . $woocommerce->plugin_url() . '/assets/images/help.png" height="16" width="16" />';

		woocommerce_wp_checkbox( array( 
			'id'    => 'wpl_ebay_relist_on_update', 
			'label' => __('Relist item', 'wplister') . $tip,
			// 'description' => __('Relist on eBay', 'wplister'),
			// 'value' => get_option( 'wplister_relist_on_update_default', false )
			'value' => false
		) );


	} // wplister_product_submitbox_relist_checkbox()

	// if product has been imported from ebay...
	function wplister_product_submitbox_imported_status() {
		global $post;
		global $woocommerce;

		$item_source = get_post_meta( $post->ID, '_ebay_item_source', true );
		if ( ! $item_source ) return;

		$ebay_id = get_post_meta( $post->ID, '_ebay_item_id', true );

		// get ViewItemURL - fall back to generic url on ebay.com
		$ebay_url = WPLE_ListingQueryHelper::getViewItemURLFromPostID( $post->ID );
		if ( ! $ebay_url ) $ebay_url = 'http://www.ebay.com/itm/'.$ebay_id;

		?>

		<div class="misc-pub-section" id="wplister-submit-options">

			<?php _e( 'This product was imported', 'wplister' ); ?>
				<!-- <b><?php //echo $item->status; ?></b> &nbsp; -->
				<a href="<?php echo $ebay_url ?>" target="_blank" style="float:right;">
					<?php echo __('View on eBay', 'wplister') ?>
				</a>
			<br>

		</div>
		<?php
	}


	// handle submitbox options
	// add_action( 'woocommerce_process_product_meta', 'wplister_product_handle_submitbox_actions', 100, 2 );
	function wplister_product_handle_submitbox_actions( $post_id, $post ) {

		if ( isset( $_POST['wpl_ebay_revise_on_update'] ) ) {
			// call markItemAsModified() to re-apply the listing profile
			$lm = new ListingsModel();
			$lm->markItemAsModified( $post_id );

			WPLE()->logger->info('revising listing '.$_POST['wpl_ebay_listing_id'] );

			$listing = ListingsModel::getItem( $_POST['wpl_ebay_listing_id'] );

			if ( $listing ) {
                // call EbayController
                WPLE()->initEC( $listing['account_id'] );
                $results = WPLE()->EC->reviseItems( $listing['id'] );
                WPLE()->EC->closeEbay();

                WPLE()->logger->info('revised listing '. $listing['id'] );
            }

			// $message = __('Selected items were revised on eBay.', 'wplister');
			// $message .= ' ID: '.$_POST['wpl_ebay_listing_id'];
			// $class = (false) ? 'error' : 'updated';
			// echo '<div id="message" class="'.$class.'" style="display:block !important"><p>'.$message.'</p></div>';

		}

		if ( isset( $_POST['wpl_ebay_relist_on_update'] ) ) {

			// call markItemAsModified() to re-apply the listing profile
			$lm = new ListingsModel();
			$lm->markItemAsModified( $post_id );

			WPLE()->logger->info('relisting listing '.$_POST['wpl_ebay_listing_id'] );

            $listing = ListingsModel::getItem( $_POST['wpl_ebay_listing_id'] );

            if ( $listing ) {
                // call EbayController
                WPLE()->initEC( $listing['account_id'] );
                $results = WPLE()->EC->relistItems( $_POST['wpl_ebay_listing_id'] );
                WPLE()->EC->closeEbay();

                WPLE()->logger->info('relisted listing '.$_POST['wpl_ebay_listing_id'] );
            }

			// $message = __('Selected items were revised on eBay.', 'wplister');
			// $message .= ' ID: '.$_POST['wpl_ebay_listing_id'];
			// $class = (false) ? 'error' : 'updated';
			// echo '<div id="message" class="'.$class.'" style="display:block !important"><p>'.$message.'</p></div>';

		}

	} // save_meta_box()

	/**
	 * Allow to list on ebay from the edit product page sidebar
	 * @param WP_Post $post
	 */
	public function show_add_to_ebay_form( $post ) {
		$pm = new ProfilesModel();
		$profiles = $pm->getAll();
		?>
		<div class="misc-pub-section" id="wplister-submit-options">
			<label>
				<input type="checkbox" name="wplister_list_on_ebay" value="yes" onchange='if (jQuery(this).is(":checked")) {jQuery("#wplister_list_profile_container").show() }else{ jQuery("#wplister_list_profile_container").hide()}'  />
				<?php _e( 'List on eBay', 'wplister' ); ?>
			</label>

			<p id="wplister_list_profile_container" style="display: none;">
				<select name="wplister_list_profile">
					<?php foreach ( $profiles as $profile ) : ?>
						<option value="<?php echo esc_attr( $profile['profile_id'] ); ?>"><?php echo esc_html( $profile['profile_name'] ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
		</div>
	<?php
	}

	/**
	 * Allow to switch profiles from the edit product page sidebar
	 * @param stdClass $item
	 */
	public function show_switch_profile_form( $item ) {
		$pm = new ProfilesModel();
		$profiles = $pm->getAll();
		?>
		<p id="wplister_switch_profile_container">
			<label>
				<input type="checkbox" name="wplister_switch_profile" value="yes" onchange='if (jQuery(this).is(":checked")) {jQuery("#wplister_switch_profile_id").show() }else{ jQuery("#wplister_switch_profile_id").hide()}'  />
				<?php _e( 'Switch Profile', 'wplister' ); ?>
			</label>
			<br/>
			<select name="wplister_switch_profile_id" id="wplister_switch_profile_id" style="display: none;">
				<?php foreach ( $profiles as $profile ) : ?>
					<option value="<?php echo esc_attr( $profile['profile_id'] ); ?>" <?php selected( $item->profile_id, $profile['profile_id'] ); ?>>
						<?php
						echo esc_html( $profile['profile_name'] );

						if ( $profile['profile_id'] == $item->profile_id ) {
							echo ' (current)';
						}
						?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
	}

	/**
	 * Allow to switch profiles for multiple listings from the edit product page sidebar
	 * @param stdClass[] $listings
	 */
	public function show_switch_profile_form_for_multiple_items( $listings ) {
		$pm = new ProfilesModel();
		$profiles = $pm->getAll();
		?>
		<p id="wplister_switch_profile_container">
			<label>
				<input type="checkbox" name="wplister_switch_profile" value="yes" onchange='if (jQuery(this).is(":checked")) {jQuery("#wplister_switch_profile_id").show() }else{ jQuery("#wplister_switch_profile_id").hide()}'  />
				<?php _e( 'Switch Profile', 'wplister' ); ?>
			</label>
			<br/>
			<select name="wplister_switch_profile_id" id="wplister_switch_profile_id" style="display: none;">
				<?php foreach ( $profiles as $profile ) : ?>
					<option value="<?php echo esc_attr( $profile['profile_id'] ); ?>">
						<?php echo esc_html( $profile['profile_name'] ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
	<?php
	}

	function wplister_product_updated_messages( $messages ) {
		global $post, $post_ID;

		// fetch last results
		$update_results = get_option( 'wplister_last_product_update_results', array() );
		if ( ! is_array($update_results) ) $update_results = array();

		// do nothing if no result for this product exists
		if ( ! isset( $update_results[ $post_ID ] ) ) return $messages;

		// show errors later
		add_action( 'admin_notices', array( &$this, 'wplister_product_updated_notices' ), 20 );

		$success = $update_results[ $post_ID ]->success;
		// $errors  = $update_results[ $post_ID ]->errors;

		// add message
		if ( $success )
			$messages['product'][1] = sprintf( __( 'Product and eBay listing were updated. <a href="%s">View Product</a>', 'wplister' ), esc_url( get_permalink($post_ID) ) );

		return $messages;
	}

	function wplister_product_updated_notices() {
		global $post, $post_ID;

		// make sure we show all admin messages - even the ones generated after the WP post_updated_messages hook has fired
		// do_action( 'wple_admin_notices' ); // does not work as expected, warning for non unique SKUs still doesn't show when locked item is revised from edit product page...

   		// fetch last results
		$update_results = get_option( 'wplister_last_product_update_results', array() );
		if ( ! is_array($update_results) ) $update_results = array();
		if ( ! isset( $update_results[ $post_ID ] ) ) return;


		$success = $update_results[ $post_ID ]->success;
		$errors  = $update_results[ $post_ID ]->errors;

		foreach ($errors as $error) {
			// hide redundant warnings like:
			// 21917091 - Warning: Requested StartPrice and Quantity revision is redundant
			// 21917092 - Warning: Requested Quantity revision is redundant.
			// 21916620 - Warning: Variations with quantity '0' will be removed
			if ( ! in_array( $error->ErrorCode, array( 21917091, 21917092, 21916620 ) ) )
				echo $error->HtmlMessage;
			
		}

		// unset last result
		unset( $update_results[ $post_ID ] );
		update_option( 'wplister_last_product_update_results', $update_results );

	} // wplister_product_updated_notices()


	function add_wc_order_table_filter_options() {
		global $typenow;
		if ( $typenow != 'shop_order' ) return;
		if ( ! isset( $_REQUEST['is_from_ebay'] ) ) return;

        $account_id   = isset($_REQUEST['wple_account_id']) ? $_REQUEST['wple_account_id'] : false;
        ?>

            <select name="wple_account_id">
                <option value=""><?php _e('All eBay accounts','wplister') ?></option>
                <?php foreach ( WPLE()->accounts as $account ) : ?>
                    <option value="<?php echo $account->id ?>"
                        <?php if ( $account_id == $account->id ) echo 'selected'; ?>
                        ><?php echo $account->title ?></option>
                <?php endforeach; ?>
            </select>            

            <input type="hidden" name="is_from_ebay" value="<?php echo isset($_REQUEST['is_from_ebay']) ? $_REQUEST['is_from_ebay'] : '' ?>">

        <?php
	} // add_wc_order_table_filter_options()

	/**
	 * Notify eBay when an item's stock is restored and the order's
	 * status is either cancelled or refunded
	 *
	 * @param WC_Order $order
	 */
	function order_stock_restored( $order ) {
		if ( !$order->has_status( array('refunded', 'cancelled') ) ) {
			return;
		}

		$order_items    = $order->get_items();
		$order_item_ids = isset( $_POST['order_item_ids'] ) ? $_POST['order_item_ids'] : array();
		$order_item_qty = isset( $_POST['order_item_qty'] ) ? $_POST['order_item_qty'] : array();

		if ( empty( $order_item_ids ) || empty( $order_item_qty ) ) {
			return;
		}

		if ( $order && ! empty( $order_items ) && sizeof( $order_item_ids ) > 0 ) {
			foreach ( $order_items as $item_id => $order_item ) {
				// Only reduce checked items
				if ( ! in_array( $item_id, $order_item_ids ) ) {
					continue;
				}

				$product_id = !empty( $order_item['variation_id'] ) ? $order_item['variation_id'] : $order_item['product_id'];

				do_action( 'wplister_revise_inventory_status', $product_id );
			}
		}
	}

	/**
	 * Notify WP-Lister of this product's quantity change after a refund
	 * @param int $product_id
	 */
	public function order_refund_stock_restored( $product_id ) {
	    if ( $parent_id = ProductWrapper::getVariationParent( $product_id ) ) {
            do_action( 'wplister_revise_inventory_status', $parent_id );
        } else {
            do_action( 'wplister_revise_inventory_status', $product_id );
        }
	}

	public function quick_edit_script() {
		$screen = get_current_screen();

		if ( ! $screen || 'edit-product' != $screen->id ) {
			return;
		}

		wp_enqueue_script( 'wplister-quick-edit', WPLISTER_URL . '/js/quick-edit.js', array('jquery') );
	}

	public function render_quick_edit_values( $column ) {
		global $post, $the_product;

		if ( $column == 'name' ) {

			$product_id = wple_get_product_meta( $the_product, 'id' );
			$listing_id = WPLE_ListingQueryHelper::getListingIDFromPostID( $product_id );

			if ( ! $listing_id ) {
				$listing_id = 0;
			}

			echo '
					<div class="hidden" id="wplister_inline_' . $post->ID . '">
						<div class="ebay_start_price">' . wple_get_product_meta( $product_id, 'ebay_start_price' ) . '</div>
						<div class="ebay_listing_id">' . $listing_id . '</div>
					</div>
				';
		}
	}

	/**
	 * Add the ability to update eBay listings through the Quick-Edit interface
	 *
	 * @param string $column_name
	 * @param string $post_type
	 */
	public function quick_edit( $column_name, $post_type ) {
		if ( 'price' != $column_name || 'product' != $post_type ) {
			return;
		}

		include WPLISTER_PATH . '/views/products_quick_edit.php';
	}

	/**
	 * @param $product
	 */
	public function quick_edit_save( $product ) {
	    $product_id = wple_get_product_meta( $product, 'id' );
		if ( isset( $_POST['_ebay_start_price'] ) ) {
			update_post_meta( $product_id, '_ebay_start_price', wc_clean( $_POST['_ebay_start_price'] ) );
		}

		if ( ! empty( $_POST['revise_listing'] ) && 'yes' == $_POST['revise_listing'] ) {
			// call markItemAsModified() to re-apply the listing profile
			$lm = new ListingsModel();
			$lm->markItemAsModified( $product_id );
			$listing_id = WPLE_ListingQueryHelper::getListingIDFromPostID( $product_id );

			WPLE()->logger->info('revising listing '. $listing_id );

			// call EbayController
			WPLE()->initEC();
			$results = WPLE()->EC->reviseItems( $listing_id );
			WPLE()->EC->closeEbay();

			WPLE()->logger->info('revised listing '.$listing_id );
		}
	}

    /**
     * Filter to return the ebay order number field rather than the post ID,
     * for display.
     *
     * @param string $order_number the order id with a leading hash
     * @param WC_Order $order the order object
     * @return string custom order number
     */
    public function get_ebay_order_number( $order_number, $order ) {

        $ebay_order_id = get_post_meta( wple_get_order_meta( $order, 'id' ), '_ebay_order_id', true );
        if ( $ebay_order_id ) {
            return $ebay_order_id;
        }

        return $order_number;
    }

    /**
     * Return the real order/post ID from the supplied eBay Order Number
     *
     * @param string $order_number
     * @return string custom order number
     */
    public function get_real_order_number( $order_number ) {
        // search for the order by custom order number
        $query_args = array(
            'numberposts' => 1,
            'meta_key'    => '_ebay_order_id',
            'meta_value'  => $order_number,
            'post_type'   => 'shop_order',
            'post_status' => 'any',
            'fields'      => 'ids',
        );

        $posts            = get_posts( $query_args );
        list( $order_id ) = ! empty( $posts ) ? $posts : null;

        // order was found
        if ( $order_id !== null ) {
            return $order_id;
        }

        // if no orders were found, simply return the order number to let other plugins run a search for it
        return $order_number;
    }

    /**
     * Add our custom _wpla_amazon_order_id to the set of search fields so that
     * the admin search functionality is maintained
     *
     * @param array $search_fields array of post meta fields to search by
     * @return array of post meta fields to search by
     */
    public function custom_search_fields( $search_fields ) {
        array_push( $search_fields, '_ebay_order_id' );

        return $search_fields;
    }
} // class WPL_WooBackendIntegration
global $WPL_WooBackendIntegration;
$WPL_WooBackendIntegration = new WPL_WooBackendIntegration();
