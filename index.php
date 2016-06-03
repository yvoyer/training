<?php
// ... other code

interface AccountType {
	const NORMAL = 0;
	const BRONZE = 1;
	const SILVER = 2;
	const GOLD = 3;
	
	public function discount($price);
}

class NormalAccount implements AccountType {
	public function discount($price) {
		return $price;
	}
};
class BronzeAccount implements AccountType {
	public function discount($price) {
		return $price * .90;
	}
}
class SilverAccount implements AccountType {
	public function discount($price) {
		return $price * .8;
	}
};
class GoldAccount implements  AccountType {
	public function discount($price) {
		return $price * .7;
	}
};

class Customer {
	private $_account_type;

	public function __construct(AccountType $account_type) {
		$this->_account_type = $account_type;	
	}
	
	public function type() {
		return $this->_account_type;
	}
	
	public static function fromArray($customer = null) {
		if (null === $customer || !isset($customer['account_level'])) {
			return new self(new NormalAccount());
		}
		
		switch ($customer['account_level']) {
			case 1:
				return new self(new BronzeAccount());
			case 2:
				return new self(new SilverAccount());
			case 3:
				return new self(new GoldAccount());
			default;
				return new NormalAccount();
		}
	}
}

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($order, $customer = null) {
    $sum = 0;
	
	$customer = Customer::fromArray($customer);
	
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

        if (2 === $item['type']) {
            $price *= 1.5;
        }

        if (3 === $item['type']) {
            $price *= 2;
        }

        if ($customer->type() instanceof GoldAccount) {
            // 2 for one
            if (2 === $itemQuantity[$item['type']] && 3 === $item['type']) {
                $itemQuantity[$item['type']] = 0;
                $price = $highestPrice[$item['type']] - $price;
                if ($price < 0) {
                    $price = 0;
                }
            }
			
        }

        $sum += $price;
    }

	$sum = $customer->type()->discount($sum);
	
    return number_format($sum, 2);
}

// ... other code
