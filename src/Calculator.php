<?php

namespace Star\Training;

class Calculator {

	const ITEM_TYPE_1 = 1;

	const ITEM_TYPE_2 = 2;

	const ITEM_TYPE_3 = 3;

	const QUANTITY_2 = 2;

	public function calculate($order, $customer = null) {

		$sum = 0;
		$accountType = TypeOfAccount::fromCustomer($customer);

		$itemQuantity[self::ITEM_TYPE_1] = 0;
		$itemQuantity[self::ITEM_TYPE_2] = 0;
		$itemQuantity[self::ITEM_TYPE_3] = 0;
		$highestPrice[self::ITEM_TYPE_1] = 0;
		$highestPrice[self::ITEM_TYPE_2] = 0;
		$highestPrice[self::ITEM_TYPE_3] = 0;

		foreach ($order->items as $item) {
			$item_obj = Item::fromArray($item);
			$price = $item['price'];
			$type = $item['type'];
			if ($price > $highestPrice[$type]) {
				$highestPrice[$type] = $price;
			}

			$itemQuantity[$type]++;

			if (self::ITEM_TYPE_2 === $type) {
				$price *= 1.5;
			}

			if (self::ITEM_TYPE_3 === $type) {
				$price *= 2;
			}

			$price = $accountType->applyDiscount($price);

			if (3 === $accountType->getType()) {
				// 2 for one
				if (self::QUANTITY_2 === $itemQuantity[$type] && self::ITEM_TYPE_3 === $type) {
					$itemQuantity[$type] = 0;
					$price = $highestPrice[$type] - $price;
					if ($price < 0) {
						$price = 0;
					}
				}
			}

			$sum += $price;
		}

		$sum = $accountType->applyDiscountOnTotal($sum);

		return number_format($sum, 2);

	}

}