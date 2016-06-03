<?php

use Star\Training\Customer;
use Star\Training\OrderFactory;

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($order, $customer = null) {
	$order = OrderFactory::createFromObjectOrder($order, new Customer($customer));
	return $order->calculate();
}

// ... other code
