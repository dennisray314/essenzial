<?php
/**
 * EbayOrdersPage class
 * 
 */

class EbayOrdersPage extends WPL_Page {

	const slug = 'orders';

	public function onWpInit() {
		// parent::onWpInit();

		// Add custom screen options
		$load_action = "load-".$this->main_admin_menu_slug."_page_wplister-".self::slug;
		add_action( $load_action, array( &$this, 'addScreenOptions' ) );

		// handle actions
		$this->handleActionsOnInit();
	}

	public function onWpAdminMenu() {
		parent::onWpAdminMenu();

		if ( 'order' != get_option( 'wplister_ebay_update_mode', 'order' ) ) return;

		add_submenu_page( self::ParentMenuId, $this->getSubmenuPageTitle( 'Orders' ), __('Orders','wplister'), 
						  self::ParentPermissions, $this->getSubmenuId( 'orders' ), array( &$this, 'onDisplayEbayOrdersPage' ) );
	}

	public function handleActionsOnInit() {
		if ( ! current_user_can('manage_ebay_listings') ) return;

		// these actions have to wait until 'init'
		if ( $this->requestAction() == 'view_ebay_order_details' ) {
		    check_admin_referer( 'wplister_view_order_details' );
			$this->showOrderDetails( $_REQUEST['ebay_order'] );
			exit();
		}

	}

	function addScreenOptions() {
		$option = 'per_page';
		$args = array(
	    	'label' => 'Orders',
	        'default' => 20,
	        'option' => 'orders_per_page'
	        );
		add_screen_option( $option, $args );
		$this->ordersTable = new EbayOrdersTable();
	
	    // add_thickbox();
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );

	}
	


	public function onDisplayEbayOrdersPage() {
		$this->check_wplister_setup();

		// handle update ALL from eBay action
		if ( $this->requestAction() == 'wple_update_orders' ) {
		    check_admin_referer( 'wplister_update_orders' );

			// regard update options
			$days = is_numeric( $_REQUEST['wpl_number_of_days'] ) ? $_REQUEST['wpl_number_of_days'] : false;

			$accounts = WPLE_eBayAccount::getAll( false, true ); // sort by id
			$msg = '';

			// loop each active account
			$processed_accounts = array();
			foreach ( $accounts as $account ) {

				// make sure we don't process the same account twice
				if ( in_array( $account->user_name, $processed_accounts ) ) {
			        WPLE()->logger->info("skipping account {$account->id} - user name {$account->user_name} was already processed");
					continue;
				}

				$this->initEC( $account->id );
				$tm = $this->EC->updateEbayOrders( $days );
				$this->EC->updateListings();
				$this->EC->closeEbay();
				$processed_accounts[] = $account->user_name;

				// show ebay_order report
				$msg .= sprintf( __('%s order(s) found on eBay for account %s.','wplister'), $tm->count_total, $account->title ) . '<br>';
				$msg .= __('Timespan','wplister') .': '. $tm->getHtmlTimespan() . '&nbsp;&nbsp;';
				$msg .= '<a href="#" onclick="jQuery(\'.ebay_order_report\').toggle();return false;">'.__('show details','wplister').'</a>';
				$msg .= $tm->getHtmlReport();
				$msg .= '<hr>';

			}
			$this->showMessage( $msg );

		}

		// handle update from eBay action
		if ( $this->requestAction() == 'wple_bulk_update_orders' ) {
			if ( isset( $_REQUEST['ebay_order'] ) ) {
                check_admin_referer( 'bulk-orders' );

				// use account_id of first item (todo: group items by account)
				$om         = new EbayOrdersModel();
				$order      = $om->getItem( $_REQUEST['ebay_order'][0] );
				$account_id = $order['account_id'];

				$this->initEC( $account_id );
				$tm = $this->EC->updateEbayOrders( false, $_REQUEST['ebay_order'] );
				$this->EC->updateListings();
				$this->EC->closeEbay();
				// $this->showMessage( __('Selected orders were updated from eBay.','wplister') );		

				// show ebay_order report
				$msg  = $tm->count_total .' '. __('orders were updated from eBay.','wplister') . '<!br>' . '&nbsp;&nbsp;';
				$msg .= '<a href="#" onclick="jQuery(\'.ebay_order_report\').toggle();return false;">'.__('show details','wplister').'</a>';
				$msg .= $tm->getHtmlReport();
				$this->showMessage( $msg );

			} else {
				$this->showMessage( __('You need to select at least one item from the list below in order to use bulk actions.','wplister'),1 );						
			}
		}

		// handle wpl_delete_order action
		if ( $this->requestAction() == 'wple_bulk_delete_orders' ) {
			if ( isset( $_REQUEST['ebay_order'] ) ) {
			    check_admin_referer( 'bulk-orders' );

				$tm = new EbayOrdersModel();
				$ebay_orders = is_array( $_REQUEST['ebay_order'] ) ? $_REQUEST['ebay_order'] : array( $_REQUEST['ebay_order'] );
				foreach ( $ebay_orders as $id ) {
					$tm->deleteItem( $id );
				}
				$this->showMessage( __('Selected items were removed.','wplister') );
			} else {
				$this->showMessage( __('You need to select at least one item from the list below in order to use bulk actions.','wplister'),1 );						
			}
		}


		// show warning if duplicate orders found
		$this->checkForDuplicates();

	    //Create an instance of our package class...
	    $ordersTable = new EbayOrdersTable();
    	//Fetch, prepare, sort, and filter our data...
	    $ordersTable->prepare_items();

		// load eBay classes to decode details in table
		EbayController::loadEbayClasses();
		
		$aData = array(
			'plugin_url'				=> self::$PLUGIN_URL,
			'message'					=> $this->message,

			'ordersTable'				=> $ordersTable,
			'preview_html'				=> isset($preview_html) ? $preview_html : '',
		
			'form_action'				=> 'admin.php?page='.self::ParentMenuId.'-orders'
		);
		$this->display( 'orders_page', $aData );
		

	}


	public function checkForDuplicates() {

		// show warning if duplicate products found
		$om = new EbayOrdersModel();
		$duplicateOrders = $om->getAllDuplicateOrders();
		if ( ! empty($duplicateOrders) ) {

			// built message
			$msg  = '<p><b>Warning: '.__('There are duplicate orders for','wplister').' '.join(', ',$duplicateOrders).'</b>';
			$msg .= '<br>';
			$msg .= 'This can happen when the scheduled order update is triggered twice at the same time - which is a rare <a href="http://wordpress.stackexchange.com/a/122805" target="_blank">race condition issue</a> in the WordPress scheduling system WP-Cron.';
			$msg .= '<br><br>';
			$msg .= 'To prevent this from happening again, it is highly recommended to use an ';
			$msg .= '<a href="http://docs.wplab.com/article/99-external-cron-job-setup" target="_blank">external cron job</a> ';
			$msg .= 'instead of relying on WP-Cron to trigger background actions for WP-Lister. ';
			$msg .= 'Please read that FAQ article, then set the update interval to "use external cron job" and follow the instructions. If you are still having issues after doing so, you might have to move to a better hosting provider.';
			$msg .= '</p>';


			// built message
			$msg .= '<p>';

			// table header
			$msg .= '<table style="width:100%">';
			$msg .= "<tr>";
			$msg .= "<th style='text-align:left'>Date</th>";
			$msg .= "<th style='text-align:left'>Order ID</th>";
			$msg .= "<th style='text-align:left'>Total</th>";
			$msg .= "<th style='text-align:left'>Items</th>";
			$msg .= "<th style='text-align:left'>Last modified</th>";
			// $msg .= "<th style='text-align:left'>eBay ID</th>";
			// $msg .= "<th style='text-align:left'>Stock red.</th>";
			// $msg .= "<th style='text-align:left'>New Stock</th>";
			$msg .= "<th style='text-align:left'>Status</th>";
			$msg .= "<th style='text-align:left'>&nbsp;</th>";
			$msg .= "</tr>";

			// table rows
			foreach ($duplicateOrders as $order_id) {

				// $transactions = $tm->getAllTransactionsByTransactionID( $order_id );
				$last_order_id = false;

				$orders = $om->getAllOrderByOrderID( $order_id );
				foreach ($orders as $order) {

					// get column data
					// $qty     = $order['quantity'];
					// $stock   = $order['stock'] . ' x ';
					// $title   = $order['auction_title'];
					// $post_id = $order['post_id'];
					// $ebay_id = $order['ebay_id'];

					// build links
					// $ebay_url = $order['ViewItemURL'] ? $order['ViewItemURL'] : $ebay_url = 'http://www.ebay.com/itm/'.$ebay_id;
					// $ebay_link = '<a href="'.$ebay_url.'" target="_blank">'.$ebay_id.'</a>';
					// $edit_link = '<a href="post.php?action=edit&post='.$post_id.'" target="_blank">'.$title.'</a>';

					// check if stock was reduced
					// list( $reduced_product_id, $new_stock_value ) = $tm->checkIfStockWasReducedForItemID( $order, $order['item_id'] );

					// color results
					$color_id = 'silver';
					if ( $order_id != $last_order_id ) {
						$color_id = 'black';
						$last_order_id = $order_id;						
					}

					$color_status = 'auto';
					if ( $order['CompleteStatus'] == 'Completed' ) {
						$color_status = 'darkgreen';
					}
					if ( $order['CompleteStatus'] == 'Cancelled' ) {
						$color_status = 'silver';
					}

					// built buttons
					$actions = '';
					// if ( $order['status'] != 'reverted' && $order['CompleteStatus'] != 'Completed' ) {
						$button_label = 'Remove';
						$url = 'admin.php?page=wplister-orders&action=wpl_delete_order&ebay_order='.$order['id'].'&_wpnonce='. wp_create_nonce( 'wplister_delete_order' );
						$actions = '<a href="'.$url.'" class="button button-small">'.$button_label.'</a>';
					// }

					// build table row
					$msg .= "<tr>";
					$msg .= "<td>".$order['date_created']."</td>";
					$msg .= "<td style='color:$color_id'>".$order['order_id']."</td>";
					$msg .= "<td>".wc_price($order['total'])."</td>";
					$msg .= "<td>".count($order['items'])."</td>";
					$msg .= "<td>".$order['LastTimeModified']."</td>";
					// $msg .= "<td>".$order['item_id']."</td>";
					// $msg .= "<td>".$reduced_product_id."</td>";
					// $msg .= "<td>".$new_stock_value."</td>";
					$msg .= "<td style='color:$color_status'>".$order['CompleteStatus']."</td>";
					$msg .= "<td>".$actions."</td>";
					// $msg .= "<td>$edit_link (ID $post_id)</td>";
					// $msg .= "<td>$qty x </td>";
					// $msg .= "<td>$ebay_link</td>";
					$msg .= "</tr>";

				}
			}
			$msg .= '</table>';

			$msg .= '<br>';
			// $msg .= $table;
			// $msg .= '<br>';
			// $msg .= 'This is caused by...';
			// $msg .= '<br><br>';
			// $msg .= 'To fix this... ';
			$msg .= '</p>';

			$this->showMessage( $msg, 1 );				
		}
	}

	public function showOrderDetails( $id ) {
	
		// init model
		$ordersModel = new EbayOrdersModel();		

		// get ebay_order record
		$ebay_order = $ordersModel->getItem( $id );
		
		// get WooCommerce order
		$wc_order_notes = $ebay_order['post_id'] ? $this->get_order_notes( $ebay_order['post_id'] ) : false;

		$aData = array(
			'ebay_order'				=> $ebay_order,
			'wc_order_notes'			=> $wc_order_notes,
		);
		$this->display( 'order_details', $aData );
		
	}

	public function get_order_notes( $id ) {

		$notes = array();

		$args = array(
			'post_id' => $id,
			'approve' => 'approve',
			'type' => ''
		);

		remove_filter('comments_clauses', 'woocommerce_exclude_order_comments');

		// fix blank details page if WooCommerce Product Reviews Pro plugin is active (Call to undefined function get_current_screen())
		// since we only render the details page and then exit(), it's safe to remove all problematic filters
		remove_all_filters('comments_clauses');
		remove_all_filters('parse_comment_query');

		$comments = get_comments( $args );

		foreach ($comments as $comment) :
			// $is_customer_note = get_comment_meta($comment->comment_ID, 'is_customer_note', true);
			// $comment->comment_content = make_clickable($comment->comment_content);
			$notes[] = $comment;
		endforeach;

		add_filter('comments_clauses', 'woocommerce_exclude_order_comments');

		return (array) $notes;

	}



}
