<?php

namespace Dockent\controllers;

use Dockent\components\Controller;
use Dockent\models\db\NotificationsInterface;
use Phalcon\Http\ResponseInterface;

/**
 * Class NotificationsController
 * @package Dockent\controllers
 */
class NotificationsController extends Controller
{
    /**
     * @var NotificationsInterface
     */
    private $notifications;

    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

        $this->notifications = $this->getDI()->get(NotificationsInterface::class);
    }

    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $requestData = $this->request->getJsonRawBody(true);
        if (!is_array($requestData)) {
            $requestData = [];
        }
        if (!isset($requestData['changeStatus'])) {
            $requestData['changeStatus'] = true;
        }
        $this->response->setJsonContent($this->notifications->getNotifications($requestData['changeStatus']));

        return $this->response;
    }

    /**
     * @return ResponseInterface
     */
    public function deleteAction(): ResponseInterface
    {
        $requestData = $this->request->getJsonRawBody(true);
        $this->response->setJsonContent(['status' => $this->notifications->deleteByIds([$requestData['id']])]);
        return $this->response;
    }

    /**
     * @return ResponseInterface
     */
    public function markAsUnreadAction(): ResponseInterface
    {
        $requestData = $this->request->getJsonRawBody(true);
        $this->notifications->markAsUnread($requestData['id']);
        $this->response->setJsonContent(['status' => 'success']);
        return $this->response;
    }

    /**
     * @return ResponseInterface
     */
    public function unreadCountAction(): ResponseInterface
    {
        $this->response->setJsonContent([
            'count' => $this->notifications->getUnreadCount()
        ]);
        return $this->response;
    }
}