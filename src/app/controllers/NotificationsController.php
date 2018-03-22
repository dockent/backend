<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\models\db\Notifications;
use Phalcon\Http\ResponseInterface;

/**
 * Class NotificationsController
 * @package Dockent\controllers
 */
class NotificationsController extends Controller
{
    /**
     * @Method(GET, DELETE)
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        if ($this->request->isGet()) {
            $notifications = Notifications::find();
            $this->response->setJsonContent($notifications);
        }
        if ($this->request->isDelete()) {
            $items = $this->request->getJsonRawBody(true);
            $this->response->setJsonContent(['status' => Notifications::deleteByIds($items['id'])]);
        }

        return $this->response;
    }
}