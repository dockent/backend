<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 10:42
 */

namespace Dockent\controllers;

use Dockent\components\Controller;

/**
 * Class ImageController
 * @package Dockent\controllers
 */
class ImageController extends Controller
{
    public function indexAction()
    {
        $images = $this->docker->getImageManager()->findAll();
        $this->view->setVars([
            'images' => $images
        ]);
    }
}