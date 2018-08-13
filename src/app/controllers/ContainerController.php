<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 25.09.17
 * Time: 16:26
 */

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\components\DI as DIFactory;
use Dockent\enums\ContainerState;
use Dockent\enums\DI;
use Dockent\models\CreateContainer;
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
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $containers = $this->docker->ContainerResource()->containerList(['all' => true]);
        $this->response->setContent($containers);

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
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'createContainer',
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
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'stopContainer',
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
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'restartAction',
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
            $model = json_decode($this->docker->ContainerResource()->containerInspect($id));
            if ($model->State->Status === ContainerState::RUNNING) {
                $top = json_decode($this->docker->ContainerResource()->containerTop($id));
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