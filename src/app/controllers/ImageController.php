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
use Dockent\models\BuildImageByDockerfileBody;
use Dockent\models\BuildImageByDockerfilePath;

/**
 * Class ImageController
 * @package Dockent\controllers
 */
class ImageController extends Controller
{
    use BulkAction;

    public function indexAction()
    {
        $images = $this->docker->ImageResource()->imageList();
        $this->view->setVars([
            'images' => json_decode($images)
        ]);
    }

    /**
     * @param string $id
     * @Bulk
     */
    public function removeAction(string $id)
    {
        try {
            $this->docker->ImageResource()->imageDelete($id);
        } catch (\Exception $e) {
        }
        $this->redirect('/image');
    }

    /**
     * @param string $id
     * @Bulk
     */
    public function forceRemoveAction(string $id)
    {
        $this->docker->ImageResource()->imageDelete($id, ['force' => true]);
        $this->redirect('/image');
    }

    public function buildAction()
    {
        $this->view->setVars([
            'dockerfilePathModel' => new BuildImageByDockerfilePath(),
            'dockerfileBodyModel' => new BuildImageByDockerfileBody()
        ]);
    }
}