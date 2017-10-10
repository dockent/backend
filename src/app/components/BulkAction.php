<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 10.10.2017
 * Time: 09:27
 */

namespace Dockent\components;

use Dockent\enums\DI;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Http\Request\Exception;
use Dockent\components\DI as DIFactory;

/**
 * Trait BulkAction
 * @package Dockent\components
 */
trait BulkAction
{
    /**
     * @param string $action
     * @throws Exception
     */
    public function bulkAction(string $action)
    {
        /** @var Controller $this */
        $id = $this->request->getPost('id');
        if ($id !== null & !empty($id)) {
            $actionName = $action . 'Action';
            if (method_exists($this, $actionName)) {
                /** @var AdapterInterface $annotationsAdapter */
                $annotationsAdapter = DIFactory::getDI()->get(DI::ANNOTATIONS);
                if ($annotationsAdapter->getMethod(static::class, $actionName)->has('Bulk')) {
                    foreach ($id as $item) {
                        $this->$actionName($item);
                    }
                } else {
                    throw new Exception('Action doesn\'t support Bulk', 400);
                }
            } else {
                throw new Exception('Action not found', 404);
            }
        }
    }
}