<?php
/**
 * This file is part of the training project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Training;

/**
 * Class Customer
 *
 * @author Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */
final class Customer
{
    /**
     * @var int
     */
    private $type;

    /**
     * @param int $type
     */
    private function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isBronze()
    {
        return $this->type === AccountType::BRONZE;
    }

    /**
     * @return bool
     */
    public function isSilver()
    {
        return $this->type === AccountType::SILVER;
    }

    /**
     * @return bool
     */
    public function isGold()
    {
        return $this->type === AccountType::GOLD;
    }

    /**
     * @return bool
     */
    public function isBasic()
    {
        return $this->type === 'Normal';
    }

    /**
     * @param array $info
     *
     * @return Customer
     */
    public static function fromLegacy(array $info = null)
    {
        $accountType = (isset($info['account_level'])) ? $info['account_level'] : 'Normal';

        return new self($accountType);
    }
}
