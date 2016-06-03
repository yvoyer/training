<?php
// ... other code

interface AccountType {
	public function discount($price);
}

class NormalAccount implements AccountType {
	public function discount($price) {
		// TODO: Implement discount() method.
	}
};
class BronzeAccount implements AccountType {
	public function discount($price) {
		// TODO: Implement discount() method.
	}
}
class SilverAccount implements AccountType {
	public function discount($price) {
		// TODO: Implement discount() method.
	}
};
class GoldAccount implements  AccountType {
	public function discount($price) {
		// TODO: Implement discount() method.
	}
};

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($order, $customer = null) {
    $sum = 0;
    $accountType = (isset($customer['account_level'])) ? $customer['account_level'] : 'Normal';

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

        if (1 === $accountType) {
            $price *= .90;
        }

        if (2 === $item['type']) {
            $price *= 1.5;
        }

        if (3 === $item['type']) {
            $price *= 2;
        }

        if (2 === $accountType) {
            $price *= .80;
        }

        if (3 === $accountType) {
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

    if (3 === $accountType) {
        $sum *= .70;
    }

    return number_format($sum, 2);
}

// ... other code
