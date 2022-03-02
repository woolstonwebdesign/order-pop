# Order Pop Sales Notification
Plugin Name: Order Pop
Plugin URI: https://github.com/woolstonwebdesign/order-pop
Description: Woocommerce Order Pop Notification. Display previous orders to your customers to promote sales.
Version: 1.0.0
Author: Woolston Web Design
Author URI: https://www.woolston.com.au
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: sale order pop notification customer woocommerce
GitHub Plugin URI: https://github.com/woolstonwebdesign/order-pop
Requires at least: 5.0
Tested up to: 5.9.1
Requires PHP: 7.0
Stable tag: 1.0.0
Contributors: stevenwoolston

Order Pop is a notification that creates FOMO (fear of missing out) in your customers and drives sales.

== Description ==
Order Pop presents a notification to users announcing purchases made by other customers. Order Pop requires Woocommerce to function.

This is a proven marketing approach that encourages customers to purchase products that appear to be desirable by previous customers.
This plugin allows you to configure:
* start/stop all notifications
* the pop background colour
* the pop text colour
* how many previously completed orders to draw from (this lets you target recent orders or those completed long ago)
* how often products should refresh within the pop
* how long a customer can dismiss pops for

Order Pop does not store your data outside your Wordpress instance. Order Pop calls the Woocommerce order history and pulls content that matches your configuration criteria (see screenshots for more information). Order Pop then caches that content for around 10 minutes to improve performance, but that cache is cleared and rebuilt when changes are saved in the Order Pop admin screen.

== Screenshots ==
1. Order Pop administration screen. Many configuration options available
2. Order Pop display on a desktop view
3. Order Pop display on a mobile view

== Installation ==
1. In your admin panel, go to Plugins and find the 'Order Pop' plugin
2. Click on the ‘Activate’ button to start using Order Pop.
3. Navigate to Order Pop in your admin panel and customize. (Pops are turned off by default)

== Frequently Asked Questions ==
= Do I need to have Woocommerce for Order Pop to work? =
Yes, Order Pop pulls from Woocommerce's order history and displays content based on those sales.

= Do you store my data away from my site? =
No, Order Pop does not store your data outside of your Wordpress instance. The only time we use your data outside of Wordpress is when it gets pushed to the customer's browser and stored there for quick and performant retrieval.

= Do I need to sign up to use Order Pop? =
Not at all. Order Pop is free. There is a Pro version which is available at https://www.woolston.com.au/product/order-pop-wordpress-plugin/.

= Can I add tracking codes to my product links? =
The Pro version allows this functionality. It is available at https://www.woolston.com.au/product/order-pop-wordpress-plugin/.

== Changelog ==
= 1.0.0 =
* First public distribution

== Copyright ==
Order Pop, Copyright 2022 Woolston Web Design is distributed under the terms of the GNU GPL