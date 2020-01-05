<?php

namespace Dockent\models;

use Dockent\components\FormModel;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class CreateContainer
 * @package Dockent\models
 */
class CreateContainer extends FormModel
{
    /**
     * @var string
     */
    protected $Image = '';

    /**
     * @var string
     */
    protected $Cmd = '';

    /**
     * @var string
     */
    protected $Name = '';

    /**
     * @var bool
     */
    protected $Start = false;

    public function rules()
    {
        $this->validator->add('Image', new PresenceOf());
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->Image;
    }

    /**
     * @param string $Image
     */
    public function setImage(string $Image): void
    {
        $this->Image = $Image;
    }

    /**
     * @return string
     */
    public function getCmd(): string
    {
        return $this->Cmd;
    }

    /**
     * @param string $Cmd
     */
    public function setCmd(string $Cmd): void
    {
        $this->Cmd = $Cmd;
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
     * @return bool
     */
    public function isStart(): bool
    {
        return $this->Start;
    }

    /**
     * @param bool $Start
     */
    public function setStart(bool $Start): void
    {
        $this->Start = $Start;
    }
}