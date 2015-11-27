<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training;

use Star\Training\Discount\BronzeCustomerGetPercentOnItem;

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
        $sum = new Price(0);

        $itemQuantity[ProductType::COMMON] = 0;
        $itemQuantity[ProductType::UNCOMMON] = 0;
        $itemQuantity[ProductType::RARE] = 0;
        $highestPrice[ProductType::COMMON] = new Price(0);
        $highestPrice[ProductType::UNCOMMON] = new Price(0);
        $highestPrice[ProductType::RARE] = new Price(0);

        foreach ($this->order->getItems() as $item) {
            $price = $item->getPrice();
            $type = $item->getType();

            if ($price->greaterThan($highestPrice[$type])) {
                $highestPrice[$type] = $price;
            }

            $itemQuantity[$type] ++;

            $price = $price->applyDiscount(new BronzeCustomerGetPercentOnItem($this->customer, .9));

            if ($item->isUncommon()) {
                $price = $price->multiply(1.5);
            }

            if ($item->isRare()) {
                $price = $price->multiply(2);
            }

            if ($this->customer->isSilver()) {
                $price = $price->multiply(.8);
            }

            if ($this->customer->isGold()) {
                // 2 for one
                if (2 === $itemQuantity[$type] && $item->isRare()) {
                    $itemQuantity[$type] = 0;
                    $price = $price->subtract($highestPrice[$type]);
                }
            }

            $sum = $sum->addPrice($price);
        }

        if ($this->customer->isGold()) {
            $sum = $sum->multiply(.7);
        }

        return (string) $sum;
    }
}
