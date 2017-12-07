<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 07.12.2017
 * Time: 19:18
 */

namespace Dockent\components;

use Dockent\components\DI as DIFactory;
use Dockent\enums\DI;
use Phalcon\Http\RequestInterface;

/**
 * Class SearchRequest
 * @package Dockent\components
 */
class SearchRequest
{
    /**
     * @param array $params
     * @return array
     */
    public static function make(array $params = []): array
    {
        /** @var RequestInterface $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $search = [];
        $search['filters'] = json_encode($request->getPost('filters', null, []));

        return array_merge($search, $params);
    }
}