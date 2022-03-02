<?php
/*
@package Woolston Web Design Developer Plugin
*/

if (! defined('ABSPATH')) exit;  // if direct access 

function order_pop_add_admin_page() {
    add_menu_page('Order Pop Theme Options', 'Order Pop', 'manage_options', 'order_pop_plugin', 'order_pop_theme_create_settings_page', 'dashicons-admin-generic', 90);
    add_submenu_page('order_pop_plugin',  'WWD Theme Options',  'Settings',  'manage_options',  'order_pop_plugin',  'order_pop_theme_create_settings_page');

    register_setting('op-plugin-options', 'op-plugin');
}
add_action('admin_menu', 'order_pop_add_admin_page');

function order_pop_theme_create_settings_page() {
    $options = get_option('op-plugin');
    // var_dump($options);
    require_once ORDER_POP_PLUGIN_PATH . "/templates/admin.php";
}