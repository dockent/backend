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
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        /** @var INotifications $notifications */
        $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
        $requestData = $this->request->getJsonRawBody(true);
        if (!is_array($requestData)) {
            $requestData = [];
        }
        if (!array_key_exists('changeStatus', $requestData)) {
            $requestData['changeStatus'] = true;
        }
        $this->response->setJsonContent($notifications->getNotifications($requestData['changeStatus']));

        return $this->response;
    }

    /**
     * @return ResponseInterface
     */
    public function deleteAction(): ResponseInterface
    {
        /** @var INotifications $notifications */
        $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
        $requestData = $this->request->getJsonRawBody(true);
        $this->response->setJsonContent(['status' => $notifications->deleteByIds([$requestData['id']])]);
        return $this->response;
    }

    /**
     * @return ResponseInterface
     */
    public function markAsUnreadAction(): ResponseInterface
    {
        $requestData = $this->request->getJsonRawBody(true);
        /** @var INotifications $notifications */
        $notifications = DIFactory::getDI()->get(DI::NOTIFICATIONS);
        $notifications->markAsUnread($requestData['id']);
        $this->response->setJsonContent(['status' => 'success']);
        return $this->response;
    }
}