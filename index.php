<?php

use Star\Training\Customer;
use Star\Training\Order;

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($order, $customer = null) {
	$order = Order::createFromObject($order, new Customer($customer));
	return $order->calculate();
}

// ... other code
