<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 28.08.17
 * Time: 07:47
 */

namespace Dockent\components;

use Dockent\components\DI as DIFactory;
use Dockent\Connector\Connector;
use Dockent\enums\DI;
use Phalcon\Mvc\Controller as PhalconController;

/**
 * Class Controller
 * @package Dockent\components
 */
class Controller extends PhalconController
{
    /**
     * @var Connector
     */
    protected $docker;

    /**
     * @var bool
     */
    static $DEBUG_MODE = false;

    public function beforeExecuteRoute()
    {
        $this->docker = DIFactory::getDI()->get(DI::DOCKER);
        static::$DEBUG_MODE = (bool)getenv('DOCKENT_DEBUG');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
    }
}