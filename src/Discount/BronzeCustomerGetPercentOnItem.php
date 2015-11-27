<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training\Discount;

use Star\Training\Customer;
use Star\Training\Price;

/**
 * Class BronzeCustomerGetPercentOnItem
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
final class BronzeCustomerGetPercentOnItem implements ItemDiscount
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var float
     */
    private $percent;

    /**
     * @param Customer $customer
     * @param float $percent
     */
    public function __construct(Customer $customer, $percent)
    {
        $this->customer = $customer;
        $this->percent = $percent;
    }

    /**
     * @param Price $price
     *
     * @return Price
     */
    public function apply(Price $price)
    {
        if ($this->customer->isBronze()) {
            return $price->multiply($this->percent);
        }

        return $price;
    }
}
