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

    public static function setUpBeforeClass()
    {
        require_once(__DIR__ . '/../index.php');
    }

    public function setUp()
    {
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

    public function test_it_should_keep_the_base_price_untouch_for_common_items()
    {
        $this->assertSame('25.00', calculateOrder($this->fixtures['order-common']));
    }

    public function test_it_should_boost_the_base_price_by_one_and_half_for_uncommon_items()
    {
        $this->assertSame('123.00', calculateOrder($this->fixtures['order-uncommon']));
    }

    public function test_it_should_boost_the_base_price_by_two_for_rare_items()
    {
        $this->assertSame('120.00', calculateOrder($this->fixtures['order-rare']));
    }

    /**
     * @depends test_it_should_keep_the_base_price_untouch_for_common_items
     * @depends test_it_should_boost_the_base_price_by_one_and_half_for_uncommon_items
     * @depends test_it_should_boost_the_base_price_by_two_for_rare_items
     */
    public function test_it_should_calculate_the_sum_of_all_orders_combined()
    {
        $this->assertCount(6, $this->fixtures['combined']->items);
        $this->assertSame('268.00', calculateOrder($this->fixtures['combined']));
    }

    /**
     * @depends test_it_should_calculate_the_sum_of_all_orders_combined
     */
    public function test_it_should_give_a_10_percent_rebate_for_bronze_customer()
    {
        $this->assertSame(
            '22.50', // 25 - 10%
            calculateOrder($this->fixtures['order-common'], ['account_level' => AccountType::BRONZE]),
            'Common items total for bronze customer is not as expected'
        );
        $this->assertSame(
            '110.70', // 123 - 10%
            calculateOrder($this->fixtures['order-uncommon'], ['account_level' => AccountType::BRONZE]),
            'Uncommon items total for bronze customer is not as expected'
        );
        $this->assertSame(
            '108.00', // 120 - 10%
            calculateOrder($this->fixtures['order-rare'], ['account_level' => AccountType::BRONZE]),
            'Rare items total for bronze customer is not as expected'
        );
        $this->assertSame(
            '241.20', // 268 - 10%
            calculateOrder($this->fixtures['combined'], ['account_level' => AccountType::BRONZE]),
            'All items total for bronze customer is not as expected'
        );
    }

    /**
     * @depends test_it_should_calculate_the_sum_of_all_orders_combined
     */
    public function test_it_should_give_a_20_percent_rebate_for_silver_customer()
    {
        $this->assertSame(
            '20.00', // 25 - 20%
            calculateOrder($this->fixtures['order-common'], ['account_level' => AccountType::SILVER]),
            'Common items total for silver customer is not as expected'
        );
        $this->assertSame(
            '98.40', // 123 - 20%
            calculateOrder($this->fixtures['order-uncommon'], ['account_level' => AccountType::SILVER]),
            'Uncommon items total for silver customer is not as expected'
        );
        $this->assertSame(
            '96.00', // 120 - 20%
            calculateOrder($this->fixtures['order-rare'], ['account_level' => AccountType::SILVER]),
            'Rare items total for silver customer is not as expected'
        );
        $this->assertSame(
            '214.40', // 268 - 20%
            calculateOrder($this->fixtures['combined'], ['account_level' => AccountType::SILVER]),
            'All items total for silver customer is not as expected'
        );
    }

    /**
     * @depends test_it_should_calculate_the_sum_of_all_orders_combined
     */
    public function test_it_should_give_a_30_percent_rebate_for_gold_customer()
    {
        $this->assertSame(
            '17.50', // 25 - 30%
            calculateOrder($this->fixtures['order-common'], ['account_level' => AccountType::GOLD]),
            'Common items total for gold customer is not as expected'
        );
        $this->assertSame(
            '86.10', // 123 - 30%
            calculateOrder($this->fixtures['order-uncommon'], ['account_level' => AccountType::GOLD]),
            'Uncommon items total for gold customer is not as expected'
        );

        $singleRareItem = (object) [
            'items' => [
                [
                    'type' => ProductType::RARE,
                    'price' => 45,
                ],
            ]
        ];
        $this->assertSame(
            '63.00', // (45 * 2) - 30%
            calculateOrder($singleRareItem, ['account_level' => AccountType::GOLD]),
            '1 Rare items total for gold customer is not as expected'
        );
    }

    /**
     * @depends test_it_should_give_a_30_percent_rebate_for_gold_customer
     */
    public function test_it_should_give_a_two_for_one_charging_highest_price_when_purchasing_two_rare_item_for_gold_customer()
    {
        // Set the "track-bug" environment variable in phpunit.xml.dist to reproduce bug
        if ($_ENV['track-bug'] == 0) {
            // This is the actual code result
            $this->assertSame(
                '21.00',
                calculateOrder($this->fixtures['order-rare'], ['account_level' => AccountType::GOLD]),
                'Multiple Rares items total for gold customer is not as expected'
            );
            $this->assertSame(
                '124.60',
                calculateOrder($this->fixtures['combined'], ['account_level' => AccountType::GOLD]),
                'All items total for gold customer is not as expected'
            );
        } else {
            // This should be the right result
            $this->assertSame(
                '63.00', // ((45 + 0) * 2) - 30% // (2 for 1)
                calculateOrder($this->fixtures['order-rare'], ['account_level' => AccountType::GOLD]),
                'Multiple Rares items total for gold customer is not as expected'
            );
            $this->assertSame(
                '166.66', // ( (10 + 15) + ((70 + 12) * 1.5) + ((45 + 0) * 2) ) - 30% (2 for 1 for rares)
                calculateOrder($this->fixtures['combined'], ['account_level' => AccountType::GOLD]),
                'All items total for gold customer is not as expected'
            );
        }
    }
}

interface AccountType
{
    const BRONZE = 1;
    const SILVER = 2;
    const GOLD = 3;
}

interface ProductType
{
    const COMMON = 1;
    const UNCOMMON = 2;
    const RARE = 3;
}
