<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training;

/**
 * Class Cart
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
final class Cart
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @param Order $order
     * @param Customer $customer
     */
    public function __construct(Order $order, Customer $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    public function calculateOrder()
    {
        $sum = 0;
        $accountType = $this->customer->getType();

        $itemQuantity[1] = 0;
        $itemQuantity[2] = 0;
        $itemQuantity[3] = 0;
        $highestPrice[1] = 0;
        $highestPrice[2] = 0;
        $highestPrice[3] = 0;

        foreach ($this->order->getItems() as $item) {
            $price = $item->getPrice();
            $type = $item->getType();

            if ($price > $highestPrice[$type]) {
                $highestPrice[$type] = $price;
            }

            $itemQuantity[$type] ++;

            if (1 === $accountType) {
                $price *= .90;
            }

            if (2 === $type) {
                $price *= 1.5;
            }

            if (3 === $type) {
                $price *= 2;
            }

            if (2 === $accountType) {
                $price *= .80;
            }

            if (3 === $accountType) {
                // 2 for one
                if (2 === $itemQuantity[$type] && 3 === $type) {
                    $itemQuantity[$type] = 0;
                    $price = $highestPrice[$type] - $price;
                }
            }

            $sum += $price;
        }

        if (3 === $accountType) {
            $sum *= .70;
        }

        return number_format($sum, 2);
    }
}
