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
    private $order;
    private $customer;

    public function __construct($order, $customer = null)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    public function calculateOrder()
    {
        $sum = 0;
        $accountType = (isset($this->customer['account_level'])) ? $this->customer['account_level'] : 'Normal';

        $itemQuantity[1] = 0;
        $itemQuantity[2] = 0;
        $itemQuantity[3] = 0;
        $highestPrice[1] = 0;
        $highestPrice[2] = 0;
        $highestPrice[3] = 0;

        foreach ($this->order->items as $item) {
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
