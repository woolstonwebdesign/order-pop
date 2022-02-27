<?php
add_filter('plugin_action_links_' . OP_PLUGIN_BASENAME, 'op_build_settings_link');

function op_build_settings_link($links) {
    $settings_link = '<a href="admin.php?page=op_plugin">View Settings</a><br/>
        <a href="https://www.woolston.com.au/product/order-pop-wordpress-plugin/" target="_blank">Click here to purchase the Pro version.</a>';
    array_push($links, $settings_link);
    return $links;
}