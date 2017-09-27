<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 28.08.17
 * Time: 07:47
 */

namespace Dockent\components;

use Dockent\components\DI as DIFactory;
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
        $this->docker = DIFactory::getDI()->get(DI::DOCKER);
    }

    /**
     * @param string $url
     */
    public function redirect(string $url)
    {
        header("Location: $url");
    }
}