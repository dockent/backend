<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 25.09.17
 * Time: 16:26
 */

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\components\Docker;
use Docker\API\Model\ContainerConfig;

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

    /**
     * @todo: Pulling the image with creating the container should be in Queue
     */
    public function createAction()
    {
        if ($this->request->isPost()) {
            $containerConfig = new ContainerConfig();
            Docker::pull($this->request->getPost('image'));
            $containerConfig->setImage($this->request->getPost('image'));
            $containerConfig->setCmd($this->request->getPost('cmd'));
            $parameters = [];
            $name = $this->request->getPost('name');
            if ($name) {
                $parameters['name'] = $name;
            }
            $containerCreateResult = $this->docker->getContainerManager()->create($containerConfig, $parameters);
            if ($this->request->getPost('start')) {
                $this->docker->getContainerManager()->start($containerCreateResult->getId());
            }
            $this->response->redirect('index');
        }
    }
}