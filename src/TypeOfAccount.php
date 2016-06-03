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

	public static function fromCustomer($customer = null) {
		return new self((isset($customer['account_level'])) ? $customer['account_level'] : 'Normal');
	}
}