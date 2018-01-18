<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 25.09.17
 * Time: 16:26
 */

namespace Dockent\controllers;

use Dockent\components\BulkAction;
use Dockent\components\Controller;
use Dockent\components\DI as DIFactory;
use Dockent\enums\ContainerState;
use Dockent\enums\DI;
use Dockent\models\CreateContainer;
use Dockent\models\RenameContainer;
use Phalcon\Http\ResponseInterface;
use Phalcon\Queue\Beanstalk;

/**
 * Class ContainerController
 * @package Dockent\controllers
 */
class ContainerController extends Controller
{
    use BulkAction;

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
        $model->assign($this->request->getPost());
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
     * @Bulk
     * @param string $id
     * @return ResponseInterface
     */
    public function startAction(string $id): ResponseInterface
    {
        $this->docker->ContainerResource()->containerStart($id);
        $this->response->setJsonContent([
            'status' => 'success'
        ]);

        return $this->response;
    }

    /**
     * @Bulk
     * @param string $id
     * @return ResponseInterface
     */
    public function stopAction(string $id): ResponseInterface
    {
        /** @var Beanstalk $queue */
        $queue = DIFactory::getDI()->get(DI::QUEUE);
        $queue->put([
            'action' => 'stopContainer',
            'data' => $id
        ]);
        $this->response->setJsonContent([
            'status' => 'success',
            'message' => 'Action sent to queue'
        ]);

        return $this->response;
    }

    /**
     * @Bulk
     * @param string $id
     * @return ResponseInterface
     */
    public function restartAction(string $id): ResponseInterface
    {
        /** @var Beanstalk $queue */
        $queue = DIFactory::getDI()->get(DI::QUEUE);
        $queue->put([
            'action' => 'restartAction',
            'data' => $id
        ]);
        $this->response->setJsonContent([
            'status' => 'success',
            'message' => 'Action sent to queue'
        ]);

        return $this->response;
    }

    /**
     * @Bulk
     * @param string $id
     * @return ResponseInterface
     */
    public function removeAction(string $id): ResponseInterface
    {
        $this->docker->ContainerResource()->containerDelete($id);
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
        $model = json_decode($this->docker->ContainerResource()->containerInspect($id));
        if ($model->State->Status === ContainerState::RUNNING) {
            $top = json_decode($this->docker->ContainerResource()->containerTop($id));
        }
        $this->response->setJsonContent([
            'top' => $top,
            'model' => $model
        ]);

        return $this->response;
    }

    /**
     * @Method(POST)
     * @param string $id
     * @return ResponseInterface
     */
    public function renameAction(string $id): ResponseInterface
    {
        $model = new RenameContainer();
        $model->assign($this->request->getPost());
        if ($model->validate()) {
            $this->docker->ContainerResource()->containerRename($id, ['name' => $model->getName()]);
            $this->response->setJsonContent([
                'status' => 'success'
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