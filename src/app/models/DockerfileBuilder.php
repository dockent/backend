<?php

namespace Dockent\models;

use Dockent\components\FormModel;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class DockerfileBuilder
 * @package Dockent\models
 */
class DockerfileBuilder extends FormModel
{
    /**
     * @var string
     */
    protected $from = '';

    /**
     * @var string
     */
    protected $run = '';

    /**
     * @var string
     */
    protected $cmd = '';

    /**
     * @var string
     */
    protected $expose = '';

    /**
     * @var string
     */
    protected $env = '';

    /**
     * @var string
     */
    protected $add = '';

    /**
     * @var string
     */
    protected $copy = '';

    /**
     * @var string
     */
    protected $volume = '';

    /**
     * @var string
     */
    protected $workdir = '';

    public function rules()
    {
        $this->validator->add(['from'], new PresenceOf());
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getRun(): string
    {
        return $this->run;
    }

    /**
     * @param string $run
     */
    public function setRun(string $run): void
    {
        $this->run = $run;
    }

    /**
     * @return string
     */
    public function getCmd(): string
    {
        return $this->cmd;
    }

    /**
     * @param string $cmd
     */
    public function setCmd(string $cmd): void
    {
        $this->cmd = $cmd;
    }

    /**
     * @return string
     */
    public function getExpose(): string
    {
        return $this->expose;
    }

    /**
     * @param string $expose
     */
    public function setExpose(string $expose): void
    {
        $this->expose = $expose;
    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }

    /**
     * @param string $env
     */
    public function setEnv(string $env): void
    {
        $this->env = $env;
    }

    /**
     * @return string
     */
    public function getAdd(): string
    {
        return $this->add;
    }

    /**
     * @param string $add
     */
    public function setAdd(string $add): void
    {
        $this->add = $add;
    }

    /**
     * @return string
     */
    public function getCopy(): string
    {
        return $this->copy;
    }

    /**
     * @param string $copy
     */
    public function setCopy(string $copy): void
    {
        $this->copy = $copy;
    }

    /**
     * @return string
     */
    public function getVolume(): string
    {
        return $this->volume;
    }

    /**
     * @param string $volume
     */
    public function setVolume(string $volume): void
    {
        $this->volume = $volume;
    }

    /**
     * @return string
     */
    public function getWorkdir(): string
    {
        return $this->workdir;
    }

    /**
     * @param string $workdir
     */
    public function setWorkdir(string $workdir): void
    {
        $this->workdir = $workdir;
    }
}