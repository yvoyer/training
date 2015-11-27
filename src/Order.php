<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training;

/**
 * Class Order
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
final class Order
{
    /**
     * @var OrderItem[]
     */
    private $items = [];

    /**
     * @param OrderItem $item
     */
    public function addItem(OrderItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return OrderItem[]
     * @deprecated todo Remove at some point
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $order
     *
     * @return Order
     */
    public static function fromLegacy($order)
    {
        $object = new self();

        foreach ($order->items as $item) {
            $object->addItem(new OrderItem($item['type'], $item['price']));
        }

        return $object;
    }
}
