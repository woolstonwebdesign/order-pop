<?php
/*
@package Woolston Web Design Order Pop
@version 1.0.0
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
*/

if (!defined('ABSPATH')) {
    exit;
}

define("ORDER_POP_PLUGIN_PATH", plugin_dir_path(__FILE__));
define('ORDER_POP_PLUGIN_URL', plugin_dir_url(__FILE__));
define("ORDER_POP_PLUGIN_BASENAME", plugin_basename(__FILE__));

require_once(plugin_dir_path(__FILE__) . '/inc/op-config.php');

require_once(plugin_dir_path(__FILE__) . '/lib/op-activate-plugin.php');

require_once(plugin_dir_path(__FILE__) . '/lib/op-admin-options.php');

require_once(plugin_dir_path(__FILE__) . '/lib/popController.php');

add_action('init', 'order_pop_enqueue_assets');

add_action('admin_enqueue_scripts', 'order_pop_admin_enqueue_assets');
register_activation_hook(__FILE__, 'order_pop_activation_hook');
register_deactivation_hook(__FILE__, 'order_pop_deactivation_hook');
register_uninstall_hook(__FILE__, 'order_pop_uninstall_hook');

function order_pop_enqueue_assets() {
    wp_enqueue_style('op-style', plugin_dir_url(__FILE__) . '/dist/css/order-pop.min.css', array(), '1.0.0', 'all');

    $order_pop_options = get_option('op-plugin')['custom_css'];
    if (isset($order_pop_options)) {
        wp_add_inline_style('op-style', $order_pop_options);
    }
    wp_register_script('momentjs', plugin_dir_url(__FILE__) . '/dist/js/moment-with-locales.min.js', array('jquery'));
    wp_register_script('order_pop_order_script', plugin_dir_url(__FILE__) . '/dist/js/order-pop.min.js', array('jquery', 'momentjs'), '1.0.0');
    wp_localize_script('order_pop_order_script', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('jquery');
    wp_enqueue_script('order_pop_order_script');
}

function order_pop_admin_enqueue_assets() {
    wp_enqueue_media();
    wp_enqueue_style('op-developer-style', plugin_dir_url(__FILE__) . '/dist/css/op-admin.min.css', array(), '1.0.0', 'all');
    wp_enqueue_script('op-developer-script', plugin_dir_url(__FILE__) . '/dist/js/op-admin.min.js', array('jquery'), '1.0.0', true);

    //Enqueue CSS just for us
    if (isset($_GET['page']) && $_GET['page'] == 'order_pop_plugin') {
        wp_enqueue_style('op-bootstrap', plugin_dir_url(__FILE__) . '/dist/css/bootstrap.min.css');
    }    
}

function order_pop_activation_hook() {
    order_pop_plugin_activate();
}

function order_pop_deactivation_hook() {
    order_pop_plugin_deactivate();
}

function order_pop_uninstall_hook() {
    order_pop_plugin_uninstall();
}