<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:37
 */

namespace Dockent\components;

use Phalcon\Di\FactoryDefault;

/**
 * Class DI
 * @package Dockent\components
 */
class DI
{
    /**
     * @var \Phalcon\Di
     */
    private static $di;

    /**
     * @return \Phalcon\Di
     */
    public static function getDI()
    {
        if (static::$di === null) {
            static::$di = new FactoryDefault();
        }

        return static::$di;
    }
}