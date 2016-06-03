<?php

namespace Star\Training;

class Item {

	private $price;
	private $type;

	/**
	 * @param $type
	 * @param $price
	 */
	public function __construct($type, $price) {
		$this->type = $type;
		$this->price = $price;
	}

	public static function fromArray(array $item) {
		$price = $item['price'];
		$type = $item['type'];

		return new self($price, $type);
	}

}