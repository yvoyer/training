<?php

use Star\Training\Customer;
use Star\Training\OrderCalculator;

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($order, $customer = null) {
	$order_calculator = new OrderCalculator();
	return $order_calculator->calculate($order, new Customer($customer));
}

// ... other code
