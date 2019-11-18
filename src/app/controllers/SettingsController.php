<?php

namespace Dockent\controllers;

use Dockent\components\config\Config;
use Dockent\components\Controller;
use Dockent\models\Settings;
use Phalcon\Http\Request\Exception;
use Phalcon\Http\ResponseInterface;

/**
 * Class SettingsController
 * @package Dockent\controllers
 */
class SettingsController extends Controller
{
    /**
     * @var Config
     */
    private $config;


    /**
     * @throws Exception
     */
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();
        if (!static::$DEBUG_MODE) {
            throw new Exception('Page not found', 404);
        }

        $this->config = $this->getDI()->get(Config::class);
    }

    /**
     * @Method(GET, POST)
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $model = new Settings($this->config);
        if ($this->request->isPost()) {
            $model->assign($this->request->getJsonRawBody(true));
            if ($model->save()) {
                $this->response->setJsonContent(['status' => 'success']);
            } else {
                $this->response->setJsonContent([
                    'status' => 'error',
                    'errors' => $model->getErrors()
                ]);
            }

            return $this->response;
        }

        $this->response->setJsonContent([
            'model' => $model
        ]);

        return $this->response;
    }
}