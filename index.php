<?php
// ... other code

class Order {
    private $_items;
    
    private function __construct($items) {
        $this->_items = items;
    }
    
    public static function fromItems($items) {
        return new self($items);
    }
    
    public function getItems() {
        return $this->_items;
    }
}

class OrderItem {
    const COMMON = 1;
    const UNCOMMON = 2;
    const RARE = 3;
    
    private $_type;
    private $_price;

    private function __construct($type, $price) {
        $this->_type = $type;
        $this->_price = $price;
    }
    
    public static function fromDefault($price) {
        return new self(OrderItem::COMMON, $price);
    }
    
    public static function fromTypeAndPrice($type, $price) {
        return new self($type, $price);
    }
    
    public function getType() {
        return $this->_type;
    }

    public function getPrice() {
        return $this->_price;
    }
}

class Customer {
    const BRONZE_ACCOUNT = 1;
    const SILVER_ACCOUNT = 2;
    const GOLD_ACCOUNT = 3;

    private $_accountLevel;

    private function __construct($accountLevel){
        $this->_accountLevel = $accountLevel;
    }

    public static function fromDefault() {
        return new self(Customer::SILVER_ACCOUNT);
    }

    public static function fromAccountLevel($accountLevel) {
        return new self($accountLevel);
    }

    public function getAccountLevel() {
        return $this->_accountLevel;
    }
}

class Calculator {

    public function __construct() {}

    public function calculateOrder(Order $order, Customer $customer = null) {
        $orderItems = $order->getItems();
        $sum = 0;

        $itemQuantity[1] = 0;
        $itemQuantity[2] = 0;
        $itemQuantity[3] = 0;
        $highestPrice[1] = 0;
        $highestPrice[2] = 0;
        $highestPrice[3] = 0;

        foreach ($orderItems as $item) {
            $itemPrice = $item.getPrice();
            $itemType = $item.getType();
            $accountLevel = $customer->getAccountLevel();

            if ($itemPrice > $highestPrice[$item.getType()]) {
                $highestPrice[$itemType] = $itemPrice;
            }

            $itemQuantity[$itemType] ++;

            switch ($accountLevel) {
                case Customer::BRONZE_ACCOUNT:
                    $itemPrice *= .90;
                    break;
                case Customer::SILVER_ACCOUNT:
                    $itemPrice *= .80;
                    break;
                case Customer::GOLD_ACCOUNT:
                    $itemPrice *= .70;
                    break;
            }

            if (2 === $itemType) {
                $itemPrice *= 1.5;
            }

            if (3 === $itemType) {
                $itemPrice *= 2;
            }

            if (Customer::GOLD_ACCOUNT == $accountLevel) {
                // 2 for one
                if (2 === $itemQuantity[$itemType] && 3 === $itemType) {
                    $itemQuantity[$itemType] = 0;
                    $itemPrice = $highestPrice[$itemType] - $itemPrice;
                    if ($itemPrice < 0) {
                        $itemPrice = 0;
                    }
                }
            }

            $sum += $itemPrice;
        }

        return number_format($sum, 2);
    }

}

/**
 * @param object $order
 * @param array $customer
 *
 * @return string The total price to pay for the $customer
 */
function calculateOrder($orderData, $customerData = null) {
    $orderItems = array();

    foreach ($orderData->items as $item){
        array_push($orderItems, OrderItem::fromTypeAndPrice($item['type'], $item['price']));
    }

    $order = Order::fromItems($orderItems);

    if (!$customerData) {
        $customer = Customer::fromDefault();
    } else {
        $customer = Customer::fromAccountLevel($customerData['account_level']);
    }

    $calculator = new Calculator();
    return  $calculator->calculateOrder($order, $customer);
}

// ... other code
