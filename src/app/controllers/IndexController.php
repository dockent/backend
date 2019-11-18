<?php

namespace Dockent\controllers;

use Dockent\components\config\Config;
use Dockent\components\Controller;
use Phalcon\Http\ResponseInterface;

/**
 * Class IndexController
 * @package Dockent\controllers
 */
class IndexController extends Controller
{
    /**
     * @var Config
     */
    private $config;

    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->config = $this->getDI()->get(Config::class);
    }

    public function indexAction()
    {
        $assetManifest = json_decode(file_get_contents(__DIR__ . '/../../asset-manifest.json'));
        $this->view->setVars([
            'assetManifest' => $assetManifest
        ]);
    }

    /**
     * @return ResponseInterface
     */
    public function applicationConfigAction(): ResponseInterface
    {
        $this->response->setJsonContent([
            'debugMode' => static::$DEBUG_MODE,
            'eventSocket' => $this->config->get('eventSocket')
        ]);

        return $this->response;
    }
}