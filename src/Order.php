<?php

namespace Star\Training;

class Order {

	const ITEM_RARITY_UNCOMMON = 2;
	const ITEM_RARITY_RARE = 3;
	const ACCOUNT_PRICE_REBATE_BRONZE = 0.90;
	const ACCOUNT_PRICE_REBATE_SILVER = 0.80;
	const ACCOUNT_PRICE_REBATE_GOLD = 0.70;
	const ITEM_PRICE_BOOST_UNCOMMON = 1.5;
	const ITEM_PRICE_BOOST_RARE = 2;

	/** @var Item[] */
	private $_items;

	/** @var Customer */
	private $_customer;

	/**
	 * Order constructor.
	 * @param Item[] $items
	 * @param Customer $customer
	 */
	private function __construct($items, $customer) {
		$this->_items = $items;
		$this->_customer = $customer;
	}

	/**
	 * @return string
	 */
	function calculate() {
		$sum = 0;

		$itemQuantity[1] = 0;
		$itemQuantity[2] = 0;
		$itemQuantity[3] = 0;
		$highestPrice[1] = 0;
		$highestPrice[2] = 0;
		$highestPrice[3] = 0;

		foreach ($this->_items as $item) {
			$price = $item->getPrice();
			if ($price > $highestPrice[$item->getType()]) {
				$highestPrice[$item->getType()] = $price;
			}

			$itemQuantity[$item->getType()] ++;

			if ($this->_customer->isAccountTypeBronze()) {
				$price *= self::ACCOUNT_PRICE_REBATE_BRONZE;
			}

			if ($this->_customer->isAccountTypeSilver()) {
				$price *= self::ACCOUNT_PRICE_REBATE_SILVER;
			}

			if (self::ITEM_RARITY_UNCOMMON === $item->getType()) {
				$price *= self::ITEM_PRICE_BOOST_UNCOMMON;
			}

			if (self::ITEM_RARITY_RARE === $item->getType()) {
				$price *= self::ITEM_PRICE_BOOST_RARE;
			}

			if ($this->_customer->isAccountTypeGold()) {
				// 2 for one
				if (self::ITEM_RARITY_UNCOMMON === $itemQuantity[$item->getType()] && self::ITEM_RARITY_RARE === $item->getType()) {
					$itemQuantity[$item->getType()] = 0;
					$price = $highestPrice[$item->getType()] - $price;
					if ($price < 0) {
						$price = 0;
					}
				}
			}

			$sum += $price;
		}

		if ($this->_customer->isAccountTypeGold()) {
			$sum *= self::ACCOUNT_PRICE_REBATE_GOLD;
		}

		return number_format($sum, 2);
	}

	public static function create($items, $customer) {
		return new self($items, new Customer($customer));
	}

	public static function createFromObject($order, $customer) {
		$items = array();
		foreach ($order->items as $item) {
			$items[] = new Item($item['type'], $item['price']);
		}

		return new self($items, $customer);
	}

}
