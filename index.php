<?php
// ... other code

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($order, $customer = null)
{
    $cart = new \Star\Training\Cart($order, $customer);

    return $cart->calculateOrder();
}

// ... other code
