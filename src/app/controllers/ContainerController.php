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
use Dockent\enums\DI;
use Phalcon\Queue\Beanstalk;

/**
 * Class ContainerController
 * @package Dockent\controllers
 */
class ContainerController extends Controller
{
    public function indexAction()
    {
        $containers = $this->docker->getContainerManager()->findAll(['all' => true]);
        $this->view->setVars([
            'containers' => $containers
        ]);
    }

    public function createAction()
    {
        if ($this->request->isPost()) {
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'createContainer',
                'data' => $this->request->getPost()
            ]);
            $this->response->redirect('index');
        }
    }

    /**
     * @param string $id
     */
    public function startAction(string $id)
    {
        $this->docker->getContainerManager()->start($id);
        $this->redirect('/container');
    }

    /**
     * @param string $id
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
     */
    public function restartAction(string $id)
    {
        $this->docker->getContainerManager()->restart($id);
        $this->redirect('/container');
    }

    /**
     * @param string $id
     */
    public function removeAction(string $id)
    {
        $this->docker->getContainerManager()->remove($id);
        $this->redirect('/container');
    }
}