<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 07.12.17
 * Time: 15:55
 */

namespace Dockent\models;

use Dockent\components\config\Config;
use Dockent\components\config\QueueSettings;
use Dockent\components\FormModel;
use Dockent\enums\DI;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Dockent\components\DI as DIFactory;

/**
 * Class Settings
 * @package Dockent\models
 */
class Settings extends FormModel
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
     */
    public function __construct()
    {
        parent::__construct();
        $this->config = DIFactory::getDI()->get(DI::CONFIG);
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
    public function setBeanstalkHost(string $beanstalkHost): void
    {
        $this->beanstalkHost = $beanstalkHost;
    }

    /**
     * @return int
     */
    public function getBeanstalkPort(): int
    {
        return $this->beanstalkPort;
    }

    /**
     * @param int $beanstalkPort
     */
    public function setBeanstalkPort(int $beanstalkPort): void
    {
        $this->beanstalkPort = $beanstalkPort;
    }
}