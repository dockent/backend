<?php

namespace Dockent\models;

use Dockent\components\config\Config;
use Dockent\components\config\QueueSettings;
use Dockent\components\FormModel;
use JsonSerializable;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class Settings
 * @package Dockent\models
 */
class Settings extends FormModel implements JsonSerializable
{
    /**
     * @var string
     */
    protected $beanstalkHost;

    /**
     * @var int
     */
    protected $beanstalkPort;

    /**
     * @var Config
     */
    private $config;

    /**
     * Settings constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct();
        $this->config = $config;
        $this->setBeanstalkHost($this->config->path('queue.host'));
        $this->setBeanstalkPort($this->config->path('queue.port'));
    }

    public function rules()
    {
        $this->validator->add(['beanstalkHost', 'beanstalkPort'], new PresenceOf());
        $this->validator->add(['beanstalkPort'], new Numericality());
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if ($this->validate()) {
            $this->config->add(new QueueSettings([
                'host' => $this->getBeanstalkHost(),
                'port' => $this->getBeanstalkPort()
            ]));
            $this->config->save();

            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getBeanstalkHost(): string
    {
        return $this->beanstalkHost;
    }

    /**
     * @param string $beanstalkHost
     */
    public function setBeanstalkHost(string $beanstalkHost)
    {
        $this->beanstalkHost = $beanstalkHost;
    }

    /**
     * @return int
     */
    public function getBeanstalkPort()
    {
        return $this->beanstalkPort;
    }

    /**
     * @param int $beanstalkPort
     */
    public function setBeanstalkPort($beanstalkPort)
    {
        $this->beanstalkPort = $beanstalkPort;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'beanstalkHost' => $this->getBeanstalkHost(),
            'beanstalkPort' => $this->getBeanstalkPort()
        ];
    }
}