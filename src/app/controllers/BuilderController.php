<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 28.09.2017
 * Time: 19:09
 */

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\components\DI as DIFactory;
use Dockent\components\HTTPMethods;
use Dockent\enums\DI;
use Dockent\models\BuildImageByDockerfileBody;
use Dockent\models\BuildImageByDockerfilePath;
use Dockent\models\DockerfileBuilder;
use Phalcon\Http\ResponseInterface;
use Phalcon\Queue\Beanstalk;

/**
 * Class BuilderController
 * @package Dockent\controllers
 */
class BuilderController extends Controller
{
    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function buildByDockerfilePathAction(): ResponseInterface
    {
        $model = new BuildImageByDockerfilePath();
        $model->assign($this->request->getJsonRawBody(true));
        if ($model->validate()) {
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'buildImageByDockerfilePath',
                'data' => $model->getDockerfilePath()
            ]);
            $this->response->setJsonContent([
                'status' => 'success',
                'message' => 'Action sent to queue'
            ]);
        } else {
            $this->response->setJsonContent([
                'status' => 'error',
                'errors' => $model->getErrors()
            ]);
        }

        return $this->response;
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function buildByDockerfileBodyAction(): ResponseInterface
    {
        $model = new BuildImageByDockerfileBody();
        $model->assign($this->request->getJsonRawBody(true));
        if ($model->validate()) {
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'buildByDockerfileBodyAction',
                'data' => $model->getDockerfileBody()
            ]);
            $this->response->setJsonContent([
                'status' => 'success',
                'message' => 'Action sent to queue'
            ]);
        } else {
            $this->response->setJsonContent([
                'status' => 'error',
                'errors' => $model->getErrors()
            ]);
        }

        return $this->response;
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $model = new DockerfileBuilder();
        $model->assign($this->request->getJsonRawBody(true));
        if ($model->validate()) {
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'buildByContext',
                'data' => $model
            ]);
            $this->response->setJsonContent([
                'status' => 'success',
                'message' => 'Action sent to queue'
            ]);
        } else {
            $this->response->setJsonContent([
                'status' => 'error',
                'errors' => $model->getErrors()
            ]);
        }

        return $this->response;
    }
}