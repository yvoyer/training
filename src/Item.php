<?php

namespace Star\Training;

class Item {

	private $_type;

	private $_price;

	public function __construct($type, $price) {
		$this->_type = $type;
		$this->_price = $price;
	}

	public function getType() {
		return $this->_type;
	}

	public function getPrice() {
		return $this->_price;
	}

}
