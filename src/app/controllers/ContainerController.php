<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\enums\ContainerState;
use Dockent\models\CreateContainer;
use Dockent\queue\CreateContainer as CreateContainerQueue;
use Dockent\queue\RestartContainer;
use Dockent\queue\StopContainer;
use Http\Client\Exception\HttpException;
use Phalcon\Http\ResponseInterface;
use Phalcon\Queue\Beanstalk;

/**
 * Class ContainerController
 * @package Dockent\controllers
 */
class ContainerController extends Controller
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
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $containers = $this->docker->ContainerResource()->containerList(['all' => true]);
        $this->response->setContent((string) $containers);

        return $this->response;
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function createAction(): ResponseInterface
    {
        $model = new CreateContainer();
        $model->assign($this->request->getJsonRawBody(true));
        if ($model->validate()) {
            $this->beanstalk->put([
                'action' => CreateContainerQueue::class,
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

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function startAction(): ResponseInterface
    {
        $data = $this->request->getJsonRawBody(true);
        foreach ($data['id'] as $id) {
            $this->docker->ContainerResource()->containerStart($id);
        }
        $this->response->setJsonContent([
            'status' => 'success'
        ]);

        return $this->response;
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function stopAction(): ResponseInterface
    {
        $data = $this->request->getJsonRawBody(true);
        foreach ($data['id'] as $id) {
            $this->beanstalk->put([
                'action' => StopContainer::class,
                'data' => $id
            ]);
        }
        $this->response->setJsonContent([
            'status' => 'success',
            'message' => 'Action sent to queue'
        ]);

        return $this->response;
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function restartAction(): ResponseInterface
    {
        $data = $this->request->getJsonRawBody(true);
        foreach ($data['id'] as $id) {
            $this->beanstalk->put([
                'action' => RestartContainer::class,
                'data' => $id
            ]);
        }
        $this->response->setJsonContent([
            'status' => 'success',
            'message' => 'Action sent to queue'
        ]);

        return $this->response;
    }

    /**
     * @Method(DELETE)
     * @return ResponseInterface
     */
    public function removeAction(): ResponseInterface
    {
        $data = $this->request->getJsonRawBody(true);
        foreach ($data['id'] as $id) {
            $this->docker->ContainerResource()->containerDelete($id);
        }
        $this->response->setJsonContent([
            'status' => 'success'
        ]);

        return $this->response;
    }

    /**
     * @param string $id
     * @return ResponseInterface
     */
    public function viewAction(string $id): ResponseInterface
    {
        $top = null;
        try {
            $model = json_decode((string) $this->docker->ContainerResource()->containerInspect($id));
            if ($model->State->Status === ContainerState::RUNNING) {
                $top = json_decode((string) $this->docker->ContainerResource()->containerTop($id));
            }
            $this->response->setJsonContent([
                'top' => $top,
                'model' => $model
            ]);
        } catch (HttpException $httpException) {
            $this->response->setStatusCode($httpException->getCode());
        }

        return $this->response;
    }
}