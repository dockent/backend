<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 13.09.17
 * Time: 14:14
 */

namespace Dockent\controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * Class InstallController
 * @package Dockent\controllers
 */
class InstallController extends Controller
{
    public function initialize()
    {
        $this->view->setRenderLevel(View::LEVEL_LAYOUT);
    }

    public function indexAction()
    {
        /** Just render view */
    }

    public function installAction()
    {
        echo 'Install Action';
    }
}