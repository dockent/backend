<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 10:42
 */

namespace Dockent\controllers;

use Dockent\components\Controller;
use Phalcon\Http\ResponseInterface;

/**
 * Class ImageController
 * @package Dockent\controllers
 */
class ImageController extends Controller
{
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
     * @Method(DELETE)
     * @return ResponseInterface
     */
    public function removeAction(): ResponseInterface
    {
        $data = $this->request->getJsonRawBody(true);
        foreach ($data['id'] as $id) {
            try {
                $this->docker->ImageResource()->imageDelete($id);
            } catch (\Exception $e) {
            }
        }
        $this->response->setJsonContent(['status' => 'success']);

        return $this->response;
    }

    /**
     * @Method(DELETE)
     * @return ResponseInterface
     */
    public function forceRemoveAction(): ResponseInterface
    {
        $data = $this->request->getJsonRawBody(true);
        foreach ($data['id'] as $id) {
            $this->docker->ImageResource()->imageDelete($id, ['force' => true]);
        }
        $this->response->setJsonContent(['status' => 'success']);

        return $this->response;
    }
}