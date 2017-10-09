<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

namespace Dockent\controllers;

use Dockent\components\Controller;

/**
 * Class IndexController
 * @package Dockent\controllers
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->setVars([
            'information' => $this->docker->getMiscManager()->getSystemInformation()
        ]);
    }
}