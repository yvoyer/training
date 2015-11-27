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

        $itemQuantity[ProductType::COMMON] = 0;
        $itemQuantity[ProductType::UNCOMMON] = 0;
        $itemQuantity[ProductType::RARE] = 0;
        $highestPrice[ProductType::COMMON] = 0;
        $highestPrice[ProductType::UNCOMMON] = 0;
        $highestPrice[ProductType::RARE] = 0;

        foreach ($this->order->getItems() as $item) {
            $price = $item->getPrice();
            $type = $item->getType();

            if ($price > $highestPrice[$type]) {
                $highestPrice[$type] = $price;
            }

            $itemQuantity[$type] ++;

            if ($this->customer->isBronze()) {
                $price *= .90;
            }

            if ($item->isUncommon()) {
                $price *= 1.5;
            }

            if ($item->isRare()) {
                $price *= 2;
            }

            if ($this->customer->isSilver()) {
                $price *= .80;
            }

            if ($this->customer->isGold()) {
                // 2 for one
                if (2 === $itemQuantity[$type] && $item->isRare()) {
                    $itemQuantity[$type] = 0;
                    $price = $highestPrice[$type] - $price;
                }
            }

            $sum += $price;
        }

        if ($this->customer->isGold()) {
            $sum *= .70;
        }

        return number_format($sum, 2);
    }
}
