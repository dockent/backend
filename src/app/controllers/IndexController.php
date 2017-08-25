<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

namespace Dockent\controllers;

use Dockent\enums\DI;
use Phalcon\Config;
use Phalcon\Mvc\Controller;

/**
 * Class IndexController
 * @package Dockent\controllers
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        echo '(c) Dockent 2017';
    }

    public function installAction()
    {

    }
}