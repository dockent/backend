<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\models\BuildImageByDockerfileBody;
use Dockent\models\BuildImageByDockerfilePath;
use Dockent\models\DockerfileBuilder;
use Dockent\queue\BuildByContext;
use Dockent\queue\BuildByDockerfileBody;
use Dockent\queue\BuildImageByDockerfilePath as BuildImageByDockerfilePathQueue;
use Phalcon\Http\ResponseInterface;
use Phalcon\Queue\Beanstalk;

/**
 * Class BuilderController
 * @package Dockent\controllers
 */
class BuilderController extends Controller
{
    /**
     * @var Beanstalk
     */
    private $beanstalk;

    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->beanstalk = $this->getDI()->getShared(Beanstalk::class);
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function buildByDockerfilePathAction(): ResponseInterface
    {
        $model = new BuildImageByDockerfilePath();
        $model->assign($this->request->getJsonRawBody(true));
        if ($model->validate()) {
            $this->beanstalk->put([
                'action' => BuildImageByDockerfilePathQueue::class,
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
            $this->beanstalk->put([
                'action' => BuildByDockerfileBody::class,
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
            $this->beanstalk->put([
                'action' => BuildByContext::class,
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