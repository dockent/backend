<?php

namespace Dockent\models;

use Dockent\components\FormModel;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class CreateNetwork
 * @package Dockent\models
 */
class CreateNetwork extends FormModel
{
    /**
     * @var string
     */
    protected $Name = '';

    /**
     * @var string
     */
    protected $Driver = '';

    /**
     * @var bool
     */
    protected $CheckDuplicate = false;

    /**
     * @var bool
     */
    protected $Internal = false;

    /**
     * @var bool
     */
    protected $Attachable = false;

    /**
     * @var bool
     */
    protected $Ingress = false;

    /**
     * @var bool
     */
    protected $EnableIPv6 = false;

    public function rules()
    {
        $this->validator->add('Name', new PresenceOf());
    }

    /**
     * @return array
     */
    public function getAttributesAsArray(): array
    {
        return [
            'Name' => $this->getName(),
            'Driver' => $this->getDriver(),
            'CheckDuplicate' => $this->isCheckDuplicate(),
            'Internal' => $this->isInternal(),
            'Attachable' => $this->isAttachable(),
            'Ingress' => $this->isIngress(),
            'EnableIPv6' => $this->isEnableIPv6()
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     */
    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getDriver(): string
    {
        return $this->Driver;
    }

    /**
     * @param string $Driver
     */
    public function setDriver(string $Driver): void
    {
        $this->Driver = $Driver;
    }

    /**
     * @return bool
     */
    public function isCheckDuplicate(): bool
    {
        return $this->CheckDuplicate;
    }

    /**
     * @param bool $CheckDuplicate
     */
    public function setCheckDuplicate(bool $CheckDuplicate): void
    {
        $this->CheckDuplicate = $CheckDuplicate;
    }

    /**
     * @return bool
     */
    public function isInternal(): bool
    {
        return $this->Internal;
    }

    /**
     * @param bool $Internal
     */
    public function setInternal(bool $Internal): void
    {
        $this->Internal = $Internal;
    }

    /**
     * @return bool
     */
    public function isAttachable(): bool
    {
        return $this->Attachable;
    }

    /**
     * @param bool $Attachable
     */
    public function setAttachable(bool $Attachable): void
    {
        $this->Attachable = $Attachable;
    }

    /**
     * @return bool
     */
    public function isIngress(): bool
    {
        return $this->Ingress;
    }

    /**
     * @param bool $Ingress
     */
    public function setIngress(bool $Ingress): void
    {
        $this->Ingress = $Ingress;
    }

    /**
     * @return bool
     */
    public function isEnableIPv6(): bool
    {
        return $this->EnableIPv6;
    }


    /**
     * @param bool $EnableIPv6
     */
    public function setEnableIPv6(bool $EnableIPv6): void
    {
        $this->EnableIPv6 = $EnableIPv6;
    }
}