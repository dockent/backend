<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\enums\DI;
use Dockent\models\db\interfaces\INotifications;
use Phalcon\Http\ResponseInterface;
use Dockent\components\DI as DIFactory;

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
        /** @var INotifications $notifications */
        $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
        if ($this->request->isGet()) {
            $this->response->setJsonContent($notifications->getNotifications());
        }
        if ($this->request->isDelete()) {
            $items = $this->request->getJsonRawBody(true);
            $this->response->setJsonContent(['status' => $notifications->deleteByIds($items['id'])]);
        }

        return $this->response;
    }
}