<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 24.10.17
 * Time: 14:46
 */

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\models\Settings;

/**
 * Class SettingsController
 * @package Dockent\controllers
 */
class SettingsController extends Controller
{
    public function indexAction()
    {
        $model = new Settings();
        if ($this->request->isPost()) {
            $model->assign($this->request->getPost());
            if ($model->save()) {
                $this->redirect('/');
            }
        }

        $this->view->setVars([
            'config' => $model
        ]);
    }
}