<?php

namespace Dockent\components;

use Dockent\Connector\Connector;
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
        $this->docker = $this->getDI()->getShared(Connector::class);
        static::$DEBUG_MODE = (bool)getenv('DOCKENT_DEBUG');
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
    }
}