<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:37
 */

namespace Dockent\components;

use Phalcon\Di\FactoryDefault;
use Phalcon\DiInterface;

/**
 * Class DI
 * @package Dockent\components
 */
class DI
{
    /**
     * @var DiInterface
     */
    private static $di;

    /**
     * @return DiInterface
     */
    public static function getDI(): DiInterface
    {
        if (static::$di === null) {
            static::$di = new FactoryDefault();
        }

        return static::$di;
    }
}