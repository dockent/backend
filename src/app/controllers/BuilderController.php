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
use Dockent\enums\DI;
use Phalcon\Queue\Beanstalk;

/**
 * Class BuilderController
 * @package Dockent\controllers
 */
class BuilderController extends Controller
{
    public function buildByDockerfilePathAction()
    {
//        if ($this->request->isPost()) {
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'buildImageByDockerfilePath',
                'data' => '/tmp/Dockerfile'
//                'data' => $this->request->getPost('path_to_dockerfile')
            ]);
            $this->redirect('/image');
//        }
    }

    public function buildByDockerfileBodyAction()
    {
        if ($this->request->isPost()) {
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'buildByDockerfileBodyAction',
                'data' => $this->request->getPost('dockerfile_body')
            ]);
            $this->redirect('/image');
        }
    }

    public function builderAction()
    {
        if ($this->request->isPost()) {
            /** @var Beanstalk $queue */
            $queue = DIFactory::getDI()->get(DI::QUEUE);
            $queue->put([
                'action' => 'buildByContext',
                'data' => $this->request->getPost()
            ]);
            $this->redirect('/image');
        }
    }
}