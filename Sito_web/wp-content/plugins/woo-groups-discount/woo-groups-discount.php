<?php
/**
 * woo-groups-discount.php
 *
 * Copyright (c) 2011,2012 Antonio Blanco http://www.blancoleon.com
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
 *
 * Plugin Name: Woocommerce Groups Discount
 * Plugin URI: http://www.eggemplo.com/plugins/woocommerce-groups-discount
 * Description: Apply discounts according to the user's group
 * Version: 3.2.0
 * Author: eggemplo
 * Author URI: http://www.eggemplo.com
 * Text Domain: woo-groups-discount
 * Domain Path: /languages
 * License: GPLv3
 */

define( 'WOO_GROUPS_DISCOUNT_PLUGIN_NAME', 'woo-groups-discount' );

define( 'WOO_GROUPS_DISCOUNT_FILE', __FILE__ );

if ( !defined( 'WOO_GROUPS_DISCOUNT_CORE_DIR' ) ) {
	define( 'WOO_GROUPS_DISCOUNT_CORE_DIR', WP_PLUGIN_DIR . '/woo-groups-discount/core' );
}

define ( 'WOO_GROUPS_DISCOUNT_DECIMALS', 2 );

define( 'WOO_GROUPS_DISCOUNT_PLUGIN_URL', plugin_dir_url( WOO_GROUPS_DISCOUNT_FILE ) );

class WooGroupsDiscount_Plugin {

	private static $notices = array();

	public static function init() {

		load_plugin_textdomain( 'woo-groups-discount', null, WOO_GROUPS_DISCOUNT_PLUGIN_NAME . '/languages' );

		register_activation_hook( WOO_GROUPS_DISCOUNT_FILE, array( __CLASS__, 'activate' ) );
		register_deactivation_hook( WOO_GROUPS_DISCOUNT_FILE, array( __CLASS__, 'deactivate' ) );

		register_uninstall_hook( WOO_GROUPS_DISCOUNT_FILE, array( __CLASS__, 'uninstall' ) );

		add_action( 'init', array( __CLASS__, 'wp_init' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );

		add_action('admin_head', array( __CLASS__, 'woogroupsdiscount_enqueue_scripts' ) );
	}

	public static function wp_init() {

		if ( is_multisite() ) {
			$active_sitewide_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
			$active_plugins = array_merge( get_option( 'active_plugins', array() ), $active_sitewide_plugins );
		} else {
			$active_plugins = get_option( 'active_plugins', array() );
		}
		$groups_is_active = in_array( 'groups/groups.php', $active_plugins );
		$woo_is_active = in_array( 'woocommerce/woocommerce.php', $active_plugins );

		if ( ( !$groups_is_active ) || ( !$woo_is_active ) ) {
			if ( !$groups_is_active ) {
				self::$notices[] = "<div class='error'>" . __( 'The <strong>Woocommerce Groups Discount</strong> plugin requires the <a href="http://wordpress.org/extend/plugins/groups" target="_blank">Groups</a> plugin to be activated.', 'woo-groups-discount' ) . "</div>";
			}
			if ( !$woo_is_active ) {
				self::$notices[] = "<div class='error'>" . __( 'The <strong>Woocommerce Groups Discount</strong> plugin requires the <a href="http://wordpress.org/extend/plugins/woocommerce" target="_blank">Woocommerce</a> plugin to be activated.', 'woo-groups-discount' ) . "</div>";
			}
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( array( __FILE__ ) );
		} else {

			add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ), 40 );
			//call register settings function
			add_action( 'admin_init', array( __CLASS__, 'register_woogroupsdiscount_settings' ) );

			if ( !class_exists( "WooGroupsDiscount" ) ) {
				include_once 'core/class-woogroupsdiscount.php';
				include_once 'core/class-wgd-variations-admin.php';
			}
		}
	}

	/**
	 * Register settings as woogroupsdiscount
	 */
	public static function register_woogroupsdiscount_settings() {

		register_setting( 'woogroupsdiscount', 'wgd-method' );
		add_option( 'wgd-method','rate' ); // by default rate

		register_setting( 'woogroupsdiscount', 'wgd-baseprice' );
		add_option( 'wgd-baseprice','regular' ); // by default regular

		register_setting( 'woogroupsdiscount', 'wgd-ifseveral' );
		add_option( 'wgd-ifseveral','higher' ); // by default first group

		register_setting( 'woogroupsdiscount', 'wgd-displayoriginal' );
		add_option( 'wgd-displayoriginal', 0 ); // by default 0 = false

	}

	/**
	 * Load scripts.
	 */
	public static function woogroupsdiscount_enqueue_scripts() {
		wp_register_style( 'wgd-styles', WOO_GROUPS_DISCOUNT_PLUGIN_URL . 'css/wgd-admin-styles.css' );
		wp_enqueue_style ('wgd-styles');
	}

	public static function admin_notices() { 
		if ( !empty( self::$notices ) ) {
			foreach ( self::$notices as $notice ) {
				echo $notice;
			}
		}
	}

	/**
	 * Adds the admin section.
	 */
	public static function admin_menu() {
		$admin_page = add_submenu_page(
				'woocommerce',
				__( 'Groups Discount', 'woo-groups-discount' ),
				__( 'Groups Discount', 'woo-groups-discount' ),
				'manage_options',
				'woogroupsdiscount',
				array( __CLASS__, 'woogroupsdiscount_settings_menu' )
		);
	}

	/**
	 * Show Groups MailChimp setting page.
	 */
	public static function woogroupsdiscount_settings_menu () {
		
		$section_links_array = array(
				'method' => __( 'Method', 'woo-groups-discount' ),
				'groups'  => __( 'Groups', 'woo-groups-discount' )
		);
		
		$alert = "";
		
		$section = isset( $_REQUEST['section'] ) ? $_REQUEST['section'] : 'method';
		
		if ( isset( $_POST['submit'] ) ) {
			switch ( $section ) {
				case 'groups' :
					$groups = WooGroupsDiscount::get_all_groups();
					foreach ( $groups as $group ) {
						if ( isset( $_POST[ "wgd-" . $group->group_id ] ) && ( $_POST[ "wgd-" . $group->group_id ] !== "" ) ) {
							update_option( "wgd-" . $group->group_id, $_POST[ "wgd-" . $group->group_id ] );
						} else {
							delete_option( "wgd-" . $group->group_id );
						}
					}
					$alert = __("Saved Groups subsection", 'woo-groups-discount');
					break;
				case 'method' :
				default:
					update_option( "wgd-method", $_POST[ "wgd-method" ] );
					
					update_option( "wgd-baseprice", $_POST[ "wgd-baseprice" ] );
					
					update_option( "wgd-ifseveral", $_POST[ "wgd-ifseveral" ] );
					
					if ( isset( $_POST["wgd-bothpricestext"] ) ) {
						update_option( "wgd-bothpricestext", $_POST[ "wgd-bothpricestext" ] );
					}
					
					if ( isset( $_POST["wgd-displayoriginal"] ) ) {
						update_option( "wgd-displayoriginal", $_POST["wgd-displayoriginal"] );
					} else {
						update_option( 'wgd-displayoriginal',0 );
					}
					$alert = __( 'Saved Method subsection', 'woo-groups-discount' );
					break;
			}

			// clear product cache
			WooGroupsDiscount::clear_products_cache();
		}

	if ($alert != "") {
		echo '<div style="background-color: #ffffe0;border: 1px solid #993;padding: 1em;margin-right: 1em;">' . $alert . '</div>';
	}
	
	$section_title = $section_links_array[$section];
	echo '<h2>' . __( 'Woocommerce Groups Discount', 'woo-groups-discount' ) . '</h2>';
	echo '<hr>';
	
	$section_links = '';
	foreach( $section_links_array as $sec => $title ) {
		$section_links .= sprintf(
				'<a class="section-link nav-tab %s" href="%s">%s</a>',
				$section == $sec ? 'active nav-tab-active' : '',
				esc_url( add_query_arg( 'section', $sec, admin_url( 'admin.php?page=woogroupsdiscount' ) ) ),
				$title
				);
	}
	
	echo '<div class="section-links nav-tab-wrapper">';
	echo $section_links;
	echo '</div>';
	
	switch( $section ) {
		case 'groups' :
			self::section_groups();
			break;
		case 'method' :
		default :
			self::section_method();
			break;
	}
}

	/**
	 * Display the Method subsection settings page.
	 */
	protected static function section_method() {
	?>
		<div class="wrap" style="border: 1px solid #ccc; padding:10px;">
			<form method="post" action="">
				<table class="form-table">
					<tr valign="top">
					<th scope="row"><strong><?php echo __( 'Products discount method:', 'woo-groups-discount' ); ?></strong></th>
					<td>
						<select name="wgd-method">
						<?php 
						if ( get_option("wgd-method") == "amount" ) {
						?>
							<option value="rate"><?php echo __( 'Rate', 'woo-groups-discount' );?></option>
							<option value="amount" selected="selected"><?php echo __( 'Amount', 'woo-groups-discount' );?></option>
						<?php 
						} else {
						?>
							<option value="rate" selected="selected"><?php echo __( 'Rate', 'woo-groups-discount' );?></option>
							<option value="amount"><?php echo __( 'Amount', 'woo-groups-discount' );?></option>
						<?php 
						}
						?>
						</select>
					</tr>
		
					<tr valign="top">
					<th scope="row"><strong><?php echo __( 'Apply to:', 'woo-groups-discount' ); ?></strong></th>
					<td>
						<select name="wgd-baseprice">
						<?php 
						if ( get_option("wgd-baseprice") == "sale" ) {
						?>
							<option value="regular"><?php echo __( 'Regular price', 'woo-groups-discount' );?></option>
							<option value="sale" selected="selected"><?php echo __( 'Sale price', 'woo-groups-discount' );?></option>
						<?php 
						} else {
						?>
							<option value="regular" selected="selected"><?php echo __( 'Regular price', 'woo-groups-discount' );?></option>
							<option value="sale"><?php echo __( 'Sale price', 'woo-groups-discount' );?></option>
						<?php 
						}
						?>
						</select>
						</br>
						<span class="description"><?php echo __( "If you select <b>Sale Price</b> then if the product has a sale price then discount is applied over this sale price. But if it doesn't, then the discount is applied on the regular price.", 'woo-groups-discount' ); ?></span>
					</tr>
		
					<tr valign="top">
					<th scope="row"><strong><?php echo __( 'If in several groups:', 'woo-groups-discount' ); ?></strong></th>
					<td>
						<select name="wgd-ifseveral">
						<?php 
						switch ( get_option("wgd-ifseveral") ) {
							case 'last':
							?>
								<option value="higher" ><?php echo __( "Higher discount", 'woo-groups-discount' ); ?></option>
								<option value="lower" ><?php echo __( "Lower discount", 'woo-groups-discount' ); ?></option>
								<option value="first" ><?php echo __( "Higher group ID", 'woo-groups-discount' ); ?></option>
								<option value="last" selected="selected"><?php echo __( "Lower group ID", 'woo-groups-discount' ); ?></option>
							<?php 
								break;
							case 'higher':
							default:
							?>
								<option value="higher" selected="selected"><?php echo __( "Higher discount", 'woo-groups-discount' ); ?></option>
								<option value="lower" ><?php echo __( "Lower discount", 'woo-groups-discount' ); ?></option>
								<option value="first" ><?php echo __( "Higher group ID", 'woo-groups-discount' ); ?></option>
								<option value="last" ><?php echo __( "Lower group ID", 'woo-groups-discount' ); ?></option>
							<?php 
								break;
							case 'lower':
							?>
								<option value="higher" ><?php echo __( "Higher discount", 'woo-groups-discount' ); ?></option>
								<option value="lower" selected="selected"><?php echo __( "Lower discount", 'woo-groups-discount' ); ?></option>
								<option value="first" ><?php echo __( "Higher group ID", 'woo-groups-discount' ); ?></option>
								<option value="last" ><?php echo __( "Lower group ID", 'woo-groups-discount' ); ?></option>
							<?php 
								break;
							case 'first':
							?>
								<option value="higher" ><?php echo __( "Higher discount", 'woo-groups-discount' ); ?></option>
								<option value="lower" ><?php echo __( "Lower discount", 'woo-groups-discount' ); ?></option>
								<option value="first" selected="selected" ><?php echo __( "Higher group ID", 'woo-groups-discount' ); ?></option>
								<option value="last" ><?php echo __( "Lower group ID", 'woo-groups-discount' ); ?></option>
							<?php 
								break;
						}
						?>
						</select>
					</tr>
		
					<tr valign="top">
					<th scope="row"><strong><?php echo __( 'Display original prices:', 'woo-groups-discount' ); ?></strong></th>
					<td>
						<?php 
						if ( get_option("wgd-displayoriginal", 0) == 1 ) {
							$checked = "checked";
						} else {
							$checked = "";
						}
						?>
						<input type="checkbox" name="wgd-displayoriginal" value="1" <?php echo $checked; ?> >
					</tr>
					
					<tr valign="top">
					<th scope="row"><strong><?php echo __( 'Both prices text:', 'woo-groups-discount' ); ?></strong></th>
					<td>
						<?php
						$text = get_option( "wgd-bothpricestext", WooGroupsDiscount::DEFAULT_BOTH_PRICES_TEXT );
						if ( $text == "" ) {
							$text = WooGroupsDiscount::DEFAULT_BOTH_PRICES_TEXT;
						}
						?>
						<textarea name="wgd-bothpricestext"><?php echo $text; ?></textarea>
						<p class="description"><?php echo __( 'You can use the tokens: [original_price], [discounted_price].', 'woo-groups-discount' ); ?></p>
					</tr>
		
				</table>
				
				<?php submit_button( __( "Save", 'woo-groups-discount' ) ); ?>
				<?php settings_fields( 'woogroupsdiscount' ); ?>
			</form>
		</div>
	<?php
	}

	/**
	 * Display the Groups subsection settings page.
	 */
	protected static function section_groups() {
		$groups = WooGroupsDiscount::get_all_groups();
		?>
		<div class="wrap" style="border: 1px solid #ccc; padding:10px;">
		<form method="post" action="">
		<h3><?php echo __( 'Groups:', 'woogroupsdiscount' ); ?></h3>
		<div class="description">Leave empty if no group discount should be applied (default setting).<br>
		Example with rate method: Indicate 0.1 for 10% discounts on every product.
		</div>

		<table class="form-table">
		<?php 
			if ( $groups ) {
				foreach ( $groups as $group ) {
				?>
					<tr valign="top">
					<th scope="row"><?php echo $group->name . ':'; ?></th>
					<td>
						<input type="text" name="wgd-<?php echo $group->group_id;?>" value="<?php echo get_option( "wgd-" . $group->group_id ); ?>" />
					</td>
					</tr>
					<?php
				}
			}
			?>
		</table>

		<?php submit_button( __( "Save", 'woo-groups-discount' ) ); ?>

		<?php settings_fields( 'woogroupsdiscount' ); ?>

	</form>
	</div>
	<?php 
	}

	/**
	 * Plugin activation work.
	 */
	public static function activate() {
	}

	/**
	 * Plugin deactivation.
	 *
	 */
	public static function deactivate() {
	}

	/**
	 * Plugin uninstall. Delete database table.
	 *
	 */
	public static function uninstall() {
	}

}

WooGroupsDiscount_Plugin::init();