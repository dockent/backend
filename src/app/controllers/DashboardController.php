<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Phalcon\Http\ResponseInterface;

/**
 * Class IndexController
 * @package Dockent\controllers
 */
class DashboardController extends Controller
{
    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $this->response->setContent((string) $this->docker->SystemResource()->systemInfo());

        return $this->response;
    }
}