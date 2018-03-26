<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\enums\DI;
use Dockent\models\db\interfaces\INotifications;
use Dockent\models\db\Notifications;
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
        if ($this->request->isGet()) {
            $notifications = Notifications::find();
            $this->response->setJsonContent($notifications);
        }
        if ($this->request->isDelete()) {
            $items = $this->request->getJsonRawBody(true);
            /** @var INotifications $notifications */
            $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
            $this->response->setJsonContent(['status' => $notifications->deleteByIds($items['id'])]);
        }

        return $this->response;
    }
}