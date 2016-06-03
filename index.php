<?php
// ... other code
use Star\Training\Calculator;

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($order, $customer = null) {
	$calculator = new Calculator();
	return $calculator->calculate($order, $customer);
}

// ... other code
