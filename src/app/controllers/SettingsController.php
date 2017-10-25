<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 24.10.17
 * Time: 14:46
 */

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\components\DI as DIFactory;
use Dockent\components\QueueSettings;
use Dockent\enums\DI;
use Dockent\components\Config;

/**
 * Class SettingsController
 * @package Dockent\controllers
 */
class SettingsController extends Controller
{
    public function indexAction()
    {
        /** @var Config $config */
        $config = DIFactory::getDI()->get(DI::CONFIG);
        if ($this->request->isPost()) {
            $config->add(new QueueSettings($this->request->getPost('queue')));
            $config->save();

            $this->redirect('/');
        }

        $this->view->setVars([
            'config' => $config
        ]);
    }
}