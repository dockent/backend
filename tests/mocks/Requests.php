<?php

namespace Dockent\Tests\mocks;

/**
 * Class Requests
 * @package Dockent\Tests\mocks
 */
class Requests
{
    /**
     * @var string
     */
    static $currentMethod = 'GET';

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return static::$currentMethod === 'GET';
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return static::$currentMethod === 'POST';
    }

    /**
     * @return bool
     */
    public function isPut(): bool
    {
        return static::$currentMethod === 'PUT';
    }

    /**
     * @return bool
     */
    public function isDelete(): bool
    {
        return static::$currentMethod === 'DELETE';
    }

    public function setGet()
    {
        static::$currentMethod = 'GET';
    }

    public function setPost()
    {
        static::$currentMethod = 'POST';
    }

    public function setPut()
    {
        static::$currentMethod = 'PUT';
    }

    public function setDelete()
    {
        static::$currentMethod = 'DELETE';
    }

    /**
     * @param null $var
     * @return mixed
     */
    public function getPost($var = null)
    {
        if ($var === null) {
            return $_POST;
        }
        return $_POST[$var];
    }
}