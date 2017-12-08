<?php

namespace Dockent\Tests\mocks;

use Phalcon\Validation;

/**
 * Class FormModel
 * @package Dockent\Tests\mocks
 */
class FormModel extends \Dockent\components\FormModel
{
    /**
     * @var string
     */
    protected $stringWithSetter = '';

    /**
     * @var bool
     */
    protected $boolWithSetter = false;

    /**
     * @var string
     */
    protected $stringWithoutSetter = '';

    /**
     * @var bool
     */
    protected $boolWithoutSetter = false;

    /**
     * @return Validation
     */
    public function getValidator(): Validation
    {
        return $this->validator;
    }

    /**
     * @param bool $boolWithSetter
     */
    public function setBoolWithSetter(bool $boolWithSetter): void
    {
        $this->boolWithSetter = $boolWithSetter;
    }

    /**
     * @param string $stringWithSetter
     */
    public function setStringWithSetter(string $stringWithSetter): void
    {
        $this->stringWithSetter = $stringWithSetter;
    }

    /**
     * @return bool
     */
    public function isBoolWithSetter(): bool
    {
        return $this->boolWithSetter;
    }

    /**
     * @return bool
     */
    public function isBoolWithoutSetter(): bool
    {
        return $this->boolWithoutSetter;
    }

    /**
     * @return string
     */
    public function getStringWithSetter(): string
    {
        return $this->stringWithSetter;
    }

    /**
     * @return string
     */
    public function getStringWithoutSetter(): string
    {
        return $this->stringWithoutSetter;
    }
}