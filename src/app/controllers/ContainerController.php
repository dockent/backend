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
}