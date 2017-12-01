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
use Phalcon\Queue\Beanstalk;

/**
 * Class ContainerController
 * @package Dockent\controllers
 */
class ContainerController extends Controller
{
    use BulkAction;

    public function indexAction()
    {
        $containers = $this->docker->ContainerResource()->containerList(['all' => true]);
        $this->view->setVars([
            'containers' => json_decode($containers)
        ]);
    }

    public function createAction()
    {
        $model = new CreateContainer();
        if ($this->request->isPost()) {
            $model->assign($this->request->getPost());
            if ($model->validate()) {
                /** @var Beanstalk $queue */
                $queue = DIFactory::getDI()->get(DI::QUEUE);
                $queue->put([
                    'action' => 'createContainer',
                    'data' => $model
                ]);
                $this->response->redirect('index');
            }
        }
        $this->view->setVars([
            'model' => $model
        ]);
    }

    /**
     * @param string $id
     * @Bulk
     */
    public function startAction(string $id)
    {
        $this->docker->ContainerResource()->containerStart($id);
        $this->redirect('/container');
    }

    /**
     * @param string $id
     * @Bulk
     */
    public function stopAction(string $id)
    {
        /** @var Beanstalk $queue */
        $queue = DIFactory::getDI()->get(DI::QUEUE);
        $queue->put([
            'action' => 'stopContainer',
            'data' => $id
        ]);
        $this->redirect('/container');
    }

    /**
     * @param string $id
     * @Bulk
     */
    public function restartAction(string $id)
    {
        /** @var Beanstalk $queue */
        $queue = DIFactory::getDI()->get(DI::QUEUE);
        $queue->put([
            'action' => 'restartAction',
            'data' => $id
        ]);
        $this->redirect('/container');
    }

    /**
     * @param string $id
     * @Bulk
     */
    public function removeAction(string $id)
    {
        $this->docker->ContainerResource()->containerDelete($id);
        $this->redirect('/container');
    }

    /**
     * @param string $id
     */
    public function viewAction(string $id)
    {
        $top = null;
        $model = json_decode($this->docker->ContainerResource()->containerInspect($id));
        if ($model->State->Status === ContainerState::RUNNING) {
            $top = json_decode($this->docker->ContainerResource()->containerTop($id));
        }
        $this->view->setVars([
            'top' => $top,
            'model' => $model
        ]);
    }

    /**
     * @param string $id
     */
    public function renameAction(string $id)
    {
        if ($this->request->isPost()) {
            $this->docker->ContainerResource()->containerRename($id, ['name' => $this->request->getPost('name')]);
            $this->redirect('/container');
        }
        $this->view->setVars([
            'model' => json_decode($this->docker->ContainerResource()->containerInspect($id))
        ]);
    }
}