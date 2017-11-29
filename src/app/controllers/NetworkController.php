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

/**
 * Class NetworkController
 * @package Dockent\controllers
 */
class NetworkController extends Controller
{
    use BulkAction;

    public function indexAction()
    {
        $networks = $this->docker->NetworkResource()->networkList();
        $this->view->setVars([
            'networks' => json_decode($networks)
        ]);
    }

    /**
     * @Bulk
     * @param string $id
     */
    public function removeAction(string $id)
    {
        try {
            $this->docker->NetworkResource()->networkDelete($id);
        } catch (\Exception $e) {
        }
        $this->redirect('/network');
    }

    /**
     * @param string $id
     */
    public function viewAction(string $id)
    {
        $this->view->setVars([
            'model' => json_decode($this->docker->NetworkResource()->networkInspect($id))
        ]);
    }

    public function createAction()
    {
        if ($this->request->isPost()) {
            $this->docker->NetworkResource()->networkCreate($this->request->getPost());
            $this->redirect('/network');
        }
    }
}