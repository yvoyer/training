<?php

namespace Star\Training;

class Customer {

	const ACCOUNT_TYPE_BRONZE = 1;
	const ACCOUNT_TYPE_SILVER = 2;
	const ACCOUNT_TYPE_GOLD = 3;

	private $_account_type = 'Normal';

	public function __construct(array $data = null) {
		if (isset($data['account_level'])) {
			$this->_account_type = $data['account_level'];
		}
	}

	public function getAccountType() {
		return $this->_account_type;
	}
	
	public function isAccountTypeBronze() {
		return $this->_account_type === self::ACCOUNT_TYPE_BRONZE;
	}

	public function isAccountTypeSilver() {
		return $this->_account_type === self::ACCOUNT_TYPE_SILVER;
	}

	public function isAccountTypeGold() {
		return $this->_account_type === self::ACCOUNT_TYPE_GOLD;
	}

}
