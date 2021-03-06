<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\models\CreateNetwork;
use Exception;
use Http\Client\Exception\HttpException;
use Phalcon\Http\ResponseInterface;

/**
 * Class NetworkController
 * @package Dockent\controllers
 */
class NetworkController extends Controller
{
    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $networks = $this->docker->NetworkResource()->networkList();
        $this->response->setContent((string) $networks);

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
                $this->docker->NetworkResource()->networkDelete($id);
            } catch (Exception $e) {
                /** We don't need to process this exception */
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
        try {
            $this->response->setContent((string) $this->docker->NetworkResource()->networkInspect($id));
        } catch (HttpException $httpException) {
            $this->response->setStatusCode($httpException->getCode());
        }

        return $this->response;
    }

    /**
     * @Method(POST)
     * @return ResponseInterface
     */
    public function createAction(): ResponseInterface
    {
        $model = new CreateNetwork();
        $model->assign($this->request->getJsonRawBody(true));
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