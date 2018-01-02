<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

namespace Dockent\controllers;

use Dockent\components\Controller;
use Phalcon\Http\ResponseInterface;

/**
 * Class IndexController
 * @package Dockent\controllers
 */
class IndexController extends Controller
{
    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $this->response->setContent($this->docker->SystemResource()->systemInfo());

        return $this->response;
    }
}