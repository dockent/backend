<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 28.08.17
 * Time: 07:47
 */

namespace Dockent\components;

use Dockent\enums\DI;
use Phalcon\Config;
use Phalcon\Mvc\Controller as PhalconController;

/**
 * Class Controller
 * @package Dockent\components
 */
class Controller extends PhalconController
{
    /**
     * @var Config
     */
    public $config;

    /**
     * If we don't have hostsettings section in config - redirect to Install Dockent page
     */
    public function beforeExecuteRoute()
    {
        $this->config = $this->getDI()->get(DI::CONFIG);
        if ($this->config->get('hostsettings') === null) {
            $this->dispatcher->forward([
                'controller' => 'install',
                'action' => 'index'
            ]);
        }
    }
}