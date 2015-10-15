<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training;

/**
 * Class FeatureTest
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
final class FeatureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $fixtures;

    public static function setUpBeforeClass() {
        require_once(__DIR__ . '/../index.php');
    }

    public function setUp() {
        $this->fixtures = [
            'order-common' => (object) [
                'items' => [
                    [
                        'type' => ProductType::COMMON,
                        'price' => 10,
                    ],
                    [
                        'type' => ProductType::COMMON,
                        'price' => 15,
                    ],
                ],
            ],
            'order-uncommon' => (object) [
                'items' => [
                    [
                        'type' => ProductType::UNCOMMON,
                        'price' => 12,
                    ],
                    [
                        'type' => ProductType::UNCOMMON,
                        'price' => 70,
                    ],
                ],
            ],
            'order-rare' => (object) [
                'items' => [
                    [
                        'type' => ProductType::RARE,
                        'price' => 15,
                    ],
                    [
                        'type' => ProductType::RARE,
                        'price' => 45,
                    ],
                ],
            ],
        ];

        $combined = (object) ['items' => []];
        foreach ($this->fixtures as $order) {
            $combined->items = array_merge($combined->items, $order->items);
        }

        $this->fixtures['combined'] = $combined;
    }

    public function test_it_should_keep_the_base_price_untouch_for_common_items() {
        $this->assertSame('25.00', calculateOrder($this->fixtures['order-common']));
    }

    public function test_it_should_boost_the_base_price_by_one_and_half_for_uncommon_items() {
        $this->assertSame('123.00', calculateOrder($this->fixtures['order-uncommon']));
    }

    public function test_it_should_boost_the_base_price_by_two_for_rare_items() {
        $this->assertSame('120.00', calculateOrder($this->fixtures['order-rare']));
    }

    public function test_it_should_calculate_the_sum_of_all_orders_combined() {
        $this->assertCount(6, $this->fixtures['combined']->items);
        $this->assertSame('268.00', calculateOrder($this->fixtures['combined']));
    }

    public function test_it_should_give_a_10_percent_rebate_for_bronze_customer() {
        $this->assertSame('241.20', calculateOrder($this->fixtures['combined'], ['account_level' => AccountType::BRONZE]));
    }

    public function test_it_should_give_a_20_percent_rebate_for_silver_customer() {
        $this->assertSame('214.40', calculateOrder($this->fixtures['combined'], ['account_level' => AccountType::SILVER]));
    }

    public function test_it_should_give_a_30_percent_rebate_for_gold_customer() {
        $this->assertSame('86.10', calculateOrder($this->fixtures['order-uncommon'], ['account_level' => AccountType::GOLD]));
    }

    public function test_it_should_give_a_two_for_one_when_purchasing_two_rare_item_for_gold_customer() {
        $this->assertSame('63.00', calculateOrder($this->fixtures['order-rare'], ['account_level' => AccountType::GOLD]));
    }
}
