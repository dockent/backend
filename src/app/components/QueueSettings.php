<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 24.10.17
 * Time: 15:51
 */

namespace Dockent\components;

/**
 * Class QueueSettings
 * @package Dockent\components
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
        if (array_key_exists('host', $data)) {
            $this->setHost($data['host']);
        }
        if (array_key_exists('port', $data)) {
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
    public function setHost(string $host)
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
    public function setPort(int $port)
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