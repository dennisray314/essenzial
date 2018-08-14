=== WooCommerce Payment Fees Lite ===
Contributors: pinchofcode
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=paypal@pinchofcode.com&item_name=Donation+for+Pinch+Of+Code
Tags: woocommerce, fees, charges, payment, shipping, method, gateway
Requires at least: 3.5
Tested up to: 4.0
Stable tag: 1.5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WooCommerce Extension that allow to add additional fees to your payment gateways.

== Description ==

[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)

This extension will add new section in each WooCommerce Payment Gateway that will allow you to add additional fees to your gateways. It's useful for COD payment gateway, in example, since WooCommerce does not allow this by default.
You can change quickly the fee in the admin panel too, for each order. Also you can choose how to handle taxes on the payment fee or exclude them automatically.

This plugin was tested with the following gateways

* BACS (included in WooCommerce)
* Cheque  (included in WooCommerce)
* COD (included in WooCommerce)
* PayPal  (included in WooCommerce)
* [WooCommerce CardSave Redirect Gateway](http://www.cardsave.net/)
* [WooCommerce PagSeguro](https://github.com/claudiosmweb/woocommerce-pagseguro)
* [WooCommerce Cash on Pickup](https://wordpress.org/plugins/wc-cash-on-pickup/)
* [WooCommerce PostePay](https://wordpress.org/plugins/woocommerce-postepay/)

If you are using a different gateway and have problems, please let us know which one you are using and we will do our best to support it too!

= Support =
For any support request, please create a new issue [here](https://github.com/PinchOfCode/woocommerce-payment-fees/issues).

**Note**: since the free nature of this plugin, the support may be discontinuous, but all the requests are checked and replied. We suggest to write on [GitHub](https://github.com/PinchOfCode/woocommerce-payment-fees/issues) to get faster support.

= Do you need more options? =

If you need more options and features, you should then check the purchase the premium version of this plugin, [Payment Gateway based Fees](http://www.woothemes.com/products/payment-gateway-based-fees/)!

= License =
Copyright (C) 2014 Pinch Of Code. All rights reserved.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

== Installation ==

= WP Installation =

1. Go to Plugins > Add New > Search
2. Type WooCommerce Payment Fees in the search box and hit Enter
3. Click on the button Install and then activate the plugin

= Manual Installation =

1. Upload `woocommerce-payment-fees` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Payment Gateways admin page
2. Order detail admin page

== Changelog ==

= 1.5.2 =

* Add: WP 4.0 compatibility
* Add: WooCommerce 2.2 compatibility

= 1.5.1 =
* Fix: Error with number format

= 1.5 =
* Add: Custom fee name field

* Update: Translations
* Fix: Grunt watching also checkout.js

* Fix: Old textdomain changed to wc_pf
* Fix: Fixed amount was not accepting decimals

* Remove: CardSave specific support. It now works like all other gateways

= 1.4.1 =
* Fix: Warning in checkout and emails

= 1.4 =
* Add: Calculate taxes on payment fees.
* Add: Support for different fee on debit/credit card.
* Update: Language packs.
* Fix: The payment fee is handled by WooCommerce fees system.

= 1.3.2 =
* Add: Gruntfile and its configuration
* Tweak: Improved JS following WooCommerce changes.
* Fix: Removed fees calculation on cart page.
* Fix: Language files renamed with the new domain.
* Removed: Old unused file.

= 1.3.1 =
* Fix: PayPal adds correctly the fees to the payment form.

= 1.3 =
* Add: You can set the maximum cart value to which apply fees.
* Tweak: Updated languages files
* Tweak: No longer calling the fees "Extra charges", but "fees" or "Payment method fees".
* Fix: Admin order page Javascript calculations now works properly.

= 1.2.1 =
* Fix: Checkout fields not saved correctly

= 1.2 =
* Fix: WordPress 3.9+ compatibility
* Fix: WooCommerce 2+ compatibility

= 1.1 =
* Tweak: Updated languages files
* Fix: The file write-panels.min.js was loaded wrongly also on other post types pages in the admin
* Fix: The plugin languages files are now loaded correctly from the folder /i18n/
* Fix: Minor changes

= 1.0 =
* First release

== Upgrade Notice ==

= 1.5 =
The payment gateway CardSave now works like the other gateway. This is a temporary remove, until we find a functional way to get it working with different fees based on the type of card you are using.
Also this update add the feature to write your own fee label on the checkout, be sure to add it after the update!

= 1.4 =
This update changes completely the way how the fee is handled by WooCommerce. We recommend to update your plugin.
