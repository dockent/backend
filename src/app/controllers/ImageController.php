<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 10:42
 */

namespace Dockent\controllers;

use Dockent\components\BulkAction;
use Dockent\components\Controller;

/**
 * Class ImageController
 * @package Dockent\controllers
 */
class ImageController extends Controller
{
    use BulkAction;

    public function indexAction()
    {
        $images = $this->docker->getImageManager()->findAll();
        $this->view->setVars([
            'images' => $images
        ]);
    }

    /**
     * @param string $id
     * @Bulk
     */
    public function removeAction(string $id)
    {
        $this->docker->getImageManager()->remove($id);
        $this->redirect('/image');
    }

    public function buildAction()
    {
        /** Render default view */
    }
}