<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training\Discount;

use Star\Training\Price;

/**
 * Class Discount
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
interface ItemDiscount
{
    /**
     * @param Price $price
     *
     * @return Price
     */
    public function apply(Price $price);
}
