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
use Dockent\models\BuildImageByDockerfileBody;
use Dockent\models\BuildImageByDockerfilePath;
use Dockent\models\DockerfileBuilder;
use Phalcon\Queue\Beanstalk;

/**
 * Class BuilderController
 * @package Dockent\controllers
 */
class BuilderController extends Controller
{
    public function buildByDockerfilePathAction()
    {
        if ($this->request->isPost()) {
            $model = new BuildImageByDockerfilePath();
            $model->assign($this->request->getPost());
            if ($model->validate()) {
                /** @var Beanstalk $queue */
                $queue = DIFactory::getDI()->get(DI::QUEUE);
                $queue->put([
                    'action' => 'buildImageByDockerfilePath',
                    'data' => $model->getDockerfilePath()
                ]);
            }
            $this->redirect('/image');
        }
    }

    public function buildByDockerfileBodyAction()
    {
        if ($this->request->isPost()) {
            $model = new BuildImageByDockerfileBody();
            $model->assign($this->request->getPost());
            if ($model->validate()) {
                /** @var Beanstalk $queue */
                $queue = DIFactory::getDI()->get(DI::QUEUE);
                $queue->put([
                    'action' => 'buildByDockerfileBodyAction',
                    'data' => $model->getDockerfileBody()
                ]);
            }
            $this->redirect('/image');
        }
    }

    public function indexAction()
    {
        $model = new DockerfileBuilder();
        if ($this->request->isPost()) {
            $model->assign($this->request->getPost());
            if ($model->validate()) {
                /** @var Beanstalk $queue */
                $queue = DIFactory::getDI()->get(DI::QUEUE);
                $queue->put([
                    'action' => 'buildByContext',
                    'data' => $this->request->getPost()
                ]);
                $this->redirect('/image');
            }
        }
        $this->view->setVars([
            'model' => $model
        ]);
    }
}