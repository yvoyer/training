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
     * @return int
     *
     * @deprecated todo Remove at some point
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Customer
     */
    public static function Bronze()
    {
        return new self(AccountType::BRONZE);
    }

    /**
     * @return Customer
     */
    public static function Silver()
    {
        return new self(AccountType::SILVER);
    }

    /**
     * @return Customer
     */
    public static function Gold()
    {
        return new self(AccountType::GOLD);
    }

    /**
     * @return Customer
     */
    public static function Basic()
    {
        return new self('Normal');
    }

    /**
     * @param array $info
     *
     * @return Customer
     */
    public static function fromLegacy(array $info = null)
    {
        $accountType = (isset($info['account_level'])) ? $info['account_level'] : 'Normal';

        switch ($accountType) {
            case AccountType::GOLD:
                return self::Gold();

            case AccountType::SILVER:
                return self::Silver();

            case AccountType::BRONZE:
                return self::Bronze();
        }

        return self::Basic();
    }
}
