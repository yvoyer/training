<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training;

use Star\Training\Discount\ItemDiscount;

/**
 * Class Price
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
final class Price
{
    /**
     * @var float
     */
    private $value;

    /**
     * @param float $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param float $multiplier
     *
     * @return Price
     */
    public function multiply($multiplier)
    {
        return new self($this->value * $multiplier);
    }

    /**
     * @param float|Price $value
     *
     * @return Price
     */
    public function subtract($value)
    {
        if ($value instanceof Price) {
            $value = $value->value;
        }

        return new self($this->value - $value);
    }

    /**
     * @param float $value
     *
     * @return Price
     */
    public function add($value)
    {
        return new self($this->value + $value);
    }

    /**
     * @param Price $price
     *
     * @return Price
     */
    public function addPrice(Price $price)
    {
        return new self($this->value + $price->value);
    }

    /**
     * @param Price $compare
     *
     * @return bool
     */
    public function greaterThan(Price $compare)
    {
        return $this->value > $compare->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return number_format($this->value, 2);
    }

    /**
     * @param Discount\ItemDiscount $discount
     *
     * @return Price
     */
    public function applyDiscount(ItemDiscount $discount)
    {
        return $discount->apply($this);
    }
}
