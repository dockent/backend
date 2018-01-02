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
use Phalcon\Http\ResponseInterface;

/**
 * Class ImageController
 * @package Dockent\controllers
 */
class ImageController extends Controller
{
    use BulkAction;

    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $images = $this->docker->ImageResource()->imageList();
        $this->response->setContent($images);

        return $this->response;
    }

    /**
     * @Bulk
     * @param string $id
     * @return ResponseInterface
     */
    public function removeAction(string $id): ResponseInterface
    {
        try {
            $this->docker->ImageResource()->imageDelete($id);
        } catch (\Exception $e) {
        }
        $this->response->setJsonContent(['status' => 'success']);

        return $this->response;
    }

    /**
     * @Bulk
     * @param string $id
     * @return ResponseInterface
     */
    public function forceRemoveAction(string $id): ResponseInterface
    {
        $this->docker->ImageResource()->imageDelete($id, ['force' => true]);
        $this->response->setJsonContent(['status' => 'success']);

        return $this->response;
    }
}