<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Phalcon\Http\ResponseInterface;

/**
 * Class IndexController
 * @package Dockent\controllers
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        /** Just render default view */
    }

    /**
     * @return ResponseInterface
     */
    public function applicationConfigAction(): ResponseInterface
    {
        $this->response->setJsonContent([
            'debugMode' => static::$DEBUG_MODE
        ]);

        return $this->response;
    }
}