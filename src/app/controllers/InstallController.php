<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 13.09.17
 * Time: 14:14
 */

namespace Dockent\controllers;

use Phalcon\Mvc\Controller;

/**
 * Class InstallController
 * @package Dockent\controllers
 */
class InstallController extends Controller
{
    public function indexAction()
    {
        echo 'Install Dockent';
    }
}