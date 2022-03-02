<?php
add_filter('plugin_action_links_' . ORDER_POP_PLUGIN_BASENAME, 'order_pop_build_settings_link');

function order_pop_build_settings_link($links) {
    $settings_link = '<a href="admin.php?page=order_pop_plugin">View Settings</a><br/>
        <a href="https://www.woolston.com.au/product/order-pop-wordpress-plugin/" target="_blank">Click here to purchase the Pro version.</a>';
    array_push($links, $settings_link);
    return $links;
}