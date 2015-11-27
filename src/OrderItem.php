<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training;

use Star\Training\Discount\ItemDiscount;

/**
 * Class OrderItem
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
final class OrderItem
{
    /**
     * @var int
     */
    private $type;

    /**
     * @var float
     */
    private $price;

    /**
     * @param int $type
     * @param float $price todo define Price object
     */
    public function __construct($type, $price)
    {
        $this->type = $type;
        $this->price = $price;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return new Price($this->price);
    }

    /**
     * @return int
     *
     * @deprecated todo Remove at some point
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isCommon()
    {
        return $this->type === ProductType::COMMON;
    }

    /**
     * @return bool
     */
    public function isUncommon()
    {
        return $this->type === ProductType::UNCOMMON;
    }

    /**
     * @return bool
     */
    public function isRare()
    {
        return $this->type === ProductType::RARE;
    }
}
