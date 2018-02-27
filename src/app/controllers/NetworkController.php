<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 28.11.17
 * Time: 13:42
 */

namespace Dockent\controllers;

use Dockent\components\BulkAction;
use Dockent\components\Controller;
use Dockent\models\CreateNetwork;
use Phalcon\Http\ResponseInterface;

/**
 * Class NetworkController
 * @package Dockent\controllers
 */
class NetworkController extends Controller
{
    use BulkAction;

    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $networks = $this->docker->NetworkResource()->networkList();
        $this->response->setContent($networks);

        return $this->response;
    }

    /**
     * @return ResponseInterface
     */
    public function removeAction(): ResponseInterface
    {
        $data = $this->request->getJsonRawBody(true);
        foreach ($data['id'] as $id) {
            try {
                $this->docker->NetworkResource()->networkDelete($id);
            } catch (\Exception $e) {
            }
        }
        $this->response->setJsonContent(['status' => 'success']);

        return $this->response;
    }

    /**
     * @param string $id
     * @return ResponseInterface
     */
    public function viewAction(string $id): ResponseInterface
    {
        $this->response->setContent($this->docker->NetworkResource()->networkInspect($id));

        return $this->response;
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function createAction(): ResponseInterface
    {
        $model = new CreateNetwork();
        $model->assign($this->request->getPost());
        if ($model->validate()) {
            $this->docker->NetworkResource()->networkCreate($model->getAttributesAsArray());
            $this->response->setJsonContent([
                'status' => 'success'
            ]);
        } else {
            $this->response->setJsonContent([
                'status' => 'error',
                'errors' => $model->getErrors()
            ]);
        }

        return $this->response;
    }
}