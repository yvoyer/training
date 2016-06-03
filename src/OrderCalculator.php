<?php

namespace Star\Training;

class OrderCalculator {

	const ITEM_RARITY_UNCOMMON = 2;
	const ITEM_RARITY_RARE = 3;
	const ACCOUNT_PRICE_REBATE_BRONZE = 0.90;
	const ACCOUNT_PRICE_REBATE_SILVER = 0.80;
	const ACCOUNT_PRICE_REBATE_GOLD = 0.70;
	const ITEM_PRICE_BOOST_UNCOMMON = 1.5;
	const ITEM_PRICE_BOOST_RARE = 2;

	/**
	 * @param $order
	 * @param Customer $customer
	 * @return string
	 */
	function calculate($order, $customer) {
		$sum = 0;

		$itemQuantity[1] = 0;
		$itemQuantity[2] = 0;
		$itemQuantity[3] = 0;
		$highestPrice[1] = 0;
		$highestPrice[2] = 0;
		$highestPrice[3] = 0;

		foreach ($order->items as $item) {
			$price = $item['price'];
			if ($price > $highestPrice[$item['type']]) {
				$highestPrice[$item['type']] = $price;
			}

			$itemQuantity[$item['type']] ++;

			if ($customer->isAccountTypeBronze()) {
				$price *= self::ACCOUNT_PRICE_REBATE_BRONZE;
			}

			if ($customer->isAccountTypeSilver()) {
				$price *= self::ACCOUNT_PRICE_REBATE_SILVER;
			}

			if (self::ITEM_RARITY_UNCOMMON === $item['type']) {
				$price *= self::ITEM_PRICE_BOOST_UNCOMMON;
			}

			if (self::ITEM_RARITY_RARE === $item['type']) {
				$price *= self::ITEM_PRICE_BOOST_RARE;
			}

			if ($customer->isAccountTypeGold()) {
				// 2 for one
				if (self::ITEM_RARITY_UNCOMMON === $itemQuantity[$item['type']] && self::ITEM_RARITY_RARE === $item['type']) {
					$itemQuantity[$item['type']] = 0;
					$price = $highestPrice[$item['type']] - $price;
					if ($price < 0) {
						$price = 0;
					}
				}
			}

			$sum += $price;
		}

		if ($customer->isAccountTypeGold()) {
			$sum *= self::ACCOUNT_PRICE_REBATE_GOLD;
		}

		return number_format($sum, 2);
	}
}
