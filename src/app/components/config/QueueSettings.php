<?php

namespace Dockent\components\config;

/**
 * Class QueueSettings
 * @package Dockent\components\config
 */
class QueueSettings implements Configurable
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * QueueSettings constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (isset($data['host'])) {
            $this->setHost($data['host']);
        }
        if (isset($data['port'])) {
            $this->setPort($data['port']);
        }
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = strip_tags($host);
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return array
     */
    public function pasteToConfig(): array
    {
        return [
            'queue' => [
                'host' => $this->host,
                'port' => $this->port
            ]
        ];
    }

    /**
     * @return bool
     */
    public function afterSave(): bool
    {
        return true;
    }
}