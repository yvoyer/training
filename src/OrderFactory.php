<?php

namespace Star\Training;

class OrderFactory {

	public static function create($items, $customer) {
		return new Order($items, new Customer($customer));
	}

	public static function createFromObjectOrder($order, $customer) {
		$items = array();
		foreach ($order->items as $item) {
			$items[] = new Item($item['type'], $item['price']);
		}

		return new Order($items, $customer);
	}

}
