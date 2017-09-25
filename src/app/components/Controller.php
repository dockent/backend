<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 28.08.17
 * Time: 07:47
 */

namespace Dockent\components;

use Dockent\enums\DI;
use Docker\Docker;
use Phalcon\Mvc\Controller as PhalconController;

/**
 * Class Controller
 * @package Dockent\components
 */
class Controller extends PhalconController
{
    /**
     * @var Docker
     */
    protected $docker;

    public function beforeExecuteRoute()
    {
        $this->docker = $this->getDI()->get(DI::DOCKER);
    }
}