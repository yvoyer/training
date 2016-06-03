<?php

namespace Star\Training;

class TypeOfAccount {

	/**
	 * @var int|string
	 */
	private $type;

	/**
	 */
	public function __construct($type) {
		$this->type = $type;
	}

	/**
	 * @return int|string
	 */
	public function getType() {
		return $this->type;
	}

	public function applyDiscount($price) {
		if (1 === $this->type) {
			$price *= .90;
		}
		if (2 === $this->type) {
			$price *= .80;
		}

		return $price;
	}

	public function applyDiscountOnTotal($sum) {
		if (3 === $this->type) {
			$sum *= .70;
		}

		return $sum;
	}

	public static function fromCustomer($customer = null) {
		return new self((isset($customer['account_level'])) ? $customer['account_level'] : 'Normal');
	}
}