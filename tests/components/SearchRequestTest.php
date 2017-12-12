<?php

namespace Dockent\Tests\components;

use Dockent\components\DI as DIFactory;
use Dockent\components\SearchRequest;
use Dockent\enums\DI;
use Phalcon\Http\RequestInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class SearchRequestTest
 * @package Dockent\Tests\components
 */
class SearchRequestTest extends TestCase
{
    public function testMake()
    {
        $result = SearchRequest::make();
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('filters', $result);
        $this->assertEmpty($result['filters']);
    }

    public function testMakeWithParams()
    {
        $result = SearchRequest::make([
            'magicParam' => 'magicResult'
        ]);
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('filters', $result);
        $this->assertEmpty($result['filters']);
        $this->assertArrayHasKey('magicParam', $result);
    }

    public function testMakeWithPostData()
    {
        $_POST['filters'] = [
            'magicParam' => 'magicResult'
        ];
        $result = SearchRequest::make();
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('filters', $result);
        $this->assertNotEmpty($result['filters']);
        $this->assertArrayHasKey('magicParam', $result['filters']);
        $this->assertEquals('magicResult', $result['filters']['magicParam']);
    }
}