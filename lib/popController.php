<?php
/*
@package Woolston Web Design Developer Plugin
*/

if (!defined('ABSPATH')) exit;  // if direct access 

add_action("wp_ajax_order_pop_get_order", "order_pop_get_order");
add_action("wp_ajax_nopriv_order_pop_get_order", "order_pop_get_order");    

function order_pop_get_order() {
	echo json_encode(order_pop_get_orders());
	die();
}

function order_pop_get_orders() {

	$order_pop_options = get_option('op-plugin');
	if (array_key_exists('stop_notifications', $order_pop_options) && $order_pop_options['stop_notifications']) {
			die();
	}
    
	$pop_last_order_count = $order_pop_options['pop_last_order_count'];
	$args = array(
		'type' => 'shop_order',
		'limit' => $pop_last_order_count,
		'return' => 'ids',
		'status' => 'completed',
		'orderby' => 'date',
		'order' => 'DESC',
		'meta_query' => array(
				'relation' => 'AND',
				array(
						'meta_key' => 'billing_first_name',
						'meta_value' => '',
						'meta_compare' => '!=',
				),
				array(
						'meta_key' => 'billing_last_name',
						'meta_value' => '',
						'meta_compare' => '!=',
				)            
		)
	);

	$orders = get_transient('order_pop_cached_orders');

	if (false == $orders) {
		$query = new WC_Order_Query($args);
		$orders = $query->get_orders();
		set_transient('order_pop_cached_orders', $orders, 10 * MINUTE_IN_SECONDS);
	}
	
	shuffle($orders);
	$qualifying_products = [];
	$options_excluded_categories = (array_key_exists('excluded_categories', $order_pop_options) ? $order_pop_options['excluded_categories'] : []);
	$excluded_categories = $options_excluded_categories ? getExcludedCategories($options_excluded_categories) : [];
	foreach($orders as $order_id) {

		$order = wc_get_order($order_id);
		$order_products = $order->get_items();
		
		foreach($order_products as $order_product) {
			$product = getProductFromOrderItem($order_product);
			$product_id = $product['id'];
			if (!$excluded_categories || ($excluded_categories && !has_term($excluded_categories, 'product_cat', $product_id))) {
				$qualifying_products[] = array_merge(
					array(
						'order_date' => $order->get_date_completed()->date('Y-m-d H:i:s'),
						'order_first_name' => (array_key_exists('anonomise_customer', $order_pop_options) ? 'Someone ' : $order->get_billing_first_name()),
						'order_last_name'  => (array_key_exists('anonomise_customer', $order_pop_options) ? '' : $order->get_billing_last_name()),
						'order_city'  => ucwords(strtolower($order->get_billing_city())),
						'order_state'  => $order->get_billing_state()
					),
					$product
				);
			}
		}
	}

	if (!$qualifying_products) {
		delete_transient('order_pop_cached_orders');
		die();
	}

	shuffle($qualifying_products);

	return
		array (
			'options' => array(
				'pop_interval_between_pop_refresh_seconds' => $order_pop_options['pop_interval_between_pop_refresh_seconds'],
				'pop_interval_between_pops_after_dismissed_minutes' => $order_pop_options['pop_interval_between_pops_after_dismissed_minutes'],
				'pop_background_colour' => $order_pop_options['pop_background_colour'],
				'pop_font_colour' => $order_pop_options['pop_font_colour'],
				'debug_active' => $order_pop_options['debug_active'],
				'custom_css' => $order_pop_options['custom_css'],
				'utm_code' => $order_pop_options['utm_code'],
			),
			'debug' => array(
				'excluded_categories' => $excluded_categories,
			),
			'products' => $qualifying_products,
		);
}

function getExcludedCategories($categories) {
	$excluded_categories = [];
	if (!isset($categories)) {
		return $excluded_categories;
	}

	foreach($categories as $cat) {
		array_push($excluded_categories, get_term_by('slug', $cat, 'product_cat', 'ARRAY_A')['slug']);
	}
	return $excluded_categories;		
}

function getProductFromOrderItem($item) {
	if ($item->get_product()->get_parent_id() == 0) {
		$product = $item->get_product();
	} else {
		$product = wc_get_product($item->get_product()->get_parent_id());
	}

	return array(
		'id' => $product->get_id(),
		'name' => $product->get_name(),
		'url' => $product->get_permalink(),
		'image' => $product->get_image(),
	);
}

function cleanUp() {
	$order_pop_options = get_option('op-plugin');

	if (array_key_exists('sale_message', $order_pop_options)) {
		unset($order_pop_options['sale_message']);
	}
}