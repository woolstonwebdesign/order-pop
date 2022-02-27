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
Text Domain: sale order pop notification customer woocommerce
GitHub Plugin URI: https://github.com/woolstonwebdesign/order-pop
*/

if (!defined('ABSPATH')) {
    exit;
}

define("OP_PLUGIN_PATH", plugin_dir_path(__FILE__));
define('OP_PLUGIN_URL', plugin_dir_url(__FILE__));
define("OP_PLUGIN_BASENAME", plugin_basename(__FILE__));

require_once(plugin_dir_path(__FILE__) . '/inc/op-config.php');

require_once(plugin_dir_path(__FILE__) . '/lib/op-activate-plugin.php');

require_once(plugin_dir_path(__FILE__) . '/lib/op-admin-options.php');

require_once(plugin_dir_path(__FILE__) . '/lib/popController.php');

add_action('init', 'op_enqueue_assets');

add_action('admin_enqueue_scripts', 'op_admin_enqueue_assets');
register_activation_hook(__FILE__, 'op_activation_hook');
register_deactivation_hook(__FILE__, 'op_deactivation_hook');
register_uninstall_hook(__FILE__, 'op_uninstall_hook');

function op_enqueue_assets() {
    wp_enqueue_style('op-style', plugin_dir_url(__FILE__) . '/dist/css/order-pop.min.css', array(), '1.0.0', 'all');

    $op_options = get_option('op-plugin')['custom_css'];
    if (isset($op_options)) {
        wp_add_inline_style('op-style', $op_options);
    }
    wp_register_script('momentjs', plugin_dir_url(__FILE__) . '/dist/js/moment-with-locales.min.js', array('jquery'));
    wp_register_script('op_order_script', plugin_dir_url(__FILE__) . '/dist/js/order-pop.min.js', array('jquery', 'momentjs'), '1.0.0');
    wp_localize_script('op_order_script', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('jquery');
    wp_enqueue_script('op_order_script');
}

function op_admin_enqueue_assets() {
    wp_enqueue_media();
    wp_enqueue_style('op-developer-style', plugin_dir_url(__FILE__) . '/dist/css/op-admin.min.css', array(), '1.0.0', 'all');
    wp_enqueue_script('op-developer-script', plugin_dir_url(__FILE__) . '/dist/js/op-admin.min.js', array('jquery'), '1.0.0', true);

    //Enqueue CSS just for us
    if (isset($_GET['page']) && $_GET['page'] == 'op_plugin') {
        wp_enqueue_style('op-bootstrap', plugin_dir_url(__FILE__) . '/dist/css/bootstrap.min.css');
    }    
}

function op_activation_hook() {
    op_plugin_activate();
}

function op_deactivation_hook() {
    op_plugin_deactivate();
}

function op_uninstall_hook() {
    op_plugin_uninstall();
}