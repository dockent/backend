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
    private $currentMethod = 'GET';

    /**
     * @var null|string
     */
    private $rawBody = null;

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->currentMethod === 'GET';
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->currentMethod === 'POST';
    }

    /**
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->currentMethod === 'PUT';
    }

    /**
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->currentMethod === 'DELETE';
    }

    public function setGet()
    {
        $this->currentMethod = 'GET';
    }

    public function setPost()
    {
        $this->currentMethod = 'POST';
    }

    public function setPut()
    {
        $this->currentMethod = 'PUT';
    }

    public function setDelete()
    {
        $this->currentMethod = 'DELETE';
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

    /**
     * @param string $body
     */
    public function setRawBody(string $body)
    {
        $this->rawBody = $body;
    }

    /**
     * @return null|string
     */
    public function getRawBody()
    {
        return $this->rawBody;
    }

    /**
     * @param bool $associative
     * @return array|\stdClass
     */
    public function getJsonRawBody(bool $associative = false)
    {
        return json_decode($this->rawBody, $associative);
    }
}